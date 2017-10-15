<?php namespace App\Http\Controllers;

use Auth;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

use App\Province;
use App\City;

class CityController extends Controller {

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
        // City::withTrashed()->restore();
        $data['province'] = Province::all();
        $data['city'] = City::join('provinces', 'cities.province_id', '=', 'provinces.id')->select(DB::RAW('provinces.*, cities.*, provinces.id as province_id'))->get();
        return view('city/city-list', $data);
    }

    public function doSearch()
    {
        // return Input::all();
        $data['search_flag_tile'] = Input::input('search_flag_tile');
        $data['province_name'] = Input::input('province_name');
        $data['city_name'] = Input::input('city_name');
        $data['province'] = Province::all();
        $data['city'] = City::join('provinces', 'cities.province_id', '=', 'provinces.id')->select(DB::RAW('provinces.*, cities.*, provinces.id as province_id'));
        if($data['province_name'] != null && $data['province_name'] != "") {
            $data['city']->where('province_name', 'LIKE', '%'.$data['province_name'].'%');
        }
        if($data['city_name'] != null && $data['city_name'] != "") {
            $data['city']->where('city_name', 'LIKE', '%'.$data['city_name'].'%');
        }
        $data['city'] = $data['city']->get();
        return view('city/city-list', $data);
    }

    public function addCity()
    {
        $province = Request::input('province_name');
        $city = Request::input('city_name');
        $provinceId = Province::where('province_name', $province)->first()->id;
        $cityModel = new City;
        $cityModel->province_id = $provinceId;
        $cityModel->city_name = $city;
        $cityModel->save();
        return Redirect::to('location/city-manager');
    }

    public function getData()
    {
        $id = Request::input('city_id');
        $data = City::join('provinces', 'cities.province_id', '=', 'provinces.id')->select(DB::RAW('cities.*, provinces.province_name'))->find($id);
        return json_encode($data);
    }

    public function editCity()
    {
        $id = Request::input('city_id');
        $province = Request::input('province_name');
        $city = Request::input('city_name');
        $provinceId = Province::where('province_name', $province)->first()->id;
        $cityModel = City::find($id);
        $cityModel->province_id = $provinceId;
        $cityModel->city_name = $city;
        $cityModel->save();
        return Redirect::to('location/city-manager');
    }

    public function delCity()
    {
        $data = json_decode(Request::input('city_data'));
        foreach($data as $d) {
            City::find($d->id)->delete();
        }
        return Redirect::to('location/city-manager');
    }

}