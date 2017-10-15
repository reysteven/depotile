$(document).ready(function() {

	// PROVINCE LIST JS
	// ----------------
	$('#add-province-form').on('submit', function(event) {
		// event.preventDefault();
		var province = $(this).find('input[name="province_name"]').val();
		if(province == null || province == "") {
			event.preventDefault();
			alert("Please input province's name");
		}
	});

	$('.edit-province').on('click', function(event) {
		event.preventDefault();
		$(this).closest('tr').find('.province-name').addClass('hidden');
		$(this).closest('tr').find('.edit-province-section').removeClass('hidden');
	});

	$('.edit-province-form').on('submit', function(event) {
		// event.preventDefault();
		var province = $(this).find('input[name="province_name"]').val();
		if(province == null || province == "") {
			event.preventDefault();
			alert("Please input province's name");
		}
	});

	$('#myModalDelProvinceConfirmation').on('show.bs.modal', function(event) {
		var button = $(event.relatedTarget);
		var type = button.data('type');
		$(this).find('input[name="type"]').val(type);
		if(type == "single") {
			var id = button.data('id');
			var array = [];
			var tempArray = {
				id : id
			}
			array.push(tempArray);
		}else {
			var array = [];
			$('#province-list-table').find('.checkthis').each(function() {
				if($(this).prop('checked') == true) {
					var id = $(this).data('id');
					var tempArray = {
						id : id
					}
					array.push(tempArray);
				}
			});
		}
		$(this).find('input[name="data"]').val(JSON.stringify(array));
	});

	$('#delProvinceConfirmButton').on('click', function(event) {
		var data = $(this).closest('.modal').find('input[name="data"]').val();
		$('#del-province-form').find('input[name="province_data"]').val(data);
		$('#del-province-form').submit();
	});

});