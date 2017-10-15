@extends('layouts.depotile', ['title' => 'Register'])

@section('css')
@stop

@section('js')

@stop

@section('content')
    <input type="hidden" id="province_data" value="{{ json_encode($province) }}">
    <div class="titleGlobalWrap">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <div class="titleSubGlobalWrap">
                        <h2 class="category1">DAFTAR</h2>
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
                                <form class="form-horizontal custom-form" id="registerForm" method="POST" action="{{ url('doRegister') }}">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    <div class="form-group">
                                        <label class="col-sm-4 col-md-4 control-label">Title</label>
                                        <div class="col-sm-8 col-md-8">
                                            <select name="title" class="form-control">
                                                <option class="hidden">Mr./Mrs.</option>
                                                <option value="Mr." {{ (old('title') == 'Mr.') ? 'selected' : '' }}>Mr.</option>
                                                <option value="Mrs." {{ (old('title') == 'Mrs.') ? 'selected' : '' }}>Mrs.</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-4 col-md-4 control-label">Nama</label>
                                        <div class="col-sm-8 col-md-8">
                                            <input type="text" name="name" class="form-control" placeholder="Nama Anda.." value="{{ old('name') }}">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-4 col-md-4 control-label">Handphone</label>
                                        <div class="col-sm-8 col-md-8">
                                            <input type="text" name="handphone" class="form-control" placeholder="Nomor Aktif Anda.." value="{{ old('handphone') }}">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-4 col-md-4 control-label">Nama Perusahaan <span style="color:red">*</span></label>
                                        <div class="col-sm-8 col-md-8">
                                            <input type="text" name="company" class="form-control" placeholder="Nama Perusahaan Anda.." value="{{ old('company') }}">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-4 col-md-4 control-label">Email</label>
                                        <div class="col-sm-8 col-md-8">
                                            <input type="email" name="email" class="form-control" placeholder="Email Anda.." value="{{ old('email') }}">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-4 col-md-4 control-label">Password</label>
                                        <div class="col-sm-8 col-md-8">
                                            <input type="password" name="password" class="form-control" placeholder="Password Anda..">
                                        </div>
                                    </div>
                                    <div class="form-group" style="margin-bottom:0">
                                        <label class="col-sm-4 col-md-4 control-label">Re-type Password</label>
                                        <div class="col-sm-8 col-md-8">
                                            <input type="password" name="retypepassword" class="form-control" placeholder="Re-type password Anda..">
                                        </div>
                                    </div>
                                    <div class="col-sm-push-4 col-sm-8 col-md-8 text-center" style="margin-bottom:2%">
                                        <span class="errormsg" style="color:red">{{ ($errors->any()) ? $errors->first() : '' }}</span>
                                    </div>
                                    <div class="col-xs-12" style="padding:0">
                                        <span class="pull-right" style="color:red">* tidak wajib diisi</span>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-sm-push-4 col-sm-8 col-md-8">
                                            <button type="submit" class="btn authBtn">daftar</button>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-sm-push-4 col-sm-8 col-md-8">
                                            <h2>Sudah bergabung? <a href="{{ url('login') }}">MASUK DISINI</a></h2>
                                        </div>
                                    </div>
                                    <div class="form-group" style="visibility:hidden">
                                        <div class="col-sm-push-4 col-sm-8 col-md-8">
                                            <button type="button" class="btn authBtn facebook">daftar dengan facebook</button>
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