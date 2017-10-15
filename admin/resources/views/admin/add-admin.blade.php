<div class="modal fade" id="myModalAddAdmin" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="width:50%">
        <div class="modal-content">
            <div class="modal-header" style="background-color:#224098; color:white">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="title text-center">Add Admin</h4>
            </div>
            <div class="modal-body row" style="color:black">
                <div class="error-msg col-sm-12 text-center" style="margin-top:1%; color:red"></div>
                <div class="loading-div text-center hidden">
                    <span class="fa fa-spinner fa-spin fa-2x"></span>
                </div>
            	<div class="content hidden">
            		<ul class="nav nav-tabs">
                        <li class="active"><a href="#general" data-toggle="tab">General</a></li>
                        <li><a href="#access" data-toggle="tab">Access</a></li>
                    </ul>
            		<form method="POST" action="{{ url('doAddAdmin') }}" id="add-admin-form">
            			<div class="tab-content">
                        	<div id="general" class="tab-pane fade-in active" style="margin-top:2%">
		            			<input type="hidden" name="_token" value="{{ csrf_token() }}">
		            			<input style="display:none" type="text" name="fakename">
		            			<input style="display:none" type="password" name="fakepass">
		            			<div class="form-group col-xs-12">
		            				<div class="col-xs-4">ID</div>
		            				<div class="col-xs-1">:</div>
		            				<div class="col-xs-7">
		            					<input type="text" class="form-control" name="id" disabled>
		            				</div>
		            			</div>
		            			<div class="form-group col-xs-12">
		            				<div class="col-xs-4">Name</div>
		            				<div class="col-xs-1">:</div>
		            				<div class="col-xs-7">
		            					<input type="text" class="form-control" name="name" autocomplete="off">
		            				</div>
		            			</div>
		            			<div class="form-group col-xs-12">
		            				<div class="col-xs-4">Password</div>
		            				<div class="col-xs-1">:</div>
		            				<div class="col-xs-7">
		            					<input type="password" class="form-control" name="password" autocomplete="off">
		            				</div>
		            			</div>
		            			<div class="form-group col-xs-12">
		            				<div class="col-xs-4">Retype Password</div>
		            				<div class="col-xs-1">:</div>
		            				<div class="col-xs-7">
		            					<input type="password" class="form-control retype-password" autocomplete="off">
		            				</div>
		            			</div>
		            			<div class="form-group col-xs-12">
		            				<div class="col-xs-4">Email</div>
		            				<div class="col-xs-1">:</div>
		            				<div class="col-xs-7">
		            					<input type="text" class="form-control" name="email">
		            				</div>
		            			</div>
		            			<div class="form-group col-xs-12">
		            				<div class="col-xs-4">Address</div>
		            				<div class="col-xs-1">:</div>
		            				<div class="col-xs-7">
		            					<textarea rows="3" class="form-control" name="address"></textarea>
		            				</div>
		            			</div>
		            			<div class="col-xs-12" style="padding-right:30px">
		            				<input type="submit" class="btn btn-primary pull-right" value="Submit">
		            				<input type="button" class="btn btn-default pull-right" value="Cancel">
		            			</div>
		            		</div>
		            		<div id="access" class="tab-pane fade-in active" style="margin-top:2%">
		            		</div>
		            	</div>
            		</form>
            	</div>
            </div>
        </div>
    </div>
</div>