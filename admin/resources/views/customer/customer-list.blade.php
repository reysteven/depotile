@extends('base')

@section('content')
    <div id="html-error-msg"></div>
	<div id="wrapper">

        @include('customer/customer-detail');

        <input type="hidden" id="addCustomerLink" value="{{ url('doAddCustomer') }}">
        <input type="hidden" id="getCustomerDataLink" value="{{ url('doGetCustomerData') }}">
        <input type="hidden" id="editCustomerLink" value="{{ url('doEditCustomer') }}">

        <div id="page-wrapper">
            <div class="row">
                <div class="col-xs-12">
                    <h1 class="page-header">Customer Manager</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-xs-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Customer Manager
                        </div>
                        <div class="panel-body" style="font-weight:normal">
                            <form method="POST" action="{{ url('doDeleteCustomer') }}" id="del-admin-form">
                            	<input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <input type="hidden" name="data">
                            </form>
                            <div class="col-xs-12 dropdown" style="padding:0">
                                <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#myModalAddCustomer" data-type="add">Add Customer</a>
                                <input type="button" class="btn btn-danger pull-right del-many-btn" value="Delete Selected" data-toggle="modal" data-target="#myModalDelCustomerConfirmation" data-type="mass">
                            </div>
                            <div class="col-xs-12" style="padding-bottom:1%">
                                <h3>Searching</h3>
                                <div class="tile-search">
                                    <form method="POST" action="{{ url('user/customer-manager') }}" id="province-search-form">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <input type="hidden" name="search_flag" value="true">
                                        <div class="form-group col-xs-7" style="padding:0.2% 0">
                                            <div class="col-xs-4" style="padding:0.5% 0">Name: </div>
                                            <div class="col-xs-8" style="padding:0">
                                                <input type="text" class="form-control" name="search_name" value="{{ isset($search_flag) ? $search_name : '' }}">
                                            </div>
                                        </div>
                                        <div class="form-group col-xs-7" style="padding:0.2% 0">
                                            <div class="col-xs-4" style="padding:0.5% 0">Email: </div>
                                            <div class="col-xs-8" style="padding:0">
                                                <input type="text" class="form-control" name="search_email" value="{{ isset($search_flag) ? $search_email : '' }}">
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
                                        <th class="text-center col-xs-2">Customer Name</th>
                                        <th class="text-center col-xs-3">Email</th>
                                        <th class="text-center col-xs-2">Customer Since</th>
                                        <th class="text-center col-xs-2">Last Login</th>
                                        <th class="text-center col-xs-2">Action</th>
                                    </tr>
                                    @if(sizeof($customer) > 0)
                                    @foreach($customer as $d)
                                    <tr>
                                    	<td class="text-center">
                                            <input type="checkbox" class="checkthis" data-id="{{ $d->id }}">
                                        </td>
                                        <td class="text-center">{{ $d->id }}</td>
                                        <td class="text-center">{{ $d->name }}</td>
                                        <td class="text-center">{{ $d->email }}</td>
                                        <td class="text-center">{{ Carbon::createFromFormat('Y-m-d H:i:s', $d->created_at)->format('d-m-Y H:i:s') }}</td>
                                        @if($d->last_login != '0000-00-00 00:00:00')
                                        <td class="text-center">{{ Carbon::createFromFormat('Y-m-d H:i:s', $d->created_at) }}</td>
                                        @else
                                        <td class="text-center">0000-00-00 00:00:00</td>
                                        @endif
                                        <td class="text-center">
                                            <a href="#" class="edit-admin" title="detail" data-toggle="modal" data-target="#myModalDetailCustomer" data-type="detail" data-id="{{ $d->id }}"><span class="fa fa-list-alt"></span></a>
                                            <a href="#" class="edit-admin" title="edit" data-toggle="modal" data-target="#myModalAddCustomer" data-type="edit" data-id="{{ $d->id }}"><span class="fa fa-pencil"></span></a>
                                            <a href="#" class="del-admin" data-toggle="modal" data-target="#myModalDelCustomerDelete"><span class="fa fa-trash"></span></a>
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
	<script type="text/javascript" src="{{ asset('public/assets/js/customer.js') }}"></script>
@endsection