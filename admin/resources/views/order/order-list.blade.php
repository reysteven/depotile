@extends('base')

@section('content')
    <div id="html-error-msg"></div>
    <div id="wrapper">

        @include('order/change-status')
        @include('order/payment-detail')

        <form id="delete-addon-form" method="POST" action="{{ url('doDeleteOrder') }}">
            <input type="hidden" name="data">
        </form>

        <input type="hidden" id="getAddressDataLink" value="{{ url('doGetAddressData') }}">
        <input type="hidden" id="getPaymentDataLink" value="{{ url('doGetPaymentData') }}">

        <input type="hidden" id="user-data" value="{{ json_encode($user) }}">
        <input type="hidden" id="tile-data" value="{{ json_encode($tile) }}">
        <input type="hidden" id="addon-data" value="{{ json_encode($addon) }}">

        <div class="modal fade" id="myModalChooseCustomer" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog" style="width:50%">
                <div class="modal-content">
                    <div class="modal-header" style="background-color:#224098; color:white">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h4 class="title text-center">Choose Customer</h4>
                    </div>
                    <div class="modal-body row" style="color:black">
                        <div class="error-msg col-sm-12 text-center" style="margin-top:1%; color:red"></div>
                        <div class="loading-div text-center hidden">
                            <span class="fa fa-spinner fa-spin fa-2x"></span>
                        </div>
                        <div class="content">
                            <form method="POST" action="{{ url('order-manager/add-order') }}">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <div class="panel-group col-xs-10 col-xs-offset-1">
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <label>Search :</label>
                                        <input type="text" name="searchCustomerName">
                                    </div>
                                    <div class="panel-body">
                                    @foreach($user as $d)
                                        <div class="col-xs-12">
                                            <input type="radio" name="user" value="{{ $d->id }}" data-name="{{ $d->name }}">&nbsp <label for="user" style="font-size:14px">{{ $d->name }}</label>
                                        </div>
                                    @endforeach
                                    </div>
                                </div>
                                <div style="margin-top:2%">
                                    <input type="submit" class="btn btn-primary pull-right" value="Choose">
                                    <input type="button" data-dismiss="modal" class="btn btn-default pull-right" value="Cancel">
                                </div>
                            </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Order Manager</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Order Manager
                        </div>
                        <div class="panel-body" style="font-weight:normal">

                            <div class="col-xs-12">
                                <div class="col-xs-6" style="padding:1% 0; text-align:left">
                                    <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#myModalChooseCustomer">Add Order Manually</a>
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
                                                <div class="col-xs-4" style="padding:0.5% 0">Receiver Name: </div>
                                                <div class="col-xs-8" style="padding:0">
                                                    <input type="text" class="form-control" name="search_name" value="{{ isset($search_flag) ? $search_name : '' }}">
                                                </div>
                                            </div>
                                            <div class="form-group col-xs-7" style="padding:0.2% 0">
                                                <div class="col-xs-4" style="padding:0.5% 0">Order ID: </div>
                                                <div class="col-xs-8" style="padding:0">
                                                    <input type="text" class="form-control" name="search_id" value="{{ isset($search_flag) ? $search_id : '' }}">
                                                </div>
                                            </div>
                                            <div class="form-group col-xs-7" style="padding:0.2% 0">
                                                <div class="col-xs-4" style="padding:0.5% 0">Order Number: </div>
                                                <div class="col-xs-8" style="padding:0">
                                                    <input type="text" class="form-control" name="search_number" value="{{ isset($search_flag) ? $search_number : '' }}">
                                                </div>
                                            </div>
                                            <div class="form-group col-xs-7" style="padding:0.2% 0">
                                                <div class="col-xs-4" style="padding:0.5% 0">Status: </div>
                                                <div class="col-xs-8" style="padding:0">
                                                    <select class="form-control" name="search_brand">
                                                    @if(isset($search_flag))
                                                        @if($search_brand == 'Menunggu Pembayaran')
                                                        <option value="Menunggu Pembayaran" selected>Menunggu Pembayaran</option>
                                                        @else
                                                        <option value="Menunggu Pembayaran">Menunggu Pembayaran</option>
                                                        @endif
                                                        @if($search_brand == 'Menunggu Konfirmasi')
                                                        <option value="Menunggu Konfirmasi" selected>Menunggu Konfirmasi</option>
                                                        @else
                                                        <option value="Menunggu Konfirmasi">Menunggu Konfirmasi</option>
                                                        @endif
                                                        @if($search_brand == 'Pesanan Terkonfirmasi')
                                                        <option value="Pesanan Terkonfirmasi" selected>Pesanan Terkonfirmasi</option>
                                                        @else
                                                        <option value="Pesanan Terkonfirmasi">Pesanan Terkonfirmasi</option>
                                                        @endif
                                                        @if($search_brand == 'Pesanan Dibatalkan')
                                                        <option value="Pesanan Dibatalkan" selected>Pesanan Dibatalkan</option>
                                                        @else
                                                        <option value="Pesanan Dibatalkan">Pesanan Dibatalkan</option>
                                                        @endif
                                                        @if($search_brand == 'Pesanan Terkirim')
                                                        <option value="Pesanan Terkirim" selected>Pesanan Terkirim</option>
                                                        @else
                                                        <option value="Pesanan Terkirim">Pesanan Terkirim</option>
                                                        @endif
                                                    @else
                                                        <option value="Menunggu Pembayaran">Menunggu Pembayaran</option>
                                                        <option value="Menunggu Konfirmasi">Menunggu Konfirmasi</option>
                                                        <option value="Pesanan Terkonfirmasi">Pesanan Terkonfirmasi</option>
                                                        <option value="Pesanan Dibatalkan">Pesanan Dibatalkan</option>
                                                        <option value="Pesanan Terkirim">Pesanan Terkirim</option>
                                                    @endif
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group col-xs-7" style="padding:0.2% 0">
                                                <div class="col-xs-4" style="padding:0.5% 0">Start Date: </div>
                                                <div class="col-xs-8" style="padding:0">
                                                    <input type="text" class="form-control" name="search_startdate" value="{{ isset($search_flag) ? $search_startdate : '' }}">
                                                </div>
                                            </div>
                                            <div class="form-group col-xs-7" style="padding:0.2% 0">
                                                <div class="col-xs-4" style="padding:0.5% 0">End Date: </div>
                                                <div class="col-xs-8" style="padding:0">
                                                    <input type="text" class="form-control" name="search_enddate" value="{{ isset($search_flag) ? $search_enddate : '' }}">
                                                </div>
                                            </div>
                                            <div class="form-group col-xs-7" style="padding:0.2% 0">
                                                <input type="submit" class="btn btn-primary pull-right" value="Search">
                                                @if(isset($search_flag))
                                                <a href="{{ url('order-manager') }}" class="btn btn-warning pull-right" style="margin-right:10px">Clear Search</a>
                                                @endif
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <table class="table table-bordered" id="addon-list-table">
                                    <tr>
                                        <th class="text-center col-xs-1">
                                            <input type="checkbox" class="checkall">
                                        </th>
                                        <th class="text-center col-xs-1">ID</th>
                                        <th class="text-center col-xs-1">Order Number</th>
                                        <th class="text-center col-xs-2">User Name</th>
                                        <th class="text-center col-xs-3">Destination Address</th>
                                        <th class="text-center col-xs-2">Status</th>
                                        <th class="text-center col-xs-1">Created At</th>
                                        <th class="text-center col-xs-1">Action</th>
                                    </tr>
                                    @if(sizeof($order) > 0)
                                    @foreach($order as $d)
                                    <tr>
                                        <td class="text-center" style="vertical-align:middle">
                                            <input type="checkbox" class="checkthis" name="checkthis" data-id="{{ $d['id'] }}">
                                        </td>
                                        <td class="text-center" style="vertical-align:middle">{{ $d['id'] }}</td>
                                        <td class="text-center" style="vertical-align:middle">{{ $d['order_number'] }}</td>
                                        <td class="text-center" style="vertical-align:middle">{{ $d['user_name'] }}</td>
                                        <td class="text-center" style="vertical-align:middle">{{ $d['receiver_address'] }}</td>
                                        <td class="text-center status" style="vertical-align:middle">{{ $d['status'] }}</td>
                                        <td class="text-center" style="vertical-align:middle">{{ Carbon::parse($d['created_at'])->format('d-m-Y H:i:s') }}</td>
                                        <td class="text-center" style="vertical-align:middle">
                                            <a href="{{ url('order-manager/detail/'.$d['id']) }}" title="detail" data-toggle="collapse" data-target="#" data-id="{{ $d['id'] }}" data-type="detail">
                                                <span class="fa fa-list-alt"></span>
                                            </a>
                                            <a href="#" title="payment detail" data-toggle="modal" data-target="#myModalPaymentDetail" data-id="{{ $d['id'] }}" data-type="change status">
                                                <span class="fa fa-credit-card"></span>
                                            </a>
                                            <a href="#" title="ubah" data-toggle="modal" data-target="#myModalChangeStatus" data-id="{{ $d['id'] }}" data-type="change status">
                                                <span class="fa fa-pencil"></span>
                                            </a>
                                            <a href="#" title="hapus" class="delete-btn" data-id="{{ $d['id'] }}" data-toggle="modal" data-target="#myModalDelOrderConfirmation" data-type="single">
                                                <span class="fa fa-trash"></span>
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                    @else
                                    <tr>
                                        <td colspan="10" class="text-center">NO DATA</td>
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

    <script type="text/javascript" src="{{ asset('public/assets/js/order.js') }}"></script>
@endsection