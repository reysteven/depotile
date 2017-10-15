<div class="modal fade" id="myModalAddNavigation" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="width:50%">
        <div class="modal-content">
            <div class="modal-header" style="background-color:#224098; color:white">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="title text-center">Add Navigation</h4>
            </div>
            <div class="modal-body row" style="color:black">
                <div class="error-msg col-sm-12 text-center" style="margin-top:1%; color:red"></div>
                <div class="loading-div text-center hidden">
                    <span class="fa fa-spinner fa-spin fa-2x"></span>
                </div>
            	<div class="content">
            		<ul class="nav nav-tabs">
                        <li class="active"><a href="#general" data-toggle="tab">General</a></li>
                        <li><a href="#tag" data-toggle="tab">Tags</a></li>
                    </ul>
            		<form method="POST" action="{{ url('doAddNavigation') }}" id="add-navigation-form">
            			<input type="hidden" name="_token" value="{{ csrf_token() }}">
            			<input type="hidden" name="id">
            			<div class="tab-content">
            				<div id="general" class="tab-pane fade in active" style="margin-top:2%">
            					<div class="form-group col-xs-12">
            						<div class="col-xs-4">Name</div>
            						<div class="col-xs-1">:</div>
            						<div class="col-xs-7">
            							<input type="text" class="form-control" name="name">
            						</div>
            					</div>
            					<div class="form-group col-xs-12">
            						<div class="col-xs-4">Relation</div>
            						<div class="col-xs-1">:</div>
            						<div class="col-xs-7">
            							<div class="col-xs-6">
            								<input type="radio" name="relation" value="1">&nbspInclude All
            							</div>
            							<div class="col-xs-6">
            								<input type="radio" name="relation" value="2">&nbspEither
            							</div>
            						</div>
            					</div>
            					<div class="col-xs-12 text-center">
            						<input type="hidden" name="curr-img">
            						<img src="" class="curr-img hidden" width="400px">
            						<div class="img-list" style="overflow-y:scroll; max-height:250px; padding:0; margin-top:20px">
                                        <div class="text-center">DAFTAR GAMBAR</div>
                                        <?php
                                            // AMBIL DATA GAMBAR
                                            // -----------------
                                            $directory = $_SERVER['DOCUMENT_ROOT']."/".env('APP_ROOT_DIR')."/public/assets/image/nav-image/";
                                            $handle = opendir($directory);
                                            while($file = readdir($handle)){
                                                if($file !== '.' && $file !== '..'){
                                        ?>
                                            <a class="thumbnail img-item-link" href="#thumb" style="margin-bottom:10px">
                                                <?php echo $file ?>
                                                <span>
                                                	<img src="{{ asset('public/assets/image/nav-image/'.$file) }}" width="200px">
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
            				</div>
            				<div id="tag" class="tab-pane fade" style="margin-top:2%">
	                            <div class="tag-content col-xs-12"></div>
	                            <div class="col-xs-12 text-left">
	                                <button class="btn btn-default add-tag-btn" type="button">
	                                    <span class="fa fa-plus"></span>
	                                    Add Tag
	                                </button>
	                            </div>
	                        </div>
            			</div>
            			<div class="col-xs-12 submit-section">
            				<input type="submit" class="btn btn-primary pull-right" value="Submit">
            				<input type="button" data-dismiss="modal" class="btn btn-default pull-right" value="Cancel">
            			</div>
            		</form>
            	</div>
            </div>
        </div>
    </div>
</div>