<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>DEPOTILE.com</title>

    <link rel="icon" href="{{ asset('public/assets/image/icon/favicon.ico') }}">

    <!-- jQuery -->
    <script type="text/javascript" language="javascript" src="{{ asset('public/assets/js/jquery.js') }}"></script>

    <!-- JQuery UI -->
    <link rel="stylesheet" href="{{ asset('public/assets/css/jquery-ui.min.css') }}" type="text/css">
    <script type="text/javascript" src="{{ asset('public/assets/js/jquery-ui.min.js') }}"></script>

    <!-- Bootstrap -->
    <link href="{{ asset('public/assets/css/bootstrap.min.css') }}" rel="stylesheet">
    <script src="{{ asset('public/assets/js/bootstrap.min.js') }}"></script>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('public/assets/font-awesome/css/font-awesome.min.css') }}" type="text/css">

    <!-- Preview Hover -->
    <link href="{{ asset('public/assets/css/preview-hover.css') }}" rel="stylesheet" type="text/css" media="all">

    <!-- DATATABLE CSS -->
    <link rel="stylesheet" type="text/css" href="{{ asset('public/assets/datatable/media/css/jquery.dataTables.css') }}">

    <!-- Custom CSS -->
    <link href="{{ asset('public/assets/css/heroic-features.css') }}" rel="stylesheet">
    <link href="{{ asset('public/assets/css/custom.css') }}" rel="stylesheet">
    <link href="{{ asset('public/assets/css/sb-admin-2.css') }}" rel="stylesheet">
    <link href="{{ asset('public/assets/metisMenu/dist/metisMenu.min.css') }}" rel="stylesheet">

    <!-- Auto Numeric -->
    <script type="text/javascript" src="{{ asset('public/assets/auto-numeric/autoNumeric.js') }}"></script>

    <!-- Text Editor -->
    <script type="text/javascript" src="{{ asset('public/assets/tinymce/js/tinymce/tinymce.min.js') }}"></script>

    <!-- DATATABLE JS -->
    <script type="text/javascript" src="{{ asset('public/assets/datatable/media/js/jquery.dataTables.js') }}"></script>

    <!-- General Custom JS -->
    <script src="{{ asset('public/assets/metisMenu/dist/metisMenu.min.js') }}"></script>
    <script src="{{ asset('public/assets/js/general-custom.js') }}" type="text/javascript" charset="utf-8"></script>
    <script src="{{ asset('public/assets/js/sb-admin-2.js') }}" type="text/javascript" charset="utf-8"></script>

    <script>
        function contain(array, value) {
            var flag = false;
            for(var a=0;a<array.length;a++) {
                if(array[a] == value) {
                    flag = true;
                    break;
                }
            }
            return flag;
        }
    </script>

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    
</head>

<input type="hidden" name="ajax_token" value="{{ csrf_token() }}">

<!-- Navigation -->
<nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0" id="admin-navbar">
    <div class="navbar-header">
        <a class="navbar-brand" href="/depotile/admin/">Admin Menu</a>
    </div>
    <!-- /.navbar-header -->
    <ul class="nav navbar-top-links navbar-right">
        <li>
            <a href="http://depotile.com" target="_blank">Visit Website</a>
        </li>
        <li>
            <a href="{{ url('doLogout') }}">Log Out</a>
        </li>
    </ul>

    <div class="navbar-default sidebar" role="navigation">
        <div class="sidebar-nav navbar-collapse">
            <ul class="nav" id="side-menu">
                <li>
                    <a href="#">User<span class="fa arrow"></span>
                    </a>
                    <ul class="nav nav-second-level collapse">
                        <li>
                            <a href="{{ url('user/customer-manager') }}"></i>Customer</a>
                        </li>
                        <li>
                            <a href="{{ url('user/admin-manager') }}"></i>Admin</a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="#">Merchandise<span class="fa arrow"></span>
                    </a>
                    <ul class="nav nav-second-level collapse">
                        <li>
                            <a href="{{ url('photo-manager') }}"></i>Photo Manager</a>
                        </li>
                        <li>
                            <a href="#"></i>Location Manager<span class="fa arrow"></span></a>
                            <ul class="nav nav-third-level">
                                <li>
                                    <a href="{{ url('location/province-manager') }}">Province Manager</a>
                                </li>
                                <li>
                                    <a href="{{ url('location/city-manager') }}">City Manager</a>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <a href="{{ url('category-manager') }}"></i>Category Manager</a>
                        </li>
                        <li>
                            <a href="{{ url('tag-manager') }}"></i>Tag Manager</a>
                        </li>
                        <li>
                            <a href="{{ url('navigation-manager') }}"></i>Navigation Manager</a>
                        </li>
                        <li>
                            <a href="{{ url('installation-manager') }}"></i>Installation Manager</a>
                        </li>
                        <li>
                            <a href="{{ url('brand-manager') }}"></i>Brand Manager</a>
                        </li>
                        <li>
                            <a href="{{ url('fee-manager') }}"></i>Shipping Fee Manager</a>
                        </li>
                        <li>
                            <a href="#"></i>Item Manager<span class="fa arrow"></span></a>
                            <ul class="nav nav-third-level collapse">
                                <li>
                                    <a href="{{ url('item/tile-manager') }}">Tile</a>
                                </li>
                                <li>
                                    <a href="{{ url('item/add-on-manager') }}">Add On</a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="{{ url('order-manager') }}"></i>Order List</a>
                </li>
                <li>
                    <a href="#"></i>Look Book</a>
                </li>
                <li>
                    <a href="#"></i>Show Room</a>
                </li>
            </ul>
        </div>
        <!-- /.sidebar-collapse -->
    </div>
    <!-- /.navbar-static-side -->
</nav>

@yield('content');