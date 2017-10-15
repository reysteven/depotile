<!DOCTYPE html>
<html>
<head>
    <title>{{ $title }} - Depotile.com</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

    <link rel="icon" href="{{ asset('admin/public/assets/image/icon/favicon.ico') }}">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('public/css/app.css') }}">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css">
    @yield('css')
</head>
<body class="cart">
<div id="app" class="content  ">
    <input type="hidden" id="ajax_token" value="{{ csrf_token() }}">
    <input type="hidden" id="getAutoCompleteDataLink" value="{{ url('getAutoCompleteData') }}">
    <input type="hidden" id="getCalcDataLink" value="{{ url('doGetCalcData') }}">
    <input type="hidden" id="getAddOnDataLink" value="{{ url('doGetAddOnData') }}">
    <input type="hidden" id="addonImgPath" value="{{ asset('admin/public/assets/image/item-image/add-on/') }}">
    <div id="html-error-msg"></div>
    @include('cart.header')
    @yield('content')
    @include('cart.footer')
</div>

<!-- Custom JavaScript -->
<script src="{{ asset('public/js/app.js') }}"></script>
<script src="{{ asset('public/js/jquery-ui.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('public/js/auto-numeric/autoNumeric.js') }}"></script>
<script src="{{ asset('public/js/custom.js') }}"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.11.2/js/bootstrap-select.min.js"></script>
@yield('js')
</body>
</html>