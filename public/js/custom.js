function number_format (number, decimals, decPoint, thousandsSep) { // eslint-disable-line camelcase
  //  discuss at: http://locutus.io/php/number_format/
  // original by: Jonas Raoni Soares Silva (http://www.jsfromhell.com)
  // improved by: Kevin van Zonneveld (http://kvz.io)
  // improved by: davook
  // improved by: Brett Zamir (http://brett-zamir.me)
  // improved by: Brett Zamir (http://brett-zamir.me)
  // improved by: Theriault (https://github.com/Theriault)
  // improved by: Kevin van Zonneveld (http://kvz.io)
  // bugfixed by: Michael White (http://getsprink.com)
  // bugfixed by: Benjamin Lupton
  // bugfixed by: Allan Jensen (http://www.winternet.no)
  // bugfixed by: Howard Yeend
  // bugfixed by: Diogo Resende
  // bugfixed by: Rival
  // bugfixed by: Brett Zamir (http://brett-zamir.me)
  //  revised by: Jonas Raoni Soares Silva (http://www.jsfromhell.com)
  //  revised by: Luke Smith (http://lucassmith.name)
  //    input by: Kheang Hok Chin (http://www.distantia.ca/)
  //    input by: Jay Klehr
  //    input by: Amir Habibi (http://www.residence-mixte.com/)
  //    input by: Amirouche
  //   example 1: number_format(1234.56)
  //   returns 1: '1,235'
  //   example 2: number_format(1234.56, 2, ',', ' ')
  //   returns 2: '1 234,56'
  //   example 3: number_format(1234.5678, 2, '.', '')
  //   returns 3: '1234.57'
  //   example 4: number_format(67, 2, ',', '.')
  //   returns 4: '67,00'
  //   example 5: number_format(1000)
  //   returns 5: '1,000'
  //   example 6: number_format(67.311, 2)
  //   returns 6: '67.31'
  //   example 7: number_format(1000.55, 1)
  //   returns 7: '1,000.6'
  //   example 8: number_format(67000, 5, ',', '.')
  //   returns 8: '67.000,00000'
  //   example 9: number_format(0.9, 0)
  //   returns 9: '1'
  //  example 10: number_format('1.20', 2)
  //  returns 10: '1.20'
  //  example 11: number_format('1.20', 4)
  //  returns 11: '1.2000'
  //  example 12: number_format('1.2000', 3)
  //  returns 12: '1.200'
  //  example 13: number_format('1 000,50', 2, '.', ' ')
  //  returns 13: '100 050.00'
  //  example 14: number_format(1e-8, 8, '.', '')
  //  returns 14: '0.00000001'

  number = (number + '').replace(/[^0-9+\-Ee.]/g, '')
  var n = !isFinite(+number) ? 0 : +number
  var prec = !isFinite(+decimals) ? 0 : Math.abs(decimals)
  var sep = (typeof thousandsSep === 'undefined') ? ',' : thousandsSep
  var dec = (typeof decPoint === 'undefined') ? '.' : decPoint
  var s = ''

  var toFixedFix = function (n, prec) {
    var k = Math.pow(10, prec)
    return '' + (Math.round(n * k) / k)
      .toFixed(prec)
  }

  // @todo: for IE parseFloat(0.55).toFixed(0) = 0;
  s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.')
  if (s[0].length > 3) {
    s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep)
  }
  if ((s[1] || '').length < prec) {
    s[1] = s[1] || ''
    s[1] += new Array(prec - s[1].length + 1).join('0')
  }

  return s.join(dec)
}

function totop(event) {
    event.preventDefault();
    $('html,body').animate({scrollTop:0},600,'linear');
}

