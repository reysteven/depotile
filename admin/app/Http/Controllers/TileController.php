<?php namespace App\Http\Controllers;

use Auth;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Carbon\Carbon;

use App\Tile;
use App\HeaderCategory;
use App\DetailCategory;
use App\Brand;
use App\Installation;
use App\HeaderFee;
use App\AddOn;
use App\HeaderTag;
use App\DetailTag;

use Excel;

class TileController extends Controller {

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

        // Tile::withTrashed()->restore();

        // AMBIL DATA KERAMIK
        // ------------------
        $data['tile'] = Tile::join('detail_categories', 'tiles.detail_category_id', '=', 'detail_categories.id')
                            ->join('header_categories', 'detail_categories.header_category_id', '=', 'header_categories.id')
                            ->join('brands', 'tiles.brand_id', '=', 'brands.id')
                            ->join('installations', 'tiles.installation_id', '=', 'installations.id')
                            ->join('header_fees', 'tiles.header_fee_id', '=', 'header_fees.id')
                            ->select(DB::RAW('tiles.*, category_name, detail_category_name, brand_name, brand_logo'))
                            ->orderBy('tiles.id')
                            ->get();

        // AMBIL DATA KATEGORI
        // -------------------
        $data['category'] = json_decode(json_encode(HeaderCategory::all()),true);
        $detailCategoryData = DetailCategory::all();
        for($i=0;$i<sizeof($data['category']);$i++) {
            $data['category'][$i]['detail_category'] = [];
            $hId = $data['category'][$i]['id'];
            foreach($detailCategoryData as $d) {
                if($d['header_category_id'] == $hId) {
                    array_push($data['category'][$i]['detail_category'], $d['detail_category_name']);
                }
            }
        }

        // AMBIL DATA BRAND
        // ----------------
        $data['brand'] = Brand::all();

        // AMBIL DATA INSTALASI
        // --------------------
        $data['installation'] = Installation::all();

        // AMBIL DATA ONGKIR
        // -----------------
        $data['fee'] = HeaderFee::all();

        // AMBIL DATA ADD ON
        // -----------------
        $data['addon'] = AddOn::all();

        // AMBIL DATA TAG
        // --------------
        $data['tag'] = json_decode(json_encode(HeaderTag::all()),true);
        $detailTagData = DetailTag::all();
        for($i=0;$i<sizeof($data['tag']);$i++) {
            $data['tag'][$i]['detail_tag'] = [];
            $id = $data['tag'][$i]['id'];
            foreach($detailTagData as $d) {
                if($d['header_tag_id'] == $id) {
                    array_push($data['tag'][$i]['detail_tag'], $d['detail_tag_name']);
                }
            }
        }

        // return $data;

