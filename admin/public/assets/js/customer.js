$(document).ready(function() {
	$('#myModalDetailCustomer').on('show.bs.modal', function(event) {
		var button = $(event.relatedTarget);
		var id = button.data('id');
		var type = button.data('type');
		var modal = $(this);
		$(this).find('.content').addClass('hidden');
		$(this).find('.loading-div').removeClass('hidden');
		$.ajax({
		    type: "POST",
		    url: $('#getCustomerDataLink').val(),
		    data: '_token='+$('input[name="ajax_token"]').val()+'&id='+id,
		    success: function(data) {
		        // console.log(data);
		        var customer = JSON.parse(data);
		        modal.find('input[name="name"]').val(customer.name);
		        modal.find('input[name="email"]').val(customer.email);
		        modal.find('input[name="name"]').val(customer.name);
		        var gender = (customer.gender == 'Pria') ? 'male' : 'female';
		        modal.find('input[name="gender"]').each(function() {
		        	if($(this).attr('value') == gender) {
		        		$(this).prop('checked', true);
		        	}
		        });
		        modal.find('input[name="birthdate"]').val(customer.date_birth);
		        modal.find('textarea[name="address"]').val(customer.address);
		        modal.find('input[name="phone1"]').val(customer.handphone1);
		        modal.find('input[name="phone2"]').val(customer.handphone2);
		        modal.find('.ordercount').html(customer.orderCount);
		        modal.find('.customersince').html(customer.customer_since);
		        modal.find('.lastvisit').html(customer.last_visit);
		        if(type == 'detail') {
		        	modal.find('input, textarea').prop('disabled', true);
		        }else {
		        	modal.find('input, textarea').prop('disabled', false);
		        }
		        modal.find('.loading-div').addClass('hidden');
		        modal.find('.content').removeClass('hidden');
		    },
		    error: function(jqXHR, textStatus, errorThrown) {
		    	$('#html-error-msg').html(JSON.stringify(jqXHR));
		        alert('error');
		    }
		});
	});
});