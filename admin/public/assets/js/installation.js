$(document).ready(function() {
	$('#myModalAddInstallation').on('show.bs.modal', function(event) {
		var button = $(event.relatedTarget);
		var type = button.data('type');
		var modal = $(this);
		modal.find('input[name="installation_name"]').val("");
		modal.find('textarea[name="installation_desc"]').val("");
		tinymce.activeEditor.setContent("");
		modal.find('.content').addClass('hidden');
		modal.find('.loading-div').removeClass('hidden');
		if(type == 'add') {
			modal.find('.title').html('Add Installation');
			modal.find('form').prop('action', $('#add-installation-link').val())
			modal.find('input[type="text"], textarea').val('');
			modal.find('.content').removeClass('hidden');
			modal.find('.loading-div').addClass('hidden');
		}else {
			modal.find('.title').html('Edit Installation');
			modal.find('form').prop('action', $('#edit-installation-link').val())
			var id = button.data('id');
			$.ajax({
	            type: "POST",
	            url: $('#get-installation-link').val(),
	            data: "_token="+$('input[name="ajax_token"]').val()+"&installation-id="+id,
	            success: function(data) {
	            	modal.find('input[name="installation_id"]').val(id);
	                var installationData = JSON.parse(data);
	                modal.find('input[name="installation_name"]').val(installationData.installation_name);
	                modal.find('textarea[name="installation_desc"]').val(installationData.installation_desc);
	                tinymce.activeEditor.setContent(installationData.installation_desc);
	                modal.find('.content').removeClass('hidden');
					modal.find('.loading-div').addClass('hidden');
	            },
	            error: function(jqXHR, textStatus, errorThrown) {
	                alert('error');
	            }
	        });
		}
	});

	$('#installation-form').on('submit', function(event) {
		// event.preventDefault();
		var valid = true;
		var desc = tinymce.activeEditor.getContent({format : 'raw'});
		if(desc == "" || desc == null) {
			valid = false;
		}
		if(valid == false) {
			event.preventDefault();
			alert('Please input data completely');
		}else {
			$(this).find('textarea[name="installation_desc"]').val(desc);
		}
	});

	$('#myModalDelInstallationConfirmation').on('show.bs.modal', function(event) {
		var button = $(event.relatedTarget);
		var type = button.data('type');
		$(this).find('input[name="type"]').val(type);
		if(type == 'single') {
			var id = button.data('id');
			$(this).find('input[name="id"]').val(id);
		}
	});

	$('input[name="delInstallationConfirmButton"]').on('click', function(event) {
		var type = $(this).closest('.modal').find('input[name="type"]').val();
		var data = [];
		if(type == 'single') {
			var id = $(this).closest('.modal').find('input[name="id"]').val();
			var array = {
				id: id
			}
			data.push(array);
		}else {
			$('#installation-list-table').find('.checkthis').each(function() {
				if($(this).prop('checked') == true) {
					var array = {
						id: $(this).data('id')
					};
					data.push(array);
				}
			});
		}
		$('#delete-installation-form').find('input[name="data"]').val(JSON.stringify(data));
		$('#delete-installation-form').submit();
	});
});