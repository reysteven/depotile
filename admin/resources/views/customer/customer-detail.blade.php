<div class="modal fade" id="myModalDetailCustomer" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="width:50%">
        <div class="modal-content">
            <div class="modal-header" style="background-color:#224098; color:white">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="title text-center">Customer Detail</h4>
            </div>
            <div class="modal-body row" style="color:black">
                <div class="error-msg col-sm-12 text-center" style="margin-top:1%; color:red"></div>
                <div class="loading-div text-center hidden">
                    <span class="fa fa-spinner fa-spin fa-2x"></span>
                </div>
            	<div class="content hidden">
            		<ul class="nav nav-tabs">
            			<li class="active"><a href="#general" data-toggle="tab">General</a></li>
            			<li><a href="#highlight" data-toggle="tab">Highlight</a></li>
            			<li><a href="#history" data-toggle="tab">History</a></li>
            		</ul>
            		<form method="POST">
            			<div class="tab-content">
	            			<div id="general" class="tab-pane fade-in active" style="margin-top:2%">
	            				<div class="form-group col-xs-12" style="padding:0">
	            					<div class="col-xs-4">Name</div>
	            					<div class="col-xs-1">:</div>
	            					<div class="col-xs-7">
	            						<input type="text" class="form-control" name="name">
	            					</div>
	            				</div>
	            				<div class="form-group col-xs-12" style="padding:0">
	            					<div class="col-xs-4">Email</div>
	            					<div class="col-xs-1">:</div>
	            					<div class="col-xs-7">
	            						<input type="text" class="form-control" name="email">
	            					</div>
	            				</div>
	            				<div class="form-group col-xs-12" style="padding:0">
	            					<div class="col-xs-4">Gender</div>
	            					<div class="col-xs-1">:</div>
	            					<div class="col-xs-7">
	            						<input type="radio" name="gender" value="male">&nbspMale
	            						<input type="radio" name="gender" value="female">&nbspFemale
	            					</div>
	            				</div>
	            				<div class="form-group col-xs-12" style="padding:0">
	            					<div class="col-xs-4">Birth Date</div>
	            					<div class="col-xs-1">:</div>
	            					<div class="col-xs-7">
	            						<input type="text" class="form-control" name="birthdate">
	            					</div>
	            				</div>
	            				<div class="form-group col-xs-12" style="padding:0">
	            					<div class="col-xs-4">Address</div>
	            					<div class="col-xs-1">:</div>
	            					<div class="col-xs-7">
	            						<textarea class="form-control" name="address" rows="2"></textarea>
	            					</div>
	            				</div>
	            				<div class="form-group col-xs-12" style="padding:0">
	            					<div class="col-xs-4">Phone 1</div>
	            					<div class="col-xs-1">:</div>
	            					<div class="col-xs-7">
	            						<input type="text" class="form-control" name="phone1">
	            					</div>
	            				</div>
	            				<div class="form-group col-xs-12" style="padding:0">
	            					<div class="col-xs-4">Phone 2</div>
	            					<div class="col-xs-1">:</div>
	            					<div class="col-xs-7">
	            						<input type="text" class="form-control" name="phone2">
	            					</div>
	            				</div>
	            			</div>
	            			<div id="highlight" class="tab-pane fade" style="margin-top:2%">
	            				<table class="table borderless">
	            					<tr>
	            						<td class="col-xs-4 text-center" style="vertical-align:middle" rowspan="2">
	            							<span style="font-size:24px" class="ordercount text-center"></span><br>
	            							<span class="text-center" style="font-size:12px; font-weight:normal">TRANSACTIONS</span>
	            						</td>
	            						<td class="col-xs-4 text-center" style="vertical-align:middle">
	            							<span style="font-size:20px" class="orderamount text-center"></span><br>
	            							<span class="text-center" style="font-size:12px; font-weight:normal">LIFETIME AMOUNT</span>
	            						</td>
	            						<td class="col-xs-4 text-center" style="vertical-align:middle">
	            							<span style="font-size:20px" class="orderavgamount text-center"></span><br>
	            							<span class="text-center" style="font-size:12px; font-weight:normal">AVERAGE AMOUNT</span>
	            						</td>
	            					</tr>
	            					<tr>
	            						<td class="col-xs-4 text-center" style="vertical-align:middle">
	            							<span style="font-size:20px" class="customersince text-center"></span><br>
	            							<span class="text-center" style="font-size:12px; font-weight:normal">CUSTOMER SINCE</span>
	            						</td>
	            						<td class="col-xs-4 text-center" style="vertical-align:middle">
	            							<span style="font-size:20px" class="lastvisit text-center"></span><br>
	            							<span class="text-center" style="font-size:12px; font-weight:normal">LAST VISIT</span>
	            						</td>
	            					</tr>
	            				</table>
	            			</div>
            			</div>
            		</form>
            	</div>
            </div>
        </div>
    </div>
</div>