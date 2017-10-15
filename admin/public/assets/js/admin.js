$(document).ready(function() {
	$('#myModalAddAdmin').on('show.bs.modal', function(event) {
		var button = $(event.relatedTarget);
		var type = button.data('type');
		var modal = $(this);
		modal.find('input[name="id"]').prop('disabled', true);
		modal.find('.content').addClass('hidden');
		modal.find('.loading-div').removeClass('hidden');
		if(type == 'add') {
			modal.find('.title').html('Add Admin');
			modal.find('.content').removeClass('hidden');
			modal.find('.loading-div').addClass('hidden');
			modal.find('form').attr('action', $('#addAdminLink').val());
		}else {
			var id = button.data('id');
			modal.find('form').attr('action', $('#editAdminLink').val());
			modal.find('.title').html('Edit Admin');
			// alert($('#getAdminDataLink').val()+'?_token='+$('input[name="ajax_token"]').val()+'&id='+id);
			$.ajax({
			    type: "POST",
			    url: $('#getAdminDataLink').val(),
			    data: '_token='+$('input[name="ajax_token"]').val()+'&id='+id,
			    success: function(data) {
			    	var user = JSON.parse(data);
			        modal.find('input[name="id"]').val(user.id);
			        modal.find('input[name="name"]').val(user.name);
			        modal.find('input[name="email"]').val(user.email);
			        modal.find('textarea[name="address"]').val(user.address);
			        modal.find('.content').removeClass('hidden');
					modal.find('.loading-div').addClass('hidden');
			    },
			    error: function(jqXHR, textStatus, errorThrown) {
			        alert('error');
			    }
			});
		}
	});

	$('#add-admin-form').on('submit', function(event) {
		var pass = $(this).find('input[name="password"]').val();
		var repass = $(this).find('input.retype-password').val();
		if(pass != repass) {
			event.preventDefault();
			alert('Please retype password correctly');
		}
	});
});