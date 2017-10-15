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

use App\HeaderNavigation;
use App\DetailNavigation;
use App\HeaderTag;
use App\DetailTag;

class NavigationController extends Controller {

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
        // HeaderNavigation::withTrashed()->restore();

        // GET NAVIGATION DATA
        // -------------------
        $data['navigation'] = HeaderNavigation::all();

        // GET TAGS DATA
        // -------------
        $data['tag'] = json_decode(json_encode(HeaderTag::all()),true);
        $detailTag = DetailTag::all();
        for($i=0;$i<sizeof($data['tag']);$i++) {
            $data['tag'][$i]['detail_tag'] = [];
            foreach($detailTag as $d) {
                if($d->header_tag_id == $data['tag'][$i]['id']) {
                    array_push($data['tag'][$i]['detail_tag'], $d->detail_tag_name);
                }
            }
        }
        // return $data;

        return view('navigation/navigation-list', $data);
    }

    public function addNavigation()
    {
        // return Input::all();
        $name = Input::input('name');
        $relation = Input::input('relation');
        $img = Input::input('curr-img');
        $headerTag = Input::input('header-tag');
        $detailTag = Input::input('detail-tag');

        $headerModel = new HeaderNavigation;
        $headerModel->navigation_name = $name;
        $headerModel->relation = $relation;
        $headerModel->img_name = $img;
        $headerModel->save();

        $headerId = $headerModel->id;

        for($i=0;$i<sizeof($headerTag);$i++) {
            $detailTagId = HeaderTag::join('detail_tags', 'header_tags.id', '=', 'detail_tags.header_tag_id')
                                    ->select('detail_tags.id')
                                    ->where('tag_name', 'LIKE', $headerTag[$i])
                                    ->where('detail_tag_name', 'LIKE', $detailTag[$i])
                                    ->first()->id;
            $detailTagModel = new DetailNavigation;
            $detailTagModel->header_navigation_id = $headerId;
            $detailTagModel->detail_tag_id = $detailTagId;
            $detailTagModel->save();
        }

        return Redirect::to('navigation-manager');
    }

    public function getData()
    {
        $id = Input::input('id');
        $navigation = json_decode(json_encode(HeaderNavigation::find($id)),true);
        $detailNavigation = DetailNavigation::join('detail_tags', 'detail_navigations.detail_tag_id', '=', 'detail_tags.id')
                                            ->join('header_tags', 'detail_tags.header_tag_id', '=', 'header_tags.id')
                                            ->where('header_navigation_id', $id)
                                            ->get();
        $navigation['detail_navigation'] = [];
        foreach($detailNavigation as $d) {
            array_push($navigation['detail_navigation'], $d);
        }
        return json_encode($navigation);
    }

    public function editNavigation()
    {
        // return Input::all();
        $id = Input::input('id');
        $name = Input::input('name');
        $relation = Input::input('relation');
        $img = Input::input('curr-img');
        $headerTag = Input::input('header-tag');
        $detailTag = Input::input('detail-tag');

        $headerModel = HeaderNavigation::find($id);
        $headerModel->navigation_name = $name;
        $headerModel->relation = $relation;
        $headerModel->img_name = $img;
        $headerModel->save();

        $detailModel = DetailNavigation::where('header_navigation_id', $id)->get();
        foreach($detailModel as $d) {
            $d->forceDelete();
        }

        for($i=0;$i<sizeof($headerTag);$i++) {
            $detailTagId = HeaderTag::join('detail_tags', 'header_tags.id', '=', 'detail_tags.header_tag_id')
                                    ->select('detail_tags.id')
                                    ->where('tag_name', 'LIKE', $headerTag[$i])
                                    ->where('detail_tag_name', 'LIKE', $detailTag[$i])
                                    ->first()->id;
            $detailTagModel = new DetailNavigation;
            $detailTagModel->header_navigation_id = $id;
            $detailTagModel->detail_tag_id = $detailTagId;
            $detailTagModel->save();
        }

        return Redirect::to('navigation-manager');
    }

    public function delNavigation()
    {
        // return Input::all();
        $data = json_decode(Input::input('data'));
        foreach($data as $d) {
            $navModel = HeaderNavigation::find($d->id);
            $navModel->delete();
        }
        return Redirect::to('navigation-manager');
    }

}