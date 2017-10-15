<div class="modal fade" id="myModalAddBrand" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="width:50%">
        <div class="modal-content">
            <div class="modal-header" style="background-color:#224098; color:white">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="title text-center">Tambah Merk</h4>
            </div>
            <div class="modal-body row" style="color:black">
                <div class="error-msg col-sm-12 text-center" style="margin-top:1%; color:red"></div>
                <div class="loading-div text-center hidden">
                    <span class="fa fa-spinner fa-spin fa-2x"></span>
                </div>
            	<div class="content">
                    <form method="POST" id="brand-form" action="{{ url('doAddBrand') }}">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="hidden" name="brand_id">
                		<div class="form-group col-xs-12">
                			<div class="col-xs-4" style="padding-top:1%">Nama Merk</div>
                			<div class="col-xs-1" style="padding-top:1%">:</div>
                			<div class="col-xs-7">
                				<input type="text" class="form-control" name="brand_name">
                			</div>
                		</div>
                		<div class="col-xs-12">
                        	<input type="hidden" name="logo_img">
                        	<table class="col-xs-12">
                        		<tr>
                        			<td class="col-xs-6 text-center" style="vertical-align:center">
                        				<img src="{{ asset('public/assets/image/image-storage/blank.png') }}" width="200px" class="logo_img" data-url="{{ asset('public/assets/image/logo-image') }}" data-default="{{ asset('public/assets/image/image-storage/blank.png') }}" >
                        			</td>
                        			<td class="col-xs-6 text-center" style="vertical-align:center">
                        				<input type="button" class="btn btn-primary change-logo-img-btn hidden" value="Ubah Gambar">
                        				<div class="img-list" style="overflow-y:scroll; max-height:250px; padding:0">
    			                            <div class="text-center">DAFTAR GAMBAR</div>
    			                             @foreach($logo_img as $d)
    			                                <a class="thumbnail logo-img-item-link" href="#thumb" style="margin-bottom:10px" data-value="{{ $d }}">
    			                                    {{ $d }}
    			                                    <span>
    			                                        <img src="{{ asset('public/assets/image/logo-image/'.$d) }}" width="150px">
    			                                    </span>
    			                                </a>
    			                            @endforeach
    			                        </div>
                        			</td>
                        		</tr>
                        	</table>
    	                </div>
                        <div class="col-xs-12" style="margin-top:10px">
                            <input type="submit" class="btn btn-primary pull-right" value="Submit" style="margin-right:2%">
                            <input type="button" class="btn btn-default pull-right" value="Cancel" style="margin-right:1%">
                        </div>
                    </form>
            	</div>
            </div>
        </div>
    </div>
</div>