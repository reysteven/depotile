@extends('layouts.depotile', ['title' => 'Profil'])

@section('css')
@stop

@section('js')
    <script type="text/javascript">
        $(document).ready(function() {
            $('.date').datepicker({
                changeMonth: true,
                changeYear: true,
                constrainInput: true,
                dateFormat: 'dd MM yy'
            });
        });
    </script>
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
                        <h3>Ubah Profil</h3>
                        <form class="form-horizontal custom-form" id="profileForm" method="POST" action="{{ url('doChangeProfile') }}">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <div class="form-group">
                                <label class="col-sm-4 col-md-2 control-label">Title</label>
                                <div class="col-sm-8 col-md-10">
                                    <select name="title" class="form-control">
                                        <option class="hidden">Mr./Mrs.</option>
                                        <option value="Mr." {{ ($user->title == 'Mr.') ? 'selected' : '' }}>Mr.</option>
                                        <option value="Mrs." {{ ($user->title == 'Mrs.') ? 'selected' : '' }}>Mrs.</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 col-md-2 control-label">Nama</label>
                                <div class="col-sm-8 col-md-10">
                                    <input type="text" class="form-control" name="name" placeholder="Nama profil anda.." value="{{ $user->name }}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 col-md-2 control-label">Email</label>
                                <div class="col-sm-8 col-md-10">
                                    <input type="text" class="form-control" name="email" placeholder="Alamat email anda.." value="{{ $user->email }}" readonly="true">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 col-md-2 control-label">No. Handphone 1</label>
                                <div class="col-sm-8 col-md-10">
                                    <input type="text" class="form-control" name="handphone1" placeholder="Nomor Aktif (wajib), cth: 08121xxx" value="{{ $user->handphone1 }}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 col-md-2 control-label">No. Handphone 2</label>
                                <div class="col-sm-8 col-md-10">
                                    <input type="text" class="form-control" name="handphone2" placeholder="Nomor Aktif (opsi), cth: 08121xxx" value="{{ ($user->handphone2 == 'null') ? '' : $user->handphone2 }}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 col-md-2 control-label">Nama Perusahaan</label>
                                <div class="col-sm-8 col-md-10">
                                    <input type="text" class="form-control" name="company" placeholder="Nama Perusahaan Anda.." value="{{ $user->company }}">
                                </div>
                            </div>
                            <div class="form-group text-center">
                                <span class="notification" style="color:green">{{ Session::get('msg') }}</span>
                            </div>
                            <div class="form-group text-center">
                                <span class="error-msg" style="color:red"></span>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-offset-2 col-sm-8 col-md-10">
                                    <button type="submit" class="btn profileBtn">ubah profil</button>
                                </div>
                            </div>
                        </form>
                        <h3>Ubah Password</h3>
                        <form class="form-horizontal custom-form" id="passwordForm" method="POST" action="{{ url('doChangePassword') }}">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <div class="form-group">
                                <label class="col-sm-4 col-md-2 control-label">Password Lama</label>
                                <div class="col-sm-8 col-md-10">
                                    <input type="password" class="form-control" name="oldPassword" placeholder="Password Lama Anda..">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 col-md-2 control-label">Password Baru</label>
                                <div class="col-sm-8 col-md-10">
                                    <input type="password" class="form-control" name="newPassword" placeholder="Password Baru Anda..">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 col-md-2 control-label">Konfirmasi<br/>Password Baru</label>
                                <div class="col-sm-8 col-md-10">
                                    <input type="password" class="form-control" name="confirmPassword" placeholder="Konfirmasi Password Baru Anda..">
                                </div>
                            </div>
                            <div class="form-group text-center">
                                <span class="notification" style="color:green">{{ Session::get('pass-msg') }}</span>
                            </div>
                            <div class="form-group text-center">
                                <span class="error-msg" style="color:red">
                                @if($errors->any())
                                    {{ $errors->first() }}
                                @endif
                                </span>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-offset-2 col-sm-8 col-md-10">
                                    <button type="submit" class="btn profileBtn">ubah password</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop