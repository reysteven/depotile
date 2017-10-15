<div class="modal fade" id="myModalPaymentDetail" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="width:50%">
        <div class="modal-content">
            <div class="modal-header" style="background-color:#224098; color:white">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="title text-center">Payment Confirmation</h4>
            </div>
            <div class="modal-body row" style="color:black">
                <div class="error-msg col-sm-12 text-center" style="margin-top:1%; color:red"></div>
                <div class="loading-div text-center hidden">
                    <span class="fa fa-spinner fa-spin fa-2x"></span>
                </div>
            	<div class="content hidden">
            		<div class="confirmed col-xs-12 hidden">
            			<div class="form-group col-xs-12">
	            			<div class="col-xs-4">
	            				<strong>Bank</strong>
	            			</div>
	            			<div class="col-xs-1">:</div>
	            			<div class="col-xs-7 bank"></div>
	            		</div>
	            		<div class="form-group col-xs-12">
	            			<div class="col-xs-4">
	            				<strong>Account Name</strong>
	            			</div>
	            			<div class="col-xs-1">:</div>
	            			<div class="col-xs-7 account_name"></div>
	            		</div>
	            		<div class="form-group col-xs-12">
	            			<div class="col-xs-4">
	            				<strong>Payment Amount</strong>
	            			</div>
	            			<div class="col-xs-1">:</div>
	            			<div class="col-xs-7 payment_amount"></div>
	            		</div>
	            		<div class="form-group col-xs-12">
	            			<div class="col-xs-4">
	            				<strong>Payment Date</strong>
	            			</div>
	            			<div class="col-xs-1">:</div>
	            			<div class="col-xs-7 payment_date"></div>
	            		</div>
	            		<div class="form-group col-xs-12">
	            			<div class="col-xs-4">
	            				<strong>Note</strong>
	            			</div>
	            			<div class="col-xs-1">:</div>
	            			<div class="col-xs-7 note"></div>
	            		</div>
            		</div>
            		<div class="unconfirmed text-center col-xs-12 hidden">
            			<h4>NO PAYMENT CONFIRMATION</h4>
            		</div>
            	</div>
            </div>
        </div>
    </div>
</div>