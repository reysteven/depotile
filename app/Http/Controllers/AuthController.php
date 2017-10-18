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
use App\Mail\ResetPassword;

use Socialite;

class AuthController extends Controller {

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

    /**
     * Redirect the user to the GitHub authentication page.
     *
     * @return Response
     */
    public function redirectToProvider()
    {
        return Socialite::driver('facebook')->redirect();
    }

    /**
     * Obtain the user information from GitHub.
     *
     * @return Response
     */
    public function handleProviderCallback()
    {
        $user = Socialite::driver('facebook')->user();

        // return json_encode($user);

        $email = "fb_".$user->email;
        $password = "fb_".$user->email;
        $type = '';
        $product = Request::input('product');
        // return $email.' '.$password;

        $userExist = User::where('email', '=', $email)->get();

        if(sizeof($userExist) == 0) {

            $gender = $user->user["gender"];
            $title = ($gender == "male") ? "Mr." : "Mrs.";
            $name = $user->name;
            $handphone1 = '';
            $company = '';
            $pass = $password;
            $product = '';

            $userModel = new User;
            $userModel->email = $email;
            $userModel->password = Hash::make($pass);
            $userModel->title = $title;
            $userModel->name = $name;
            $userModel->handphone1 = $handphone1;
            $userModel->handphone2 = 'null';
            $userModel->company = $company;
            $userModel->last_login = Carbon::now()->format('Y-m-d H:i:s');
            $userModel->save();

            if (Auth::attempt(['email' => $email, 'password' => $pass]))
            {
                $user = User::where('email', 'LIKE', $email)->first();
                // return json_encode($user).'1';
                // Redirect to homepage
                Session::regenerate();
                Session::put('sesUsername',$user->name);
                Session::put('sesUserEmail',$user->email);
                Session::put('sesUserId',$user->id);
                Session::put('sesUserType', $user->user_type);
                Session::put('sesUserStep', 'cart');
                if($product == '' || $product == null) {
                    return redirect()->intended('/');
                }else {
                    if($type == 'tile') {
                        $name = Tile::where(DB::RAW('MD5(id)'), $product)->first()->item_name;
                    }else {
                        $name = AddOn::where(DB::RAW('MD5(id)'), $product)->first()->add_on_name;
                    }
                    return Redirect::to($type.'/'.$product.'/'.$name);
                }
            }

        }else {

            // Try to log the user in.
            if (Auth::attempt(['email' => $email, 'password' => $password]))
            {
                $user = User::where('email', 'LIKE', $email)->first();
                // return json_encode($user).'1';
                // Redirect to homepage
                Session::regenerate();
                Session::put('sesUsername',$user->name);
                Session::put('sesUserEmail',$user->email);
                Session::put('sesUserId',$user->id);
                Session::put('sesUserType', $user->user_type);
                Session::put('sesUserStep', 'cart');
                if($product == '' || $product == null) {
                    return redirect()->intended('/');
                }else {
                    if($type == 'tile') {
                        $name = Tile::where(DB::RAW('MD5(id)'), $product)->first()->item_name;
                        $type = 't';
                    }else {
                        $name = AddOn::where(DB::RAW('MD5(id)'), $product)->first()->add_on_name;
                        $type = 'a';
                    }
                    return Redirect::to($name.'/'.$type);
                }
            }
            else
            {
                $user = User::where('email', 'LIKE', $email)->first();
                // return json_encode($user).'2';
                if(isset($user)) {
                    if($user->password == md5($password)) { // If their password is still MD5
                        $newPass= Hash::make($password); // Convert to new format
                        DB::table('users')
                            ->where('id', $user->id)
                            ->update(['password' => $newPass]);
                        Auth::loginUsingId($user->id,true);
                    }else{
                        // Redirect to the login page.
                        
                        return Redirect::to('/login')->withErrors(array('password' => 'Email or Password invalid'))->withInput(Request::except('password'));
                    }
                }else {
                    return Redirect::to('/login')->withErrors(array('email' => 'Email or Password invalid'))->withInput(Request::except('password'));
                }
            }

        }

        return Redirect::to("/");
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

        // ===================================================================================================

        return view('auth/login', $data);
    }

    public function doLogout()
    {
        Auth::logout();
        Session::flush();

        return redirect('/');
    }

    public function doLogin()
    {
        $email = Request::input('email');
        $password = Request::input('password');
        $type = Request::input('type');
        $product = Request::input('product');
        // return $email.' '.$password;

        // Try to log the user in.
        if (Auth::attempt(['email' => $email, 'password' => $password]))
        {
            $user = User::where('email', 'LIKE', $email)->first();
            // return json_encode($user).'1';
            // Redirect to homepage
            Session::regenerate();
            Session::put('sesUsername',$user->name);
            Session::put('sesUserEmail',$user->email);
            Session::put('sesUserId',$user->id);
            Session::put('sesUserType', $user->user_type);
            Session::put('sesUserStep', 'cart');
            if($product == '' || $product == null) {
                return redirect()->intended('/');
            }else {
                if($type == 'tile') {
                    $name = Tile::where(DB::RAW('MD5(id)'), $product)->first()->item_name;
                    $type = 't';
                }else {
                    $name = AddOn::where(DB::RAW('MD5(id)'), $product)->first()->add_on_name;
                    $type = 'a';
                }
                return Redirect::to($name.'/'.$type);
            }
        }
        else
        {
            $user = User::where('email', 'LIKE', $email)->first();
            // return json_encode($user).'2';
            if(isset($user)) {
                if($user->password == md5($password)) { // If their password is still MD5
                    $newPass= Hash::make($password); // Convert to new format
                    DB::table('users')
                        ->where('id', $user->id)
                        ->update(['password' => $newPass]);
                    Auth::loginUsingId($user->id,true);
                }else{
                    // Redirect to the login page.
                    
                    return Redirect::to('/login')->withErrors(array('password' => 'Email or Password invalid'))->withInput(Request::except('password'));
                }
            }else {
                return Redirect::to('/login')->withErrors(array('email' => 'Email or Password invalid'))->withInput(Request::except('password'));
            }
        }
    }

    public function resetPass()
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

        // ===================================================================================================

        return view('auth/reset-password', $data);
    }

    public function doResetPass()
    {
        // return Input::all();
        $email = Input::input('email');

        $userExist = User::where('email', $email)->count();
        if($userExist > 0) {
            $pass = str_random(8);
            $hashPass = Hash::make($pass);
            $userModel = User::where('email', $email)->first();
            $name = $userModel->name;
            $userModel->password = $hashPass;
            $userModel->save();

            Mail::to($email)->send(new ResetPassword($pass, $name));

            return Redirect::to('login')->with('reset-msg', 'Password Anda telah ter-reset, silakan cek email untuk mengetahui password baru');
        }else {
            return Redirect::back()->withErrors(['Email tidak terdaftar']);
        }
    }

    public function unauthorized()
    {
        return view('unauthorized');
    }

}