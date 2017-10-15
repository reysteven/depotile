function autocompleteValidation(target, value) {
    if(value == true) {
        target.css('background-color', 'white');
        target.attr('data-valid', 'true');
    }else {
        target.css('background-color', 'rgb(255,166,166)');
        target.attr('data-valid', 'false');
    }
}

function updateAutocompleteTag() {
    var tempTagData = JSON.parse($('#tagData').val())
    var headerTagData = [];
    for(var i=0;i<tempTagData.length;i++) {
        headerTagData.push(tempTagData[i]['tag_name']);
    }
    $('#myModalDetailItem').find('#tag').find('input.header-tag').each(function() {
        $(this).autocomplete({
            source: headerTagData,
            appendTo: '#myModalDetailItem',
            close: function(event, ui) {
                var tag_name = $(this).val();
                var valid = false;
                for(var i=0;i<tempTagData.length;i++) {
                    if(tempTagData[i]['tag_name'] == tag_name) {
                        valid = true;
                        $(this).closest('.tag-wrapper').find('input.detail-tag').attr('data-detail', JSON.stringify(tempTagData[i]['detail_tag']));
                        var detail_data = JSON.parse($(this).closest('.tag-wrapper').find('input.detail-tag').attr('data-detail'));
                        $(this).closest('.tag-wrapper').find('input.detail-tag').autocomplete({
                            source: detail_data
                        });
                    }
                }
                if(valid == false) {
                    $('#myModalDetailItem').find('input[name="item_sub_category"]').prop('disabled', true);
                }else {
                    $('#myModalDetailItem').find('input[name="item_sub_category"]').prop('disabled', false);
                }
                autocompleteValidation($(event.target), valid);
            }
        });
    });
    $('#myModalDetailItem').find('#tag').find('input.detail-tag').each(function() {
        var tag_name = $(this).closest('.tag-wrapper').find('input.header-tag').val();
        var detailTag = [];
        for(var i=0;i<tempTagData.length;i++) {
            if(tempTagData[i]['tag_name'] == tag_name) {
                for(var j=0;j<tempTagData[i]['detail_tag'].length;j++) {
                    detailTag.push(tempTagData[i]['detail_tag'][j]);
                }
                $(this).attr('data-detail', JSON.stringify(detailTag));
                break;
            }
        }
        $(this).autocomplete({
            source: detailTag,
            appendTo: '#myModalDetailItem',
            close: function(event, ui) {
                var detail_tag_name = $(this).val();
                var detail_tag_data = JSON.parse($(this).attr('data-detail'));
                var detailValid = false;
                for(var i=0;i<detail_tag_data.length;i++) {
                    if(detail_tag_data[i] == detail_tag_name) {
                        detailValid = true;
                    }
                }
                autocompleteValidation($(event.target), detailValid);
            }
        });
    });
}

