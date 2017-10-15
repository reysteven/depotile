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
                        <h3>Order {{ $header->order_number }}</h3>
                        <div class="orderDetailContent">
                            <div class="orderDetailTop">
                                <div class="row">
                                    <div class="col-sm-6 col-xs-12">
                                        @foreach($detail as $d)
                                        <div class="summaryRow">
                                            <div class="summaryLeft">
                                                @if($d->type == 'tile')
                                                <img src="{{ asset('admin/public/assets/image/item-image/small/'.$d->img_name1) }}" class="imgFull" />
                                                @else
                                                <img src="{{ asset('admin/public/assets/image/item-image/add-on/small/'.$d->img_name1) }}" class="imgFull" />
                                                @endif
                                            </div>
                                            <div class="summaryRight">
                                                <h1>{{ $d->item_name }}</h1>
                                                <p>Jumlah {{ $d->total_item }} Box</p>
                                                <p class="summaryPrice">Rp. {{ number_format(($d->price_per_box * $d->total_item),0,'.','.') }}</p>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                    <div class="col-sm-6 col-xs-12 borLeft">
                                        <div class="mainShipping">
                                            <h3>Alamat Utama</h3>
                                            <div class="shippingRow">
                                                <h4>{{ $header->receiver_name }}</h4>
                                                <p>{{ $header->address }}</p>
                                                <p>{{ $header->city }}, {{ $header->province }}</p>
                                                @if($header->receiver_telp2 == 'null')
                                                <p>Telp: {{ $header->receiver_telp1 }}</p>
                                                @else
                                                <p>Telp1: {{ $header->receiver_telp1 }}</p>
                                                <p>Telp2: {{ $header->receiver_telp2 }}</p>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="mainShipping noBor">
                                            <h3>Total Pembayaran</h3>
                                            <div class="shippingRow">
                                                <div class="row">
                                                    <div class="col-xs-6">
                                                        <h5>Total Belanja</h5>
                                                    </div>
                                                    <div class="col-xs-6 text-left">
                                                        <p>Rp {{ number_format($header->total,0,'.','.') }}</p>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-xs-6">
                                                        <h5>Biaya Pengiriman</h5>
                                                    </div>
                                                    <div class="col-xs-6 text-left">
                                                        @if($header->fee == 0)
                                                        <p>Gratis</p>
                                                        @else
                                                        <p>Rp. {{ number_format($header->fee,0,'.','.') }}</p>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="orderDetailBottom">
                                <div class="subMainTotal">
                                    <div class="row">
                                        <div class="col-xs-6">
                                            <h4>Total Pembayaran</h4>
                                        </div>
                                        <div class="col-xs-6 text-right">
                                            <p class="totalPrice">Rp {{ number_format($header->subtotal,0,'.','.') }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <a class="profileBtn marTop back"  href="{{ url('profile/order') }}" >< kembali</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop