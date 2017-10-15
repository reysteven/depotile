@extends('base')

@section('content')
    <div id="html-error-msg"></div>
    <div id="wrapper">

        @include('category/edit-sub-category')

        <form id="delete-category-form" method="POST" action="{{ url('doDeleteCategory') }}">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <input type="hidden" name="data">
        </form>
        <form id="delete-subcategory-form" method="POST" action="{{ url('doDeleteSubCategory') }}">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <input type="hidden" name="data">
        </form>

        <input type="hidden" id="edit-category-link" value="{{ url('doEditCategory') }}">
        <input type="hidden" id="add-sub-category-link" value="{{ url('doAddSubCategory') }}">
        <input type="hidden" id="get-sub-category-data-link" value="{{ url('doGetSubCategoryData') }}">
        <input type="hidden" id="edit-sub-category-link" value="{{ url('doEditSubCategory') }}">
        <input type="hidden" id="del-sub-category-link" value="{{ url('doDeleteSubCategory') }}">

        <div class="modal fade" id="myModalDelCategoryConfirmation" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="top:30%">
            <div class="modal-dialog" style="width:30%; color:black">
                <div class="modal-content">
                    <div class="modal-body row">
                        <p class="text-center">Apakah anda yakin untuk menghapus kategori ini?</p>
                        <div class="text-center">
                            <input type="hidden" name="type">
                            <input type="hidden" name="id">
                            <input type="button" class="btn btn-warning" value="Ya" style="width:15%" name="delCategoryConfirmButton">
                            <input type="button" class="btn btn-default" value="Tidak" style="width:15%" data-dismiss="modal">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="myModalDelSubCategoryConfirmation" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="top:30%">
            <div class="modal-dialog" style="width:30%; color:black">
                <div class="modal-content">
                    <div class="modal-body row">
                        <p class="text-center">Apakah anda yakin untuk menghapus sub kategori ini?</p>
                        <div class="text-center">
                            <input type="hidden" name="type">
                            <input type="hidden" name="id">
                            <input type="button" class="btn btn-warning" value="Ya" style="width:15%" name="delSubCategoryConfirmButton">
                            <input type="button" class="btn btn-default" value="Tidak" style="width:15%" data-dismiss="modal">
                        </div>
                        <div class="loading-div text-center hidden">
                            <span class="fa fa-spin fa-spinner fa-2x"></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Category Manager</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Category Manager
                        </div>
                        <div class="panel-body" style="font-weight:normal">
                            <input type="button" class="btn btn-primary pull-left" value="Add Category" style="margin-bottom:10px" data-toggle="collapse" data-target="#add-category-form-wrapper">
                            <input type="button" class="btn btn-danger pull-right" value="Delete Selected" style="margin-bottom:10px" data-toggle="modal" data-target="#myModalDelCategoryConfirmation" data-type="mass">
                            <div class="col-xs-12 collapse" id="add-category-form-wrapper" style="padding:0">
                                <form method="POST" id="add-category-form" class="col-xs-6" style="padding:10px 0" action="{{ url('doAddCategory') }}">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    <div class="form-group">
                                        <div class="col-xs-4" style="padding:1.3% 0">Category Name :</div
                                        >
                                        <div class="col-xs-8" style="padding:0">
                                            <input type="text" class="form-control" name="category_name" placeholder="Type category name here">
                                            <input type="submit" class="btn btn-primary pull-right" value="Submit" style="margin-top:10px">
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="col-xs-12" style="padding-bottom:1%">
                                <h3>Searching</h3>
                                <div class="tile-search">
                                    <form method="POST" action="{{ url('category-manager') }}" id="category-search-form">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <input type="hidden" name="search_flag_tile" value="true">
                                        <div class="form-group col-xs-7" style="padding:0.2% 0">
                                            <div class="col-xs-4" style="padding:0.5% 0">Category Name: </div>
                                            <div class="col-xs-8" style="padding:0">
                                                <input type="text" class="form-control" name="category_name" value="{{ isset($search_flag_tile) ? $category_name : '' }}">
                                            </div>
                                        </div>
                                        <div class="form-group col-xs-7" style="padding:0.2% 0">
                                            <div class="col-xs-4" style="padding:0.5% 0">Sub Category Name: </div>
                                            <div class="col-xs-8" style="padding:0">
                                                <input type="text" class="form-control" name="sub_category_name" value="{{ isset($search_flag_tile) ? $sub_category_name : '' }}">
                                            </div>
                                        </div>
                                        <div class="form-group col-xs-7" style="padding:0.2% 0">
                                            <input type="submit" class="btn btn-primary pull-right" value="Search">
                                            @if(isset($search_flag_tile))
                                            <a href="{{ url('category-manager') }}" class="btn btn-warning pull-right" style="margin-right:10px">Clear Search</a>
                                            @endif
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="col-xs-12">
                                <table class="table table-bordered" id="category-list-table">
                                    <tr>
                                        <th class="col-xs-1 text-center">
                                            <input type="checkbox" class="checkall" onclick="checkall(event)">
                                        </th>
                                        <th class="col-xs-1 text-center">ID</th>
                                        <th class="col-xs-9 text-center">Category Name</th>
                                        <th class="col-xs-2 text-center">Action</th>
                                    </tr>
                                    @if(sizeof($category) > 0)
                                    @foreach($category as $d)
                                    <tr>
                                        <td class="text-center">
                                            <input type="checkbox" class="checkthis" data-id="{{ $d->id }}">
                                        </td>
                                        <td class="text-center">{{ $d->id }}</td>
                                        <td class="text-center category-name-col" data-id="{{ $d->id }}">{{ $d->category_name }}</td>
                                        <td class="text-center">
                                            <a href="#" title="detail" data-toggle="collapse" data-target="#category-detail-{{ $d->id }}" title="detail">
                                                <span class="fa fa-list-alt"></span>
                                            </a>
                                        </td>
                                    </tr>
                                    <tr id="category-detail-{{ $d->id }}" class="collapse">
                                        <td colspan="4" class="text-center" style="background-color:#286090">
                                            <div class="col-xs-12">
                                                <div class="text-center">
                                                    <h4 style="color:white">Category Detail</h4>
                                                </div>
                                                <div class="form-group col-xs-6" style="padding:0">
                                                    <div class="col-xs-3 text-left" style="padding:1% 0 0 0; color:white">Category Name : </div>
                                                    <div class="col-xs-7">
                                                        <input type="text" class="form-control category-name-input" name="category_name" value="{{ $d->category_name }}" data-id="{{ $d->id }}" disabled>
                                                    </div>
                                                    @if($d->category_name != "Aksesoris")
                                                    <div class="col-xs-1" style="padding:1% 0 0 0">
                                                        <a href="#" class="edit-category-name-link" title="change name" style="color:white">
                                                            <span class="fa fa-pencil"></span>
                                                        </a>
                                                        <a href="#" class="submit-category-name-link hidden" title="ok" style="color:white" data-id="{{ $d->id }}">
                                                            <span class="fa fa-check"></span>
                                                        </a>
                                                        <div class="loading-div hidden" style="color:white">
                                                            <span class="fa fa-spin fa-spinner"></span>
                                                        </div>
                                                    </div>
                                                    @endif
                                                </div>
                                                @if($d->category_name != "Aksesoris")
                                                <div class="col-xs-5 text-right pull-right" style="padding:0">
                                                    <input type="button" class="btn btn-danger del-category-btn" value="Delete Category" data-id="{{ $d->id }}" data-toggle="modal" data-target="#myModalDelCategoryConfirmation" data-type="single">
                                                </div>
                                                @endif
                                                <div class="col-xs-12" style="padding:0"><hr></div>
                                                <div class="col-xs-12 text-left" style="padding:0 0 10px 0">
                                                    <input type="button" class="btn btn-default add-sub-category-btn" value="Add Sub Category" data-toggle="modal" data-target="#myModalEditSubCategory" data-type="add" data-id="{{ $d->id }}">
                                                </div>
                                                <table class="table table-bordered" name="sub-category-list-table">
                                                    <tr>
                                                        <th class="text-center col-xs-1">ID</th>
                                                        <th class="text-center col-xs-10">Sub Category Name</th>
                                                        <th class="text-center col-xs-1">Action</th>
                                                    </tr>
                                                    @foreach($d->detail as $dd)
                                                    <tr>
                                                        <td class="text-center">{{ $dd->id }}</td>
                                                        <td class="text-center">{{ $dd->detail_category_name }}</td>
                                                        <td class="text-center">
                                                            <a href="#" class="edit-sub-category-name-link" data-id="{{ $dd->id }}" title="ubah" data-toggle="modal" data-target="#myModalEditSubCategory" data-type="edit">
                                                                <span class="fa fa-pencil"></span>
                                                            </a>
                                                            <a href="#" class="del-sub-category-name-link" data-id="{{ $dd->id }}" title="hapus" data-toggle="modal" data-target="#myModalDelSubCategoryConfirmation">
                                                                <span class="fa fa-trash"></span>
                                                            </a>
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                </table>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                    @else
                                    <tr>
                                        <td colspan="4" class="text-center">NO DATA</td>
                                    </tr>
                                    @endif
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

    <script type="text/javascript" src="{{ asset('public/assets/js/category.js') }}"></script>
@endsection