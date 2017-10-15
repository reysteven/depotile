@extends('layouts.depotile', ['title' => 'Profil Alamat'])

@section('css')
@stop

@section('js')

@stop

@section('content')
    <input type="hidden" id="get-address-data-link" value="{{ url('doGetAddressData') }}">
    <input type="hidden" id="addAddressLink" value="{{ url('doAddAddress') }}">
    <input type="hidden" id="editAddressLink" value="{{ url('doEditAddress') }}">
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
                        @if(sizeof($address) == 0)
                        <div class="text-center" style="margin-bottom:4%">
                            <h4>Anda Belum Memiliki Alamat</h4>
                        </div>
                        @else
                        <h3>Daftar Alamat</h3>
                        <div style="margin-top:10px">
                            <b>ALAMAT UTAMA</b>
                        </div>
                        @php
                            $alt = false;
                        @endphp
                        @foreach($address as $d)
                        @if($d->type == 'primary')
                        <div class="addressRow">
                            <p>{{ $d->name }}</p>
                            <p>{{ $d->address }}, {{ $d->city_name }}, {{ $d->province_name }}</p>
                            <p>No. Handphone: {{ $d->telp1 }} {{ ($d->telp2 == 'null') ? '' : ', '.$d->telp2 }}</p>
                            <a type="button" data-toggle="modal" data-target="#changeAddress" data-type="edit" data-id="{{ $d->addressId }}">Ubah alamat?</a>
                        </div>
                        @else
                        @php
                            $alt = true;
                        @endphp
                        @endif
                        @endforeach
                        @if($alt == true)
                        <div style="margin-top:10px">
                            <b>ALAMAT ALTERNATIF</b>
                        </div>
                        @foreach($address as $d)
                        @if($d->type != 'primary')
                        <div class="addressRow">
                            <p>{{ $d->name }}</p>
                            <p>{{ $d->address }}, {{ $d->city_name }}, {{ $d->province_name }}</p>
                            <p>No. Handphone: {{ $d->telp1 }} {{ ($d->telp2 == 'null') ? '' : ', '.$d->telp2 }}</p>
                            <a type="button" data-toggle="modal" data-target="#myModalDelAddressConfirmation" data-type="delete" data-id="{{ $d->addressId }}" style="color:red">Hapus Alamat?</a>
                            <a type="button" class="edit-alt" data-toggle="modal" data-target="#changeAddress" data-type="edit" data-id="{{ $d->addressId }}">Ubah alamat?</a>
                        </div>
                        @endif
                        @endforeach
                        @endif
                        @endif
                        <div class="form-group text-center">
                            <span class="notification" style="color:green">{{ Session::get('msg') }}</span>
                        </div>
                        <button class="profileBtn marTop" type="button" data-toggle="modal" data-type="add" data-target="#addAddress">+ Tambah Alamat Baru</button>
                    </div>
                </div>
            </div>
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
                @include('modal.modalAddAddress')
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal custom-modal fade" id="changeAddress" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Ubah Alamat</h4>
                </div>
                <div class="loading-div text-center hidden" style="margin-top:1%">
                    <span class="fa fa-spin fa-spinner fa-2x"></span>
                </div>
                <div class="content hidden">
                @include('modal.modalAddAddress')
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal custom-modal fade" id="myModalDelAddressConfirmation" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document" style="margin-top:16%">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Hapus Alamat</h4>
                </div>
                <form method="POST" action="{{ url('doDeleteAddress') }}" id="delAddressForm">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="hidden" name="id">
                    <div class="text-center" style="padding-bottom: 1%">
                        <h4>Anda yakin ingin menghapus alamat ini?</h4>
                        <input type="submit" class="btn btn-primary" value="Ya">
                        <input type="button" class="btn btn-default" data-dismiss="modal" value="Tidak">
                    </div>
                </form>
            </div>
        </div>
    </div>
@stop