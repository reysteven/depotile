<div class="modal fade" id="myModalImportExportTile" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="width:50%">
        <div class="modal-content">
            <div class="modal-header" style="background-color:#224098; color:white">
                <input type="hidden" id="parent-hash-code">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="title text-center">Impor/Ekspor Data Keramik</h4>
            </div>
            <div class="modal-body row" style="color:black">
                <div class="loading-div text-center hidden">
                    <span class="fa fa-spinner fa-spin fa-2x"></span>
                </div>
                <div class="content">
                    <div class="col-xs-12">
                        <p style="text-align:justify">This menu is used to do both data import or data export in excel format. You should export existing data first <a href="{{ url('doExportTile') }}" id="export-excel-link" target="_blank">here</a> so you know the table format and the existing data, but if you're already sure with excel that will be imported, you can import your excel below.</p>
                        <form method="POST" id="excel-uploader-form" action="{{ url('doUploadTile') }}" enctype="multipart/form-data">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <br>
                            <div class="form-group">
                                <input type="file" style="display:none" name="excelFile">
                                <div class="col-xs-6" style="padding:0 1% 0 0">
                                    <input type="text" class="form-control file-name-text" disabled>
                                </div>
                                <div class="col-xs-3" style="padding:0 1%">
                                    <input type="button" class="btn btn-default file-browser" value="Browse">
                                </div>
                                <div class="col-xs-3 text-right" style="padding:0 1%">
                                    <input type="button" class="btn btn-primary" id="excel-uploader-submit" value="Submit">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>