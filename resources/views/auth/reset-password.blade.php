@extends('layouts.depotile', ['title' => 'Reset Password'])

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
                        <h2 class="category1">RESET PASSWORD</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="authContent">
        <div class="container">
            <div class="row">
                <div class="col-xs-12">
                    <div class="row" style="margin-bottom: 2%">
                        <div class="col-sm-6">
                            <img src="{{ asset('public/img/home/home1.jpg') }}" class="imgFull authBorder" />
                        </div>
                        <div class="col-sm-6">
                            <div class="subWrapAuthContent">
                                <form class="form-horizontal custom-form" method="POST" action="{{ url('doResetPassword') }}">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    <div class="form-group">
                                        <label class="col-sm-2 col-md-2 control-label">Email</label>
                                        <div class="col-sm-10 col-md-10">
                                            <input type="email" name="email" class="form-control" placeholder="Email Anda.." required>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-sm-push-2 col-sm-10 col-md-10">
                                            <button type="submit" class="btn authBtn">reset password</button>
                                        </div>
                                    </div>
                                    <div class="error-msg text-center col-sm-push-2 col-sm-10 col-md-10">
                                        <span style="color:red">{{ ($errors->any()) ? $errors->first() : '' }}</span>
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