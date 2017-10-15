<?php namespace App\Http\Controllers;

use Auth;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

use App\Folder;
use App\Photo;

class PhotoController extends Controller {

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
        // Folder::withTrashed()->restore();

        // GET TILE IMAGE
        // --------------
        $data['tile_dir'] = Folder::select('id', 'name', 'type')
                                ->where('type', 'tile')
                                ->orderBy('folders.name')
                                ->get();
        $data['tile'] = Photo::join('folders', 'photos.folder_id', '=', 'folders.id')
                            ->select(DB::RAW('photos.*, folders.name as folder_name, folders.type'))
                            ->where('type', 'tile')
                            ->orderBy('photos.name')
                            ->get();

        // paging for each folder type
        // $tileTemp = json_decode(json_encode($data['tile']));
        // $tileFolderTemp = [];
        // foreach($data['tile_dir'] as $d) {
        //     $tileFolderTemp[$d->name]['count'] = 0;
        // }
        // $data['tile'] = [];
        // foreach($tileTemp as $d) {
        //     if($tileFolderTemp[$d->folder_name]['count'] < 16) {
        //         array_push($data['tile'], $d);
        //         $tileFolderTemp[$d->folder_name]['count']++;
        //     }
        // }

        // GET ADD ON IMAGE
        // ----------------
        $data['addon_dir'] = Folder::select('id', 'name', 'type')
                                    ->where('type', 'add_on')
                                    ->orderBy('folders.name')
                                    ->get();
        $data['addon'] = Photo::join('folders', 'photos.folder_id', '=', 'folders.id')
                            ->select(DB::RAW('photos.*, folders.name as folder_name, folders.type'))
                            ->where('type', 'add_on')
                            ->orderBy('photos.name')
                            ->get();

        // GET LOGO IMAGE
        // --------------
        $data['logo_dir'] = Folder::select('id', 'name', 'type')
                                ->where('type', 'logo')
                                ->orderBy('folders.name')
                                ->get();
        $data['logo'] = Photo::join('folders', 'photos.folder_id', '=', 'folders.id')
                            ->select(DB::RAW('photos.*, folders.name as folder_name, folders.type'))
                            ->where('type', 'logo')
                            ->orderBy('photos.name')
                            ->get();

        // GET TAG ICON
        // ------------
        $data['icon_dir'] = Folder::select('id', 'name', 'type')
                                ->where('type', 'tag')
                                ->orderBy('folders.name')
                                ->get();
        $data['icon'] = Photo::join('folders', 'photos.folder_id', '=', 'folders.id')
                            ->select(DB::RAW('photos.*, folders.name as folder_name, folders.type'))
                            ->where('type', 'tag')
                            ->orderBy('photos.name')
                            ->get();

        // GET NAVIGATION IMAGE
        // --------------------
        $data['nav_dir'] = Folder::select('id', 'name', 'type')
                                ->where('type', 'navigation')
                                ->orderBy('folders.name')
                                ->get();
        $data['nav'] = Photo::join('folders', 'photos.folder_id', '=', 'folders.id')
                            ->select(DB::RAW('photos.*, folders.name as folder_name, folders.type'))
                            ->where('type', 'navigation')
                            ->orderBy('photos.name')
                            ->get();

        // GET OTHER IMAGE
        // ---------------
        $data['other_dir'] = Folder::select('id', 'name', 'type')
                                    ->where('type', 'other')
                                    ->orderBy('folders.name')
                                    ->get();
        $data['other'] = Photo::join('folders', 'photos.folder_id', '=', 'folders.id')
                            ->select(DB::RAW('photos.*, folders.name as folder_name, folders.type'))
                            ->where('type', 'other')
                            ->orderBy('photos.name')
                            ->get();

