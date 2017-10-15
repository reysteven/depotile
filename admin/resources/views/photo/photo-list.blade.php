@extends('base')

@section('content')
    <form method="POST" id="del-photo-form" action="{{ url('doDeletePhoto') }}">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <input type="hidden" name="data">
    </form>
    <form method="POST" id="del-folder-form" action="{{ url('doDeleteFolder') }}">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <input type="hidden" name="data">
    </form>
    <div id="wrapper">

        <input type="hidden" id="getAllFolderTypeLink" value="{{ url('doGetAllFolderType') }}">
        <input type="hidden" id="addFolderLink" value="{{ url('doAddFolder') }}">
        <input type="hidden" id="editFolderLink" value="{{ url('doEditFolder') }}">
        <input type="hidden" id="getFolderDataLink" value="{{ url('doGetFolderData') }}">
        <input type="hidden" id="deleteFolderLink" value="{{ url('doDeleteFolder') }}">

        <div class="modal fade" id="myModalDelPhotoConfirmation" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="top:30%">
            <div class="modal-dialog" style="width:30%; color:black">
                <div class="modal-content">
                    <div class="modal-body row">
                        <p class="text-center">Are you sure for deleting this/these photo?</p>
                        <div class="text-center">
                            <input type="hidden" name="type">
                            <input type="hidden" name="id">
                            <input type="button" class="btn btn-warning" value="Yes" style="width:15%" name="delPhotoConfirmButton">
                            <input type="button" class="btn btn-default" value="No" style="width:15%" data-dismiss="modal">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="myModalDelFolderConfirmation" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="top:30%">
            <div class="modal-dialog" style="width:30%; color:black">
                <div class="modal-content">
                    <div class="modal-body row">
                        <p class="text-center">Are you sure for deleting this folder? (all photo inside folder will be moved to root folder)</p>
                        <div class="text-center">
                            <input type="hidden" name="type">
                            <input type="hidden" name="id">
                            <input type="button" class="btn btn-warning" value="Yes" style="width:15%" name="delFolderConfirmButton">
                            <input type="button" class="btn btn-default" value="No" style="width:15%" data-dismiss="modal">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="myModalAddFolder" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog" style="width:50%">
                <div class="modal-content">
                    <div class="modal-header" style="background-color:#224098; color:white">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h4 class="title text-center"></h4>
                    </div>
                    <div class="modal-body row" style="color:black">
                        <div class="error-msg col-sm-12 text-center" style="margin-top:1%; color:red"></div>
                        <div class="loading-div text-center hidden">
                            <span class="fa fa-spinner fa-spin fa-2x"></span>
                        </div>
                        <div class="content">
                            <form method="POST" action="{{ url('doAddFolder') }}" id="folderForm">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <input type="hidden" name="id">
                                <input type="hidden" name="type">
                                <div class="form-group col-xs-12">
                                    <div class="col-xs-4">Name</div>
                                    <div class="col-xs-1">:</div>
                                    <div class="col-xs-7">
                                        <input type="text" class="form-control" name="name">
                                    </div>
                                </div>
                                <div class="col-xs-12">
                                    <div class="col-xs-12">
                                        <input type="submit" class="btn btn-primary pull-right" value="Submit">
                                        <input type="button" class="btn btn-default pull-right" value="Cancel" data-dismiss="modal">
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="myModalMoveFolder" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog" style="width:50%">
                <div class="modal-content">
                    <div class="modal-header" style="background-color:#224098; color:white">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h4 class="title text-center">Move to Another Folder</h4>
                    </div>
                    <div class="modal-body row" style="color:black">
                        <div class="error-msg col-sm-12 text-center" style="margin-top:1%; color:red"></div>
                        <div class="loading-div text-center hidden">
                            <span class="fa fa-spinner fa-spin fa-2x"></span>
                        </div>
                        <div class="content">
                            <form method="POST" action="{{ url('doChangeFolder') }}" id="change-folder-form">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <input type="hidden" name="id-array">
                                <input type="hidden" name="photo-type">
                                <div class="form-group col-xs-12 moveFolder">
                                    <label>Please select folder as this/these photo(s)' new location:</label><br>
                                    <select class="form-control folder-name" name="move-folder-name"></select>
                                </div>
                                <div class="col-xs-12">
                                    <input type="submit" class="btn btn-primary pull-right" value="Submit" style="margin-left:1%">
                                    <input type="button" class="btn btn-default pull-right" value="Cancel" data-dismiss="modal">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Photo Manager</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Photo Manager
                        </div>
                        <div class="panel-body" style="font-weight:normal">
                            <div class="col-xs-10 col-xs-offset-1 text-center">
                                Upload your photo here!
                                {!! Form::open(['url' => 'doUploadPhoto', 'files' => true, 'id' => 'photo-uploader-form']) !!}
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    <br>
                                    <div class="form-group col-xs-12" style="padding:0">
                                        <input type="file" class="hidden" name="imageFile[]">
                                        <div class="col-xs-2" style="padding:0 1%">
                                            <select class="form-control file-type" name="file-type[]">
                                                <option>Tile Photo</option>
                                                <option>Add On Photo</option>
                                                <option>Logo Picture</option>
                                                <option>Tag Icon</option>
                                                <option>Navigation Picture</option>
                                                <option>Other</option>
                                            </select>
                                        </div>
                                        <div class="col-xs-2" style="padding:0 1%">
                                            <select class="form-control folder-type" name="folder-type[]"></select>
                                        </div>
                                        <div class="col-xs-4" style="padding:0 1%">
                                            <input type="text" class="form-control file-name-text" disabled>
                                        </div>
                                        <div class="col-xs-2" style="padding:0 1%">
                                            <input type="button" class="btn btn-default file-browser" value="Browse" style="width:100%">
                                        </div>
                                        <div class="col-xs-1" style="padding:0 1%">
                                            <button type="button" class="btn btn-default add-file-uploader">
                                                <span class="fa fa-plus"></span>
                                            </button>
                                        </div>
                                    </div>
                                {!! Form::close() !!}
                                <br><br>
                                <div class="col-xs-12" style="margin-top:1%">
                                    <input type="submit" id="photo-uploader-submit" class="btn btn-default" value="Kirim">
                                </div>
                            </div>
                            <ul class="nav nav-pills col-xs-9" style="margin-top:2%">
                                <li class="active"><a href="#tile" data-toggle="tab">Tile Photo</a></li>
                                <li><a href="#addon" data-toggle="tab">Add On Photo</a></li>
                                <li><a href="#logo" data-toggle="tab">Logo Picture</a></li>
                                <li><a href="#icon" data-toggle="tab">Tag Icon</a></li>
                                <li><a href="#navigation" data-toggle="tab">Navigation Picture</a></li>
                                <li><a href="#media" data-toggle="tab">Other Media</a></li>
                            </ul>
                            <div class="col-xs-3">
                                <input type="button" class="btn btn-danger pull-right delete-all-btn" value="Delete Selected" data-toggle="modal" data-target="#myModalDelPhotoConfirmation">
                            </div>
                            <div class="tab-content">
                                <div class="col-xs-12 tab-pane fade in active" id="tile" style="padding-top:2%">
                                    <div class="col-xs-12" style="padding:0">
                                        <div class="col-xs-2" style="padding:0"><h4>Folder List</h4></div>
                                        <div class="col-xs-3 col-xs-offset-6">
                                            <input type="button" class="btn btn-warning pull-right move-folder-btn" value="Move to Another Folder" data-toggle="modal" data-target="#myModalMoveFolder" data-type="tile">
                                        </div>
                                        <div class="col-xs-1" style="padding:0">
                                            <input type="button" class="btn btn-primary pull-right" value="Add Folder" data-toggle="modal" data-target="#myModalAddFolder" data-action="add" data-type="tile">
                                        </div>
                                    </div>
                                    <div class="col-xs-12" style="padding:0"><hr style="margin-top:3px; margin-bottom:10px"></div>
                                    <ul class="nav nav-pills nav-stacked col-xs-2">
                                        <li class="active"><a href="#tile_root" data-toggle="tab">root</a></li>
                                        <?php
                                            foreach($tile_dir as $d) {
                                                if(strpos($d->name, "root") === false) {
                                        ?>
                                        <li><a href="#{{ $d->name }}" data-toggle="tab">
                                            {{ $d->name }}
                                            <button class="btn btn-default pull-right del-folder-btn" style="padding:0; background:none; border:none; margin-left:3%" data-toggle="modal" data-target="#myModalDelFolderConfirmation" data-type="tile" data-id="{{ $d->id }}">
                                                <span class="fa fa-trash"></span>
                                            </button>
                                            <button class="btn btn-default pull-right edit-folder-btn" style="padding:0; background:none; border:none" data-toggle="modal" data-target="#myModalAddFolder" data-type="tile" data-id="{{ $d->id }}">
                                                <span class="fa fa-pencil"></span>
                                            </button>
                                        </a></li>
                                        <?php
                                                }
                                            }
                                        ?>
                                    </ul>
                                    <div class="tab-content col-xs-10">
                                        <div class="col-xs-12 tab-pane fade in active" id="tile_root">
                                            <table class="col-xs-12">
                                                <tr>
                                        <?php
                                            $counter = 0;
                                            $photoExist = false;
                                            $fileArray = [];
                                            foreach($tile as $d) {
                                                if($d->folder_name == 'tile_root') {
                                                    $counter++;
                                                    array_push($fileArray, $d->name);
                                                    $photoExist = true;
                                        ?>
                                                    <td class="col-xs-3">
                                                        <div class="check-img-btn-wrapper">
                                                            <input type="checkbox" class="check-img-btn" data-id="{{ $d->id }}" data-type="tile" data-name="{{ $d->name }}">
                                                        </div>
                                                        <div class="image-wrapper">
                                                            <img src="{{ asset('public/assets/image/item-image/medium/'.$d->name) }}" width="100%">
                                                        </div>
                                                    </td>
                                        <?php
                                                    if($counter == 4) {
                                                        $string = '
                                                            </tr>
                                                            <tr>';
                                                        foreach($fileArray as $d) {
                                                            $string .= '<td class="col-xs-3 text-center" style="padding-bottom:10px; word-wrap:break-word; max-width:1px">'.$d.'</td>';
                                                        }
                                                        $string .= '</tr><tr>';
                                                        echo $string;
                                                        $fileArray = [];
                                                        $counter = 0;
                                                    }
                                                }
                                            }
                                            // print nama image jika baris akhir tidak sampai 4 kolom
                                            if($counter != 4) {
                                                $string = '
                                                    </tr>
                                                    <tr>';
                                                foreach($fileArray as $f) {
                                                    $string .= '<td class="col-xs-3 text-center" style="padding-bottom:10px; word-wrap:break-word; max-width:1px">'.$f.'</td>';
                                                }
                                                $string .= '</tr><tr>';
                                                echo $string;
                                            }
                                            if($photoExist == false) {
                                                $string .= '<td class="col-xs-12 text-center" colspan="4"><h4>NO PHOTO FOUND</h4></td></tr>';
                                                echo $string;
                                            }
                                        ?>
                                            </table>
                                        </div>
                                        @foreach($tile_dir as $d)
                                        <?php
                                            if(strpos($d->name, "root") === false) {
                                        ?>
                                        <div class="col-xs-12 tab-pane fade" id="{{ $d->name }}">
                                            <table class="col-xs-12">
                                                <tr>
                                        <?php
                                            $counter = 0;
                                            $photoExist = false;
                                            $fileArray = [];
                                            foreach($tile as $dd) {
                                                if($dd->folder_name == $d->name) {
                                                    $counter++;
                                                    array_push($fileArray, $dd->name);
                                                    $photoExist = true;
                                        ?>
                                                    <td class="col-xs-3">
                                                        <div class="check-img-btn-wrapper">
                                                            <input type="checkbox" class="check-img-btn" data-id="{{ $dd->id }}" data-type="tile" data-name="{{ $dd->name }}">
                                                        </div>
                                                        <div class="image-wrapper">
                                                            <img src="{{ asset('public/assets/image/item-image/medium/'.$dd->name) }}" width="100%">
                                                        </div>
                                                    </td>
                                        <?php
                                                    if($counter == 4) {
                                                        $string = '
                                                            </tr>
                                                            <tr>';
                                                        foreach($fileArray as $ddd) {
                                                            $string .= '<td class="col-xs-3 text-center" style="padding-bottom:10px; word-wrap:break-word; max-width:1px">'.$ddd.'</td>';
                                                        }
                                                        $string .= '</tr><tr>';
                                                        echo $string;
                                                        $fileArray = [];
                                                        $counter = 0;
                                                    }
                                                }
                                            }
                                            // print nama image jika baris akhir tidak sampai 4 kolom
                                            if($counter != 4) {
                                                $string = '
                                                    </tr>
                                                    <tr>';
                                                foreach($fileArray as $f) {
                                                    $string .= '<td class="col-xs-3 text-center" style="padding-bottom:10px; word-wrap:break-word; max-width:1px">'.$f.'</td>';
                                                }
                                                $string .= '</tr><tr>';
                                                echo $string;
                                            }
                                            if($photoExist == false) {
                                                $string = '<td class="col-xs-12 text-center" colspan="4"><h4>NO PHOTO FOUND</h4></td></tr>';
                                                echo $string;
                                            }
                                        ?>
                                            </table>
                                        </div>
                                        <?php
                                            }
                                        ?>
                                        @endforeach
                                    </div>
                                </div>
                                <div class="col-xs-12 tab-pane fade" id="addon" style="padding-top:2%">
                                    <div class="col-xs-12" style="padding:0">
                                        <div class="col-xs-2" style="padding:0"><h4>Folder List</h4></div>
                                        <div class="col-xs-3 col-xs-offset-6">
                                            <input type="button" class="btn btn-warning pull-right move-folder-btn" value="Move to Another Folder" data-toggle="modal" data-target="#myModalMoveFolder" data-type="add_on">
                                        </div>
                                        <div class="col-xs-1" style="padding:0">
                                            <input type="button" class="btn btn-primary pull-right" value="Add Folder" data-toggle="modal" data-target="#myModalAddFolder" data-action="add" data-type="add_on">
                                        </div>
                                    </div>
                                    <div class="col-xs-12" style="padding:0"><hr style="margin-top:3px; margin-bottom:10px"></div>
                                    <ul class="nav nav-pills nav-stacked col-xs-2">
                                        <li class="active"><a href="#add_on_root" data-toggle="tab">root</a></li>
                                        <?php
                                            foreach($addon_dir as $d) {
                                                if(strpos($d->name, "root") === false) {
                                        ?>
                                        <li><a href="#{{ $d->name }}" data-toggle="tab">{{ $d->name }}</a></li>
                                        <?php
                                                }
                                            }
                                        ?>
                                    </ul>
                                    <div class="tab-content col-xs-10">
                                        <div class="col-xs-12 tab-pane fade in active" id="add_on_root">
                                            <table class="col-xs-12">
                                                <tr>
                                        <?php
                                            $counter = 0;
                                            $photoExist = false;
                                            $fileArray = [];
                                            foreach($addon as $d) {
                                                if($d->folder_name == 'add_on_root') {
                                                    $counter++;
                                                    array_push($fileArray, $d->name);
                                                    $photoExist = true;
                                        ?>
                                                    <td class="col-xs-3">
                                                        <div class="check-img-btn-wrapper">
                                                            <input type="checkbox" class="check-img-btn" data-id="{{ $d->id }}" data-type="tile" data-name="{{ $d->name }}">
                                                        </div>
                                                        <div class="image-wrapper">
                                                            <img src="{{ asset('public/assets/image/item-image/add-on/medium/'.$d->name) }}" width="100%">
                                                        </div>
                                                    </td>
                                        <?php
                                                    if($counter == 4) {
                                                        $string = '
                                                            </tr>
                                                            <tr>';
                                                        foreach($fileArray as $d) {
                                                            $string .= '<td class="col-xs-3 text-center" style="padding-bottom:10px; word-wrap:break-word; max-width:1px">'.$d.'</td>';
                                                        }
                                                        $string .= '</tr><tr>';
                                                        echo $string;
                                                        $fileArray = [];
                                                        $counter = 0;
                                                    }
                                                }
                                            }
                                            // print nama image jika baris akhir tidak sampai 4 kolom
                                            if($counter != 4) {
                                                $string = '
                                                    </tr>
                                                    <tr>';
                                                foreach($fileArray as $f) {
                                                    $string .= '<td class="col-xs-3 text-center" style="padding-bottom:10px; word-wrap:break-word; max-width:1px">'.$f.'</td>';
                                                }
                                                $string .= '</tr><tr>';
                                                echo $string;
                                            }
                                            if($photoExist == false) {
                                                $string .= '<td class="col-xs-12 text-center" colspan="4"><h4>NO PHOTO FOUND</h4></td></tr>';
                                                echo $string;
                                            }
                                        ?>
                                            </table>
                                        </div>
                                        @foreach($addon_dir as $d)
                                        <?php
                                            if(strpos($d->name, "root") === false) {
                                        ?>
                                        <div class="col-xs-12 tab-pane fade" id="{{ $d->name }}">
                                            <table class="col-xs-12">
                                                <tr>
                                        <?php
                                            $counter = 0;
                                            $photoExist = false;
                                            $fileArray = [];
                                            foreach($addon as $dd) {
                                                if($dd->folder_name == $d->name) {
                                                    $counter++;
                                                    array_push($fileArray, $dd->name);
                                                    $photoExist = true;
                                        ?>
                                                    <td class="col-xs-3">
                                                        <div class="check-img-btn-wrapper">
                                                            <input type="checkbox" class="check-img-btn" data-id="{{ $dd->id }}" data-type="tile" data-name="{{ $dd->name }}">
                                                        </div>
                                                        <div class="image-wrapper">
                                                            <img src="{{ asset('public/assets/image/item-image/add-on/medium/'.$dd->name) }}" width="100%">
                                                        </div>
                                                    </td>
                                        <?php
                                                    if($counter == 4) {
                                                        $string = '
                                                            </tr>
                                                            <tr>';
                                                        foreach($fileArray as $ddd) {
                                                            $string .= '<td class="col-xs-3 text-center" style="padding-bottom:10px; word-wrap:break-word; max-width:1px">'.$ddd.'</td>';
                                                        }
                                                        $string .= '</tr><tr>';
                                                        echo $string;
                                                        $fileArray = [];
                                                        $counter = 0;
                                                    }
                                                }
                                            }
                                            // print nama image jika baris akhir tidak sampai 4 kolom
                                            if($counter != 4) {
                                                $string = '
                                                    </tr>
                                                    <tr>';
                                                foreach($fileArray as $f) {
                                                    $string .= '<td class="col-xs-3 text-center" style="padding-bottom:10px; word-wrap:break-word; max-width:1px">'.$f.'</td>';
                                                }
                                                $string .= '</tr><tr>';
                                                echo $string;
                                            }
                                            if($photoExist == false) {
                                                $string .= '<td class="col-xs-12 text-center" colspan="4"><h4>NO PHOTO FOUND</h4></td></tr>';
                                                echo $string;
                                            }
                                        ?>
                                            </table>
                                        </div>
                                        <?php
                                            }
                                        ?>
                                        @endforeach
                                    </div>
                                </div>
                                <div class="col-xs-12 tab-pane fade" id="logo" style="padding-top:2%">
                                    <div class="col-xs-12" style="padding:0">
                                        <div class="col-xs-2" style="padding:0"><h4>Folder List</h4></div>
                                        <div class="col-xs-3 col-xs-offset-6">
                                            <input type="button" class="btn btn-warning pull-right move-folder-btn" value="Move to Another Folder" data-toggle="modal" data-target="#myModalMoveFolder" data-type="logo">
                                        </div>
                                        <div class="col-xs-1" style="padding:0">
                                            <input type="button" class="btn btn-primary pull-right" value="Add Folder" data-toggle="modal" data-target="#myModalAddFolder" data-action="add" data-type="logo">
                                        </div>
                                    </div>
                                    <div class="col-xs-12" style="padding:0"><hr style="margin-top:3px; margin-bottom:10px"></div>
                                    <ul class="nav nav-pills nav-stacked col-xs-2">
                                        <li class="active"><a href="#logo_root" data-toggle="tab">root</a></li>
                                        <?php
                                            foreach($logo_dir as $d) {
                                                if(strpos($d->name, "root") === false) {
                                        ?>
                                        <li><a href="#{{ $d->name }}" data-toggle="tab">{{ $d->name }}</a></li>
                                        <?php
                                                }
                                            }
                                        ?>
                                    </ul>
                                    <div class="tab-content col-xs-10">
                                        <div class="col-xs-12 tab-pane fade in active" id="logo_root">
                                            <table class="col-xs-12">
                                                <tr>
                                        <?php
                                            $counter = 0;
                                            $photoExist = false;
                                            $fileArray = [];
                                            foreach($logo as $d) {
                                                if($d->folder_name == 'logo_root') {
                                                    $counter++;
                                                    array_push($fileArray, $d->name);
                                                    $photoExist = true;
                                        ?>
                                                    <td class="col-xs-3">
                                                        <div class="check-img-btn-wrapper">
                                                            <input type="checkbox" class="check-img-btn" data-id="{{ $d->id }}" data-type="tile" data-name="{{ $d->name }}">
                                                        </div>
                                                        <div class="image-wrapper">
                                                            <img src="{{ asset('public/assets/image/logo-image/'.$d->name) }}" width="100%">
                                                        </div>
                                                    </td>
                                        <?php
                                                    if($counter == 4) {
                                                        $string = '
                                                            </tr>
                                                            <tr>';
                                                        foreach($fileArray as $d) {
                                                            $string .= '<td class="col-xs-3 text-center" style="padding-bottom:10px; word-wrap:break-word; max-width:1px">'.$d.'</td>';
                                                        }
                                                        $string .= '</tr><tr>';
                                                        echo $string;
                                                        $fileArray = [];
                                                        $counter = 0;
                                                    }
                                                }
                                            }
                                            // print nama image jika baris akhir tidak sampai 4 kolom
                                            if($counter != 4) {
                                                $string = '
                                                    </tr>
                                                    <tr>';
                                                foreach($fileArray as $f) {
                                                    $string .= '<td class="col-xs-3 text-center" style="padding-bottom:10px; word-wrap:break-word; max-width:1px">'.$f.'</td>';
                                                }
                                                $string .= '</tr><tr>';
                                                echo $string;
                                            }
                                            if($photoExist == false) {
                                                $string .= '<td class="col-xs-12 text-center" colspan="4"><h4>NO PHOTO FOUND</h4></td></tr>';
                                                echo $string;
                                            }
                                        ?>
                                            </table>
                                        </div>
                                        @foreach($logo_dir as $d)
                                        <?php
                                            if(strpos($d->name, "root") === false) {
                                        ?>
                                        <div class="col-xs-12 tab-pane fade" id="{{ $d->name }}">
                                            <table class="col-xs-12">
                                                <tr>
                                        <?php
                                            $counter = 0;
                                            $photoExist = false;
                                            $fileArray = [];
                                            foreach($logo as $dd) {
                                                if($dd->folder_name == $d->name) {
                                                    $counter++;
                                                    array_push($fileArray, $dd->name);
                                                    $photoExist = true;
                                        ?>
                                                    <td class="col-xs-3">
                                                        <div class="check-img-btn-wrapper">
                                                            <input type="checkbox" class="check-img-btn" data-id="{{ $dd->id }}" data-type="tile" data-name="{{ $dd->name }}">
                                                        </div>
                                                        <div class="image-wrapper">
                                                            <img src="{{ asset('public/assets/image/logo-image/'.$dd->name) }}" width="100%">
                                                        </div>
                                                    </td>
                                        <?php
                                                    if($counter == 4) {
                                                        $string = '
                                                            </tr>
                                                            <tr>';
                                                        foreach($fileArray as $ddd) {
                                                            $string .= '<td class="col-xs-3 text-center" style="padding-bottom:10px; word-wrap:break-word; max-width:1px">'.$ddd.'</td>';
                                                        }
                                                        $string .= '</tr><tr>';
                                                        echo $string;
                                                        $fileArray = [];
                                                        $counter = 0;
                                                    }
                                                }
                                            }
                                            // print nama image jika baris akhir tidak sampai 4 kolom
                                            if($counter != 4) {
                                                $string = '
                                                    </tr>
                                                    <tr>';
                                                foreach($fileArray as $f) {
                                                    $string .= '<td class="col-xs-3 text-center" style="padding-bottom:10px; word-wrap:break-word; max-width:1px">'.$f.'</td>';
                                                }
                                                $string .= '</tr><tr>';
                                                echo $string;
                                            }
                                            if($photoExist == false) {
                                                $string .= '<td class="col-xs-12 text-center" colspan="4"><h4>NO PHOTO FOUND</h4></td></tr>';
                                                echo $string;
                                            }
                                        ?>
                                            </table>
                                        </div>
                                        <?php
                                            }
                                        ?>
                                        @endforeach
                                    </div>
                                </div>
                                <div class="col-xs-12 tab-pane fade" id="icon" style="padding-top:2%">
                                    <div class="col-xs-12" style="padding:0">
                                        <div class="col-xs-2" style="padding:0"><h4>Folder List</h4></div>
                                        <div class="col-xs-3 col-xs-offset-6">
                                            <input type="button" class="btn btn-warning pull-right move-folder-btn" value="Move to Another Folder" data-toggle="modal" data-target="#myModalMoveFolder" data-type="tag">
                                        </div>
                                        <div class="col-xs-1" style="padding:0">
                                            <input type="button" class="btn btn-primary pull-right" value="Add Folder" data-toggle="modal" data-target="#myModalAddFolder" data-action="add" data-type="tag">
                                        </div>
                                    </div>
                                    <div class="col-xs-12" style="padding:0"><hr style="margin-top:3px; margin-bottom:10px"></div>
                                    <ul class="nav nav-pills nav-stacked col-xs-2">
                                        <li class="active"><a href="#tag_root" data-toggle="tab">root</a></li>
                                        <?php
                                            foreach($icon_dir as $d) {
                                                if(strpos($d->name, "root") === false) {
                                        ?>
                                        <li><a href="#{{ $d->name }}" data-toggle="tab">{{ $d->name }}</a></li>
                                        <?php
                                                }
                                            }
                                        ?>
                                    </ul>
                                    <div class="tab-content col-xs-10">
                                        <div class="col-xs-12 tab-pane fade in active" id="tag_root">
                                            <table class="col-xs-12">
                                                <tr>
                                        <?php
                                            $counter = 0;
                                            $photoExist = false;
                                            $fileArray = [];
                                            foreach($icon as $d) {
                                                if($d->folder_name == 'tag_root') {
                                                    $counter++;
                                                    array_push($fileArray, $d->name);
                                                    $photoExist = true;
                                        ?>
                                                    <td class="col-xs-3">
                                                        <div class="check-img-btn-wrapper">
                                                            <input type="checkbox" class="check-img-btn" data-id="{{ $d->id }}" data-type="tile" data-name="{{ $d->name }}">
                                                        </div>
                                                        <div class="image-wrapper">
                                                            <img src="{{ asset('public/assets/image/tag-icon/'.$d->name) }}" width="100%">
                                                        </div>
                                                    </td>
                                        <?php
                                                    if($counter == 4) {
                                                        $string = '
                                                            </tr>
                                                            <tr>';
                                                        foreach($fileArray as $d) {
                                                            $string .= '<td class="col-xs-3 text-center" style="padding-bottom:10px; word-wrap:break-word; max-width:1px">'.$d.'</td>';
                                                        }
                                                        $string .= '</tr><tr>';
                                                        echo $string;
                                                        $fileArray = [];
                                                        $counter = 0;
                                                    }
                                                }
                                            }
                                            // print nama image jika baris akhir tidak sampai 4 kolom
                                            if($counter != 4) {
                                                $string = '
                                                    </tr>
                                                    <tr>';
                                                foreach($fileArray as $f) {
                                                    $string .= '<td class="col-xs-3 text-center" style="padding-bottom:10px; word-wrap:break-word; max-width:1px">'.$f.'</td>';
                                                }
                                                $string .= '</tr><tr>';
                                                echo $string;
                                            }
                                            if($photoExist == false) {
                                                $string .= '<td class="col-xs-12 text-center" colspan="4"><h4>NO PHOTO FOUND</h4></td></tr>';
                                                echo $string;
                                            }
                                        ?>
                                            </table>
                                        </div>
                                        @foreach($icon_dir as $d)
                                        <?php
                                            if(strpos($d->name, "root") === false) {
                                        ?>
                                        <div class="col-xs-12 tab-pane fade" id="{{ $d->name }}">
                                            <table class="col-xs-12">
                                                <tr>
                                        <?php
                                            $counter = 0;
                                            $photoExist = false;
                                            $fileArray = [];
                                            foreach($icon as $dd) {
                                                if($dd->folder_name == $d->name) {
                                                    $counter++;
                                                    array_push($fileArray, $dd->name);
                                                    $photoExist = true;
                                        ?>
                                                    <td class="col-xs-3">
                                                        <div class="check-img-btn-wrapper">
                                                            <input type="checkbox" class="check-img-btn" data-id="{{ $dd->id }}" data-type="tile" data-name="{{ $dd->name }}">
                                                        </div>
                                                        <div class="image-wrapper">
                                                            <img src="{{ asset('public/assets/image/tag-icon/'.$dd->name) }}" width="100%">
                                                        </div>
                                                    </td>
                                        <?php
                                                    if($counter == 4) {
                                                        $string = '
                                                            </tr>
                                                            <tr>';
                                                        foreach($fileArray as $ddd) {
                                                            $string .= '<td class="col-xs-3 text-center" style="padding-bottom:10px; word-wrap:break-word; max-width:1px">'.$ddd.'</td>';
                                                        }
                                                        $string .= '</tr><tr>';
                                                        echo $string;
                                                        $fileArray = [];
                                                        $counter = 0;
                                                    }
                                                }
                                            }
                                            // print nama image jika baris akhir tidak sampai 4 kolom
                                            if($counter != 4) {
                                                $string = '
                                                    </tr>
                                                    <tr>';
                                                foreach($fileArray as $f) {
                                                    $string .= '<td class="col-xs-3 text-center" style="padding-bottom:10px; word-wrap:break-word; max-width:1px">'.$f.'</td>';
                                                }
                                                $string .= '</tr><tr>';
                                                echo $string;
                                            }
                                            if($photoExist == false) {
                                                $string .= '<td class="col-xs-12 text-center" colspan="4"><h4>NO PHOTO FOUND</h4></td></tr>';
                                                echo $string;
                                            }
                                        ?>
                                            </table>
                                        </div>
                                        <?php
                                            }
                                        ?>
                                        @endforeach
                                    </div>
                                </div>
                                <div class="col-xs-12 tab-pane fade" id="navigation" style="padding-top:2%">
                                    <div class="col-xs-12" style="padding:0">
                                        <div class="col-xs-2" style="padding:0"><h4>Folder List</h4></div>
                                        <div class="col-xs-3 col-xs-offset-6">
                                            <input type="button" class="btn btn-warning pull-right move-folder-btn" value="Move to Another Folder" data-toggle="modal" data-target="#myModalMoveFolder" data-type="navigation">
                                        </div>
                                        <div class="col-xs-1" style="padding:0">
                                            <input type="button" class="btn btn-primary pull-right" value="Add Folder" data-toggle="modal" data-target="#myModalAddFolder" data-action="add" data-type="navigation">
                                        </div>
                                    </div>
                                    <div class="col-xs-12" style="padding:0"><hr style="margin-top:3px; margin-bottom:10px"></div>
                                    <ul class="nav nav-pills nav-stacked col-xs-2">
                                        <li class="active"><a href="#navigation_root" data-toggle="tab">root</a></li>
                                        <?php
                                            foreach($nav_dir as $d) {
                                                if(strpos($d->name, "root") === false) {
                                        ?>
                                        <li><a href="#{{ $d->name }}" data-toggle="tab">{{ $d->name }}</a></li>
                                        <?php
                                                }
                                            }
                                        ?>
                                    </ul>
                                    <div class="tab-content col-xs-10">
                                        <div class="col-xs-12 tab-pane fade in active" id="navigation_root">
                                            <table class="col-xs-12">
                                                <tr>
                                        <?php
                                            $counter = 0;
                                            $photoExist = false;
                                            $fileArray = [];
                                            foreach($nav as $d) {
                                                if($d->folder_name == 'navigation_root') {
                                                    $counter++;
                                                    array_push($fileArray, $d->name);
                                                    $photoExist = true;
                                        ?>
                                                    <td class="col-xs-3">
                                                        <div class="check-img-btn-wrapper">
                                                            <input type="checkbox" class="check-img-btn" data-id="{{ $d->id }}" data-type="tile" data-name="{{ $d->name }}">
                                                        </div>
                                                        <div class="image-wrapper">
                                                            <img src="{{ asset('public/assets/image/nav-image/'.$d->name) }}" width="100%">
                                                        </div>
                                                    </td>
                                        <?php
                                                    if($counter == 4) {
                                                        $string = '
                                                            </tr>
                                                            <tr>';
                                                        foreach($fileArray as $d) {
                                                            $string .= '<td class="col-xs-3 text-center" style="padding-bottom:10px; word-wrap:break-word; max-width:1px">'.$d.'</td>';
                                                        }
                                                        $string .= '</tr><tr>';
                                                        echo $string;
                                                        $fileArray = [];
                                                        $counter = 0;
                                                    }
                                                }
                                            }
                                            // print nama image jika baris akhir tidak sampai 4 kolom
                                            if($counter != 4) {
                                                $string = '
                                                    </tr>
                                                    <tr>';
                                                foreach($fileArray as $f) {
                                                    $string .= '<td class="col-xs-3 text-center" style="padding-bottom:10px; word-wrap:break-word; max-width:1px">'.$f.'</td>';
                                                }
                                                $string .= '</tr><tr>';
                                                echo $string;
                                            }
                                            if($photoExist == 0) {
                                                $string .= '<td class="col-xs-12 text-center" colspan="4"><h4>NO PHOTO FOUND</h4></td></tr>';
                                                echo $string;
                                            }
                                        ?>
                                            </table>
                                        </div>
                                        @foreach($nav_dir as $d)
                                        <?php
                                            if(strpos($d->name, "root") === false) {
                                        ?>
                                        <div class="col-xs-12 tab-pane fade" id="{{ $d->name }}">
                                            <table class="col-xs-12">
                                                <tr>
                                        <?php
                                            $counter = 0;
                                            $photoExist = false;
                                            $fileArray = [];
                                            foreach($nav as $dd) {
                                                if($dd->folder_name == $d->name) {
                                                    $counter++;
                                                    array_push($fileArray, $dd->name);
                                                    $photoExist = true;
                                        ?>
                                                    <td class="col-xs-3">
                                                        <div class="check-img-btn-wrapper">
                                                            <input type="checkbox" class="check-img-btn" data-id="{{ $dd->id }}" data-type="tile" data-name="{{ $dd->name }}">
                                                        </div>
                                                        <div class="image-wrapper">
                                                            <img src="{{ asset('public/assets/image/tag-icon/'.$dd->name) }}" width="100%">
                                                        </div>
                                                    </td>
                                        <?php
                                                    if($counter == 4) {
                                                        $string = '
                                                            </tr>
                                                            <tr>';
                                                        foreach($fileArray as $ddd) {
                                                            $string .= '<td class="col-xs-3 text-center" style="padding-bottom:10px; word-wrap:break-word; max-width:1px">'.$ddd.'</td>';
                                                        }
                                                        $string .= '</tr><tr>';
                                                        echo $string;
                                                        $fileArray = [];
                                                        $counter = 0;
                                                    }
                                                }
                                            }
                                            // print nama image jika baris akhir tidak sampai 4 kolom
                                            if($counter != 4) {
                                                $string = '
                                                    </tr>
                                                    <tr>';
                                                foreach($fileArray as $f) {
                                                    $string .= '<td class="col-xs-3 text-center" style="padding-bottom:10px; word-wrap:break-word; max-width:1px">'.$f.'</td>';
                                                }
                                                $string .= '</tr><tr>';
                                                echo $string;
                                            }
                                            if($photoExist == false) {
                                                $string .= '<td class="col-xs-12 text-center" colspan="4"><h4>NO PHOTO FOUND</h4></td></tr>';
                                                echo $string;
                                            }
                                        ?>
                                            </table>
                                        </div>
                                        <?php
                                            }
                                        ?>
                                        @endforeach
                                    </div>
                                </div>
                                <div class="col-xs-12 tab-pane fade" id="media" style="padding-top:2%">
                                    <div class="col-xs-12" style="padding:0">
                                        <div class="col-xs-2" style="padding:0"><h4>Folder List</h4></div>
                                        <div class="col-xs-3 col-xs-offset-6">
                                            <input type="button" class="btn btn-warning pull-right move-folder-btn" value="Move to Another Folder" data-toggle="modal" data-target="#myModalMoveFolder" data-type="other">
                                        </div>
                                        <div class="col-xs-1" style="padding:0">
                                            <input type="button" class="btn btn-primary pull-right" value="Add Folder" data-toggle="modal" data-target="#myModalAddFolder" data-action="add" data-type="other">
                                        </div>
                                    </div>
                                    <div class="col-xs-12" style="padding:0"><hr style="margin-top:3px; margin-bottom:10px"></div>
                                    <ul class="nav nav-pills nav-stacked col-xs-2">
                                        <li class="active"><a href="#other_root" data-toggle="tab">root</a></li>
                                        <?php
                                            foreach($other_dir as $d) {
                                                if(strpos($d->name, "root") === false) {
                                        ?>
                                        <li><a href="#{{ $d->name }}" data-toggle="tab">{{ $d->name }}</a></li>
                                        <?php
                                                }
                                            }
                                        ?>
                                    </ul>
                                    <div class="tab-content col-xs-10">
                                        <div class="col-xs-12 tab-pane fade in active" id="other_root">
                                            <table class="col-xs-12">
                                                <tr>
                                        <?php
                                            $counter = 0;
                                            $photoExist = false;
                                            $fileArray = [];
                                            foreach($other as $d) {
                                                if($d->folder_name == 'other_root') {
                                                    $counter++;
                                                    array_push($fileArray, $d->name);
                                                    $photoExist = true;
                                        ?>
                                                    <td class="col-xs-3">
                                                        <div class="check-img-btn-wrapper">
                                                            <input type="checkbox" class="check-img-btn" data-id="{{ $d->id }}" data-type="tile" data-name="{{ $d->name }}">
                                                        </div>
                                                        <div class="image-wrapper">
                                                            <img src="{{ asset('public/assets/image/image-storage/'.$d->name) }}" width="100%">
                                                        </div>
                                                    </td>
                                        <?php
                                                    if($counter == 4) {
                                                        $string = '
                                                            </tr>
                                                            <tr>';
                                                        foreach($fileArray as $d) {
                                                            $string .= '<td class="col-xs-3 text-center" style="padding-bottom:10px; word-wrap:break-word; max-width:1px">'.$d.'</td>';
                                                        }
                                                        $string .= '</tr><tr>';
                                                        echo $string;
                                                        $fileArray = [];
                                                        $counter = 0;
                                                    }
                                                }
                                            }
                                            // print nama image jika baris akhir tidak sampai 4 kolom
                                            if($counter != 4) {
                                                $string = '
                                                    </tr>
                                                    <tr>';
                                                foreach($fileArray as $f) {
                                                    $string .= '<td class="col-xs-3 text-center" style="padding-bottom:10px; word-wrap:break-word; max-width:1px">'.$f.'</td>';
                                                }
                                                $string .= '</tr><tr>';
                                                echo $string;
                                            }
                                            if($photoExist == false) {
                                                $string .= '<td class="col-xs-12 text-center" colspan="4"><h4>NO PHOTO FOUND</h4></td></tr>';
                                                echo $string;
                                            }
                                        ?>
                                            </table>
                                        </div>
                                        @foreach($other_dir as $d)
                                        <?php
                                            if(strpos($d->name, "root") === false) {
                                        ?>
                                        <div class="col-xs-12 tab-pane fade" id="{{ $d->name }}">
                                            <table class="col-xs-12">
                                                <tr>
                                        <?php
                                            $counter = 0;
                                            $photoExist = false;
                                            $fileArray = [];
                                            foreach($other as $dd) {
                                                if($dd->folder_name == $d->name) {
                                                    $counter++;
                                                    array_push($fileArray, $dd->name);
                                                    $photoExist = true;
                                        ?>
                                                    <td class="col-xs-3">
                                                        <div class="check-img-btn-wrapper">
                                                            <input type="checkbox" class="check-img-btn" data-id="{{ $dd->id }}" data-type="tile" data-name="{{ $dd->name }}">
                                                        </div>
                                                        <div class="image-wrapper">
                                                            <img src="{{ asset('public/assets/image/image-storage/'.$dd->name) }}" width="100%">
                                                        </div>
                                                    </td>
                                        <?php
                                                    if($counter == 4) {
                                                        $string = '
                                                            </tr>
                                                            <tr>';
                                                        foreach($fileArray as $ddd) {
                                                            $string .= '<td class="col-xs-3 text-center" style="padding-bottom:10px; word-wrap:break-word; max-width:1px">'.$ddd.'</td>';
                                                        }
                                                        $string .= '</tr><tr>';
                                                        echo $string;
                                                        $fileArray = [];
                                                        $counter = 0;
                                                    }
                                                }
                                            }
                                            // print nama image jika baris akhir tidak sampai 4 kolom
                                            if($counter != 4) {
                                                $string = '
                                                    </tr>
                                                    <tr>';
                                                foreach($fileArray as $f) {
                                                    $string .= '<td class="col-xs-3 text-center" style="padding-bottom:10px; word-wrap:break-word; max-width:1px">'.$f.'</td>';
                                                }
                                                $string .= '</tr><tr>';
                                                echo $string;
                                            }
                                            if($photoExist == false) {
                                                $string .= '<td class="col-xs-12 text-center" colspan="4"><h4>NO PHOTO FOUND</h4></td></tr>';
                                                echo $string;
                                            }
                                        ?>
                                            </table>
                                        </div>
                                        <?php
                                            }
                                        ?>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.panel
                </div>
                <!-- /.col-lg-12
            </div>
            <!-- /.row
        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->

    <script type="text/javascript" src="{{ asset('public/assets/js/photo.js') }}"></script>
@endsection
