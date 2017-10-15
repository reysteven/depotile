<?php namespace App\Http\Controllers;

use Auth;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Carbon\Carbon;

use App\HeaderFee;
use App\DetailFee;
use App\Province;
use App\City;

use Excel;

class FeeController extends Controller {

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
        $data['fee'] = json_decode(json_encode(HeaderFee::all()),true);
        $detailFee = DetailFee::all();
        for($i=0;$i<sizeof($data['fee']);$i++) {
            $data['fee'][$i]['detail'] = [];
            foreach($detailFee as $d) {
                if($data['fee'][$i]['id'] == $d->header_fee_id) {
                    array_push($data['fee'][$i]['detail'], $d);
                }
            }
        }

        $data['province'] = json_decode(json_encode(Province::all()),true);
        $city = City::all();
        for($i=0;$i<sizeof($data['province']);$i++) {
            $data['province'][$i]['city'] = [];
            foreach($city as $d) {
                if($data['province'][$i]['id'] == $d->province_id) {
                    array_push($data['province'][$i]['city'], $d);
                }
            }
        }
        // return $data;

        return view('fee/fee-list', $data);
    }

    public function doSearch()
    {
        // LOGIC PENCARIAN
        // ---------------
        $feeName = Input::input('search-name');
        $feeProvince = Input::input('search-province');
        $feeCity = Input::input('search-city');
        $startFee = Input::input('search-startfee');
        $endFee = Input::input('search-endfee');
        $data['search_flag'] = Input::input('search-flag');
        $data['fee'] = HeaderFee::join('detail_fees', 'header_fees.id', '=', 'detail_fees.header_fee_id')
                                ->join('cities', 'detail_fees.city_id', '=', 'cities.id')
                                ->join('provinces', 'cities.province_id', '=', 'provinces.id');
        if($feeName != "" && $feeName != null && $feeName != 'Pilih nama ongkir') {
            $data['fee'] = $data['fee']->where('header_fees.fee_name', 'LIKE', $feeName);
        }
        if($feeProvince != "" && $feeProvince != null && $feeProvince != 'Pilih nama provinsi') {
            $data['fee'] = $data['fee']->where('provinces.province_name', 'LIKE', $feeProvince);
        }
        if($feeCity != "" && $feeCity != null && $feeCity != 'Pilih nama kota' && $feeCity != 'Pilih provinsi dahulu') {
            $data['fee'] = $data['fee']->where('cities.city_name', 'LIKE', $feeCity);
        }
        if($startFee != "" && $startFee != null) {
            $startFee = explode('Rp ', $startFee)[1];
            $startFee = explode(',', $startFee)[0];
            $startFee = preg_replace('/\./', '', $startFee);
            $data['fee'] = $data['fee']->where('detail_fees.fee_value', '>=', $startFee);
        }
        if($endFee != "" && $endFee != null) {
            $endFee = explode('Rp ', $endFee)[1];
            $endFee = explode(',', $endFee)[0];
            $endFee = preg_replace('/\./', '', $endFee);
            $data['fee'] = $data['fee']->where('detail_fees.fee_value', '<=', $endFee);
        }
        $data['fee'] = $data['fee']->orderBy('header_fees.fee_name')
                                    ->orderBy('provinces.province_name')
                                    ->orderBy('cities.city_name')
                                    ->orderBy('detail_fees.quantity_below')->get();
        // die($sql);

        $data['province'] = json_decode(json_encode(Province::all()),true);
        $city = City::all();
        for($i=0;$i<sizeof($data['province']);$i++) {
            $data['province'][$i]['city'] = [];
            foreach($city as $d) {
                if($data['province'][$i]['id'] == $d->province_id) {
                    array_push($data['province'][$i]['city'], $d);
                }
            }
        }

        $data['search_name'] = Input::input('search-name');
        $data['search_province'] = Input::input('search-province');
        $data['search_city'] = Input::input('search-city');
        $data['search_startfee'] = Input::input('search-startfee');
        $data['search_endfee'] = Input::input('search-endfee');

        // return $data;

        return view('fee/fee-list', $data);
    }

    public function doUpload(Request $request)
    {
        $feeExcel = $request->file('excelFile');

        if($feeExcel->isValid()) {
            $extension = $feeExcel->getClientOriginalExtension();
            $fileName = $feeExcel->getClientOriginalName();
            
            if(strtolower($extension) == "xls" || strtolower($extension) == "xlsx") {

                $feeData = Excel::load($feeExcel)->all();
                // return $feeData;
                
                // GET PROVINCE AND CITY DATA
                // --------------------------
                $provinceData = Province::all();
                $cityData = City::all();

                // VALIDASI NAMA KOTA DAN PROVINSI DI EXCEL
                // ----------------------------------------
                foreach($feeData as $d) {
                    $sheetName = $d->getTitle();
                    $headers = $d[0]->keys();
                    $i=0;
                    foreach($headers as $h) {
                        if($i > 0) {
                            // echo $h.'<br>';
                            $city = str_replace('_',' ',substr(explode('0', $h)[0],0,-1));
                            $province = str_replace('_',' ',substr(explode('0', $h)[1],1));
                            // return $city.' '.$province;

                            $cityValid = false;
                            $provinceValid = false;
                            foreach($provinceData as $p) {
                                if(strtolower($p->province_name) == $province) {
                                    $provinceValid = true;
                                    break;
                                }
                            }
                            if($provinceValid == false) {
                                // jika nama provinsi tidak ada di db provinsi
                                $messageError = $province." in ".$sheetName." sheet, column ".($i+1)." is not registered";
                                return Redirect::back()->withErrors([$messageError]);
                            }
                            foreach($cityData as $c) {
                                if(strtolower($c->city_name) == $city) {
                                    $cityValid = true;
                                    break;
                                }
                            }
                            if($cityValid == false) {
                                // jika nama kota tidak ada di db kota
                                $messageError = $city." in ".$sheetName." sheet, column ".($i+1)." is not registered";
                                return Redirect::back()->withErrors([$messageError]);
                            }
                        }
                        $i++;
                    }
                }
                // return 'validasi sukses';

                // TRUNCATE FEE TABLE
                // ------------------
                HeaderFee::truncate();
                DetailFee::truncate();

                // GET CITY WITH ID AND STATUS
                // ---------------------------
                $cityArray = City::select(DB::RAW("id, 'false' as status"))->get();

                // INSERT KE FEE TABLE
                // -------------------
                foreach($feeData as $d) {
                    $detailData = [];
                    $sheetName = $d->getTitle();
                    $headerModel = new HeaderFee;
                    $headerModel->fee_name = $sheetName;
                    $headerModel->save();
                    $headerId = $headerModel->id;
                    foreach($d as $dd) {
                        $data = json_decode(json_encode($dd),true);
                        $headers = $dd->keys();
                        if(sizeof(explode(' - ', $data['jumlah_item'])) == 2) {
                            $qty_below = explode(' - ', $data['jumlah_item'])[0];
                            $qty_above = explode(' - ', $data['jumlah_item'])[1];
                        }else {
                            $qty_below = explode('>= ', $data['jumlah_item'])[1];
                            $qty_above = 1000000;
                        }
                        $i=0;
                        // echo $qty_below.' '.$qty_above.'<br>';
                        foreach($headers as $h) {
                            if($i > 0) {
                                if($data[$h] !== null) {
                                    $city = str_replace('_',' ',substr(explode('0', $h)[0],0,-1));
                                    $province = str_replace('_',' ',substr(explode('0', $h)[1],1));
                                    $cityId = Province::join('cities', 'provinces.id', '=', 'cities.province_id')->where('provinces.province_name', 'LIKE', $province)->where('cities.city_name', 'LIKE', $city)->first()->id;
                                    // for($j=0;$j<sizeof($cityArray);$j++) {
                                    //     if($cityArray[$j]->id == $cityId) {
                                    //         $cityArray[$j]->status = 'true';
                                    //         break;
                                    //     }
                                    // }
                                    $array = [
                                        "header_fee_id" => $headerId,
                                        "city_id" => $cityId,
                                        "quantity_below" => $qty_below,
                                        "quantity_above" => $qty_above,
                                        "fee_value" => $data[$h],
                                        "created_at" => Carbon::now(),
                                        "updated_at" => Carbon::now()
                                    ];
                                    array_push($detailData, $array);
                                }
                                echo '<br>';
                            }
                            $i++;
                        }
                        // foreach($cityArray as $ca) {
                        //     if($ca->status == 'false') {
                        //         $array = [
                        //             "header_fee_id" => $headerId,
                        //             "city_id" => $ca->id,
                        //             "quantity_below" => $qty_below,
                        //             "quantity_above" => $qty_above,
                        //             "fee_value" => 0,
                        //             "created_at" => Carbon::now(),
                        //             "updated_at" => Carbon::now()
                        //         ];
                        //         array_push($detailData, $array);
                        //     }
                        // }
                    }
                    // return $detailData;
                    DetailFee::insert($detailData);
                }
                return Redirect::to('fee-manager');

            }else {
                $messageError = "You can only upload a file with *.xls or *.xlsx extension";
                return Redirect::back()->withErrors([$messageError]);
            }
            
        }
    }

    public function doExport()
    {
        // GET CITY DATA
        // -------------
        $cityData = City::join('provinces', 'cities.province_id', '=', 'provinces.id')->orderBy('cities.id')->get();

        // GET FEE DATA
        // ------------
        $feeRaw = HeaderFee::join('detail_fees', 'header_fees.id', '=', 'detail_fees.header_fee_id')
                            ->join('cities', 'detail_fees.city_id', '=', 'cities.id')
                            ->join('provinces', 'cities.province_id', '=', 'provinces.id')
                            ->select(DB::RAW("header_fees.*, detail_fees.*, city_name, province_name"))
                            ->orderBy('header_fees.id','ASC','cities.id')
                            ->orderBy('detail_fees.quantity_below', 'ASC')
                            ->get();
        $feeData = [];
        foreach($feeRaw as $d) {
            $quantity = "";
            if($d->quantity_above < 1000000) {
                $quantity = $d->quantity_below.' - '.$d->quantity_above;
            }else {
                $quantity = '>= '.$d->quantity_below;
            }
            $feeData[$d->fee_name][$quantity][$d->province_name][$d->city_name] = $d->fee_value;
        }
        $excelData = [];
        foreach($feeData as $name => $d) {
            $excelData[$name][0] = ["Jumlah Item"];
            foreach($cityData as $cd) {
                array_push($excelData[$name][0], $cd['city_name'].' 0 '.$cd['province_name']);
            }
            foreach($d as $range => $dd) {
                $array = [$range];
                foreach($cityData as $cd) {
                    $feeExist = false;
                    foreach($dd as $province => $cData) {
                        foreach($cData as $city => $fee) {
                            if($province == $cd['province_name'] && $city == $cd['city_name']) {
                                $feeExist = true;
                                array_push($array, $fee);
                            }
                        }
                    }
                    if($feeExist == false) {
                        array_push($array, "");
                    }
                }
                array_push($excelData[$name], $array);
            }
        }
        // return $excelData;
        
        Excel::create('Fees', function($excel) use ($excelData) {
            foreach($excelData as $name => $d) {
                // Set the spreadsheet title, creator, and description
                $excel->setTitle('Fees');
                $excel->setCreator('Depotile')->setCompany('Depotile');
                $excel->setDescription('fees file');

                // Build the spreadsheet, passing in the payments array
                $excel->sheet($name, function($sheet) use ($d) {
                    $sheet->fromArray($d, null, 'A1', true, false);
                });
            }
        })->download('xls');
    }

}