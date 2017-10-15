@extends('layouts.depotile', ['title' => 'Add On Detail'])

@section('css')
@stop

@section('js')
    <script>
        $(document).ready(function() {
            var swiper = new Swiper('#swiper1', {
                paginationClickable: false,
                slidesPerView: 6,
                spaceBetween: 25,
                loop: true,
                // Disable preloading of all images
                preloadImages: false,
                // Enable lazy loading
                lazyLoading: true,
                nextButton: '.swiperRight',
                prevButton: '.swiperLeft',
                breakpoints: {
                    992: {
                        slidesPerView: 4,
                        spaceBetween: 30
                    },
                    768: {
                        slidesPerView: 3,
                        spaceBetween: 30
                    },
                    640: {
                        slidesPerView: 2,
                        spaceBetween: 20
                    },
                    320: {
                        slidesPerView: 1,
                        spaceBetween: 10
                    }
                }
            });

            $(".fancybox").fancybox();

            attrQty()
        });

        function attrQty(){
            if ($( "#qty" ).val() > 0) {
                $('#submitQty').removeAttr("disabled", "disabled");
            } else {
                $('#submitQty').attr("disabled", "disabled");
            }
        }
    </script>
@stop

@section('content')
<div class="detailTopWrap">
    <div class="container">
        <div class="row">
            <div class="col-lg-4 col-md-4 col-sm-5 col-xs-12">
                <div class="detailImg">
                    <div class="cycle-slideshow"
                         data-cycle-fx="scrollHorz"
                         data-cycle-timeout="0"
                         data-cycle-prev="#prev"
                         data-cycle-next="#next"
                         data-cycle-slides="> div"
                         data-cycle-pager="#no-template-pager"
                         data-cycle-pager-template=""
                    >
                        <div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <a class="fancybox" rel="gallery1" href="{{ asset('admin/public/assets/image/item-image/add-on/xlarge/'.$item->img_name) }}" title="">
                                        <img src="{{ asset('admin/public/assets/image/item-image/add-on/medium/'.$item->img_name) }}" class="imgFull" />
                                    </a>
                                </div>
                            </div>
                        </div><div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <a class="fancybox" rel="gallery1" href="{{ asset('admin/public/assets/image/item-image/add-on/xlarge/'.$item->img_name) }}" title="">
                                        <img src="{{ asset('admin/public/assets/image/item-image/add-on/medium/'.$item->img_name) }}" class="imgFull" />
                                    </a>
                                </div>
                            </div>
                        </div><div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <a class="fancybox" rel="gallery1" href="{{ asset('admin/public/assets/image/item-image/add-on/xlarge/'.$item->img_name) }}" title="">
                                        <img src="{{ asset('admin/public/assets/image/item-image/add-on/medium/'.$item->img_name) }}" class="imgFull" />
                                    </a>
                                </div>
                            </div>
                        </div>

                    </div>
                    <a href=# id="prev" class="prev"><i class="fa fa-chevron-left" aria-hidden="true"></i></a>
                    <a href=# id="next" class="next"><i class="fa fa-chevron-right" aria-hidden="true"></i></a>
                </div>
                <div id=no-template-pager class="cycle-pager external hidden-xs">
                    <!-- using thumbnail image files would be even better! -->
                    <img src="{{ asset('admin/public/assets/image/item-image/add-on/medium/'.$item->img_name) }}" width=80 height=80>
                    <img src="{{ asset('admin/public/assets/image/item-image/add-on/medium/'.$item->img_name) }}" width=80 height=80>
                    <img src="{{ asset('admin/public/assets/image/item-image/add-on/medium/'.$item->img_name) }}" width=80 height=80>
                </div>
            </div>
            <div class="col-lg-5 col-md-5 col-sm-7 col-xs-12">
                <div class="detailMidBox">
                    <div class="breadcrumbWrap hidden-xs">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item"><a href="#">Kategori</a></li>
                            <li class="breadcrumb-item"><a href="#">{{ $item->category_name }}</a></li>
                            <li class="breadcrumb-item"><a href="#">{{ $item->detail_category_name }}</a></li>
                            <li class="breadcrumb-item active">{{ $item->add_on_name }}</li>
                        </ol>
                    </div>
                    <div class="detailTitleWrap">
                        <h1>{{ $item->add_on_name }}</h1>
                        <div class="starWrap">
                            <ul class="starSubWrap pull-right">
                                <li class="starLi"><img src="{{ asset('public/img/icon/rate-nyala.png') }}" class="imgFull" /></li>
                                <li class="starLi"><img src="{{ asset('public/img/icon/rate-nyala.png') }}" class="imgFull" /></li>
                                <li class="starLi"><img src="{{ asset('public/img/icon/rate-nyala.png') }}" class="imgFull" /></li>
                                <li class="starLi"><img src="{{ asset('public/img/icon/rate-nyala.png') }}" class="imgFull" /></li>
                                <li class="starLi"></li>
                            </ul>
                            <div class="clearBoth"></div>
                        </div>
                        <div class="discPrice">
                            @if($item->disc > 0)
                            @php
                                $afterdisc = $item->price_per_pcs * $item->disc / 100
                            @endphp
                            <s>Rp {{ number_format($item->price_per_pcs,0,'.','.') }}/m&sup2;</s>
                            @endif
                            <ul class="list-inline list-unstyled">
                                <li class="brand">Brand: <a href="#">{{ $item->brand_name }}</a></li>
                                <!-- <li class="stockOn">Stock tersedia</li> -->
                            </ul>
                            <div class="clearBoth"></div>
                        </div>
                        @if($item->disc > 0)
                        <p class="realPrice">Rp {{ number_format($afterdisc,0,'.','.') }}/pc</p>
                        @else
                        <p class="realPrice">Rp {{ number_format($item->price_per_pcs,0,'.','.') }}/pc</p>
                        @endif
                    </div>
                    @if(Session::get('sesUserId') !== null)
                    <form action="{{ url('doAddAddonToCart') }}" method="POST">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="hidden" name="id" value="{{ $item->itemId }}">
                    <div class="detailProcess">
                        <div class="rightDetailProcess">
                            <div class="form-group">
                                <label for="box">pc(s)</label>
                                <input maxlength="2" type="text" name="qty" onkeyup="attrQty()" class="form-control" id="qty" placeholder="0">
                            </div>
                        </div>
                        <div class="clearBoth"></div>
                        <div class="centerDetailProcess">
                            <button id="submitQty" disabled="disabled"  type="submit">Tambahkan ke Troli</button>
                        </div>
                    </div>
                    </form>
                    @else
                    <div class="detailProcess text-center">
                        <a href="{{ url('login?type=tile&product='.$item->itemId) }}" class="btn btn-primary" style="width:100%">Login terlebih dahulu</a>
                    </div>
                    @endif
                </div>
            </div>
            <div class="col-lg-3 col-md-3 hidden-sm hidden-xs">
                <div class="infoDetail">
                    <p>Butuh bantuan? Hubungi kami</p>
                    <ul class="list-unstyled">
                        <li><i class="fa fa-phone"></i><a href="#">021-452-3047</a></li>
                        <li><i class="fa fa-envelope"></i><a href="#">help@depotile.com</a></li>
                    </ul>
                </div>
                <div class="infoDetail2">
                    <ul class="list-unstyled">
                        <li>
                            <div class="infoDetail2Box">
                                <img src="{{ asset('public/img/icon/detail1.png') }}" width="35" height="35"  />
                                <p>Gratis Pengiriman</p>
                                <span>Syarat dan ketentuan berlaku</span>
                                <div class="clearBoth"></div>
                            </div>
                        </li>
                        <li>
                            <div class="infoDetail2Box">
                                <img src="{{ asset('public/img/icon/detail2.png') }}" width="35" height="35"  />
                                <p>Area Jabodetabek</p>
                                <span>Cakupan area Jabodetabek</span>
                                <div class="clearBoth"></div>
                            </div>
                        </li>
                        <li>
                            <div class="infoDetail2Box">
                                <img src="{{ asset('public/img/icon/detail3.png') }}" width="35" height="35"  />
                                <p>Hitung Cepat & Tepat</p>
                                <span>Kalkulasi kebutuhan Anda dengan cepat</span>
                                <div class="clearBoth"></div>
                            </div>
                        </li>
                    </ul>
                </div>
                <div class="infoDetail3 text-center">
                    <ul class="list-inline list-unstyled text-center">
                        <li><a href="#"><i class="fa fa-facebook"></i></a></li>
                        <li><a href="#"><i class="fa fa-twitter"></i></a></li>
                        <li><a href="#"><i class="fa fa-instagram"></i></a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="row hidden-xs">
            <div class="col-lg-12">
                <div class="customTabs detailDesc">
                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs" role="tablist">
                        <li role="presentation" class="active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab">Deskripsi</a></li>
                        <li role="presentation"><a href="#messages" aria-controls="messages" role="tab" data-toggle="tab">Review</a></li>
                        <li role="presentation"><a href="#settings" aria-controls="settings" role="tab" data-toggle="tab">Biaya Pengiriman</a></li>
                    </ul>

                    <!-- Tab panes -->
                    <div class="tab-content">
                        <div role="tabpanel" class="tab-pane active" id="home">
                            <div class="row">
                                <div class="col-sm-5 borRight">
                                    <h4>{{ $item->add_on_name }}</h4>
                                    <p>{{ $item->itemDesc }}</p>
                                </div>
                                <div class="col-sm-5 borRight">
                                    
                                </div>
                                <div class="col-sm-2">
                                    <h4>Brand</h4>
                                    <img src="{{ asset('admin/public/assets/image/logo-image/'.$item->brand_logo) }}" width="100" />
                                </div>
                            </div>
                        </div>
                        <div role="tabpanel" class="tab-pane" id="messages">
                            <div class="reviewRow">
                                <div class="leftReview">
                                    <img src="https://www.gravatar.com/avatar/kelvin?s=200&d=retro" class="imgFull" />
                                </div>
                                <div class="rightReview">
                                    <h2>Kelvin Mijaya</h2>
                                    <p>wah bagus ya</p>
                                </div>
                                <div class="rating">
                                    <ul class="ratingSubWrap noCursor">
                                        <li class="starLi active"><img src="{{ asset('public/img/icon/rate-nyala.png') }}" class="imgFull" /></li>
                                        <li class="starLi active"><img src="{{ asset('public/img/icon/rate-nyala.png') }}" class="imgFull" /></li>
                                        <li class="starLi"><img src="{{ asset('img/icon/rate-nyala.png') }}" class="imgFull" /></li>
                                        <li class="starLi"><img src="{{ asset('img/icon/rate-nyala.png') }}" class="imgFull" /></li>
                                        <li class="starLi"><img src="{{ asset('img/icon/rate-nyala.png') }}" class="imgFull" /></li>
                                    </ul>
                                    <p>Rating Produk</p>
                                    <div class="clearBoth"></div>
                                </div>
                                <div class="clearBoth"></div>
                            </div>
                        </div>
                        <div role="tabpanel" class="tab-pane" id="settings">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Lokasi Pengiriman</th>
                                        @foreach($fee as $province => $provinceData)
                                        @foreach($provinceData as $city => $cityData)
                                        @foreach($cityData as $qty => $value)
                                        @if($qty == '> 300')
                                            <th>Lebih besar dari 300</th>
                                        @else
                                            <th>{{ $qty }}</th>
                                        @endif
                                        @endforeach
                                        @php
                                            break;
                                        @endphp
                                        @endforeach
                                        @php
                                            break;
                                        @endphp
                                        @endforeach
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($fee as $province => $provinceData)
                                    @foreach($provinceData as $city => $cityData)
                                    <tr>
                                        <th>{{ $province }}, {{ $city }}</th>
                                        @foreach($cityData as $qty => $value)
                                        <th>{{ number_format($value,0,'.','.') }}</th>
                                        @endforeach
                                    </tr>
                                    @endforeach
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row visible-xs">
            <div class="col-lg-12">
                <div class="panel-group custom-panel" id="accordion" role="tablist" aria-multiselectable="true">
                    <div class="panel panel-default">
                        <div class="panel-heading" role="tab" id="headingOne">
                            <h4 class="panel-title">
                                <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                    Deskripsi
                                </a>
                            </h4>
                        </div>
                        <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-md-5 borRight">
                                        <h4>Stone Marble Tiles</h4>
                                        <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged.</p>
                                    </div>
                                    <div class="col-md-5 borRight">
                                        <h4>Specification</h4>
                                        <ul class="listDesc">
                                            <li>Lorem Ipsum</li>
                                            <li>Lorem Ipsum</li>
                                            <li>Lorem Ipsum</li>
                                            <li>Lorem Ipsum</li>
                                            <li>Lorem Ipsum</li>
                                            <li>Lorem Ipsum</li>
                                            <li>Lorem Ipsum</li>
                                            <li>Lorem Ipsum</li>
                                            <li>Lorem Ipsum</li>
                                            <li>Lorem Ipsum</li>
                                            <li>Lorem Ipsum</li>
                                            <li>Lorem Ipsum</li>
                                            <div class="clearBoth"></div>
                                        </ul>
                                    </div>
                                    <div class="col-md-2">
                                        <h4>Brand</h4>
                                        <img src="{{ asset('img/brand/brand1.png') }}" width="100" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="panel panel-default">
                        <div class="panel-heading" role="tab" id="headingFour">
                            <h4 class="panel-title">
                                <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                                    Instalasi
                                </a>
                            </h4>
                        </div>
                        <div id="collapseFour" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingFour">
                            <div class="panel-body">
                                <h4>Stone Marble Tiles</h4>
                                <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged.</p>
                            </div>
                        </div>
                    </div>
                    <div class="panel panel-default">
                        <div class="panel-heading" role="tab" id="headingTwo">
                            <h4 class="panel-title">
                                <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                    Review
                                </a>
                            </h4>
                        </div>
                        <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
                            <div class="panel-body">
                                <div class="reviewRow">
                                    <div class="leftReview">
                                        <img src="https://www.gravatar.com/avatar/kelvin?s=200&d=retro" class="imgFull" />
                                    </div>
                                    <div class="rightReview">
                                        <h2>Kelvin Mijaya</h2>
                                        <p>wah bagus ya</p>
                                    </div>
                                    <div class="rating">
                                        <ul class="ratingSubWrap noCursor">
                                            <li class="starLi active"><img src="{{ asset('img/icon/rate-nyala.png') }}" class="imgFull" /></li>
                                            <li class="starLi active"><img src="{{ asset('img/icon/rate-nyala.png') }}" class="imgFull" /></li>
                                            <li class="starLi"><img src="{{ asset('img/icon/rate-nyala.png') }}" class="imgFull" /></li>
                                            <li class="starLi"><img src="{{ asset('img/icon/rate-nyala.png') }}" class="imgFull" /></li>
                                            <li class="starLi"><img src="{{ asset('img/icon/rate-nyala.png') }}" class="imgFull" /></li>
                                        </ul>
                                        <p>Rating Produk</p>
                                        <div class="clearBoth"></div>
                                    </div>
                                    <div class="clearBoth"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="panel panel-default">
                        <div class="panel-heading" role="tab" id="headingThree">
                            <h4 class="panel-title">
                                <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                    Biaya Pengiriman
                                </a>
                            </h4>
                        </div>
                        <div id="collapseThree" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
                            <div class="panel-body">
                                <table class="table table-striped">
                                    <thead>
                                    <tr>
                                        <th>Lokasi Pengiriman</th>
                                        <th>0 - 49</th>
                                        <th>50 - 99	</th>
                                        <th>100 - 299</th>
                                        <th>Lebih besar dari 300</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td>Jakarta Barat, DKI Jakarta</td>
                                        <td>175,000</td>
                                        <td>225,000</td>
                                        <td>300,000</td>
                                        <td>500,000</td>
                                    </tr>
                                    <tr>
                                        <td>Jakarta Barat, DKI Jakarta</td>
                                        <td>175,000</td>
                                        <td>225,000</td>
                                        <td>300,000</td>
                                        <td>500,000</td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="homeItemWrap">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="sectionTitle">
                    <h3>pilihan lainnya</h3>
                    <div class="lineTitle"></div>
                </div>
                <div class="swiperWrap marBot">
                    <!-- Swiper -->
                    <div class="swiper-container" id="swiper1">
                        <div class="swiper-wrapper">
                            @foreach($other as $d)
                            <div class="swiper-slide">
                                <div class="itemBox">
                                    <a href="{{ url($d->add_on_name.'/a') }}">
                                        <img data-src="{{ asset('admin/public/assets/image/item-image/add-on/medium/'.$d->img_name) }}" class="swiper-lazy imgFull" />
                                        <div class="itemDesc">
                                            <h4>{{ $d->add_on_name }}</h4>
                                            @if($d->calculator == 1)
                                            <p class="itemPrice">Rp {{ number_format($d->price_per_pcs) }}/pc</p>
                                            @else
                                            <p class="itemPrice">Rp {{ number_format($d->price_per_pcs) }}/pc</p>
                                            @endif
                                        </div>
                                    </a>
                                    @if(Session::get('sesUserId') !== null)
                                    <a class="btnHitung" data-toggle="modal" data-target="#calculator" data-id="{{ $d->itemId }}">Hitung</a>
                                    @endif
                                </div>
                                <!-- Preloader image -->
                                <div class="swiper-lazy-preloader swiper-lazy-preloader-white"></div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="swiperArrow swiperRight"></div>
                    <div class="swiperArrow swiperLeft"></div>
                </div>
            </div>
        </div>
    </div>
</div>
@stop