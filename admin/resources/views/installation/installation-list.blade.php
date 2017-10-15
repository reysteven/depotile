@extends('base')

@section('content')
    <div id="wrapper">

        @include('installation/add-installation')

        <input type="hidden" id="get-installation-link" value="{{ url('doGetInstallationData') }}">
        <input type="hidden" id="add-installation-link" value="{{ url('doAddInstallation') }}">
        <input type="hidden" id="edit-installation-link" value="{{ url('doEditInstallation') }}">
        <input type="hidden" id="del-installation-link" value="{{ url('doDeleteInstallation') }}">

        <form id="delete-installation-form" method="POST" action="{{ url('doDeleteInstallation') }}">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <input type="hidden" name="data">
        </form>

        <div class="modal fade" id="myModalDelInstallationConfirmation" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="top:30%">
            <div class="modal-dialog" style="width:30%; color:black">
                <div class="modal-content">
                    <div class="modal-body row">
                        <p class="text-center">Are you sure for deleting this/these installation?</p>
                        <div class="text-center">
                            <input type="hidden" name="type">
                            <input type="hidden" name="id">
                            <input type="button" class="btn btn-warning" value="Yes" style="width:15%" name="delInstallationConfirmButton">
                            <input type="button" class="btn btn-default" value="No" style="width:15%" data-dismiss="modal">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Installation Manager</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Installation Manager
                        </div>
                        <div class="panel-body" style="font-weight:normal">
                            <input type="button" class="btn btn-primary pull-left" value="Add Installation" style="margin-bottom:10px" data-toggle="modal" data-target="#myModalAddInstallation" data-type="add">
                            <input type="button" class="btn btn-danger pull-right" value="Delete Selected" data-toggle="modal" data-target="#myModalDelInstallationConfirmation" data-type="mass">
                            <table class="table table-bordered" id="installation-list-table">
                                <tr>
                                    <th class="col-xs-1 text-center">
                                        <input type="checkbox" class="checkall" onclick="checkall(event)">
                                    </th>
                                    <th class="col-xs-5 text-center">Installation Name</th>
                                    <th class="col-xs-5 text-center">Installation Description</th>
                                    <th class="col-xs-1 text-center">Action</th>
                                </tr>
                                @if(sizeof($installation) > 0)
                                @foreach($installation as $d)
                                <tr>
                                    <td class="text-center" style="vertical-align:middle">
                                        <input type="checkbox" class="checkthis" data-id="{{ $d->id }}">
                                    </td>
                                    <td class="text-center" style="vertical-align:middle">{{ $d->installation_name }}</td>
                                    <td class="text-center" style="vertical-align:middle">{{ $d->installation_desc }}</td>
                                    <td class="text-center" style="vertical-align:middle">
                                        <a href="#" class="edit-installation-link" data-id="{{ $d->id }}" title="edit" data-toggle="modal" data-target="#myModalAddInstallation" data-type="edit">
                                            <span class="fa fa-pencil"></span>
                                        </a>
                                        <a href="#" class="del-installation-link" data-id="{{ $d->id }}" title="hapus" data-toggle="modal" data-target="#myModalDelInstallationConfirmation" data-type="single">
                                            <span class="fa fa-trash"></span>
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                                @else
                                <tr>
                                    <td colspan="3" class="text-center">NO DATA</td>
                                </tr>
                                @endif
                            </table>
                        </div>
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->

    <script type="text/javascript" src="{{ asset('public/assets/js/installation.js') }}"></script>
@endsection
