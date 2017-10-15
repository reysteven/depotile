@extends('base')

@section('content')
    <div id="wrapper">

        @include('brand/add-brand')

        <input type="hidden" id="get-brand-data-link" value="{{ url('getBrandData') }}">
        <input type="hidden" id="edit-brand-link" value="{{ url('doEditBrand') }}">
        <input type="hidden" id="del-brand-link" value="{{ url('doDeleteBrand') }}">

        <form id="delete-brand-form" method="POST" action="{{ url('doDeleteBrand') }}">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <input type="hidden" name="data">
        </form>

        <div class="modal fade" id="myModalDelBrandConfirmation" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="top:30%">
            <div class="modal-dialog" style="width:30%; color:black">
                <div class="modal-content">
                    <div class="modal-body row">
                        <p class="text-center">Are you sure for deleting this/these brand?</p>
                        <div class="text-center">
                            <input type="hidden" name="type">
                            <input type="hidden" name="id">
                            <input type="button" class="btn btn-warning" value="Yes" style="width:15%" name="delBrandConfirmButton">
                            <input type="button" class="btn btn-default" value="No" style="width:15%" data-dismiss="modal">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Brand Manager</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Brand Manager
                        </div>
                        <div class="panel-body" style="font-weight:normal">
                            <input type="button" class="btn btn-primary pull-left" value="Add Brand" style="margin-bottom:10px" data-toggle="modal" data-target="#myModalAddBrand" data-type="add">
                            <input type="button" class="btn btn-danger pull-right" value="Delete Selected" data-toggle="modal" data-target="#myModalDelBrandConfirmation" data-type="mass">
                            <table class="table table-bordered" id="brand-list-table">
                                <tr>
                                    <th class="col-xs-1 text-center">
                                        <input type="checkbox" class="checkall" onclick="checkall(event)">
                                    </th>
                                    <th class="col-xs-1 text-center">ID</th>
                                    <th class="col-xs-4 text-center">Brand Name</th>
                                    <th class="col-xs-5 text-center">Brand Logo</th>
                                    <th class="col-xs-1 text-center">Action</th>
                                </tr>
                                @if(sizeof($brand) > 0)
                                @foreach($brand as $d)
                                <tr>
                                    <td class="text-center" style="vertical-align:middle">
                                        <input type="checkbox" class="checkthis" data-id="{{ $d->id }}">
                                    </td>
                                    <td class="text-center" style="vertical-align:middle">{{ $d->id }}</td>
                                    <td class="text-center" style="vertical-align:middle">{{ $d->brand_name }}</td>
                                    <td class="text-center" style="vertical-align:middle">
                                        <img src="{{ asset('public/assets/image/logo-image/'.$d->brand_logo) }}" width="50%">
                                    </td>
                                    <td class="text-center" style="vertical-align:middle">
                                        <a href="#" class="edit-brand-link" data-id="{{ $d->id }}" title="edit" data-toggle="modal" data-target="#myModalAddBrand" data-type="edit">
                                            <span class="fa fa-pencil"></span>
                                        </a>
                                        <a href="#" class="del-brand-link" data-id="{{ $d->id }}" title="hapus" data-toggle="modal" data-target="#myModalDelBrandConfirmation" data-type="single">
                                            <span class="fa fa-trash"></span>
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                                @else
                                <tr>
                                    <td colspan="3" class="text-center">NO DATA</td>
                                </tr>
                                @endif
                            </table>
                            <form method="POST" action="{{ url('doEditBrandOrderBy') }}" id="editBrandOrderByForm">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <div class="col-xs-8">
                                    <div class="col-xs-2" style="padding-top:1%">ORDER BY: </div>
                                    <div class="col-xs-4">
                                        <select class="form-control" name="orderBy">
                                            @if($order_by == 'id')
                                            <option value="id" selected>ID</option>
                                            @else
                                            <option value="id">ID</option>
                                            @endif
                                            @if($order_by == 'brand_name')
                                            <option value="brand_name" selected>Brand Name</option>
                                            @else
                                            <option value="brand_name">Brand Name</option>
                                            @endif
                                            @if($order_by == 'created_at')
                                            <option value="created_at" selected>Created Date</option>
                                            @else
                                            <option value="created_at">Created Date</option>
                                            @endif
                                            @if($order_by == 'updated_at')
                                            <option value="updated_at" selected>Updated Date</option>
                                            @else
                                            <option value="updated_at">Updated Date</option>
                                            @endif
                                        </select>
                                    </div>
                                    <div class="col-xs-2">
                                        <input type="submit" class="btn btn-primary" value="Submit">
                                    </div>
                                </div>
                            </form>
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

    <script type="text/javascript" src="{{ asset('public/assets/js/brand.js') }}"></script>
@endsection
