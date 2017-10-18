<?php namespace App\Http\Controllers;

use Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;

use App\User;
use App\Tile;
use App\AddOn;
use App\Brand;
use App\HeaderOrder;
use App\DetailOrder;
use App\HeaderTag;
use App\DetailTag;
use App\HeaderCategory;
use App\DetailCategory;
use App\HeaderFee;
use App\DetailFee;
use App\Address;
use App\Province;
use App\City;
use App\OrderLog;
use App\Mail\OrderCheckout;

class CartController extends Controller {

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

    protected function  guard()
    {
    	return Auth::guard('guard-name');
    }

    public function __construct()
	{
	    $this->middleware('auth');
	}

    public function back($step)
    {
        Session::put('sesUserStep', $step);
        $curr = md5(json_encode(Session::get('cart')));
        if($step == 'cart') {
            return Redirect::to('cart');
        }else if($step == 'shipping') {
            return Redirect::to('cart/shipping/'.$curr);
        }else if($step == 'summary') {
            return Redirect::to('cart/summary/'.$curr);
        }else if($step == 'finish') {
            return Redirect::to('cart/finish/'.$curr);
        }
    }

    public function index()
    {
        // return view('cart/cart');
        // return Session::get('cart');
        $cart = json_decode(Session::get('cart'),true);

        // inisialisasi addonexist dan tileexist
        // -------------------------------------
        for($i=0;$i<sizeof($cart);$i++) {
            if($cart[$i]['type'] == 'tile') {
                $cart[$i]['addonexist'] = 'false';
            }else {
                $cart[$i]['tile'] = '';
                $cart[$i]['tileexist'] = 'false';
            }
        }

        for($i=0;$i<sizeof($cart);$i++) {
            if($cart[$i]['type'] == 'tile') {
                $item = Tile::where(DB::RAW('MD5(id)'), $cart[$i]['id'])->first();
                $cart[$i]['addonexist'] = 'false';
                for($j=0;$j<sizeof($cart);$j++) {
                    if($cart[$j]['type'] == 'addon') {
                        if($cart[$j]['id'] == md5($item->add_on_1) || $cart[$j]['id'] == md5($item->add_on_2) || $cart[$j]['id'] == md5($item->add_on_3))
                        {
                            $cart[$j]['tile'] .= $item->item_name.' '.$item->item_code.', ';
                            $cart[$j]['tileexist'] = 'true';
                            $cart[$i]['addonexist'] = 'true';
                        }
                    }
                }
            }
        }
        // return $cart;
        Session::put('cart', json_encode($cart));
        return view('cart/cart');
        // $step = Session::get('sesUserStep');
        // if($step == 'cart') {
        //     return view('cart/cart');
        // }else if($step == 'shipping') {
        //     return Redirect::to('cart/shipping/'.$curr);
        // }else if($step == 'summary') {
        //     return Redirect::to('cart/summary/'.$curr);
        // }else if($step == 'finish') {
        //     return Redirect::to('cart/finish/'.$curr);
        // }
    }

