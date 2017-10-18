<?php namespace App\Http\Controllers;

use Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;

use App\User;
use App\Tile;
use App\AddOn;
use App\Brand;
use App\Province;
use App\City;
use App\HeaderTag;
use App\DetailTag;
use App\HeaderCategory;
use App\DetailCategory;
use App\HeaderNavigation;
use App\DetailNavigation;
use App\HeaderFee;
use App\DetailFee;
use App\Setting;

class ProductController extends Controller {

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

    public function search($page)
    {
        // return Input::all();
        $type = Input::input('type');
        $data['menu'] = 'search';
        $data['type'] = $type;
        $data['subtype'] = 'search result';
        $data['page'] = $page;
        if(Input::input('s') !== null) {
            $data['s'] = Input::input('s');
        }else {
            $data['s'] = 3;
        }
        if(Input::input('pg') !== null) {
            $data['pg'] = (Input::input('pg') == '' || Input::input('pg') == null) ? 20 : Input::input('pg');
        }else {
            $data['pg'] = 20;
        }
        $data['adv_category'] = '';
        $data['adv_project'] = '';
        $data['adv_color'] = '';
        $data['adv_price'] = '';
        $data['adv_brand'] = '';

        // HEADER DATA
        // -----------

        $data['brand_order_by'] = Setting::where('name', 'LIKE', 'brand order by')->first()->value;
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
        $detailTag = DetailTag::join('header_tags', 'detail_tags.header_tag_id', '=', 'header_tags.id')
                            ->select(DB::RAW('detail_tags.*'))
                            ->get();
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
                                        ->select(DB::RAW('detail_categories.*'))
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
        // return $data['category'];

        $data['acc'] = DetailCategory::join('header_categories', 'detail_categories.header_category_id', '=', 'header_categories.id')
                                        ->where('header_categories.id', '1')
                                        ->get();

        // ===================================================================================================

        if($type == 'all_search') {
            // return Input::all();
            $type = Input::input('item_type');
            $keyword = Input::input('keyword');

            if($type == 'Tile') {
                $tile = Tile::where('item_name', 'LIKE', '%'.$keyword.'%');
                if(isset($data['s'])) {
                    if($data['s'] == 3) {
                        $tile = $tile->orderby('tiles.item_name');
                    }else if($data['s'] == 4) {
                        $tile = $tile->orderby('tiles.price_per_m2', 'ASC');
                    }else if($data['s'] == 5) {
                        $tile = $tile->orderby('tiles.price_per_m2', 'DESC');
                    }
                }else {
                    $tile = $tile->orderby('tiles.item_name');
                }
                $tile = $tile->get();
                // return $tile;

                $data['item'] = [];
                $skipcount = 0;
                $takecount = 0;
                foreach($tile as $d) {
                    if($skipcount >= ($page-1)*$data['pg']) {
                        array_push($data['item'], $d);
                        $takecount++;
                    }
                    $skipcount++;
                    if($takecount >= $data['pg']) {
                        break;
                    }
                }
                // return $data['item'];
            }else {
                $addon = AddOn::where('add_on_name', 'LIKE', '%'.$keyword.'%');
                if(isset($data['s'])) {
                    if($data['s'] == 3) {
                        $addon = $addon->orderby('add_ons.add_on_name');
                    }else if($data['s'] == 4) {
                        $addon = $addon->orderby('add_ons.price_per_pc', 'ASC');
                    }else if($data['s'] == 5) {
                        $addon = $addon->orderby('add_ons.price_per_pc', 'DESC');
                    }
                }else {
                    $addon = $addon->orderby('add_ons.add_on_name');
                }
                $addon = $addon->get();
                // return $addon;

                $data['item'] = [];
                $skipcount = 0;
                $takecount = 0;
                foreach($addon as $d) {
                    if($skipcount >= ($page-1)*$data['pg']) {
                        array_push($data['item'], $d);
                        $takecount++;
                    }
                    $skipcount++;
                    if($takecount >= $data['pg']) {
                        break;
                    }
                }
                $tile = json_decode(json_encode($addon));
                // return $data['item'];
            }
        }else {
            $category = Input::input('category');
            $project = Input::input('project');
            $color = Input::input('color');
            $price = Input::input('price');
            $brand = Input::input('brand');
            $data['adv_category'] = $category;
            $data['adv_project'] = $project;
            $data['adv_color'] = $color;
            $data['adv_price'] = $price;
            $data['adv_brand'] = $brand;
            $tile = Tile::join('detail_categories', 'tiles.detail_category_id', '=', 'detail_categories.id')
                        ->join('header_categories', 'detail_categories.header_category_id', '=', 'header_categories.id')
                        ->join('brands', 'tiles.brand_id', '=', 'brands.id')
                        ->select(DB::RAW('tiles.*, detail_categories.*, header_categories.*, brands.*, tiles.id as tileId, md5(tiles.id) as itemId, tiles.calculator as calc, detail_categories.id as detailId, header_categories.id as headerId, brands.id as brandId'));
            // return $tile->get();

            if($category != '0') {
                if(explode('_', $category)[0] == 'c') {
                    $tile = $tile->where('header_categories.id', explode('_', $category)[1]);
                }else {
                    $tile = $tile->where('detail_categories.id', explode('_', $category)[1]);
                }
            }
            if($brand != '0') {
                $tile = $tile->where('brands.id', $brand);
            }
            if(isset($data['s'])) {
                if($data['s'] == 3) {
                    $tile = $tile->orderby('tiles.item_name');
                }else if($data['s'] == 4) {
                    $tile = $tile->orderby('tiles.price_per_m2', 'ASC');
                }else if($data['s'] == 5) {
                    $tile = $tile->orderby('tiles.price_per_m2', 'DESC');
                }
            }else {
                $tile = $tile->orderby('tiles.item_name');
            }
            $tile = $tile->get();
            if($project != '0') {
                $temp = json_decode(json_encode($tile));
                $tile = [];
                foreach($temp as $d) {
                    $tagdata = json_decode($d->detail_tag_data);
                    foreach($tagdata as $dd) {
                        if($dd->header_tag_id == 1 && $dd->detail_tag_id == $project) {
                            array_push($tile, $d);
                            break;
                        }
                    }
                }
            }
            if($color != '0') {
                $temp = json_decode(json_encode($tile));
                $tile = [];
                foreach($temp as $d) {
                    $tagdata = json_decode($d->detail_tag_data);
                    foreach($tagdata as $dd) {
                        if($dd->header_tag_id == 2 && $dd->detail_tag_id == $color) {
                            array_push($tile, $d);
                            break;
                        }
                    }
                }
            }
            if($price != '0') {
                $temp = json_decode(json_encode($tile));
                $tile = [];
                foreach($temp as $d) {
                    $tagdata = json_decode($d->detail_tag_data);
                    foreach($tagdata as $dd) {
                        if($dd->header_tag_id == 3 && $dd->detail_tag_id == $price) {
                            array_push($tile, $d);
                            break;
                        }
                    }
                }
            }
            // return $tile;

            $data['item'] = [];
            $skipcount = 0;
            $takecount = 0;
            foreach($tile as $d) {
                if($skipcount >= ($page-1)*$data['pg']) {
                    array_push($data['item'], $d);
                    $takecount++;
                }
                $skipcount++;
                if($takecount >= $data['pg']) {
                    break;
                }
            }
            // return $data['item'];
        }
        $data['paging'] = ceil(sizeof($tile) / $data['pg']);

        return view('product/productCategory', $data);
    }

