<?php namespace App\Http\Controllers;

use Auth;
use Mail;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Carbon\Carbon;

use App\User;
use App\Address;
use App\City;
use App\Province;
use App\Tile;
use App\HeaderCategory;
use App\DetailCategory;
use App\Brand;
use App\Installation;
use App\HeaderFee;
use App\AddOn;
use App\HeaderTag;
use App\DetailTag;
use App\HeaderOrder;
use App\DetailOrder;
use App\OrderLog;
use App\Payment;
use App\Mail\OrderCheckout;
use App\Mail\OrderConfirmed;

use Excel;

class OrderController extends Controller {

	/**
     * Handle an authentication attempt.
     *
     * @return Response
     */


    /**
     * The Guard implementation.
     *
     * @var Authenticator
     */
    protected $auth;

    protected function  guard()
    {
    	return Auth::guard('guard-name');
    }

    public function __construct()
	{
        $this->middleware('auth');
	}

    public function index()
    {
        $data['order'] = HeaderOrder::join('users', 'header_orders.user_id', '=', 'users.id')
                                    ->select(DB::RAW('header_orders.*, users.name as user_name'))
                                    ->orderBy('created_at', 'DESC')
                                    ->get();
        $data['order'] = json_decode(json_encode($data['order']),true);
        $detailOrder = DetailOrder::join('header_orders', 'detail_orders.order_header_id', '=', 'header_orders.id')
                                    ->select(DB::RAW('detail_orders.*'))
                                    ->get();
        for($i=0;$i<sizeof($data['order']);$i++) {
            $data['order'][$i]['detail'] = [];
            foreach($detailOrder as $d) {
                if($d->header_order_id == $data['order'][$i]['id']) {
                    array_push($data['order'][$i]['detail'], $d);
                }
            }
        }

        $data['user'] = User::select('id', 'name')->get();

        $data['tile'] = Tile::select('id', 'item_name')->get();
        $data['addon'] = AddOn::select('id', 'add_on_name')->get();

        // return $data;

        return view('order/order-list', $data);
    }

    public function getPayment()
    {
        $id = Input::input('id');

        $data['payment'] = Payment::where('order_header_id', $id)->first();

        return json_encode($data);
    }

    public function changeStatus()
    {
        // return Input::all();
        $id = Input::input('id');
        $email = Input::input('email');
        $status = Input::input('status');
        $note = Input::input('admin_note');
        $orderModel = HeaderOrder::find($id);
        $orderModel->status = $status;
        $orderModel->admin_note = $note;
        if($status == 'pesanan terkirim') {
            $orderModel->sent = 1;
            $orderModel->sent_at = Carbon::now()->format('Y-m-d H:i:s');
        }
        $orderModel->save();

        $logModel = new OrderLog;
        $logModel->header_order_id = $id;
        $logModel->status = $status;
        $logModel->admin_note = $note;
        $logModel->save();

        if($email == 'true') {
            $header = HeaderOrder::join('users', 'header_orders.user_id', '=', 'users.id')
                                ->select(DB::RAW('users.email, users.name, header_orders.*, header_orders.created_at as header_created_at, header_orders.created_at as header_created_at2, header_orders.fee as subtotal, "null" as paymentDetail'))
                                ->where('header_orders.id', $id)->first();
            $header->paymentDetail = Payment::where('order_header_id', $id)->first();
            if($header->paymentDetail != null && $header->paymentDetail != '') {
                $header->paymentDetail->payment_date = Carbon::createFromFormat('d/m/Y', $header->paymentDetail->payment_date)->format('d F Y');
            }
            $header->header_created_at = Carbon::createFromFormat('Y-m-d H:i:s', $header->header_created_at)->format('d F Y H:i');
            $header->header_created_at2 = Carbon::createFromFormat('Y-m-d H:i:s', $header->header_created_at2)->format('d F Y');
            $detail = DetailOrder::where('order_header_id', $id)->get();
            foreach($detail as $d) {
                $header->subtotal += $d->price_per_box * $d->total_item;
            }
            if($status == 'menunggu pembayaran') {
                Mail::send('email-depotile.invoice1', ['header' => $header, 'detail' => $detail], function($m) use ($header) {
                    $m->from(env('MAIL_ADDRESS', 'sales@depotile.com'), 'depotile.com');
                    $m->to($header->email, $header->name)->subject('Konfirmasi Pesanan');
                });
            }else if($status == 'pesanan terkonfirmasi') {
                Mail::send('email-depotile.invoice2', ['header' => $header, 'detail' => $detail], function($m) use ($header) {
                    $m->from(env('MAIL_ADDRESS', 'sales@depotile.com'), 'depotile.com');
                    $m->to($header->email, $header->name)->subject('Konfirmasi Pembayaran');
                });
            }else if($status = 'pesanan terkirim') {
                Mail::send('email-depotile.invoice3', ['header' => $header, 'detail' => $detail], function($m) use ($header) {
                    $m->from(env('MAIL_ADDRESS', 'sales@depotile.com'), 'depotile.com');
                    $m->to($header->email, $header->name)->subject('Pesanan Terkirim');
                });
            }
        }

        return Redirect::back();
    }

