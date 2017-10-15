@extends('layouts.depotile', ['title' => 'Profil Alamat'])

@section('css')
@stop

@section('js')

@stop

@section('content')
    <div class="titleProfileWrap">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <div class="titleSubProfileWrap">
                        <h2 class="category1">Profil Saya</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="profileContent">
        <div class="container">
            <div class="row">
                <div class="col-sm-3">
                    @include('profile.profileMenu')
                </div>
                <div class="col-sm-9 leftBor">
                    <div class="profileMain">
                        <!-- <h3>Daftar Pesanan</h3> -->
                        <ul class="nav nav-pills col-xs-12" style="padding-left:0;padding-right:0">
                            <li class="active col-xs-5" style="padding-left:0;padding-right:0;width:49.8%"><a data-toggle="pill" href="#ongoing">Active Order</a></li>
                            <li class="col-xs-5" style="padding-left:0;padding-right:0;width:49.8%"><a data-toggle="pill" href="#finished">Order History</a></li>
                        </ul>
                        <div class="tab-content">
                            <div id="ongoing" class="tab-pane fade in active">
                            @if(sizeof($ongoing) > 0)
                                @foreach($ongoing as $d)
                                <div class="orderRow">
                                    <div class="orderRowTitle">
                                        <h4>#Order {{ $d->order_number }}</h4>
                                    </div>
                                    <div class="orderRowContent">
                                        <div class="row">
                                            <div class="col-xs-6 col-sm-4 col-md-4 text-left">
                                                <h5>Waktu Order</h5>
                                                <p>{{ $d->order_created_at }}</p>
                                            </div>
                                            <div class="col-xs-6 col-sm-4 col-md-4 text-center">
                                                <h5>Status Order</h5>
                                                <p class="orderState success">{{ $d->status }}</p>
                                            </div>
                                            <div class="col-xs-6 col-sm-4 col-md-4 text-center">
                                                <a href="{{ url('profile/order/detail/'.$d->order_number) }}">Detail Order</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            @else
                                <div class="orderRow">
                                    <div class="orderRowTitle">
                                        <div class="text-center"><h4>TIDAK ADA PESANAN</h4></div>
                                    </div>
                                </div>
                            @endif
                            </div>
                            <div id="finished" class="tab-pane">
                            @if(sizeof($finished) > 0)
                                @foreach($finished as $d)
                                <div class="orderRow">
                                    <div class="orderRowTitle">
                                        <h4>#Order {{ $d->order_number }}</h4>
                                    </div>
                                    <div class="orderRowContent">
                                        <div class="row">
                                            <div class="col-xs-6 col-sm-3 col-md-3 text-left">
                                                <h5>Waktu Order</h5>
                                                <p>{{ $d->order_created_at }}</p>
                                            </div>
                                            <div class="col-xs-6 col-sm-3 col-md-3 text-left">
                                                <h5>Waktu Pengiriman</h5>
                                                <p>{{ $d->order_sent_at }}</p>
                                            </div>
                                            <div class="col-xs-6 col-sm-3 col-md-3 text-center">
                                                <h5>Status Order</h5>
                                                <p class="orderState success">{{ $d->status }}</p>
                                            </div>
                                            <div class="col-xs-6 col-sm-3 col-md-3 text-center">
                                                <a href="{{ url('profile/order/detail/'.$d->order_number) }}">Detail Order</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            @else
                                <div class="orderRow">
                                    <div class="orderRowTitle">
                                        <div class="text-center"><h4>TIDAK ADA PESANAN</h4></div>
                                    </div>
                                </div>
                            @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop