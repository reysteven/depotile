<div class="modal fade" id="myModalAddSubTag" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="width:50%">
        <div class="modal-content">
            <div class="modal-header" style="background-color:#224098; color:white">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="title text-center"></h4>
            </div>
            <div class="modal-body row" style="color:black">
                <div class="error-msg col-sm-12 text-center" style="margin-top:1%; color:red"></div>
                <div class="loading-div text-center hidden">
                    <span class="fa fa-spinner fa-spin fa-2x"></span>
                </div>
            	<div class="content">
            		<form method="POST" id="edit-sub-tag-form" action="">
            			<input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="hidden" name="type">
                        <input type="hidden" name="tag_id">
                        <input type="hidden" name="sub_tag_id">
                		<div class="form-group col-xs-12">
                			<div class="col-xs-4">Sub Tag Name</div>
                			<div class="col-xs-1">:</div>
                			<div class="col-xs-7">
                				<input type="text" class="form-control" name="sub_tag_name">
                			</div>
                		</div>
                		<div class="form-group col-xs-12">
                			<div class="col-xs-4">Sub Tag CTA</div>
                			<div class="col-xs-1">:</div>
                			<div class="col-xs-7">
                				<input type="text" class="form-control" name="sub_tag_cta">
                			</div>
                		</div>
                		<div class="col-xs-12 text-center">
    						<input type="hidden" name="curr-img">
    						<img src="{{ asset('public/assets/image/tag-icon/bathroom.png') }}" class="curr-img hidden" width="47px">
    						<div class="img-list" style="overflow-y:scroll; max-height:250px; padding:0; margin-top:20px">
                                <div class="text-center">DAFTAR GAMBAR</div>
                                <?php
                                    // AMBIL DATA GAMBAR
                                    // -----------------
                                    $directory = $_SERVER['DOCUMENT_ROOT']."/".env('APP_ROOT_DIR')."/public/assets/image/tag-icon/";
                                    $handle = opendir($directory);
                                    while($file = readdir($handle)){
                                        if($file !== '.' && $file !== '..'){
                                ?>
                                    <a class="thumbnail img-item-link" href="#thumb" style="margin-bottom:10px">
                                        <?php echo $file ?>
                                        <span>
                                        	<img src="{{ asset('public/assets/image/tag-icon/'.$file) }}" width="100%">
                                        </span>
                                    </a>
                                <?php
                                        }
                                    }
                                ?>
                            </div>
                            <div class="col-xs-12 text-center" style="padding-top:2%">
                            	<input type="button" class="btn btn-default change-img-btn hidden" value="Change Image">
                            </div>
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