    public function getDetail($id)
    {
        // return $id;
        $data['header'] = HeaderOrder::join('users', 'header_orders.user_id', '=', 'users.id')->select(DB::RAW('header_orders.*'))->find($id);
        $data['detail_tile'] = DetailOrder::join('tiles', 'detail_orders.item_id', '=', 'tiles.id')
                                    ->where('detail_orders.type', 'tile')
                                    ->where('order_header_id', $id)
                                    ->get();
        $data['detail_add_on'] = DetailOrder::join('add_ons', 'detail_orders.item_id', '=', 'add_ons.id')
                                    ->where('detail_orders.type', 'addon')
                                    ->where('order_header_id', $id)
                                    ->get();

        return view('order/order-detail', $data);
    }

    public function add()
    {
        // return Input::all();
        $data['type'] = 'add';
        $id = Input::input('user');

        $data['header'] = User::join('addresses', 'users.id', '=', 'addresses.user_id')
                            ->join('cities', 'addresses.city_id', '=', 'cities.id')
                            ->join('provinces', 'cities.province_id', '=', 'provinces.id')
                            ->select(DB::RAW('users.*, CONCAT(addresses.address,", ", cities.city_name, ", ", provinces.province_name) as receiver_address, addresses.name as receiver_name, addresses.telp1 as receiver_telp1, addresses.telp2 as receiver_telp2'))
                            ->where('users.id', $id)
                            ->where('addresses.type', 'primary')
                            ->first();
        $data['detail_tile'] = [];
        $data['detail_add_on'] = [];
        $data['address'] = Address::join('cities', 'addresses.city_id', '=', 'cities.id')
                                ->join('provinces', 'cities.province_id', '=', 'provinces.id')
                                ->select(DB::RAW('addresses.*, cities.city_name, provinces.province_name'))
                                ->where('addresses.user_id', '!=', 0)
                                ->where('user_id', $data['header']->id)
                                ->get();
        $data['tile'] = Tile::all();
        $data['add_on'] = AddOn::all();
        $addressArray = explode(', ', $data['header']['receiver_address']);
        $data['city'] = City::join('provinces', 'provinces.id', '=', 'cities.province_id')
                            ->select('cities.id')
                            ->where('cities.city_name', 'LIKE', $addressArray[sizeof($addressArray)-2])
                            ->where('provinces.province_name', 'LIKE', $addressArray[sizeof($addressArray)-1])
                            ->first()->id;
        $data['fee'] = HeaderFee::join('detail_fees', 'header_fees.id', '=', 'detail_fees.header_fee_id')
                                ->select(DB::RAW('header_fees.*, detail_fees.*, header_fees.id as header_id, detail_fees.id as detail_id'))
                                ->get();
        // $data['fee'] = [];
        // foreach($feeData as $d) {
        //     $data['fee'][$d->header_id][$d->detail_id]['city'] = $d->city_id;
        //     $data['fee'][$d->header_id][$d->detail_id]['quantity_below'] = $d->quantity_below;
        //     $data['fee'][$d->header_id][$d->detail_id]['quantity_above'] = $d->quantity_above;
        //     $data['fee'][$d->header_id][$d->detail_id]['fee_value'] = $d->fee_value;
        // }
        // return $data['fee'];

        return view('order/add-order', $data);
    }

