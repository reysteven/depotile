<?php namespace App\Http\Controllers;

use Auth;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller {

	protected function  guard()
    {
    	return Auth::guard('guard-name');
    }

	public function __construct()
	{
		$this->middleware('guest');
	}

	/**
	 * Show the application welcome screen to the user.
	 *
	 * @return Response
	 */
	public function index()
	{
		$data['error'] = '';
		return view('login',$data);
	}

}