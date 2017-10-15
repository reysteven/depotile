$(document).ready(function() {
	$('#add-tag-form').on('submit', function(event) {
		var name = $(this).find('input[name="tag_name"]').val();
		if(name == null || name == "") {
			event.preventDefault();
			alert('Please input tag name');
		}
	});

	$('.edit-tag-name-link').on('click', function(event) {
		event.preventDefault();
		$(this).addClass('hidden');
		$(this).closest('div').find('.submit-tag-name-link').removeClass('hidden');
		$(this).closest('.form-group').find('input.tag-name-input').prop('disabled', false);
	});

	$('input.tag-name-input').on('keyup', function(event) {
		var value = $(this).val();
		var id = $(this).data('id');
		$('#tag-list-table').find('.tag-name-col').each(function() {
			var currId = $(this).data('id');
			if(currId == id) {
				$(this).html(value);
			}
		});
	});

	$('.submit-tag-name-link').on('click', function(event) {
		event.preventDefault();
		var name = $(this).closest('.form-group').find('input.tag-name-input').val();
		var id = $(this).data('id');
		var link = $(this);
		if(name == null || name == "") {
			alert('Please input tag name');
		}else {
			$(this).addClass('hidden');
			$(this).closest('div').find('.loading-div').removeClass('hidden');
			$(this).closest('.form-group').find('input.tag-name-input').prop('disabled', true);
			$.ajax({
                type: "POST",
                url: $('#edit-tag-link').val(),
                data: "_token="+$('input[name="ajax_token"]').val()+"&id="+id+"&name="+name,
                success: function(data) {
                    link.closest('div').find('.loading-div').addClass('hidden');
                    link.closest('div').find('.edit-tag-name-link').removeClass('hidden');
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    alert('error');
                    $('#html-error-msg').html(JSON.stringify(jqXHR));
                }
            });
		}
	});

	$('#myModalDelTagConfirmation').on('show.bs.modal', function(event) {
		var button = $(event.relatedTarget);
        var type = button.data('type');
        $(this).find('input[name="type"]').val(type);
        if(type == "single") {
            var id = button.data('id');
            $(this).find('input[name="id"]').val(id);
        }
	});

	$('#myModalDelTagConfirmation').find('input[name="delTagConfirmButton"]').on('click', function(event) {
        var type = $(this).closest('div').find('input[name="type"]').val();
        if(type == "single") {
            var id = $(this).closest('div').find('input[name="id"]').val();
            var data = [];
            var tempData = {
                id : id
            }
            data.push(tempData);
            $('#delete-tag-form').find('input[name="data"]').val(JSON.stringify(data));
            $('#delete-tag-form').submit();
        }else {
            var data = [];
            $('#tag-list-table').find('tr').each(function() {
                var check = $(this).find('input.checkthis').prop('checked');
                if(check == true) {
                    var dataTemp = {
                        id : $(this).find('input.checkthis').data('id')
                    }
                    data.push(dataTemp);
                }
            });
            $('#delete-tag-form').find('input[name="data"]').val(JSON.stringify(data));
            $('#delete-tag-form').submit();
        }
    });

    $('.img-item-link').on('click', function(event) {
        event.preventDefault();
        var img = $(this).find('img').attr('src');
        $(this).closest('.img-list').addClass('hidden');
        $(this).closest('.col-xs-12').find('input[name="curr-img"]').val(img.split('/tag-icon/')[1]);
        $(this).closest('.col-xs-12').find('.curr-img').attr('src', img);
        $(this).closest('.col-xs-12').find('.curr-img').removeClass('hidden');
        $(this).closest('.col-xs-12').find('.change-img-btn').removeClass('hidden');
    });

    $('.change-img-btn').on('click', function(event) {
        $(this).addClass('hidden');
        $(this).closest('form').find('.curr-img').addClass('hidden');
        $(this).closest('form').find('.img-list').removeClass('hidden');
    });

    $('#myModalAddSubTag').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget);
        var type = button.data('type');
        var modal = $(this);
        if(type == 'add') {
            var id = button.data('id');
            modal.find('.title').html('Add Sub Tag');
            modal.find('input[name="tag_id"]').val(id);
            modal.find('input[name="sub_tag_name"]').val('');
            modal.find('input[name="sub_tag_cta"]').val('');
            modal.find('input[name="curr-img"]').val('');
            modal.find('form').attr('action', $('#add-sub-tag-link').val());
            modal.find('.img-list').removeClass('hidden');
            modal.find('.curr-img').addClass('hidden');            
        }else {
            modal.find('.title').html('Edit Sub Tag');
            modal.find('.content').addClass('hidden');
            modal.find('.loading-div').removeClass('hidden');
            modal.find('.img-list').addClass('hidden');
            modal.find('.curr-img').removeClass('hidden');
            var id = button.data('id');
            $.ajax({
                type: "POST",
                url: $('#get-sub-tag-data-link').val(),
                data: '_token='+$('input[name="ajax_token"]').val()+'&id='+id,
                success: function(data) {
                    // console.log(data);
                    var imgSrc = $('#img-icon-src').val();
                    var subtag = JSON.parse(data);
                    modal.find('input[name="sub_tag_id"]').val(id);
                    modal.find('input[name="sub_tag_name"]').val(subtag.detail_tag_name);
                    modal.find('input[name="sub_tag_cta"]').val(subtag.tag_cta);
                    modal.find('input[name="curr-img"]').val(subtag.icon);
                    modal.find('img.curr-img').attr('src', imgSrc+'/'+subtag.icon);
                    modal.find('input.change-img-btn').removeClass('hidden');

                    modal.find('form').attr('action', $('#edit-sub-tag-link').val());
                    modal.find('.content').removeClass('hidden');
                    modal.find('.loading-div').addClass('hidden');
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    $('#html-error-msg').html(JSON.stringify(jqXHR));
                    alert('error');
                }
            });
        }
    });

	$('form[name="add-sub-tag-form"]').on('submit', function(event) {
        event.preventDefault();
        var subTag = $(this).find('input[name="sub_tag_name"]').val();
        var tagId = $(this).data('id');
        if(subTag == null || subTag == "") {
            alert('Please input sub tag name');
        }else {
            $(this).find('input[name="sub_tag_name"]').prop('disabled', true);
            $(this).find('input[type="submit"]').addClass('hidden');
            $(this).find('.loading-div').removeClass('hidden');
            var form = $(this);
            $.ajax({
                type: "POST",
                url: $('#add-sub-tag-link').val(),
                data: "_token="+$('input[name="ajax_token"]').val()+"&tagId="+tagId+"&subTag="+subTag,
                success: function(data) {
                    form.find('input[name="sub_tag_name"]').prop('disabled', false);
                    form.find('input[type="submit"]').removeClass('hidden');
                    form.find('.loading-div').addClass('hidden');
                    form.closest('td').find('input.add-sub-tag-btn').click();
                    var id = data;
                    var string = ""+
                                '<tr>'+
                                    '<td class="text-center">'+id+'</td>'+
                                    '<td class="text-center">'+subTag+'</td>'+
                                    '<td class="text-center">'+
                                        '<a href="#" class="edit-sub-category-name-link" data-id="'+id+'" title="ubah" data-toggle="modal" data-target="#myModalEditSubTag">'+
                                            '<span class="fa fa-pencil"></span>'+
                                        '</a>'+
                                        '<a href="#" class="edit-sub-tag-name-link" data-id="'+id+'" title="hapus">'+
                                            '<span class="fa fa-trash"></span>'+
                                        '</a>'+
                                    '</td>'+
                                '<tr>';
                    form.closest('td').find('table[name="sub-tag-list-table"]').append(string);
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    alert('error');
                    $('#html-error-msg').html(JSON.stringify(jqXHR));
                }
            });
        }
    });

	$('form[name="edit-sub-tag-form"]').on('submit', function(event) {
		event.preventDefault();
		var name = $(this).find('input[name="detail_tag_name"]').val();
		if(name == null || name == "") {
			alert('Please input sub tag name');
		}else {
			var id = $(this).data('id');
			$(this).find('input[name="detail_tag_name"]').prop('disabled', true);
			$(this).find('input[type="submit"]').addClass('hidden');
			$(this).find('.loading-div').removeClass('hidden');
			var form = $(this);
			$.ajax({
                type: "POST",
                url: $('#edit-sub-tag-link').val(),
                data: "_token="+$('input[name="ajax_token"]').val()+"&detailId="+id+"&subTag="+name,
                success: function(data) {
                    form.find('input[name="detail_tag_name"]').prop('disabled', false);
					form.find('input[type="submit"]').removeClass('hidden');
					form.find('.loading-div').addClass('hidden');
					form.closest('tr').find('.edit-sub-tag-name-section').addClass('hidden');
					form.closest('tr').find('.sub-tag-name-col').html(name);
					form.closest('tr').find('.sub-tag-name-col').removeClass('hidden');
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    alert('error');
                    $('#html-error-msg').html(JSON.stringify(jqXHR));
                }
            });
		}
	});

	$('#myModalDelSubTagConfirmation').on('show.bs.modal', function(event) {
		var button = $(event.relatedTarget);
        var id = button.data('id');
        $(this).find('input[name="id"]').val(id);
	});

	$('#myModalDelSubTagConfirmation').find('input[name="delSubTagConfirmButton"]').on('click', function(event) {
        var id = $(this).closest('div').find('input[name="id"]').val();
        var data = [];
        var tempData = {
            id : id
        }
        data.push(tempData);
        var button = $(this)
        button.closest('div').addClass('hidden');
        button.find('.loading-div').removeClass('hidden');
        $.ajax({
            type: "POST",
            url: $('#del-sub-tag-link').val(),
            data: "_token="+$('input[name="ajax_token"]').val()+"&detailId="+id,
            success: function(data) {
                $('.sub-tag-name-col').each(function() {
                	var subtagId = $(this).data('id');
                	if(subtagId == id) {
                		$(this).closest('tr').remove();
                		button.closest('div').addClass('hidden');
        				button.find('.loading-div').removeClass('hidden');
        				button.closest('.modal').modal('hide');
                	}
                });
            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert('error');
                $('#html-error-msg').html(JSON.stringify(jqXHR));
            }
        });
    });

    $('input[name="changeShowedTagConfirmButton"]').on('click', function(event) {
        $('#showed-tag-form').submit();
    });

});