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
use App\Setting;
use App\Payment;
use App\Mail\OrderCheckout;

class ConfirmationController extends Controller {

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

    public function index()
    {
        // HEADER DATA
        // -----------

        $data['brand_order_by'] = Setting::where('name', 'LIKE', 'brand order by')->first()->value;
        $data['brand'] = Brand::orderBy($data['brand_order_by'])->get();
        $data['tag'] = json_decode(json_encode(HeaderTag::where('showed', '!=', '0')->get()), true);
        $detailTag = DetailTag::join('header_tags', 'detail_tags.header_tag_id', '=', 'header_tags.id')
                            ->where('showed', '!=', '0')
                            ->get();
        for($i=0;$i<sizeof($data['tag']);$i++) {
            $data['tag'][$i]['detail'] = [];
            foreach($detailTag as $d) {
                if($d->header_tag_id == $data['tag'][$i]['id']) {
                    array_push($data['tag'][$i]['detail'], $d);
                }
            }
        }
        // return $data['tag'];

        $data['alltag'] = json_decode(json_encode(HeaderTag::all()), true);
        $detailTag = DetailTag::join('header_tags', 'detail_tags.header_tag_id', '=', 'header_tags.id')
                            ->select(DB::RAW('detail_tags.*'))
                            ->get();
        for($i=0;$i<sizeof($data['alltag']);$i++) {
            $data['alltag'][$i]['detail'] = [];
            foreach($detailTag as $d) {
                if($d->header_tag_id == $data['alltag'][$i]['id']) {
                    array_push($data['alltag'][$i]['detail'], $d);
                }
            }
        }
        // return $data['alltag'];

        $data['category'] = json_decode(json_encode(HeaderCategory::where('id', '!=', '1')->get()), true);
        $detailCategory = DetailCategory::join('header_categories', 'detail_categories.header_category_id', '=', 'header_categories.id')
                                        ->select(DB::RAW('detail_categories.*'))
                                        ->where('header_categories.id', '!=', '1')
                                        ->get();
        for($i=0;$i<sizeof($data['category']);$i++) {
            $data['category'][$i]['detail'] = [];
            foreach($detailCategory as $d) {
                if($d->header_category_id == $data['category'][$i]['id']) {
                    array_push($data['category'][$i]['detail'], $d);
                }
            }
        }
        // return $data['category'];

        $data['acc'] = DetailCategory::join('header_categories', 'detail_categories.header_category_id', '=', 'header_categories.id')
                                        ->where('header_categories.id', '1')
                                        ->get();

        // ==========================================================================================

        // return Session::all();
        // return Session::get('sesUserId');
        // $data['order'] = HeaderOrder::where('user_id', Session::get('sesUserId'))
        //                             ->whereNotExists(function($query) {
        //                                 $query->select('order_header_id')
        //                                     ->from('payments')
        //                                     ->get();
        //                             })->get();
        $data['order'] = HeaderOrder::leftJoin('payments', 'header_orders.id', '=', 'payments.order_header_id')
                                    ->select(DB::RAW('header_orders.*'))
                                    ->where('bank', null)
                                    ->where('user_id', Session::get('sesUserId'))
                                    ->get();

        return view('payment/paymentConfirmation', $data);
    }

    public function confirm()
    {
        // return Input::all();
        $number = Input::input('no_order');
        $bank = Input::input('bank');
        $account = Input::input('account_name');
        $amount = preg_replace('/[^0-9]/', '', Input::input('amount'));
        $date = Input::input('date');
        $note = Input::input('note');

        $orderId = HeaderOrder::where('order_number', 'LIKE', $number)->first()->id;

        $paymentModel = new Payment;
        $paymentModel->order_header_id = $orderId;
        $paymentModel->bank = $bank;
        $paymentModel->account_name = $account;
        $paymentModel->amount = $amount;
        $paymentModel->payment_date = $date;
        $paymentModel->note = $note;
        $paymentModel->status = "";
        $paymentModel->save();

        $orderModel = HeaderOrder::find($orderId);
        $orderModel->status = "pembayaran terkonfirmasi";
        $orderModel->save();

        return Redirect::back();
    }

}