    public function getList($menu, $type, $subtype, $page)
    {
        $data['menu'] = $menu;
        $data['type'] = $type;
        $data['subtype'] = $subtype;
        if($menu == 'style') {
            $data['selectedTag'] = HeaderTag::join('detail_tags', 'header_tags.id', '=', 'detail_tags.header_tag_id')
                                            ->where('tag_name', $type)
                                            ->where('detail_tag_name', $subtype)
                                            ->first();
        }
        $data['page'] = $page;
        if(Input::input('s') !== null) {
            $data['s'] = Input::input('s');
        }else {
            $data['s'] = 3;
        }
        if(Input::input('pg') !== null) {
            $data['pg'] = (Input::input('pg') == '' || Input::input('pg') == null) ? 20 : Input::input('pg');
        }else {
            $data['pg'] = 20;
        }
        $data['adv_category'] = '';
        $data['adv_project'] = '';
        $data['adv_color'] = '';
        $data['adv_price'] = '';
        $data['adv_brand'] = '';
        // return $data;

        // HEADER DATA
        // -----------

        $data['brand_order_by'] = Setting::where('name', 'LIKE', 'brand order by')->first()->value;
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
        $detailTag = DetailTag::join('header_tags', 'detail_tags.header_tag_id', '=', 'header_tags.id')
                            ->select(DB::RAW('detail_tags.*'))
                            ->get();
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
                                        ->select(DB::RAW('detail_categories.*'))
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
        // return $data['category'];

        $data['acc'] = DetailCategory::join('header_categories', 'detail_categories.header_category_id', '=', 'header_categories.id')
                                        ->where('header_categories.id', '1')
                                        ->get();

        // ===================================================================================================

        if($type != 'Aksesoris') {
            $itemData = Tile::join('detail_categories', 'tiles.detail_category_id', '=', 'detail_categories.id')
                            ->join('header_categories', 'detail_categories.header_category_id', '=', 'header_categories.id')
                            ->select(DB::RAW('tiles.*, category_name, detail_category_name, MD5(tiles.id) as itemId'));
            if(isset($data['s'])) {
                if($data['s'] == 3) {
                    $itemData = $itemData->orderby('tiles.item_name');
                }else if($data['s'] == 4) {
                    $itemData = $itemData->orderby('tiles.price_per_m2', 'ASC');
                }else if($data['s'] == 5) {
                    $itemData = $itemData->orderby('tiles.price_per_m2', 'DESC');
                }
            }else {
                $itemData = $itemData->orderby('tiles.item_name');
            }
        }else {
            $itemData = AddOn::join('detail_categories', 'add_ons.type', '=', 'detail_categories.id')
                            ->join('header_categories', 'detail_categories.header_category_id', '=', 'header_categories.id')
                            ->select(DB::RAW('add_ons.*, category_name, detail_category_name, MD5(add_ons.id) as itemId'));
            if(isset($data['s'])) {
                if($data['s'] == 3) {
                    $itemData = $itemData->orderby('add_ons.add_on_name');
                }else if($data['s'] == 4) {
                    $itemData = $itemData->orderby('add_ons.price_per_pcs', 'ASC');
                }else if($data['s'] == 5) {
                    $itemData = $itemData->orderby('add_ons.price_per_pcs', 'DESC');
                }
            }else {
                $itemData = $itemData->orderby('add_ons.add_on_name');
            }
        }

        if($menu == 'style') {
            $typeId = HeaderTag::where('tag_name', $type)->first()->id;
            if($typeId == 1) {
                $data['adv_project'] = HeaderTag::join('detail_tags', 'header_tags.id', '=', 'detail_tags.header_tag_id')
                                                ->select('detail_tags.id')
                                                ->where('tag_name', $type)
                                                ->where('detail_tag_name', $subtype)
                                                ->first()->id;
            }else if($typeId == 2) {
                $data['adv_color'] = HeaderTag::join('detail_tags', 'header_tags.id', '=', 'detail_tags.header_tag_id')
                                                ->select('detail_tags.id')
                                                ->where('tag_name', $type)
                                                ->where('detail_tag_name', $subtype)
                                                ->first()->id;
            }else if($typeId == 3) {
                $data['adv_price'] = HeaderTag::join('detail_tags', 'header_tags.id', '=', 'detail_tags.header_tag_id')
                                                ->select('detail_tags.id')
                                                ->where('tag_name', $type)
                                                ->where('detail_tag_name', $subtype)
                                                ->first()->id;
            }
            $data['navigation'] = HeaderNavigation::join('detail_navigations', 'header_navigations.id', '=', 'detail_navigations.header_navigation_id')
                                                ->join('detail_tags', 'detail_navigations.detail_tag_id', '=', 'detail_tags.id')
                                                ->join('header_tags', 'detail_tags.header_tag_id', '=', 'header_tags.id')
                                                ->select('header_navigations.id', 'navigation_name', 'img_name')
                                                ->where('tag_name', 'LIKE', $type)
                                                ->where('detail_tag_name', 'LIKE', $subtype)
                                                ->get();

            $itemtemp = [];
            $itemData = $itemData->get();
            foreach($itemData as $d) {
                $tagData = json_decode($d->detail_tag_data);
                foreach($tagData as $dd) {
                    if($dd->tag_name == $type && $dd->detail_tag_name == $subtype) {
                        array_push($itemtemp, $d);
                        break;
                    }
                }
            }
            $data['item'] = [];
            $skipcount = 0;
            $takecount = 0;
            foreach($itemtemp as $d) {
                if($skipcount >= ($page-1)*$data['pg']) {
                    array_push($data['item'], $d);
                    $takecount++;
                }
                $skipcount++;
                if($takecount >= $data['pg']) {
                    break;
                }
            }
            // return $data['item'];

            $data['paging'] = ceil(sizeof($itemtemp) / $data['pg']);
        }else if($menu == 'collection') {
            if($type != 'Aksesoris') {
                $data['adv_category'] = 'dc_'.HeaderCategory::join('detail_categories', 'header_categories.id', '=', 'detail_categories.header_category_id')
                                                    ->select('detail_categories.id')
                                                    ->where('detail_categories.detail_category_name', $subtype)
                                                    ->first()->id;
            }
            $itemtemp = [];
            $itemData = $itemData->get();
            foreach($itemData as $d) {
                if($d->category_name == $type && $d->detail_category_name == $subtype) {
                    array_push($itemtemp, $d);
                }
            }
            $data['item'] = [];
            $skipcount = 0;
            $takecount = 0;
            foreach($itemtemp as $d) {
                if($skipcount >= ($page-1)*$data['pg']) {
                    array_push($data['item'], $d);
                    $takecount++;
                }
                $skipcount++;
                if($takecount >= $data['pg']) {
                    break;
                }
            }
            // return $data['item'];

            $data['paging'] = ceil(sizeof($itemtemp) / $data['pg']);
        }

        return view('product/productCategory', $data);
    }

