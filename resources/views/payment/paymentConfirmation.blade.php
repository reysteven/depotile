@extends('layouts.depotile', ['title' => 'Konfirmasi Pembayaran'])

@section('css')
@stop

@section('js')

@stop

@section('content')
    <div class="titleGlobalWrap">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <div class="titleSubGlobalWrap">
                        <h2 class="category1">Konfirmasi Pembayaran</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="paymentContent">
        <div class="container">
            <div class="row">
                <div class="col-xs-12">
                    <div class="subWrapPaymentContent">
                        <form class="form-horizontal custom-form" id="paymentConfirmationForm" method="POST" action="{{ url('doConfirm') }}">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <div class="form-group">
                                <label class="col-sm-4 col-md-4 control-label">Order ID</label>
                                <?php 
                                    $noOrder = true; 
                                    foreach($order as $d) {
                                        $noOrder = false;
                                    }
                                ?>
                                <div class="col-sm-8 col-md-8">
                                    <select name="no_order" class="form-control" {{ ($noOrder) ? 'disabled' : '' }}>
                                        @if($noOrder == false)
                                        @foreach($order as $d)
                                        <option value="{{ $d->order_number }}">{{ $d->order_number }}</option>
                                        @endforeach
                                        @else
                                        <option>TIDAK ADA PESANAN</option>
                                        @endif
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 col-md-4 control-label">Bank</label>
                                <div class="col-sm-8 col-md-8">
                                    <select class="form-control" name="bank" {{ ($noOrder) ? 'disabled' : '' }}>
                                        <option value="BCA">BCA</option>
                                        <option value="Mandiri">Mandiri</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 col-md-4 control-label">Nama Akun</label>
                                <div class="col-sm-8 col-md-8">
                                    <input type="text" class="form-control" name="account_name" placeholder="Nama akun rekening anda" {{ ($noOrder) ? 'disabled' : '' }}>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 col-md-4 control-label">Jumlah</label>
                                <div class="col-sm-8 col-md-8">
                                    <input type="tel" class="form-control" name="amount" placeholder="Jumlah yang anda kirim" {{ ($noOrder) ? 'disabled' : '' }}>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 col-md-4 control-label">Tanggal Pembayaran</label>
                                <div class="col-sm-8 col-md-8">
                                    <input type="tel" class="form-control" name="date" placeholder="Tanggal melakukan pembayaran (dd/mm/yyyy)" {{ ($noOrder) ? 'disabled' : '' }} readonly="true">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 col-md-4 control-label">Notes</label>
                                <div class="col-sm-8 col-md-8">
                                    <textarea class="form-control" name="note" cols="30" rows="3" {{ ($noOrder) ? 'disabled' : '' }}></textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-offset-2 col-sm-8 col-md-8">
                                    <button type="submit" class="btn paymentBtn marTop {{ ($noOrder) ? 'hidden' : '' }}">konfirmasi</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop