@extends('base')

@section('content')
    <div id="wrapper">

        @include('fee/fee-uploader')

        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Shipping Fee Manager</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Shippinh Fee Manager
                        </div>
                        <div class="panel-body" style="font-weight:normal">
                            @if($errors->any())
                            <div class="alert alert-danger col-xs-12" role="alert">
                                <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                                <span class="sr-only">Error:</span>
                                {{ $errors->first() }}
                            </div>
                            @endif
                            <div class="col-xs-12" style="margin-top:10px">
                                <div class="col-xs-6" style="padding:1% 0; text-align:left">
                                    <input type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModalFeeUploader" value="Import/Export">
                                </div>
                            </div>
                            <span style="color:red; margin-left:14px">Reupload if you want to add, edit, and delete fee data</span>
                            <div class="col-xs-12" style="padding-bottom:1%">
                                <h3>Search</h3>
                                <div class="order-search">
                                    <form method="POST" action="" id="fee-search-form">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <input type="hidden" name="search-flag" value="true">
                                        <div class="form-group col-xs-7" style="padding:0.2% 0">
                                            <div class="col-xs-4" style="padding:0.5% 0">Fee Name: </div>
                                            <div class="col-xs-8" style="padding:0">
                                                <select class="form-control" name="search-name">
                                                    <option class="hidden">Select fee name</option>
                                                    @foreach($fee as $d)
                                                    @if(!isset($search_flag))
                                                    <option value="{{ $d['fee_name'] }}">{{ $d['fee_name'] }}</option>
                                                    @else
                                                        @if($d['fee_name'] == $search_name)
                                                    <option value="{{ $d['fee_name'] }}" selected>{{ $d['fee_name'] }}</option>
                                                        @else
                                                    <option value="{{ $d['fee_name'] }}">{{ $d['fee_name'] }}</option>
                                                        @endif
                                                    @endif
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group col-xs-7" style="padding:0.2% 0">
                                            <div class="col-xs-4" style="padding:0.5% 0">Provinsi: </div>
                                            <div class="col-xs-8" style="padding:0">
                                                <select class="form-control" name="search-province">
                                                    <option class="hidden">Pilih nama provinsi</option>
                                                    @foreach($province as $d)
                                                    @if(!isset($search_province))
                                                    <option value="{{ $d['province_name'] }}">{{ $d['province_name'] }}</option>
                                                    @else
                                                        @if($d['province_name'] == $search_province)
                                                    <option value="{{ $d['province_name'] }}" selected>{{ $d['province_name'] }}</option>
                                                        @else
                                                    <option value="{{ $d['province_name'] }}">{{ $d['province_name'] }}</option>
                                                        @endif
                                                    @endif
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group col-xs-7" style="padding:0.2% 0">
                                            <div class="col-xs-4" style="padding:0.5% 0">Kota: </div>
                                            <div class="col-xs-8" style="padding:0">
                                                @if(!isset($search_flag))
                                                <select class="form-control" name="search-city" disabled>
                                                    <option>Pilih provinsi dahulu</option>
                                                </select>
                                                @else                                                
                                                <select class="form-control" name="search-city">
                                                    <option class="hidden">Pilih nama kota</option>
                                                    @foreach($province as $d)
                                                        @if($d['province_name'] == $search_province)
                                                            @foreach($d['city'] as $cd)
                                                                @if($cd['city_name'] == $search_city)
                                                    <option value="{{ $cd['city_name'] }}" selected>{{ $cd['city_name'] }}</option>
                                                                @else
                                                    <option value="{{ $cd['city_name'] }}">{{ $cd['city_name'] }}</option>
                                                                @endif
                                                            @endforeach
                                                        @endif
                                                    @endforeach
                                                </select>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="form-group col-xs-7" style="padding:0.2% 0">
                                            <div class="col-xs-4" style="padding:0.5% 0">Jangka Biaya: </div>
                                            <div class="col-xs-3" style="padding:0">
                                                <input type="text" id="search-startfee" class="form-control datepicker" name="search-startfee" value="{{ (isset($search_startfee)) ? $search_startfee : '' }}">
                                            </div>
                                            <div class="col-xs-2 text-center" style="padding:0.8% 0 0 0">sampai</div>
                                            <div class="col-xs-3" style="padding:0">
                                                <input type="text" id="search-endfee" class="form-control datepicker" name="search-endfee" value="{{ (isset($search_endfee)) ? $search_endfee : '' }}">
                                            </div>
                                        </div>
                                        <div class="form-group col-xs-7" style="padding:0.2% 0">
                                            <div class="col-xs-12" style="margin-bottom:2%; padding:0">
                                                <div class="pull-left" style="padding-top:0.5%"><strong>Use search to present fee data that you want to see</strong></div>
                                            </div>
                                            <input type="submit" class="btn btn-primary pull-right" value="Search">
                                            @if(isset($search_flag))
                                            <a href="{{ url('fee-manager') }}" class="btn btn-warning pull-right" style="margin-right:10px">Hapus Pencarian</a>
                                            @endif
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="col-xs-12" id="result-section">
                            @if(isset($search_flag))
                                <table class="table table-bordered">
                                    <tr>
                                        <th class="text-center col-xs-3">Nama</th>
                                        <th class="text-center col-xs-2">Provinsi</th>
                                        <th class="text-center col-xs-2">Kota</th>
                                        <th class="text-center col-xs-2">Jumlah</th>
                                        <th class="text-center col-xs-3">Tarif</th>
                                    </tr>
                                @foreach($fee as $d)
                                    <tr>
                                        <td class="text-center"><?php echo $d['fee_name'] ?></td>
                                        <td class="text-center"><?php echo $d['province_name'] ?></td>
                                        <td class="text-center"><?php echo $d['city_name'] ?></td>
                                    @php
                                    if($d['quantity_above'] >= 1000000)
                                        $jml = ">=".$d['quantity_below'];
                                    else
                                        $jml = $d['quantity_below'].' - '.$d['quantity_above'];
                                    @endphp
                                        <td class="text-center"><?php echo $jml ?></td>
                                        <td class="text-center">Rp. {{ number_format($d['fee_value'],0,'.','.') }}</td>
                                    </tr>
                                @endforeach
                                </table>
                            @endif
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

    <script type="text/javascript" src="{{ asset('public/assets/js/fee.js') }}"></script>
@endsection
