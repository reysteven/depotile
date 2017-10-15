$(document).ready(function() {
    $('select[name="search-province"]').on('change', function(event) {
        $('select[name="search-city"]').prop('disabled', true);
        var provinceData = JSON.parse('<?php echo json_encode($provinceData) ?>');
        var provinceName = $(this).val();
        for(var i=0;i<provinceData.length;i++) {
            if(provinceData[i]['province_name'] == provinceName) {
                var string = '<option class="hidden">Pilih nama kota</option>';
                for(var j=0;j<provinceData[i]['cityData'].length;j++) {
                    string += '<option>'+provinceData[i]['cityData'][j]['city_name']+'</option>'
                }
                $('select[name="search-city"]').html(string);
                $('select[name="search-city"]').prop('disabled', false);
            }
        }
    });

    $('#search-startfee').autoNumeric('init', {
        aSep: '.',
        aDec: ',',
        aSign: 'Rp '
    });
    $('#search-endfee').autoNumeric('init', {
        aSep: '.',
        aDec: ',',
        aSign: 'Rp '
    });

    $('#fee-search-form').on('submit', function(event) {
        $(this).find('select').prop('disabled', false);
    });

    $(this).on('click', '.file-browser', function(event) {
        $(this).closest('.form-group').find('input[type="file"]').click();
    });

    $(this).on('change', 'input[type="file"]', function(event) {
        var value = $(this).val().split('\\');
        value = value[value.length-1];
        $(this).closest('.form-group').find('.file-name-text').val(value);
    })

    $('#excel-uploader-submit').click(function(event) {
        $(this).prop('disabled', true);
        $('#excel-uploader-form').submit();
    });
});