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

use App\Brand;
use App\Setting;

class BrandController extends Controller {

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
    	// Brand::withTrashed()->restore();

        // AMBIL DATA SETTING ORDER BY
        // ---------------------------
        $data['order_by'] = Setting::where('name', 'LIKE', 'brand order by')->first()->value;


        // AMBIL DATA BRAND
        // ----------------
    	$data['brand'] = Brand::orderBy($data['order_by'])->get();

    	// AMBIL DATA GAMBAR
        // -----------------
        $directory = $_SERVER['DOCUMENT_ROOT']."/".env('APP_ROOT_DIR')."/public/assets/image/logo-image/";
        $handle = opendir($directory);
        $data['logo_img'] = [];
        while($file = readdir($handle)){
            if($file !== '.' && $file !== '..') {
            	array_push($data['logo_img'], $file);
            }
        }
        // return $data;

    	return view('brand/brand-list', $data);
    }

    public function addBrand()
    {
    	$name = Request::input('brand_name');
    	$img = Request::input('logo_img');
    	$brandModel = new Brand;
    	$brandModel->brand_name = $name;
    	$brandModel->brand_logo = $img;
    	$brandModel->save();
    	return Redirect::to('brand-manager');
    }

    public function getData()
    {
    	$id = Request::input('brand-id');
    	$data = Brand::find($id);
    	return json_encode($data);
    }

    public function editBrand()
    {
    	// return Input::all();
    	$id = Input::input('brand_id');
    	$name = Input::input('brand_name');
    	$img = Input::input('logo_img');
    	$brandModel = Brand::find($id);
    	$brandModel->brand_name = $name;
    	$brandModel->brand_logo = $img;
    	$brandModel->save();
    	return Redirect::to('brand-manager');
    }

    public function delBrand()
    {
    	// return Input::all();
    	$data = json_decode(Input::input('data'));
    	foreach($data as $d) {
    		$brandModel = Brand::find($d->id);
    		$brandModel->delete();
    	}
    	return Redirect::to('brand-manager');
    }

    public function editOrderBy()
    {
        // return Input::all();
        $value = Input::input('orderBy');
        $settingModel = Setting::where('name', 'LIKE', 'brand order by')->first();
        $settingModel->value = $value;
        $settingModel->save();

        return Redirect::back();
    }

}