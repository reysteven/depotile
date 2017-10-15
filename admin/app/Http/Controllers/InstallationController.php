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

use App\Installation;

class InstallationController extends Controller {

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
    	// Installation::withTrashed()->restore();

        // AMBIL DATA INSTALLATION
        // -----------------------
    	$data['installation'] = Installation::orderBy('id', 'DESC')->orderBy('created_at', 'DESC')->get();

        // return $data;

    	return view('installation/installation-list', $data);
    }

    public function getData()
    {
        $id = Input::input('installation-id');

        $data = Installation::find($id);

        return json_encode($data);
    }

    public function addInstallation()
    {
        // return Input::all();
        $name = Input::input('installation_name');
        $desc = Input::input('installation_desc');

        $installationModel = new Installation;
        $installationModel->installation_name = $name;
        $installationModel->installation_desc = $desc;
        $installationModel->save();

        return Redirect::back();
    }

    public function editInstallation()
    {
        // return Input::all();
        $id = Input::input('installation_id');
        $name = Input::input('installation_name');
        $desc = Input::input('installation_desc');

        $installationModel = Installation::find($id);
        $installationModel->installation_name = $name;
        $installationModel->installation_desc = $desc;
        $installationModel->save();

        return Redirect::back();
    }

    public function delInstallation()
    {
        // return Input::all();
        $data = json_decode(Input::input('data'));
        foreach($data as $d) {
            $installationModel = Installation::find($d->id);
            $installationModel->delete();
        }
        return Redirect::back();
    }

}