    public function getNavigation($name, $page)
    {
        $data['menu'] = 'navigation';
        $data['type'] = $name;
        $data['subtype'] = $name;
        $data['name'] = $name;
        $data['page'] = $page;
        if(Input::input('s') !== null) {
            $data['s'] = Input::input('s');
        }else {
            $data['s'] = 3;
        }
        if(Input::input('pg') !== null && Input::input('pg') != '' && Input::input('pg') != null) {
            $data['pg'] = Input::input('pg');
        }else {
            $data['pg'] = 20;
        }
        // return $data;

        // HEADER DATA
        // -----------

        $data['brand_order_by'] = Setting::where('name', 'LIKE', 'brand order by')->first()->value;
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
        $detailTag = DetailTag::join('header_tags', 'detail_tags.header_tag_id', '=', 'header_tags.id')
                            ->select(DB::RAW('detail_tags.*'))
                            ->get();
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
                                        ->select(DB::RAW('detail_categories.*'))
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
        // return $data;

        $data['adv_category'] = '';
        $data['adv_project'] = '';
        $data['adv_color'] = '';
        $data['adv_price'] = '';
        $data['adv_brand'] = '';

        $navigation = HeaderNavigation::join('detail_navigations', 'header_navigations.id', '=', 'detail_navigations.header_navigation_id')
                                    ->join('detail_tags', 'detail_navigations.detail_tag_id', '=', 'detail_tags.id')
                                    ->join('header_tags', 'detail_tags.header_tag_id', '=', 'header_tags.id')
                                    ->where('navigation_name', $data['name'])
                                    ->get();
        foreach($navigation as $d) {
            if($d->header_tag_id == 1) {
                $data['adv_project'] = $d->detail_tag_id;
            }else if($d->header_tag_id == 2) {
                $data['adv_color'] = $d->detail_tag_id;
            }else if($d->header_tag_id == 3) {
                $data['adv_price'] = $d->detail_tag_id;
            }
        }

        $itemData = Tile::join('detail_categories', 'tiles.detail_category_id', '=', 'detail_categories.id')
                        ->join('header_categories', 'detail_categories.header_category_id', '=', 'header_categories.id')
                        ->select(DB::RAW('tiles.*, category_name, detail_category_name, MD5(tiles.id) as itemId'));
        if(isset($data['s'])) {
            if($data['s'] == 3) {
                $itemData = $itemData->orderby('tiles.item_name');
            }else if($data['s'] == 4) {
                $itemData = $itemData->orderby('tiles.price_per_m2', 'ASC');
            }else if($data['s'] == 5) {
                $itemData = $itemData->orderby('tiles.price_per_m2', 'DESC');
            }
        }else {
            $itemData = $itemData->orderby('tiles.item_name');
        }
        $itemtemp = [];
        $itemData = $itemData->get();
        foreach($itemData as $d) {
            $tagData = json_decode($d->detail_tag_data);
            foreach($tagData as $dd) {
                $valid = false;
                foreach($navigation as $ddd) {
                    if($dd->tag_name == $ddd->tag_name && $dd->detail_tag_name == $ddd->detail_tag_name) {
                        array_push($itemtemp, $d);
                        $valid = true;
                        break;
                    }
                }
                if($valid == true) {
                    break;
                }
            }
        }
        $data['item'] = [];
        $skipcount = 0;
        $takecount = 0;
        foreach($itemtemp as $d) {
            if($skipcount >= ($page-1)*$data['pg']) {
                array_push($data['item'], $d);
                $takecount++;
            }
            $skipcount++;
            if($takecount >= $data['pg']) {
                break;
            }
        }
        // return $data['item'];

        $data['paging'] = ceil(sizeof($itemtemp) / $data['pg']);

        return view('product/productCategory', $data);
    }

