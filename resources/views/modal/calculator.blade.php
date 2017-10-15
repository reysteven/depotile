<form method="POST" class="form-horizontal custom-form noMar" id="calculator-form" action="{{ url('doAddCartByCalc') }}">
    <div class="modal-body">
        <div class="loading-div text-center hidden">
            <span class="fa fa-spinner fa-spin fa-2x"></span>
        </div>
        <div class="content hidden">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <input type="hidden" name="id">
            <input type="hidden" class="data">
            <div class="calc calcSec1">
                <h4>Saya tahu luas area (m2) yang saya butuhkan. Hitung jumlah ubin yang mau dipesan:</h4>
                <div class="row">
                    <div class="col-sm-4">
                        <div class="LeftFormatCalc">
                            <div class="form-group">
                                <label for="box">Luas m2</label>
                                <input maxlength="5" type="text" onkeyup="attrLuas()" class="form-control" id="qtyM2" placeholder="0">
                            </div>
                        </div>
                        <div class="clearBoth"></div>
                    </div>
                    <div class="col-sm-8">
                        <button class="calcBtn" id="submitLuas" disabled="disabled" type="button" onclick="submitluas()">Hitung</button>
                    </div>
                </div>
            </div>
            <div class="calc calcSec2">
                <h4>Saya tahu ukuran ruangan yang saya butuhkan. Hitung jumlah ubin yang mau dipesan:</h4>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="LeftFormatCalc">
                            <div class="form-group">
                                <label for="box">Panjang m2</label>
                                <input maxlength="5" type="text" onkeyup="attrLuas2()" class="form-control" id="qtyPanjang" placeholder="0">
                            </div>
                        </div>
                        <div class="clearBoth"></div>
                    </div>
                    <div class="col-sm-6">
                        <div class="LeftFormatCalc">
                            <div class="form-group">
                                <label for="box">Lebar m2</label>
                                <input maxlength="5" type="text" onkeyup="attrLuas2()" class="form-control" id="qtyLebar" placeholder="0">
                            </div>
                        </div>
                        <div class="clearBoth"></div>
                    </div>
                    <div class="col-sm-12">
                        <button class="calcBtn" id="submitLuas2" disabled="disabled" type="button" onclick="submitluas2()">Hitung</button>
                    </div>
                </div>
            </div>
            <div class="calc calcSec3">
                <h4>Anda butuh <span id="qtyBox">0 Box</span>. Kami sarankan memesan <span id="recommendation">0 Box</span> (7% ekstra) untuk persiapan kekurangan dan perbaikan yang mungkin ada.</h4>
                <div class="row">
                    <div class=" col-xs-4 col-sm-4">
                        <div class="LeftFormatCalc">
                            <div class="form-group">
                                <input maxlength="5" type="text" onkeyup="attrTotal()" class="form-control" id="qtyTotal" name="qtyTotal" placeholder="0">
                            </div>
                        </div>
                        <div class="clearBoth"></div>
                    </div>
                    <div class=" col-xs-8 col-sm-8">
                        <button class="calcBtn" id="submitTotal" id="submitTotal" disabled="disabled" type="submit">Tambahkan ke Troli</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
<script type="application/javascript">
    function attrLuas(){
        if ($( "#qtyM2" ).val() > 0) {
            $('#submitLuas').removeAttr("disabled", "disabled");
        } else {
            $('#submitLuas').attr("disabled", "disabled");
        }
    }
    function attrLuas2(){
        if ($( "#qtyPanjang" ).val() > 0 && $( "#qtyLebar" ).val()) {
            $('#submitLuas2').removeAttr("disabled", "disabled");
        } else {
            $('#submitLuas2').attr("disabled", "disabled");
        }
    }
    function attrTotal(){
        if ($( "#submitTotal" ).val() > 0) {
            $('#submitTotal').removeAttr("disabled", "disabled");
        } else {
            $('#submitTotal').attr("disabled", "disabled");
        }
    }
    function submitluas(){
        var data = JSON.parse($('#calculator').find('input.data').val());
        var luas = $('#qtyM2').val();
        var qty = Math.ceil(luas / data.coverage);
        var rec = Math.ceil(qty + (qty * 0.07));
        $('#qtyBox').html(qty+' Box');
        $('#recommendation').html(rec+' Box');
        $('#qtyTotal').val(rec);
        if($('#qtyTotal').val() > 0) {
            $('#submitTotal').removeAttr("disabled", "disabled");
        }else {
            $('#submitTotal').attr("disabled", "disabled");
        }
    }
    function submitluas2(){
        var data = JSON.parse($('#calculator').find('input.data').val());
        var luas = $('#qtyPanjang').val() * $('#qtyLebar').val();
        var qty = Math.ceil(luas / data.coverage);
        var rec = Math.ceil(qty + (qty * 0.07));
        $('#qtyBox').html(qty+' Box');
        $('#recommendation').html(rec+' Box');
        $('#qtyTotal').val(rec);
        if($('#qtyTotal').val() > 0) {
            $('#submitTotal').removeAttr("disabled", "disabled");
        }else {
            $('#submitTotal').attr("disabled", "disabled");
        }
    }
</script>
