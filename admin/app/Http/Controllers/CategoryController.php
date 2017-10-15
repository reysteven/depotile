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

use App\HeaderCategory;
use App\DetailCategory;
use App\HeaderTag;

class CategoryController extends Controller {

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
        $data['category'] = json_decode(json_encode(HeaderCategory::get()),true);
        $detailData = DetailCategory::get();
        for($i=0;$i<sizeof($data['category']);$i++) {
            $data['category'][$i]['detail'] = [];
            foreach($detailData as $dd) {
                if($dd->header_category_id == $data['category'][$i]['id']) {
                    array_push($data['category'][$i]['detail'], $dd);
                }
            }
        }
        $data['category'] = json_decode(json_encode($data['category']));
        $data['tag'] = HeaderTag::select('tag_name')->get();
        // return $data;
        return view('category/category-list', $data);
    }

    public function doSearch()
    {
        // return Input::all();
        $data['search_flag_tile'] = Input::input('search_flag_tile');
        $data['category_name'] = Input::input('category_name');
        $data['sub_category_name'] = Input::input('sub_category_name');
        if($data['category_name'] != null && $data['category_name'] != "") {
            $data['category'] = json_decode(json_encode(HeaderCategory::where('category_name', 'LIKE', '%'.$data['category_name'].'%')->get()),true);
        }else {
            $data['category'] = json_decode(json_encode(HeaderCategory::get()),true);
        }
        if($data['sub_category_name'] != null && $data['sub_category_name'] != "") {
            $detailData = DetailCategory::where('detail_category_name', 'LIKE', '%'.$data['sub_category_name'].'%')->get();
        }else {
            $detailData = DetailCategory::get();
        }
        for($i=0;$i<sizeof($data['category']);$i++) {
            $data['category'][$i]['detail'] = [];
            foreach($detailData as $dd) {
                if($dd->header_category_id == $data['category'][$i]['id']) {
                    array_push($data['category'][$i]['detail'], $dd);
                }
            }
        }
        $data['category'] = json_decode(json_encode($data['category']));
        return view('category/category-list', $data);
    }

    public function addCategory()
    {
        $category = Request::input('category_name');
        $categoryModel = new HeaderCategory;
        $categoryModel->category_name = $category;
        $categoryModel->save();
        return Redirect::to('category-manager');
    }

    public function editCategory()
    {
        $id = Request::input('id');
        $category = Request::input('name');
        $provinceModel = HeaderCategory::find($id);
        $provinceModel->category_name = $category;
        $provinceModel->save();
    }

    public function delCategory()
    {
        $data = json_decode(Request::input('data'));
        foreach($data as $d) {
            HeaderCategory::find($d->id)->delete();
        }
        return Redirect::to('category-manager');
    }

    public function addSubCategory()
    {
        $categoryId = Request::input('categoryId');
        $subCategory = Request::input('name');
        $desc = Request::input('desc');
        $subCategoryModel = new DetailCategory;
        $subCategoryModel->header_category_id = $categoryId;
        $subCategoryModel->detail_category_name = $subCategory;
        $subCategoryModel->description = $desc;
        $subCategoryModel->save();
        $id = DetailCategory::orderBy('created_at', 'DESC')->first()->id;
        return $id;
    }

    public function editSubCategory()
    {
        $id = Request::input('subcategoryId');
        $name = Request::input('name');
        $cta = Request::input('cta');
        $desc = Request::input('desc');
        $subCategoryModel = DetailCategory::find($id);
        $subCategoryModel->detail_category_name = $name;
        $subCategoryModel->description = $desc;
        $subCategoryModel->save();
    }

    public function getSubCategory()
    {
        $subCategoryId = Request::input('subCategoryId');
        $subCategoryModel = DetailCategory::find($subCategoryId);
        return json_encode($subCategoryModel);
    }

    public function delSubCategory()
    {
        $id = Input::input('id');
        $subCategoryModel = DetailCategory::find($id);
        $subCategoryModel->delete();
    }

}