    public function getProduct($name, $type)
    {
        // return $name.' '.$type;
        // Session::forget('cart');

        $name = preg_replace('/_/', ' ', $name);

        if($type == 't') {

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

            $data['item'] = Tile::join('brands', 'tiles.brand_id', '=', 'brands.id')
                                ->join('detail_categories', 'tiles.detail_category_id', '=', 'detail_categories.id')
                                ->join('header_categories', 'detail_categories.header_category_id', '=', 'header_categories.id')
                                ->join('installations', 'tiles.installation_id', '=', 'installations.id')
                                ->leftjoin('add_ons', 'tiles.add_on_1', '=', 'add_ons.id')
                                ->select(DB::RAW('tiles.*, brands.*, detail_categories.*, header_categories.category_name, installations.*, add_ons.id as addonid, add_ons.img_name, MD5(tiles.id) as itemId, tiles.description as itemDesc'))
                                ->where('tiles.item_name', $name)->first();

            $feeData = HeaderFee::join('detail_fees', 'header_fees.id', '=', 'detail_fees.header_fee_id')
                                    ->join('tiles', 'header_fees.id', '=', 'tiles.header_fee_id')
                                    ->join('cities', 'detail_fees.city_id', 'cities.id')
                                    ->join('provinces', 'cities.province_id', '=', 'provinces.id')
                                    ->select(DB::RAW('detail_fees.*, cities.city_name, provinces.province_name'))
                                    ->where('tiles.item_name', $name)
                                    ->orderby('city_id', 'ASC')
                                    ->orderby('quantity_above', 'ASC')
                                    ->get();
            $data['fee'] = [];
            foreach($feeData as $d) {
                if($d->quantity_above >= 1000000) {
                    $data['fee'][$d->province_name][$d->city_name]['LEBIH BESAR DARI '.$d->quantity_below] = $d->fee_value;
                }else {
                    $data['fee'][$d->province_name][$d->city_name][$d->quantity_below.' - '.$d->quantity_above] = $d->fee_value;
                }
            }
            // return $data['fee'];

            $allTile = Tile::select(DB::RAW('tiles.*, MD5(id) as itemId'))->get();
            $data['other'] = [];
            $allOther = [];
            foreach($allTile as $d) {
                $item = $data['item'];
                $price_margin = intval($item->price_per_m2 * 0.2);
                $tagData = json_decode($item['detail_tag_data']);
                $currTagData = json_decode($d->detail_tag_data);
                $match = 0;
                foreach($currTagData as $dd) {
                    foreach($tagData as $ddd) {
                        if($dd->header_tag_id == $ddd->header_tag_id && $dd->detail_tag_id == $ddd->detail_tag_id) {
                            $match++;
                            break;
                        }
                    }
                }
                if($match > 0 && 
                    $d->length == $item->length && 
                    $d->width == $item->width &&
                    $d->price_per_m2 <= $item->price_per_m2 + $price_margin &&
                    $d->price_per_m2 >= $item->price_per_m2 - $price_margin &&
                    $d->detail_category_id == $item->detail_category_id) 
                {
                    $array = [
                        "data" => $d,
                        "n" => $match
                    ];
                    array_push($allOther, $array);
                }
            }
            
            $flag = false;
            while($flag == false) {
                $flag = true;
                for($i=0;$i<sizeof($allOther)-1;$i++) {
                    if($allOther[$i]["n"] < $allOther[$i+1]["n"]) {
                        $temp = $allOther[$i];
                        $allOther[$i] = $allOther[$i+1];
                        $allOther[$i+1] = $temp;
                    }
                }
            }

            for($i=0;$i<6;$i++) {
                array_push($data['other'], $allOther[$i]["data"]);
            }
            
            // return $data['other'];
            return view('product/productDetail', $data);

        }else {

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

            $data['item'] = AddOn::join('brands', 'add_ons.brand', '=', 'brands.id')
                                ->join('detail_categories', 'add_ons.type', '=', 'detail_categories.id')
                                ->join('header_categories', 'detail_categories.header_category_id', '=', 'header_categories.id')
                                ->select(DB::RAW('add_ons.*, brands.*, detail_categories.*, header_categories.category_name, add_ons.description as itemDesc, MD5(add_ons.id) as itemId'))
                                ->where('add_ons.add_on_name', $name)->first();

            $feeData = HeaderFee::join('detail_fees', 'header_fees.id', '=', 'detail_fees.header_fee_id')
                                    ->join('add_ons', 'header_fees.id', '=', 'add_ons.header_fee_id')
                                    ->join('cities', 'detail_fees.city_id', 'cities.id')
                                    ->join('provinces', 'cities.province_id', '=', 'provinces.id')
                                    ->select(DB::RAW('detail_fees.*, cities.city_name, provinces.province_name'))
                                    ->where('add_ons.add_on_name', $name)
                                    ->orderby('city_id', 'ASC')
                                    ->orderby('quantity_above', 'ASC')
                                    ->get();
            $data['fee'] = [];
            foreach($feeData as $d) {
                if($d->quantity_above >= 1000000) {
                    $data['fee'][$d->province_name][$d->city_name]['> 300'] = $d->fee_value;
                }else {
                    $data['fee'][$d->province_name][$d->city_name][$d->quantity_below.' - '.$d->quantity_above] = $d->fee_value;
                }
            }
            // return $data['fee'];

            $data['other'] = AddOn::select(DB::RAW('add_ons.*, MD5(id) as itemId'))->get();
            // $data['other'] = [];
            // foreach($allTile as $d) {
            //     $tagData = json_decode($data['item']['detail_tag_data']);
            //     $currTagData = json_decode($d->detail_tag_data);
            //     foreach($currTagData as $dd) {
            //         $valid = false;
            //         foreach($tagData as $ddd) {
            //             if($dd->header_tag_id == $ddd->header_tag_id && $dd->detail_tag_id == $ddd->detail_tag_id) {
            //                 array_push($data['other'], $d);
            //                 $valid = true;
            //                 break;
            //             }
            //         }
            //         if($valid == true) {
            //             break;
            //         }
            //     }
            // }
            // if(sizeof($data['other']) < 6) {
            //     foreach($allTile as $d) {
            //         $valid = true;
            //         foreach($data['other'] as $dd) {
            //             if($d->id == $dd->id) {
            //                 $valid = false;
            //                 break;
            //             }
            //         }
            //         if($valid == true) {
            //             array_push($data['other'], $d);
            //         }
            //         if(sizeof($data['other']) >= 6) {
            //             break;
            //         }
            //     }
            // }
            // return $data['other'];
            return view('product/addonDetail', $data);

        }
    }

