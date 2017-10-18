<?php namespace App\Http\Controllers;

use Auth;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

use App\User;
use App\Tile;
use App\AddOn;
use App\Brand;
use App\HeaderTag;
use App\DetailTag;
use App\HeaderCategory;
use App\DetailCategory;
use App\Province;
use App\City;
use App\Address;
use App\RegistTemp;
use App\Mail\EmailConfirmation;

class RegisterController extends Controller {

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

    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
        $this->middleware('guest', ['except' => 'doLogout']);
    }

    public function index()
    {
        // HEADER DATA
        // -----------

        $data['item'] = Tile::all();
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

        // =============================================================================================

        $data['dd'] = Carbon::now()->format('j');
        $data['mm'] = Carbon::now()->format('n');
        $data['yy'] = Carbon::now()->format('Y');

        $data['province'] = json_decode(json_encode(Province::orderBy('id')->get()), true);
        $data['city'] = City::orderBy('province_id')->get();
        for($i=0;$i<sizeof($data['province']);$i++) {
            if(!isset($data['province'][$i]['city'])) {
                $data['province'][$i]['city'] = [];
            }
            foreach($data['city'] as $d) {
                if($d->province_id == $data['province'][$i]['id']) {
                    array_push($data['province'][$i]['city'], $d);
                }
            }
        }
        // return $data['province'];

        return view('auth/register', $data);
    }

    public function register()
    {

        // HEADER DATA
        // -----------

        $data['item'] = Tile::all();
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

        // =============================================================================================

        // return Input::all();
        $email = Input::input('email');
        $gender = ((Input::input('title') == "Mr.") ? "male" : "female");
        $name = Input::input('name');
        $handphone1 = Input::input('handphone');
        $company = Input::input('company');
        $pass = Input::input('password');
        $product = '';

        $emailExist = sizeof(User::where('email', $email)->get());
        if($emailExist != 0) {
            $messageError = "Email yang dimasukkan sudah terdaftar";
            return Redirect::back()->withErrors([$messageError])->withInput();
        }

        $emailHash = Hash::make($email);
        $emailHash = preg_replace("/[^A-Za-z0-9 ]/", '', $emailHash);
        // $emailHash = str_replace("\\", "", $emailHash);
        // $emailHash = str_replace("?", "", $emailHash);
        $registModel = new RegistTemp;
        $registModel->email = $email;
        $registModel->password = Hash::make($pass);
        $registModel->name = $name;
        $registModel->handphone1 = $handphone1;
        $registModel->handphone2 = 'null';
        $registModel->gender = $gender;
        $registModel->company = $company;
        $registModel->hash = $emailHash;
        $registModel->save();

        Mail::to($email)->send(new EmailConfirmation($emailHash, $name));

        // $userModel = new User;
        // $userModel->email = $email;
        // $userModel->password = Hash::make($pass);
        // $userModel->title = $title;
        // $userModel->name = $name;
        // $userModel->handphone1 = $handphone1;
        // $userModel->handphone2 = 'null';
        // $userModel->company = $company;
        // $userModel->last_login = Carbon::now()->format('Y-m-d H:i:s');
        // $userModel->save();

        // if (Auth::attempt(['email' => $email, 'password' => $pass]))
        // {
        //     $user = User::where('email', 'LIKE', $email)->first();
        //     // return json_encode($user).'1';
        //     // Redirect to homepage
        //     Session::regenerate();
        //     Session::put('sesUsername',$user->name);
        //     Session::put('sesUserEmail',$user->email);
        //     Session::put('sesUserId',$user->id);
        //     Session::put('sesUserType', $user->user_type);
        //     Session::put('sesUserStep', 'cart');
        //     if($product == '' || $product == null) {
        //         return redirect()->intended('/');
        //     }else {
        //         if($type == 'tile') {
        //             $name = Tile::where(DB::RAW('MD5(id)'), $product)->first()->item_name;
        //         }else {
        //             $name = AddOn::where(DB::RAW('MD5(id)'), $product)->first()->add_on_name;
        //         }
        //         return Redirect::to($type.'/'.$product.'/'.$name);
        //     }
        // }

        return view('auth/email-confirmation', $data);
        // return Redirect::to('/');
    }

    public function doConfirm($a)
    {
        // HEADER DATA
        // -----------

        $data['item'] = Tile::all();
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

        // =============================================================================================

        $hash = $a;

        $registModel = RegistTemp::where("hash", '=', $hash)->first();

        $userModel = new User;
        $userModel->email = $registModel->email;
        $userModel->password = $registModel->password;
        $userModel->title = (($registModel->gender == "male") ? "Mr." : "Mrs.");
        $userModel->name = $registModel->name;
        $userModel->handphone1 = $registModel->handphone1;
        $userModel->handphone2 = 'null';
        $userModel->company = $registModel->company;
        $userModel->last_login = Carbon::now()->format('Y-m-d H:i:s');
        $userModel->save();

        $registModel->delete();

        return view('auth/email-confirmed', $data);
    }

}