@extends('base')

@section('content')
    <div id="html-error-msg"></div>
    <div id="wrapper">

        @include('item/import-export-addon')

        <form id="delete-addon-form" method="POST" action="doDeleteAddon.php">
            <input type="hidden" name="data-id">
        </form>

        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Add On Manager</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Add On Manager
                        </div>
                        <div class="panel-body" style="font-weight:normal">

                            <div class="col-xs-12">
                                <div class="col-xs-6" style="padding:1% 0; text-align:left">
                                    <input type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModalImportExportAddon" value="Import/Export">
                                </div>
                                <div class="col-xs-6" style="padding:1% 0; text-align:right">
                                    <input type="button" class="btn btn-danger delete-all-btn" value="Delete Selected" data-toggle="modal" data-target="#myModalDelAddonConfirmation" data-type="mass-del">
                                </div>
                                <div class="col-xs-12" style="padding-bottom:1%">
                                    <h3>Searching</h3>
                                    <div class="item-search">
                                        <form method="GET" action="#" id="addon-search-form">
                                            <input type="hidden" name="search_flag" value="true">
                                            <div class="form-group col-xs-7" style="padding:0.2% 0">
                                                <div class="col-xs-4" style="padding:0.5% 0">ID: </div>
                                                <div class="col-xs-8" style="padding:0">
                                                    <input type="text" class="form-control" name="search_id" value="{{ isset($search_flag) ? $search_id : '' }}">
                                                </div>
                                            </div>
                                            <div class="form-group col-xs-7" style="padding:0.2% 0">
                                                <div class="col-xs-4" style="padding:0.5% 0">Name: </div>
                                                <div class="col-xs-8" style="padding:0">
                                                    <input type="text" class="form-control" name="search_code" value="{{ isset($search_code) ? $search_code : '' }}">
                                                </div>
                                            </div>
                                            <div class="form-group col-xs-7" style="padding:0.2% 0">
                                                <div class="col-xs-4" style="padding:0.5% 0">Name: </div>
                                                <div class="col-xs-8" style="padding:0">
                                                    <input type="text" class="form-control" name="search_name" value="{{ isset($search_flag) ? $search_name : '' }}">
                                                </div>
                                            </div>
                                            <div class="form-group col-xs-7" style="padding:0.2% 0">
                                                <div class="col-xs-4" style="padding:0.5% 0">Type: </div>
                                                <div class="col-xs-8" style="padding:0">
                                                    <select class="form-control" name="search_category">
                                                        <option class="hidden">Choose category name</option>
                                                        @foreach($category as $d)
                                                            @if($d['category_name'] == "Aksesoris")
                                                                @foreach($d['detail_category'] as $dd)
                                                                    @if(isset($search_flag)) 
                                                                        @if($dd == $search_category)
                                                        <option value="{{ $dd }}" selected>{{ $dd }}</option>
                                                                        @else                            
                                                        <option value="{{ $dd }}">{{ $dd }}</option>
                                                                        @endif
                                                                    @else
                                                        <option value="{{ $dd }}">{{ $dd }}</option>
                                                                    @endif
                                                                @endforeach
                                                            @endif
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group col-xs-7" style="padding:0.2% 0">
                                                <div class="col-xs-4" style="padding:0.5% 0">Color: </div>
                                                <div class="col-xs-8" style="padding:0">
                                                    <input type="text" class="form-control" name="search_color" value="{{ isset($search_flag) ? $search_color : '' }}">
                                                </div>
                                            </div>
                                            <div class="form-group col-xs-7" style="padding:0.2% 0">
                                                <div class="col-xs-4" style="padding:0.5% 0">Brand: </div>
                                                <div class="col-xs-8" style="padding:0">
                                                    <select class="form-control" name="search_brand">
                                                        <option class="hidden">Pilih nama merk</option>
                                                        @foreach($brand as $d)
                                                            @if(isset($search_flag))
                                                                @if($d->brand_name == $search_brand)
                                                    ?>
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
                                                <input type="submit" class="btn btn-primary pull-right" value="Cari">
                                                @if(isset($search_flag))
                                                <a href="{{ url('add-on-manager') }}" class="btn btn-warning pull-right" style="margin-right:10px">Clear Searching</a>
                                                @endif
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <table class="table table-bordered" id="addon-list-table">
                                    <tr>
                                        <th class="text-center col-xs-1">
                                            <input type="checkbox" class="check-all">
                                        </th>
                                        <th class="text-center col-xs-1">ID</th>
                                        <th class="text-center col-xs-2">Item Code</th>
                                        <th class="text-center col-xs-3">Image</th>
                                        <th class="text-center col-xs-2">Item Name</th>
                                        <th class="text-center col-xs-2">Type</th>
                                        <th class="text-center col-xs-2">Action</th>
                                    </tr>
                                    @if(sizeof($addon) > 0)
                                    @foreach($addon as $d)
                                    <tr>
                                        <td class="text-center" style="vertical-align:middle">
                                            <input type="checkbox" class="check-this" name="checkthis" data-id="{{ $d->id }}">
                                        </td>
                                        <td class="text-center" style="vertical-align:middle">{{ $d->id }}</td>
                                        <td class="text-center" style="vertical-align:middle">{{ $d->item_code }}</td>
                                        <td class="text-center" style="vertical-align:middle">
                                            <img src="{{ asset('public/assets/image/item-image/add-on/small/'.$d->img_name) }}" width="106px">
                                        </td>
                                        <td class="text-center" style="vertical-align:middle">{{ $d->add_on_name }}</td>
                                        <td class="text-center" style="vertical-align:middle">{{ $d->type }}</td>
                                        <td class="text-center" style="vertical-align:middle">
                                            <a href="#" title="detail" data-toggle="modal" data-target="#myModalDetailAddon" data-id="{{ $d->id }}" data-type="detail">
                                                <span class="fa fa-list-alt"></span>
                                            </a>
                                            <a href="#" title="ubah" data-toggle="modal" data-target="#myModalDetailAddon" data-id="{{ $d->id }}" data-type="edit">
                                                <span class="fa fa-pencil"></span>
                                            </a>
                                            <a href="#" title="hapus" class="delete-btn" data-id="{{ $d->id }}" data-toggle="modal" data-target="#myModalDelAddonConfirmation" data-type="addon-del">
                                                <span class="fa fa-trash"></span>
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                    @else
                                    <tr>
                                        <td colspan="6" class="text-center">NO DATA</td>
                                    </tr>
                                    @endif
                                </table>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript" src="{{ asset('public/assets/js/addon.js') }}"></script>
@endsection