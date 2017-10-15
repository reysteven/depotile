@extends('base')

@section('content')
    <div id="html-error-msg"></div>
    <div id="wrapper">

        @include('tag/add-sub-tag')

        <form id="delete-tag-form" method="POST" action="{{ url('doDeleteTag') }}">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <input type="hidden" name="data">
        </form>
        <form id="delete-subtag-form" method="POST" action="{{ url('doDeleteSubTag') }}">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <input type="hidden" name="data">
        </form>

        <input type="hidden" id="edit-tag-link" value="{{ url('doEditTag') }}">
        <input type="hidden" id="add-sub-tag-link" value="{{ url('doAddSubTag') }}">
        <input type="hidden" id="get-sub-tag-data-link" value="{{ url('doGetSubTagData') }}">
        <input type="hidden" id="edit-sub-tag-link" value="{{ url('doEditSubTag') }}">
        <input type="hidden" id="img-icon-src" value="{{ asset('public/assets/image/tag-icon') }}">
        <input type="hidden" id="del-sub-tag-link" value="{{ url('doDeleteSubTag') }}">

        <div class="modal fade" id="myModalDelTagConfirmation" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="top:30%">
            <div class="modal-dialog" style="width:30%; color:black">
                <div class="modal-content">
                    <div class="modal-body row">
                        <p class="text-center">Are you sure for deleting this/these tag?</p>
                        <div class="text-center">
                            <input type="hidden" name="type">
                            <input type="hidden" name="id">
                            <input type="button" class="btn btn-warning" value="Yes" style="width:15%" name="delTagConfirmButton">
                            <input type="button" class="btn btn-default" value="No" style="width:15%" data-dismiss="modal">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="myModalDelSubTagConfirmation" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="top:30%">
            <div class="modal-dialog" style="width:30%; color:black">
                <div class="modal-content">
                    <div class="modal-body row">
                        <p class="text-center">Are you sure for deleting this/these sub tag?</p>
                        <div class="text-center">
                            <input type="hidden" name="type">
                            <input type="hidden" name="id">
                            <input type="button" class="btn btn-warning" value="Yes" style="width:15%" name="delSubTagConfirmButton">
                            <input type="button" class="btn btn-default" value="No" style="width:15%" data-dismiss="modal">
                        </div>
                        <div class="text-center loading-div hidden">
                            <span class="fa fa-spin fa-spinner"></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="myModalChangeShowedTagConfirmation" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="top:30%">
            <div class="modal-dialog" style="width:30%; color:black">
                <div class="modal-content">
                    <div class="modal-body row">
                        <p class="text-center">Are you sure for changing these showed tags?</p>
                        <div class="text-center">
                            <input type="button" class="btn btn-warning" value="Yes" style="width:15%" name="changeShowedTagConfirmButton">
                            <input type="button" class="btn btn-default" value="No" style="width:15%" data-dismiss="modal">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Tag Manager</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Tag Manager
                        </div>
                        <div class="panel-body" style="font-weight:normal">
                            <input type="button" class="btn btn-primary pull-left" value="Add Tag" style="margin-bottom:10px" data-toggle="collapse" data-target="#add-tag-form-wrapper">
                            <input type="button" class="btn btn-danger pull-right delete-all-btn" value="Delete Selected" style="margin-bottom:10px" data-toggle="modal" data-target="#myModalDelTagConfirmation" data-type="mass">
                            <div class="col-xs-12 collapse" id="add-tag-form-wrapper" style="padding:0">
                                <form method="POST" id="add-tag-form" class="col-xs-6" style="padding:10px 0" action="{{ url('doAddTag') }}">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    <div class="form-group">
                                        <div class="col-xs-4" style="padding:1.3% 0">Tag Name :</div
                                        >
                                        <div class="col-xs-8" style="padding:0">
                                            <input type="text" class="form-control" name="tag_name" placeholder="Type tag name here">
                                            <input type="submit" class="btn btn-primary pull-right" value="Submit" style="margin-top:10px">
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <table class="table table-bordered col-xs-12" id="tag-list-table" style="padding:0">
                                <tr>
                                    <th class="col-xs-1 text-center">
                                        <input type="checkbox" class="checkall" onclick="checkall(event)">
                                    </th>
                                    <th class="col-xs-1 text-center">ID</th>
                                    <th class="col-xs-9 text-center">Tag Name</th>
                                    <th class="col-xs-2 text-center">Action</th>
                                </tr>
                                @if(sizeof($tag) > 0)
                                @foreach($tag as $d)
                                <tr>
                                    <td class="text-center">
                                        <input type="checkbox" class="checkthis" data-id="{{ $d['id'] }}">
                                    </td>
                                    <td class="text-center">{{ $d['id'] }}</td>
                                    <td class="text-center tag-name-col" data-id="{{ $d['id'] }}">{{ $d['tag_name'] }}</td>
                                    <td class="text-center">
                                        <a href="#" title="detail" data-toggle="collapse" data-target="#tag-detail-{{ $d['id'] }}" title="detail">
                                            <span class="fa fa-list-alt"></span>
                                        </a>
                                    </td>
                                </tr>
                                <tr id="tag-detail-{{ $d['id'] }}" class="collapse">
                                    <td colspan="4" class="text-center" style="background-color:#286090">
                                        <div class="col-xs-12">
                                            <div class="text-center">
                                                <h4 style="color:white">Tag Detail</h4>
                                            </div>
                                            <div class="form-group col-xs-6" style="padding:0">
                                                <div class="col-xs-3 text-left" style="padding:1% 0 0 0; color:white">Tag Name : </div>
                                                <div class="col-xs-7">
                                                    <input type="text" class="form-control tag-name-input" name="tag_name" value="{{ $d['tag_name'] }}" data-id="{{ $d['id'] }}" disabled>
                                                </div>
                                                <div class="col-xs-1" style="padding:1% 0 0 0">
                                                    <a href="#" class="edit-tag-name-link" title="change name" style="color:white">
                                                        <span class="fa fa-pencil"></span>
                                                    </a>
                                                    <a href="#" class="submit-tag-name-link hidden" title="ok" style="color:white" data-id="{{ $d['id'] }}">
                                                        <span class="fa fa-check"></span>
                                                    </a>
                                                    <div class="loading-div hidden" style="color:white">
                                                        <span class="fa fa-spin fa-spinner"></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xs-5 text-right pull-right" style="padding:0">
                                                <input type="button" class="btn btn-danger del-tag-btn" value="Delete Tag" data-id="{{ $d['id'] }}" data-toggle="modal" data-target="#myModalDelTagConfirmation" data-type="single">
                                            </div>
                                            <div class="col-xs-12" style="padding:0"><hr></div>
                                            <div class="col-xs-12 text-left" style="padding:0 0 10px 0">
                                                <input type="button" class="btn btn-default add-sub-tag-btn" value="Add Sub Tag" data-toggle="modal" data-target="#myModalAddSubTag" data-id="{{ $d['id'] }}" data-type="add">
                                            </div>
                                            <!-- <div class="col-xs-12 collapse" id="add-sub-tag-form-wrapper-{{ $d['id'] }}" style="padding:0">
                                                <form method="POST" name="add-sub-tag-form" class="col-xs-6" style="padding:10px 0" action="{{ url('doAddSubTag') }}" data-id="{{ $d['id'] }}">
                                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                    <div class="form-group">
                                                        <div class="col-xs-4" style="padding:1.3% 0; color:white">Sub Tag Name :</div
                                                        >
                                                        <div class="col-xs-8" style="padding:0">
                                                            <input type="text" class="form-control" name="sub_tag_name" placeholder="Type sub tag name here">
                                                            <input type="submit" class="btn btn-primary pull-right" value="Submit" style="margin-top:10px">
                                                            <div class="loading-div hidden text-right">
                                                                <span class="fa fa-spin fa-spinner" style="color:white"></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div> -->
                                            <table class="table table-bordered" name="sub-tag-list-table">
                                                <tr>
                                                    <th class="text-center col-xs-1">ID</th>
                                                    <th class="text-center col-xs-10">Sub Tag Name</th>
                                                    <th class="text-center col-xs-1">Action</th>
                                                </tr>
                                                @foreach($d['detail'] as $dd) {
                                                <tr>
                                                    <td class="text-center">{{ $dd->id }}</td>
                                                    <td class="text-center">
                                                        <div class="sub-tag-name-col" data-id="{{ $dd->id }}">{{ $dd->detail_tag_name }}</div>
                                                        <!-- <div class="edit-sub-tag-name-section col-xs-8 col-xs-offset-2 hidden">
                                                            <form method="POST" action="{{ url('doEditSubTag') }}" name="edit-sub-tag-form" data-id="{{ $dd->id }}">
                                                                <input type="hidden" name="detail_id">
                                                                <div class="col-xs-9">
                                                                    <input type="text" class="form-control" name="detail_tag_name" value="{{ $dd->detail_tag_name }}">
                                                                </div>
                                                                <div class="col-xs-3">
                                                                    <input type="submit" class="btn btn-primary" value="Submit">
                                                                    <div class="loading-div hidden">
                                                                        <span class="fa fa-spin fa-spinner"></span>
                                                                    </div>
                                                                </div>
                                                            </form>
                                                        </div> -->
                                                    </td>
                                                    <td class="text-center">
                                                        <a href="#" class="edit-sub-tag-name-link" data-id="{{ $dd->id }}" title="edit" data-toggle="modal" data-target="#myModalAddSubTag" data-type="edit">
                                                            <span class="fa fa-pencil"></span>
                                                        </a>
                                                        <a href="#" class="del-sub-tag-name-link" data-id="{{ $dd->id }}" title="hapus" data-toggle="modal" data-target="#myModalDelSubTagConfirmation">
                                                            <span class="fa fa-trash"></span>
                                                        </a>
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </table>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                                @else
                                <tr>
                                    <td colspan="4" class="text-center">NO DATA</td>
                                </tr>
                                @endif
                            </table>
                            <form method="POST" action="{{ url('doChangeShowedTag') }}" id="showed-tag-form">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <div class="col-xs-12" style="padding:0">
                                    <div class="col-xs-5" style="padding-left:0">
                                        <div class="col-xs-4" style="padding-top:1%">Showed Tag 1 :</div>
                                        <div class="col-xs-8">
                                            <select class="form-control" name="showed_tag_1">
                                                <option class="hidden">Please select a tag name</option>
                                                @foreach($tag as $d)
                                                    @if($d['showed'] == 1)
                                                <option value="{{ $d['id'] }}" selected>{{ $d['tag_name'] }}</option>
                                                    @else
                                                <option value="{{ $d['id'] }}">{{ $d['tag_name'] }}</option>
                                                    @endif
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-xs-5" style="padding-left:0">
                                        <div class="col-xs-4" style="padding-top:1%">Showed Tag 2 :</div>
                                        <div class="col-xs-8">
                                            <select class="form-control" name="showed_tag_2">
                                                <option class="hidden">Please select a tag name</option>
                                                @foreach($tag as $d)
                                                    @if($d['showed'] == 2)
                                                <option value="{{ $d['id'] }}" selected>{{ $d['tag_name'] }}</option>
                                                    @else
                                                <option value="{{ $d['id'] }}">{{ $d['tag_name'] }}</option>
                                                    @endif
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-xs-2" style="padding:0">
                                        <input type="button" class="btn btn-primary pull-right" value="Submit" data-toggle="modal" data-target="#myModalChangeShowedTagConfirmation">
                                    </div>
                                </div>
                            </form>
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

    <script type="text/javascript" src="{{ asset('public/assets/js/tag.js') }}"></script>
@endsection