    public function shipping()
    {
        // return $code;
        // return Session::get('delivery-address');
        // return Session::get('cart');

        $curr = md5(json_encode(Session::get('cart')));
        $step = Session::get('sesUserStep');

        $address = Address::join('cities', 'addresses.city_id', '=', 'cities.id')
                        ->join('provinces', 'cities.province_id', 'provinces.id')
                        ->select(DB::RAW('addresses.*, addresses.id as addressId, province_name, city_name'))
                        ->where('user_id', Session::get('sesUserId'))
                        ->where('addresses.type', 'primary')->first();
        $cart = json_decode(Session::get('cart'),true);
        $data['fee'] = 0;
        for($i=0;$i<sizeof($cart);$i++) {
            if($cart[$i]['type'] == 'tile') {
                $fee = HeaderFee::join('detail_fees', 'header_fees.id', '=', 'detail_fees.header_fee_id')
                                ->join('tiles', 'header_fees.id', '=', 'tiles.header_fee_id')
                                ->select(DB::RAW('detail_fees.*'))
                                ->where(DB::RAW('MD5(tiles.id)'), $cart[$i]['id'])
                                ->get();
            }else {
                $fee = HeaderFee::join('detail_fees', 'header_fees.id', '=', 'detail_fees.header_fee_id')
                                ->join('add_ons', 'header_fees.id', '=', 'add_ons.header_fee_id')
                                ->select(DB::RAW('detail_fees.*'))
                                ->where(DB::RAW('MD5(add_ons.id)'), $cart[$i]['id'])
                                ->get();
            }
            // return json_encode($fee);
            $qty = $cart[$i]['qty'];
            foreach($fee as $d) {
                if($d["city_id"] == $address["city_id"] && $d["quantity_below"] <= $qty && $d["quantity_above"] >= $qty) {
                    $data['fee'] += $d->fee_value;
                }
            }
        }
        // return $data['fee'];

        $province = Province::join('cities', 'provinces.id', '=', 'cities.province_id')
                            ->select(DB::RAW('provinces.id as provinceId, province_name, cities.id as cityId, city_name'))
                            ->get();
        $data['province'] = [];
        foreach($province as $d) {
            if(!isset($data['province'][$d->province_name]['city'])) {
                $data['province'][$d->province_name]['city'] = [];
            }
            $data['province'][$d->province_name]['id'] = $d->provinceId;
            $data['province'][$d->province_name]['city'][$d->city_name]['id'] = $d->cityId;
        }

        $data['address'] = Address::join('cities', 'addresses.city_id', '=', 'cities.id')
                        ->join('provinces', 'cities.province_id', 'provinces.id')
                        ->select(DB::RAW('addresses.*, addresses.id as addressId, province_name, city_name'))
                        ->where('user_id', Session::get('sesUserId'))->get();
        return view('cart/shipping', $data);
        // if($code == $curr && $step == 'cart') {
        //     Session::put('sesUserStep', 'shipping');
        //     return view('cart/shipping', $data);
        // }else {
        //     if($step == 'cart') {
        //         return Redirect::to('cart');
        //     }else if($step == 'shipping') {
        //         return view('cart/shipping', $data);
        //     }else if($step == 'summary') {
        //         return Redirect::to('cart/summary/'.$curr);
        //     }else if($step == 'finish') {
        //         return Redirect::to('cart/finish/'.$curr);
        //     }
        // }
    }

    public function getFeeData()
    {
        $addressId = Input::input('address');
        $address = Address::join('cities', 'addresses.city_id', '=', 'cities.id')
                        ->join('provinces', 'cities.province_id', 'provinces.id')
                        ->select(DB::RAW('addresses.*, addresses.id as addressId, province_name, city_name'))
                        ->where('addresses.id', $addressId)
                        ->first();
        $cart = json_decode(Session::get('cart'),true);
        $data['fee'] = 0;
        for($i=0;$i<sizeof($cart);$i++) {
            if($cart[$i]['type'] == 'tile') {
                $fee = HeaderFee::join('detail_fees', 'header_fees.id', '=', 'detail_fees.header_fee_id')
                                ->join('tiles', 'header_fees.id', '=', 'tiles.header_fee_id')
                                ->select(DB::RAW('detail_fees.*'))
                                ->where(DB::RAW('MD5(tiles.id)'), $cart[$i]['id'])
                                ->get();
            }else {
                $fee = HeaderFee::join('detail_fees', 'header_fees.id', '=', 'detail_fees.header_fee_id')
                                ->join('add_ons', 'header_fees.id', '=', 'add_ons.header_fee_id')
                                ->select(DB::RAW('detail_fees.*'))
                                ->where(DB::RAW('MD5(add_ons.id)'), $cart[$i]['id'])
                                ->get();
            }
            // return json_encode($fee);
            $qty = $cart[$i]['qty'];
            foreach($fee as $d) {
                if($d->city_id == $address->city_id && $d->quantity_below <= $qty && $d->quantity_above >= $qty) {
                    $data['fee'] += $d->fee_value;
                }
            }
        }

        return number_format($data['fee'],0,'.','.');
    }

    public function addAddressToSession()
    {
        $non_shipping = Input::input('non-shipping');
        $addressId = Input::input('addressId');
        $receiverName = Input::input('name');
        $receiverPhone1 = Input::input('receiverPhone1');
        $receiverPhone2 = Input::input('receiverPhone2');
        $receiverNote = Input::input('receiverNote');
        // return $addressId.' '.$receiverName.' '.$receiverPhone1.' '.$receiverPhone2.' '.$receiverNote;

        // ADD FEE DATA
        // ------------
        // return Session::get('cart');
        $address = Address::join('cities', 'addresses.city_id', '=', 'cities.id')
                            ->join('provinces', 'cities.province_id', '=', 'provinces.id')
                            ->where('addresses.id', $addressId)
                            ->first();
        $cart = json_decode(Session::get('cart'),true);
        for($i=0;$i<sizeof($cart);$i++) {
            $cart[$i]['fee'] = 0;
            if($addressId != 0) {
                if($cart[$i]['type'] == 'tile') {
                    $fee = HeaderFee::join('detail_fees', 'header_fees.id', '=', 'detail_fees.header_fee_id')
                                    ->join('tiles', 'header_fees.id', '=', 'tiles.header_fee_id')
                                    ->select(DB::RAW('detail_fees.*'))
                                    ->where(DB::RAW('MD5(tiles.id)'), $cart[$i]['id'])
                                    ->get();
                }else {
                    $fee = HeaderFee::join('detail_fees', 'header_fees.id', '=', 'detail_fees.header_fee_id')
                                    ->join('add_ons', 'header_fees.id', '=', 'add_ons.header_fee_id')
                                    ->select(DB::RAW('detail_fees.*'))
                                    ->where(DB::RAW('MD5(add_ons.id)'), $cart[$i]['id'])
                                    ->get();
                }
                // return json_encode($fee);
                $qty = $cart[$i]['qty'];
                foreach($fee as $d) {
                    if($d->city_id == $address->city_id && $d->quantity_below <= $qty && $d->quantity_above >= $qty) {
                        $cart[$i]['fee'] = $d->fee_value;
                    }
                }
            }
        }
        Session::put('cart', json_encode($cart));

        if($addressId == 0) {
            $addressId = Address::select('addresses.id')
                                ->where('type', 'non-shipping')
                                ->first()->id;
        }

        if($non_shipping == "true") {
            $array = [
                "non-shipping" => $non_shipping,
                "addressId" => $addressId,
                "receiverName" => $receiverName,
                "receiverPhone1" => $receiverPhone1,
                "receiverPhone2" => $receiverPhone2,
                "receiverNote" => $receiverNote
            ];
        }else {
            $array = [
                "non-shipping" => $non_shipping,
                "addressId" => $addressId,
                "receiverName" => $receiverName,
                "receiverPhone1" => $receiverPhone1,
                "receiverPhone2" => $receiverPhone2,
                "receiverNote" => $receiverNote
            ];
        }
        Session::put('delivery-address', json_encode($array));
        $curr = md5(json_encode(Session::get('cart')));
        return $curr;
    }

    public function summary()
    {
        // return $code;
        // return Session::get('cart');
        // return Session::get('delivery-address');
        $address = json_decode(Session::get('delivery-address'),true);
        if($address['non-shipping'] == "false") {
            $data['delivery_address'] = Address::join('cities', 'addresses.city_id', '=', 'cities.id')
                                                ->join('provinces', 'cities.province_id', '=', 'provinces.id')
                                                ->where('addresses.id', $address['addressId'])
                                                ->first();
        }else {
            $data['delivery_address'] = "<p>Jln. Boulevard Raya Blok RA1 No. 1B<br>Kelapa Gading, Jakarta Utara 14240</p>";
        }
        // return $data['delivery_address'];
        $curr = md5(json_encode(Session::get('cart')));
        $step = Session::get('sesUserStep');
        return view('cart/summary', $data);
        // if($code == $curr && $step == 'shipping') {
        //     Session::put('sesUserStep', 'summary');
        //     return view('cart/summary', $data);
        // }else {
        //     if($step == 'cart') {
        //         return Redirect::to('cart');
        //     }else if($step == 'shipping') {
        //         return Redirect::to('cart/shipping');
        //     }else if($step == 'summary') {
        //         return view('cart/summary', $data);
        //     }else if($step == 'finish') {
        //         return Redirect::to('cart/finish/'.$curr);
        //     }
        // }
    }

