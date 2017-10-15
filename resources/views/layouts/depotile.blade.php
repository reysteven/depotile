<!DOCTYPE html>
<html>
<head>
    <title>{{ $title }} - Depotile.com</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- OPEN GRAPH META -->
    <?php
        $name = "DEPOTILE.COM";
        if(isset($item->item_name)) {
            $name = $item->item_name;
        }else if(isset($item->add_on_name)) {
            $name = $item->add_on_name;
        }

        $desc = "Destinasi online terlengkap untuk MENCARI INSPIRASI, MEMILIH dan BERBELANJA berbagai jenis ubin seperti Keramik, Homogenous Tile, Parquet, Mozaic, Vinyl, dan Batu Alam.";
        if(isset($item->itemDesc)) {
            if($item->itemDesc != 'null') {
                $desc = $item->itemDesc;
            }
        }

        $img = "";
        if(isset($item->img_name1)) {
            $img = 'admin/public/assets/image/item-image/small/'.$item->img_name1;
        }else if(isset($item->img_name)) {
            $img = 'admin/public/assets/image/item-image/add-on/small/'.$item->img_name;
        }else {
            $img = 'public/img/logo/logo-primary.png';
        }
    ?>
    <meta property="og:title" content="{{ $name }}" />
    <meta property="og:url" content="{{ Request::url() }}" />
    <meta property="og:type" content="website" />
    <meta property="og:description" content="{{ $desc }}" />
    <meta property="og:image" content="{{ asset($img) }}" />

    <!-- TWITTER META -->
    <meta name="twitter:card" content="" />
    <meta name="twitter:title" content="" />
    <meta name="twitter:url" content="" />
    <meta name="twitter:image" content="" />

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

    <link rel="icon" href="{{ asset('admin/public/assets/image/icon/favicon.ico') }}">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('public/css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('public/css/jquery-ui.min.css') }}">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Swiper/3.4.0/css/swiper.min.css">

    <style type="text/css">
        .detailTopWrap .detailMidBox .detailTitleWrap h1 div.productTitle {
            font-size: 28px;
            font-weight: 600;
            font-family: "Titillium Web", sans-serif;
            color: #404040;
            margin: 0;
            text-transform: uppercase;
            position: relative;
            width: 90%;
        }
    </style>

    <input type="hidden" id="unauthorizedLink" value="{{ url('unauthorized') }}">

    <script type="text/javascript">
        // var pass = prompt("Please enter password");
        // if(pass == "d3potile") {
            
        // }else {
        //     var link = document.getElementById("unauthorizedLink").value;
        //     window.location.href = link;
        // }
    </script>
    @yield('css')
</head>
<body>
<div id="app" class="content">
    <input type="hidden" id="ajax_token" value="{{ csrf_token() }}">
    <input type="hidden" id="getAutoCompleteDataLink" value="{{ url('getAutoCompleteData') }}">
    <input type="hidden" id="getCalcDataLink" value="{{ url('doGetCalcData') }}">
    <input type="hidden" id="getAddOnDataLink" value="{{ url('doGetAddOnData') }}">
    <input type="hidden" id="addonImgPath" value="{{ asset('admin/public/assets/image/item-image/add-on/') }}">
    <div id="html-error-msg"></div>
    <div class="modal fade" id="myModalProductCart" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog" style="width:50%; margin:18% auto">
            <div class="modal-content">
                <div class="modal-body row" style="color:black">
                    <div class="error-msg col-sm-12 text-center" style="margin-top:1%; color:red"></div>
                    <div class="loading-div text-center hidden">
                        <span class="fa fa-spinner fa-spin fa-2x"></span>
                    </div>
                    <div class="content text-center">
                        <div class="text-center" style="margin:0 4% 2% 4%; border-bottom:1px solid; padding-bottom:2%">
                            <img src="{{ asset('public/img/icon/troli.png') }}" style="width: 7%">
                            <span style="color:#224098; font-size:18px">DEPOTILE</span>
                        </div>
                        <h4>Produk anda sudah masuk ke troli</h4>
                        <div class="text-center">
                            <input type="button" class="btn btn-default" data-dismiss="modal" value="Ok">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php
        // JUST ADDED TO CART DETECTOR
        // ---------------------------
        if(Session::get('cartCount') === null) {
            Session::put('cartCount', 0);
        }
        $cart = json_decode(Session::get('cart'));
        $qty_total = 0;
        if(sizeof($cart) > 0) {
            foreach($cart as $d) {
                $qty_total += $d->qty;
            }
        }
        if($qty_total > Session::get('cartCount')) {
            Session::put('cartCount', $qty_total);
            $notif = 1;
        }else {
            Session::put('cartCount', $qty_total);
            $notif = 0;
        }
    ?>
    <input type="hidden" name="notifIndex" value="{{ $notif }}">
    @include('layouts.header')
    @include('layouts.menu')
    @yield('content')
    @include('layouts.footer')
</div>
@include('layouts.mobileMenu')

<!-- Custom JavaScript -->
<script src="{{ asset('public/js/app.js') }}"></script>
<script src="{{ asset('public/js/jquery-ui.min.js') }}"></script>
<script src="{{ asset('public/js/custom.js') }}"></script>

<!-- Auto Numeric -->
<script type="text/javascript" src="{{ asset('public/js/auto-numeric/autoNumeric.js') }}"></script>

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/Swiper/3.4.0/js/swiper.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/Swiper/3.4.0/js/swiper.jquery.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.11.2/js/bootstrap-select.min.js"></script>

<script>
  window.fbAsyncInit = function() {
    FB.init({
      appId      : '447191775645206',
      cookie     : true,
      xfbml      : true,
      version    : 'v2.8'
    });
    FB.AppEvents.logPageView();   
  };

  (function(d, s, id){
     var js, fjs = d.getElementsByTagName(s)[0];
     if (d.getElementById(id)) {return;}
     js = d.createElement(s); js.id = id;
     js.src = "//connect.facebook.net/en_US/sdk.js";
     fjs.parentNode.insertBefore(js, fjs);
   }(document, 'script', 'facebook-jssdk'));
</script>

@yield('js')
</body>
</html>