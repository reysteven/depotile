@extends('layouts.depotile', ['title' => 'Home'])

@section('css')
@stop

@section('js')
    <script>
        $(document).ready(function () {
            var h1 = $('.headerWrap').height();
            var h2 = $('.menuWrap').height();
            var h3 = $('.bannerWrap').height();
            var h4 = $('.filterWrap').height();

            // set affix
            $('#filterAffix').affix({
                offset: {
                    top: ((h1 + h2 + h3) - h4)
                }
            })
        });
        var swiper = new Swiper('#swiper1', {
            paginationClickable: false,
            slidesPerView: 6,
            spaceBetween: 25,
            loop: false,
            // Disable preloading of all images
            preloadImages: true,
            // Enable lazy loading
            lazyLoading: true,
            nextButton: '.swiperRight',
            prevButton: '.swiperLeft',
            initialSlide: 0,
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
        var count = 0;
        swiper.on('reachEnd', function(event) {
            count++;
            $.ajax({
                type: "POST",
                url: $('#getNextItemLink').val(),
                data: "_token="+$('#ajax_token').val()+"&count="+count,
                success: function(data) {
                    data = JSON.parse(data);
                    lastSlide = $('#swiper1').find('.swiper-slide').last().prev().next();
                    var swiperLoadingHtml = lastSlide.html()
                    lastSlide.find('img').attr('data-src', $('#tileBaseLink').val()+'/'+data[0].img_name1);
                    lastSlide.find('img').attr('src', $('#tileBaseLink').val()+'/'+data[0].img_name1);
                    lastSlide.find('a').attr('href', $('#depotileBaseLink').val()+'/tile/'+data[0].itemId+'/'+data[0].item_name)
                    lastSlide.find('.itemDesc').find('h4').html(data[0].item_name);
                    if(data[0].calculator == 1) {
                        var price = 'Rp. '+number_format(data[0].price_per_m2)+'/m<sup>2</sup>';
                    }else {
                        var price = 'Rp. '+number_format(data[0].price_per_m2)+'/box';
                    }
                    lastSlide.find('.itemDesc').find('p.itemPrice').html(price);
                    var btnHitungHtml = '<a class="btnHitung" data-toggle="modal" data-target="#calculator" data-id="'+data[0].itemId+'">Hitung</a>';
                    lastSlide.find('a').append(btnHitungHtml);
                    $('#swiper1').find('.swiper-wrapper').append('<div class="swiper-slide">'+swiperLoadingHtml+'</div>');
                    swiper.update();
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    // $('#html-error-msg').html(JSON.stringify(jqXHR));
                    alert('error');
                }
            });
        });

        var swiper2 = new Swiper('#swiper2', {
            paginationClickable: false,
            slidesPerView: 7,
            spaceBetween: 60,
            loop: true,
            // Disable preloading of all images
            preloadImages: false,
            // Enable lazy loading
            lazyLoading: true,
            breakpoints: {
                992: {
                    slidesPerView: 6,
                    spaceBetween: 25
                },
                768: {
                    slidesPerView: 4,
                    spaceBetween: 25
                },
                640: {
                    slidesPerView: 4,
                    spaceBetween: 20
                },
                320: {
                    slidesPerView: 2,
                    spaceBetween: 10
                }
            }
        });
    </script>
@stop

@section('content')
<input type="hidden" id="getNextItemLink" value="{{ url('getNextItem') }}">
<input type="hidden" id="tileBaseLink" value="{{ asset('admin/public/assets/image/item-image/small/') }}">
<input type="hidden" id="depotileBaseLink" value="{{ url('/') }}">
<div class="bannerWrap">
    <div class="bannerTitleWrap">
        <div class="bannerTitleSubWrap">
            <div class="bannerTitle">
                <h1><span>hadiri pembukaan </span><br/>showroom kami</h1>
                <p>15-25 MEI 2017</p>
                <div class="separator hidden-xs"></div>
                <h2 class="hidden-xs">Dapatkan berbagai<br/>penawaran special</h2>
                <div class="separator hidden-xs"></div>
                <a href="#" class="bannerBtn">selengkapnya</a>
            </div>
        </div>
    </div>
</div>
<div id="filterAffix" class="filterWrap hidden-xs">
    <div class="container">
        <div class="row">
            <div class="col-md-2 hidden-sm">
                <p class="filterTitle">Apa yang anda cari?</p>
            </div>
            <form method="GET" action="{{ url('product/search/1') }}">
                <input type="hidden" name="type" value="tag_search">
                <div class="col-md-8 col-sm-10">
                    <select class="selectpicker" name="category">
                        <option class="hidden" value="0">-- Kategori --</option>
                        @foreach($category as $d)
                        <option class="category-search-home" value="c_{{ $d['id'] }}">{{ $d['category_name'] }}</option>
                            @foreach($d['detail'] as $dd)
                        <option value="dc_{{ $dd->id }}">{{ $dd->detail_category_name }}</option>
                            @endforeach
                        @endforeach
                    </select>
                    <select class="selectpicker" name="project">
                        @foreach($alltag as $d)
                            @if($d['id'] == 1)
                        <option class="hidden" value="0">-- {{ $d['tag_name'] }} --</option>
                                @php
                                break;
                                @endphp
                            @endif
                        @endforeach
                        @foreach($alltag as $d)
                            @if($d['id'] == 1)
                                @foreach($d['detail'] as $dd)
                        <option value="{{ $dd->id }}">{{ $dd->detail_tag_name }}</option>
                                @endforeach
                                @php
                                break;
                                @endphp
                            @endif
                        @endforeach
                    </select>
                    <select class="selectpicker" name="color">
                        @foreach($alltag as $d)
                            @if($d['id'] == 2)
                        <option class="hidden" value="0">-- {{ $d['tag_name'] }} --</option>
                                @php
                                break;
                                @endphp
                            @endif
                        @endforeach
                        @foreach($alltag as $d)
                            @if($d['id'] == 2)
                                @foreach($d['detail'] as $dd)
                        <option value="{{ $dd->id }}">{{ $dd->detail_tag_name }}</option>
                                @endforeach
                                @php
                                break;
                                @endphp
                            @endif
                        @endforeach
                    </select>
                    <select class="selectpicker" name="price">
                        @foreach($alltag as $d)
                            @if($d['id'] == 3)
                        <option class="hidden" value="0">-- {{ $d['tag_name'] }} --</option>
                                @php
                                break;
                                @endphp
                            @endif
                        @endforeach
                        @foreach($alltag as $d)
                            @if($d['id'] == 3)
                                @foreach($d['detail'] as $dd)
                        <option value="{{ $dd->id }}">{{ $dd->detail_tag_name }}</option>
                                @endforeach
                                @php
                                break;
                                @endphp
                            @endif
                        @endforeach
                    </select>
                    <select class="selectpicker" name="brand">
                        <option class="hidden" value="0">-- Merk --</option>
                        @foreach($brand as $d)
                            <option value="{{ $d->id }}">{{ $d->brand_name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2 col-sm-2">
                    <button type="submit" class="btn filterBtn">CARI</button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="midMenuWrap">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 hidden-xs">
                <ul class="list-inline list-unstyled">
                    <li><p class="hidden-sm">Top Pick:</p></li>
                    @foreach($project as $d)
                    <li><a href="{{ url('product/style/Proyek/'.$d->detail_tag_name.'/1') }}"><span class="midMenuFirst" style="background-image:url('admin/public/assets/image/tag-icon/{{$d->icon}}')">{{ $d->detail_tag_name }}</span></a></li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</div>
<!-- <div class="midMenuWrapMobile visible-xs">
    <div class="container">
        <div class="row">
            <div class="col-xs-12"><select class="selectpicker">
                    <option>kitchen</option>
                    <option>Ketchup</option>
                    <option>Relish</option>
                </select></div>
        </div>
    </div>
</div> -->
<div class="homeItemWrap">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="swiperWrap">
                    <!-- Swiper -->
                    <div class="swiper-container" id="swiper1">
                        <div class="swiper-wrapper">
                            @foreach($item as $d)
                            <div class="swiper-slide">
                                <div class="itemBox">
                                	<?php
                                		$urlItemName = preg_replace('/ /', '_', $d->item_name);
                                	?>
                                    <a href="{{ url($urlItemName.'/t') }}">
                                        @if($d->img_name1 != "" && $d->img_name1 != null)
                                        <img data-src="{{ asset('admin/public/assets/image/item-image/small/'.$d->img_name1) }}" class="swiper-lazy imgFull" />
                                        @else
                                        <img data-src="{{ asset('admin/public/assets/image/no_image.png') }}" class="swiper-lazy imgFull" />
                                        @endif
                                        <div class="itemDesc">
                                            <h4>{{ $d->item_name }}</h4>
                                            @if($d->calculator == 1)
                                            <p class="itemPrice">Rp {{ number_format($d->price_per_m2,0,'.','.') }}/m<sup>2</sup></p>
                                            @else
                                            <p class="itemPrice">Rp {{ number_format($d->price_per_m2,0,'.','.') }}/box</p>
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
                            <div class="swiper-slide">
                                <div class="itemBox">
                                    <a href="#">
                                        <img data-src="{{ asset('admin/public/assets/image/loading-gif.gif') }}" class="swiper-lazy imgFull" />
                                        <div class="itemDesc">
                                            <h4></h4>
                                            <p class="itemPrice"></p>
                                        </div>
                                    </a>
                                </div>
                                <!-- Preloader image -->
                                <div class="swiper-lazy-preloader swiper-lazy-preloader-white"></div>
                            </div>
                        </div>
                    </div>
                    <div class="swiperArrow swiperRight"></div>
                    <div class="swiperArrow swiperLeft"></div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="homeSection1">
    <div class="container">
        <div class="row">
            <div class="col-sm-6">
                <!-- <img src="{{ asset('admin/public/assets/image/image-storage/547b6544dfd1bc12413189e8a628d32d.jpg') }}" class="imgFull" /> -->
                <img src="{{ asset('public/img/home/home1.jpg') }}" class="imgFull" />
            </div>
            <div class="col-sm-6">
                <h2>DEPOTILE.COM itu Memudahkan!</h2>
                <p>Destinasi online terlengkap untuk MENCARI INSPIRASI, MEMILIH dan BERBELANJA berbagai jenis ubin seperti Keramik, Homogenous Tile, Parquet, Mozaic, Vinyl, dan Batu Alam.</p>
                <a href="#" class="bannerBtn">selengkapnya</a>
            </div>
        </div>
    </div>
</div>
<div class="homeSection2">
    <div class="container">
        <div class="row">
            <div class="col-sm-6">
                <div class="sectionTitle">
                    <h3>showroom kami</h3>
                    <div class="lineTitle"></div>
                </div>
                <p>Masih belum terbiasa memilih ubin di depan komputer? Kunjungi showroom kami yang berlokasi di Kelapa Gading agar Anda dapat memilih dan membeli ubin yang Anda inginkan secara langsung.</p>
                <!-- <img src="{{ asset('admin/public/assets/image/image-storage/showroom_muc_2015_shedhalle_hs.jpg') }}" class="imgFull" /> -->
                <img src="{{ asset('public/img/home/home1.jpg') }}" class="imgFull" />
            </div>
            <div class="col-sm-6">
                <div class="sectionTitle">
                    <h3>inspirasi anda</h3>
                    <div class="lineTitle"></div>
                </div>
                <p>Belum tahu mau ubin yang seperti apa? Kunjungi LOOKBOOK kami, terdapat ratusan design dari berbagai brand ternama sebagai inspirasi untuk lantai ruangan Anda.</p>
                <!-- <img src="{{ asset('admin/public/assets/image/image-storage/showroom-interior-design_4531_800_550.jpg') }}" class="imgFull" /> -->
                <img src="{{ asset('public/img/home/home1.jpg') }}" class="imgFull" />
            </div>
        </div>
    </div>
</div>
<div class="homeSection3">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="sectionTitle">
                    <h3>brand</h3>
                    <div class="lineTitle"></div>
                </div>
                <div class="swiperWrap">
                    <!-- Swiper -->
                    <div class="swiper-container" id="swiper2">
                        <div class="swiper-wrapper">
                            @foreach($brand as $d)
                            <div class="swiper-slide">
                                <div class="itemBox">
                                    <a href="#">
                                        <img data-src="{{ asset('admin/public/assets/image/logo-image/'.$d->brand_logo) }}" class="swiper-lazy imgFull" />
                                    </a>
                                </div>
                                <!-- Preloader image -->
                                <div class="swiper-lazy-preloader swiper-lazy-preloader-white"></div>
                            </div>
                            @endforeach
                        </div>
                    </div>
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
@stop