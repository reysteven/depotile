<?php namespace App\Http\Controllers;

use Auth;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

use App\User;
use App\Tile;
use App\AddOn;
use App\Brand;
use App\HeaderTag;
use App\DetailTag;
use App\HeaderCategory;
use App\DetailCategory;
use App\Setting;
use App\HeaderOrder;
use App\Mail\OrderCheckout;

class HomeController extends Controller {

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
	    // $this->middleware('auth');
	}

    public function getSearchAutocomplete()
    {
        $type = Input::input('type');
        $keyword = Input::input('keyword');
        $keyword = explode(' ', $keyword);
        if($type == 'Tile') {
            $data = Tile::select('item_name');
            foreach($keyword as $d) {
                $data = $data->where('item_name', 'LIKE', '%'.$d.'%');
            }
            $data = $data->groupBy('item_name')->limit(10)->get();
        }else {
            $data = AddOn::select('add_on_name');
            foreach($keyword as $d) {
                $data = $data->where('item_name', 'LIKE', '%'.$d.'%');
            }
            $data = $data->groupBy('add_on_name')->limit(10)->get();
            // $data = AddOn::select('add_on_name')->where('item_name', 'LIKE', '%'.$keyword.'%')->groupBy('add_on_name')->limit(10)->get();
        }
        return json_encode($data);
    }

    public function index()
    {
        // Auth::logout();
        // Session::flush();
        // Session::forget('cart');
        // return Session::all();

        // Mail::to('reysteven16@gmail.com')->send(new OrderCheckout());

        // HEADER DATA
        // -----------

        $data['brand_order_by'] = Setting::where('name', 'LIKE', 'brand order by')->first()->value;
        $data['item'] = Tile::select(DB::RAW('tiles.*, MD5(id) as itemId'))->limit(6)->get();
        $data['brand'] = Brand::orderBy($data['brand_order_by'])->get();
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

        $data['alltag'] = json_decode(json_encode(HeaderTag::all()), true);
        $detailTag = DetailTag::join('header_tags', 'detail_tags.header_tag_id', '=', 'header_tags.id')->get();
        for($i=0;$i<sizeof($data['alltag']);$i++) {
            $data['alltag'][$i]['detail'] = [];
            foreach($detailTag as $d) {
                if($d->header_tag_id == $data['alltag'][$i]['id']) {
                    array_push($data['alltag'][$i]['detail'], $d);
                }
            }
        }
        // return $data['alltag'];

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

        $data['project'] = HeaderTag::join('detail_tags', 'header_tags.id', '=', 'detail_tags.header_tag_id')
                                    ->select('detail_tags.detail_tag_name', 'detail_tags.icon')
                                    ->where('header_tags.tag_name', 'proyek')
                                    ->take(5)
                                    ->get();

        // ===================================================================================================

        return view('home/home', $data);
    }

    function getNextItemSliding()
    {
        $count = Input::input('count');
        $data = Tile::select(DB::RAW('tiles.*, MD5(id) as itemId'))->skip(6+$count)->limit(1)->get();
        return json_encode($data);
    }

}