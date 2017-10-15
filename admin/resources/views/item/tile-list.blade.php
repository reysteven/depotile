@extends('base')

@section('content')
    <div id="html-error-msg"></div>
    <div id="wrapper">

        @extends('item/import-export-tile')
        @extends('item/tile-detail')

        <?php

            // LOGIC PENCARIAN
            // ---------------
            if(isset($_GET['search-flag-tile'])) {

                // AMBIL DATA ITEM
                // ---------------
                $sql = "SELECT i.*, dc.detail_category_name, hc.category_name, b.brand_name, b.brand_logo
                    FROM ms_item i
                    JOIN ms_detail_category dc
                    ON i.detail_category_id = dc.id
                    JOIN ms_header_category hc
                    ON dc.header_category_id = hc.id
                    JOIN ms_brand b
                    ON i.brand_id = b.id
                    WHERE ";
                if($_GET['search-id'] != null && $_GET['search-id'] != "") {
                    $sql .= "i.id = '".$_GET['search-id']."' AND ";
                }
                if($_GET['search-code'] != null && $_GET['search-code'] != "") {
                    $sql .= "i.item_code LIKE '%".$_GET['search-code']."%' AND ";
                }
                if($_GET['search-name'] != null && $_GET['search-name'] != "") {
                    $sql .= "i.item_name LIKE '%".$_GET['search-name']."%' AND ";
                }
                if($_GET['search-category'] != null && $_GET['search-category'] != "" && $_GET['search-category'] != "Pilih nama kategori") {
                    $sql .= "hc.category_name LIKE '".$_GET['search-category']."' AND ";
                }
                if($_GET['search-sub-category'] != null && $_GET['search-sub-category'] != "" && $_GET['search-sub-category'] != "Pilih nama sub kategori" && $_GET['search-sub-category'] != "Pilih kategori dahulu") {
                    $sql .= "dc.detail_category_name LIKE '".$_GET['search-sub-category']."' AND ";
                }
                if($_GET['search-brand'] != null && $_GET['search-brand'] != "" && $_GET['search-brand'] != "Pilih nama merk") {
                    $sql .= "b.brand_name LIKE '".$_GET['search-brand']."' AND ";
                }
                $sql .= "i.del = 0 ORDER BY i.id";
                // die($sql);
                $itemData = [];
                $itemResult = $db->database_prepare($sql)->execute();
                while($itemRow = $db->database_fetch_array($itemResult)) {
                    array_push($itemData, $itemRow);
                }

            }

            if(isset($_GET['search-flag-addon'])) {

                // AMBIL DATA ADD ON
                // -----------------
                $sql = "SELECT ao.*, dc.detail_category_name as type
                    FROM ms_add_on ao
                    JOIN ms_detail_category dc
                    ON ao.type = dc.id
                    JOIN ms_brand b
                    ON ao.brand = b.id
                    WHERE ";
                if($_GET['search-id'] != null && $_GET['search-id'] != "") {
                    $sql .= "ao.id = '".$_GET['search-id']."' AND ";
                }
                if($_GET['search-name'] != null && $_GET['search-name'] != "") {
                    $sql .= "ao.item_name LIKE '%".$_GET['search-name']."%' AND ";
                }
                if($_GET['search-category'] != null && $_GET['search-category'] != "" && $_GET['search-category'] != "Pilih nama kategori") {
                    $sql .= "dc.detail_category_name LIKE '".$_GET['search-category']."' AND ";
                }
                if($_GET['search-brand'] != null && $_GET['search-brand'] != "" && $_GET['search-brand'] != "Pilih nama merk") {
                    $sql .= "b.brand_name LIKE '".$_GET['search-brand']."' AND ";
                }
                $sql .= "ao.del = 0 ORDER BY ao.id";
                // die($sql);
                $addonData = [];
                $addonResult = $db->database_prepare($sql)->execute();
                while($addonRow = $db->database_fetch_array($addonResult)) {
                    array_push($addonData, $addonRow);
                }

            }

        ?>

        <form id="delete-tile-form" method="POST" action="{{ url('doDeleteTile') }}">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <input type="hidden" name="data">
        </form>

        <input type="hidden" id="categoryData" value='{{ json_encode($category) }}'>
        <input type="hidden" id="brandData" value='{{ json_encode($brand) }}'>
        <input type="hidden" id="installationData" value='{{ json_encode($installation) }}'>
        <input type="hidden" id="feeData" value='{{ json_encode($fee) }}'>
        <input type="hidden" id="addonData" value='{{ json_encode($addon) }}'>
        <input type="hidden" id="tagData" value='{{ json_encode($tag) }}'>

        <input type="hidden" id="getTileDataLink" value="{{ url('doGetTileData') }}">
        <input type="hidden" id="editTileLink" value="{{ url('doEditTile') }}">
        <input type="hidden" id="getImageLink" value="{{ asset('public/assets/image/item-image') }}">

        <div class="modal fade" id="myModalDelTileConfirmation" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="top:30%">
            <div class="modal-dialog" style="width:30%; color:black">
                <div class="modal-content">
                    <div class="modal-body row">
                        <p class="text-center">Are you sure for deleting this/these tile?</p>
                        <div class="text-center">
                            <input type="hidden" name="type">
                            <input type="hidden" name="id">
                            <input type="button" class="btn btn-warning" value="Yes" style="width:15%" name="delTileConfirmButton">
                            <input type="button" class="btn btn-default" value="No" style="width:15%" data-dismiss="modal">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Tile Manager</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Tile Manager
                        </div>
                        <div class="panel-body" style="font-weight:normal">

                            <div class="col-xs-12">
                                @if($errors->any())
                                <div class="alert alert-danger col-xs-12" role="alert">
                                    <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                                    <span class="sr-only">Error:</span>
                                    {{ $errors->first() }}
                                </div>
                                @endif
                                <div class="col-xs-6" style="padding:1% 0; text-align:left">
                                    <input type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModalImportExportTile" value="Import/Export">
                                </div>
                                <div class="col-xs-6" style="padding:1% 0; text-align:right">
                                    <input type="button" class="btn btn-danger delete-all-btn" value="Delete Selected" data-toggle="modal" data-target="#myModalDelTileConfirmation" data-type="mass">
                                </div>
                                <div class="col-xs-12" style="padding-bottom:1%">
                                    <h3>Pencarian</h3>
                                    <div class="tile-search">
                                        <form method="POST" action="{{ url('item/tile-manager') }}" id="tile-search-form">
                                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                            <input type="hidden" name="search_flag" value="true">
                                            <div class="form-group col-xs-7" style="padding:0.2% 0">
                                                <div class="col-xs-4" style="padding:0.5% 0">ID Barang: </div>
                                                <div class="col-xs-8" style="padding:0">
                                                    <input type="text" class="form-control" name="search_id" value="{{ isset($search_flag) ? $search_id : '' }}">
                                                </div>
                                            </div>
                                            <div class="form-group col-xs-7" style="padding:0.2% 0">
                                                <div class="col-xs-4" style="padding:0.5% 0">Kode Barang: </div>
                                                <div class="col-xs-8" style="padding:0">
                                                    <input type="text" class="form-control" name="search_code" value="{{ isset($search_flag) ? $search_code : '' }}">
                                                </div>
                                            </div>
                                            <div class="form-group col-xs-7" style="padding:0.2% 0">
                                                <div class="col-xs-4" style="padding:0.5% 0">Nama Barang: </div>
                                                <div class="col-xs-8" style="padding:0">
                                                    <input type="text" class="form-control" name="search_name" value="{{ isset($search_flag) ? $search_name : '' }}">
                                                </div>
                                            </div>
                                            <div class="form-group col-xs-7" style="padding:0.2% 0">
                                                <div class="col-xs-4" style="padding:0.5% 0">Kategori: </div>
                                                <div class="col-xs-8" style="padding:0">
                                                    <select class="form-control" name="search_category">
                                                        <option class="hidden">Pilih nama kategori</option>
                                                    @foreach($category as $d)
                                                        @if($d['category_name'] != 'Aksesoris')
                                                        @if(isset($search_flag))
                                                            @if($d['category_name'] == $search_category)
                                                        <option value="{{ $d['category_name'] }}" selected>{{ $d['category_name'] }}</option>
                                                            @else
                                                        <option value="{{ $d['category_name'] }}">{{ $d['category_name'] }}</option>
                                                            @endif
                                                        @else
                                                        <option value="{{ $d['category_name'] }}">{{ $d['category_name'] }}</option>
                                                        @endif
                                                        @endif
                                                    @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group col-xs-7" style="padding:0.2% 0">
                                                <div class="col-xs-4" style="padding:0.5% 0">Sub Kategori: </div>
                                                <div class="col-xs-8" style="padding:0">
                                                    @if(!isset($search_sub_category))
                                                    <select class="form-control" name="search_sub_category" disabled>
                                                        <option class="hidden">Choose category first</option>
                                                    @else
                                                    <select class="form-control" name="search_sub_category">
                                                        <option class="hidden">Choose sub category</option>
                                                        @foreach($category as $d)
                                                            @if(isset($search_flag))
                                                                @if($d['category_name'] == $search_category)
                                                                    @foreach($d['detail_category'] as $dd) {
                                                                        @if($dd == $search_sub_category)
                                                        <option value="{{ $dd }}" selected>{{ $dd }}</option>
                                                                        @else
                                                        <option value="{{ $dd }}">{{ $dd }}</option>
                                                                        @endif
                                                                    @endforeach
                                                                @endif
                                                            @endif
                                                        @endforeach
                                                    @endif
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group col-xs-7" style="padding:0.2% 0">
                                                <div class="col-xs-4" style="padding:0.5% 0">Merk: </div>
                                                <div class="col-xs-8" style="padding:0">
                                                    <select class="form-control" name="search_brand">
                                                        <option class="hidden">Pilih nama merk</option>
                                                        @foreach($brand as $d)
                                                            @if(isset($search_flag))
                                                                @if($d->brand_name == $search_brand)
                                                        <option value="{{ $d->brand_name }}" selected>{{ $d->brand_name }}</option>
                                                                @else
                                                        <option value="{{ $d->brand_name }}">{{ $d->brand_name }}</option>
                                                                @endif
                                                            @else
                                                        <option value="{{ $d->brand_name }}">{{ $d->brand_name }}</option>
                                                            @endif
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group col-xs-7" style="padding:0.2% 0">
                                                <input type="submit" class="btn btn-primary pull-right" value="Submit">
                                                @if(isset($search_flag))
                                                <a href="{{ url('item/tile-manager') }}" class="btn btn-warning pull-right" style="margin-right:10px">Delete Search</a>
                                                @endif
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <table class="table table-bordered" id="tile-list-table">
                                    <thead>
                                        <tr>
                                            <th class="text-center">
                                                <input type="checkbox" class="checkall" onclick="checkall(event)">
                                            </th>
                                            <th class="text-center">ID</th>
                                            <th class="text-center">Image</th>
                                            <th class="text-center">Item Code</th>
                                            <th class="text-center">Item Name</th>
                                            <th class="text-center">Category</th>
                                            <th class="text-center">Brand</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if(sizeof($tile) > 0)
                                        @foreach($tile as $d)
                                        <tr>
                                            <td class="text-center" style="vertical-align:middle">
                                                <input type="checkbox" class="checkthis" data-id="{{ $d->id }}">
                                            </td>
                                            <td class="text-center" style="vertical-align:middle">{{ $d->id }}</td>
                                            <td class="text-center" style="vertical-align:middle">
                                                <img src="{{ asset('/public/assets/image/item-image/small/'.$d->img_name1) }}">
                                            </td>
                                            <td class="text-center" style="vertical-align:middle">{{ $d->item_code }}</td>
                                            <td class="text-center" style="vertical-align:middle">{{ $d->item_name }}</td>
                                            <td class="text-center" style="vertical-align:middle">{{ $d->detail_category_name.', '.$d->category_name }}</td>
                                            <td class="text-center" style="vertical-align:middle">{{ $d->brand_name }}</td>
                                            <td class="text-center" style="vertical-align:middle">
                                                <a href="#" title="detail" data-toggle="modal" data-target="#myModalDetailTile" data-id="{{ $d->id }}" data-type="detail">
                                                    <span class="fa fa-list-alt"></span>
                                                </a>
                                                <a href="#" title="ubah" data-toggle="modal" data-target="#myModalDetailTile" data-id="{{ $d->id }}" data-type="edit">
                                                    <span class="fa fa-pencil"></span>
                                                </a>
                                                <a href="#" title="hapus" class="delete-btn" data-id="{{ $d->id }}" data-toggle="modal" data-target="#myModalDelTileConfirmation" data-type="single">
                                                    <span class="fa fa-trash"></span>
                                                </a>
                                            </td>
                                        </tr>
                                        @endforeach
                                        @else
                                        <tr>
                                            <td colspan="8" class="text-center"><strong>NO TILE DATA</strong></td>
                                        </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->

    <script type="text/javascript" src="{{ asset('public/assets/js/tile.js') }}"></script>
@endsection
