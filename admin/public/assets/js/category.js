function checkall(event) {
    var checkCond = $(event.target).prop('checked');
    $(event.target).closest('table').find('input[type="checkbox"]').each(function() {
        if(checkCond == true) {
            $(this).prop('checked', true);
        }else {
            $(this).prop('checked', false);
        }
    });
}
$(document).ready(function() {
    $('table').find('a').on('click', function(event) {
        event.preventDefault();
    });

    $('.checkthis').on('click', function(event) {
        var allcheck = true;
        $('input[name="checkthis"]').each(function() {
            if($(this).prop('checked') == false) {
                allcheck = false;
                return 0;
            }
        });
        $(this).closest('table').find('input.checkall').prop(allcheck);
    });

    $('#add-category-form').on('submit', function(event) {
        var name = $(this).find('input[name="category_name"]').val();
        if(name == null || name == "") {
            event.preventDefault();
            alert('Please input category name');
        }
    });

    $('#myModalDelCategoryConfirmation').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget);
        var type = button.data('type');
        $(this).find('input[name="type"]').val(type);
        if(type == "single") {
            var id = button.data('id');
            $(this).find('input[name="id"]').val(id);
        }
    });

    $('#myModalDelCategoryConfirmation').find('input[name="delCategoryConfirmButton"]').on('click', function(event) {
        var type = $(this).closest('div').find('input[name="type"]').val();
        if(type == "single") {
            var id = $(this).closest('div').find('input[name="id"]').val();
            var data = [];
            var tempData = {
                id : id
            }
            data.push(tempData);
            $('#delete-category-form').find('input[name="data"]').val(JSON.stringify(data));
            $('#delete-category-form').submit();
        }else {
            var data = [];
            $('#category-list-table').find('tr').each(function() {
                var check = $(this).find('input.checkthis').prop('checked');
                if(check == true) {
                    var dataTemp = {
                        id : $(this).find('input.checkthis').data('id')
                    }
                    data.push(dataTemp);
                }
            });
            $('#delete-category-form').find('input[name="data"]').val(JSON.stringify(data));
            $('#delete-category-form').submit();
        }
    });

    tinymce.init({ selector:'#sub-category-item-detail' });

    $('#myModalEditSubCategory').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget);
        var type = button.data('type');
        $(this).find('.loading-div').addClass('hidden');
        $(this).find('.content').removeClass('hidden');
        $(this).find('form').find('input[name="type"]').val(type);
        if(type == 'edit') {
            $(this).find('.loading-div').removeClass('hidden');
            $(this).find('.content').addClass('hidden');
            var id = button.data('id');
            var modal = $(this);
            $.ajax({
                type: "POST",
                url: $('#get-sub-category-data-link').val(),
                data: "_token="+$('input[name="ajax_token"]').val()+"&subCategoryId="+id,
                success: function(data) {
                    var subcategoryData = JSON.parse(data);
                    modal.find('input[name="sub_category_name"]').val(subcategoryData['detail_category_name']);
                    modal.find('input[name="sub_category_id"]').val(id);
                    tinymce.activeEditor.setContent(subcategoryData['description']);
                    $('#submit-sub-category-btn').attr('data-id', id);
                    modal.find('.loading-div').addClass('hidden');
                    modal.find('.content').removeClass('hidden');
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    alert('error');
                }
            });
        }else {
            var categoryId = button.data('id');
            $(this).find('form').find('input[name="category_id"]').val(categoryId);
        }
    });

    $('#submit-sub-category-btn').on('click', function(event) {
        var id = $(this).attr('data-id');
        var name = $(this).closest('.content').find('input[name="sub_category_name"]').val();
        var desc = tinymce.activeEditor.getContent({format : 'raw'});
        $('#edit-sub-category-form').find('input[name="id"]').val(id);
        $('#edit-sub-category-form').find('input[name="sub_category_name"]').val(name);
        $('#edit-sub-category-form').find('input[name="sub_category_desc"]').val(desc);
        $('#edit-sub-category-form').submit();
    });

    $('.edit-category-name-link').on('click', function(event) {
        event.preventDefault();
        $(this).closest('.form-group').find('input[type="text"]').prop('disabled', false);
        $(this).addClass('hidden');
        $(this).closest('div').find('.submit-category-name-link').removeClass('hidden');
    });

    $('.category-name-input').on('keyup', function(event) {
        var value = $(this).val();
        var id = $(this).data('id');
        $(this).closest('table').find('tr').each(function() {
            var currid = $(this).find('.category-name-col').data('id');
            if(currid == id) {
                $(this).find('.category-name-col').html(value);
            }
        });
    });

    $('.submit-category-name-link').on('click', function(event) {
        var name = $(this).closest('.form-group').find('input[type="text"]').val();
        var id = $(this).data('id');
        if(name == null || name == "") {
            alert("Please input category name");
        }else {
            $(this).closest('.form-group').find('input[type="text"]').prop('disabled', true);
            $(this).addClass('hidden');
            $(this).closest('div').find('.loading-div').removeClass('hidden');
            var link = $(this);
            $.ajax({
                type: "POST",
                url: $('#edit-category-link').val(),
                data: "_token="+$('input[name="ajax_token"]').val()+"&id="+id+"&name="+name,
                success: function(data) {
                    link.closest('div').find('.loading-div').addClass('hidden');
                    link.closest('div').find('.edit-category-name-link').removeClass('hidden');
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    alert('error');
                }
            });
        }
    });

    $('form[name="add-sub-category-form"]').on('submit', function(event) {
        event.preventDefault();
        var subCategory = $(this).find('input[name="sub_category_name"]').val();
        var categoryId = $(this).data('id');
        if(subCategory == null || subCategory == "") {
            alert('Please input sub category name');
        }else {
            $(this).find('input[name="sub_category_name"]').prop('disabled', true);
            $(this).find('input[type="submit"]').addClass('hidden');
            $(this).find('.loading-div').removeClass('hidden');
            var form = $(this);
            $.ajax({
                type: "POST",
                url: $('#add-sub-category-link').val(),
                data: "_token="+$('input[name="ajax_token"]').val()+"&categoryId="+categoryId+"&subcategory="+subCategory,
                success: function(data) {
                    form.find('input[name="sub_category_name"]').prop('disabled', false);
                    form.find('input[type="submit"]').removeClass('hidden');
                    form.find('.loading-div').addClass('hidden');
                    form.closest('td').find('input.add-sub-category-btn').click();
                    var id = data;
                    var string = ""+
                                '<tr>'+
                                    '<td class="text-center">'+id+'</td>'+
                                    '<td class="text-center">'+subCategory+'</td>'+
                                    '<td class="text-center">'+
                                        '<a href="#" class="edit-sub-category-name-link" data-id="'+id+'" title="ubah" data-toggle="modal" data-target="#myModalEditSubCategory">'+
                                            '<span class="fa fa-pencil"></span>'+
                                        '</a>'+
                                        '<a href="#" class="edit-sub-category-name-link" data-id="'+id+'" title="hapus">'+
                                            '<span class="fa fa-trash"></span>'+
                                        '</a>'+
                                    '</td>'+
                                '<tr>';
                    form.closest('td').find('table[name="sub-category-list-table"]').append(string);
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    alert('error');
                    $('#html-error-msg').html(JSON.stringify(jqXHR));
                }
            });
        }
    });

    $('#edit-sub-category-form').on('submit', function(event) {
        event.preventDefault();
        var name = $(this).find('input[name="sub_category_name"]').val();
        var cta = $(this).find('input[name="sub_category_cta"]').val();
        var desc = tinymce.activeEditor.getContent({format : 'raw'}).replace(/\&nbsp;/g,' ');
        var type = $(this).find('input[name="type"]').val();
        if(name == null || name == "") {
            alert('Please input sub category_name');
        }else {
            $(this).find('input[name="sub_category_name"]').prop('disabled', true);
            $(this).find('input[type="submit"]').prop('disabled', true);
            $(this).closest('.modal').find('.loading-div').removeClass('hidden');
            $(this).closest('.content').addClass('hidden');
            var form = $(this);
            // alert("_token="+$('input[name="ajax_token"]').val()+"&subcategoryId="+id+"&name="+name+"&desc="+desc);
            if(type == "edit") {
                var id = $(this).find('input[name="sub_category_id"]').val();
                $.ajax({
                    type: "POST",
                    url: $('#edit-sub-category-link').val(),
                    data: "_token="+$('input[name="ajax_token"]').val()+"&subcategoryId="+id+"&name="+name+"&desc="+desc,
                    success: function(data) {
                        alert('Sub category was edited successfully');
                        form.closest('.modal').modal('hide');
                        form.find('input[name="sub_category_name"]').prop('disabled', false);
                        form.find('input[type="submit"]').prop('disabled', false);
                        form.closest('.modal').find('.loading-div').addClass('hidden');
                        form.closest('.content').removeClass('hidden');
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        alert('error');
                        $('#html-error-msg').html(JSON.stringify(jqXHR));
                    }
                });
            }else {
                var categoryId = $(this).find('input[name="category_id"]').val();
                $.ajax({
                    type: "POST",
                    url: $('#add-sub-category-link').val(),
                    data: "_token="+$('input[name="ajax_token"]').val()+"&categoryId="+categoryId+"&name="+name+"&desc="+desc,
                    success: function(data) {
                        alert('Sub category was added successfully');
                        form.closest('.modal').modal('hide');
                        form.find('input[name="sub_category_name"]').prop('disabled', false);
                        form.find('input[type="submit"]').prop('disabled', false);
                        form.closest('.modal').find('.loading-div').addClass('hidden');
                        form.closest('.content').removeClass('hidden');
                        var id = data;
                        var string = '<tr>'+
                                        '<td class="text-center">'+id+'</td>'+
                                        '<td class="text-center">'+name+'</td>'+
                                        '<td class="text-center">'+
                                            '<a href="#" class="edit-sub-category-name-link" data-id="'+id+'" title="ubah" data-toggle="modal" data-target="#myModalEditSubCategory" data-type="edit">'+
                                                '<span class="fa fa-pencil"></span>'+
                                            '</a>'+
                                            '<a href="#" class="edit-sub-category-name-link" data-id="'+id+'" title="hapus">'+
                                                '<span class="fa fa-trash"></span>'+
                                            '</a>'+
                                        '</td>'+
                                    '</tr>';
                        $('#category-detail-'+categoryId).find('table').append(string);
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        alert('error');
                        $('#html-error-msg').html(JSON.stringify(jqXHR));
                    }
                });
            }
        }
    });

    $('#myModalDelSubCategoryConfirmation').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget);
        var id = button.data('id');
        $(this).find('input[name="id"]').val(id);
    });

    $('input[name="delSubCategoryConfirmButton"]').on('click', function(event) {
        var id = $(this).closest('div').find('input[name="id"]').val();
        var obj = $(this);
        $(this).closest('div').addClass('hidden');
        $(this).closest('.modal').find('.loading-div').removeClass('hidden');
        $.ajax({
            type: "POST",
            url: $('#del-sub-category-link').val(),
            data: "_token="+$('input[name="ajax_token"]').val()+"&id="+id,
            success: function(data) {
                alert('Sub category was deleted successfully');
                $('.del-sub-category-name-link').each(function() {
                    if($(this).data('id') == id) {
                        $(this).closest('tr').remove();
                    }
                });
                obj.closest('.modal').modal('hide');
                obj.closest('div').removeClass('hidden');
                obj.closest('.modal').find('.loading-div').addClass('hidden');
            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert('error');
                $('#html-error-msg').html(JSON.stringify(jqXHR));
            }
        });
    });

});