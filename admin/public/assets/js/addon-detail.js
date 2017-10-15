$(document).ready(function() {
	$('#addon_price').autoNumeric('init', {
        aSep: '.',
        aDec: ',',
        aSign: 'Rp '
    });

	$('#myModalDetailAddon').on('show.bs.modal', function(event) {
		var button = $(event.relatedTarget);
		var id = button.data('id');
		var type = button.data('type');
		$(this).find('.loading-div').removeClass('hidden');
		$(this).find('.content').addClass('hidden');
		var modal = $(this);

        // RESET SEMUA TEXTBOX MERAH
        // -------------------------
        $(this).find('input[type="text"], textarea').each(function() {
            $(this).css('background-color', 'white');
            $(this).attr('data-valid', 'true');
        });

		$.ajax({
            type: "POST",
            url: '/depotile/admin/item-manager/doGetAddonData.php',
            data: "id="+id,
            success: function(data) {
                var addonData = JSON.parse(data);
                modal.find('input[name="addon_id"]').val(addonData['id']);
                modal.find('input[name="addon_name"]').val(addonData['add_on_name']);
                modal.find('input[name="addon_price"]').val(addonData['price_per_pcs']);
                modal.find('select[name="addon_type"]').val(addonData['type']);
                modal.find('input[name="addon_color"]').val(addonData['color']);
                modal.find('select[name="addon_brand"]').val(addonData['brand']);
                modal.find('select[name="addon_fee"]').val(addonData['fee']);
                modal.find('textarea[name="addon_desc"]').val(addonData['description']);
                modal.find('input[name="addon_img"]').val(addonData['img_name']);
                modal.find('img.addon_img').attr('src', "/depotile/assets/image/image-storage/"+addonData['img_name']);
                modal.find('input.change-addon-img-btn').prop('disabled', true);
                modal.find('input.change-addon-img-btn').removeClass('hidden');
                modal.find('.img-list').addClass('hidden');
                modal.find('.loading-div').addClass('hidden');
                modal.find('.content').removeClass('hidden');
                if(type == "detail") {
                	modal.find('input, select, textarea').prop('disabled', true);
                	modal.find('.nav-section').addClass('hidden');
                }else if(type == "edit") {
                	modal.find('input, select, textarea').prop('disabled', false);
                	modal.find('input[name="addon_id"]').prop('disabled', true);
                	modal.find('.nav-section').removeClass('hidden');
                	modal.find('form').attr('action', 'doEditAddon.php');
                }
                modal.find('input[name="addon_price"]').keypress();
            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert('error');
            }
        });
	});

    $('#myModalDetailAddon').find('input[type="text"], textarea').on('keyup', function(event) {
        if($(this).val() == "" || $(this).val() == null) {
            autocompleteValidation($(this),false);
        }else {
            autocompleteValidation($(this),true);
        }
    });

	$('.change-addon-img-btn').on('click', function(event) {
		$(this).closest('tr').find('.img-list').removeClass('hidden');
		$(this).addClass('hidden');
	});

	$('.addon-img-item-link').on('click', function(event) {
		event.preventDefault();
		$(this).closest('tr').find('img.addon_img').attr('src', "/depotile/assets/image/image-storage/"+$(this).data('value'));
		$('input[name="addon_img"]').val($(this).data('value'));
		$(this).closest('.img-list').addClass('hidden');
		$(this).closest('td').find('.change-addon-img-btn').removeClass('hidden');
	});

	$('#addon-form').on('submit', function(event) {
		// event.preventDefault();
		var valid = true;
		$(this).find('input[type="text"], select, textarea').each(function() {
			if($(this).val() == null || $(this).val() == "") {
				valid = false;
			}
		});
		if(valid == false) {
			event.preventDefault();
			$(this).closest('.modal').find('.error-msg').html('Isi semua data dengan lengkap dahulu');
		}else {
			$(this).find('input').prop('disabled', false);
		}
	});
});