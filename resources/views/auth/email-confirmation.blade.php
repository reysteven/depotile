@extends('layouts.depotile', ['title' => 'Register'])

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
                        <h2 class="category1">Konfirmasi Email</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="authContent" style="margin-bottom:1%">
        <div class="container">
            <div class="row">
                <div class="col-xs-12">
                    <div class="row">
                        <div class="col-sm-6">
                            <img src="{{ asset('public/img/home/home1.jpg') }}" class="imgFull authBorder" />
                        </div>
                        <div class="col-sm-6">
                            <div class="subWrapAuthContent">
                                <div class="form-group">
                                    <div class="col-sm-12 col-md-12 text-center">
                                        Kami telah mengirimkan konfirmasi email ke alamat email Anda. Klik "AKTIFKAN AKUN ANDA" untuk mengaktifkan akun Anda.
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