<form class="form-horizontal custom-form noMar" id="addressForm" name="addressForm" method="POST" action="{{ url('doAddAddress') }}">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <input type="hidden" name="id">
    <input type="hidden" name="type">
    <div class="modal-body">
        <div class="form-group">
            <label class="col-sm-4 col-md-4 control-label">Nama</label>
            <div class="col-sm-8 col-md-8">
                <input type="text" class="form-control" placeholder="Nama penerima.." name="name">
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-4 col-md-4 control-label">Provinsi</label>
            <div class="col-sm-8 col-md-8">
                <select class="form-control" name="province" id="provinceAddProfile">
                    <option value="0">Pilih provinsi</option>
                    @foreach($province as $p_name => $p_data)
                    <option value="{{ $p_data['id'] }}">{{ $p_name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-4 col-md-4 control-label">Kota</label>
            <div class="col-sm-8 col-md-8">
                <select class="form-control cityAddProfile" data-id="0" disabled>
                    <option value="0">Pilih provinsi dahulu</option>
                </select>
                @foreach($province as $p_name => $p_data)
                <select class="cityAddProfile form-control hidden" data-id="{{ $p_data['id'] }}">
                    @foreach($p_data['city'] as $c_name => $c_data)
                    <option value="{{ $c_data['id'] }}">{{ $c_name }}</option>
                    @endforeach
                </select>
                @endforeach
                <input type="hidden" name="city">
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-4 col-md-4 control-label">Alamat</label>
            <div class="col-sm-8 col-md-8">
                <textarea class="form-control" placeholder="Alamat anda.." cols="30" rows="3" name="address"></textarea>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-4 col-md-4 control-label">No. Handphone 1</label>
            <div class="col-sm-8 col-md-8">
                <input type="text" class="form-control" placeholder="Nomor aktif (wajib), cth: 08121xxx" name="handphone1">
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-4 col-md-4 control-label">No. Handphone 2</label>
            <div class="col-sm-8 col-md-8">
                <input type="text" class="form-control" placeholder="Nomor aktif (opsi), cth: 08121xxx" name="handphone2">
            </div>
        </div>
    </div>
    <div class="form-group text-center">
        <span class="error-msg" style="color:red"></span>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
        <button type="submit" class="btn btn-primary">Kirim</button>
    </div>
</form>