    public function finish()
    {
        // return $code;
        // return Session::all();

        $deliveryaddress = json_decode(Session::get('delivery-address'),true);
        if($deliveryaddress['non-shipping'] == 'false') {
            $useraddress = Address::join('cities', 'addresses.city_id', '=', 'cities.id')
                                ->join('provinces', 'cities.province_id', '=', 'provinces.id')
                                ->select(DB::RAW('addresses.*, cities.city_name, provinces.province_name'))
                                ->find($deliveryaddress['addressId']);
        }else {
            $useraddress = Address::where('type', 'non-shipping')->first();
        }
        $deliveryaddress = json_decode(json_encode($deliveryaddress));
        $cart = json_decode(Session::get('cart'));

        $orderList = HeaderOrder::all();

        $data['number'] = '';
        while(true) {
            $data['number'] = 'DPT';
            for($i=0;$i<7;$i++) {
                $data['number'] .= mt_rand(0,9);
            }
            $valid = true;
            foreach($orderList as $d) {
                if($d->order_number == $data['number']) {
                    $valid = false;
                    break;
                }
            }
            if($valid == true) {
                break;
            }
        }
        // return $data['number'];

        $data['fee'] = 0;
        foreach($cart as $d) {
            $data['fee'] += $d->fee;
        }
        // return $fee;

        $headerModel = new HeaderOrder;
        $headerModel->order_number = $data['number'];
        $headerModel->user_id = Session::get('sesUserId');
        if($deliveryaddress->receiverName == '' || $deliveryaddress->receiverName == null) {
            $headerModel->receiver_name = $useraddress->name;
        }else {
            $headerModel->receiver_name = $deliveryaddress->receiverName;
        }
        $headerModel->receiver_address = $useraddress->address.', '.$useraddress->city_name.', '.$useraddress->province_name;
        if($deliveryaddress->receiverPhone1 == '' || $deliveryaddress->receiverPhone1 == null) {
            $headerModel->receiver_telp1 = $useraddress->telp1;
        }else {
            $headerModel->receiver_telp1 = $deliveryaddress->receiverPhone1;
        }
        if($deliveryaddress->receiverPhone2 == '' || $deliveryaddress->receiverPhone2 == null) {
            $headerModel->receiver_telp2 = $useraddress->telp2;
        }else {
            $headerModel->receiver_telp2 = $deliveryaddress->receiverPhone2;
        }
        $headerModel->user_note = $deliveryaddress->receiverNote;
        $headerModel->admin_note = '';
        $headerModel->fee = $data['fee'];
        $headerModel->status = 'menunggu pembayaran';
        $headerModel->sent = 0;
        $headerModel->rev = 0;
        $headerModel->save();

        $headerId = $headerModel->id;

        $logModel = new OrderLog;
        $logModel->header_order_id = $headerId;
        $logModel->status = 'menunggu pembayaran';
        $logModel->admin_note = '';
        $logModel->save();

        $data['subtotal'] = 0;

        foreach($cart as $d) {
            $data['subtotal'] += $d->qty * $d->price;
            if($d->type == 'tile') {
                $itemId = Tile::where(DB::RAW('MD5(tiles.id)'), $d->id)->first()->id;
            }else {
                $itemId = AddOn::where(DB::RAW('MD5(add_ons.id)'), $d->id)->first()->id;
            }
            $detailModel = new DetailOrder;
            $detailModel->order_header_id = $headerId;
            $detailModel->item_id = $itemId;
            $detailModel->item_name = $d->name;
            $detailModel->detail_category_id = 0;
            $detailModel->img_name1 = $d->image;
            $detailModel->img_name2 = $d->image;
            $detailModel->img_name3 = $d->image;
            $detailModel->price_per_box = $d->price;
            $detailModel->type = $d->type;
            $detailModel->hash_code = '';
            $detailModel->parent_hash = '';
            $detailModel->total_item = $d->qty;
            $detailModel->save();
        }

        $data['id'] = md5($headerId);
        // $data['order'] = HeaderOrder::join('detail_orders', 'header_orders.id', '=', 'detail_orders.order_header_id')->get();

        Session::put('sesUserStep', 'cart');

        Session::forget('cart');
        // return $headerId;

        // $order = HeaderOrder::join('users', 'header_orders.user_id', '=', 'users.id')->find($headerId);

        Mail::to(Session::get('sesUserEmail'))->send(new OrderCheckout($headerId));

        return Redirect::to('cart/finish/'.$data['id']);
    }

    public function toFinish($code)
    {
        // return $code;
        $data['code'] = $code;
        $data['order'] = HeaderOrder::join('detail_orders', 'header_orders.id', '=', 'detail_orders.order_header_id')
                                    ->select(DB::RAW('header_orders.*, detail_orders.*, header_orders.id as headerId'))
                                    ->where(DB::RAW('MD5(header_orders.id)'), $code)
                                    ->get();
        $data['number'] = $data['order'][0]->order_number;
        $data['fee'] = $data['order'][0]->fee;
        $data['subtotal'] = 0;
        foreach($data['order'] as $d) {
            $data['subtotal'] += $d->price_per_box * $d->total_item;
        }
        $data['id'] = md5($data['order'][0]->headerId);
        return view('cart/finish', $data);
    }

    public function delCart()
    {
        // return Input::all();
        $type = Input::input('type');
        $id = Input::input('id');
        $cart = json_decode(Session::get('cart'));

        $i=0;
        foreach($cart as $d) {
            if($d->type == $type && $d->id == $id) {
                unset($cart[$i]);
            }
            $i++;
        }

        Session::put('cart', json_encode($cart));

        return Redirect::back();
    }

}