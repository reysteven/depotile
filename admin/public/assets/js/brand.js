$(document).ready(function() {
	$('#myModalAddBrand').on('show.bs.modal', function(event) {
		$(this).find('input[name="brand-name"]').val("");
		$(this).find('.logo_img').attr('src', $(this).find('.logo_img').data('default'));
		var button = $(event.relatedTarget);
		var type = button.data('type');
		if(type == 'edit') {
			$(this).find('.content').addClass('hidden');
			$(this).find('.loading-div').removeClass('hidden');
			var id = button.data('id');
			var editurl = $('#edit-brand-link').val();
			$(this).find('form').attr('action', editurl);
			var modal = $(this);
			$.ajax({
	            type: "POST",
	            url: $('#get-brand-data-link').val(),
	            data: "_token="+$('input[name="ajax_token"]').val()+"&brand-id="+id,
	            success: function(data) {
	            	modal.find('input[name="brand_id"]').val(id);
	                var brandData = JSON.parse(data);
	                var imgurl = modal.find('.logo_img').data('url')+'/'+brandData.brand_logo;
	                modal.find('input[name="brand_name"]').val(brandData.brand_name);
	                modal.find('.logo_img').attr('src', imgurl);
	                modal.find('.content').removeClass('hidden');
					modal.find('.loading-div').addClass('hidden');
	            },
	            error: function(jqXHR, textStatus, errorThrown) {
	                alert('error');
	            }
	        });
		}
	});

	$('.logo-img-item-link').on('click', function(event) {
		var value = $(this).data('value');
		var url = $('.logo_img').data('url')+'/';
		$('.logo_img').attr('src', url+value);
		$('input[name="logo_img"]').val(value);
	});

	$('#myModalDelBrandConfirmation').on('show.bs.modal', function(event) {
		var button = $(event.relatedTarget);
		var type = button.data('type');
		$(this).find('input[name="type"]').val(type);
		if(type == 'single') {
			var id = button.data('id');
			$(this).find('input[name="id"]').val(id);
		}
	});

	$('input[name="delBrandConfirmButton"]').on('click', function(event) {
		var type = $(this).closest('.modal').find('input[name="type"]').val();
		var data = [];
		if(type == 'single') {
			var id = $(this).closest('.modal').find('input[name="id"]').val();
			var array = {
				id: id
			}
			data.push(array);
		}else {
			$('#brand-list-table').find('.checkthis').each(function() {
				if($(this).prop('checked') == true) {
					var array = {
						id: $(this).data('id')
					};
					data.push(array);
				}
			});
		}
		$('#delete-brand-form').find('input[name="data"]').val(JSON.stringify(data));
		$('#delete-brand-form').submit();
	});
});