    public function edit($id)
    {
        // HeaderOrder::withTrashed()->restore();
        // return $id;
        $data['header'] = HeaderOrder::join('users', 'header_orders.user_id', '=', 'users.id')->select(DB::RAW('header_orders.*'))->find($id);
        $data['detail_tile'] = DetailOrder::join('tiles', 'detail_orders.item_id', '=', 'tiles.id')
                                    ->where('detail_orders.type', 'tile')
                                    ->where('order_header_id', $id)
                                    ->get();
        $data['detail_add_on'] = DetailOrder::join('add_ons', 'detail_orders.item_id', '=', 'add_ons.id')
                                    ->where('detail_orders.type', 'addon')
                                    ->where('order_header_id', $id)
                                    ->get();
        $data['address'] = Address::join('cities', 'addresses.city_id', '=', 'cities.id')
                                ->join('provinces', 'cities.province_id', '=', 'provinces.id')
                                ->select(DB::RAW('addresses.*, cities.city_name, provinces.province_name'))
                                ->where('addresses.user_id', '!=', 0)
                                ->where('user_id', $data['header']->id)
                                ->get();
        $data['tile'] = Tile::all();
        $data['add_on'] = AddOn::all();
        $addressArray = explode(', ', $data['header']['receiver_address']);
        $data['city'] = City::join('provinces', 'provinces.id', '=', 'cities.province_id')
                            ->select('cities.id')
                            ->where('cities.city_name', 'LIKE', $addressArray[sizeof($addressArray)-2])
                            ->where('provinces.province_name', 'LIKE', $addressArray[sizeof($addressArray)-1])
                            ->first()->id;
        $data['fee'] = HeaderFee::join('detail_fees', 'header_fees.id', '=', 'detail_fees.header_fee_id')
                                ->select(DB::RAW('header_fees.*, detail_fees.*, header_fees.id as header_id, detail_fees.id as detail_id'))
                                ->get();
        // $data['fee'] = [];
        // foreach($feeData as $d) {
        //     $data['fee'][$d->header_id][$d->detail_id]['city'] = $d->city_id;
        //     $data['fee'][$d->header_id][$d->detail_id]['quantity_below'] = $d->quantity_below;
        //     $data['fee'][$d->header_id][$d->detail_id]['quantity_above'] = $d->quantity_above;
        //     $data['fee'][$d->header_id][$d->detail_id]['fee_value'] = $d->fee_value;
        // }
        // return $data['fee'];

        return view('order/add-order', $data);
    }

    // public function getAddress()
    // {
    //     $name = $_POST['name'];

    //     $address = Address::join('cities', 'addresses.city_id', '=', 'cities.id')
    //                         ->join('provinces', 'cities.province_id', '=', 'provinces.id')
    //                         ->join('users', 'addresses.user_id', '=', 'users.id')
    //                         ->select(DB::RAW('addresses.*, cities.city_name, provinces.province_name, users.name as username'))
    //                         ->where('users.name', 'LIKE', $name)
    //                         ->get();
    //     if(sizeof($address) == 0) {
    //         return 'No Address Data';
    //     }
    //     return json_encode($address);
    // }

