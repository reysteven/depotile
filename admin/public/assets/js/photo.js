$(document).ready(function() {

	$(this).on('click', '.file-browser', function(event) {
        $(this).closest('.form-group').find('input[type="file"]').click();
    });

    $(this).on('change', 'input[type="file"]', function(event) {
        var value = $(this).val().split('\\');
        value = value[value.length-1];
        $(this).closest('.form-group').find('.file-name-text').val(value);
    })

    $(this).on('change', '.file-type', function(event) {
        var type = $(this).val();
        if(type == "Tile Photo") {
            type = "tile";
        }else if(type == "Add On Photo") {
            type = "add_on";
        }else if(type == "Logo Picture") {
            type = "logo";
        }else if(type == "Tag Icon") {
            type = "tag";
        }else if(type == "Navigation Picture") {
            type = "navigation";
        }else if(type == "Other") {
            type = "other";
        }
        var obj = $(this);
        obj.closest('.form-group').find('.folder-type').prop('disabled', true);
        $.ajax({
            type: "POST",
            url: $('#getAllFolderTypeLink').val(),
            data: "_token="+$('input[name="ajax_token"]').val()+"&type="+type,
            success: function(data) {
                var folderData = JSON.parse(data);
                var string = '<option value="root">root</option>';
                for(var i=0;i<folderData.length;i++) {
                    string += '<option value="'+folderData[i].name+'">'+folderData[i].name+'</option>';
                }
                string += '<option value="auto">auto</option>'
                obj.closest('.form-group').find('.folder-type').html(string);
                obj.closest('.form-group').find('.folder-type').prop('disabled', false);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert('error');
            }
        });
    });

    $('.file-type').change();

	$(this).on('click', 'button.add-file-uploader', function(event) {
		var html = $(this).closest('.form-group').html();
		$('#photo-uploader-form').append('<div class="form-group col-xs-12" style="padding:0">'+html+'</div>');
        $('#photo-uploader-form').find('.form-group').last().each(function() {
            var type = $(this).prev().find('.file-type').val();
            var folder = $(this).prev().find('.folder-type').val();
            $(this).find('.file-type').find('option').each(function() {
                if($(this).html() == type) {
                    $(this).prop('selected', true);
                }
            });
            $(this).find('.folder-type').find('option').each(function() {
                if($(this).html() == folder) {
                    $(this).prop('selected', true);
                }
            });
        });
		$(this).addClass('hidden');
	});

	$('#photo-uploader-submit').click(function(event) {
        $('#photo-uploader-form').submit();
    });

    $('input[name="delPhotoConfirmButton"]').on('click', function(event) {
        var data = [];
        $('input.check-img-btn').each(function() {
            if($(this).prop('checked') == true) {
                var array = {
                    type: $(this).data('type'),
                    name: $(this).data('name')
                };
                data.push(array);
            }
        });
        // alert(JSON.stringify(data));
        $('#del-photo-form').find('input[name="data"]').val(JSON.stringify(data));
        $('#del-photo-form').submit();
    });

    $('#myModalAddFolder').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget);
        var type = button.data('type');
        var action = button.data('action');
        var modal = $(this);
        $(this).find('form').find('input[name="type"]').val(type);
        $(this).find('.loading-div').removeClass('hidden');
        $(this).find('.content').addClass('hidden');
        if(action == "add") {
            $(this).find('form').attr('action', $("#addFolderLink").val());
            $(this).find('.title').html('Add Folder');
            $(this).find('input[type="text"]').val("");
            $(this).find('.loading-div').addClass('hidden');
            $(this).find('.content').removeClass('hidden');
        }else {
            var id = button.data('id');
            $(this).find('input[name="id"]').val(id);
            $(this).find('form').attr('action', $("#editFolderLink").val());
            $(this).find('.title').html('Edit Folder');
            $.ajax({
                type: "POST",
                url: $('#getFolderDataLink').val(),
                data: "_token="+$('input[name="ajax_token"]').val()+"&id="+id,
                success: function(data) {
                    var folderData = JSON.parse(data);
                    modal.find('input[name="name"]').val(folderData.name);
                    modal.find('.loading-div').addClass('hidden');
                    modal.find('.content').removeClass('hidden');
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    alert('error');
                }
            });
        }
    });

    $('#folderForm').on('submit', function(event) {
        // event.preventDefault();
        var name = $(this).find('input[name="name"]').val()
        if(name == "" || name == null) {
            event.preventDefault();
            alert("Please input folder name");
        }
    });

    $('#myModalDelFolderConfirmation').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget);
        var type = button.data('type');
        var id = button.data('id');
        $(this).find('input[name="type"]').val(type);
        $(this).find('input[name="id"]').val(id);
    });

    $('input[name="delFolderConfirmButton"]').on('click', function(event) {
        var id = $(this).closest('.modal').find('input[name="id"]').val();
        var type = $(this).closest('.modal').find('input[name="type"]').val();
        var data = [
            {
                id: id,
                type: type
            }
        ];
        $('#del-folder-form').find('input[name="data"]').val(JSON.stringify(data));
        $('#del-folder-form').submit();
    });

    $('.move-folder-btn').on('click', function(event) {
        var nocheck = false;
        var type = $(this).data('type');
        var tab = null;
        if(type == 'tile') {
            tab = $('#tile');
        }else if(type == 'add_on') {
            tab = $('#addon');
        }else if(type == 'logo') {
            tab = $('#logo');
        }else if(type == 'tag') {
            tab = $('#icon');
        }else if(type == 'navigation') {
            tab = $('#navigation');
        }else {
            tab = $('#media');
        }
        tab.find('.check-img-btn').each(function() {
            if($(this).prop('checked') == true) {
                nocheck = true;
                return 1;
            }
        });
        if(nocheck == false) {
            event.stopPropagation();
            alert('Please check one of the list in table first');
        }
    });

    $('input[name="move-folder"]').on('change', function(event) {
        $('input[name="move-folder"]').each(function() {
            if($(this).prop('checked') == true) {
                $(this).closest('.form-group').find('.collapse').collapse('show');
            }else {
                $(this).closest('.form-group').find('.collapse').collapse('hide');
            }
        });
    });

    $('#myModalMoveFolder').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget);
        var type = button.data('type');
        var modal = $(this);
        modal.find('input[name="photo-type"]').val(type);
        modal.find('.content').addClass('hidden');
        modal.find('.loading-div').removeClass('hidden');
        $.ajax({
            type: "POST",
            url: $('#getAllFolderTypeLink').val(),
            data: "_token="+$('input[name="ajax_token"]').val()+"&type="+type,
            success: function(data) {
                var folderData = JSON.parse(data);
                var string = '<option value="root">root</option>';
                for(var i=0;i<folderData.length;i++) {
                    string += '<option value="'+folderData[i].name+'">'+folderData[i].name+'</option>';
                }
                string += '<option value="auto">auto</option>'
                modal.find('select[name="move-folder-name"]').html(string);
                var moveFolderType = modal.find('select[name="move-folder-type-name"]').val()
                $.ajax({
                    type: "POST",
                    url: $('#getAllFolderTypeLink').val(),
                    data: "_token="+$('input[name="ajax_token"]').val()+"&type="+moveFolderType,
                    success: function(data) {
                        var folderData = JSON.parse(data);
                        var string = '<option value="root">root</option>';
                        for(var i=0;i<folderData.length;i++) {
                            string += '<option value="'+folderData[i].name+'">'+folderData[i].name+'</option>';
                        }
                        string += '<option value="auto">auto</option>'
                        modal.find('select[name="move-folder-type-folder-name"]').html(string);
                        modal.find('.content').removeClass('hidden');
                        modal.find('.loading-div').addClass('hidden');
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        alert('error');
                    }
                });
            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert('error');
            }
        });
    });

    $('#move-folder-radio').click();

    $('.type-name').on('change', function(event) {
        var type = $(this).val();
        var obj = $(this);
        obj.closest('.modal').find('select[name="move-folder-type-folder-name"]').prop('disabled', true);
        $.ajax({
            type: "POST",
            url: $('#getAllFolderTypeLink').val(),
            data: "_token="+$('input[name="ajax_token"]').val()+"&type="+type,
            success: function(data) {
                var folderData = JSON.parse(data);
                var string = '<option value="root">root</option>';
                for(var i=0;i<folderData.length;i++) {
                    string += '<option value="'+folderData[i].name+'">'+folderData[i].name+'</option>';
                }
                string += '<option value="auto">auto</option>'
                obj.closest('.modal').find('select[name="move-folder-type-folder-name"]').html(string);
                obj.closest('.modal').find('select[name="move-folder-type-folder-name"]').prop('disabled', false);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert('error');
            }
        });
    });

    $('#change-folder-form').on('submit', function(event) {
        // event.preventDefault();
        var arrayId = [];
        var type = $(this).find('input[name="photo-type"]').val();
        var tab = null;
        if(type == 'tile') {
            tab = $('#tile');
        }else if(type == 'add_on') {
            tab = $('#addon');
        }else if(type == 'logo') {
            tab = $('#logo');
        }else if(type == 'tag') {
            tab = $('#icon');
        }else if(type == 'navigation') {
            tab = $('#navigation');
        }else {
            tab = $('#media');
        }
        tab.find('.check-img-btn').each(function() {
            if($(this).prop('checked') == true) {
                var id = $(this).data('id');
                console.log(id);
                arrayId.push(id);
            }
        });
        $(this).find('input[name="id-array"]').val(JSON.stringify(arrayId));
    });

});