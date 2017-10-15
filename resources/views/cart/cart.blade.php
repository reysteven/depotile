@extends('cart.layouts', ['title' => 'Troli Belanja'])

@section('css')
@stop

@section('js')
@stop

@section('content')
<form id="delCartForm" method="POST" action="{{ url('doDeleteCart') }}">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <input type="hidden" name="type">
    <input type="hidden" name="id">
</form>
<div class="cartContent">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="cartBox">
                    <div class="cartBoxHead hidden-xs">
                        <ul class="list-unstyled list-unstyled">
                            <li class="active"><a href="#">Troli Belanja</a>
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

                            </li>
                            <li><a href="#">Selesai</a></li>
                            <div class="clearBoth"></div>
                        </ul>
                    </div>
                    <div class="cartBoxContent">
                        <div class="cartRow rowTitle text-left">
                            <div class="row1"><h4>Produk</h4></div>
                            <div class="row2"><h4>Jumlah</h4></div>
                            <div class="row3"><h4>Harga</h4></div>
                            <div class="row4"><h4>Total</h4></div>
                            <div class="clearBoth"></div>
                        </div>
                        @if(sizeof(json_decode(Session::get('cart'))) > 0)
                        @foreach(json_decode(Session::get('cart')) as $d)
                        <div class="cartRow">
                            <div class="row1">
                                <div class="rowItem">
                                    <div class="itemLeft">
                                        @if($d->type == 'tile')
                                        <img src="{{ asset('admin/public/assets/image/item-image/medium/'.$d->image) }}" class="imgFull" />
                                        @else
                                        <img src="{{ asset('admin/public/assets/image/item-image/add-on/medium/'.$d->image) }}" class="imgFull" />
                                        @endif
                                    </div>
                                    <div class="itemRight">
                                        <h1>{{ $d->name }}</h1>
                                        <p>{{ $d->item_code }}</p>
                                        <p style="color:white">Size 3 x 3 inch</p>
                                        <p style="color:white">Size 3 x 3 inch</p>
                                        <a href="#" class="delCartLink" data-type="{{ $d->type }}" data-id="{{ $d->id }}">Hapus</a>
                                    </div>
                                    <div class="clearBoth"></div>
                                </div>
                            </div>
                            <div class="row2">
                                <div class="qtyBox">
                                    <div class="form-group">
                                        <label for="box">Box</label>
                                        <input value="{{ $d->qty }}" maxlength="2" type="text" class="form-control" id="box" placeholder="0">
                                    </div>
                                </div>
                            </div>
                            <div class="row3">
                                <p class="itemPrice">Rp {{ number_format($d->price,0,'.','.') }}</p>
                            </div>
                            <div class="row4">
                                <p class="itemPrice">Rp {{ number_format(($d->qty * $d->price),0,'.','.') }}</p>
                            </div>
                            @if($d->type == 'tile')
                            @php
                                $addon = json_decode($d->add_on);
                            @endphp
                            @if($addon->status == 1)
                                @if($d->addonexist == 'false')
                            <a class="addOnCart" data-toggle="modal" data-target="#addOn" data-id="{{ $d->id }}" data-item="{{ $d->id }}">
                                <div class="addOnCartIcon">
                                    <img src="{{ asset('admin/public/assets/image/item-image/add-on/small/'.$addon->image) }}" class="imgFull" />
                                </div>
                                <p>{{ $addon->cta }}<br/>
                                    <span>Cek model lain</span>
                                </p>
                            </a>
                                @endif
                            @endif
                            @else
                                @if($d->tileexist == 'true')
                            <div class="addOnCart" data-toggle="modal" data-target="#addOn" data-id="{{ $d->id }}" data-item="{{ $d->id }}">
                                <h4>ADD ON UNTUK {{ substr($d->tile,0,-2) }}</h4>
                            </div>
                            <!-- <div style="margin-top:2%"></div> -->
                                @endif
                            @endif
                            <div class="clearBoth"></div>
                        </div>
                        @endforeach
                        @else
                        <div class="text-center col-xs-12">
                            <b>TIDAK ADA DATA</b>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-6 col-xs-12">
                <!-- <div class="recommendCart">
                    <img src="{{ asset('public/img/product/product1.jpg') }}" />
                    <p class="infoTitle">Tambahkan Lem keramik?</p>
                    <p class="infoName">Semen Putih Standard</p>
                    <p class="infoPrice">Rp 150.000/sak</p>
                    <div class="clearBoth"></div>
                    <div class="flyingButton">
                        <i class="fa fa-check" aria-hidden="true"></i>
                    </div>
                </div> -->
                <div class="promoWrap">
                    <label for="box">Promo</label>
                    <input type="text" class="form-control" id="box" placeholder="Masukan Kode Voucher">
                </div>
            </div>
            <div class="col-sm-6  col-xs-12">
                <!-- <div class="promoWrap">
                    <label for="box">Promo</label>
                    <input type="text" class="form-control" id="box" placeholder="Masukan Kode Voucher">
                </div> -->
                <form method="POST" action="{{ url('cart/shipping') }}">
                <a href="#" style="color:white">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <button type="submit" class="cartNextButton">
                        LANJUTKAN >
                    </button>
                </a>
                </form>
            </div>
        </div>
        <div class="cartDivider hidden-xs"></div>
    </div>
</div>
<!-- Modal -->
<div class="modal custom-modal fade" id="addOn" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">REKOMENDASI GROUT/LEM KERAMIK</h4>
            </div>
            @include('modal.addOn')
        </div>
    </div>
</div>
@stop