    public function getItem()
    {
        $orderId = Input::input('orderId');
        $data = json_decode(Input::input('data'));

        // AMBIL DATA ITEM YANG BARU DIMASUKIN
        // -----------------------------------
        $tileModel = Tile::select(DB::RAW('id as item_id, item_code, item_name, detail_category_id, img_name1, img_name2, img_name3, price_per_m2 as price_per_box, "tile" as type, "0" as total_item, add_on_1, add_on_2, add_on_3, header_fee_id'));
        $addonModel = AddOn::select(DB::RAW('id as item_id, item_code, add_on_name as item_name, type as detail_category_id, img_name as img_name1, img_name as img_name2, img_name as img_name3, price_per_pcs as price_per_box, "addon" as type, "0" as total_item, header_fee_id'));
        $tileExist = false;
        $addonExist = false;
        foreach($data as $d) {
            if($d->type == 'tile') {
                $tileExist = true;
                $tileModel = $tileModel->orWhere('id', $d->id);
            }else {
                $addonExist = true;
                $addonModel = $addonModel->orWhere('id', $d->id);
            }
        }

        // jika user tidak memasukkan barang tile atau add on jadiin array nya kosong
        if($tileExist == true) {
            $tile = $tileModel->get();
        }else {
            $tile = [];
        }
        if($addonExist == true) {
            $addon = $addonModel->get();
        }else {
            $addon = [];
        }
        // return $tile;

        // AMBIL DATA ORDER YANG SUDAH ADA DENGAN ID YANG DIMINTA
        // ------------------------------------------------------
        $existingOrder = json_decode(json_encode(
            DetailOrder::join('header_orders', 'detail_orders.order_header_id', '=', 'header_orders.id')
                        ->select(DB::RAW('header_orders.receiver_address, detail_orders.*'))
                        ->where('order_header_id', $orderId)->get()
        ),true);
        if(sizeof($existingOrder) > 0) {
            $addressArray = explode(', ', $existingOrder[0]['receiver_address']);
            $cityId = City::join('provinces', 'provinces.id', '=', 'cities.province_id')
                        ->select('cities.id')
                        ->where('cities.city_name', 'LIKE', $addressArray[sizeof($addressArray)-2])
                        ->where('provinces.province_name', 'LIKE', $addressArray[sizeof($addressArray)-1])
                        ->first()->id;
            for($i=0;$i<sizeof($existingOrder);$i++) {
                if($existingOrder[$i]['type'] == 'tile') {
                    $itemModel = Tile::select(DB::RAW('header_fee_id, item_code, add_on_1, add_on_2, add_on_3'))->find($existingOrder[$i]['item_id']);
                    $existingOrder[$i]['item_code'] = $itemModel['item_code'];
                    $existingOrder[$i]['add_on_1'] = $itemModel['add_on_1'];
                    $existingOrder[$i]['add_on_2'] = $itemModel['add_on_2'];
                    $existingOrder[$i]['add_on_3'] = $itemModel['add_on_3'];
                    $existingOrder[$i]['header_fee_id'] = $itemModel['header_fee_id'];
                }else {
                    $addonModel = AddOn::select(DB::RAW('header_fee_id, item_code'))->find($existingOrder[$i]['item_id']);
                    $existingOrder[$i]['item_code'] = $addonModel['item_code'];
                    $existingOrder[$i]['header_fee_id'] = $addonModel['header_fee_id'];
                }
            }
        }
        $cityId = User::join('addresses', 'users.id', '=', 'addresses.user_id')
                    ->select('addresses.city_id')
                    ->where('users.id', $orderId)
                    ->first()->city_id;
        $orderModel = [];
        foreach($tile as $d) {
            array_push($orderModel, $d);
        }
        foreach($addon as $d) {
            array_push($orderModel, $d);
        }            
        // return $orderModel;

        // UPDATE DATA DESCRIPTION TIAP ITEM DI ORDER DATA
        // -----------------------------------------------
        for($i=0;$i<sizeof($orderModel);$i++) {
            $orderModel[$i]['desc'] = "Paired with ";
            if($orderModel[$i]['type'] == 'tile') {
                for($j=0;$j<sizeof($existingOrder);$j++) {
                    if($existingOrder[$j]['type'] == 'addon' && 
                        ($existingOrder[$j]['item_id'] == $orderModel[$i]['add_on_1'] ||
                        $existingOrder[$j]['item_id'] == $orderModel[$i]['add_on_2'] ||
                        $existingOrder[$j]['item_id'] == $orderModel[$i]['add_on_3'])) 
                    {
                        $orderModel[$i]['desc'] .= $existingOrder[$j]['item_name']." ".$existingOrder[$j]['item_code'].", ";
                    }
                }
                for($j=0;$j<sizeof($orderModel);$j++) {
                    if($orderModel[$j]['type'] == 'addon' && 
                        ($orderModel[$j]['item_id'] == $orderModel[$i]['add_on_1'] ||
                        $orderModel[$j]['item_id'] == $orderModel[$i]['add_on_2'] ||
                        $orderModel[$j]['item_id'] == $orderModel[$i]['add_on_3'])) 
                    {
                        $orderModel[$i]['desc'] .= $orderModel[$j]['item_name']." ".$orderModel[$j]['item_code'].", ";
                    }
                }
            }else {
                for($j=0;$j<sizeof($existingOrder);$j++) {
                    if($existingOrder[$j]['type'] == 'tile' && 
                        ($orderModel[$i]['item_id'] == $existingOrder[$j]['add_on_1'] ||
                        $orderModel[$i]['item_id'] == $existingOrder[$j]['add_on_2'] ||
                        $orderModel[$i]['item_id'] == $existingOrder[$j]['add_on_3'])) 
                    {
                        $orderModel[$i]['desc'] .= $existingOrder[$j]['item_name']." ".$existingOrder[$j]['item_code'].", ";
                    }
                }
                for($j=0;$j<sizeof($orderModel);$j++) {
                    if($orderModel[$j]['type'] == 'tile' && 
                        ($orderModel[$i]['item_id'] == $orderModel[$j]['add_on_1'] ||
                        $orderModel[$i]['item_id'] == $orderModel[$j]['add_on_2'] ||
                        $orderModel[$i]['item_id'] == $orderModel[$j]['add_on_3'])) 
                    {
                        $orderModel[$i]['desc'] .= $orderModel[$j]['item_name']." ".$orderModel[$j]['item_code'].", ";
                    }
                }
            }
        }
        // return $orderModel;

        // UPDATE DATA ONGKIR DAN KOTA TIAP ITEM DI ORDER DATA
        // ---------------------------------------------------
        for($i=0;$i<sizeof($orderModel);$i++) {
            if($orderModel[$i]['total_item'] > 0) {
                $fee = HeaderFee::join('detail_fees', 'header_fees.id', '=', 'detail_fees.header_fee_id')
                                ->where('header_fees.id', $orderModel[$i]['header_fee_id'])
                                ->where('quantity_below', '>=', $orderModel[$i]['total_item'])
                                ->where('quantity_above', '>=', $orderModel[$i]['total_item'])
                                ->first()->fee_value;
                $orderModel[$i]['fee'] = $fee;
            }else {
                $orderModel[$i]['fee'] = 0;
            }
            $orderModel[$i]['city'] = $cityId;
        }
        // return $orderModel;

        return json_encode($orderModel);
    }

    public function editOrder()
    {
        // return Input::all();
        $orderId = Input::input('id');
        $receiverName = Input::input('username');
        $receiverAddress = Input::input('address');
        $receiverTelp1 = Input::input('receiverTelp1');
        $receiverTelp2 = Input::input('receiverTelp2');
        $adminNote = Input::input('note');
        $itemId = Input::input('itemId');
        $itemQty = Input::input('itemQty');
        $itemType = Input::input('itemType');
        $grandTotalPrice = preg_replace('/\./', '', Input::input('grand_total_price'));
        $fee = preg_replace('/\./', '', Input::input('fee'));

        // SAVE HEADER
        // -----------
        $existingOrder = HeaderOrder::find($orderId);
        $orderModel = new HeaderOrder;
        $orderModel->order_number = $existingOrder->order_number.' Rev '.($existingOrder->rev+1);
        $orderModel->user_id = $existingOrder->user_id;
        $orderModel->receiver_name = $receiverName;
        $orderModel->receiver_address = $receiverAddress;
        $orderModel->receiver_telp1 = $receiverTelp1;
        $orderModel->receiver_telp2 = $receiverTelp2;
        $orderModel->admin_note = $adminNote;
        $orderModel->fee = $fee;
        $orderModel->status = 'menunggu pembayaran';
        $orderModel->rev = $existingOrder->rev+1;
        $orderModel->save();

        $headerId = $orderModel->id;

        // SAVE DETAIL
        // -----------
        $i=0;
        foreach($itemId as $d) {
            if($itemType[$i] == 'tile') {
                $itemModel = Tile::find($d);
                $itemName = $itemModel->item_name;
                $imgName = $itemModel->img_name1;
                $price = $itemModel->price_per_m2;
            }else {
                $itemModel = AddOn::find($d);
                $itemName = $itemModel->add_on_name;
                $imgName = $itemModel->img_name;
                $price = $itemModel->price_per_pcs;
            }
            $detailModel = new DetailOrder;
            $detailModel->order_header_id = $headerId;
            $detailModel->item_id = $d;
            $detailModel->item_name = $itemName;
            $detailModel->img_name1 = $imgName;
            $detailModel->img_name2 = $imgName;
            $detailModel->img_name3 = $imgName;
            $detailModel->price_per_box = $price;
            $detailModel->type = $itemType[$i];
            $detailModel->total_item = $itemQty[$i];
            $detailModel->save();
            $i++;
        }

        $existingOrder->delete();

        $header = HeaderOrder::join('users', 'header_orders.user_id', '=', 'users.id')
                            ->select(DB::RAW('users.email, users.name, header_orders.*, header_orders.created_at as header_created_at, header_orders.created_at as header_created_at2, header_orders.fee as subtotal, "null" as paymentDetail'))
                            ->where('header_orders.id', $headerId)->first();
        $header->paymentDetail = Payment::where('order_header_id', $headerId)->first();
        if($header->paymentDetail != null && $header->paymentDetail != '') {
            $header->paymentDetail->payment_date = Carbon::createFromFormat('d/m/Y', $header->paymentDetail->payment_date)->format('d F Y');
        }
        $header->header_created_at = Carbon::createFromFormat('Y-m-d H:i:s', $header->header_created_at)->format('d F Y H:i');
        $header->header_created_at2 = Carbon::createFromFormat('Y-m-d H:i:s', $header->header_created_at2)->format('d F Y');
        $detail = DetailOrder::where('order_header_id', $headerId)->get();
        foreach($detail as $d) {
            $header->subtotal += $d->price_per_box * $d->total_item;
        }
        Mail::send('email-depotile.invoice1', ['header' => $header, 'detail' => $detail], function($m) use ($header) {
            $m->from(env('MAIL_ADDRESS', 'sales@depotile.com'), 'depotile.com');
            $m->to($header->email, $header->name)->subject('Konfirmasi Pesanan');
        });

        return Redirect::to('order-manager/edit/'.$headerId);
    }

