<div class="modal fade" id="myModalEditCity" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <input type="hidden" id="getDataLink" value="{{ url('getCityData') }}">
    <div class="modal-dialog" style="width:50%">
        <div class="modal-content">
            <div class="modal-header" style="background-color:#224098; color:white">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="title text-center">Edit City</h4>
            </div>
            <div class="modal-body row" style="color:black">
                <div class="loading-div text-center fa-2x hidden">
                    <span class="fa fa-spin fa-spinner"></span>
                </div>
                <div class="content hidden">
                    <form method="POST" id="edit-city-form" class="col-xs-12" style="padding:10px" action="{{ url('doEditCity') }}">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    	<input type="hidden" name="city_id">
                        <div class="form-group col-xs-12">
                            <div class="col-xs-4" style="padding:1.3% 0">Province Name :</div
                            >
                            <div class="col-xs-8" style="padding:0">
                                <select class="form-control" name="province_name">
                                	<option class="hidden" value="null">Select a province name</option>
                                <?php
                                    foreach($province as $d) {
                                ?>
                                    <option value="{{ $d->province_name }}">{{ $d->province_name }}</option>
                                <?php
                                    }
                                ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group col-xs-12">
                            <div class="col-xs-4" style="padding:1.3% 0">Nama Kota :</div
                            >
                            <div class="col-xs-8" style="padding:0">
                                <input type="text" class="form-control" name="city_name" placeholder="Type a city name here">
                            </div>
                        </div>
                        <div class="col-xs-12">
                        	<input type="submit" class="btn btn-primary pull-right" value="Submit" style="margin-top:10px">
                        	<input type="submit" class="btn btn-default pull-right" value="Cancel" style="margin:10px" data-dismiss="modal" aria-label="Close">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>