    public function getTile($id)
    {
        // Session::forget('cart');
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

        $data['item'] = Tile::join('brands', 'tiles.brand_id', '=', 'brands.id')
                            ->join('detail_categories', 'tiles.detail_category_id', '=', 'detail_categories.id')
                            ->join('header_categories', 'detail_categories.header_category_id', '=', 'header_categories.id')
                            ->join('installations', 'tiles.installation_id', '=', 'installations.id')
                            ->leftjoin('add_ons', 'tiles.add_on_1', '=', 'add_ons.id')
                            ->select(DB::RAW('tiles.*, brands.*, detail_categories.*, header_categories.category_name, installations.*, add_ons.id as addonid, add_ons.img_name, MD5(tiles.id) as itemId, tiles.description as itemDesc'))
                            ->where(DB::RAW("MD5(tiles.id)"), $id)->first();

        $feeData = HeaderFee::join('detail_fees', 'header_fees.id', '=', 'detail_fees.header_fee_id')
                                ->join('tiles', 'header_fees.id', '=', 'tiles.header_fee_id')
                                ->join('cities', 'detail_fees.city_id', 'cities.id')
                                ->join('provinces', 'cities.province_id', '=', 'provinces.id')
                                ->select(DB::RAW('detail_fees.*, cities.city_name, provinces.province_name'))
                                ->where(DB::RAW('MD5(tiles.id)'), $id)
                                ->orderby('city_id', 'ASC')
                                ->orderby('quantity_above', 'ASC')
                                ->get();
        $data['fee'] = [];
        foreach($feeData as $d) {
            if($d->quantity_above >= 1000000) {
                $data['fee'][$d->province_name][$d->city_name]['LEBIH BESAR DARI '.$d->quantity_below] = $d->fee_value;
            }else {
                $data['fee'][$d->province_name][$d->city_name][$d->quantity_below.' - '.$d->quantity_above] = $d->fee_value;
            }
        }
        // return $data['fee'];

        $allTile = Tile::select(DB::RAW('tiles.*, MD5(id) as itemId'))->get();
        $data['other'] = [];
        $allOther = [];
        foreach($allTile as $d) {
            $item = $data['item'];
            $price_margin = intval($item->price_per_m2 * 0.2);
            $tagData = json_decode($item['detail_tag_data']);
            $currTagData = json_decode($d->detail_tag_data);
            $match = 0;
            foreach($currTagData as $dd) {
                foreach($tagData as $ddd) {
                    if($dd->header_tag_id == $ddd->header_tag_id && $dd->detail_tag_id == $ddd->detail_tag_id) {
                        $match++;
                        break;
                    }
                }
            }
            if($match > 0 && 
                $d->length == $item->length && 
                $d->width == $item->width &&
                $d->price_per_m2 <= $item->price_per_m2 + $price_margin &&
                $d->price_per_m2 >= $item->price_per_m2 - $price_margin &&
                $d->detail_category_id == $item->detail_category_id) 
            {
                $array = [
                    "data" => $d,
                    "n" => $match
                ];
                array_push($allOther, $array);
            }
        }
        
        $flag = false;
        while($flag == false) {
            $flag = true;
            for($i=0;$i<sizeof($allOther)-1;$i++) {
                if($allOther[$i]["n"] < $allOther[$i+1]["n"]) {
                    $temp = $allOther[$i];
                    $allOther[$i] = $allOther[$i+1];
                    $allOther[$i+1] = $temp;
                }
            }
        }

        for($i=0;$i<6;$i++) {
            array_push($data['other'], $allOther[$i]["data"]);
        }
        
        // return $data['other'];

        return view('product/productDetail', $data);
    }