$(document).ready(function() {
    $('#price_m2').autoNumeric('init', {
        aSep: '.',
        aDec: ',',
        aSign: 'Rp '
    });

    // BUAT VALIDASI KALO ADA YANG MASIH KOSONG
    // ----------------------------------------
    $('#myModalDetailItem').find('input[type="text"]').on('keyup', function(event) {
        if($(this).val() == "" || $(this).val() == null) {
            autocompleteValidation($(this),false);
        }else {
            autocompleteValidation($(this),true);
        }
    });

    // TAMPILIN BAGIAN ADD ON JIKA ADD ON DIPILIH YES
    // ----------------------------------------------
    $('#myModalDetailItem').find('select[name="addon"]').on('change', function(event) {
        if($(this).val() == "Ya") {
            $('#myModalDetailItem').find('#add-on-detail').collapse('show');
        }else {
            $('#myModalDetailItem').find('#add-on-detail').collapse('hide');
        }
    });

    // KASIH TEXT EDITOR DI BAGIAN DESCRIPTION
    // ---------------------------------------
    tinymce.init({ selector:'#desc-editor' });

    $('#myModalDetailItem').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget);
        var itemId = button.data('id');
        var type = button.data('type');
        $(this).find('input.item-id').val(itemId);
        $(this).find('.loading-div').removeClass('hidden');
        $(this).find('.content').addClass('hidden');
        $(this).find('a[href="#general"]').tab('show');

        // RESET SEMUA TEXTBOX MERAH
        // -------------------------
        $(this).find('input[type="text"]').each(function() {
            $(this).css('background-color', 'white');
            $(this).attr('data-valid', 'true');
        });

        // AUTOCOMPLETE TEXTBOX BRAND
        // --------------------------
        var tempBrandData = JSON.parse($('#brandData').val());
        var brandData = [];
        for(var i=0;i<tempBrandData.length;i++) {
            brandData.push(tempBrandData[i]['brand_name']);
        }
        // alert(JSON.stringify(brandData));
        $('#general').find('input[name="brand"]').autocomplete({
            source: brandData,
            appendTo: '#myModalDetailItem',
            close: function(event, ui) {
                var brand_name = $(this).val();
                var valid = false;
                for(var i=0;i<brandData.length;i++) {
                    if(brandData[i] == brand_name) {
                        valid = true;
                    }
                }
                autocompleteValidation($(event.target),valid);
            }
        });

        // AUTOCOMPLETE TEXTBOX INSTALLATION
        // ---------------------------------
        var tempInstallationData = JSON.parse($('#installationData').val());
        var installationData = [];
        for(var i=0;i<tempInstallationData.length;i++) {
            installationData.push(tempInstallationData[i]['installation_name']);
        }
        // alert(JSON.stringify(installationData));
        $('#general').find('input[name="installation"]').autocomplete({
            source: installationData,
            appendTo: '#myModalDetailItem',
            close: function(event, ui) {
                var inst_name = $(this).val();
                var valid = false;
                for(var i=0;i<installationData.length;i++) {
                    if(installationData[i] == inst_name) {
                        valid = true;
                    }
                }
                autocompleteValidation($(event.target),valid);
            }
        });

        // AUTOCOMPLETE TEXTBOX ONGKIR
        // ---------------------------
        var tempFeeData = JSON.parse($('#feeData').val());
        var feeData = [];
        for(var i=0;i<tempFeeData.length;i++) {
            feeData.push(tempFeeData[i]['fee_name']);
        }
        // alert(JSON.stringify(feeData));
        $('#general').find('input[name="fee"]').autocomplete({
            source: feeData,
            appendTo: '#myModalDetailItem',
            close: function(event, ui) {
                var fee_name = $(this).val();
                var valid = false;
                for(var i=0;i<feeData.length;i++) {
                    if(feeData[i] == fee_name) {
                        valid = true;
                    }
                }
                autocompleteValidation($(event.target),valid);
            }
        });

        $.ajax({
            type: "POST",
            url: '/depotile/admin/item-manager/doGetItemDetail.php',
            data: "itemId="+itemId,
            success: function(data) {
                var itemData = JSON.parse(data);
                // alert(itemData['detail_tag_data']);                    

                //GENERAL INFO
                //------------
                $('#general').find('input[name="item_id"]').val(itemData['id']);
                $('#general').find('input[name="item_code"]').val(itemData['item_code']);
                $('#general').find('input[name="item_name"]').val(itemData['item_name']);
                $('#general').find('input[name="item_category"]').val(itemData['category_name']);
                $('#general').find('input[name="item_sub_category"]').val(itemData['detail_category_name']);
                var categoryData = JSON.parse($('#categoryData').val());
                for(var i=0;i<categoryData.length;i++) {
                    if(categoryData[i]['category_name'] == itemData['category_name']) {
                        $('#general').find('input[name="item_sub_category"]').attr('data-detail', JSON.stringify(categoryData[i]['detail_category']));
                    }
                }
                $('#general').find('input[name="item_length"]').val(itemData['length']);
                $('#general').find('input[name="item_width"]').val(itemData['width']);
                $('#general').find('input[name="item_thick"]').val(itemData['thickness']);
                $('#general').find('input[name="pcs_per_box"]').val(itemData['pcs_per_box']);
                $('#general').find('input[name="price_m2"]').val(itemData['price_per_m2']);
                $('#general').find('input[name="brand"]').val(itemData['brand_name']);
                if(itemData['calculator'] == 1) {
                    $('#general').find('select[name="calc"]').val('Ya');
                }else {
                    $('#general').find('select[name="calc"]').val('Tidak');
                }
                $('#general').find('input[name="installation"]').val(itemData['installation_name']);
                $('#general').find('input[name="fee"]').val(itemData['fee_name']);
                if(itemData['add_on'] == 1) {
                    $('#general').find('select[name="addon"]').val('Ya');
                    $('#general').find('#add-on-detail').collapse('show');
                    $('#general').find('#add-on-detail').find('input[name="addon1"]').val(itemData['add_on_1_name']);
                    $('#general').find('#add-on-detail').find('input[name="addon2"]').val(itemData['add_on_2_name']);
                    $('#general').find('#add-on-detail').find('input[name="addon3"]').val(itemData['add_on_3_name']);
                    $('#general').find('#add-on-detail').find('textarea[name="addon1desc"]').val(itemData['add_on_description_1']);
                    $('#general').find('#add-on-detail').find('textarea[name="addon2desc"]').val(itemData['add_on_description_2']);
                    $('#general').find('#add-on-detail').find('textarea[name="addon3desc"]').val(itemData['add_on_description_3']);
                    $('#general').find('#add-on-detail').find('input[name="addoncta"]').val(itemData['add_on_cta']);
                    $('#general').find('#add-on-detail').find('input[name="addontitle"]').val(itemData['add_on_title']);
                }else {
                    $('#general').find('select[name="addon"]').val('Tidak');
                    $('#general').find('#add-on-detail').collapse('hide');
                }

                // AUTOCOMPLETE TEXTBOX HEADER KATEGORI
                // ------------------------------------
                var categoryName = [];
                for(var i=0;i<categoryData.length;i++) {
                    categoryName.push(categoryData[i]['category_name']);
                }
                $('#general').find('input[name="item_category"]').autocomplete({
                    source: categoryName,
                    appendTo: '#myModalDetailItem',
                    close: function(event, ui) {
                        var category_name = $(this).val();
                        var valid = false;
                        for(var i=0;i<categoryData.length;i++) {
                            if(categoryData[i]['category_name'] == category_name) {
                                valid = true;
                                $('#general').find('input[name="item_sub_category"]').attr('data-detail', JSON.stringify(categoryData[i]['detail_category']));
                                var detail_data = JSON.parse($('#general').find('input[name="item_sub_category"]').attr('data-detail'));
                                $('#general').find('input[name="item_sub_category"]').autocomplete({
                                    source: detail_data
                                    // appendTo: '#myModalDetailItem'
                                    // close: function(detailevent, detailui) {
                                    //     var detail_category_name = $(this).val();
                                    //     var detail_category_data = JSON.parse($(this).attr('data-detail'));
                                    //     var detailValid = false;
                                    //     for(var j=0;j<detail_category_data.length;j++) {
                                    //         if(detail_category_data[j] == detail_category_name) {
                                    //             detailValid = true;
                                    //         }
                                    //     }
                                    //     autocompleteValidation($(detailevent.target), detailValid);
                                    // }
                                });
                            }
                        }
                        if(valid == false) {
                            $('#myModalDetailItem').find('input[name="item_sub_category"]').prop('disabled', true);
                        }else {
                            $('#myModalDetailItem').find('input[name="item_sub_category"]').prop('disabled', false);
                        }
                        autocompleteValidation($(event.target), valid);
                    }
                });

                // AUTOCOMPLETE TEXTBOX DETAIL KATEGORI
                // ------------------------------------
                var detail_data = JSON.parse($('#general').find('input[name="item_sub_category"]').attr('data-detail'));
                $('#general').find('input[name="item_sub_category"]').autocomplete({
                    source: detail_data,
                    appendTo: '#myModalDetailItem',
                    close: function(event, ui) {
                        var detail_category_name = $(this).val();
                        var detail_category_data = JSON.parse($(this).attr('data-detail'));
                        var valid = false;
                        for(var j=0;j<detail_category_data.length;j++) {
                            if(detail_category_data[j] == detail_category_name) {
                                valid = true;
                            }
                        }
                        autocompleteValidation($(event.target), valid);
                    }
                });

                // AUTOCOMPLETE TEXTBOX ADDON
                // --------------------------
                var addon_data = JSON.parse($('#addonData').val());
                var addon_name = [];
                for(var i=0;i<addon_data.length;i++) {
                    addon_name.push(addon_data[i]['add_on_name']);
                }
                $('#general').find('input.addon').autocomplete({
                    source: addon_name,
                    appendTo: '#myModalDetailItem',
                    close: function(event, ui) {
                        var addon_name = $(this).val();
                        var valid = false;
                        for(var j=0;j<addon_data.length;j++) {
                            if(addon_data[j]['add_on_name'] == addon_name) {
                                valid = true;
                            }
                        }
                        var self = $(this);
                        $('#general').find('input.addon').each(function(e) {
                            if(!$(this).is(self) && $(this).val() == addon_name) {
                                valid = false;
                                autocompleteValidation($(this), valid);
                            }
                        });
                        autocompleteValidation($(event.target), valid);
                    }
                });

                // IMAGE INFO
                // ----------
                $('#img').find('td.img1').find('.curr-img').attr('src', '/depotile/assets/image/item-image/small/'+itemData['img_name1']);
                $('#img').find('td.img2').find('.curr-img').attr('src', '/depotile/assets/image/item-image/small/'+itemData['img_name2']);
                $('#img').find('td.img3').find('.curr-img').attr('src', '/depotile/assets/image/item-image/small/'+itemData['img_name3']);

                //DESCRIPTION INFO
                //----------------
                tinymce.activeEditor.setContent(itemData['description'])

                //TAG INFO
                //--------
                var string = '';
                var tagData = JSON.parse(itemData['detail_tag_data']);
                for(var i=0;i<tagData.length;i++) {
                    string += ''+
                        '<div class="col-xs-12 tag-wrapper" style="margin-bottom:2%">'+
                            '<div class="col-xs-1" style="padding:0.5% 0 0 0">'+
                                '<span class="fa fa-circle" style="font-size:10px"></span>'+
                            '</div>'+
                            '<div class="col-xs-4" style="padding:0">'+
                                '<input type="text" class="form-control header-tag" value="'+tagData[i]['tag_name']+'" placeholder="Tag" disabled>'+
                            '</div>'+
                            '<div class="col-xs-1 text-center" style="padding:1% 0 0 0">=></div>'+
                            '<div class="col-xs-4" style="padding:0">'+
                                '<input type="text" class="form-control detail-tag" value="'+tagData[i]['detail_tag_name']+'" placeholder="Sub Tag" disabled>'+
                            '</div>'+
                            '<div class="col-xs-2 text-center editor-panel" style="padding-top:0.5%">'+
                                '<a href="#" class="fa fa-check check-tag hidden" style="margin:0 3%"></a>'+
                                '<a href="#" class="fa fa-pencil edit-tag" style="margin:0 3%"></a>'+
                                '<a href="#" class="fa fa-trash delete-tag" style="margin:0 3%"></a>'+
                            '</div>'+
                        '</div>';
                }
                $('#tag').find('.tag-content').html(string);

                // LOGIC AUTOCOMPLETE TEXTBOX TAG
                // ------------------------------
                updateAutocompleteTag();

                $('#myModalDetailItem').find('.loading-div').addClass('hidden');
                $('#myModalDetailItem').find('.content').removeClass('hidden');
                if(type == "detail") {
                    $('#myModalDetailItem').find('#general').find('input').prop('disabled', true);
                    $('#myModalDetailItem').find('#general').find('select').prop('disabled', true);
                    $('#myModalDetailItem').find('#general').find('textarea').prop('disabled', true);
                    $('#myModalDetailItem').find('#img').find('th.change-img-head').addClass('hidden');
                    $('#myModalDetailItem').find('#img').find('a.change-img').closest('td').addClass('hidden');
                    $('#myModalDetailItem').find('#tag').find('.editor-panel').addClass('hidden');
                    $('#myModalDetailItem').find('#tag').find('.add-tag-btn').closest('div').addClass('hidden');
                    $('#submit-item-btn').closest('div').addClass('hidden');
                    tinymce.activeEditor.getBody().setAttribute('contenteditable', false);
                }else {
                    $('#myModalDetailItem').find('#general').find('input').prop('disabled', false);
                    $('#myModalDetailItem').find('#general').find('select').prop('disabled', false);
                    $('#myModalDetailItem').find('#general').find('textarea').prop('disabled', false);
                    $('#myModalDetailItem').find('input[name="item_id"]').prop('disabled', true);
                    $('#myModalDetailItem').find('#img').find('th.change-img-head').removeClass('hidden');
                    $('#myModalDetailItem').find('#img').find('a.change-img').closest('td').removeClass('hidden');
                    $('#myModalDetailItem').find('#tag').find('.editor-panel').removeClass('hidden');
                    $('#myModalDetailItem').find('#tag').find('.add-tag-btn').closest('div').removeClass('hidden');
                    $('#submit-item-btn').closest('div').removeClass('hidden');
                    tinymce.activeEditor.getBody().setAttribute('contenteditable', true);
                }
                $('#price_m2').keypress();
            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert('error');
            }
        });
    });

    $('#img').find('a.change-img').on('click', function(event) {
        event.preventDefault();
        $(this).closest('tr').find('.img-list').removeClass('hidden');
    });

    // LOGIKA LINK ITEM LIST DIKLIK
    // ----------------------------
    $('#img').find('a.img-item-link').on('click', function(event) {
        event.preventDefault();
        if(confirm('Yakin ingin berganti ke gambar ini?')) {
            var url = $(this).find('img').attr('src').replace('medium', 'small');
            $(this).closest('td').find('img').attr('src',url);
            $(this).closest('.img-list').addClass('hidden');
        }
    })

    // LOGIC KLIK TOMBOL EDIT TAG
    // --------------------------
    $('#myModalDetailItem').find('#tag').on('click', 'a.edit-tag', function(event) {
        $(this).closest('.tag-wrapper').find('input[type="text"]').prop('disabled', false);
        $(this).addClass('hidden')
        $(this).closest('.tag-wrapper').find('a.check-tag').removeClass('hidden');
    });

    // LOGIC KLIK TOMBOL CHECK TAG
    // ---------------------------
    $('#myModalDetailItem').find('#tag').on('click', 'a.check-tag', function(event) {
        var valid = true;
        $(this).closest('.tag-wrapper').find('input[type="text"]').each(function() {
            console.log($(this).val()+' | '+$(this).val()+' | '+$(this).attr('data-valid'));
            if($(this).val() == null || $(this).val() == "" || $(this).attr('data-valid') == 'false') {
                valid = false;
            }
        });
        if(valid == false) {
            alert('Isi data tag dengan benar terlebih dahulu');
        }else {
            $(this).closest('.tag-wrapper').find('input[type="text"]').css('background-color', '');
            $(this).closest('.tag-wrapper').find('input[type="text"]').prop('disabled', true);
            $(this).addClass('hidden')
            $(this).closest('.tag-wrapper').find('a.edit-tag').removeClass('hidden');
        }
    });

    // LOGIC KLIK TOMBOL TAMBAH TAG
    // ----------------------------
    $('#myModalDetailItem').find('#tag').on('click', 'button.add-tag-btn', function(event) {
        var string = ''+
        '<div class="col-xs-12 tag-wrapper" style="margin-bottom:2%">'+
            '<div class="col-xs-1" style="padding:0.5% 0 0 0">'+
                '<span class="fa fa-circle" style="font-size:10px"></span>'+
            '</div>'+
            '<div class="col-xs-4" style="padding:0">'+
                '<input type="text" class="form-control header-tag" value="" placeholder="Tag">'+
            '</div>'+
            '<div class="col-xs-1 text-center" style="padding:1% 0 0 0">=></div>'+
            '<div class="col-xs-4" style="padding:0">'+
                '<input type="text" class="form-control detail-tag" value="" placeholder="Sub Tag">'+
            '</div>'+
            '<div class="col-xs-2 text-center editor-panel" style="padding-top:0.5%">'+
                '<a href="#" class="fa fa-check check-tag" style="margin:0 3%"></a>'+
                '<a href="#" class="fa fa-pencil edit-tag hidden" style="margin:0 3%"></a>'+
                '<a href="#" class="fa fa-trash delete-tag" style="margin:0 3%"></a>'+
            '</div>'+
        '</div>';
        $('#myModalDetailItem').find('#tag').find('.tag-content').append(string);
        updateAutocompleteTag();
    });

    // LOGIC KLIK TOMBOL DELETE TAG
    // ----------------------------
    $('#myModalDetailItem').find('#tag').on('click', 'a.delete-tag', function(event) {
        $(this).closest('.tag-wrapper').remove();
    });

    // LOGIC KLIK TOMBOL SUBMIT
    // ------------------------
    $('#submit-item-btn').on('click', function(event) {
        event.preventDefault();
        // $(this).closest('.modal').find('.content').addClass('hidden');
        // $(this).closest('.modal').find('.loading-div').removeClass('hidden');

        //validasi pake ajax (karena benar2 butuh cek ke database)
        var datastring = "item_id="+$(this).closest('.modal').find('input.item-id').val();
        datastring += "&item_code="+$('#general').find('input[name="item_code"]').val();
        datastring += "&item_name="+$('#general').find('input[name="item_name"]').val();
        datastring += "&item_category="+$('#general').find('input[name="item_category"]').val();
        datastring += "&item_sub_category="+$('#general').find('input[name="item_sub_category"]').val();
        var sizeArray = [$('#general').find('input[name="item_length"]').val(), $('#general').find('input[name="item_width"]').val(), $('#general').find('input[name="item_thick"]').val()];
        datastring += "&item_size="+JSON.stringify(sizeArray);
        datastring += "&pcs_per_box="+$('#general').find('input[name="pcs_per_box"]').val();
        datastring += "&price_per_m2="+$('#general').find('input[name="price_m2"]').val();
        datastring += "&brand="+$('#general').find('input[name="brand"]').val();
        datastring += "&calc="+$('#general').find('select[name="calc"]').val();
        datastring += "&installation="+$('#general').find('input[name="installation"]').val();
        datastring += "&fee="+$('#general').find('input[name="fee"]').val();
        datastring += "&addon="+$('#general').find('select[name="addon"]').val();
        if($('#general').find('select[name="addon"]').val() == 'Ya') {
            var addonArray = {
                addon1: $('#general').find('input[name="addon1"]').val(),
                addon1desc: $('#general').find('textarea[name="addon1desc"]').val(),
                addon2: $('#general').find('input[name="addon2"]').val(),
                addon2desc: $('#general').find('textarea[name="addon2desc"]').val(),
                addon3: $('#general').find('input[name="addon3"]').val(),
                addon3desc: $('#general').find('textarea[name="addon3desc"]').val(),
                addoncta: $('#general').find('input[name="addoncta"]').val(),
                addontitle: $('#general').find('input[name="addontitle"]').val(),
            };
            datastring += "&addon_data="+JSON.stringify(addonArray);
        }
        var imageArray = {
            image1: $('#img').find('td.img1').find('img.curr-img').attr('src').split('/small/')[1],
            image2: $('#img').find('td.img2').find('img.curr-img').attr('src').split('/small/')[1],
            image3: $('#img').find('td.img3').find('img.curr-img').attr('src').split('/small/')[1]
        }
        datastring += "&img_data="+JSON.stringify(imageArray);
        var tagArray = [];
        $('#tag').find('.tag-wrapper').each(function() {
            tagArray.push(
                [$(this).find('.header-tag').val(), $(this).find('.detail-tag').val()]
            );
        });
        datastring += "&tag_data="+JSON.stringify(tagArray);
        // console.log(datastring);
        // aa;
        $.ajax({
            type: "POST",
            url: '/depotile/admin/item-manager/itemFormValidation.php',
            data: datastring,
            success: function(data) {
                $('#myModalDetailItem').find('.content').removeClass('hidden');
                $('#myModalDetailItem').find('.loading-div').addClass('hidden');
                if(data == 'PASS') {
                    $('#item-form').find('input[name="item_id"]').val($('#myModalDetailItem').find('input.item-id').val());
                    $('#item-form').find('input[name="item_code"]').val($('#myModalDetailItem').find('input[name="item_code"]').val());
                    $('#item-form').find('input[name="item_name"]').val($('#myModalDetailItem').find('input[name="item_name"]').val());
                    $('#item-form').find('input[name="item_category"]').val($('#myModalDetailItem').find('input[name="item_category"]').val());
                    $('#item-form').find('input[name="item_sub_category"]').val($('#myModalDetailItem').find('input[name="item_sub_category"]').val());
                    $('#item-form').find('input[name="item_desc"]').val(tinymce.activeEditor.getContent({format : 'raw'}));
                    var sizeArray = [$('#general').find('input[name="item_length"]').val(), $('#general').find('input[name="item_width"]').val(), $('#general').find('input[name="item_thick"]').val()];
                    $('#item-form').find('input[name="item_size"]').val(JSON.stringify(sizeArray));
                    $('#item-form').find('input[name="pcs_per_box"]').val($('#myModalDetailItem').find('input[name="pcs_per_box"]').val());
                    $('#item-form').find('input[name="price_per_m2"]').val($('#myModalDetailItem').find('input[name="price_m2"]').val());
                    $('#item-form').find('input[name="brand"]').val($('#myModalDetailItem').find('input[name="brand"]').val());
                    $('#item-form').find('input[name="calc"]').val($('#myModalDetailItem').find('input[name="calc"]').val());
                    $('#item-form').find('input[name="installation"]').val($('#myModalDetailItem').find('input[name="installation"]').val());
                    $('#item-form').find('input[name="fee"]').val($('#myModalDetailItem').find('input[name="fee"]').val());
                    $('#item-form').find('input[name="addon"]').val($('#myModalDetailItem').find('input[name="addon"]').val());
                    if($('#general').find('select[name="addon"]').val() == 'Ya') {
                        var addonArray = {
                            addon1: $('#general').find('input[name="addon1"]').val(),
                            addon1desc: $('#general').find('textarea[name="addon1desc"]').val(),
                            addon2: $('#general').find('input[name="addon2"]').val(),
                            addon2desc: $('#general').find('textarea[name="addon2desc"]').val(),
                            addon3: $('#general').find('input[name="addon3"]').val(),
                            addon3desc: $('#general').find('textarea[name="addon3desc"]').val(),
                            addoncta: $('#general').find('input[name="addoncta"]').val(),
                            addontitle: $('#general').find('input[name="addontitle"]').val(),
                        };
                        $('#item-form').find('input[name="addon_data"]').val(JSON.stringify(addonArray));
                    }
                    var imageArray = {
                        image1: $('#img').find('td.img1').find('img.curr-img').attr('src').split('/small/')[1],
                        image2: $('#img').find('td.img2').find('img.curr-img').attr('src').split('/small/')[1],
                        image3: $('#img').find('td.img3').find('img.curr-img').attr('src').split('/small/')[1]
                    }
                    $('#item-form').find('input[name="img_data"]').val(JSON.stringify(imageArray));
                    var tagArray = [];
                    $('#tag').find('.tag-wrapper').each(function() {
                        tagArray.push(
                            [$(this).find('.header-tag').val(), $(this).find('.detail-tag').val()]
                        );
                    });
                    $('#item-form').find('input[name="tag_data"]').val(JSON.stringify(tagArray));
                    $('#item-form').submit();
                }else {
                    $('#myModalDetailItem').find('.error-msg').html(data.toUpperCase());
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert('error');
            }
        });
        // alert(tinymce.activeEditor.getContent({format : 'raw'}));
    });
});