        // return json_encode($data);
        return view('photo/photo-list', $data);
    }

    public function doUpload()
    {
        // return Input::all();
        $folderData = Folder::select('id', 'name', 'type')->get();

        for($i=0;$i<sizeof($_FILES['imageFile']['tmp_name']);$i++) {

            $filename = $_FILES['imageFile']['tmp_name'][$i];
            $basename = basename($_FILES['imageFile']['name'][$i]);
            $target_file = $_SERVER['DOCUMENT_ROOT']."/".env('APP_ROOT_DIR')."/public/assets/image/image-storage/".$basename;
            $target_file = preg_replace('/ /', '_', $target_file);
            $basename = preg_replace('/ /', '_', $basename);
            $imageFileType = pathinfo($target_file, PATHINFO_EXTENSION);

            //file type validation
            if(strtoupper($imageFileType) == "JPG" || strtoupper($imageFileType) == "JPEG" || strtoupper($imageFileType) == "PNG") {

                //upload new file first
                move_uploaded_file($filename, $target_file);

                //get image type
                $type = $_POST['file-type'][$i];

                // get folder type
                $ftype = $_POST['folder-type'][$i];

                if($type == "Tile Photo") {

                    // FOLDERING
                    // ---------
                    $folderId = 0;
                    foreach($folderData as $d) {
                        if($ftype == "auto") {
                            if(strpos(strtolower($basename), strtolower($d->name)) !== false && $d->type == 'tile') {
                                $folderId = $d->id;
                                break;
                            }
                        }else if($ftype == "root") {
                            if(strpos(strtolower($d->name), 'root') !== false && $d->type == 'tile') {
                                $folderId = $d->id;
                                break;
                            }
                        }else {
                            if($d->name == $ftype && $d->type == 'tile') {
                                $folderId = $d->id;
                                break;
                            }
                        }
                    }
                    $photoModel = new Photo;
                    $photoModel->folder_id = $folderId;
                    $photoModel->name = $basename;
                    $photoModel->save();
                    
                    // COPY KE STORAGE
                    // ---------------
                    $target_file = $_SERVER['DOCUMENT_ROOT']."/".env('APP_ROOT_DIR')."/public/assets/image/image-storage/".$basename;
                    $target_file = preg_replace('/ /', '_', $target_file);

                    list($width, $height) = getimagesize($target_file);

                    $basenameArray = explode(".", $basename);
                    if(strtolower($basenameArray[sizeof($basenameArray)-1]) == "jpg" || strtolower($basenameArray[sizeof($basenameArray)-1]) == "jpeg") {
                        $im = imagecreatefromjpeg($target_file);
                    }else if(strtolower($basenameArray[sizeof($basenameArray)-1]) == "png") {
                        $im = imagecreatefrompng($target_file);
                    }

                    if($width != $height) {
                        $margin = abs($width - $height)/2;

                        //pilih skala antara lebar atau tinggi yang lebih kecil
                        $crop_measure = min($width, $height);

                        //atur parameter buat crop nya
                        if($width > $height) {
                            $crop_array = array(
                                'x' => $margin,
                                'y' => 0,
                                'width' => $crop_measure,
                                'height' => $crop_measure
                            );
                        }else {
                            $crop_array = array(
                                'x' => 0,
                                'y' => $margin,
                                'width' => $crop_measure,
                                'height' => $crop_measure
                            );
                        }

                        $thumb_im = imagecrop($im, $crop_array);
                        if(strtolower($basenameArray[sizeof($basenameArray)-1]) == "jpg" || strtolower($basenameArray[sizeof($basenameArray)-1]) == "jpeg") {
                            imagejpeg($thumb_im, ($_SERVER['DOCUMENT_ROOT']."/".env('APP_ROOT_DIR')."/public/assets/image/item-image/".$basename));
                        }else if(strtolower($basenameArray[sizeof($basenameArray)-1]) == "png") {
                            imagepng($thumb_im, ($_SERVER['DOCUMENT_ROOT']."/".env('APP_ROOT_DIR')."/public/assets/image/item-image/".$basename));    
                        }
                    }else {
                        if(strtolower($basenameArray[sizeof($basenameArray)-1]) == "jpg" || strtolower($basenameArray[sizeof($basenameArray)-1]) == "jpeg") {
                            imagejpeg($im, ($_SERVER['DOCUMENT_ROOT']."/".env('APP_ROOT_DIR')."/public/assets/image/item-image/".$basename));
                        }else if(strtolower($basenameArray[sizeof($basenameArray)-1]) == "png") {
                            imagepng($im, ($$_SERVER['DOCUMENT_ROOT']."/".env('APP_ROOT_DIR')."/public/assets/image/item-image/".$basename));  
                        }
                    }
                    // unlink($target_file);
                    $target_file = $_SERVER['DOCUMENT_ROOT']."/".env('APP_ROOT_DIR')."/public/assets/image/item-image/".$basename;

                    // Get new sizes
                    list($width, $height) = getimagesize($target_file);
                    $newwidthXLarge = 500;
                    $newheightXLarge = 500;
                    $newwidthLarge = 350;
                    $newheightLarge = 350;
                    $newwidthMedium = 235;
                    $newheightMedium = 235;
                    $newwidthSmall = 106;
                    $newheightSmall = 106;

                    // Load
                    if(strtolower($basenameArray[sizeof($basenameArray)-1]) == "jpg" || sttolower($basenameArray[sizeof($basenameArray)-1]) == "jpeg") {
                        $source = imagecreatefromjpeg($target_file);
                    }else if(strtolower($basenameArray[sizeof($basenameArray)-1]) == "png") {
                        $source = imagecreatefrompng($target_file);
                    }

                    // Resize Extra Large
                    $thumb = imagecreatetruecolor($newwidthXLarge, $newheightXLarge);
                    if(strtolower($basenameArray[sizeof($basenameArray)-1]) == "png"){
                        imagecolortransparent($thumb, imagecolorallocatealpha($thumb, 0, 0, 0, 127));
                        imagealphablending($thumb, false);
                        imagesavealpha($thumb, true);
                    }
                    imagecopyresampled($thumb, $source, 0, 0, 0, 0, $newwidthXLarge, $newheightXLarge, $width, $height);

                    // Output Extra Large
                    if(strtolower($basenameArray[sizeof($basenameArray)-1]) == "jpg" || strtolower($basenameArray[sizeof($basenameArray)-1]) == "jpeg") {
                        imagejpeg($thumb, ($_SERVER['DOCUMENT_ROOT']."/".env('APP_ROOT_DIR')."/public/assets/image/item-image/xlarge/".$basename));   
                    }else if($basenameArray[sizeof($basenameArray)-1] == "png") {
                        imagepng($thumb, ($_SERVER['DOCUMENT_ROOT']."/".env('APP_ROOT_DIR')."/public/assets/image/item-image/xlarge/".$basename));    
                    }

                    // Resize Large
                    $thumb = imagecreatetruecolor($newwidthLarge, $newheightLarge);
                    if(strtolower($basenameArray[sizeof($basenameArray)-1]) == "png"){
                        imagecolortransparent($thumb, imagecolorallocatealpha($thumb, 0, 0, 0, 127));
                        imagealphablending($thumb, false);
                        imagesavealpha($thumb, true);
                    }
                    imagecopyresampled($thumb, $source, 0, 0, 0, 0, $newwidthLarge, $newheightLarge, $width, $height);

                    // Output Large
                    if(strtolower($basenameArray[sizeof($basenameArray)-1]) == "jpg" || strtolower($basenameArray[sizeof($basenameArray)-1]) == "jpeg") {
                        imagejpeg($thumb, ($_SERVER['DOCUMENT_ROOT']."/".env('APP_ROOT_DIR')."/public/assets/image/item-image/large/".$basename));    
                    }else if(strtolower($basenameArray[sizeof($basenameArray)-1]) == "png") {
                        imagepng($thumb, ($_SERVER['DOCUMENT_ROOT']."/".env('APP_ROOT_DIR')."/public/assets/image/item-image/large/".$basename)); 
                    }

                    // Resize Medium
                    $thumb = imagecreatetruecolor($newwidthMedium, $newheightMedium);
                    if(strtolower($basenameArray[sizeof($basenameArray)-1]) == "png"){
                        imagecolortransparent($thumb, imagecolorallocatealpha($thumb, 0, 0, 0, 127));
                        imagealphablending($thumb, false);
                        imagesavealpha($thumb, true);
                    }
                    imagecopyresampled($thumb, $source, 0, 0, 0, 0, $newwidthMedium, $newheightMedium, $width, $height);

                    // Output Medium
                    if(strtolower($basenameArray[sizeof($basenameArray)-1]) == "jpg" || strtolower($basenameArray[sizeof($basenameArray)-1]) == "jpeg") {
                        imagejpeg($thumb, ($_SERVER['DOCUMENT_ROOT']."/".env('APP_ROOT_DIR')."/public/assets/image/item-image/medium/".$basename));   
                    }else if(strtolower($basenameArray[sizeof($basenameArray)-1]) == "png") {
                        imagepng($thumb, ($_SERVER['DOCUMENT_ROOT']."/".env('APP_ROOT_DIR')."/public/assets/image/item-image/medium/".$basename));    
                    }

                    // Resize Small
                    $thumb = imagecreatetruecolor($newwidthSmall, $newheightSmall);
                    if(strtolower($basenameArray[sizeof($basenameArray)-1]) == "png"){
                        imagecolortransparent($thumb, imagecolorallocatealpha($thumb, 0, 0, 0, 127));
                        imagealphablending($thumb, false);
                        imagesavealpha($thumb, true);
                    }
                    imagecopyresampled($thumb, $source, 0, 0, 0, 0, $newwidthSmall, $newheightSmall, $width, $height);

                    // Output Small
                    if(strtolower($basenameArray[sizeof($basenameArray)-1]) == "jpg" || strtolower($basenameArray[sizeof($basenameArray)-1]) == "jpeg") {
                        imagejpeg($thumb, ($_SERVER['DOCUMENT_ROOT']."/".env('APP_ROOT_DIR')."/public/assets/image/item-image/small/".$basename));    
                    }else if(strtolower($basenameArray[sizeof($basenameArray)-1]) == "png") {
                        imagepng($thumb, ($_SERVER['DOCUMENT_ROOT']."/".env('APP_ROOT_DIR')."/public/assets/image/item-image/small/".$basename)); 
                    }

                    unlink($target_file);

                }else if($type == "Add On Photo") {

                    // FOLDERING
                    // ---------
                    $folderId = 0;
                    foreach($folderData as $d) {
                        if($ftype == "auto") {
                            if(strpos(strtolower($basename), strtolower($d->name)) !== false && $d->type == 'add_on') {
                                $folderId = $d->id;
                                break;
                            }
                        }else if($ftype == "root") {
                            if(strpos(strtolower($d->name), 'root') !== false && $d->type == 'add_on') {
                                $folderId = $d->id;
                                break;
                            }
                        }else {
                            if($d->name == $ftype && $d->type == 'add_on') {
                                $folderId = $d->id;
                                break;
                            }
                        }
                    }
                    $photoModel = new Photo;
                    $photoModel->folder_id = $folderId;
                    $photoModel->name = $basename;
                    $photoModel->save();
                    
                    // COPY KE STORAGE
                    // ---------------
                    $target_file = $_SERVER['DOCUMENT_ROOT']."/".env('APP_ROOT_DIR')."/public/assets/image/image-storage/".$basename;
                    $target_file = preg_replace('/ /', '_', $target_file);

                    list($width, $height) = getimagesize($target_file);

                    $basenameArray = explode(".", $basename);
                    if(strtolower($basenameArray[sizeof($basenameArray)-1]) == "jpg" || strtolower($basenameArray[sizeof($basenameArray)-1]) == "jpeg") {
                        $im = imagecreatefromjpeg($target_file);
                    }else if(strtolower($basenameArray[sizeof($basenameArray)-1]) == "png") {
                        $im = imagecreatefrompng($target_file);
                    }

                    if($width != $height) {
                        $margin = abs($width - $height)/2;

                        //pilih skala antara lebar atau tinggi yang lebih kecil
                        $crop_measure = min($width, $height);

                        //atur parameter buat crop nya
                        if($width > $height) {
                            $crop_array = array(
                                'x' => $margin,
                                'y' => 0,
                                'width' => $crop_measure,
                                'height' => $crop_measure
                            );
                        }else {
                            $crop_array = array(
                                'x' => 0,
                                'y' => $margin,
                                'width' => $crop_measure,
                                'height' => $crop_measure
                            );
                        }

                        $thumb_im = imagecrop($im, $crop_array);
                        if(strtolower($basenameArray[sizeof($basenameArray)-1]) == "jpg" || strtolower($basenameArray[sizeof($basenameArray)-1]) == "jpeg") {
                            imagejpeg($thumb_im, ($_SERVER['DOCUMENT_ROOT']."/".env('APP_ROOT_DIR')."/public/assets/image/item-image/add-on/".$basename));
                        }else if(strtolower($basenameArray[sizeof($basenameArray)-1]) == "png") {
                            imagepng($thumb_im, ($_SERVER['DOCUMENT_ROOT']."/".env('APP_ROOT_DIR')."/public/assets/image/item-image/add-on/".$basename));    
                        }
                    }else {
                        if(strtolower($basenameArray[sizeof($basenameArray)-1]) == "jpg" || strtolower($basenameArray[sizeof($basenameArray)-1]) == "jpeg") {
                            imagejpeg($im, ($_SERVER['DOCUMENT_ROOT']."/".env('APP_ROOT_DIR')."/public/assets/image/item-image/add-on/".$basename));
                        }else if(strtolower($basenameArray[sizeof($basenameArray)-1]) == "png") {
                            imagepng($im, ($$_SERVER['DOCUMENT_ROOT']."/".env('APP_ROOT_DIR')."/public/assets/image/item-image/add-on/".$basename));  
                        }
                    }
                    // unlink($target_file);
                    $target_file = $_SERVER['DOCUMENT_ROOT']."/".env('APP_ROOT_DIR')."/public/assets/image/item-image/add-on/".$basename;

                    // Get new sizes
                    list($width, $height) = getimagesize($target_file);
                    $newwidthXLarge = 500;
                    $newheightXLarge = 500;
                    $newwidthLarge = 350;
                    $newheightLarge = 350;
                    $newwidthMedium = 235;
                    $newheightMedium = 235;
                    $newwidthSmall = 106;
                    $newheightSmall = 106;

                    // Load
                    if(strtolower($basenameArray[sizeof($basenameArray)-1]) == "jpg" || strtolower($basenameArray[sizeof($basenameArray)-1]) == "jpeg") {
                        $source = imagecreatefromjpeg($target_file);
                    }else if(strtolower($basenameArray[sizeof($basenameArray)-1]) == "png") {
                        $source = imagecreatefrompng($target_file);
                    }

                    // Resize Extra Large
                    $thumb = imagecreatetruecolor($newwidthXLarge, $newheightXLarge);
                    if(strtolower($basenameArray[sizeof($basenameArray)-1]) == "png"){
                        imagecolortransparent($thumb, imagecolorallocatealpha($thumb, 0, 0, 0, 127));
                        imagealphablending($thumb, false);
                        imagesavealpha($thumb, true);
                    }
                    imagecopyresampled($thumb, $source, 0, 0, 0, 0, $newwidthXLarge, $newheightXLarge, $width, $height);

                    // Output Extra Large
                    if(strtolower($basenameArray[sizeof($basenameArray)-1]) == "jpg" || strtolower($basenameArray[sizeof($basenameArray)-1]) == "jpeg") {
                        imagejpeg($thumb, ($_SERVER['DOCUMENT_ROOT']."/".env('APP_ROOT_DIR')."/public/assets/image/item-image/add-on/xlarge/".$basename));   
                    }else if(strtolower($basenameArray[sizeof($basenameArray)-1]) == "png") {
                        imagepng($thumb, ($_SERVER['DOCUMENT_ROOT']."/".env('APP_ROOT_DIR')."/public/assets/image/item-image/add-on/xlarge/".$basename));    
                    }

                    // Resize Large
                    $thumb = imagecreatetruecolor($newwidthLarge, $newheightLarge);
                    if(strtolower($basenameArray[sizeof($basenameArray)-1]) == "png"){
                        imagecolortransparent($thumb, imagecolorallocatealpha($thumb, 0, 0, 0, 127));
                        imagealphablending($thumb, false);
                        imagesavealpha($thumb, true);
                    }
                    imagecopyresampled($thumb, $source, 0, 0, 0, 0, $newwidthLarge, $newheightLarge, $width, $height);

                    // Output Large
                    if(strtolower($basenameArray[sizeof($basenameArray)-1]) == "jpg" || strtolower($basenameArray[sizeof($basenameArray)-1]) == "jpeg") {
                        imagejpeg($thumb, ($_SERVER['DOCUMENT_ROOT']."/".env('APP_ROOT_DIR')."/public/assets/image/item-image/add-on/large/".$basename));    
                    }else if(strtolower($basenameArray[sizeof($basenameArray)-1]) == "png") {
                        imagepng($thumb, ($_SERVER['DOCUMENT_ROOT']."/".env('APP_ROOT_DIR')."/public/assets/image/item-image/add-on/large/".$basename)); 
                    }

                    // Resize Medium
                    $thumb = imagecreatetruecolor($newwidthMedium, $newheightMedium);
                    if(strtolower($basenameArray[sizeof($basenameArray)-1]) == "png"){
                        imagecolortransparent($thumb, imagecolorallocatealpha($thumb, 0, 0, 0, 127));
                        imagealphablending($thumb, false);
                        imagesavealpha($thumb, true);
                    }
                    imagecopyresampled($thumb, $source, 0, 0, 0, 0, $newwidthMedium, $newheightMedium, $width, $height);

                    // Output Medium
                    if(strtolower($basenameArray[sizeof($basenameArray)-1]) == "jpg" || strtolower($basenameArray[sizeof($basenameArray)-1]) == "jpeg") {
                        imagejpeg($thumb, ($_SERVER['DOCUMENT_ROOT']."/".env('APP_ROOT_DIR')."/public/assets/image/item-image/add-on/medium/".$basename));   
                    }else if(strtolower($basenameArray[sizeof($basenameArray)-1]) == "png") {
                        imagepng($thumb, ($_SERVER['DOCUMENT_ROOT']."/".env('APP_ROOT_DIR')."/public/assets/image/item-image/add-on/medium/".$basename));    
                    }

                    // Resize Small
                    $thumb = imagecreatetruecolor($newwidthSmall, $newheightSmall);
                    if(strtolower($basenameArray[sizeof($basenameArray)-1]) == "png"){
                        imagecolortransparent($thumb, imagecolorallocatealpha($thumb, 0, 0, 0, 127));
                        imagealphablending($thumb, false);
                        imagesavealpha($thumb, true);
                    }
                    imagecopyresampled($thumb, $source, 0, 0, 0, 0, $newwidthSmall, $newheightSmall, $width, $height);

                    // Output Small
                    if(strtolower($basenameArray[sizeof($basenameArray)-1]) == "jpg" || strtolower($basenameArray[sizeof($basenameArray)-1]) == "jpeg") {
                        imagejpeg($thumb, ($_SERVER['DOCUMENT_ROOT']."/".env('APP_ROOT_DIR')."/public/assets/image/item-image/add-on/small/".$basename));    
                    }else if(strtolower($basenameArray[sizeof($basenameArray)-1]) == "png") {
                        imagepng($thumb, ($_SERVER['DOCUMENT_ROOT']."/".env('APP_ROOT_DIR')."/public/assets/image/item-image/add-on/small/".$basename)); 
                    }

                    unlink($target_file);
                }else if($type == "Logo Picture") {

                    // FOLDERING
                    // ---------
                    $folderId = 0;
                    foreach($folderData as $d) {
                        if($ftype == "auto") {
                            if(strpos(strtolower($basename), strtolower($d->name)) !== false && $d->type == 'logo') {
                                $folderId = $d->id;
                                break;
                            }
                        }else if($ftype == "root") {
                            if(strpos(strtolower($d->name), 'root') !== false && $d->type == 'logo') {
                                $folderId = $d->id;
                                break;
                            }
                        }else {
                            if($d->name == $ftype && $d->type == 'logo') {
                                $folderId = $d->id;
                                break;
                            }
                        }
                    }
                    $photoModel = new Photo;
                    $photoModel->folder_id = $folderId;
                    $photoModel->name = $basename;
                    $photoModel->save();
                    
                    // COPY KE STORAGE
                    // ---------------
                    $target_file = $_SERVER['DOCUMENT_ROOT']."/".env('APP_ROOT_DIR')."/public/assets/image/image-storage/".$basename;
                    $target_file = preg_replace('/ /', '_', $target_file);

                    $basenameArray = explode(".", $basename);
                    if(strtolower($basenameArray[sizeof($basenameArray)-1]) == "jpg" || $basenameArray[sizeof($basenameArray)-1] == "jpeg") {
                        $im = imagecreatefromjpeg($target_file);
                        imagejpeg($im, ($_SERVER['DOCUMENT_ROOT']."/".env('APP_ROOT_DIR')."/public/assets/image/logo-image/".$basename));
                    }else if(strtolower($basenameArray[sizeof($basenameArray)-1]) == "png") {
                        $im = imagecreatefrompng($target_file);
                        imagepng($im, ($_SERVER['DOCUMENT_ROOT']."/".env('APP_ROOT_DIR')."/public/assets/image/logo-image/".$basename));
                    }

                    unlink($target_file);
                }else if($type == "Tag Icon"){

                    // FOLDERING
                    // ---------
                    $folderId = 0;
                    foreach($folderData as $d) {
                        if($ftype == "auto") {
                            if(strpos(strtolower($basename), strtolower($d->name)) !== false && $d->type == 'tag') {
                                $folderId = $d->id;
                                break;
                            }
                        }else if($ftype == "root") {
                            if(strpos(strtolower($d->name), 'root') !== false && $d->type == 'tag') {
                                $folderId = $d->id;
                                break;
                            }
                        }else {
                            if($d->name == $ftype && $d->type == 'tag') {
                                $folderId = $d->id;
                                break;
                            }
                        }
                    }
                    $photoModel = new Photo;
                    $photoModel->folder_id = $folderId;
                    $photoModel->name = $basename;
                    $photoModel->save();
                    
                    // COPY KE STORAGE
                    // ---------------
                    $target_file = $_SERVER['DOCUMENT_ROOT']."/".env('APP_ROOT_DIR')."/public/assets/image/image-storage/".$basename;
                    $target_file = preg_replace('/ /', '_', $target_file);

                    list($width, $height) = getimagesize($target_file);

                    $basenameArray = explode(".", $basename);

                    // Get new sizes
                    list($width, $height) = getimagesize($target_file);
                    $newwidth = 47;
                    $newheight = 44;

                    // Load
                    if(strtolower($basenameArray[sizeof($basenameArray)-1]) == "jpg" || strtolower($basenameArray[sizeof($basenameArray)-1]) == "jpeg") {
                        $source = imagecreatefromjpeg($target_file);
                    }else if(strtolower($basenameArray[sizeof($basenameArray)-1]) == "png") {
                        $source = imagecreatefrompng($target_file);
                    }

                    // Resize
                    $thumb = imagecreatetruecolor($newwidth, $newheight);
                    if(strtolower($basenameArray[sizeof($basenameArray)-1]) == "png"){
                        imagecolortransparent($thumb, imagecolorallocatealpha($thumb, 0, 0, 0, 127));
                        imagealphablending($thumb, false);
                        imagesavealpha($thumb, true);
                    }
                    imagecopyresampled($thumb, $source, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);

                    // Output
                    if(strtolower($basenameArray[sizeof($basenameArray)-1]) == "jpg" || strtolower($basenameArray[sizeof($basenameArray)-1]) == "jpeg") {
                        imagejpeg($thumb, ($_SERVER['DOCUMENT_ROOT']."/".env('APP_ROOT_DIR')."/public/assets/image/tag-icon/".$basename));   
                    }else if(strtolower($basenameArray[sizeof($basenameArray)-1]) == "png") {
                        imagepng($thumb, ($_SERVER['DOCUMENT_ROOT']."/".env('APP_ROOT_DIR')."/public/assets/image/tag-icon/".$basename));    
                    }

                    unlink($target_file);
                }else if($type == "Navigation Picture") {

                    // FOLDERING
                    // ---------
                    $folderId = 0;
                    foreach($folderData as $d) {
                        if($ftype == "auto") {
                            if(strpos(strtolower($basename), strtolower($d->name)) !== false && $d->type == 'navigation') {
                                $folderId = $d->id;
                                break;
                            }
                        }else if($ftype == "root") {
                            if(strpos(strtolower($d->name), 'root') !== false && $d->type == 'navigation') {
                                $folderId = $d->id;
                                break;
                            }
                        }else {
                            if($d->name == $ftype && $d->type == 'navigation') {
                                $folderId = $d->id;
                                break;
                            }
                        }
                    }
                    $photoModel = new Photo;
                    $photoModel->folder_id = $folderId;
                    $photoModel->name = $basename;
                    $photoModel->save();
                    
                    // COPY KE STORAGE
                    // ---------------
                    $target_file = $_SERVER['DOCUMENT_ROOT']."/".env('APP_ROOT_DIR')."/public/assets/image/image-storage/".$basename;
                    $target_file = preg_replace('/ /', '_', $target_file);

                    list($width, $height) = getimagesize($target_file);
                    if($width < 336 || $height < 162) {
                        return Redirect::back()->withErrors(["Picture's size must be larger than 336 x 162"]);
                    }else {
                        list($width, $height) = getimagesize($target_file);

                        $basenameArray = explode(".", $basename);
                        if(strtolower($basenameArray[sizeof($basenameArray)-1]) == "jpg" || strtolower($basenameArray[sizeof($basenameArray)-1]) == "jpeg") {
                            $im = imagecreatefromjpeg($target_file);
                        }else if(strtolower($basenameArray[sizeof($basenameArray)-1]) == "png") {
                            $im = imagecreatefrompng($target_file);
                        }

                        if($width < $height) {
                            return Redirect::back()->withErrors(["Picture's width must be larger than its height"]);
                        }else {
                            if(strtolower($basenameArray[sizeof($basenameArray)-1]) == "jpg" || strtolower($basenameArray[sizeof($basenameArray)-1]) == "jpeg") {
                                imagejpeg($im, ($_SERVER['DOCUMENT_ROOT']."/".env('APP_ROOT_DIR')."/public/assets/image/nav-image/".$basename));
                            }else if(strtolower($basenameArray[sizeof($basenameArray)-1]) == "png") {
                                imagepng($im, ($$_SERVER['DOCUMENT_ROOT']."/".env('APP_ROOT_DIR')."/public/assets/image/nav-image/".$basename));  
                            }

                            unlink($target_file);
                            $target_file = $_SERVER['DOCUMENT_ROOT']."/".env('APP_ROOT_DIR')."/public/assets/image/nav-image/".$basename;

                            // Get new sizes
                            list($width, $height) = getimagesize($target_file);
                            $newwidth = 336;
                            $newheight = 162;

                            // Load
                            if(strtolower($basenameArray[sizeof($basenameArray)-1]) == "jpg" || strtolower($basenameArray[sizeof($basenameArray)-1]) == "jpeg") {
                                $source = imagecreatefromjpeg($target_file);
                            }else if(strtolower($basenameArray[sizeof($basenameArray)-1]) == "png") {
                                $source = imagecreatefrompng($target_file);
                            }

                            // Resize
                            $thumb = imagecreatetruecolor($newwidth, $newheight);
                            if(strtolower($basenameArray[sizeof($basenameArray)-1]) == "png"){
                                imagecolortransparent($thumb, imagecolorallocatealpha($thumb, 0, 0, 0, 127));
                                imagealphablending($thumb, false);
                                imagesavealpha($thumb, true);
                            }
                            imagecopyresampled($thumb, $source, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);

                            // Output Extra Large
                            if(strtolower($basenameArray[sizeof($basenameArray)-1]) == "jpg" || strtolower($basenameArray[sizeof($basenameArray)-1]) == "jpeg") {
                                imagejpeg($thumb, ($_SERVER['DOCUMENT_ROOT']."/".env('APP_ROOT_DIR')."/public/assets/image/nav-image/".$basename));   
                            }else if(strtolower($basenameArray[sizeof($basenameArray)-1]) == "png") {
                                imagepng($thumb, ($_SERVER['DOCUMENT_ROOT']."/".env('APP_ROOT_DIR')."/public/assets/image/nav-image/".$basename));    
                            }
                        }
                    }
                }else {
                    // FOLDERING
                    // ---------
                    $folderId = 0;
                    foreach($folderData as $d) {
                        if($ftype == "auto") {
                            if(strpos(strtolower($basename), strtolower($d->name)) !== false && $d->type == 'other') {
                                $folderId = $d->id;
                                break;
                            }
                        }else if($ftype == "root") {
                            if(strpos(strtolower($d->name), 'root') !== false && $d->type == 'other') {
                                $folderId = $d->id;
                                break;
                            }
                        }else {
                            if($d->name == $ftype && $d->type == 'other') {
                                $folderId = $d->id;
                                break;
                            }
                        }
                    }
                    $photoModel = new Photo;
                    $photoModel->folder_id = $folderId;
                    $photoModel->name = $basename;
                    $photoModel->save();
                }
            }           

        }
        return Redirect::to('photo-manager');
    }

    public function getAllFolderType()
    {
        $type = Input::input('type');
        $data = Folder::select('id', 'name')->where('type', $type)->where('name', 'NOT LIKE', '%root%')->get();
        return json_encode($data);
    }

    public function delPhoto()
    {
        // return Input::all();
        $data = json_decode(Input::input('data'));
        foreach($data as $d) {
            if($d->type == 'tile') {
                $target_file = $_SERVER['DOCUMENT_ROOT']."/".env('APP_ROOT_DIR')."/public/assets/image/item-image/small/".$d->name;
                unlink($target_file);
                $target_file = $_SERVER['DOCUMENT_ROOT']."/".env('APP_ROOT_DIR')."/public/assets/image/item-image/medium/".$d->name;
                unlink($target_file);
                $target_file = $_SERVER['DOCUMENT_ROOT']."/".env('APP_ROOT_DIR')."/public/assets/image/item-image/large/".$d->name;
                unlink($target_file);
                $target_file = $_SERVER['DOCUMENT_ROOT']."/".env('APP_ROOT_DIR')."/public/assets/image/item-image/xlarge/".$d->name;
                unlink($target_file);
                Photo::where('name', $d->name)->delete();
            }else if($d->type == 'add-on') {
                $target_file = $_SERVER['DOCUMENT_ROOT']."/".env('APP_ROOT_DIR')."/public/assets/image/item-image/add-on/".$d->name;
                unlink($target_file);
                Photo::where('name', $d->name)->delete();
            }else if($d->type == 'logo') {
                $target_file = $_SERVER['DOCUMENT_ROOT']."/".env('APP_ROOT_DIR')."/public/assets/image/logo-image/".$d->name;
                unlink($target_file);
                Photo::where('name', $d->name)->delete();
            }else if($d->type == 'icon') {
                $target_file = $_SERVER['DOCUMENT_ROOT']."/".env('APP_ROOT_DIR')."/public/assets/image/tag-icon/".$d->name;
                unlink($target_file);
                Photo::where('name', $d->name)->delete();
            }else if($d->type == 'navigation') {
                $target_file = $_SERVER['DOCUMENT_ROOT']."/".env('APP_ROOT_DIR')."/public/assets/image/nav-image/".$d->name;
                unlink($target_file);
                Photo::where('name', $d->name)->delete();
            }else if($d->type == 'other') {
                $target_file = $_SERVER['DOCUMENT_ROOT']."/".env('APP_ROOT_DIR')."/public/assets/image/image-storage/".$d->name;
                unlink($target_file);
                Photo::where('name', $d->name)->delete();
            }
        }
        return Redirect::to('photo-manager');
    }

    public function addFolder()
    {
        // return Input::all();
        $type = Input::input('type');
        $name = Input::input('name');

        $folderModel = new Folder;
        $folderModel->type = $type;
        $folderModel->name = $name;
        $folderModel->save();

        return Redirect::back();
    }

    public function editFolder()
    {
        // return Input::all();
        $id = Input::input('id');
        $name = Input::input('name');

        $folderModel = Folder::find($id);
        $folderModel->name = $name;
        $folderModel->save();

        return Redirect::back();
    }

    public function getFolderData()
    {
        $id = Input::input('id');
        $data = Folder::find($id);
        return json_encode($data);
    }

    public function delFolder()
    {
        // return Input::all();
        $data = json_decode(Input::input('data'));
        foreach($data as $d) {
            $folderRootId = Folder::where('name', 'LIKE', '%root%')->where('type', $d->type)->first()->id;
            Photo::where('folder_id', $d->id)->update(['folder_id' => $folderRootId]);
            Folder::find($d->id)->delete();
        }
        return Redirect::back();
    }

    public function changeFolder()
    {
        // return Input::all();
        $dataId = json_decode(Input::input('id-array'));
        $photoType = Input::input('photo-type');
        $moveFolder = Input::input('move-folder');
        $folderName = Input::input('move-folder-name');
        if($folderName == "root") {
            $folderId = Folder::where('type', $photoType)->where('name', 'LIKE', '%root%')->first()->id;
            foreach($dataId as $id) {
                $photoModel = Photo::find($id);
                $photoModel->folder_id = $folderId;
                $photoModel->save();
            }
        }else if($folderName == "auto") {
            $allFolder = Folder::select('id', 'name')->get();
            $folderId = Folder::where('type', $photoType)->where('name', 'LIKE', '%root%')->first()->id;
            foreach($dataId as $id) {
                $photoModel = Photo::find($id);
                foreach($allFolder as $d) {
                    if(strpos($photoModel->name, $d->name) !== false) {
                        $folderId = $d->id;
                    }
                }
                $photoModel->folder_id = $folderId;
                $photoModel->save();
            }
        }else {
            $folderId = Folder::where('type', $photoType)->where('name', $folderName)->first()->id;
            foreach($dataId as $id) {
                $photoModel = Photo::find($id);
                $photoModel->folder_id = $folderId;
                $photoModel->save();
            }
        }
        return Redirect::back();
    }

}