        return view('item/tile-list', $data);
    }

    public function editTile()
    {
        // return Input::all();
        $id = Input::input('item_id');
        $number = Input::input('code');
        $name = Input::input('name');
        $category = Input::input('category');
        $subcategory = Input::input('sub_category');
        $length = Input::input('length');
        $width = Input::input('width');
        $thick = Input::input('thickness');
        $pcperbox = Input::input('pc_per_box');
        $pricem2 = Input::input('price_m2');
        $brand = Input::input('brand');
        $calc = Input::input('calc');
        $installation = Input::input('installation');
        $fee = Input::input('fee');
        $description = Input::input('description');
        $addon = Input::input('addon');
        $addon1 = Input::input('addon1');
        $addon1desc = Input::input('addon1desc');
        $addon2 = Input::input('addon2');
        $addon2desc = Input::input('addon2desc');
        $addon3 = Input::input('addon3');
        $addon3desc = Input::input('addon3desc');
        $addoncta = Input::input('addoncta');
        $addontitle = Input::input('addontitle');
        $img = Input::input('img_name');
        $headertag = Input::input('header-tag');
        $detailtag = Input::input('detail-tag');

        $categoryId = HeaderCategory::join('detail_categories', 'header_categories.id', '=', 'detail_categories.header_category_id')
                                    ->select('detail_categories.id')
                                    ->where('header_categories.category_name', 'LIKE', $category)
                                    ->where('detail_categories.detail_category_name', 'LIKE', $subcategory)
                                    ->first()->id;
        $brandId = Brand::select('id')->where('brand_name', 'LIKE', $brand)->first()->id;
        $installationId = Installation::select('id')->where('installation_name', 'LIKE', $installation)->first()->id;
        $feeId = HeaderFee::select('id')->where('fee_name', 'LIKE', $fee)->first()->id;
        $tagData = [];
        for($i=0;$i<sizeof($headertag);$i++) {
            $tagModel = HeaderTag::select(DB::RAW('header_tags.id as headerId, detail_tags.id as detailId'))
                                ->join('detail_tags', 'header_tags.id', '=', 'detail_tags.header_tag_id')
                                ->where('header_tags.tag_name', 'LIKE', $headertag[$i])
                                ->where('detail_tags.detail_tag_name', 'LIKE', $detailtag[$i])
                                ->first();
            $array = [
                "detail_tag_id" => $tagModel->detailId,
                "detail_tag_name" => $detailtag[$i],
                "header_tag_id" => $tagModel->headerId,
                "tag_name" => $headertag[$i]
            ];
            array_push($tagData, $array);
        }
        // return $tagData;

        $tileModel = Tile::find($id);
        $tileModel->item_code = $number;
        $tileModel->item_name = $name;
        $tileModel->detail_category_id = $categoryId;
        $tileModel->img_name1 = $img[0];
        $tileModel->img_name2 = $img[1];
        $tileModel->img_name3 = $img[2];
        $tileModel->description = $description;
        $tileModel->length = $length;
        $tileModel->width = $width;
        $tileModel->thickness = $thick;
        $tileModel->pcs_per_box = $pcperbox;
        $tileModel->price_per_m2 = $pricem2;
        $tileModel->brand_id = $brandId;
        $tileModel->calculator = $calc;
        $tileModel->installation_id = $installationId;
        $tileModel->header_fee_id = $feeId;
        $tileModel->add_on = $addon;
        $tileModel->add_on_cta = $addoncta;
        $tileModel->add_on_title = $addontitle;
        $tileModel->add_on_1 = $addon1;
        $tileModel->add_on_2 = $addon2;
        $tileModel->add_on_3 = $addon3;
        $tileModel->add_on_description_1 = $addon1desc;
        $tileModel->add_on_description_2 = $addon2desc;
        $tileModel->add_on_description_3 = $addon3desc;
        $tileModel->detail_tag_data = json_encode($tagData);
        $tileModel->save();

        return Redirect::to('item/tile-manager');

    }

    public function delTile()
    {
        // return Input::all();
        $data = json_decode(Input::input('data'));
        foreach($data as $d) {
            $tileModel = Tile::find($d->id);
            $tileModel->delete();
        }

        return Redirect::to('item/tile-manager');
    }

    public function doSearch()
    {
        // return Input::all();
        $data['search_flag'] = Input::input('search_flag');
        $data['search_id'] = Input::input('search_id');
        $data['search_code'] = Input::input('search_code');
        $data['search_name'] = Input::input('search_name');
        $data['search_category'] = Input::input('search_category');
        $data['search_sub_category'] = Input::input('search_sub_category');
        $data['search_brand'] = Input::input('search_brand');

        // AMBIL DATA ITEM
        // ---------------
        $data['tile'] = Tile::join('detail_categories', 'tiles.detail_category_id', '=', 'detail_categories.id')
                            ->join('header_categories', 'detail_categories.header_category_id', '=', 'header_categories.id')
                            ->join('brands', 'tiles.brand_id', '=', 'brands.id')
                            ->join('installations', 'tiles.installation_id', '=', 'installations.id')
                            ->join('header_fees', 'tiles.header_fee_id', '=', 'header_fees.id');
        if($data['search_id'] != null && $data['search_id'] != "") {
            $data['tile'] = $data['tile']->where('tiles.id', $data['search_id']);
        }
        if($data['search_code'] != null && $data['search_code'] != "") {
            $data['tile'] = $data['tile']->where('tiles.item_code', 'LIKE', $data['search_code']);
        }
        if($data['search_name'] != null && $data['search_name'] != "") {
            $data['tile'] = $data['tile']->where('tiles.item_name', 'LIKE', $data['search_name']);
        }
        if($data['search_category'] != null && $data['search_category'] != "" && $data['search_category'] != "Pilih nama kategori") {
            $data['tile'] = $data['tile']->where('header_categories.category_name', 'LIKE', $data['search_category']);
        }
        // if($_GET['search-sub-category'] != null && $_GET['search-sub-category'] != "" && $_GET['search-sub-category'] != "Pilih nama sub kategori" && $_GET['search-sub-category'] != "Pilih kategori dahulu") {
        //     $sql .= "dc.detail_category_name LIKE '".$_GET['search-sub-category']."' AND ";
        // }
        if($data['search_brand'] != null && $data['search_brand'] != "" && $data['search_brand'] != "Pilih nama merk") {
            $data['tile'] = $data['tile']->where('brand.brand_name', 'LIKE', $data['search_brand']);
        }
        $data['tile'] = $data['tile']->select(DB::RAW('tiles.*, category_name, detail_category_name, brand_name, brand_logo'))
                                    ->orderBy('tiles.id')
                                    ->get();

        // AMBIL DATA KATEGORI
        // -------------------
        $data['category'] = json_decode(json_encode(HeaderCategory::all()),true);
        $detailCategoryData = DetailCategory::all();
        for($i=0;$i<sizeof($data['category']);$i++) {
            $data['category'][$i]['detail_category'] = [];
            $hId = $data['category'][$i]['id'];
            foreach($detailCategoryData as $d) {
                if($d['header_category_id'] == $hId) {
                    array_push($data['category'][$i]['detail_category'], $d['detail_category_name']);
                }
            }
        }

        // AMBIL DATA BRAND
        // ----------------
        $data['brand'] = Brand::all();

        // AMBIL DATA INSTALASI
        // --------------------
        $data['installation'] = Installation::all();

        // AMBIL DATA ONGKIR
        // -----------------
        $data['fee'] = HeaderFee::all();

        // AMBIL DATA ADD ON
        // -----------------
        $data['addon'] = AddOn::all();

        // AMBIL DATA TAG
        // --------------
        $data['tag'] = json_decode(json_encode(HeaderTag::all()),true);
        $detailTagData = DetailTag::all();
        for($i=0;$i<sizeof($data['tag']);$i++) {
            $data['tag'][$i]['detail_tag'] = [];
            $id = $data['tag'][$i]['id'];
            foreach($detailTagData as $d) {
                if($d['header_tag_id'] == $id) {
                    array_push($data['tag'][$i]['detail_tag'], $d['detail_tag_name']);
                }
            }
        }
        
        return view('item/tile-list', $data);
    }

    public function doUpload(Request $request)
    {
        $tileExcel = $request->file('excelFile');

        if($tileExcel->isValid()) {
            $extension = $tileExcel->getClientOriginalExtension();
            $fileName = $tileExcel->getClientOriginalName();
            
            if(strtolower($extension) == "xls" || strtolower($extension) == "xlsx") {

                $tileData = Excel::load($tileExcel)->all();

                $headerList = [
                    "no_item",
                    "item_code",
                    "item_name",
                    "sub_category",
                    "image_i",
                    "image_ii",
                    "image_iii",
                    "description",
                    "size_l",
                    "size_w",
                    "thickness",
                    "pcs_per_box",
                    "price_m2",
                    "kalkulator",
                    "installation",
                    "brand",
                    "ongkir",
                    "add_on",
                    "add_on_cta",
                    "add_on_title",
                    "add_on_1",
                    "add_on_2",
                    "add_on_3",
                    "add_on_description_1",
                    "add_on_description_2",
                    "add_on_description_3"
                ];

                if(sizeof($tileData) > 0) {
                    //validation excel data header
                    $headerValid = false;
                    $headers = $tileData[0]->keys();
                    
                    $jmlPrimHeader = 0;
                    foreach($headers as $d) {
                        if(strpos($d, 'tag') !== false) {
                            break;
                        }
                        $jmlPrimHeader++;
                    }
                    if($jmlPrimHeader == sizeof($headerList)) {
                        $headerValid = true;
                        for($i=0;$i<sizeof($headerList);$i++) {
                            $headerValid = false; //inisialisasi setiap kali pengecekan per header
                            for($j=0;$j<sizeof($headerList);$j++) {
                                // echo $headers[$i].' '.$headerList[$j].'<br>';
                                if($headers[$i] == $headerList[$j]) { //pengecekan tiap 1 header selesai jika sudah ketemu yg sama
                                    $headerValid = true;
                                    break;
                                }
                            }
                            if($headerValid == false) { //pengecekan dihentikan jika tidak ketemu yg sama
                                $messageError = $headers[$i]." is a wrong header name";
                                return Redirect::back()->withErrors([$messageError]);
                            }
                        }
                    }else {
                        $headerValid = false;
                        $messageError = "Header amount in front of tag column in uploaded excel is fewer or more than needed header amount";
                        return Redirect::back()->withErrors([$messageError]);
                    }

                    if($headerValid == true) {

                        // cek apakah data - data di db ada di excel
                        for($i=0;$i<sizeof($tileData);$i++) {
                            $tileData[$i]['status'] = "new";
                        }
                        $tile = Tile::all();
                        foreach($tile as $t) {
                            $valid = false;
                            for($i=0;$i<sizeof($tileData);$i++) {
                                if($t->id == $tileData[$i]['no_item']) {
                                    $valid = true;
                                    $tileData[$i]['status'] = "existed";
                                    break;
                                }
                            }
                            if($valid == false && $i < sizeof($tileData)) {
                                $messageError = "Item with ID ".$tileData[$i]['no_item']." is not registered in uploaded excel";
                                return Redirect::back()->withErrors([$messageError]);
                            }
                        }
                        // return $tileData;

                        // cek apakah ada id yang sama di excel
                        foreach($tileData as $d) {
                            $currId = $d['no_item'];
                            $count = 0;
                            foreach($tileData as $sd) {
                                if($sd['no_item'] == $currId) {
                                    $count++;
                                    if($count == 2) {
                                        $messageError = "There're two or more item with ID ".$currId;
                                        return Redirect::back()->withErrors([$messageError]);
                                    }
                                }
                            }
                        }

                        // mulai masukin data ke db jika validasi sukses
                        $itemDb = [];
                        for($i=0;$i<sizeof($tileData);$i++) {
                            $id = "";
                            $itemCode = "";
                            $itemName = "";
                            $subCategory = "";
                            $image1 = "";
                            $image2 = "";
                            $image3 = "";
                            $description = "";
                            $length = "";
                            $width = "";
                            $thickness = "";
                            $pcsPerBox = "";
                            $pricePerM2 = "";
                            $brand = "";
                            $calculator = "";
                            $installation = "";
                            $fee = "";
                            $addOn = "";
                            $addOnCta = "";
                            $addOnTitle = "";
                            $addOn1 = "";
                            $addOn2 = "";
                            $addOn3 = "";
                            $addOnDescription1 = "";
                            $addOnDescription2 = "";
                            $addOnDescription3 = "";

                            // define data per kolom di excel ke dalam 1 variabel yang tidak berindex supaya bisa fleksibel untuk ke depannya
                            if($tileData[$i]['no_item'] == "") {
                                $id = 0;
                            }else {
                                $id = $tileData[$i]['no_item'];
                            }

                            if($tileData[$i]['item_code'] == "") {
                                $itemCode = "null";
                            }else {
                                $itemCode = $tileData[$i]['item_code'];
                            }

                            if($tileData[$i]['item_name'] == "") {
                                $itemName = "null";
                            }else {
                                $itemName = $tileData[$i]['item_name'];
                            }

                            if($tileData[$i]['sub_category'] == "") {
                                $subCategory = "null";
                            }else {
                                $subCategory = $tileData[$i]['sub_category'];
                            }

                            if($tileData[$i]['image_i'] == "") {
                                $image1 = "null";
                            }else {
                                $image1 = $tileData[$i]['image_i'];
                            }

                            if($tileData[$i]['image_ii'] == "") {
                                $image2 = "null";
                            }else {
                                $image2 = $tileData[$i]['image_ii'];
                            }

                            if($tileData[$i]['image_iii'] == "") {
                                $image3 = "null";
                            }else {
                                $image3 = $tileData[$i]['image_iii'];
                            }

                            if($tileData[$i]['description'] == "") {
                                $description = "null";
                            }else {
                                $description = $tileData[$i]['description'];
                            }

                            if($tileData[$i]['size_l'] == "") {
                                $length = "null";
                            }else {
                                $length = $tileData[$i]['size_l'];
                            }

                            if($tileData[$i]['size_w'] == "") {
                                $width = "null";
                            }else {
                                $width = $tileData[$i]['size_w'];
                            }

                            if($tileData[$i]['thickness'] == "") {
                                $thickness = "null";
                            }else {
                                $thickness = $tileData[$i]['thickness'];
                            }

                            if($tileData[$i]['pcs_per_box'] == "") {
                                $pcsPerBox = "null";
                            }else {
                                $pcsPerBox = $tileData[$i]['pcs_per_box'];
                            }

                            if($tileData[$i]['price_m2'] == "") {
                                $pricePerM2 = "null";
                            }else {
                                $pricePerM2 = $tileData[$i]['price_m2'];
                            }

                            if($tileData[$i]['brand'] == "") {
                                $brand = "null";
                            }else {
                                $brand = $tileData[$i]['brand'];
                            }

                            if($tileData[$i]['kalkulator'] == "") {
                                $calculator = 0;
                            }else {
                                if(strtoupper($tileData[$i]['kalkulator']) == "YES") {
                                    $calculator = 1;
                                }else {
                                    $calculator = 0;
                                }
                            }

                            if($tileData[$i]['installation'] == "") {
                                $installation = "null";
                            }else {
                                $installation = $tileData[$i]['installation'];
                            }

                            if($tileData[$i]['ongkir'] == "") {
                                $fee = "null";
                            }else {
                                $fee = $tileData[$i]['ongkir'];
                            }

                            if($tileData[$i]['add_on'] == "") {
                                $addOn = "null";
                            }else if(strtoupper($tileData[$i]['add_on']) == "YES") {
                                $addOn = 1;
                            }else {
                                $addOn = 0;
                            }

                            if($tileData[$i]['add_on_cta'] == "") {
                                $addOnCta = "null";
                            }else {
                                $addOnCta = $tileData[$i]['add_on_cta'];
                            }

                            if($tileData[$i]['add_on_title'] == "") {
                                $addOnTitle = "null";
                            }else {
                                $addOnTitle = $tileData[$i]['add_on_title'];
                            }

                            if($tileData[$i]['add_on_1'] == "") {
                                $addOn1 = "null";
                            }else {
                                $addOn1 = $tileData[$i]['add_on_1'];
                            }

                            if($tileData[$i]['add_on_2'] == "") {
                                $addOn2 = "null";
                            }else {
                                $addOn2 = $tileData[$i]['add_on_2'];
                            }

                            if($tileData[$i]['add_on_3'] == "") {
                                $addOn3 = "null";
                            }else {
                                $addOn3 = $tileData[$i]['add_on_3'];
                            }

                            if($tileData[$i]['add_on_description_1'] == "") {
                                $addOnDescription1 = "null";
                            }else {
                                $addOnDescription1 = $tileData[$i]['add_on_description_1'];
                            }

                            if($tileData[$i]['add_on_description_2'] == "") {
                                $addOnDescription2 = "null";
                            }else {
                                $addOnDescription2 = $tileData[$i]['add_on_description_2'];
                            }

                            if($tileData[$i]['add_on_description_3'] == "") {
                                $addOnDescription3 = "null";
                            }else {
                                $addOnDescription3 = $tileData[$i]['add_on_description_3'];
                            }

                            // GET TILE IMAGE
                            // --------------
                            $directory = $_SERVER['DOCUMENT_ROOT'].'/'.env('APP_ROOT_DIR').'/public/assets/image/item-image/small';
                            $handle = opendir($directory);
                            $tileImg = [];
                            while($file = readdir($handle)) {
                                if($file !== '.' && $file !== '..') {
                                    array_push($tileImg, $file);
                                }
                            }

                            //validasi eksistensi image 1
                            $valid = false;
                            foreach($tileImg as $d) {
                                if(strtolower($image1) == strtolower($d)) {
                                    $valid = true;
                                    break;
                                }
                            }
                            if($valid == false) {
                                $image1 = "";
                            }

                            //validasi eksistensi image 2
                            $valid = false;
                            foreach($tileImg as $d) {
                                if(strtolower($image2) == strtolower($d)) {
                                    $valid = true;
                                    break;
                                }
                            }
                            if($valid == false) {
                                $image2 = "";
                            }

                            //validasi eksistensi image 3
                            $valid = false;
                            foreach($tileImg as $d) {
                                if(strtolower($image3) == strtolower($d)) {
                                    $valid = true;
                                    break;
                                }
                            }
                            if($valid == false) {
                                $image3 = "";
                            }

                            // cari detail category id
                            $detail_category_id = DetailCategory::find($subCategory)->id;
                            // die($detail_category_id);
                            if(sizeof($detail_category_id) == 0) {
                                $messageError = "There's no matched category in row ".($i+1);
                                return Redirect::back()->withErrors([$messageError]);
                            }

                            //cari brand id
                            $brand_id = Brand::find($brand)->id;
                            // die($brand_id);
                            if(sizeof($brand_id) == 0) {
                                $messageError = "There's no matched brand in row ".($i+1);
                                return Redirect::back()->withErrors([$messageError]);
                            }

                            // cari installation id
                            $installation_id = Installation::find($installation)->id;
                            // die($installation_id);
                            if(sizeof($installation_id) == 0) {
                                $messageError = "There's no matched installation in row ".($i+1);
                                return Redirect::back()->withErrors([$messageError]);
                            }

                            // cari fee id
                            $fee_id = HeaderFee::find($fee)->id;
                            if(sizeof($fee_id) == 0) {
                                $messageError = "There's no matched fee in row ".($i+1);
                                return Redirect::back()->withErrors([$messageError]);
                            }

                            // logic generate json detail item tag
                            $tagExist = false; // penanda jika ada kolom tag di file excel
                            $tagData = [];
                            for($k=0;$k<sizeof($headers);$k++) {
                                // echo($headers[$k].'<br>');
                                $pos = strpos($headers[$k], "tag");
                                if($pos !== false) {
                                    $tagExist = true;
                                    $tagType = str_replace('_',' ',explode("tag_", $headers[$k])[1]);
                                    $tagValueArray = explode(",", $tileData[$i][$headers[$k]]);
                                    // echo $tagType.' : '.json_encode($tagValueArray).'<br>';
                                    for($l=0;$l<sizeof($tagValueArray);$l++) { // looping save ke detail item tag sebanyak jumlah data per kolom tag
                                        $tagTemp = HeaderTag::join('detail_tags', 'header_tags.id', '=', 'detail_tags.header_tag_id')
                                                            ->select(DB::RAW('detail_tags.id as detail_tag_id, detail_tag_name, header_tags.id as header_tag_id, tag_name'))
                                                            ->where('detail_tag_name', 'LIKE', $tagValueArray[$l])
                                                            ->where('tag_name', 'LIKE', $tagType)
                                                            ->first();
                                        if(sizeof($tagTemp) > 0) {
                                            array_push($tagData, $tagTemp);
                                        }
                                    }
                                }
                            }
                            // return 'test';
                            // return $tagData;
                            // echo json_encode($tagData).'<br>';
                            if($tagExist == false) {
                                $messageError = "There must be at least 1 tag data in every row";
                                return Redirect::back()->withErrors([$messageError]);
                            }

                            // $hashCode = hash("md5", $itemCode);

                            if($tileData[$i]['status'] == "new") {
                                $tileModel = new Tile;
                                $tileModel->id = $id;
                                $tileModel->item_code = $itemCode;
                                $tileModel->item_name = $itemName;
                                $tileModel->detail_category_id = $detail_category_id;
                                $tileModel->img_name1 = $image1;
                                $tileModel->img_name2 = $image2;
                                $tileModel->img_name3 = $image3;
                                $tileModel->description = $description;
                                $tileModel->length = $length;
                                $tileModel->width = $width;
                                $tileModel->thickness = $thickness;
                                $tileModel->pcs_per_box = $pcsPerBox;
                                $tileModel->price_per_m2 = $pricePerM2;
                                $tileModel->brand_id = $brand_id;
                                $tileModel->calculator = $calculator;
                                $tileModel->installation_id = $installation_id;
                                $tileModel->header_fee_id = $fee_id;
                                $tileModel->add_on = $addOn;
                                $tileModel->add_on_cta = $addOnCta;
                                $tileModel->add_on_title = $addOnTitle;
                                $tileModel->add_on_1 = $addOn1;
                                $tileModel->add_on_2 = $addOn2;
                                $tileModel->add_on_3 = $addOn3;
                                $tileModel->add_on_description_1 = $addOnDescription1;
                                $tileModel->add_on_description_2 = $addOnDescription2;
                                $tileModel->add_on_description_3 = $addOnDescription3;
                                $tileModel->detail_tag_data = json_encode($tagData);
                                $tileModel->save();
                            }else {
                                $tileModel = Tile::find($id);
                                $tileModel->item_code = $itemCode;
                                $tileModel->item_name = $itemName;
                                $tileModel->detail_category_id = $detail_category_id;
                                $tileModel->img_name1 = $image1;
                                $tileModel->img_name2 = $image2;
                                $tileModel->img_name3 = $image3;
                                $tileModel->description = $description;
                                $tileModel->length = $length;
                                $tileModel->width = $width;
                                $tileModel->thickness = $thickness;
                                $tileModel->pcs_per_box = $pcsPerBox;
                                $tileModel->price_per_m2 = $pricePerM2;
                                $tileModel->brand_id = $brand_id;
                                $tileModel->calculator = $calculator;
                                $tileModel->installation_id = $installation_id;
                                $tileModel->header_fee_id = $fee_id;
                                $tileModel->add_on = $addOn;
                                $tileModel->add_on_cta = $addOnCta;
                                $tileModel->add_on_title = $addOnTitle;
                                $tileModel->add_on_1 = $addOn1;
                                $tileModel->add_on_2 = $addOn2;
                                $tileModel->add_on_3 = $addOn3;
                                $tileModel->add_on_description_1 = $addOnDescription1;
                                $tileModel->add_on_description_2 = $addOnDescription2;
                                $tileModel->add_on_description_3 = $addOnDescription3;
                                $tileModel->detail_tag_data = json_encode($tagData);
                                $tileModel->save();
                            }
                        }
                    }
                }else {

                }

                // return 'SUCCESS!!!';
                return Redirect::to('item/tile-manager');

            }else {
                $messageError = "You can only upload a file with *.xls or *.xlsx extension";
                return Redirect::back()->withErrors([$messageError]);
            }

        }

    }

    public function doExport()
    {
        $tileRaw = Tile::all();
        $headerList = [[
            "No. Item",
            "Item Code",
            "Item Name",
            "Sub Category",
            "Image I",
            "Image II",
            "Image III",
            "Description",
            "Size : L",
            "Size : W",
            "Thickness",
            "Pcs per box",
            "Price /m2",
            "Brand",
            "Kalkulator",
            "Installation",
            "Ongkir",
            "Add On",
            "Add On CTA",
            "Add On Title",
            "Add On 1",
            "Add On 2",
            "Add On 3",
            "Add On Description 1",
            "Add On Description 2",
            "Add On Description 3"
        ]];
        $tagList = [];
        foreach(json_decode($tileRaw[0]->detail_tag_data) as $d) {
            if(!in_array($d->tag_name, $tagList)) {
                array_push($tagList, $d->tag_name);
            }
        }
        // return $tagList;
        foreach($tagList as $d) {
            array_push($headerList[0], 'Tag : '.$d);
        }
        // return $headerList;
        foreach($tileRaw as $d) {
            $array = [
                $d->id,
                $d->item_code,
                $d->item_name,
                $d->detail_category_id,
                $d->img_name1,
                $d->img_name2,
                $d->img_name3,
                $d->description,
                $d->length,
                $d->width,
                $d->thickness,
                $d->pcs_per_box,
                $d->price_per_m2,
                $d->brand_id,
                (($d->calculator == 1) ? 'YES' : 'NO'),
                $d->installation_id,
                $d->header_fee_id,
                (($d->add_on == 1) ? 'YES' : 'NO'),
                $d->add_on_cta,
                $d->add_on_title,
                $d->add_on_1,
                $d->add_on_2,
                $d->add_on_3,
                $d->add_on_description_1,
                $d->add_on_description_2,
                $d->add_on_description_3
            ];
            foreach($tagList as $dd) {
                $tagValue = [];
                $tagData = json_decode($d->detail_tag_data);
                foreach($tagData as $ddd) {
                    if($ddd->tag_name == $dd) {
                        array_push($tagValue, $ddd->detail_tag_name);
                    }
                }
                $tagValue = implode(',', $tagValue);
                array_push($array, $tagValue);
            }
            array_push($headerList, $array);
        }

        Excel::create('Tiles', function($excel) use ($headerList) {
            // Set the spreadsheet title, creator, and description
            $excel->setTitle('Tiles');
            $excel->setCreator('Depotile')->setCompany('Depotile');
            $excel->setDescription('tiles file');

            // Build the spreadsheet, passing in the payments array
            $excel->sheet('Sheet 1', function($sheet) use ($headerList) {
                $sheet->fromArray($headerList, null, 'A1', false, false);
            });
        })->download('xlsx');
    }

    public function getData()
    {
        $id = Input::input('id');
        $tileModel = Tile::find($id)->join('detail_categories', 'tiles.detail_category_id', '=', 'detail_categories.id')
                                    ->join('header_categories', 'detail_categories.header_category_id', '=', 'header_categories.id')
                                    ->join('brands', 'tiles.brand_id', '=', 'brands.id')
                                    ->join('installations', 'tiles.installation_id', '=', 'installations.id')
                                    ->join('header_fees', 'tiles.header_fee_id', '=', 'header_fees.id')
                                    ->select(DB::RAW('tiles.*, detail_categories.detail_category_name,header_categories.category_name, brands.brand_name, installations.installation_name, header_fees.fee_name'))
                                    ->where('tiles.id', $id)
                                    ->first();
        return json_encode($tileModel);
    }

}