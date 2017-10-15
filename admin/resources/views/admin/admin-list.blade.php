@extends('base')

@section('content')
	<div id="wrapper">

        @include('admin/add-admin');

        <input type="hidden" id="addAdminLink" value="{{ url('doAddAdmin') }}">
        <input type="hidden" id="getAdminDataLink" value="{{ url('doGetAdminData') }}">
        <input type="hidden" id="editAdminLink" value="{{ url('doEditAdmin') }}">

        <div id="page-wrapper">
            <div class="row">
                <div class="col-xs-12">
                    <h1 class="page-header">Admin Manager</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-xs-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Admin Manager
                        </div>
                        <div class="panel-body" style="font-weight:normal">
                            <form method="POST" action="{{ url('doDeleteAdmin') }}" id="del-admin-form">
                            	<input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <input type="hidden" name="data">
                            </form>
                            <div class="col-xs-12 dropdown" style="padding:0">
                                <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#myModalAddAdmin" data-type="add">Add Admin</a>
                                <input type="button" class="btn btn-danger pull-right del-many-btn" value="Delete Selected" data-toggle="modal" data-target="#myModalDelAdminConfirmation" data-type="mass">
                            </div>
                            <div class="col-xs-12" style="padding-bottom:1%">
                                <h3>Searching</h3>
                                <div class="tile-search">
                                    <form method="POST" action="{{ url('user/admin-manager') }}" id="province-search-form">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <input type="hidden" name="search_flag_tile" value="true">
                                        <div class="form-group col-xs-7" style="padding:0.2% 0">
                                            <div class="col-xs-4" style="padding:0.5% 0">Name: </div>
                                            <div class="col-xs-8" style="padding:0">
                                                <input type="text" class="form-control" name="search_name" value="{{ isset($search_flag_tile) ? $search_name : '' }}">
                                            </div>
                                        </div>
                                        <div class="form-group col-xs-7" style="padding:0.2% 0">
                                            <div class="col-xs-4" style="padding:0.5% 0">Email: </div>
                                            <div class="col-xs-8" style="padding:0">
                                                <input type="text" class="form-control" name="search_email" value="{{ isset($search_flag_tile) ? $search_email : '' }}">
                                            </div>
                                        </div>
                                        <div class="form-group col-xs-7" style="padding:0.2% 0">
                                            <input type="submit" class="btn btn-primary pull-right" value="Search">
                                            @if(isset($search_flag_tile))
                                            <a href="{{ url('user/admin-manager') }}" class="btn btn-warning pull-right" style="margin-right:10px">Clear Search</a>
                                            @endif
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="col-xs-12" style="padding:10px 0">
                                <table class="table table-bordered" id="admin-list-table">
                                    <tr>
                                        <th class="text-center col-xs-1">
                                            <input type="checkbox" class="checkall" onclick="checkall(event)">
                                        </th>
                                        <th class="text-center col-xs-1">ID</th>
                                        <th class="text-center col-xs-3">Admin Name</th>
                                        <th class="text-center col-xs-3">Email</th>
                                        <th class="text-center col-xs-4">Address</th>
                                        <th class="text-center col-xs-1">Action</th>
                                    </tr>
                                    @if(sizeof($admin) > 0)
                                    @foreach($admin as $d)
                                    <tr>
                                    	<td class="text-center">
                                            <input type="checkbox" class="checkthis" data-id="{{ $d->id }}">
                                        </td>
                                        <td class="text-center">{{ $d->id }}</td>
                                        <td class="text-center">{{ $d->name }}</td>
                                        <td class="text-center">{{ $d->email }}</td>
                                        <td class="text-center">{{ $d->address }}</td>
                                        <td class="text-center">
                                            <a href="#" class="edit-admin" title="edit" data-toggle="modal" data-target="#myModalAddAdmin" data-type="edit" data-id="{{ $d->id }}"><span class="fa fa-pencil"></span></a>
                                            <a href="#" class="del-admin" data-toggle="modal" data-target="#myModalDelAdminConfirmation" data-id="{{ $d->id }}" data-type="single" title="delete"><span class="fa fa-trash"></span></a>
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
	<script type="text/javascript" src="{{ asset('public/assets/js/admin.js') }}"></script>
@endsection