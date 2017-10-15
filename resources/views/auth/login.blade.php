@extends('layouts.depotile', ['title' => 'Login'])

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
                        <h2 class="category1">MASUK</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="authContent">
        <div class="container">
            <div class="row">
                <div class="col-xs-12">
                    <div class="row">
                        <div class="col-sm-6">
                            <img src="{{ asset('public/img/home/home1.jpg') }}" class="imgFull authBorder" />
                        </div>
                        <div class="col-sm-6">
                            <div class="subWrapAuthContent">
                                <form class="form-horizontal custom-form" method="POST" action="{{ url('doLogin') }}">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    <input type="hidden" name="type" value="{{ isset($_GET['type']) ? $_GET['type'] : '' }}">
                                    <input type="hidden" name="product" value="{{ isset($_GET['product']) ? $_GET['product'] : '' }}">
                                    <div class="form-group">
                                        <label class="col-sm-2 col-md-2 control-label">Email</label>
                                        <div class="col-sm-10 col-md-10">
                                            <input type="email" name="email" class="form-control" placeholder="Email Anda.." required>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 col-md-2 control-label">Password</label>
                                        <div class="col-sm-10 col-md-10">
                                            <input type="password" name="password" class="form-control" placeholder="Password Anda.." required>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-sm-push-2 col-sm-10 col-md-10">
                                            <a href="{{ url('reset-password') }}">Lupa password?</a>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-sm-push-2 col-sm-10 col-md-10">
                                            <button type="submit" class="btn authBtn">masuk</button>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-sm-push-2 col-sm-10 col-md-10">
                                            <a href="{{ url('/facebook') }}"><button type="button" class="btn authBtn facebook">masuk dengan facebook</button></a>
                                        </div>
                                    </div>
                                    <div class="error-msg text-center">
                                        <span style="color:red">{{ ($errors->any()) ? $errors->first('password') : '' }}</span>
                                    </div>
                                    <div class="text-center col-sm-offset-2 col-sm-10 col-md-offset-2 col-md-10">
                                        <span class="notification" style="color:green">{{ Session::get('reset-msg') }}</span>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-sm-push-2 col-sm-10 col-md-10">
                                            <h2>Belum bergabung? <a href="{{ url('register') }}">DAFTAR SEKARANG</a></h2>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop