function updateItemAutoComplete(type, obj) {
	if(type == 'tile') {
		var tiledata = JSON.parse($('#tile-data').val());
		var autodata = [];
		for(var a=0;a<tiledata.length;a++) {
			autodata.push(tiledata[a].item_name+' : '+tiledata[a].id);
		}
		if(obj.hasClass('ui-autocomplete-input')) {
			obj.autocomplete('option', 'source', autodata);
		}else {
			obj.autocomplete({
				source: autodata,
				appendTo: "#myModalAddOrder"
			});
		}
	}else {
		var addondata = JSON.parse($('#addon-data').val());
		var autodata = [];
		for(var a=0;a<addondata.length;a++) {
			autodata.push(addondata[a].add_on_name+' : '+addondata[a].id);
		}
		if(obj.hasClass('ui-autocomplete-input')) {
			obj.autocomplete('option', 'source', autodata);
		}else {
			obj.autocomplete({
				source: autodata,
				appendTo: "#myModalAddOrder"
			});
		}
	}
}

function changeItemListDetail() {
	var totalQty = 0;
	var grandTotalPrice = 0;
	$('#item-list-table').find('input[name="item_number[]"]').each(function() {
		totalQty += parseInt($(this).val());
	});
	$('#item-list-table').find('.total_price').each(function() {
		var totalPrice = parseInt($(this).html().split('Rp. ')[1].replace(/\./g,''));
		grandTotalPrice += totalPrice;
	});
	// alert(totalQty+' '+grandTotalPrice);
	$('#item-list-table').find('.total_qty').html(totalQty);
	$('#item-list-table').find('.grand_total_price').html('Rp. '+number_format(grandTotalPrice,0,'.','.'));
	$('input[name="grand_total_price"]').val(number_format(grandTotalPrice,0,'.','.'));

	// UPDATE FEE VALUE
	// ----------------
	var feeValue = 0;
	$('#item-list-table').find('.detail-body').find('tr').each(function() {
		var feeId = parseInt($(this).data('fee'));
		var cityId = parseInt($(this).data('city'));
		var qty = parseInt($(this).find('input[name="item_number[]"]').val());
		var feeData = JSON.parse($('#feeData').val());
		// console.log(JSON.stringify(feeData));
		for(var i=0;i<feeData.length;i++) {
			if(feeData[i].header_id == feeId && feeData[i].city_id == cityId && qty != 0 && feeData[i].quantity_above >= qty && feeData[i].quantity_below <= qty)
			{
				feeValue += parseInt(feeData[i].fee_value);
			}
		}
	});
	var subtotal = grandTotalPrice + feeValue;
	$('input[name="fee"]').val(number_format(feeValue,0,'.','.'));
	$('input[name="subtotal_price"]').val(number_format(subtotal,0,'.','.'));
}

$(document).ready(function() {

	// ADD ORDER MANUAL
	// ----------------
	$('input[name="searchCustomerName"]').on('keyup', function(event) {
		var value = $(this).val();
		setTimeout(
			function() {
				$('#myModalChooseCustomer').find('input[name="user"]').each(function() {
					var name = $(this).data('name');
					if(name.toLowerCase().includes(value)) {
						$(this).closest('div').removeClass('hidden');
					}else {
						$(this).closest('div').addClass('hidden');
					}
				});
			}
		,1000);
	});

	// CHANGE STATUS
	// -------------
	$('#myModalChangeStatus').on('show.bs.modal', function(event) {
		var button = $(event.relatedTarget);
		var id = button.data('id');
		var status = button.closest('tr').find('.status').html();
		$(this).find('input[name="id"]').val(id);
		$(this).find('select[name="status"]').val(status);
		$(this).find('select[name="status"]').change();
	});
	$('#changeStatusForm').find('select[name="status"]').on('change', function(event) {
		var value = $(this).val();
		if(value == 'menunggu pembayaran' || value == 'pesanan terkonfirmasi' || value == 'pesanan terkirim')
		{
			$(this).closest('form').find('.submitandsend').removeClass('hidden');
		}else {
			$(this).closest('form').find('.submitandsend').addClass('hidden');
		}
	});
	$('#changeStatusForm').find('.submitandsend').on('click', function(event) {
		$('#changeStatusForm').find('input[name="email"]').val('true');
		$('#changeStatusForm').submit();
	});
	$('#changeStatusForm').on('submit', function(event) {
		// event.preventDefault();
		var note = $(this).find('textarea[name="admin_note"]').val();
		if(note == '' || note == null) {
			event.preventDefault();
			alert('Please input admin note for changing status');
		}
	});

	// PAYMENT DETAIL
	// --------------
	$('#myModalPaymentDetail').on('show.bs.modal', function(event) {
		var button = $(event.relatedTarget);
		var id = button.data('id');
		var modal = $(this);
		modal.find('.content').addClass('hidden');
		modal.find('.loading-div').removeClass('hidden');
		// console.log($('#getPaymentDataLink').val()+"?token="+$('input[name="ajax_token"]').val()+"&id="+id)
		$.ajax({
		    type: "POST",
		    url: $('#getPaymentDataLink').val(),
		    data: "_token="+$('input[name="ajax_token"]').val()+"&id="+id,
		    success: function(data) {
		    	// alert(data);
		    	data = JSON.parse(data);
		    	data = data.payment;
		    	if(data != null && data != '') {
		    		var obj = modal.find('.content').find('.confirmed');
		    		obj.find('.bank').html(data.bank);
		    		obj.find('.account_name').html(data.account_name);
		    		obj.find('.payment_amount').html(number_format(data.amount,0,'.','.'));
		    		obj.find('.payment_date').html(data.payment_date);
		    		obj.find('.note').html(data.note);
					obj.removeClass('hidden');
		    	}else {
		    		modal.find('.content').find('.unconfirmed').removeClass('hidden');
		    	}
		    	modal.find('.loading-div').addClass('hidden');
		    	modal.find('.content').removeClass('hidden');
		    },
		    error: function(jqXHR, textStatus, errorThrown) {
		    	// $('#html-error-msg').html(JSON.stringify(jqXHR));
		    	alert('error');
		    }
		});
	});

	// ORDER DETAIL
	// ------------
	$('#changeOrderForm').find('input[type="text"], textarea, select').prop('disabled', true);

	// EDIT ORDER
	// ----------
	changeItemListDetail();
	// $('#order-submit-btn').prop('disabled', true);
	$('#order-form').on('submit', function(event) {
		$(this).find('input[type="text"], textarea').prop('disabled', false);
	});
	$('.edit-field').on('click', function(event) {
		event.preventDefault();
		if($(this).data('type') != 'address') {
			$('#order-submit-btn').prop('disabled', false);
			$(this).closest('.form-group').find('input[type="text"]').prop('disabled', false);
		}
	});
	$('#address-choose-btn').prop('disabled', true);
	$('input[name="address-opt"]').on('click', function(event) {
		$('#address-choose-btn').prop('disabled', false);
	});
	$('#address-choose-btn').on('click', function(event) {
		var address = $('input[name="address-opt"]:checked').closest('.address-wrapper').find('[name="full-address"]').html();
		var telp1 = $('input[name="address-opt"]:checked').closest('.address-wrapper').find('[name="telp1"]').html();
		var telp2 = $('input[name="address-opt"]:checked').closest('.address-wrapper').find('[name="telp2"]').html();
		if(telp2 == '' || telp2 == null) {
			telp2 = 'null';
		}
		$('#order-form').find('textarea[name="address"]').val(address);
		$('#order-form').find('input[name="receiverTelp1"]').val(telp1);
		$('#order-form').find('input[name="receiverTelp2"]').val(telp2);
		$(this).closest('.modal').modal('hide');
	});
	$(this).on('change', 'input[name="item_number[]"]', function(event) {
		var qty = $(this).val();
		var price = $(this).closest('tr').find('.price_per_pc').html().split('Rp. ')[1].replace(/\./g, '');
		var totalPrice = qty * price;
		// alert(qty+' '+price+' '+totalPrice);
		$(this).closest('tr').find('input[name="itemQty[]"]').val(qty);
		$(this).closest('tr').find('.total_price').html('Rp. '+number_format(totalPrice,0,'.','.'));
		changeItemListDetail();
	});
	$('#submit-add-item').on('click', function() {
		var arrayId = [];
		$(this).closest('.modal').find('input[name="item-opt"]').each(function() {
			if($(this).prop('checked') == true) {
				var type = $(this).closest('.tab-pane').attr('id');
				var temp = {
					id: $(this).data('id'),
					type: type
				};
				arrayId.push(temp);
			}
		});
		// alert(JSON.stringify(arrayId));
		var obj = $(this);
		obj.closest('.content').addClass('hidden');
		obj.closest('.modal').find('.loading-div').removeClass('hidden');
		var datastring = '_token='+$('input[name="ajax_token"]').val()+'&orderId='+$('#orderId').val()+'&data='+JSON.stringify(arrayId);
		// console.log($('#getItemDataLink').val()+'?'+datastring);
		// aa;
		$.ajax({
		    type: "POST",
		    url: $('#getItemDataLink').val(),
		    data: datastring,
		    success: function(data) {
		    	// console.log(data);
		    	// aa;
		    	var data = JSON.parse(data);
		    	var string = "";
		    	var grandTotalPrice = 0;
		    	for(var i=0;i<data.length;i++) {
		    		var exist = false;
		    		$('#item-list-table').find('.detail-body').find('tr').each(function() {
		    			var id = $(this).find('input[name="itemId[]"]').val();
		    			var type = $(this).find('.type').html().toLowerCase().replace(/ /g,'');
		    			if(data[i].item_id == id && data[i].type == type) {
		    				exist = true;
		    			}
		    		});
		    		if(exist == false) {
			    		var imgSrc = "";
			    		if(data[i].type == 'tile') {
			    			imgSrc = $('#imgPath').val()+'/small/'+data[i].img_name1
			    		}else {
			    			imgSrc = $('#imgPath').val()+'/add-on/small/'+data[i].img_name1
			    		}
			    		string = ""+
			    		'<tr data-fee="'+data[i].header_fee_id+'" data-city="'+data[i].city+'">'+
			    			'<td class="hidden">'+
			    				'<input type="hidden" name="itemId[]" value="'+data[i]['item_id']+'">'+
			    				'<input type="hidden" name="itemQty[]" value="0">'+
			    				'<input type="hidden" name="itemType[]" value="'+data[i].type+'">'+
			    			'</td>'+
			    			'<td class="text-center type">'+((data[i].type == 'tile') ? 'Tile' : 'Add On')+'</td>'+
			    			'<td class="text-center">'+data[i].item_code+'</td>'+
			    			'<td class="text-center">'+
			    				'<img src="'+imgSrc+'">'+
			    			'</td>'+
			    			'<td class="text-center">'+data[i].item_name+'</td>'+
			    			'<td class="text-center desc">'+data[i].desc.substr(0,(data[i].desc.length-2))+'</td>'+
			    			'<td class="text-center price_per_pc">Rp. '+number_format(data[i].price_per_box,0,'.','.')+'</td>'+
			    			'<td class="text-center">'+
			    				'<input type="number" name="item_number[]" min="0" value="'+data[i].total_item+'" onkeydown="return false" style="width:55px">'+
			    			'</td>'+
			    			'<td class="text-center total_price">Rp. '+number_format((data[i].price_per_box * data[i].total_item),0,'.','.')+'</td>'+
			    			'<td class="text-center">'+
			    				'<a href="#">'+
			    					'<span class="fa fa-trash"></span>'+
			    				'</a>'+
			    			'</td>'+
			    		'</tr>';
			    		$('#item-list-table').find('.detail-body').append(string);
			    	}
		    	}
		    	$('#item-list-table').find('input[name="item_number[]"]').change();
		    	changeItemListDetail();
		    	obj.closest('.modal').modal('hide');
		    	obj.closest('.modal').find('input[type="checkbox"]').prop('checked', false);
		    	obj.closest('.modal').find('.loading-div').addClass('hidden');
		    	obj.closest('.content').removeClass('hidden');
		    },
		    error: function(jqXHR, textStatus, errorThrown) {
		    	$('#html-error-msg').html(JSON.stringify(jqXHR));
		        alert('error');
		    }
		});
	});

	// USERNAME AUTOCOMPLETE
	// ---------------------
	// var userdata = JSON.parse($('#user-data').val());
	// var autodata = [];
	// for(var i=0;i<userdata.length;i++) {
	// 	autodata.push(userdata[i].name);
	// }
	// $('input[name="username"]').autocomplete({
	// 	source: autodata,
	// 	delay: 1000,
	// 	close: function(event, ui) {
	// 		var name = $(this).val();
	// 		var email = '';
	// 		for(var i=0;i<userdata.length;i++) {
	// 			if(userdata[i].name == name) {
	// 				email = userdata[i].email;
	// 				break;
	// 			}
	// 		}
	// 		if(email != '') {
	// 			$('input[name="email"]').val(email);
	// 			$('.name-error').html('');
	// 			$('.address-section').find('.loading-div').removeClass('hidden');
	// 			$('.address-section').find('.no-address').addClass('hidden');
	// 			$('.address-section').find('.address-list').addClass('hidden');
	// 			$.ajax({
	// 			    type: "POST",
	// 			    url: $('#getAddressDataLink').val(),
	// 			    data: '_token='+$('input[name="ajax_token"]').val()+'&name='+name,
	// 			    success: function(data) {
	// 			    	if(data != 'No Address Found') {
	// 				        var address = JSON.parse(data);
	// 				        var string = "";
	// 				        // for(var i=0;i<address.length;i++) {
	// 				        // 	string += ''+
	// 				        // 	'<div class="col-xs-6" style="border:solid 1px black">'+
	// 				        // 		'<div class="col-xs-2">'+
	// 				        // 			'<input type="radio" name="address-opt" value="'+address[i].id+'" '+( address[i].type == 'primary' ? 'checked' : '' )+'>'+
	// 				        // 		'</div>'+
	// 				        // 		'<div class="col-xs-10">'+
	// 				        // 			'<strong>'+address[i].name+'</strong><br>'+
	// 				        // 			address[i].address+'<br>'+
	// 				        // 			address[i].city_name+', '+address[i].province_name+'<br>'+
	// 				        // 			'Telp 1 '+address[i].telp1+'<br>';
	// 				        // 	if(address[i].telp2 != null || address[i].telp2 != "") {
	// 				        // 		string += 'Telp 2 '+address[i].telp2;
	// 				        // 	}
	// 				        // 	string += ''+
	// 				        // 		'</div>'+
	// 				        // 	'</div>';
	// 				        // }
	// 				        $('.address-section').find('.address-list').html(string);
	// 				        $('.address-section').find('.loading-div').removeClass('hidden');
	// 						$('.address-section').find('.no-address').addClass('hidden');
	// 						$('.address-section').find('.address-list').addClass('hidden');
	// 				    }
	// 			    },
	// 			    error: function(jqXHR, textStatus, errorThrown) {
	// 			        alert('error');
	// 			    }
	// 			});
	// 		}else {
	// 			$('input[name="email"]').val('');
	// 			$('.name-error').html('no customer name found');
	// 			$('.address-section').find('.loading-div').addClass('hidden');
	// 			$('.address-section').find('.no-address').removeClass('hidden');
	// 			$('.address-section').find('.address-list').addClass('hidden');
	// 		}
	// 	}
	// });

	// EMAIL AUTOCOMPLETE
	// ------------------
	// var userdata = JSON.parse($('#user-data').val());
	// var autodata = [];
	// for(var i=0;i<userdata.length;i++) {
	// 	autodata.push(userdata[i].email);
	// }
	// $('input[name="email"]').autocomplete({
	// 	source: autodata,
	// 	delay: 1000,
	// 	close: function(event, ui) {
	// 		var name = $(this).val();
	// 		// $.ajax({
	// 		//     type: "POST",
	// 		//     url: $('#getAddressDataLink').val(),
	// 		//     data: '_token='+$('input[name="ajax_token"]').val()+'&name='+name,
	// 		//     success: function(data) {
	// 		//     	if(data != 'No Address Found') {
	// 		// 	        var address = JSON.parse(data);
	// 		// 	        var string = "";
	// 		// 	        // for(var i=0;i<address.length;i++) {
	// 		// 	        // 	string += ''+
	// 		// 	        // 	'<div class="col-xs-6" style="border:solid 1px black">'+
	// 		// 	        // 		'<div class="col-xs-2">'+
	// 		// 	        // 			'<input type="radio" name="address-opt" value="'+address[i].id+'" '+( address[i].type == 'primary' ? 'checked' : '' )+'>'+
	// 		// 	        // 		'</div>'+
	// 		// 	        // 		'<div class="col-xs-10">'+
	// 		// 	        // 			'<strong>'+address[i].name+'</strong><br>'+
	// 		// 	        // 			address[i].address+'<br>'+
	// 		// 	        // 			address[i].city_name+', '+address[i].province_name+'<br>'+
	// 		// 	        // 			'Telp 1 '+address[i].telp1+'<br>';
	// 		// 	        // 	if(address[i].telp2 != null || address[i].telp2 != "") {
	// 		// 	        // 		string += 'Telp 2 '+address[i].telp2;
	// 		// 	        // 	}
	// 		// 	        // 	string += ''+
	// 		// 	        // 		'</div>'+
	// 		// 	        // 	'</div>';
	// 		// 	        // }
	// 		// 	        $('#address-content').html(string);
	// 		// 	        $('#address-list').find('.loading-div').addClass('hidden');
	// 		// 	    }
	// 		//     },
	// 		//     error: function(jqXHR, textStatus, errorThrown) {
	// 		//         alert('error');
	// 		//     }
	// 		// });
	// 	}
	// });

	// $('input[name="address"]').on('click', function(event) {
	// 	if($(this).val() == "2") {
	// 		$('#address-list').collapse('show');
	// 	}else {
	// 		$('#address-list').collapse('hide');
	// 	}
	// });

	// $('button.add-item-btn').on('click', function(event) {
	// 	var string = ''+
	// 	'<div class="col-xs-12 item-wrapper" style="padding:0">'+
	// 		'<div class="col-xs-1">'+
	// 			'<a href="#" class="del-item-btn"><span class="fa fa-trash"></span></a>'+
	// 		'</div>';
	// 	var count = 0;
	// 	$('#detail').find('.item-content').find('.item-wrapper').each(function() {
	// 		count++;
	// 	});
	// 	if(count == 0) {
	// 		string += ''+
	// 		'<div class="col-xs-2">'+
	// 			'<select name="item-type[]" class="form-control">'+
	// 				'<option value="tile">Tile</option>'+
	// 			'</select>'+
	// 		'</div>';
	// 	}else {
	// 		string += ''+
	// 		'<div class="col-xs-2">'+
	// 			'<select name="item-type[]" class="form-control">'+
	// 				'<option value="tile">Tile</option>'+
	// 				'<option value="addon">Add On</option>'+
	// 			'</select>'+
	// 		'</div>';
	// 	}
	// 	string += ''+
	// 		'<div class="col-xs-5">'+
	// 			'<input type="text" name="item-name[]" class="form-control">'+
	// 		'</div>'+
	// 		'<div class="col-xs-2">'+
	// 			'<input type="text" name="item-num[]" class="form-control">'+
	// 		'</div>'+
	// 		'<div class="col-xs-2 addon-relation hidden">'+
	// 			'<input type="hidden" name="addon-relation[]" value="false">'+
	// 			'<input type="checkbox" class="addon-relation">&nbsprelated'+
	// 		'</div>'+
	// 	'</div>';
	// 	$('#detail').find('.item-content').append(string);
	// 	updateItemAutoComplete('tile', $('#detail').find('.item-content').find('.item-wrapper:last').find('input[name="item-name[]"]'))
	// });

	// $(this).on('change', 'select[name="item-type[]"]', function(event) {
	// 	if($(this).val() == 'addon') {
	// 		$(this).closest('.item-wrapper').find('.addon-relation').removeClass('hidden');
	// 		updateItemAutoComplete('addon', $(this).closest('.item-wrapper').find('input[name="item-name[]"]'));
	// 	}else {
	// 		$(this).closest('.item-wrapper').find('.addon-relation').addClass('hidden');
	// 		updateItemAutoComplete('tile', $(this).closest('.item-wrapper').find('input[name="item-name[]"]'));
	// 	}
	// });

	// $(this).on('click', 'input.addon-relation', function(event) {
	// 	if($(this).prop('checked') == true) {
	// 		$(this).closest('div').find('input[name="addon-relation[]"]').val('true')
	// 	}else {
	// 		$(this).closest('div').find('input[name="addon-relation[]"]').val('false')
	// 	}
	// });

});