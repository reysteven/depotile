@extends('base')

@section('content')
    <div id="html-error-msg"></div>
	<div id="wrapper">
		@include('city/city-del-confirmation')
        @include('city/city-edit')
        <div id="page-wrapper">
            <div class="row">
                <div class="col-xs-12">
                    <h1 class="page-header">City Manager</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-xs-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            City Manager
                        </div>
                        <div class="panel-body" style="font-weight:normal">
                            <form method="POST" action="{{ url('doDeleteCity') }}" id="del-city-form">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <input type="hidden" name="city_data">
                            </form>
                            <div class="col-xs-12" style="padding:0">
                                <a href="#" class="btn btn-primary" data-toggle="collapse" data-target="#add-city-form-wrapper">Add City</a>
                                <div class="col-xs-12 collapse" id="add-city-form-wrapper" style="padding:0">
                                    <form method="POST" id="add-city-form" class="col-xs-6" style="padding:10px 0" action="{{ url('doAddCity') }}">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <div class="form-group">
                                            <div class="col-xs-4" style="padding:1.3% 0">Province Name :</div
                                            >
                                            <div class="col-xs-8" style="padding:0">
                                                <select class="form-control" name="province_name">
                                                @foreach($province as $d)
                                                    <option class="hidden" value="null">Select a province name here</option>
                                                    <option value="{{ $d->province_name }}">{{ $d->province_name }}</option>
                                                @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-xs-4" style="padding:1.3% 0">City Name :</div
                                            >
                                            <div class="col-xs-8" style="padding:0">
                                                <input type="text" class="form-control" name="city_name" placeholder="Ketik nama kota disini">
                                                <input type="submit" class="btn btn-primary pull-right" value="Kirim" style="margin-top:10px">
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <input type="button" class="btn btn-danger pull-right del-many-btn" value="Hapus Pilihan" data-type="many" data-toggle="modal" data-target="#myModalDelCityConfirmation">
                            </div>
                            <div class="col-xs-12" style="padding-bottom:1%">
                                <h3>Pencarian</h3>
                                <div class="tile-search">
                                    <form method="POST" action="{{ url('location/city-manager') }}" id="city-search-form">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <input type="hidden" name="search_flag_tile" value="true">
                                        <div class="form-group col-xs-7" style="padding:0.2% 0">
                                            <div class="col-xs-4" style="padding:0.5% 0">Province Name: </div>
                                            <div class="col-xs-8" style="padding:0">
                                                <input type="text" class="form-control" name="province_name" value="{{ isset($search_flag_tile) ? $province_name : '' }}">
                                            </div>
                                        </div>
                                        <div class="form-group col-xs-7" style="padding:0.2% 0">
                                            <div class="col-xs-4" style="padding:0.5% 0">City Name: </div>
                                            <div class="col-xs-8" style="padding:0">
                                                <input type="text" class="form-control" name="city_name" value="{{ isset($search_flag_tile) ? $city_name : '' }}">
                                            </div>
                                        </div>
                                        <div class="form-group col-xs-7" style="padding:0.2% 0">
                                            <input type="submit" class="btn btn-primary pull-right" value="Search">
                                            @if(isset($search_flag_tile))
                                            <a href="{{ url('location/city-manager') }}" class="btn btn-warning pull-right" style="margin-right:10px">Clear Search</a>
                                            @endif
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="col-xs-12" style="padding:10px 0">
                                <table class="table table-bordered" id="city-list-table">
                                    <tr>
                                        <th class="text-center col-xs-1">
                                            <input type="checkbox" class="checkall" onclick="checkall(event)">
                                        </th>
                                        <th class="text-center col-xs-2">Province ID </th>
                                        <th class="text-center col-xs-1">City ID</th>
                                        <th class="text-center col-xs-4">Province Name</th>
                                        <th class="text-center col-xs-4">City Name</th>
                                        <th class="text-center col-xs-1">Action</th>
                                    </tr>
                                    @if(sizeof($city) > 0)
                                    @foreach($city as $d)
                                    <tr>
                                        <td class="text-center">
                                            <input type="checkbox" class="checkthis" data-id="{{ $d->id }}">
                                        </td>
                                        <td class="text-center">{{ $d->province_id }}</td>
                                        <td class="text-center">{{ $d->id }}</td>
                                        <td class="text-center province_name">{{ $d->province_name }}</td>
                                        <td class="text-center city_name">{{ $d->city_name }}</td>
                                        <td class="text-center">
                                            <a href="#" class="edit-city-link" data-id="{{ $d->id }}" data-toggle="modal" data-target="#myModalEditCity">
                                                <span class="fa fa-pencil"></span>
                                            </a>
                                            <a href="#" class="del-city-link" data-id="{{ $d->id }}" data-toggle="modal" data-target="#myModalDelCityConfirmation" data-type="single">
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
	<script type="text/javascript" src="{{ asset('public/assets/js/city.js') }}"></script>
@endsection