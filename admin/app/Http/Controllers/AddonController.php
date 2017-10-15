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

use App\HeaderCategory;
use App\DetailCategory;
use App\Brand;
use App\Installation;
use App\HeaderFee;
use App\AddOn;
use App\HeaderTag;
use App\DetailTag;

use Excel;

class AddonController extends Controller {

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

        // AMGIL DATA ADD ON
        // -----------------
        $data['addon'] = AddOn::join('detail_categories', 'add_ons.type', '=', 'detail_categories.id')
                            ->select(DB::RAW('add_ons.*, detail_categories.detail_category_name as type'))
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

        return view('item/add-on-list', $data);
    }

    public function doUpload(Request $request)
    {
        $addonExcel = $request->file('excelFile');

        if($addonExcel->isValid()) {
            $extension = $addonExcel->getClientOriginalExtension();
            $fileName = $addonExcel->getClientOriginalName();
            
            if(strtolower($extension) == "xls" || strtolower($extension) == "xlsx") {

                $addonData = Excel::load($addonExcel)->all();

                $headerList = [
                    "no",
                    "nama",
                    "item_code",
                    "sub_category",
                    "price_per_pc",
                    "warna",
                    "merk",
                    "ongkir",
                    "image",
                    "description"
                ];

                if(sizeof($addonData) > 0) {
                    //validation excel data header
                    $headerValid = false;
                    $headers = $addonData[0]->keys();
                    
                    $jmlPrimHeader = 0;
                    foreach($headers as $d) {
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
                        for($i=0;$i<sizeof($addonData);$i++) {
                            $addonData[$i]['status'] = "new";
                        }
                        $addon = AddOn::all();
                        foreach($addon as $a) {
                            $valid = false;
                            for($i=0;$i<sizeof($addonData);$i++) {
                                if($a->id == $addonData[$i]['no']) {
                                    $valid = true;
                                    $addonData[$i]['status'] = "existed";
                                }
                            }
                            if($valid == false) {
                                $messageError = "Item with ID ".$addonData[$i]['no']." is not registered in uploaded excel";
                                return Redirect::back()->withErrors([$messageError]);
                            }
                        }
                        // return $addonData;

                        // cek apakah ada id yang sama di excel
                        foreach($addonData as $d) {
                            $currId = $d['no'];
                            $count = 0;
                            foreach($addonData as $sd) {
                                if($sd['no'] == $currId) {
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
                        for($i=0;$i<sizeof($addonData);$i++) {
                            $id = "";
                            $itemCode = "";
                            $itemName = "";
                            $subCategory = "";
                            $price = "";
                            $color = "";
                            $brand = "";
                            $fee = "";
                            $image = "";
                            $description = "";

                            // define data per kolom di excel ke dalam 1 variabel yang tidak berindex supaya bisa fleksibel untuk ke depannya
                            if($addonData[$i]['no'] == "") {
                                $id = 0;
                            }else {
                                $id = $addonData[$i]['no'];
                            }

                            if($addonData[$i]['item_code'] == "") {
                                $itemCode = "null";
                            }else {
                                $itemCode = $addonData[$i]['item_code'];
                            }

                            if($addonData[$i]['nama'] == "") {
                                $itemName = "null";
                            }else {
                                $itemName = $addonData[$i]['nama'];
                            }

                            if($addonData[$i]['sub_category'] == "") {
                                $subCategory = "null";
                            }else {
                                $subCategory = $addonData[$i]['sub_category'];
                            }

                            if($addonData[$i]['price_per_pc'] == "") {
                                $price = "null";
                            }else {
                                $price = $addonData[$i]['price_per_pc'];
                            }

                            if($addonData[$i]['warna'] == "") {
                                $color = "null";
                            }else {
                                $color = $addonData[$i]['warna'];
                            }

                            if($addonData[$i]['merk'] == "") {
                                $brand = "null";
                            }else {
                                $brand = $addonData[$i]['merk'];
                            }

                            if($addonData[$i]['ongkir'] == "") {
                                $fee = "null";
                            }else {
                                $fee = $addonData[$i]['ongkir'];
                            }

                            if($addonData[$i]['image'] == "") {
                                $image = "null";
                            }else {
                                $image = $addonData[$i]['image'];
                            }

                            if($addonData[$i]['description'] == "") {
                                $description = "null";
                            }else {
                                $description = $addonData[$i]['description'];
                            }

                            // GET ADD ON IMAGE
                            // ----------------
                            $directory = $_SERVER['DOCUMENT_ROOT'].'/'.env('APP_ROOT_DIR').'/public/assets/image/item-image/add-on/small';
                            $handle = opendir($directory);
                            $addonImg = [];
                            while($file = readdir($handle)) {
                                if($file !== '.' && $file !== '..') {
                                    array_push($addonImg, $file);
                                }
                            }

                            //validasi eksistensi image
                            $target_file = $_SERVER['DOCUMENT_ROOT']."/".env('APP_ROOT_DIR')."/public/assets/image/item-image/add-on/small/".$image;
                            if(!file_exists($target_file)) {
                                $messageError = "There's no image file that matched with image in row ".$i;
                                return Redirect::back()->withErrors([$messageError]);
                            }

                            // cari detail category id
                            $detail_category_id = DetailCategory::find($subCategory)->id;
                            // die($detail_category_id);
                            if(sizeof($detail_category_id) == 0) {
                                $messageError = "There's no matched category in row ".$i;
                                return Redirect::back()->withErrors([$messageError]);
                            }

                            //cari brand id
                            $brand_id = Brand::find($brand)->id;
                            // die($brand_id);
                            if(sizeof($brand_id) == 0) {
                                $messageError = "There's no matched brand in row ".$i;
                                return Redirect::back()->withErrors([$messageError]);
                            }

                            // cari fee id
                            $fee_id = HeaderFee::find($fee)->id;
                            if(sizeof($fee_id) == 0) {
                                $messageError = "There's no matched fee in row ".$i;
                                return Redirect::back()->withErrors([$messageError]);
                            }

                            if($addonData[$i]['status'] == "new") {
                                $addonModel = new AddOn;
                                $addonModel->id = $id;
                                $addonModel->item_code = $itemCode;
                                $addonModel->add_on_name = $itemName;
                                $addonModel->type = $detail_category_id;
                                $addonModel->price_per_pcs = $price;
                                $addonModel->color = $color;
                                $addonModel->img_name = $image;
                                $addonModel->brand = $brand_id;
                                $addonModel->header_fee_id = $fee_id;
                                $addonModel->description = $description;
                                $addonModel->save();
                            }else {
                                $addonModel = AddOn::find($id);
                                $addonModel->item_code = $itemCode;
                                $addonModel->add_on_name = $itemName;
                                $addonModel->type = $detail_category_id;
                                $addonModel->price_per_pcs = $price;
                                $addonModel->color = $color;
                                $addonModel->img_name = $image;
                                $addonModel->brand = $brand_id;
                                $addonModel->header_fee_id = $fee_id;
                                $addonModel->description = $description;
                                $addonModel->save();
                            }
                        }
                    }
                }else {
                    $messageError = "There's no data or only corrupted data in your uploaded excel";
                    return Redirect::back()->withErrors([$messageError]);
                }

                // return 'SUCCESS!!!';
                return Redirect::to('item/add-on-manager');

            }else {
                $messageError = "You can only upload a file with *.xls or *.xlsx extension";
                return Redirect::back()->withErrors([$messageError]);
            }

        }

    }

    public function doExport()
    {
        $addonRaw = AddOn::all();
        $headerList = [[
            "No.",
            "Item Code",
            "Nama",
            "Sub Category",
            "Price Per Pc",
            "Warna",
            "Merk",
            "Ongkir",
            "Image",
            "Description"
        ]];
        foreach($addonRaw as $d) {
            $array = [
                $d->id,
                $d->item_code,
                $d->add_on_name,
                $d->type,
                $d->price_per_pcs,
                $d->color,
                $d->brand,
                $d->header_fee_id,
                $d->img_name,
                $d->description
            ];
            array_push($headerList, $array);
        }

        Excel::create('Add Ons', function($excel) use ($headerList) {
            // Set the spreadsheet title, creator, and description
            $excel->setTitle('Add Ons');
            $excel->setCreator('Depotile')->setCompany('Depotile');
            $excel->setDescription('addons file');

            // Build the spreadsheet, passing in the payments array
            $excel->sheet('Sheet 1', function($sheet) use ($headerList) {
                $sheet->fromArray($headerList, null, 'A1', false, false);
            });
        })->download('xlsx');
    }

}