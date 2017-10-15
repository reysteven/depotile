<div class="modal fade" id="myModalDetailTile" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="width:50%">
        <div class="modal-content">
            <div class="modal-header" style="background-color:#224098; color:white">
                <input type="hidden" id="parent-hash-code">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="title text-center">Tile Detail</h4>
            </div>
            <div class="modal-body row" style="color:black">
                <div class="error-msg col-sm-12 text-center" style="margin-top:1%; color:red"></div>
                <div class="loading-div text-center hidden">
                    <span class="fa fa-spinner fa-spin fa-2x"></span>
                </div>
                <form method="POST" action="{{ url('doEditTile') }}" id="add-tile-form">
                    <div class="content hidden">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="hidden" class="item-id" name="item_id">
                        <ul class="nav nav-tabs">
                            <li class="active"><a href="#general" data-toggle="tab">General</a></li>
                            <li><a href="#img" data-toggle="tab">Picture</a></li>
                            <li><a href="#tag" data-toggle="tab">Tag</a></li>
                        </ul>
                        <div class="tab-content">
                            <div id="general" class="tab-pane fade-in active" style="margin-top:2%">
                                <div class="col-xs-12 form-group">
                                    <div class="col-xs-3" style="padding-top:0.5%">ID</div>
                                    <div class="col-xs-1" style="padding-top:0.5%">:</div>
                                    <div class="col-xs-8">
                                        <input type="text" class="form-control" name="id" disabled>
                                    </div>
                                </div>
                                <div class="col-xs-12 form-group">
                                    <div class="col-xs-3" style="padding-top:0.5%">Item Code</div>
                                    <div class="col-xs-1" style="padding-top:0.5%">:</div>
                                    <div class="col-xs-8">
                                        <input type="text" class="form-control" name="code" placeholder="Input item code here">
                                    </div>
                                </div>
                                <div class="col-xs-12 form-group">
                                    <div class="col-xs-3" style="padding-top:0.5%">Name</div>
                                    <div class="col-xs-1" style="padding-top:0.5%">:</div>
                                    <div class="col-xs-8">
                                        <input type="text" class="form-control" name="name" placeholder="Input item name here">
                                    </div>
                                </div>
                                <div class="col-xs-12 form-group">
                                    <div class="col-xs-3" style="padding-top:0.5%">Category</div>
                                    <div class="col-xs-1" style="padding-top:0.5%">:</div>
                                    <div class="col-xs-4">
                                        <select class="form-control" name="category">
                                            <option class="hidden">Choose item category</option>
                                            @foreach($category as $d)
                                            @if($d['category_name'] != 'Aksesoris')
                                            <option value="{{ $d['category_name'] }}">{{ $d['category_name'] }}</option>
                                            @endif
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-xs-4">
                                        <select class="form-control" name="sub_category" disabled>
                                            <option class="hidden">Choose item category first</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xs-12 form-group">
                                    <div class="col-xs-3" style="padding-top:0.5%">Size</div>
                                    <div class="col-xs-1" style="padding-top:0.5%">:</div>
                                    <div class="col-xs-2">
                                        <input type="text" class="form-control text-center" name="length" id="length" placeholder="L">
                                    </div>
                                    <div class="col-xs-1" style="padding-top:0.5%">X</div>
                                    <div class="col-xs-2">
                                        <input type="text" class="form-control text-center" name="width" id="width" placeholder="W">
                                    </div>
                                    <div class="col-xs-1" style="padding-top:0.5%">X</div>
                                    <div class="col-xs-2">
                                        <input type="text" class="form-control text-center" name="thickness" id="thickness" placeholder="T">
                                    </div>
                                </div>
                                <div class="col-xs-12 form-group">
                                    <div class="col-xs-3" style="padding-top:0.5%">Pc per box</div>
                                    <div class="col-xs-1" style="padding-top:0.5%">:</div>
                                    <div class="col-xs-8">
                                        <input type="text" class="form-control" name="pc_per_box" id="pc_per_box" placeholder="Input item per box here">
                                    </div>
                                </div>
                                <div class="col-xs-12 form-group">
                                    <div class="col-xs-3" style="padding-top:0.5%">Price per m<sup>2</sup></div>
                                    <div class="col-xs-1" style="padding-top:0.5%">:</div>
                                    <div class="col-xs-8">
                                        <input type="text" class="form-control" name="price_m2" id="price_m2" placeholder="Input price per m2 here">
                                    </div>
                                </div>
                                <div class="col-xs-12 form-group">
                                    <div class="col-xs-3" style="padding-top:0.5%">Brand</div>
                                    <div class="col-xs-1" style="padding-top:0.5%">:</div>
                                    <div class="col-xs-8">
                                        <input type="text" class="form-control" name="brand" placeholder="Input item brand here">
                                    </div>
                                </div>
                                <div class="col-xs-12 form-group">
                                    <div class="col-xs-3" style="padding-top:0.5%">Calculator</div>
                                    <div class="col-xs-1" style="padding-top:0.5%">:</div>
                                    <div class="col-xs-8">
                                        <select class="form-control" name="calc">
                                            <option class="hidden">Choose option</option>
                                            <option value="1">Yes</option>
                                            <option value="0">No</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xs-12 form-group">
                                    <div class="col-xs-3" style="padding-top:0.5%">Installation</div>
                                    <div class="col-xs-1" style="padding-top:0.5%">:</div>
                                    <div class="col-xs-8">
                                        <input type="text" class="form-control" name="installation" placeholder="Type installation name here">
                                    </div>
                                </div>
                                <div class="col-xs-12 form-group">
                                    <div class="col-xs-3" style="padding-top:0.5%">Shipping Fee</div>
                                    <div class="col-xs-1" style="padding-top:0.5%">:</div>
                                    <div class="col-xs-8">
                                        <input type="text" class="form-control" name="fee" placeholder="Input item shipping fee name here">
                                    </div>
                                </div>
                                <div class="col-xs-12 form-group">
                                    <div class="col-xs-3" style="padding-top:0.5%">Description</div>
                                    <div class="col-xs-1" style="padding-top:0.5%">:</div>
                                    <div class="col-xs-8">
                                        <textarea rows="3" class="form-control" name="description" placeholder="Input item description here"></textarea>
                                    </div>
                                </div>
                                <div class="col-xs-12 form-group">
                                    <div class="col-xs-3" style="padding-top:0.5%">Add On</div>
                                    <div class="col-xs-1" style="padding-top:0.5%">:</div>
                                    <div class="col-xs-8">
                                        <select class="form-control" name="addon">
                                            <option class="hidden">Choose option</option>
                                            <option value="1">Yes</option>
                                            <option value="0">No</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xs-12 collapse" id="add-on-detail" style="border-top: 1px solid; border-bottom: 1px solid">
                                    <div class="col-xs-12 form-group" style="margin-top:2%">
                                        <div class="col-xs-3" style="padding-top:0.5%">Add On 1</div>
                                        <div class="col-xs-1" style="padding-top:0.5%">:</div>
                                        <div class="col-xs-8">
                                            <input type="text" class="form-control addon" name="addon1" id="addon1" placeholder="Input add on 1 ID here">
                                        </div>
                                    </div>
                                    <div class="col-xs-12 form-group">
                                        <div class="col-xs-3" style="padding-top:0.5%">Description 1</div>
                                        <div class="col-xs-1" style="padding-top:0.5%">:</div>
                                        <div class="col-xs-8">
                                            <textarea type="text" class="form-control" name="addon1desc" rows="2" placeholder="Input add on 1 description here"></textarea>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 form-group">
                                        <div class="col-xs-3" style="padding-top:0.5%">Add On 2</div>
                                        <div class="col-xs-1" style="padding-top:0.5%">:</div>
                                        <div class="col-xs-8">
                                            <input type="text" class="form-control addon" name="addon2" id="addon2" placeholder="Input add on 2 ID here">
                                        </div>
                                    </div>
                                    <div class="col-xs-12 form-group">
                                        <div class="col-xs-3" style="padding-top:0.5%">Description 2</div>
                                        <div class="col-xs-1" style="padding-top:0.5%">:</div>
                                        <div class="col-xs-8">
                                            <textarea class="form-control" name="addon2desc" rows="2" placeholder="Input add on 2 description here"></textarea>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 form-group">
                                        <div class="col-xs-3" style="padding-top:0.5%">Add On 3</div>
                                        <div class="col-xs-1" style="padding-top:0.5%">:</div>
                                        <div class="col-xs-8">
                                            <input type="text" class="form-control addon" name="addon3" id="addon3" placeholder="Input add on 3 ID here">
                                        </div>
                                    </div>
                                    <div class="col-xs-12 form-group">
                                        <div class="col-xs-3" style="padding-top:0.5%">Description 3</div>
                                        <div class="col-xs-1" style="padding-top:0.5%">:</div>
                                        <div class="col-xs-8">
                                            <textarea class="form-control" name="addon3desc" rows="2" placeholder="Input add on 3 description here"></textarea>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 form-group">
                                        <div class="col-xs-3" style="padding-top:0.5%">Add On CTA</div>
                                        <div class="col-xs-1" style="padding-top:0.5%">:</div>
                                        <div class="col-xs-8">
                                            <input type="text" class="form-control" name="addoncta" placeholder="Input add on CTA here">
                                        </div>
                                    </div>
                                    <div class="col-xs-12 form-group">
                                        <div class="col-xs-3" style="padding-top:0.5%">Add On Title</div>
                                        <div class="col-xs-1" style="padding-top:0.5%">:</div>
                                        <div class="col-xs-8">
                                            <input type="text" class="form-control" name="addontitle" placeholder="Input add on title here">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div id="img" class="tab-pane fade" style="margin-top:2%">
                                <table class="table table-bordered" id="item-img-table">
                                    <thead>
                                        <tr>
                                            <th class="text-center">Tipe</th>
                                            <th class="text-center" style="max-width:570px">Gambar</th>
                                            <th class="text-center change-img-head">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td class="text-center" style="vertical-align:middle">Gambar 1</td>
                                            <td class="text-center img1" style="max-width:580px">
                                                <input type="hidden" name="img_name[]">
                                                <img src="" class="curr-img">
                                                <div class="img-list hidden" style="overflow-y:scroll; max-height:250px; padding:0; margin-top:20px">
                                                    <div class="text-center">DAFTAR GAMBAR</div>
                                                    <?php
                                                        // AMBIL DATA GAMBAR
                                                        // -----------------
                                                        $directory = $_SERVER['DOCUMENT_ROOT']."/".env('APP_ROOT_DIR')."/public/assets/image/item-image/medium/";
                                                        $handle = opendir($directory);
                                                        while($file = readdir($handle)){
                                                            if($file !== '.' && $file !== '..'){
                                                    ?>
                                                        <a class="thumbnail img-item-link" href="#thumb" style="margin-bottom:10px" data-name="{{ $file }}">
                                                            <?php echo $file ?>
                                                            <span>
                                                                <img src="/depotile/assets/image/item-image/medium/<?php echo $file ?>" width="200px">
                                                            </span>
                                                        </a>
                                                    <?php
                                                            }
                                                        }
                                                    ?>
                                                </div>
                                            </td>
                                            <td class="text-center" style="vertical-align:middle">
                                                <a href="#" class="change-img">
                                                    <span class="fa fa-pencil"></span>
                                                </a>
                                            </td>
                                        </tr>
                                        <tr></tr>
                                        <tr>
                                            <td class="text-center" style="vertical-align:middle">Gambar 2</td>
                                            <td class="text-center img2" style="max-width:580px">
                                                <input type="hidden" name="img_name[]">
                                                <img src="" class="curr-img">
                                                <div class="img-list hidden" style="overflow-y:scroll; max-height:250px; padding:0; margin-top:20px">
                                                    <div class="text-center">DAFTAR GAMBAR</div>
                                                    <?php
                                                        // AMBIL DATA GAMBAR
                                                        // -----------------
                                                        $directory = $_SERVER['DOCUMENT_ROOT']."/".env('APP_ROOT_DIR')."/public/assets/image/item-image/medium/";
                                                        $handle = opendir($directory);
                                                        while($file = readdir($handle)){
                                                            if($file !== '.' && $file !== '..'){
                                                    ?>
                                                        <a class="thumbnail img-item-link" href="#thumb" style="margin-bottom:10px">
                                                            <?php echo $file ?>
                                                            <span>
                                                                <img src="/depotile/assets/image/item-image/medium/<?php echo $file ?>" width="200px">
                                                            </span>
                                                        </a>
                                                    <?php
                                                            }
                                                        }
                                                    ?>
                                                </div>
                                            </td>
                                            <td class="text-center" style="vertical-align:middle">
                                                <a href="#" class="change-img">
                                                    <span class="fa fa-pencil"></span>
                                                </a>
                                            </td>
                                        </tr>
                                        <tr></tr>
                                        <tr>
                                            <td class="text-center" style="vertical-align:middle">Gambar 3</td>
                                            <td class="text-center img3" style="max-width:580px">
                                                <input type="hidden" name="img_name[]">
                                                <img src="" class="curr-img">
                                                <div class="img-list hidden" style="overflow-y:scroll; max-height:250px; padding:0; margin-top:20px">
                                                    <div class="text-center">DAFTAR GAMBAR</div>
                                                    <?php
                                                        // AMBIL DATA GAMBAR
                                                        // -----------------
                                                        $directory = $_SERVER['DOCUMENT_ROOT']."/".env('APP_ROOT_DIR')."/public/assets/image/item-image/medium/";
                                                        $handle = opendir($directory);
                                                        while($file = readdir($handle)){
                                                            if($file !== '.' && $file !== '..'){
                                                    ?>
                                                        <a class="thumbnail img-item-link" href="#thumb" style="margin-bottom:10px" data-name="{{ $file }}">
                                                            <?php echo $file ?>
                                                            <span>
                                                                <img src="/depotile/assets/image/item-image/medium/<?php echo $file ?>" width="200px">
                                                            </span>
                                                        </a>
                                                    <?php
                                                            }
                                                        }
                                                    ?>
                                                </div>
                                            </td>
                                            <td class="text-center" style="vertical-align:middle">
                                                <a href="#" class="change-img">
                                                    <span class="fa fa-pencil"></span>
                                                </a>
                                            </td>
                                        </tr>
                                        <tr></tr>
                                    </tbody>
                                </table>
                            </div>
                            <div id="tag" class="tab-pane fade" style="margin-top:2%">
                                <div class="tag-content col-xs-12"></div>
                                <div class="col-xs-12 text-left">
                                    <button class="btn btn-default add-tag-btn" type="button">
                                        <span class="fa fa-plus"></span>
                                        Add Tag
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="text-right submit-section col-xs-12" style="margin-top:1%">
                        <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
                        <input type="submit" class="btn btn-primary" id="submit-item-btn" value="Submit">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<form id="item-form" method="POST" action="doItemSubmit.php">
    <input type="hidden" name="item_id">
    <input type="hidden" name="item_code">
    <input type="hidden" name="item_name">
    <input type="hidden" name="item_category">
    <input type="hidden" name="item_sub_category">
    <input type="hidden" name="img_data">
    <input type="hidden" name="item_desc">
    <input type="hidden" name="item_size">
    <input type="hidden" name="pcs_per_box">
    <input type="hidden" name="price_per_m2">
    <input type="hidden" name="brand">
    <input type="hidden" name="calc">
    <input type="hidden" name="installation">
    <input type="hidden" name="fee">
    <input type="hidden" name="addon">
    <input type="hidden" name="addon_data">
    <input type="hidden" name="tag_data">
</form>