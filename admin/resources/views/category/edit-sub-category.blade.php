<div class="modal fade" id="myModalEditSubCategory" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="width:50%">
        <div class="modal-content">
            <div class="modal-header" style="background-color:#224098; color:white">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="title text-center">Edit Sub Category</h4>
            </div>
            <div class="modal-body row" style="color:black">
                <div class="error-msg col-sm-12 text-center" style="margin-top:1%; color:red"></div>
                <div class="loading-div text-center hidden">
                    <span class="fa fa-spinner fa-spin fa-2x"></span>
                </div>
            	<div class="content hidden">
                    <form method="POST" id="edit-sub-category-form" action="{{ url('doEditSubCategory') }}">
                        <input type="hidden" name="type">
                        <input type="hidden" name="category_id">
                        <input type="hidden" name="sub_category_id">
                		<div class="form-group col-xs-12">
                			<div class="col-xs-4">Sub Category Name</div>
                			<div class="col-xs-1">:</div>
                			<div class="col-xs-7">
                				<input type="text" class="form-control" name="sub_category_name">
                			</div>
                		</div>
                		<div class="col-xs-12" style="margin-bottom:10px">
                			<div class="col-xs-6 text-center">
                				<input type="button" class="btn btn-default" value="Pcs per box" onclick="addDetail('pcs per box')" style="width:100%">
                			</div>
                			<div class="col-xs-6 text-center tag-dropdown-description">
                				<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" value="Tag" style="width:100%">Tag
                                <span class="caret"></span></button>
                                <ul class="dropdown-menu">
                                @foreach($tag as $t)
                                    <li><a href="#" onclick="addDetail('{{ $t->tag_name }}')">{{ $t->tag_name }}</a></li>
                                @endforeach
                                </ul>
                			</div>
                		</div>
                		<div class="col-xs-12">
                			<textarea id="sub-category-item-detail" name="sub_category_item_detail"></textarea>
                		</div>
                		<div class="col-xs-12" style="padding-top:1%">
                			<input type="submit" class="btn btn-primary pull-right" id="submit-sub-category-btn" value="Submit" data-id="">
                			<input type="button" class="btn btn-default pull-right" data-dismiss="modal" value="Cancel" style="margin-right:1%">
                		</div>
                    </form>
            	</div>
            </div>
        </div>
    </div>
</div>
<!-- <form method="POST" action="doEditSubCategory.php" id="edit-sub-category-form">
	<input type="hidden" name="id">
	<input type="hidden" name="sub_category_name">
	<input type="hidden" name="sub_category_desc">
</form> -->
<script type="text/javascript">
	function addDetail(type) {
		tinymce.activeEditor.execCommand('mceInsertContent', false, '['+type+']');
	}
</script>