$(document).ready(function() {
    if($('input[name="notifIndex"]').val() == 1) {
        $('#myModalProductCart').modal('show');
    }

    $('.all-search-item-type-link').on('click', function(event) {
        event.preventDefault();
        var type = $(this).html();
        $('#all-search-item-type').html(type+' <span class="caret"></span>');
        $(this).closest('form').find('input[name="item_type"]').val(type);
    });

    $('#all-search-text').on('keyup', function(event) {
        var type = $(this).closest('form').find('input[name="item_type"]').val();
        var keyword = $(this).val();
        setTimeout(function() {
            $.ajax({
                type: "POST",
                url: $('#getAutoCompleteDataLink').val(),
                data: "_token="+$('#ajax_token').val()+"&type="+type+"&keyword="+keyword,
                success: function(data) {
                    // // console.log(data);
                    var data = JSON.parse(data);
                    autoCompleteData = [];
                    for(var i=0;i<data.length;i++) {
                        autoCompleteData.push(data[i].item_name);
                    }
                    $('#all-search-text').autocomplete({
                        source: autoCompleteData,
                        appendTo: "#autocomplete-all-search-section"
                    });
                    $('#all-search-text').autocomplete('search', " ");
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    // $('#html-error-msg').html(JSON.stringify(jqXHR));
                    // alert('error');
                }
            });
        }, 1000);
    });

	$('ul.expand-link').find('a').on('click', function(event) {
        event.preventDefault();
        var id = $(this).data('id');
        $('ul.sub-material').each(function() {
            $(this).addClass('hidden');
            if($(this).data('id') == id) {
                $(this).removeClass('hidden');
            }
        });
        $('ul.expand-link').find('a').each(function() {
            $(this).html('+');
            $(this).closest('li').removeClass('active');
        });
        $('ul.material-name').find('li').each(function() {
            $(this).removeClass('active');
            if($(this).data('id') == id) {
                $(this).addClass('active');
            }
        });
        $(this).html('-');
        $(this).closest('li').addClass('active');
    });

    $('ul.material-name').find('a').on('click', function(event) {
        event.preventDefault();
        var name = $(this).data('name');
        $('ul.expand-link').find('a').each(function() {
            console.log($(this).data('name')+' '+name);
            if($(this).data('name') == name) {
                console.log('match');
                $(this).click();
            }
        });
    });

    $('.swiper-slide').each(function() {
        // $(this).css('height', '30%');
    });

    $('#calculator').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget);
        var id = button.data('id');
        var modal = $(this);
        modal.find('.loading-div').removeClass('hidden');
        modal.find('.content').addClass('hidden');
        $.ajax({
            type: "POST",
            url: $('#getCalcDataLink').val(),
            data: "_token="+$('#ajax_token').val()+"&id="+id,
            success: function(data) {
                modal.find('input[name="id"]').val(id);
                modal.find('.data').val(data);
                modal.find('.loading-div').addClass('hidden');
                modal.find('.content').removeClass('hidden');
            },
            error: function(jqXHR, textStatus, errorThrown) {
                // alert('error');
            }
        });
    });

    // REGISTER JS
    // -----------
    $('#registerForm').find('select[name="province"]').on('change', function(event) {
        var provinceData = JSON.parse($('#province_data').val());
        var value = $(this).val();
        var string = '<option value="0" class="hidden">Kota anda..</option>';
        for(var i=0;i<provinceData.length;i++) {
            if(provinceData[i].id == value) {
                $('#registerForm').find('select[name="city"]').prop('disabled', false);
                for(var j=0;j<provinceData[i].city.length;j++) {
                    string += '<option value="'+provinceData[i].city[j].id+'">'+provinceData[i].city[j].city_name+'</option>';
                }
            }
        }
        $('#registerForm').find('select[name="city"]').html(string);
    });
    $('#registerForm').on('submit', function(event) {
        // event.preventDefault();
        var pass = $(this).find('input[name="password"]').val();
        var retype = $(this).find('input[name="retypepassword"]').val();
        if(pass.length < 6) {
            event.preventDefault();
            $(this).find('.errormsg').html('Panjang password minimal 6 karakter');
        }else {
            if(pass != retype) {
                event.preventDefault();
                $(this).find('.errormsg').html('Mohon masukkan kembali password yang telah anda masukkan');
            }else {
                var valid = true;
                $(this).find('input[type="text"], textarea').each(function() {
                    if($(this).prop('name') != 'handphone2' && $(this).prop('name') != 'company') {
                        if($(this).val() == '' || $(this).val() == null) {
                            valid = false;
                        }
                    }
                });
                $(this).find('select').each(function() {
                    if($(this).val() == 0) {
                        valid = false;
                    }
                });
                if(valid == false) {
                    event.preventDefault();
                    $(this).find('.errormsg').html('Mohon masukkan data dengan lengkap');
                }else {
                    $(this).find('.errormsg').html('');
                }
            }
        }
    });

    // PROFILE JS
    // ----------
    $('#provinceProfile').on('change', function(event) {
        var id = $(this).val();
        $('.cityProfile').each(function() {
            $(this).addClass('hidden');
            if($(this).data('id') == id) {
                $(this).removeClass('hidden');
            }
        });
    });
    $('[name="addressForm"]').find('select[name="province"]').on('change', function(event) {
        var id = $(this).val();
        $('.cityAddProfile').each(function() {
            $(this).addClass('hidden');
            if($(this).data('id') == id) {
                $(this).removeClass('hidden');
            }
        });
    });
    $('#profileForm').on('submit', function(event) {
        var valid = true;
        $(this).find('input[type="text"]').each(function() {
            if($(this).prop('name') != 'handphone2' && $(this).prop('name') != 'company') {
                if($(this).val() == '' || $(this).val() == null) {
                    valid = false;
                }
            }
        });
        if(valid == false) {
            event.preventDefault()
            $(this).find('.notification').html('');
            $(this).find('.error-msg').html('Mohon isi data dengan lengkap');
        }
    });
    $('#passwordForm').on('submit', function(event) {
        // event.preventDefault();
        valid = true;
        $(this).find('input[type="password"]').each(function() {
            if($(this).val() == '' || $(this).val() == null) {
                valid = false;
            }
        });
        if(valid == false) {
            event.preventDefault();
            $(this).find('.error-msg').html('Mohon isi data dengan lengkap');
        }else {
            var pass = $(this).find('input[name="newPassword"]').val();
            var confirm = $(this).find('input[name="confirmPassword"]').val();
            if(pass != confirm) {
                event.preventDefault();
                $(this).find('.error-msg').html('Masukkan konfirmasi password sesuai dengan password baru yang telah anda masukkan');
            }else {
                $(this).find('.error-msg').html('');
            }
        }
    });
    $('#addAddress').on('show.bs.modal', function(event) {
        $(this).find('form').prop('action', $('addAddressLink').val());
        var button = $(event.relatedTarget);
        var type = button.data('type');
        $(this).find('input[name="type"]').val(type);
    });
    $('#changeAddress').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget);
        var id = button.data('id');
        var modal = $(this);
        modal.find('.content').addClass('hidden');
        modal.find('.loading-div').removeClass('hidden');
        modal.find('form').prop('action', $('#editAddressLink').val());
        modal.find('input[name="id"]').val(id);
        $.ajax({
            type: "POST",
            url: $('#get-address-data-link').val(),
            data: "_token="+$('#ajax_token').val()+"&id="+id,
            success: function(data) {
                var data = JSON.parse(data);
                modal.find('input[name="name"]').val(data.name);
                modal.find('select[name="province"]').val(data.province_id);
                modal.find('select.cityAddProfile').each(function() {
                    $(this).addClass('hidden');
                    if($(this).data('id') == data.province_id) {
                        $(this).val(data.city_id);
                        $(this).removeClass('hidden');
                    }
                });
                modal.find('input[name="city"]').val(data.city_id);
                modal.find('textarea[name="address"]').val(data.address);
                modal.find('input[name="handphone1"]').val(data.telp1);
                if(data.telp2 == 'null') {
                    modal.find('input[name="handphone2"]').val('');
                }else {
                    modal.find('input[name="handphone2"]').val(data.telp2);
                }
                modal.find('.loading-div').addClass('hidden');
                modal.find('.content').removeClass('hidden');
            },
            error: function(jqXHR, textStatus, errorThrown) {
                // $('#html-error-msg').html(JSON.stringify(jqXHR));
                // alert('error');
            }
        });
    });
    $('[name="addressForm"]').on('submit', function(event) {
        var city = 0;
        $(this).find('select.cityAddProfile').each(function() {
            if(!$(this).hasClass('hidden')) {
                city = $(this).val();
            }
        });
        $(this).find('input[name="city"]').val(city);
        var type = $(this).find('input[name="type"]').val();
        if(type == 'cart') {
            event.preventDefault();
            var name = $(this).find('input[name="name"]').val();
            var province = $(this).find('select[name="province"]').val();
            var city = $(this).find('input[name="city"]').val();
            var address = $(this).find('textarea[name="address"]').val();
            var handphone1 = $(this).find('input[name="handphone1"]').val();
            var handphone2 = $(this).find('input[name="handphone2"]').val();
            var datastring = "_token="+$('#ajax_token').val()+"&name="+name+"&province="+province+"&city="+city+"&address="+address+"&handphone1="+handphone1+"&handphone2="+handphone2;
            var modal = $(this).closest('.modal');
            modal.find('.content').addClass('hidden');
            modal.find('.loading-div').removeClass('hidden');
            // console.log($('#addAddressLink').val()+'?'+datastring);
            $.ajax({
                type: "POST",
                url: $('#addAddressLink').val(),
                data: datastring,
                success: function(data) {
                    var data = JSON.parse(data);
                    if(data.type == "primary") {
                        var string = ''+
                        '<div class="shippingRow withRadio">'+
                            '<input type="radio" name="address" id="main-address" data-id="'+data.id+'" checked>'+
                            '<label for="main-address">'+
                                '<h4>'+data.name+'</h4>'+
                                '<p>'+data.address+'</p>'+
                                '<p>'+data.city_name+', '+data.province_name+'</p>';
                        if(data.telp2 == null || data.telp2 == '') {
                            string += '<p>Telp: '+data.telp1+'</p>';
                        }else {
                            string += '<p>Telp 1: '+data.telp1+'</p>'+
                                    '<p>Telp 2: '+data.telp2+'</p>';
                        }
                        string += '</label>'+
                            '</div>';
                    }else {
                        var string = ''+
                        '<div class="shippingRow withRadio">'+
                            '<input type="radio" class="alt-address" name="address" data-id="'+data.id+'">'+
                            '<label for="alt-address1">'+
                                '<h4>'+data.name+'</h4>'+
                                '<p>'+data.address+'</p>'+
                                '<p>'+data.city_name+', '+data.province_name+'</p>';
                        if(data.telp2 == null || data.telp2 == '') {
                            string += '<p>Telp: '+data.telp1+'</p>';
                        }else {
                            string += '<p>Telp 1: '+data.telp1+'</p>'+
                                    '<p>Telp 2: '+data.telp2+'</p>';
                        }
                        string += '</label>'+
                            '</div>';
                    }
                    $('#no-address').remove();
                    $('.mainShipping').append(string);
                    if($('#nonShippingCheck').prop('checked') == true) {
                        $('#nonShippingCheck').click();
                    }
                    $('.mainShipping').find('.shippingRow').each(function() {
                        $(this).find('input[type="radio"]').click();
                    });
                    modal.modal('hide');
                    modal.find('.loading-div').addClass('hidden');
                    modal.find('.content').removeClass('hidden');
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    // $('#html-error-msg').html(JSON.stringify(jqXHR));
                    // alert('error');
                }
            });
        }else {
            var valid = true;
            $(this).find('input[type="text"], textarea').each(function() {
                if($(this).prop('name') != 'handphone2') {
                    if($(this).val() == null || $(this).val() == '') {
                        valid = false;
                    }
                }
            });
            if(city == 0) {
                valid = false;
            }
            if(valid == false) {
                event.preventDefault();
                $(this).find('.error-msg').html('Mohon isi data dengan lengkap');
            }else {
                $(this).find('.error-msg').html('');
            }
        }
    });
    $('#myModalDelAddressConfirmation').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget);
        var id = button.data('id');
        $(this).find('form').find('input[name="id"]').val(id);
    });

    // PRODUCT CATEGORY JS
    // -------------------
    $('#sorting, #pg').on('change', function(event) {
        $('#sortingForm').find('input[name="s"]').val($('#sorting').val());
        $('#sortingForm').find('input[name="pg"]').val($('#pg').val());
        $('#sortingForm').submit();
    });

    // PRODUCT DETAIL JS
    // -----------------
    $('#addOn').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget);
        var id = button.data('id');
        var tile = button.data('item');
        var modal = $(this);
        modal.find('.loading-div').removeClass('hidden');
        modal.find('.content').addClass('hidden');
        $.ajax({
            type: "POST",
            url: $('#getAddOnDataLink').val(),
            data: "_token="+$('#ajax_token').val()+"&id="+id,
            success: function(data) {
                data = JSON.parse(data);
                modal.find('input[name="tile"]').val(tile);
                modal.find('.addon1').find('.addonid').val(data.add_on_1_data.addonid);
                modal.find('.addon1').find('img').attr('src', $('#addonImgPath').val()+'/medium/'+data.add_on_1_data.img_name);
                modal.find('.addon1').find('.productName').html(data.add_on_1_data.add_on_name);
                modal.find('.addon1').find('.addOnPrice').html('Rp.'+data.add_on_1_data.price_per_pcs);
                modal.find('.addon2').find('.addonid').val(data.add_on_2_data.addonid);
                modal.find('.addon2').find('img').attr('src', $('#addonImgPath').val()+'/medium/'+data.add_on_2_data.img_name);
                modal.find('.addon2').find('.productName').html(data.add_on_2_data.add_on_name);
                modal.find('.addon2').find('.addOnPrice').html('Rp.'+data.add_on_2_data.price_per_pcs);
                modal.find('.addon3').find('.addonid').val(data.add_on_3_data.addonid);
                modal.find('.addon3').find('img').attr('src', $('#addonImgPath').val()+'/medium/'+data.add_on_3_data.img_name);
                modal.find('.addon3').find('.productName').html(data.add_on_3_data.add_on_name);
                modal.find('.addon3').find('.addOnPrice').html('Rp.'+data.add_on_3_data.price_per_pcs);
                modal.find('.addOnDesc1').html('<b>'+data.add_on_1_data.add_on_name+'</b>, '+data.add_on_description_1);
                modal.find('.addOnDesc2').html('<b>'+data.add_on_2_data.add_on_name+'</b>, '+data.add_on_description_2);
                modal.find('.addOnDesc3').html('<b>'+data.add_on_3_data.add_on_name+'</b>, '+data.add_on_description_3);
                if(data.nobuy == true) {
                    modal.find('.qty-box').addClass('hidden');
                    modal.find('.calcBtn').addClass('hidden');
                    modal.find('.login-notif').removeClass('hidden');
                }else {
                    modal.find('.qty-box').removeClass('hidden');
                    modal.find('.calcBtn').removeClass('hidden');
                    modal.find('.login-notif').addClass('hidden');
                }
                modal.find('.loading-div').addClass('hidden');
                modal.find('.content').removeClass('hidden');
            },
            error: function(jqXHR, textStatus, errorThrown) {
                // $('#html-error-msg').html(JSON.stringify(jqXHR));
                // alert('error');
            }
        });
    });

    $('#addOn').find('.calcBtn').on('click', function(event) {
        $('.productBox').each(function() {
            if($(this).hasClass('active')) {
                $('#addOn').find('input[name="id"]').val($(this).find('.addonid').val());
                $('#addOn').find('input[name="qty"]').val($(this).find('.qty-box').find('input[type="text"]').val());
                $('#addOn').find('form').submit();
            }
        });
    });

    // CART JS
    // -------
    $('.delCartLink').on('click', function(event) {
        event.preventDefault();
        var type = $(this).data('type');
        var id = $(this).data('id');
        $('#delCartForm').find('input[name="type"]').val(type);
        $('#delCartForm').find('input[name="id"]').val(id);
        $('#delCartForm').submit();
    });
    $('#mainShipping').collapse('show');
    $('#nonShippingCheck').on('click', function(event) {
        var addressExist = false;
        $('.shippingRow').each(function() {
            addressExist = true;
        });
        if(addressExist == true) {
            if($(this).prop('checked') == true) {
                $('#nonShipping').collapse('show');
                $('#mainShipping').collapse('hide');
                $(this).closest('body').find('input[type="text"]').prop('disabled', true);
                $(this).closest('body').find('textarea').prop('disabled', true);
                $('#fee-data').find('span').html('0');
            }else {
                $('#nonShipping').collapse('hide');
                $('#mainShipping').collapse('show');
                $(this).closest('body').find('input[type="text"]').prop('disabled', false);
                $(this).closest('body').find('textarea').prop('disabled', false);
                $('.mainShipping').find('.shippingRow').each(function() {
                    if($(this).find('input[type="radio"]').prop('checked') == true) {
                        $(this).find('input[type="radio"]').click();
                    }
                });
            }
        }else {
            event.preventDefault();
            $('#nonShipping').collapse('show');
            $(this).closest('body').find('input[type="text"]').prop('disabled', true);
            $(this).closest('body').find('textarea').prop('disabled', true);
            $(this).closest('body').find('.modal').find('input[type="text"], textarea').prop('disabled', false);
            $('#fee-data').find('span').html('0');
        }
    });
    var addressExist = false;
    $('.mainShipping').find('.shippingRow').each(function() {
        addressExist = true;
    });
    if(addressExist == false) {
        $('#nonShippingCheck').click();
    }
    $(this).on('click', 'input[name="address"]', function(event) {
        var id = $(this).data('id');
        $.ajax({
            type: "POST",
            url: $('#getFeeDataLink').val(),
            data: '_token='+$('#ajax_token').val()+'&address='+id,
            success: function(data) {
                $('#fee-data').find('span').html(data);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                // alert('error');
            }
        });
    });
    $('#to-summary-link').on('click', function(event) {
        event.preventDefault();
        var nonShippingCheck = $('#nonShippingCheck').prop('checked');
        var addressId = 0;
        if(nonShippingCheck == false) {
            $('input[name="address"]').each(function() {
                if($(this).prop('checked') == true) {
                    addressId = $(this).data('id');
                }
            });
        }
        var receiverName = $('input[name="receiver-name"]').val();
        var receiverPhone1 = $('input[name="receiver-phone1"]').val();
        var receiverPhone2 = $('input[name="receiver-phone2"]').val();
        var receiverNote = $('textarea[name="delivery-note"]').val();
        var datastring = "_token="+$('#ajax_token').val()+"&non-shipping="+nonShippingCheck+"&addressId="+addressId+"&name="+receiverName+"&receiverPhone1="+receiverPhone1+"&receiverPhone2="+receiverPhone2+"&receiverNote="+receiverNote;
        // alert(datastring);
        // aa;
        $.ajax({
            type: "POST",
            url: $('#addressToSessionLink').val(),
            data: datastring,
            success: function(data) {
                // console.log(data);
                // window.location.href = $('#toSummaryLink').val()+'/'+code;
                $('#toSummaryForm').submit();
            },
            error: function(jqXHR, textStatus, errorThrown) {
                // $('#html-error-msg').html(JSON.stringify(jqXHR));
                // alert('error');
            }
        });
    });

    // CONFIRMATION JS
    // ---------------
    $('input[name="amount"]').autoNumeric('init', {
        aSep: '.',
        aDec: ','
    });
    $('input[name="date"]').datepicker({
        dateFormat: "dd/mm/yy"
    });

    // FOOTER JS
    // ---------
    $('#to_top').bind("click", function(event){
        event.preventDefault();
        $('html,body').animate({scrollTop:0},600,'linear');
    });
});