    public function getAddon($id)
    {
        // Session::forget('cart');
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

        $data['item'] = AddOn::join('brands', 'add_ons.brand', '=', 'brands.id')
                            ->join('detail_categories', 'add_ons.type', '=', 'detail_categories.id')
                            ->join('header_categories', 'detail_categories.header_category_id', '=', 'header_categories.id')
                            ->select(DB::RAW('add_ons.*, brands.*, detail_categories.*, header_categories.category_name, add_ons.description as itemDesc, MD5(add_ons.id) as itemId'))
                            ->where(DB::RAW("MD5(add_ons.id)"), $id)->first();

        $feeData = HeaderFee::join('detail_fees', 'header_fees.id', '=', 'detail_fees.header_fee_id')
                                ->join('tiles', 'header_fees.id', '=', 'tiles.header_fee_id')
                                ->join('cities', 'detail_fees.city_id', 'cities.id')
                                ->join('provinces', 'cities.province_id', '=', 'provinces.id')
                                ->select(DB::RAW('detail_fees.*, cities.city_name, provinces.province_name'))
                                ->where(DB::RAW('MD5(tiles.id)'), $id)
                                ->orderby('city_id', 'ASC')
                                ->orderby('quantity_above', 'ASC')
                                ->get();
        $data['fee'] = [];
        foreach($feeData as $d) {
            if($d->quantity_above >= 1000000) {
                $data['fee'][$d->province_name][$d->city_name]['> 300'] = $d->fee_value;
            }else {
                $data['fee'][$d->province_name][$d->city_name][$d->quantity_below.' - '.$d->quantity_above] = $d->fee_value;
            }
        }
        // return $data['fee'];

        $data['other'] = AddOn::select(DB::RAW('add_ons.*, MD5(id) as itemId'))->get();
        // $data['other'] = [];
        // foreach($allTile as $d) {
        //     $tagData = json_decode($data['item']['detail_tag_data']);
        //     $currTagData = json_decode($d->detail_tag_data);
        //     foreach($currTagData as $dd) {
        //         $valid = false;
        //         foreach($tagData as $ddd) {
        //             if($dd->header_tag_id == $ddd->header_tag_id && $dd->detail_tag_id == $ddd->detail_tag_id) {
        //                 array_push($data['other'], $d);
        //                 $valid = true;
        //                 break;
        //             }
        //         }
        //         if($valid == true) {
        //             break;
        //         }
        //     }
        // }
        // if(sizeof($data['other']) < 6) {
        //     foreach($allTile as $d) {
        //         $valid = true;
        //         foreach($data['other'] as $dd) {
        //             if($d->id == $dd->id) {
        //                 $valid = false;
        //                 break;
        //             }
        //         }
        //         if($valid == true) {
        //             array_push($data['other'], $d);
        //         }
        //         if(sizeof($data['other']) >= 6) {
        //             break;
        //         }
        //     }
        // }
        // return $data['other'];

        return view('product/addonDetail', $data);
    }

