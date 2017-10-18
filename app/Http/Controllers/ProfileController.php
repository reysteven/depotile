<?php namespace App\Http\Controllers;

use Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

use App\User;
use App\Brand;
use App\HeaderTag;
use App\DetailTag;
use App\HeaderCategory;
use App\DetailCategory;
use App\HeaderOrder;
use App\DetailOrder;
use App\City;
use App\Province;
use App\Address;

class ProfileController extends Controller {

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

    public function index($type)
    {
        // HEADER DATA
        // -----------

        return $type;

        $data['brand'] = Brand::all();
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
        $detailTag = DetailTag::join('header_tags', 'detail_tags.header_tag_id', '=', 'header_tags.id')->get();
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

        $data['acc'] = DetailCategory::join('header_categories', 'detail_categories.header_category_id', '=', 'header_categories.id')
                                        ->where('header_categories.id', '1')
                                        ->get();

        // ==============================================================================================

        $data['user'] = User::select(DB::RAW('users.*'))
                            ->where('users.id', Session::get('sesUserId'))
                            ->first();

        return view('profile/profile', $data);
    }

    public function changeProfile()
    {
        // return Input::all();
        $title = Input::input('title');
        $name = Input::input('name');
        $gender = Input::input('gender');
        $handphone1 = Input::input('handphone1');
        $handphone2 = (Input::input('handphone2') == '' || Input::input('handphone2') == null) ? 'null' : Input::input('handphone2');
        $company = Input::input('company');

        Session::put('sesUsername', $name);

        $userModel = User::find(Session::get('sesUserId'));
        $userModel->title = $title;
        $userModel->name = $name;
        $userModel->handphone1 = $handphone1;
        $userModel->handphone2 = $handphone2;
        $userModel->company = $company;
        $userModel->save();

        return Redirect::back()->with('msg', 'Profile anda telah diperbaharui');
    }

    public function changePass()
    {
        // return Input::all();
        $old = Input::input('oldPassword');
        $new = Input::input('newPassword');
        $curr = User::find(Session::get('sesUserId'))->password;
        if(!Hash::check($old, $curr)) {
            $messageError = "Password lama tidak sesuai";
            return Redirect::back()->withErrors([$messageError]);
        }else {
            $userModel = User::find(Session::get('sesUserId'));
            $userModel->password = Hash::make($new);
            $userModel->save();
        }

        return Redirect::back()->with('pass-msg', 'Password anda telah diperbaharui');
    }

    public function address()
    {
        // HEADER DATA
        // -----------

        $data['brand'] = Brand::all();
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
        $detailTag = DetailTag::join('header_tags', 'detail_tags.header_tag_id', '=', 'header_tags.id')->get();
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

        $data['acc'] = DetailCategory::join('header_categories', 'detail_categories.header_category_id', '=', 'header_categories.id')
                                        ->where('header_categories.id', '1')
                                        ->get();

        // ===================================================================================================

        $data['address'] = Address::join('cities', 'addresses.city_id', '=', 'cities.id')
                                ->join('provinces', 'cities.province_id', '=', 'provinces.id')
                                ->select(DB::RAW('addresses.*, cities.*, provinces.*, addresses.id as addressId'))
                                ->where('user_id', Session::get('sesUserId'))->get();
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

        return view('profile/address', $data);
    }

    public function getAddressData()
    {
        $id = Input::input('id');

        $addressModel = Address::join('cities', 'addresses.city_id', '=', 'cities.id')
                            ->join('provinces', 'cities.province_id', '=', 'provinces.id')
                            ->select(DB::RAW('addresses.*, cities.id as city_id, provinces.id as province_id'))
                            ->find($id);
        return json_encode($addressModel);
    }

    public function addAddress()
    {
        // return Input::all();
        $name = Input::input('name');
        $province = Input::input('province');
        $city = Input::input('city');
        $address = Input::input('address');
        $handphone1 = Input::input('handphone1');
        $handphone2 = (Input::input('handphone2') == '' || Input::input('handphone2') == null) ? 'null' : Input::input('handphone2');

        $addressExist = sizeof(Address::where('user_id', Session::get('sesUserId'))->get());
        if($addressExist == 0) {
            $type = "primary";
        }else {
            $type = "secondary";
        }

        $addressModel = new Address;
        $addressModel->user_id = Session::get('sesUserId');
        $addressModel->name = $name;
        $addressModel->address = $address;
        $addressModel->city_id = $city;
        $addressModel->telp1 = $handphone1;
        $addressModel->telp2 = $handphone2;
        $addressModel->type = $type;
        $addressModel->save();

        return Redirect::back()->with('msg', 'Alamat baru telah berhasil dimasukkan');
    }

