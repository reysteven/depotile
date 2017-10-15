<?php namespace App\Http\Controllers;

use Auth;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

use App\Admin;

class AdminController extends Controller {

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
        $data['admin'] = Admin::all();

        return view('admin/admin-list', $data);
    }

    public function addAdmin()
    {
        // return Input::all();
        $name = Input::input('name');
        $password = Input::input('password');
        $email = Input::input('email');
        $address = Input::input('address');

        $adminModel = new Admin;
        $adminModel->name = $name;
        $adminModel->password = md5($password);
        $adminModel->email = $email;
        $adminModel->address = $address;
        $adminModel->save();

        return Redirect::to('user/admin-manager');
    }

    public function getData()
    {
        $id = Input::input('id');
        $adminModel = Admin::find($id);
        return json_encode($adminModel);
    }

}