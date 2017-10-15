<div class="modal fade" id="myModalChangeStatus" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="width:50%">
        <div class="modal-content">
            <div class="modal-header" style="background-color:#224098; color:white">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="title text-center">Change Status</h4>
            </div>
            <div class="modal-body row" style="color:black">
                <div class="error-msg col-sm-12 text-center" style="margin-top:1%; color:red"></div>
                <div class="loading-div text-center hidden">
                    <span class="fa fa-spinner fa-spin fa-2x"></span>
                </div>
            	<div class="content">
            		<form method="POST" action="{{ url('doChangeStatus') }}" id="changeStatusForm">
            			<input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="hidden" name="id">
                        <input type="hidden" name="email" value="false">
            			<div class="form-group col-xs-12">
            				<div class="col-xs-4">Status</div>
            				<div class="col-xs-1">:</div>
            				<div class="col-xs-7">
            					<select class="form-control" name="status">
            						<option value="menunggu pembayaran">Menunggu Pembayaran</option>
            						<option value="pembayaran terkonfirmasi">Pembayaran Terkonfirmasi</option>
            						<option value="pesanan terkonfirmasi">Pesanan Terkonfirmasi</option>
            						<option value="pesanan terkirim">Pesanan Terkirim</option>
            						<option value="pesanan dibatalkan">Pesanan Dibatalkan</option>
            					</select>
            				</div>
            			</div>
            			<div class="form-group col-xs-12">
            				<div class="col-xs-4">Admin Note</div>
            				<div class="col-xs-1">:</div>
            				<div class="col-xs-7">
            					<textarea class="form-control" rows="3" name="admin_note"></textarea>
            				</div>
            			</div>
            			<div class="col-xs-12">
            				<div class="col-xs-12">
                                <input type="button" class="btn btn-primary pull-right submitandsend hidden" value="Submit and Send Email">
	            				<input type="submit" class="btn btn-primary pull-right" value="Submit" style="margin-right:1%">
	            				<input type="button" class="btn btn-default pull-right" value="cancel" data-dismiss="modal" style="margin-right:1%">
            				</div>
            			</div>
            		</form>
            	</div>
            </div>
        </div>
    </div>
</div>