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

use App\HeaderTag;
use App\DetailTag;

class TagController extends Controller {

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
        // HeaderTag::withTrashed()->restore();
        $data['tag'] = json_decode(json_encode(HeaderTag::all()),true);
        $detailTag = DetailTag::all();
        for($i=0;$i<sizeof($data['tag']);$i++) {
            $data['tag'][$i]['detail'] = [];
            foreach($detailTag as $d) {
                if($data['tag'][$i]['id'] == $d->header_tag_id) {
                    array_push($data['tag'][$i]['detail'], $d);
                }
            }
        }
        
        return view('tag/tag-list', $data);
    }

    public function addTag()
    {
        // return Input::all();
        $name = Input::input('tag_name');
        $tagModel = new HeaderTag;
        $tagModel->tag_name = $name;
        $tagModel->save();
        return Redirect::to('tag-manager');
    }

    public function editTag()
    {
        $id = Input::input('id');
        $name = Input::input('name');
        $tagModel = HeaderTag::find($id);
        $tagModel->tag_name = $name;
        $tagModel->save();
    }

    public function delTag()
    {
        // return Input::all();
        $data = json_decode(Input::input('data'));
        foreach($data as $d) {
            $id = $d->id;
            $tagModel = HeaderTag::find($id);
            $tagModel->delete();
        }
        return Redirect::to('tag-manager');
    }

    public function addSubTag()
    {
        $id = Input::input('tag_id');
        $subTag = Input::input('sub_tag_name');
        $cta = Input::input('sub_tag_cta');
        $icon = Input::input('curr-img');
        $subtagModel = new DetailTag;
        $subtagModel->header_tag_id = $id;
        $subtagModel->detail_tag_name = $subTag;
        $subtagModel->tag_cta = $cta;
        $subtagModel->icon = $icon;
        $subtagModel->save();
        return Redirect::to('tag-manager');
    }

    public function getSubTag()
    {
        $id = Input::input('id');
        $data = DetailTag::join('header_tags', 'detail_tags.header_tag_id', '=', 'header_tags.id')
                        ->where('detail_tags.id', $id)
                        ->first();
        return json_encode($data);
    }

    public function editSubTag()
    {
        // return Input::all();
        $id = Input::input('sub_tag_id');
        $subTag = Input::input('sub_tag_name');
        $cta = Input::input('sub_tag_cta');
        $icon = Input::input('curr-img');
        $subtagModel = DetailTag::find($id);
        $subtagModel->detail_tag_name = $subTag;
        $subtagModel->tag_cta = $cta;
        $subtagModel->icon = $icon;
        $subtagModel->save();
        return Redirect::to('tag-manager');
    }

    public function delSubTag()
    {
        $id = Input::input('detailId');
        $subtagModel = DetailTag::find($id);
        $subtagModel->delete();
    }

    public function changeShowedTag()
    {
        // return Input::all();
        $tag1 = Input::input('showed_tag_1');
        $tag2 = Input::input('showed_tag_2');
        $allTag = HeaderTag::all();
        foreach($allTag as $d) {
            $d->showed = 0;
            $d->save();
        }
        $headerTagModel = HeaderTag::find($tag1);
        $headerTagModel->showed = 1;
        $headerTagModel->save();
        $headerTagModel = HeaderTag::find($tag2);
        $headerTagModel->showed = 2;
        $headerTagModel->save();
        return Redirect::to('tag-manager');
    }

}