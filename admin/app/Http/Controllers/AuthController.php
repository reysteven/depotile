<?php namespace App\Http\Controllers;

use Auth;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

use App\Admin;

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

    public function doLogout()
    {
        Auth::logout();
        Session::flush();

        return redirect('/');
    }

    public function doLogin()
    {
        $email = Request::input('emailadmin');
        $password = Request::input('passwordadmin');
        // return('<script>alert("'.$username.$password.'")</script>');

        // Try to log the user in.
        if (Auth::attempt(['email' => $email, 'password' => $password]))
        {
            $user = Admin::where('email', 'LIKE', $email)->first();
            // return json_encode($user).'1';
            // Redirect to homepage
            Session::regenerate();
            Session::put('sesUsername',$user->name);
            Session::put('sesUserEmail',$user->email);
            Session::put('sesUserId',$user->id);
            Session::put('sesUserType', $user->user_type);
            return redirect()->intended('home');
        }
        else
        {
            $user = Admin::where('email', 'LIKE', $email)->first();
            // return json_encode($user).'2';
            if(isset($user)) {
                if($user->password == md5($password)) { // If their password is still MD5
                    $newPass= Hash::make($password); // Convert to new format
                    DB::table('admins')
                        ->where('id', $user->id)
                        ->update(['password' => $newPass]);
                    Auth::loginUsingId($user->id,true);
                }else{
                    // Redirect to the login page.
                    
                    return Redirect::to('/')->withErrors(array('password' => 'Email or Password invalid'))->withInput(Request::except('password'));
                }
            }else {
                return Redirect::to('/')->withErrors(array('email' => 'Email or Password invalid'))->withInput(Request::except('password'));
            }
        }
    }

}