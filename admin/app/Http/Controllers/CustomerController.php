<?php namespace App\Http\Controllers;

use Auth;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;

use App\User;

class CustomerController extends Controller {

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
        $data['customer'] = User::all();

        return view('customer/customer-list', $data);
    }

    public function getData()
    {
        $id = Input::input('id');
        $data = User::leftjoin('header_orders', 'users.id', '=', 'header_orders.user_id')
                            ->select(DB::RAW('users.*, COUNT(header_orders.id) as orderCount'))
                            ->find($id);
        $data['customer_since'] = Carbon::createFromFormat('Y-m-d H:i:s', $data['created_at'])->format('d F Y');
        if($data['last_login'] != '0000-00-00 00:00:00') {
            $data['last_visit'] = Carbon::createFromFormat('Y-m-d H:i:s', $data['last_login'])->format('d F Y');
        }else {
            $data['last_visit'] = 'No Record';
        }
        return json_encode($data);
    }

}