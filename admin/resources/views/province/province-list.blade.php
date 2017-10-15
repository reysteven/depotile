@extends('base')

@section('content')
	<div id="wrapper">
		@include('province/province-del-confirmation')
        <div id="page-wrapper">
            <div class="row">
                <div class="col-xs-12">
                    <h1 class="page-header">Province Manager</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-xs-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Province Manager
                        </div>
                        <div class="panel-body" style="font-weight:normal">
                            <form method="POST" action="{{ url('doDeleteProvince') }}" id="del-province-form">
                            	<input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <input type="hidden" name="province_data">
                            </form>
                            <div class="col-xs-12 dropdown" style="padding:0">
                                <a href="#" class="btn btn-primary" data-toggle="collapse" data-target="#add-province-form-wrapper">Add Province</a>
                                <div class="col-xs-12 collapse" id="add-province-form-wrapper" style="padding:0">
                                    <form method="POST" id="add-province-form" class="col-xs-6" style="padding:10px 0" action="{{ url('doAddProvince') }}">
                                    	<input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <div class="form-group">
                                            <div class="col-xs-4" style="padding:1.3% 0">Province Name :</div
                                            >
                                            <div class="col-xs-8" style="padding:0">
                                                <input type="text" class="form-control" name="province_name" placeholder="Type province name here">
                                                <input type="submit" class="btn btn-primary pull-right" value="Submit" style="margin-top:10px">
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <input type="button" class="btn btn-danger pull-right del-many-btn" value="Delete Selected" data-toggle="modal" data-target="#myModalDelProvinceConfirmation" data-type="many">
                            </div>
                            <div class="col-xs-12" style="padding-bottom:1%">
                                <h3>Pencarian</h3>
                                <div class="tile-search">
                                    <form method="POST" action="{{ url('location/province-manager') }}" id="province-search-form">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <input type="hidden" name="search_flag_tile" value="true">
                                        <div class="form-group col-xs-7" style="padding:0.2% 0">
                                            <div class="col-xs-4" style="padding:0.5% 0">Province Name: </div>
                                            <div class="col-xs-8" style="padding:0">
                                                <input type="text" class="form-control" name="province_name" value="{{ isset($search_flag_tile) ? $province_name : '' }}">
                                            </div>
                                        </div>
                                        <div class="form-group col-xs-7" style="padding:0.2% 0">
                                            <input type="submit" class="btn btn-primary pull-right" value="Search">
                                            @if(isset($search_flag_tile))
                                            <a href="{{ url('location/province-manager') }}" class="btn btn-warning pull-right" style="margin-right:10px">Clear Search</a>
                                            @endif
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="col-xs-12" style="padding:10px 0">
                                <table class="table table-bordered" id="province-list-table">
                                    <tr>
                                        <th class="text-center col-xs-1">
                                            <input type="checkbox" class="checkall" onclick="checkall(event)">
                                        </th>
                                        <th class="text-center col-xs-1">ID</th>
                                        <th class="text-center col-xs-9">Province Name</th>
                                        <th class="text-center col-xs-1">Action</th>
                                    </tr>
                                    @if(sizeof($province) > 0)
                                    @foreach($province as $d)
                                    <tr>
                                    	<td class="text-center">
                                            <input type="checkbox" class="checkthis" data-id="{{ $d->id }}">
                                        </td>
                                        <td class="text-center">{{ $d->id }}</td>
                                        <td class="text-center">
                                            <div class="province-name">
                                                {{ $d->province_name }}
                                            </div>
                                            <div class="edit-province-section hidden col-xs-8 col-xs-offset-2">
                                                <form method="POST" action="{{ url('doEditProvince') }}" class="edit-province-form">
                                                	<input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                    <input type="hidden" name="province_id" value="{{ $d->id }}">
                                                    <div class="col-xs-9">
                                                        <input type="text" class="form-control" value="{{ $d->province_name }}" name="province_name" placeholder="Type province name here">
                                                    </div>
                                                    <div class="col-xs-3">
                                                        <input type="submit" class="btn btn-primary" value="kirim" style="width:100%">
                                                    </div>
                                                </form>
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <a href="#" class="edit-province" title="edit"><span class="fa fa-pencil"></span></a>
                                            <a href="#" class="del-province" data-toggle="modal" data-target="#myModalDelProvinceConfirmation" data-id="{{ $d->id }}" data-type="single" title="delete"><span class="fa fa-trash"></span></a>
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
                </div>
            </div>
        </div>
	</div>
	<script type="text/javascript" src="{{ asset('public/assets/js/province.js') }}"></script>
@endsection