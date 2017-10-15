@extends('cart.layouts', ['title' => 'Troli Belanja'])

@section('css')
@stop

@section('js')
@stop

@section('content')
    <div class="cartContent marBot">
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
                                <li><a href="#">Ringkasan Pesanan</a>
                                    <div class="cartArrow">
                                        <div class="cartInnerArrow"></div>
                                    </div>
                                </li>
                                <li class="active borRight"><a href="#">Selesai</a></li>
                                <div class="clearBoth"></div>
                            </ul>
                        </div>
                        <div class="cartBoxContent lessBottomsTops">
                            <div class="doneSection1">
                                <div class="row">
                                    <div class="col-lg-12 text-center">
                                        <h1>Terima Kasih!</h1>
                                        <p>Kami telah menerima order Anda!<br>Silahkan selesaikan pembayaran anda dalam 24 jam dan jangan lupa memasukkan "Nomor Order ID" didalam berita. </p>
                                    </div>
                                </div>
                            </div>
                            <div class="doneSection2">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="doneBox">
                                            <h3>Nomer Order ID</h3>
                                            <div class="orderID">
                                                <p>{{ $number }}</p>
                                            </div>
                                            <p class="notes">
                                                Lakukan pembayaran dengan transfer ke salah satu rekening dibawah ini, sertakan nomer order ID di berita, konfirmasi pembayaran
                                                <a href="{{ url('confirmation') }}">disini</a> setelah Anda melakukan pembayaran.
                                            </p>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="doneBox">
                                            <div class="mainDoneDetail">
                                                <h3>Rincian Pesanan</h3>
                                                @foreach($order as $d)
                                                <h3 class="upper">{{ $d->item_name }} - {{ $d->total_item }} box</h3>
                                                @endforeach
                                                <div class="rowDoneDetail">
                                                    <div class="row">
                                                        <div class="col-xs-6">
                                                            <h5>Total Belanja</h5>
                                                        </div>
                                                        <div class="col-xs-6 text-left">
                                                            <p>Rp {{ number_format($subtotal,0,'.','.') }}</p>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-xs-6">
                                                            <h5>Biaya Pengiriman</h5>
                                                        </div>
                                                        <div class="col-xs-6 text-left">
                                                            <p>{{ ($fee == 0) ? 'Gratis' : number_format($fee,0,'.','.') }}</p>
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
                                                    <div class="row">
                                                        <div class="col-xs-6">
                                                            <h5>Total Pembayaran</h5>
                                                        </div>
                                                        <div class="col-xs-6 text-left">
                                                            <p>Rp. {{ number_format(($subtotal + $fee),0,'.','.') }}</p>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="doneSection3">
                                <div class="row">
                                    <div class="col-sm-4">
                                        <div class="bankWrap">
                                            <img src="{{ asset('public/img/bank/bca.png') }}" />
                                            <p>BCA: 123987189237</p>
                                            <p>A/N: Billy Lumanauw</p>
                                            <p>Bca Cab.Sunter Mall</p>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="bankWrap">
                                            <img src="{{ asset('public/img/bank/bca.png') }}" />
                                            <p>BCA: 123987189237</p>
                                            <p>A/N: Billy Lumanauw</p>
                                            <p>Bca Cab.Sunter Mall</p>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="bankWrap">
                                            <img src="{{ asset('public/img/bank/bca.png') }}" />
                                            <p>BCA: 123987189237</p>
                                            <p>A/N: Billy Lumanauw</p>
                                            <p>Bca Cab.Sunter Mall</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="cartDivider"></div>
                            <div class="doneSection4">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <p class="notes">Notes:</p>
                                        <ol>
                                            <li>Order segera diperoses setelah pembayaran kami terima.</li>
                                            <li>Anda akan menerima konfirmasi melalui email.</li>
                                            <li>Untuk melacak order, silahkan hubungi customer service kami.</li>
                                        </ol>
                                    </div>
                                    <div class="col-sm-6">
                                            <a href="{{ url('confirmation') }}" class="cartFinish">KONFIRMASI PEMBAYARAN</a>
                                        <br/>
                                        <br/>
                                        <br/>
                                        <a href="">Lanjutkan Berbelanja ></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop