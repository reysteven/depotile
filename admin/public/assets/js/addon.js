$(document).ready(function() {
	$(this).on('click', '.file-browser', function(event) {
        $(this).closest('.form-group').find('input[type="file"]').click();
    });

    $(this).on('change', 'input[type="file"]', function(event) {
        var value = $(this).val().split('\\');
        value = value[value.length-1];
        $(this).closest('.form-group').find('.file-name-text').val(value);
    })

    $('#excel-uploader-submit').click(function(event) {
        $(this).prop('disabled', true);
        $('#excel-uploader-form').submit();
    });
});