    public function addAddressInCart()
    {
        // return Input::all();
        $name = Input::input('name');
        $province = Input::input('province');
        $city = Input::input('city');
        $address = Input::input('address');
        $handphone1 = Input::input('handphone1');
        $handphone2 = (Input::input('handphone2') == '' || Input::input('handphone2') == null) ? 'null' : Input::input('handphone2');

        $addressExist = sizeof(Address::where('user_id', Session::get('sesUserId'))->get());
        if($addressExist == 0) {
            $type = "primary";
        }else {
            $type = "secondary";
        }

        $addressModel = new Address;
        $addressModel->user_id = Session::get('sesUserId');
        $addressModel->name = $name;
        $addressModel->address = $address;
        $addressModel->city_id = $city;
        $addressModel->telp1 = $handphone1;
        $addressModel->telp2 = $handphone2;
        $addressModel->type = $type;
        $addressModel->save();

        $addressModel = Address::join('cities', 'addresses.city_id', '=', 'cities.id')
                                ->join('provinces', 'cities.province_id', '=', 'provinces.id')
                                ->select(DB::RAW('addresses.*, cities.city_name, provinces.province_name'))
                                ->find($addressModel->id);

        return json_encode($addressModel);
    }

    public function editAddress()
    {
        // return Input::all();
        $id = Input::input('id');
        $name = Input::input('name');
        $city = Input::input('city');
        $address = Input::input('address');
        $handphone1 = Input::input('handphone1');
        $handphone2 = Input::input('handphone2');
        if($handphone2 == '' || $handphone2 == null) {
            $handphone2 = 'null';
        }

        $addressModel = Address::find($id);
        $addressModel->name = $name;
        $addressModel->city_id = $city;
        $addressModel->address = $address;
        $addressModel->telp1 = $handphone1;
        $addressModel->telp2 = $handphone2;
        $addressModel->save();

        return Redirect::back()->with('msg', 'Alamat telah berhasil diperbaharui');
    }

    public function delAddress()
    {
        // return Input::all();
        $id = Input::input('id');
        Address::find($id)->delete();

        return Redirect::back()->with('msg', 'Alamat telah berhasil dihapus');
    }

    public function order()
    {
        // HEADER DATA
        // -----------

        $data['brand'] = Brand::all();
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
        $detailTag = DetailTag::join('header_tags', 'detail_tags.header_tag_id', '=', 'header_tags.id')->get();
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

        $data['acc'] = DetailCategory::join('header_categories', 'detail_categories.header_category_id', '=', 'header_categories.id')
                                        ->where('header_categories.id', '1')
                                        ->get();

        // ==============================================================================================

        $data['ongoing'] = HeaderOrder::select(DB::RAW('header_orders.*, 0 as order_created_at, 0 as order_sent_at'))->where('user_id', Session::get('sesUserId'))->where('status', '!=', 'pesanan terkirim')->get();
        for($i=0;$i<sizeof($data['ongoing']);$i++) {
            $data['ongoing'][$i]->order_created_at = Carbon::createFromFormat('Y-m-d H:i:s', $data['ongoing'][$i]->created_at)->format('d F Y H:i');
            $data['ongoing'][$i]->order_sent_at = Carbon::createFromFormat('Y-m-d H:i:s', $data['ongoing'][$i]->sent_at)->format('d F Y H:i');
        }
        $data['finished'] = HeaderOrder::select(DB::RAW('header_orders.*, 0 as order_created_at, 0 as order_sent_at'))->where('user_id', Session::get('sesUserId'))->where('status', 'pesanan terkirim')->get();
        for($i=0;$i<sizeof($data['finished']);$i++) {
            $data['finished'][$i]->order_created_at = Carbon::createFromFormat('Y-m-d H:i:s', $data['finished'][$i]->created_at)->format('d F Y H:i');
            $data['finished'][$i]->order_sent_at = Carbon::createFromFormat('Y-m-d H:i:s', $data['finished'][$i]->sent_at)->format('d F Y H:i');
        }

        return view('profile/order', $data);
    }

    public function orderDetail($number)
    {
        // HEADER DATA
        // -----------

        $data['brand'] = Brand::all();
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
        $detailTag = DetailTag::join('header_tags', 'detail_tags.header_tag_id', '=', 'header_tags.id')->get();
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

        $data['acc'] = DetailCategory::join('header_categories', 'detail_categories.header_category_id', '=', 'header_categories.id')
                                        ->where('header_categories.id', '1')
                                        ->get();

        // ==============================================================================================

        $data['header'] = HeaderOrder::where('order_number', $number)->first();
        $addressArray = explode(', ', $data['header']->receiver_address);
        $data['header']['province'] = $addressArray[sizeof($addressArray)-1];
        $data['header']['city'] = $addressArray[sizeof($addressArray)-2];
        unset($addressArray[sizeof($addressArray)-1]);
        unset($addressArray[sizeof($addressArray)-1]);
        $data['header']['address'] = $addressArray[sizeof($addressArray)-1];
        $data['header']['total'] = 0;
        $data['detail'] = DetailOrder::where('order_header_id', $data['header']->id)->get();
        foreach($data['detail'] as $d) {
            $data['header']['total'] += $d->total_item * $d->price_per_box;
        }
        $data['header']['subtotal'] = $data['header']->total + $data['header']->fee;

        return view('profile/orderDetail', $data);
    }

    public function review()
    {
        // HEADER DATA
        // -----------

        $data['brand'] = Brand::all();
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
        $detailTag = DetailTag::join('header_tags', 'detail_tags.header_tag_id', '=', 'header_tags.id')->get();
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

        $data['acc'] = DetailCategory::join('header_categories', 'detail_categories.header_category_id', '=', 'header_categories.id')
                                        ->where('header_categories.id', '1')
                                        ->get();

        // ===================================================================================================

        return view('profile/review', $data);
    }

}