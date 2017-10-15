@extends('cart.layouts', ['title' => 'Troli Belanja'])

@section('css')
@stop

@section('js')
@stop

@section('content')
    <input type="hidden" id="addressToSessionLink" value="{{ url('doAddAddressToSession') }}">
    <input type="hidden" id="toSummaryLink" value="{{ url('cart/summary') }}">
    <input type="hidden" id="getFeeDataLink" value="{{ url('doGetFeeData') }}">
    <input type="hidden" id="addAddressLink" value="{{ url('doAddAddressInCart') }}">
    <div id="html-error-msg"></div>
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
                                <li class="active"><a href="#">Alamat Pengiriman</a>
                                    <div class="cartArrow">
                                        <div class="cartInnerArrow"></div>
                                    </div>
                                </li>
                                <li><a href="#">Ringkasan Pesanan</a>
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
                                <div class="rowFull"><h4>Alamat Pengiriman</h4></div>
                                <div class="clearBoth"></div>
                            </div>
                            <div class="shippingContent">
                                <div class="row">
                                    <div class="col-sm-4">
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" name="non-shipping-check" id="nonShippingCheck" {{ (sizeof($address) == 0) ? 'checked' : '' }}>
                                               Pengambilan ditempat
                                            </label>
                                        </div>
                                        <div class="nonShipping collapse" id="nonShipping">
                                            <p><b>Alamat Kami</b></p>
                                            <p>Jln. Boulevard Raya Blok RA1 No. 1B<br>
                                            Kelapa Gading, Jakarta Utara 14240</p>
                                        </div>
                                        <div class="collapse" id="mainShipping">
                                            <div class="mainShipping" style="overflow-y:scroll; overflow-x:hidden; max-height:168px">
                                                <h3>Alamat Utama</h3>
                                                @php
                                                    $alt_address = false;
                                                @endphp
                                                @if(sizeof($address) > 0)
                                                @foreach($address as $d)
                                                @if($d->type == 'primary')
                                                <div class="shippingRow withRadio">
                                                    <input type="radio" name="address" id="main-address" data-id="{{ $d->id }}" checked>
                                                    <label for="main-address">
                                                        <h4>{{ $d->name }}</h4>
                                                        <p>{{ $d->address }}</p>
                                                        <p>{{ $d->city_name }}, {{ $d->province_name }}</p>
                                                        @if($d->telp2 == null || $d->telp2 == '')
                                                        <p>Telp: {{ $d->telp1 }}</p>
                                                        @else
                                                        <p>Telp 1: {{ $d->telp1 }}</p>
                                                        <p>Telp 2: {{ $d->telp2 }}</p>
                                                        @endif
                                                    </label>
                                                </div>
                                                @else
                                                    @php
                                                    $alt_address = true;
                                                    @endphp
                                                @endif
                                                @endforeach
                                                @if($alt_address == true)
                                                <h3>Alamat Alternatif</h3>
                                                @endif
                                                @foreach($address as $d)
                                                @if($d->type != 'primary')
                                                <div class="shippingRow withRadio">
                                                    <input type="radio" class="alt-address" name="address" data-id="{{ $d->id }}">
                                                    <label for="alt-address1">
                                                        <h4>{{ $d->name }}</h4>
                                                        <p>{{ $d->address }}</p>
                                                        <p>{{ $d->city_name }}, {{ $d->province_name }}</p>
                                                        @if($d->telp2 == null || $d->telp2 == '')
                                                        <p>Telp: {{ $d->telp1 }}</p>
                                                        @else
                                                        <p>Telp 1: {{ $d->telp1 }}</p>
                                                        <p>Telp 2: {{ $d->telp2 }}</p>
                                                        @endif
                                                    </label>
                                                </div>
                                                @endif
                                                @endforeach
                                                @else
                                                <h4 id="no-address">ANDA BELUM MEMASUKKAN ALAMAT</h4>
                                                @endif
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <a data-toggle="modal" data-target="#addAddress" style="cursor: pointer;" data-type="cart">+ Tambah Alamat</a>
                                                </div>
                                                <div class="col-lg-6"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <form>
                                            <div class="shippingForm">
                                                <div class="form-group">
                                                    <label>Nama Penerima</label>
                                                    <input type="text" class="form-control" name="receiver-name" placeholder="">
                                                </div>
                                                <div class="form-group">
                                                    <label>No. Handphone penerima</label>
                                                    <input type="text" class="form-control" name="receiver-phone1" placeholder="">
                                                </div>
                                                <div class="form-group">
                                                    <label>No. Handphone lainnya</label>
                                                    <input type="text" class="form-control" name="receiver-phone2" placeholder="">
                                                </div>

                                            </div>
                                        </form>
                                        <div class="row">
                                            <div class="col-lg-7">
                                                <p class="notes">Note: Isi form diatas jika penerima berbeda / orang lain</p>
                                            </div>
                                            <div class="col-lg-5"></div>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <form>
                                            <p class="notes">Catatan Pengiriman</p>
                                            <div class="shippingForm">
                                                <div class="form-group">
                                                    <textarea class="form-control" id="" cols="30" rows="10" name="delivery-note"></textarea>
                                                </div>
                                            </div>
                                        </form>
                                        <div id="fee-data">
                                            <p>Biaya pengiriman: Rp. <span>{{ number_format($fee,0,'.','.') }}</span></p>
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
                    <form method="POST" action="{{ url('cart/summary') }}" id="toSummaryForm">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <a href="#" style="color:white" id="to-summary-link">
                        <button type="button" class="cartNextButton">
                            LANJUTKAN >
                        </button>
                    </a>
                    </form>
                </div>
            </div>
            <div class="cartDivider"></div>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal custom-modal fade" id="addAddress" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Tambah Alamat Baru</h4>
                </div>
                <div class="loading-div text-center hidden" style="margin-top:1%">
                    <span class="fa fa-spin fa-spinner fa-2x"></span>
                </div>
                <div class="content">
                @include('modal.modalAddAddress')
                </div>
            </div>
        </div>
    </div>
@stop