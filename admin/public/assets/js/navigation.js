$(document).ready(function() {
	$('.img-item-link').on('click', function(event) {
		event.preventDefault();
		var img = $(this).find('img').attr('src');
		$(this).closest('.img-list').addClass('hidden');
		$(this).closest('.col-xs-12').find('input[name="curr-img"]').val(img.split('/nav-image/')[1]);
		$(this).closest('.col-xs-12').find('.curr-img').attr('src', img);
		$(this).closest('.col-xs-12').find('.curr-img').removeClass('hidden');
		$(this).closest('.col-xs-12').find('.change-img-btn').removeClass('hidden');
	});

	$('.change-img-btn').on('click', function(event) {
		$(this).addClass('hidden');
		$(this).closest('form').find('.curr-img').addClass('hidden');
		$(this).closest('form').find('.img-list').removeClass('hidden');
	});

	$('button.add-tag-btn').on('click', function(event) {
		var tagData = JSON.parse($('#tag-data').val());
		var tagString = "";
		for(var i=0;i<tagData.length;i++) {
			tagString += '<option value="'+tagData[i].tag_name+'">'+tagData[i].tag_name+'</option>';
		}
		var string = ''+
        '<div class="col-xs-12 tag-wrapper" style="margin-bottom:2%">'+
            '<div class="col-xs-1" style="padding:0.5% 0 0 0">'+
                '<span class="fa fa-circle" style="font-size:10px"></span>'+
            '</div>'+
            '<div class="col-xs-4" style="padding:0">'+
                '<select class="form-control" name="header-tag[]">'+
                	'<option class="hidden">Choose tag</option>'+
                	tagString+
                '</select>'+
            '</div>'+
            '<div class="col-xs-1 text-center" style="padding:1% 0 0 0">=></div>'+
            '<div class="col-xs-4" style="padding:0">'+
                '<select class="form-control" name="detail-tag[]" disabled>'+
                	'<option class="hidden">Choose tag first</option>'+
                '</select>'+
            '</div>'+
            '<div class="col-xs-2 text-center editor-panel" style="padding-top:0.5%">'+
                '<a href="#" class="fa fa-trash delete-tag" style="margin:0 3%"></a>'+
            '</div>'+
        '</div>';
        $(this).closest('.tab-pane').find('.tag-content').append(string);
	});

	$(this).on('change', 'select[name="header-tag[]"]', function(event) {
		$(this).closest('.tag-wrapper').find('select[name="detail-tag[]"]').prop('disabled', true);
		var tag = $(this).val();
		var tagData = JSON.parse($('#tag-data').val());
		var detailTagString = '<option class="hidden">Choose sub tag</option>';
		for(var i=0;i<tagData.length;i++) {
			if(tagData[i].tag_name == tag) {
				for(var j=0;j<tagData[i].detail_tag.length;j++) {
					detailTagString += '<option value="'+tagData[i].detail_tag[j]+'">'+tagData[i].detail_tag[j]+'</option>';
				}
			}
		}
		$(this).closest('.tag-wrapper').find('select[name="detail-tag[]"]').html(detailTagString);
		$(this).closest('.tag-wrapper').find('select[name="detail-tag[]"]').prop('disabled', false);
	});

	$('#myModalAddNavigation').on('show.bs.modal', function(event) {
		var button = $(event.relatedTarget);
		var type = button.data('type');
		var modal = $(this);
		if(type == 'add') {
			modal.find('input[name="name"]').val('');
			modal.find('input[type="radio"]').each(function() {
				$(this).prop('selected', false);
			});
			modal.find('input[name="curr-img"]').val('');
			modal.find('form').attr('action', $('#addNavigationLink').val());
			modal.find('.img-list').removeClass('hidden');
			modal.find('.curr-img').addClass('hidden');
			$('#tag').find('.tag-content').html('');
		}else {
			modal.find('.content').addClass('hidden');
			modal.find('.loading-div').removeClass('hidden');
			modal.find('.img-list').addClass('hidden');
			modal.find('.curr-img').removeClass('hidden');
			var id = button.data('id');
			$.ajax({
			    type: "POST",
			    url: $('#getNavigationDataLink').val(),
			    data: '_token='+$('input[name="ajax_token"]').val()+'&id='+id,
			    success: function(data) {
			        // console.log(data);
			        var imgSrc = $('#imgSrcLink').val();
			        var nav = JSON.parse(data);
			        modal.find('input[name="id"]').val(nav.id);
			        modal.find('input[name="name"]').val(nav.navigation_name);
			        modal.find('input[name="relation"]').each(function() {
			        	if($(this).attr('value') == nav.relation) {
			        		$(this).prop('checked', true);
			        	}
			        });
			        modal.find('input[name="curr-img"]').val(nav.img_name);
			        modal.find('img.curr-img').attr('src', imgSrc+'/'+nav.img_name);
			        modal.find('input.change-img-btn').removeClass('hidden');

			        var tagData = JSON.parse($('#tag-data').val());
			        var headeropt = "";
			        var detailopt = "";
			        var string = "";
			        for(var i=0;i<nav.detail_navigation.length;i++) {
			        	for(var j=0;j<tagData.length;j++) {
				        	if(tagData[j].tag_name == nav.detail_navigation[i].tag_name) {
	                            headeropt += '<option value="'+tagData[j].tag_name+'" selected>'+tagData[j].tag_name+'</option>';
	                            for(var k=0;k<tagData[j].detail_tag.length;k++) {
	                                if(tagData[j].detail_tag[k] == nav.detail_navigation[i].detail_tag_name) {
	                                    detailopt += '<option value="'+tagData[j].detail_tag[k]+'" selected>'+tagData[j].detail_tag[k]+'</option>';
	                                }else {
	                                    detailopt += '<option value="'+tagData[j].detail_tag[k]+'">'+tagData[j].detail_tag[k]+'</option>';
	                                }
	                            }
	                        }else {
	                            headeropt += '<option value="'+tagData[j].tag_name+'">'+tagData[j].tag_name+'</option>';
	                        }
				        }
			        	string += ''+
                        '<div class="col-xs-12 tag-wrapper" style="margin-bottom:2%">'+
                            '<div class="col-xs-1" style="padding:0.5% 0 0 0">'+
                                '<span class="fa fa-circle" style="font-size:10px"></span>'+
                            '</div>'+
                            '<div class="col-xs-4" style="padding:0">'+
                                '<select class="form-control" name="header-tag[]" value="'+nav.detail_navigation[i]['tag_name']+'">'+
                                    '<option class="hidden">Choose category</option>'+
                                    headeropt+
                                '</select>'+
                            '</div>'+
                            '<div class="col-xs-1 text-center" style="padding:1% 0 0 0">=></div>'+
                            '<div class="col-xs-4" style="padding:0">'+
                                '<select class="form-control" name="detail-tag[]" value="'+nav.detail_navigation[i]['detail_tag_name']+'">'+
                                    '<option class="hidden">Choose sub category</option>'+
                                    detailopt+
                                '</select>'+
                            '</div>'+
                            '<div class="col-xs-2 text-center editor-panel" style="padding-top:0.5%">'+
                                '<a href="#" class="fa fa-trash delete-tag" style="margin:0 3%"></a>'+
                            '</div>'+
                        '</div>';
			        }
			        modal.find('#tag').find('.tag-content').html(string);

			        modal.find('form').attr('action', $('#editNavigationLink').val());
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

	$(this).on('click', 'a.delete-tag', function(event) {
		event.preventDefault();
		$(this).closest('.tag-wrapper').remove();
	});

	$('#myModalDelNavigationConfirmation').on('show.bs.modal', function(event) {
		var button = $(event.relatedTarget);
		var type = button.data('type');
		$(this).find('input[name="type"]').val(type);
		if(type == 'single') {
			var id = button.data('id');
			$(this).find('input[name="id"]').val(id);
		}
	});

	$('input[name="delNavigationConfirmButton"]').on('click', function(event) {
		var type = $(this).closest('.modal').find('input[name="type"]').val();
		var data = [];
		if(type == 'single') {
			var id = $(this).closest('.modal').find('input[name="id"]').val();
			var array = {
				id : id
			}
			data.push(array);
		}else {
			$('#navigation-list-table').find('.checkthis').each(function() {
				if($(this).prop('checked') == true) {
					var array = {
						id : $(this).data('id')
					}
					data.push(array);
				}
			});
		}
		$('#del-navigation-form').find('input[name="data"]').val(JSON.stringify(data));
		$('#del-navigation-form').submit();
	});
});