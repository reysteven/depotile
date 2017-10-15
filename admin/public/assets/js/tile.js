$(document).ready(function() {
    $('#tile-list-table').dataTable({
        "aLengthMenu": [[5,10,25,50,100,-1], [5,10,25,50,100,"All"]],
        "paging": true,
        "searching": false
    });

    $('#tile-search-form').on('submit', function(event) {
        $(this).find('select[name="search-sub-category"]').prop('disabled', false);
    });

    $('select[name="search_category"]').on('change', function(event) {
        var category = $(this).val();
        var categoryData = JSON.parse($('#categoryData').val());
        var string = '<option class="hidden">Choose sub category</option>';
        for(var i=0;i<categoryData.length;i++) {
            if(categoryData[i].category_name == category) {
                for(var j=0;j<categoryData[i].detail_category.length;j++) {
                    string += '<option value="'+categoryData[i].detail_category[j]+'">'+categoryData[i].detail_category[j]+'</option>';
                }
                break;
            }
        }
        $('select[name="search_sub_category"]').html(string);
        $('select[name="search_sub_category"]').prop('disabled', false);
    });

    $('#price_m2').autoNumeric('init', {
        aSep: '.',
        aDec: ',',
        aSign: 'Rp '
    });

    $('#length, #width, #thickness, #pc_per_box, #addon1, #addon2, #addon3').autoNumeric('init', {
        aSep: '.',
        aDec: ',',
    });

    $('#myModalDetailTile').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget);
        var id = button.data('id');
        var type = button.data('type');
        var modal = $(this);
        modal.find('.content').addClass('hidden');
        modal.find('.loading-div').removeClass('hidden');
        var categoryData = JSON.parse($('#categoryData').val());

        // atur semua fitur autocomplete
        var brandData = JSON.parse($('#brandData').val());
        var brandAC = [];
        for(var i=0;i<brandData.length;i++) {
            brandAC.push(brandData[i].brand_name);
        }
        // console.log(JSON.stringify(brandAC));
        modal.find('input[name="brand"]').autocomplete({
            source: brandAC,
            appendTo: '#myModalDetailTile'
        });

        var installationData = JSON.parse($('#installationData').val());
        var installationAC = [];
        for(var i=0;i<installationData.length;i++) {
            installationAC.push(installationData[i].installation_name);
        }
        modal.find('input[name="installation"]').autocomplete({
            source: installationAC,
            appendTo: '#myModalDetailTile'
        });

        var feeData = JSON.parse($('#feeData').val());
        var feeAC = [];
        for(var i=0;i<feeData.length;i++) {
            feeAC.push(feeData[i].fee_name);
        }
        modal.find('input[name="fee"]').autocomplete({
            source: feeAC,
            appendTo: '#myModalDetailTile'
        });

        $.ajax({
            type: "POST",
            url: $('#getTileDataLink').val(),
            data: '_token='+$('input[name="ajax_token"]').val()+'&id='+id,
            success: function(data) {
                console.log(id);

                modal.find('input[name="item_id"]').val(id);

                // isi data ke tag general
                var tile = JSON.parse(data);
                modal.find('input[name="id"]').val(id);
                modal.find('input[name="code"]').val(tile.item_code);
                modal.find('input[name="name"]').val(tile.item_name);
                modal.find('select[name="category"]').val(tile.category_name);
                var string = '<option class="hidden">Choose item sub category</option>';
                for(var i=0;i<categoryData.length;i++) {
                    if(categoryData[i].category_name == tile.category_name) {
                        for(var j=0;j<categoryData[i].detail_category.length;j++) {
                            if(categoryData[i].detail_category[j] == tile.detail_category_name) {
                                string += '<option value="'+categoryData[i].detail_category[j]+'" selected>'+categoryData[i].detail_category[j]+'</option>';
                            }else {
                                string += '<option value="'+categoryData[i].detail_category[j]+'">'+categoryData[i].detail_category[j]+'</option>';
                            }
                        }
                    }
                }
                modal.find('select[name="sub_category"]').html(string);
                modal.find('input[name="length"]').val(tile.length);
                modal.find('input[name="width"]').val(tile.width);
                modal.find('input[name="thickness"]').val(tile.thickness);
                modal.find('input[name="pc_per_box"]').val(tile.pcs_per_box);
                modal.find('input[name="price_m2"]').val(tile.price_per_m2);
                modal.find('input[name="brand"]').val(tile.brand_name);
                modal.find('select[name="calc"]').val(tile.calculator);
                modal.find('input[name="installation"]').val(tile.installation_name);
                modal.find('input[name="fee"]').val(tile.fee_name);
                modal.find('textarea[name="description"]').val(tile.description);
                modal.find('select[name="addon"]').val(tile.add_on);

                if(tile.add_on == 1) { /*tampilkan bagian add on jika memang menggunakan add on*/
                    $('#add-on-detail').collapse('show');
                    modal.find('input[name="addon1"]').val(tile.add_on_1);
                    modal.find('textarea[name="addon1desc"]').val(tile.add_on_description_1);
                    modal.find('input[name="addon2"]').val(tile.add_on_2);
                    modal.find('textarea[name="addon2desc"]').val(tile.add_on_description_2);
                    modal.find('input[name="addon3"]').val(tile.add_on_3);
                    modal.find('textarea[name="addon3desc"]').val(tile.add_on_description_3);
                    modal.find('input[name="addoncta"]').val(tile.add_on_cta);
                    modal.find('input[name="addontitle"]').val(tile.add_on_title);
                }

                // isi data ke tab gambar
                var imgsrc = $('#getImageLink').val();
                modal.find('.img1').find('.curr-img').attr('src', imgsrc+'/small/'+tile.img_name1);
                modal.find('.img2').find('.curr-img').attr('src', imgsrc+'/small/'+tile.img_name2);
                modal.find('.img3').find('.curr-img').attr('src', imgsrc+'/small/'+tile.img_name3);
                modal.find('.img1').find('input[name="img_name[]"]').val(tile.img_name1);
                modal.find('.img2').find('input[name="img_name[]"]').val(tile.img_name2);
                modal.find('.img3').find('input[name="img_name[]"]').val(tile.img_name3);

                // isi data ke tab tag
                var string = '';
                var allTagData = JSON.parse($('#tagData').val());
                var tagData = JSON.parse(tile.detail_tag_data);
                var headeropt = "";
                var detailopt = "";
                for(var i=0;i<tagData.length;i++) {
                    for(var j=0;j<allTagData.length;j++) {
                        if(allTagData[j].tag_name == tagData[i].tag_name) {
                            headeropt += '<option value="'+allTagData[j].tag_name+'" selected>'+allTagData[j].tag_name+'</option>';
                            for(var k=0;k<allTagData[j].detail_tag.length;k++) {
                                if(allTagData[j].detail_tag[k] == tagData[i].detail_tag_name) {
                                    detailopt += '<option value="'+allTagData[j].detail_tag[k]+'" selected>'+allTagData[j].detail_tag[k]+'</option>';
                                }else {
                                    detailopt += '<option value="'+allTagData[j].detail_tag[k]+'">'+allTagData[j].detail_tag[k]+'</option>';
                                }
                            }
                        }else {
                            headeropt += '<option value="'+allTagData[j].tag_name+'">'+allTagData[j].tag_name+'</option>';
                        }
                    }
                    string += ''+
                        '<div class="col-xs-12 tag-wrapper" style="margin-bottom:2%">'+
                            '<div class="col-xs-1" style="padding:0.5% 0 0 0">'+
                                '<span class="fa fa-circle" style="font-size:10px"></span>'+
                            '</div>'+
                            '<div class="col-xs-4" style="padding:0">'+
                                '<select class="form-control" name="header-tag[]" value="'+tagData[i]['tag_name']+'">'+
                                    '<option class="hidden">Choose category</option>'+
                                    headeropt+
                                '</select>'+
                            '</div>'+
                            '<div class="col-xs-1 text-center" style="padding:1% 0 0 0">=></div>'+
                            '<div class="col-xs-4" style="padding:0">'+
                                '<select class="form-control" name="detail-tag[]" value="'+tagData[i]['detail_tag_name']+'">'+
                                    '<option class="hidden">Choose sub category</option>'+
                                    detailopt+
                                '</select>'+
                            '</div>'+
                            '<div class="col-xs-2 text-center editor-panel" style="padding-top:0.5%">'+
                                '<a href="#" class="fa fa-trash delete-tag" style="margin:0 3%"></a>'+
                            '</div>'+
                        '</div>';
                }
                $('#tag').find('.tag-content').html(string);

                if(type == 'detail') {
                    modal.find('select, input[type="text"], textarea').prop('disabled', true);
                    modal.find('.submit-section').addClass('hidden');
                    modal.find('.img1').closest('tr').find('.change-img').closest('td').addClass('hidden');
                    modal.find('.img2').closest('tr').find('.change-img').closest('td').addClass('hidden');
                    modal.find('.img3').closest('tr').find('.change-img').closest('td').addClass('hidden');
                    modal.find('.editor-panel').addClass('hidden');
                    modal.find('.change-img-head').addClass('hidden');
                    modal.find('.add-tag-btn').addClass('hidden');
                }else {
                    modal.find('select, input[type="text"], textarea').prop('disabled', false);
                    modal.find('input[name="id"]').prop('disabled', true);
                    modal.find('.submit-section').removeClass('hidden');
                    modal.find('.img1').closest('tr').find('.change-img').closest('td').removeClass('hidden');
                    modal.find('.img2').closest('tr').find('.change-img').closest('td').removeClass('hidden');
                    modal.find('.img3').closest('tr').find('.change-img').closest('td').removeClass('hidden');
                    modal.find('.editor-panel').removeClass('hidden');
                    modal.find('.add-tag-btn').removeClass('hidden');
                }
                modal.find('.content').removeClass('hidden');
                modal.find('.loading-div').addClass('hidden');
            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert('error');
                // $('#html-error-msg').html(JSON.stringify(jqXHR));
            }
        });
    });

    $('select[name="category"]').on('change', function(event) {
        var category = $(this).val();
        var categoryData = JSON.parse($('#categoryData').val());
        var valid = false;
        var string = '<option class="hidden">Choose item category first</option>';
        for(var i=0;i<categoryData.length;i++) {
            if(categoryData[i].category_name == category) {                
                valid = true;
                string = '<option class="hidden">Choose item sub category</option>';
                for(var j=0;j<categoryData[i].detail_category.length;j++) {
                    string += '<option value="'+categoryData[i].detail_category[j]+'">'+categoryData[i].detail_category[j]+'</option>';
                }
                break;
            }
        }
        $('select[name="sub_category"]').html(string);
        if(valid == true) {
            $('select[name="sub_category"]').prop('disabled', false);
        }else {
            $('select[name="sub_category"]').prop('disabled', true);
        }
    });

    $('.change-img').on('click', function(event) {
        event.preventDefault();
        $(this).closest('tr').find('.curr-img').addClass('hidden');
        $(this).closest('tr').find('.img-list').removeClass('hidden');
    });

    $('.img-item-link').on('click', function(event) {
        event.preventDefault();
        var imgsrc = $('#getImageLink').val();
        var name = $(this).data('name');
        $(this).closest('td').find('input[name="img_name[]"]').val(name);
        $(this).closest('td').find('.curr-img').attr('src', imgsrc+'/small/'+name);
        $(this).closest('td').find('.curr-img').removeClass('hidden');
        $(this).closest('td').find('.img-list').addClass('hidden');
    });

    $(this).on('change', 'select[name="header-tag[]"]', function(event) {
        var tag = $(this).val();
        var tagData = JSON.parse($('#tagData').val());
        for(var i=0;i<tagData.length;i++) {
            if(tagData[i].tag_name == tag) {
                var string = '<option class="hidden">Choose sub tag</option>';
                for(var j=0;j<tagData[i].detail_tag.length;j++) {
                    string += '<option value="'+tagData[i].detail_tag[j]+'">'+tagData[i].detail_tag[j]+'</option>';
                }
                $(this).closest('.tag-wrapper').find('select[name="detail-tag[]"]').html(string);
                $(this).closest('.tag-wrapper').find('select[name="detail-tag[]"]').prop('disabled', false);
                break;
            }
        }
    });

    $('.add-tag-btn').on('click', function(event) {
        var allTagData = JSON.parse($('#tagData').val());
        var headeropt = "";
        var detailopt = "";
        for(var i=0;i<allTagData.length;i++) {
            headeropt += '<option value="'+allTagData[i].tag_name+'">'+allTagData[i].tag_name+'</option>';
        }
        var string = ''+
        '<div class="col-xs-12 tag-wrapper" style="margin-bottom:2%">'+
            '<div class="col-xs-1" style="padding:0.5% 0 0 0">'+
                '<span class="fa fa-circle" style="font-size:10px"></span>'+
            '</div>'+
            '<div class="col-xs-4" style="padding:0">'+
                '<select class="form-control" name="header-tag[]">'+
                    '<option class="hidden">Choose category</option>'+
                    headeropt+
                '</select>'+
            '</div>'+
            '<div class="col-xs-1 text-center" style="padding:1% 0 0 0">=></div>'+
            '<div class="col-xs-4" style="padding:0">'+
                '<select class="form-control" name="detail-tag[]" disabled>'+
                    '<option class="hidden">Choose category first</option>'+
                '</select>'+
            '</div>'+
            '<div class="col-xs-2 text-center editor-panel" style="padding-top:0.5%">'+
                '<a href="#" class="fa fa-trash delete-tag" style="margin:0 3%"></a>'+
            '</div>'+
        '</div>';
        $('#tag').find('.tag-content').append(string);
    });

    $(this).on('click', '.delete-tag', function(event) {
        event.preventDefault();
        $(this).closest('.tag-wrapper').remove();
    });

    $('#myModalDelTileConfirmation').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget);
        type = button.data('type');
        $(this).find('input[name="type"]').val(type)
        if(type == 'single') {
            $(this).find('input[name="id"]').val(button.data('id'));
        }
    });

    $('input[name="delTileConfirmButton"]').on('click', function(event) {
        var type = $(this).closest('div').find('input[name="type"]').val();
        var data = [];
        if(type == "mass") {
            $('#tile-list-table').find('.checkthis').each(function() {
                if($(this).prop('checked') == true) {
                    var array = {
                        id: $(this).data('id')
                    }
                    data.push(array);
                }
            });
        }else {
            var id = $(this).closest('div').find('input[name="id"]').val();
            var array = {
                id: id
            }
            data.push(array);
        }
        $('#delete-tile-form').find('input[name="data"]').val(JSON.stringify(data));
        $('#delete-tile-form').submit();
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