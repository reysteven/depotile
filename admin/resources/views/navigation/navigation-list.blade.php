@extends('base')

@section('content')
    <div id="html-error-msg"></div>
    <div id="wrapper">

    @include('navigation/add-navigation')
        
    <div class="modal fade" id="myModalDelNavigationConfirmation" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="top:30%">
            <div class="modal-dialog" style="width:30%; color:black">
                <div class="modal-content">
                    <div class="modal-body row">
                        <p class="text-center">Are you sure for deleting this/these navigation?</p>
                        <div class="text-center">
                            <input type="hidden" name="type">
                            <input type="hidden" name="id">
                            <input type="button" class="btn btn-warning" value="Yes" style="width:15%" name="delNavigationConfirmButton">
                            <input type="button" class="btn btn-default" value="No" style="width:15%" data-dismiss="modal">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <form method="POST" action="{{ url('doDeleteNavigation') }}" id="del-navigation-form">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <input type="hidden" name="data">
        </form>

        <input type="hidden" id="addNavigationLink" value="{{ url('doAddNavigation') }}">
        <input type="hidden" id="getNavigationDataLink" value="{{ url('doGetNavigationData') }}">
        <input type="hidden" id="editNavigationLink" value="{{ url('doEditNavigation') }}">
        <input type="hidden" id="imgSrcLink" value="{{ asset('public/assets/image/nav-image') }}">

        <input type="hidden" id="tag-data" value="{{ json_encode($tag) }}">

        <div id="page-wrapper">
            <div class="row">
                <div class="col-xs-12">
                    <h1 class="page-header">Navigation Manager</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-xs-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Navigation Manager
                        </div>
                        <div class="panel-body" style="font-weight:normal">
                            <div class="col-xs-12 dropdown" style="padding:0">
                                <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#myModalAddNavigation" data-type="add">Add Navigation</a>
                                <input type="button" class="btn btn-danger pull-right del-many-btn" value="Delete Selected" data-toggle="modal" data-target="#myModalDelNavigationConfirmation" data-type="mass">
                            </div>
                            <div class="col-xs-12" style="padding-bottom:1%">
                                <h3>Searching</h3>
                                <div class="tile-search">
                                    <form method="POST" action="{{ url('navigation-manager') }}" id="navigation-search-form">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <input type="hidden" name="search_flag" value="true">
                                        <div class="form-group col-xs-7" style="padding:0.2% 0">
                                            <div class="col-xs-4" style="padding:0.5% 0">Navigation Name: </div>
                                            <div class="col-xs-8" style="padding:0">
                                                <input type="text" class="form-control" name="search_name" value="{{ isset($search_flag) ? $navigation_name : '' }}">
                                            </div>
                                        </div>
                                        <div class="form-group col-xs-7" style="padding:0.2% 0">
                                            <div class="col-xs-4" style="padding:0.5% 0">Relation: </div>
                                            <div class="col-xs-8" style="padding:0">
                                                <div class="col-xs-6">
                                                    <input type="radio" name="search_relation" value="1">&nbspInclude All
                                                </div>
                                                <div class="col-xs-6">
                                                    <input type="radio" name="search_relation" value="2">&nbspEither
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group col-xs-7" style="padding:0.2% 0">
                                            <input type="submit" class="btn btn-primary pull-right" value="Search">
                                            @if(isset($search_flag_tile))
                                            <a href="{{ url('navigation-manager') }}" class="btn btn-warning pull-right" style="margin-right:10px">Clear Search</a>
                                            @endif
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="col-xs-12" style="padding:10px 0">
                                <table class="table table-bordered" id="navigation-list-table">
                                    <tr>
                                        <th class="text-center col-xs-1">
                                            <input type="checkbox" class="checkall" onclick="checkall(event)">
                                        </th>
                                        <th class="text-center col-xs-1">ID</th>
                                        <th class="text-center col-xs-5">Navigation Name</th>
                                        <th class="text-center col-xs-4">Relation</th>
                                        <th class="text-center col-xs-1">Action</th>
                                    </tr>
                                    @if(sizeof($navigation) > 0)
                                    @foreach($navigation as $d)
                                    <tr>
                                        <td class="text-center">
                                            <input type="checkbox" class="checkthis" data-id="{{ $d->id }}">
                                        </td>
                                        <td class="text-center">{{ $d->id }}</td>
                                        <td class="text-center">{{ $d->navigation_name }}</td>
                                        <td class="text-center">{{ ($d->relation == 1) ? 'Include All' : 'Either' }}</td>
                                        <td class="text-center">
                                            <a href="#" class="edit-province" title="edit" data-toggle="modal" data-target="#myModalAddNavigation" data-id="{{ $d->id }}" data-type="edit"><span class="fa fa-pencil"></span></a>
                                            <a href="#" class="del-province" data-toggle="modal" data-target="#myModalDelNavigationConfirmation" data-id="{{ $d->id }}" data-type="single" title="delete"><span class="fa fa-trash"></span></a>
                                        </td>
                                    </tr>
                                    @endforeach
                                    @else
                                    <tr>
                                        <td colspan="5" class="text-center">NO DATA</td>
                                    </tr>
                                    @endif
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript" src="{{ asset('public/assets/js/navigation.js') }}"></script>
@endsection