    public function getCalcdata()
    {
        $id = Input::input('id');
        $data = Tile::select(DB::RAW("MD5(id) as id, (length / 100) as length, (width / 100) as width, pcs_per_box, ((length / 100) * (width / 100) * pcs_per_box) as coverage, calculator"))
                    ->where(DB::RAW("MD5(id)"), $id)
                    ->first();
        return json_encode($data);
    }

    public function addCartByCalc()
    {
        // return Input::all();
        $id = Input::input('id');
        $qty = Input::input('qtyTotal');
        $tileexist = false;
        if(Session::get('cart') === null) {
            $cart = [];
        }else {
            $cart = json_decode(Session::get('cart'));
            for($i=0;$i<sizeof($cart);$i++) {
                if($cart[$i]->id == $id && $cart[$i]->type == 'tile') {
                    $tileexist = true;
                    $cart[$i]->qty += $qty;
                }
            }
        }
        if($tileexist == false) {
            $tile = Tile::leftjoin('add_ons', 'tiles.add_on_1', '=', 'add_ons.id')
                        ->select(DB::RAW('tiles.*, add_ons.img_name'))
                        ->where(DB::RAW('MD5(tiles.id)'), $id)->first();
            $addon = [
                "status" => $tile->add_on,
                "cta" => $tile->add_on_cta,
                "image" => $tile->img_name
            ];
            $coverage = 0;
            if($tile->calculator == 1) {
                $coverage = ($tile->length / 100) * ($tile->width / 100) * $tile->pcs_per_box;
            }else {
                $coverage = 1;
            }
            $array = [
                "id" => $id,
                "item_code" => $tile->item_code,
                "name" => $tile->item_name,
                "image" => $tile->img_name1,
                "price" => ceil($coverage * ($tile->price_per_m2 - ($tile->price_per_m2 * $tile->disc / 100))),
                "add_on" => json_encode($addon),
                "qty" => $qty,
                "type" => "tile"
            ];
            array_push($cart, $array);
        }
        Session::put('cart',json_encode($cart));
        return Redirect::back();
    }

