@extends('layouts.depotile', ['title' => 'Tile Detail'])

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
                                    <?php
                                        $count = 0;
                                    ?>
                                    @if($item->img_name1 != "" && $item->img_name1 != null)
                                    <?php
                                        $count++;
                                    ?>
                                    <a class="fancybox" rel="gallery1" href="{{ asset('admin/public/assets/image/item-image/xlarge/'.$item->img_name1) }}" title="">
                                        <img src="{{ asset('admin/public/assets/image/item-image/medium/'.$item->img_name1) }}" class="imgFull" />
                                    </a>
                                    @else
                                    <a class="fancybox" rel="gallery1" href="{{ asset('admin/public/assets/image/no_image.png') }}" title="">
                                        <img src="{{ asset('admin/public/assets/image/no_image.png') }}" class="imgFull" />
                                    </a>
                                    @endif
                                </div>
                            </div>
                        </div><div>
                            <div class="row">
                                <div class="col-lg-12">
                                    @if($item->img_name2 != "" && $item->img_name2 != null)
                                    <?php
                                        $count++;
                                    ?>
                                    <a class="fancybox" rel="gallery1" href="{{ asset('admin/public/assets/image/item-image/xlarge/'.$item->img_name2) }}" title="">
                                        <img src="{{ asset('admin/public/assets/image/item-image/medium/'.$item->img_name2) }}" class="imgFull" />
                                    </a>
                                    @endif
                                </div>
                            </div>
                        </div><div>
                            <div class="row">
                                <div class="col-lg-12">
                                    @if($item->img_name3 != "" && $item->img_name3 != null)
                                    <?php
                                        $count++;
                                    ?>
                                    <a class="fancybox" rel="gallery1" href="{{ asset('admin/public/assets/image/item-image/xlarge/'.$item->img_name3) }}" title="">
                                        <img src="{{ asset('admin/public/assets/image/item-image/medium/'.$item->img_name3) }}" class="imgFull" />
                                    </a>
                                    @endif
                                </div>
                            </div>
                        </div>

                    </div>
                    @if($count > 1)
                    <a href=# id="prev" class="prev"><i class="fa fa-chevron-left" aria-hidden="true"></i></a>
                    <a href=# id="next" class="next"><i class="fa fa-chevron-right" aria-hidden="true"></i></a>
                    @endif
                </div>
                <div id=no-template-pager class="cycle-pager external hidden-xs" style="text-align:center">
                    <!-- using thumbnail image files would be even better! -->
                    @if($item->img_name1 != "" && $item->img_name1 != null)
                    <img src="{{ asset('admin/public/assets/image/item-image/medium/'.$item->img_name1) }}" width=80 height=80>
                    @endif
                    @if($item->img_name2 != "" && $item->img_name2 != null)
                    <img src="{{ asset('admin/public/assets/image/item-image/medium/'.$item->img_name2) }}" width=80 height=80>
                    @endif
                    @if($item->img_name3 != "" && $item->img_name3 != null)
                    <img src="{{ asset('admin/public/assets/image/item-image/medium/'.$item->img_name3) }}" width=80 height=80>
                    @endif
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
                            <li class="breadcrumb-item active">{{ $item->item_name }}</li>
                        </ol>
                    </div>
                    <div class="detailTitleWrap">
                        <h1><div class="productTitle">{{ $item->item_name }}</div><span>{{ $item->item_code }}</span></h1>
                        <div class="starWrap hidden">
                            <ul class="starSubWrap pull-right">
                                <li class="starLi"><img src="{{ asset('public/img/icon/rate-nyala.png') }}" class="imgFull" /></li>
                                <li class="starLi"><img src="{{ asset('public/img/icon/rate-nyala.png') }}" class="imgFull" /></li>
                                <li class="starLi"><img src="{{ asset('public/img/icon/rate-nyala.png') }}" class="imgFull" /></li>
                                <li class="starLi"><img src="{{ asset('public/img/icon/rate-nyala.png') }}" class="imgFull" /></li>
                                <li class="starLi"></li>
                            </ul>
                            <div class="clearBoth"></div>
                        </div>
                        @if($item->calculator == 1)
                        <div class="discPrice">
                            @if($item->disc > 0)
                            @php
                                $afterdisc = $item->price_per_m2 * $item->disc / 100
                            @endphp
                            <s>Rp {{ number_format($item->price_per_m2,0,'.','.') }}/m&sup2;</s>
                            @endif
                            <ul class="list-inline list-unstyled">
                                <li class="brand">Brand: <a href="#">{{ $item->brand_name }}</a></li>
                                <!-- <li class="stockOn">Stock tersedia</li> -->
                            </ul>
                            <div class="clearBoth"></div>
                        </div>
                        @if($item->disc > 0)
                        <p class="realPrice">Rp {{ number_format($afterdisc,0,'.','.') }}/m&sup2;</p>
                        @else
                        <p class="realPrice">Rp {{ number_format($item->price_per_m2,0,'.','.') }}/m&sup2;</p>
                        @endif
                        @endif
                    </div>
                    <div class="detail2TitleWrap">
                        @php
                            $coverage = ($item->length/100) * ($item->width/100) * $item->pcs_per_box;
                            if($item->calculator == 1) {
                                $price_per_box = $item->price_per_m2 * $coverage;
                            }else {
                                $price_per_box = $item->price_per_m2;
                            }
                        @endphp
                        @if($item->disc > 0)
                            @php
                                $afterdisc = $price_per_box * $item->disc / 100
                            @endphp
                        <div class="discPrice"><s>Rp {{ number_format($price_per_box,0,'.','.') }}/box</s></div>
                        <p class="realPrice">Rp {{ number_format($afterdisc,0,'.','.') }}/box <span>[
                        @else
                        <p class="realPrice">Rp {{ number_format($price_per_box,0,'.','.') }}/box <span>[
                        @endif
                        Setiap box mencakup {{ number_format($coverage,2,'.','.') }}m&sup2;]</span></p>
                        <div class="titleDesc">
                            <h4>Detail Produk :</h4>
                            <?php
                                $description = $item->description;
                                $detail_tag = json_decode($item->detail_tag_data);
                                if(strpos($description, '[pcs per box]')) {
                                    $description = str_replace('[pcs per box]', $item->pcs_per_box." pc(s)", $description);
                                }
                                foreach($detail_tag as $dt) {
                                    if(strpos($description, "[".$dt->tag_name."]")) {
                                        $detail_tag_string = "";
                                        $detail_tag_name = [];
                                        foreach($detail_tag as $dt2) {
                                            if($dt2->tag_name == $dt->tag_name) {
                                                array_push($detail_tag_name, $dt2->detail_tag_name);
                                            }
                                        }
                                        for($i=0;$i<sizeof($detail_tag_name);$i++) {
                                            $detail_tag_string .= $detail_tag_name[$i];
                                            if($i == sizeof($detail_tag_name)-2) {
                                                $detail_tag_string .= " & ";
                                            }else {
                                                $detail_tag_string .= ", ";
                                            }
                                        }
                                        $description = str_replace('['.$dt->tag_name.']', substr($detail_tag_string, 0, -2), $description);
                                    }
                                }
                            ?>
                            {!! $description !!}
                        </div>
                    </div>
                    @if(Session::get('sesUserId') !== null)
                    <form action="{{ url('doAddTileToCart') }}" method="POST">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="hidden" name="id" value="{{ $item->itemId }}">
                    <div class="detailProcess">
                        <div class="leftDetailProcess">
                            <a class="calcBlack" data-toggle="modal" data-target="#calculator" data-id="{{ $item->itemId }}">
                                <img src="{{ asset('public/img/icon/calculator.png') }}" class="imgFull" />
                            </a>
                            <a class="calcText hidden-xs" data-toggle="modal" data-target="#calculator" data-id="{{ $item->itemId }}">
                                Berapa banyak saya butuh?
                            </a>
                            <a class="calcText visible-xs" data-toggle="modal" data-target="#calculator" data-id="{{ $item->itemId }}" style="float:right">
                                Berapa banyak?
                            </a>
                        </div>
                        <div class="rightDetailProcess">
                            <div class="form-group">
                                <label for="box">Box</label>
                                <input maxlength="4" type="text" name="qty" onkeyup="attrQty()" class="form-control" id="qty" placeholder="0" style="width:100px">
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
                        <li><i class="fa fa-phone"></i><a href="#">021-2245-5224</a></li>
                        <li><i class="fa fa-envelope"></i><a href="#">hello@depotile.com</a></li>
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
                @if($item->add_on == 1)
                <div class="infoDetail4 visible-lg" >
                    <a data-toggle="modal" data-target="#addOn" data-id="{{ $item->itemId }}">
                    @if($item->img_name != "" && $item->img_name != null)
                    <img src="{{ asset('admin/public/assets/image/item-image/add-on/small/'.$item->img_name) }}" />
                    @else
                    <img src="{{ asset('admin/public/assets/image/no_image.png') }}" />
                    @endif
                    <p class="infoTitle">{{ $item->add_on_cta }}</p>
                    <p class="infoName">Cek model lain</p>
                    <!-- <p class="infoPrice">Rp 150.000/sak</p> -->
                    <div class="clearBoth"></div>
                    <div class="flyingButton">
                        <i class="fa fa-check" aria-hidden="true"></i>
                    </div>
                    </a>
                </div>
                @endif
            </div>
        </div>
        <div class="row hidden-xs">
            <div class="col-lg-12">
                <div class="customTabs detailDesc">
                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs" role="tablist">
                        <li role="presentation" class="active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab">Deskripsi</a></li>
                        <li role="presentation"><a href="#profile" aria-controls="profile" role="tab" data-toggle="tab">Instalasi</a></li>
                        <!-- <li role="presentation"><a href="#messages" aria-controls="messages" role="tab" data-toggle="tab">Review</a></li> -->
                        <li role="presentation"><a href="#settings" aria-controls="settings" role="tab" data-toggle="tab">Biaya Pengiriman</a></li>
                    </ul>

                    <!-- Tab panes -->
                    <div class="tab-content">
                        <div role="tabpanel" class="tab-pane active" id="home">
                            <div class="row">
                                <div class="col-sm-5 borRight">
                                    <h4>{{ $item->item_name }}</h4>
                                    <p>{{ $item->itemDesc }}</p>
                                </div>
                                <div class="col-sm-5 borRight">
                                    <h4>Specification</h4>
                                    <ul class="listDesc">
                                        <li>Size : {{ $item->width }}cm x {{ $item->length }}cm</li>
                                        <li>Pcs per box : {{ $item->pcs_per_box }} pc(s)</li>
                                        @php
                                            $jmlMeter = ($item->width / 100) * ($item->length / 100) * $item->pcs_per_box;
                                        @endphp
                                        <li>Meter Sq per box : {{ number_format($jmlMeter,2,'.','.') }}m<sup>2</sup></li>
                                        <?php
                                            $tagdata = json_decode($item->detail_tag_data);
                                            $tagarray = [];
                                            foreach($tagdata as $d) {
                                                $tagtemp = [
                                                    "tagname" => $d->tag_name,
                                                    "detailtagname" => $d->detail_tag_name
                                                ];
                                                if(sizeof($tagarray) > 0) {
                                                    $exist = false;
                                                    for($i=0;$i<sizeof($tagarray);$i++) {
                                                        if($tagarray[$i]["tagname"] == $tagtemp["tagname"])
                                                        {
                                                            $exist = true;
                                                            $tagarray[$i]["detailtagname"] .= ', '.$tagtemp["detailtagname"];
                                                        }
                                                    }
                                                    if($exist == false) {
                                                        array_push($tagarray, $tagtemp);
                                                    }
                                                }else {
                                                    array_push($tagarray, $tagtemp);
                                                }
                                            }
                                        ?>
                                        @foreach($tagarray as $d)
                                        <li>{{ $d["tagname"] }} : {{ $d["detailtagname"] }}</li>
                                        @endforeach
                                        <div class="clearBoth"></div>
                                    </ul>
                                </div>
                                <div class="col-sm-2">
                                    <h4>Brand</h4>
                                    <img src="{{ asset('admin/public/assets/image/logo-image/'.$item->brand_logo) }}" width="100" />
                                </div>
                            </div>
                        </div>
                        <div role="tabpanel" class="tab-pane" id="profile">
                            <h4>{{ $item->installation_name }}</h4>
                            <p>{!! $item->installation_desc !!}</p>
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
                                        <th><h4>LOKASI PENGIRIMAN</h4></th>
                                        @foreach($fee as $province => $provinceData)
                                        @foreach($provinceData as $city => $cityData)
                                        @foreach($cityData as $qty => $value)
                                            <th><h4>{{ $qty }}</h4></th>
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
                                        <td>{{ $province }}, {{ $city }}</td>
                                        @foreach($cityData as $qty => $value)
                                        @if($value > 0)
                                        <td>{{ number_format($value,0,'.','.') }}</td>
                                        @else
                                        <td>FREE</td>
                                        @endif
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
                                        <h4>{{ $item->item_name }}</h4>
                                        <p>{{ $item->itemDesc }}</p>
                                    </div>
                                    <div class="col-md-5 borRight">
                                        <h4>Specification</h4>
                                        <ul class="listDesc" style="padding-left:7%">
                                            <li>Size : {{ $item->width }}cm x {{ $item->length }}cm</li>
                                            <li>Pcs per box : {{ $item->pcs_per_box }} pc(s)</li>
                                            @php
                                                $jmlMeter = ($item->width / 100) * ($item->length / 100) * $item->pcs_per_box;
                                            @endphp
                                            <li>Meter Sq per box : {{ number_format($jmlMeter,1,'.','.') }}m<sup>2</sup></li>
                                            @foreach($tagarray as $d)
                                            <li>{{ $d["tagname"] }} : {{ $d["detailtagname"] }}</li>
                                            @endforeach
                                            <div class="clearBoth"></div>
                                        </ul>
                                    </div>
                                    <div class="col-md-2">
                                        <h4>Brand</h4>
                                        <img src="{{ asset('admin/public/assets/image/logo-image/'.$item->brand_logo) }}" width="100" />
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
                                <h4>{{ $item->installation_name }}</h4>
                                <p>{!! $item->installation_desc !!}</p>
                            </div>
                        </div>
                    </div>
                    <!-- <div class="panel panel-default">
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
                    </div> -->
                    <div class="panel panel-default fee-panel-mobile">
                        <div class="panel-heading" role="tab" id="headingThree">
                            <h4 class="panel-title">
                                <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                    Biaya Pengiriman
                                </a>
                            </h4>
                        </div>
                        <div id="collapseThree" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
                            <div class="panel-body">
                                <table class="table table-striped fee-table-mobile">
                                    <thead>
                                        <tr>
                                            <th><h3>LOKASI PENGIRIMAN</h3></th>
                                            @foreach($fee as $province => $provinceData)
                                            @foreach($provinceData as $city => $cityData)
                                            @foreach($cityData as $qty => $value)
                                                <th><h3 class="qty-header">{{ $qty }}</h3></th>
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
                                            <td>{{ $city }}</td>
                                            @foreach($cityData as $qty => $value)
                                            @if($value > 0)
                                            <td>{{ number_format($value,0,'.','.') }}</td>
                                            @else
                                            <td>FREE</td>
                                            @endif
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
                                    <?php
                                        $urlItemName = preg_replace('/ /', '_', $d->item_name);
                                    ?>
                                    <a href="{{ url($urlItemName.'/t') }}">
                                        @if($d->img_name1 != "" && $d->img_name1 != null)
                                        <img data-src="{{ asset('admin/public/assets/image/item-image/medium/'.$d->img_name1) }}" class="swiper-lazy imgFull" />
                                        @else
                                        <img data-src="{{ asset('admin/public/assets/image/no_image.png') }}" class="swiper-lazy imgFull" />
                                        @endif
                                        <div class="itemDesc">
                                            <h4>{{ $d->item_name }}</h4>
                                            @if($d->calculator == 1)
                                            <p class="itemPrice">Rp {{ number_format($d->price_per_m2) }}/m<sup>2</sup></p>
                                            @else
                                            <p class="itemPrice">Rp {{ number_format($d->price_per_m2) }}/box</p>
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
                    <!-- <div class="swiperArrow swiperRight"></div>
                    <div class="swiperArrow swiperLeft"></div> -->
                </div>
            </div>
        </div>
    </div>
</div>


<!-- Modal -->
<div class="modal custom-modal fade" id="calculator" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">KALKULATOR KERAMIK</h4>
            </div>
            @include('modal.calculator')
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal custom-modal fade" id="addOn" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">REKOMENDASI GROUT/LEM KERAMIK</h4>
            </div>
            @include('modal.addOn')
        </div>
    </div>
</div>
@stop