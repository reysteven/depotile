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

class ProvinceController extends Controller {

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
        $data['province'] = Province::all();
        return view('province/province-list', $data);
    }

    public function doSearch()
    {
        // return Input::all();
        $data['search_flag_tile'] = Input::input('search_flag_tile');
        $data['province_name'] = Input::input('province_name');
        $data['province'] = Province::where('province_name', 'LIKE', '%'.$data['province_name'].'%')->get();
        return view('province/province-list', $data);
    }

    public function addProvince()
    {
        $province = Request::input('province_name');
        $provinceModel = new Province;
        $provinceModel->province_name = $province;
        $provinceModel->save();
        return Redirect::to('location/province-manager');
    }

    public function editProvince()
    {
        $id = Request::input('province_id');
        $province = Request::input('province_name');
        $provinceModel = Province::find($id);
        $provinceModel->province_name = $province;
        $provinceModel->save();
        return Redirect::to('location/province-manager');
    }

    public function delProvince()
    {
        $data = json_decode(Request::input('province_data'));
        foreach($data as $d) {
            Province::find($d->id)->delete();
        }
        return Redirect::to('location/province-manager');
    }

}