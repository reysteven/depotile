@extends('cart.layouts', ['title' => 'Troli Belanja'])

@section('css')
@stop

@section('js')
@stop

@section('content')
    <div class="cartContent">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="cartBox">
                        <div class="cartBoxHead hidden-xs">
                            <ul class="list-unstyled list-unstyled">
                                <li><a href="#">Troli Belanja</a>
                                    <div class="cartArrow">
                                        <div class="cartInnerArrow"></div>
                                    </div>
                                </li>
                                <li><a href="#">Alamat Pengiriman</a>
                                    <div class="cartArrow">
                                        <div class="cartInnerArrow"></div>
                                    </div>
                                </li>
                                <li class="active"><a href="#">Ringkasan Pesanan</a>
                                    <div class="cartArrow">
                                        <div class="cartInnerArrow"></div>
                                    </div>
                                </li>
                                <li><a href="#">Selesai</a></li>
                                <div class="clearBoth"></div>
                            </ul>
                        </div>
                        <div class="cartBoxContent lessBottoms">
                            <div class="cartRow rowTitle text-left">
                                <div class="rowFull"><h4>Ringkasan Pesanan</h4></div>
                                <div class="clearBoth"></div>
                            </div>
                            <div class="shippingContent">
                                <div class="row">
                                   <div class="col-sm-4">
                                        @foreach(json_decode(Session::get('cart')) as $d)
                                        <div class="summaryRow">
                                           <div class="summaryLeft">
                                                @if($d->type == 'tile')
                                                <img src="{{ asset('admin/public/assets/image/item-image/small/'.$d->image) }}" class="imgFull" />
                                                @else
                                                <img src="{{ asset('admin/public/assets/image/item-image/add-on/small/'.$d->image) }}" class="imgFull" />
                                                @endif
                                           </div>
                                           <div class="summaryRight">
                                               <h1>{{ $d->name }}</h1>
                                               <!-- <p>Polish, Size 3 x 3 inch</p> -->
                                               <p>Jumlah {{ $d->qty }} Box</p>
                                               <p class="summaryPrice">Rp. {{ number_format($d->qty * $d->price,0,'.','.') }}</p>
                                           </div>
                                        </div>
                                        @endforeach
                                   </div>
                                    <div class="col-sm-4">
                                        <div class="mainShipping">
                                            <h3>Alamat Tujuan</h3>
                                            <div class="shippingRow">
                                                @if(json_decode(Session::get('delivery-address'),true)['non-shipping'] == "false")
                                                @php
                                                    $address = json_decode(Session::get('delivery-address'));
                                                @endphp
                                                @if($address->receiverName == '' || $address->receiverName == null)
                                                <h4>{{ $delivery_address->name }}</h4>
                                                @else
                                                <h4>{{ $address->receiverName }}</h4>
                                                @endif
                                                <p>{{ $delivery_address->address }}</p>
                                                <p>{{ $delivery_address->city_name }}, {{ $delivery_address->province_name }}</p>
                                                <p>Telp: 0899898989</p>
                                                @else
                                                {!! $delivery_address !!}
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="mainShipping">
                                            <h3>Total Pembayaran</h3>
                                            <div class="shippingRow">
                                                <div class="row">
                                                    <div class="col-xs-6">
                                                        <h5>Total Belanja</h5>
                                                    </div>
                                                    @php
                                                        $cart = json_decode(Session::get('cart'));
                                                        $subtotal = 0;
                                                        $fee = 0;
                                                        foreach($cart as $d) {
                                                            $subtotal += $d->qty * $d->price;
                                                            $fee += $d->fee;
                                                        }
                                                    @endphp
                                                    <div class="col-xs-6 text-left">
                                                        <p>Rp {{ number_format($subtotal,0,'.','.') }}</p>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-xs-6">
                                                        <h5>Biaya Pengiriman</h5>
                                                    </div>
                                                    <div class="col-xs-6 text-left">
                                                        @if($fee == 0)
                                                        <p>Gratis</p>
                                                        @else
                                                        <p>Rp {{ number_format($fee,0,'.','.') }}</p>
                                                        @endif
                                                    </div>
                                                </div>
                                                <!-- <div class="row">
                                                    <div class="col-xs-6">
                                                        <h5>Handling fee</h5>
                                                    </div>
                                                    <div class="col-xs-6 text-left">
                                                        <p>Gratis</p>
                                                    </div>
                                                </div> -->
                                                <div class="subMainTotal">
                                                    <div class="row">
                                                        <div class="col-xs-6">
                                                            <h4>Total Pembayaran</h4>
                                                        </div>
                                                        <div class="col-xs-6 text-left">
                                                            <p class="totalPrice">Rp {{ number_format($subtotal+$fee,0,'.','.') }}</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <form method="POST" action="{{ url('cart/finish') }}">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <a href="#" style="color:white">
                        <button type="submit" class="cartNextButton">
                            SELESAI >
                        </button>
                    </a>
                    </form>
                </div>
            </div>
            <div class="cartDivider"></div>
        </div>
    </div>
@stop