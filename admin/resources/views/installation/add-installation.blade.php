<div class="modal fade" id="myModalAddInstallation" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
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
            	<div class="content hidden">
            		<form method="POST" id="installation-form" action="">
            			<input type="hidden" name="_token" value="{{ csrf_token() }}">
            			<input type="hidden" name="installation_id" value="">
	            		<div class="form-group col-xs-12">
	            			<div class="col-xs-4">Name</div>
	            			<div class="col-xs-1">:</div>
	            			<div class="col-xs-7">
	            				<input type="text" class="form-control" name="installation_name">
	            			</div>
	            		</div>
	            		<div class="form-group col-xs-12">
	            			<div class="col-xs-12 text-center" style="margin-bottom:1%">DESCRIPTION</div>
	            			<div class="col-xs-12">
	            				<textarea class="form-control text-editor" name="installation_desc" rows="3"></textarea>
	            			</div>
	            		</div>
	            		<div class="error-msg">
	            			<span style="color:red"></span>
	            		</div>
	            		<div class="col-xs-12">
	            			<div class="col-xs-12">
		            			<input type="submit" class="btn btn-primary pull-right" value="Submit">
		            			<input type="button" class="btn btn-default pull-right" data-dismiss="modal" value="Cancel" style="margin-left:1%">
	            			</div>
	            		</div>
            		</form>
            	</div>
            </div>
        </div>
    </div>
</div>