$(document).ready(function() {

	// CITY LIST JS
	// ------------
	$('#add-city-form, #edit-city-form').on('submit', function(event) {
		// event.preventDefault();
		var province = $(this).find('select[name="province_name"]').val();
		var city = $(this).find('input[name="city_name"]').val();
		if(province == "null") {
			event.preventDefault();
			alert('Please select a province name');
		}else {
			if(city == null || city == "") {
				event.preventDefault();
				alert('Please input a city name');
			}
		}
	});

	$('#myModalEditCity').on('show.bs.modal', function(event) {
		var button = $(event.relatedTarget);
		var id = button.data('id');
		$(this).find('input[name="city_id"]').val(id);
		$(this).find('.loading-div').removeClass('hidden');
		$(this).find('.content').addClass('hidden');
		var modal = $(this);
		$.ajax({
			type: "POST",
			url: $('#getDataLink').val(),
			data: "_token="+$('input[name="ajax_token"]').val()+"&city_id="+id,
			success: function(data) {
				var data = JSON.parse(data);
				modal.find('select[name="province_name"]').val(data.province_name);
				modal.find('input[name="city_name"]').val(data.city_name);
				modal.find('.loading-div').addClass('hidden');
				modal.find('.content').removeClass('hidden');
			},
			error: function(jqXHR, textStatus, errorThrown) {
				alert("error");
			}
		});
	});

	$('#myModalDelCityConfirmation').on('show.bs.modal', function(event) {
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
			$('#city-list-table').find('.checkthis').each(function() {
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

	$('#delCityConfirmButton').on('click', function(event) {
		var data = $(this).closest('.modal').find('input[name="data"]').val();
		$('#del-city-form').find('input[name="city_data"]').val(data);
		$('#del-city-form').submit();
	});

});