    public function addTileToCart()
    {
        // return Input::all();
        $id = Input::input('id');
        $qty = Input::input('qty');
        $tileexist = false;
        if(Session::get('cart') === null) {
            $cart = [];
        }else {
            $cart = json_decode(Session::get('cart'));
            for($i=0;$i<sizeof($cart);$i++) {
                if($cart[$i]->id == $id && $cart[$i]->type == 'tile') {
                    $tileexist = true;
                    $cart[$i]->qty += $qty;
                }
            }
        }
        if($tileexist == false) {
            $tile = Tile::leftjoin('add_ons', 'tiles.add_on_1', '=', 'add_ons.id')
                        ->select(DB::RAW('tiles.*, add_ons.img_name'))
                        ->where(DB::RAW('MD5(tiles.id)'), $id)->first();
            $addon = [
                "status" => $tile->add_on,
                "cta" => $tile->add_on_cta,
                "image" => $tile->img_name
            ];
            $coverage = 0;
            if($tile->calculator == 1) {
                $coverage = ($tile->length / 100) * ($tile->width / 100) * $tile->pcs_per_box;
            }else {
                $coverage = 1;
            }
            $array = [
                "id" => $id,
                "item_code" => $tile->item_code,
                "name" => $tile->item_name,
                "image" => $tile->img_name1,
                "price" => ceil($coverage * ($tile->price_per_m2 - ($tile->price_per_m2 * $tile->disc / 100))),
                "add_on" => json_encode($addon),
                "qty" => $qty,
                "type" => "tile"
            ];
            array_push($cart, $array);
        }
        Session::put('cart',json_encode($cart));
        return Redirect::back();
    }

    public function addAddonToCart()
    {
        // return Input::all();
        $id = Input::input('id');
        $qty = Input::input('qty');
        $addonexist = false;

        if(Session::get('cart') === null) {
            $cart = [];
        }else {
            $cart = json_decode(Session::get('cart'));
            for($i=0;$i<sizeof($cart);$i++) {
                if($cart[$i]->id == $id && $cart[$i]->type == 'addon') {
                    $addonexist = true;
                    $cart[$i]->qty += $qty;
                }
            }
        }
        if($addonexist == false) {
            $addon = AddOn::where(DB::RAW('MD5(id)'), $id)->first();
            $array = [
                "id" => $id,
                "item_code" => $addon->item_code,
                "name" => $addon->add_on_name,
                "image" => $addon->img_name,
                "price" => $addon->price_per_pcs - ($addon->price_per_pcs * $addon->disc / 100),
                "qty" => $qty,
                "type" => "addon"
            ];
            array_push($cart, $array);
        }
        Session::put('cart',json_encode($cart));
        return Redirect::back();
    }

    public function getAddOnData()
    {
        $id = Input::input('id');
        $data = Tile::select(DB::RAW('add_on_title, add_on_cta, add_on_1, add_on_2, add_on_3, add_on_description_1, add_on_description_2, add_on_description_3'))
                    ->where(DB::RAW('MD5(tiles.id)'), $id)
                    ->first();
        $data['add_on_1_data'] = AddOn::select(DB::RAW('add_ons.*, MD5(add_ons.id) as addonid'))
                                    ->where('id', $data->add_on_1)
                                    ->first();
        $data['add_on_1_data']->price_per_pcs = number_format($data['add_on_1_data']->price_per_pcs,'0','.','.');
        $data['add_on_2_data'] = AddOn::select(DB::RAW('add_ons.*, MD5(add_ons.id) as addonid'))
                                    ->where('id', $data->add_on_2)
                                    ->first();
        $data['add_on_2_data']->price_per_pcs = number_format($data['add_on_2_data']->price_per_pcs,'0','.','.');
        $data['add_on_3_data'] = AddOn::select(DB::RAW('add_ons.*, MD5(add_ons.id) as addonid'))
                                    ->where('id', $data->add_on_3)
                                    ->first();
        $data['add_on_3_data']->price_per_pcs = number_format($data['add_on_3_data']->price_per_pcs,'0','.','.');
        if(Session::get('sesUserId') === null) {
            $data['nobuy'] = true;
        }else {
            $data['nobuy'] = false;
        }

        return json_encode($data);
    }

}