    public function addOrder()
    {
        // return Input::all();
        $data['type'] = 'edit';
        $userId = Input::input('id');
        $receiverName = Input::input('username');
        $receiverAddress = Input::input('address');
        $receiverTelp1 = Input::input('receiverTelp1');
        $receiverTelp2 = Input::input('receiverTelp2');
        $adminNote = Input::input('note');
        $itemId = Input::input('itemId');
        $itemQty = Input::input('itemQty');
        $itemType = Input::input('itemType');
        $grandTotalPrice = preg_replace('/\./', '', Input::input('grand_total_price'));
        $fee = preg_replace('/\./', '', Input::input('fee'));

        // SAVE HEADER
        // -----------
        $orderList = HeaderOrder::all();
        $number = '';
        while(true) {
            $number = 'DPT';
            for($i=0;$i<7;$i++) {
                $number .= mt_rand(0,9);
            }
            $valid = true;
            foreach($orderList as $d) {
                if($d->order_number == $number) {
                    $valid = false;
                    break;
                }
            }
            if($valid == true) {
                break;
            }
        }
        $orderModel = new HeaderOrder;
        $orderModel->order_number = $number;
        $orderModel->user_id = $userId;
        $orderModel->receiver_name = $receiverName;
        $orderModel->receiver_address = $receiverAddress;
        $orderModel->receiver_telp1 = $receiverTelp1;
        $orderModel->receiver_telp2 = $receiverTelp2;
        $orderModel->admin_note = $adminNote;
        $orderModel->fee = $fee;
        $orderModel->status = 'menunggu pembayaran';
        $orderModel->rev = 0;
        $orderModel->save();

        $headerId = $orderModel->id;

        // SAVE DETAIL
        // -----------
        $i=0;
        foreach($itemId as $d) {
            if($itemType[$i] == 'tile') {
                $itemModel = Tile::find($d);
                $itemName = $itemModel->item_name;
                $imgName = $itemModel->img_name1;
                $price = $itemModel->price_per_m2;
            }else {
                $itemModel = AddOn::find($d);
                $itemName = $itemModel->add_on_name;
                $imgName = $itemModel->img_name;
                $price = $itemModel->price_per_pcs;
            }
            $detailModel = new DetailOrder;
            $detailModel->order_header_id = $headerId;
            $detailModel->item_id = $d;
            $detailModel->item_name = $itemName;
            $detailModel->img_name1 = $imgName;
            $detailModel->img_name2 = $imgName;
            $detailModel->img_name3 = $imgName;
            $detailModel->price_per_box = $price;
            $detailModel->type = $itemType[$i];
            $detailModel->total_item = $itemQty[$i];
            $detailModel->save();
            $i++;
        }

        $header = HeaderOrder::join('users', 'header_orders.user_id', '=', 'users.id')
                            ->select(DB::RAW('users.email, users.name, header_orders.*, header_orders.created_at as header_created_at, header_orders.created_at as header_created_at2, header_orders.fee as subtotal, "null" as paymentDetail'))
                            ->where('header_orders.id', $headerId)->first();
        $header->paymentDetail = Payment::where('order_header_id', $headerId)->first();
        if($header->paymentDetail != null && $header->paymentDetail != '') {
            $header->paymentDetail->payment_date = Carbon::createFromFormat('d/m/Y', $header->paymentDetail->payment_date)->format('d F Y');
        }
        $header->header_created_at = Carbon::createFromFormat('Y-m-d H:i:s', $header->header_created_at)->format('d F Y H:i');
        $header->header_created_at2 = Carbon::createFromFormat('Y-m-d H:i:s', $header->header_created_at2)->format('d F Y');
        $detail = DetailOrder::where('order_header_id', $headerId)->get();
        foreach($detail as $d) {
            $header->subtotal += $d->price_per_box * $d->total_item;
        }
        Mail::send('email-depotile.invoice1', ['header' => $header, 'detail' => $detail], function($m) use ($header) {
            $m->from(env('MAIL_ADDRESS', 'sales@depotile.com'), 'depotile.com');
            $m->to($header->email, $header->name)->subject('Konfirmasi Pesanan');
        });

        return Redirect::to('order-manager');

    }

}