@extends('layouts.depotile', ['title' => 'Category'])

@section('css')
@stop

@section('js')
    <script>
        $(document).ready(function () {
            var h1 = $('.headerWrap').height();
            var h2 = $('.menuWrap').height();
            var h3 = $('.CategoryBannerWrap').height();
            var h4 = $('.filterWrap').height();

            // set affix
            $('#filterAffix').affix({
                offset: {
                    top: ((h1 + h2 + h3) - h4)
                }
            })
        });
    </script>
@stop

@section('content')
    <div class="CategoryBannerWrap">

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
                            @php
                                $selected = '';
                                if($adv_category == 'c_'.$d['id']) {
                                    $selected = 'selected';
                                }
                            @endphp
                            <option class="category-search-home" value="c_{{ $d['id'] }}" {{ $selected }}>{{ $d['category_name'] }}</option>
                                @foreach($d['detail'] as $dd)
                                @php
                                    $selected = '';
                                    if($adv_category == 'dc_'.$dd->id) {
                                        $selected = 'selected';
                                    }
                                @endphp
                            <option value="dc_{{ $dd->id }}" {{ $selected }}>{{ $dd->detail_category_name }}</option>
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
                                    @php
                                        $selected = '';
                                        if($adv_project == $dd->id) {
                                            $selected = 'selected';
                                        }
                                    @endphp
                            <option value="{{ $dd->id }}" {{ $selected }}>{{ $dd->detail_tag_name }}</option>
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
                                    @php
                                        $selected = '';
                                        if($adv_color == $dd->id) {
                                            $selected = 'selected';
                                        }
                                    @endphp
                            <option value="{{ $dd->id }}" {{ $selected }}>{{ $dd->detail_tag_name }}</option>
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
                                    @php
                                        $selected = '';
                                        if($adv_price == $dd->id) {
                                            $selected = 'selected';
                                        }
                                    @endphp
                            <option value="{{ $dd->id }}" {{ $selected }}>{{ $dd->detail_tag_name }}</option>
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
                            @php
                                $selected = '';
                                if($adv_brand == $d->id) {
                                    $selected = 'selected';
                                }
                            @endphp
                                <option value="{{ $d->id }}" {{ $selected }}>{{ $d->brand_name }}</option>
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
    @if($menu == 'style')
    <div class="titleCategoryWrap">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <div class="titleSubCategoryWrap">
                        <h2 class="category1" style="background-image:url('../../../../admin/public/assets/image/tag-icon/{{$selectedTag->icon}}')">{{ $subtype }}</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
    @if(isset($navigation))
    <div class="productSegmentWrap">
        <div class="container">
            <div class="row">
                @if(sizeof($navigation) > 0)
                @foreach($navigation as $d)
                <div class="col-lg-4 col-md-4 col-sm-6 col-xs-6">
                    <div class="itemSegmentBox">
                        <a href="{{ url('product/navigation/'.$d->navigation_name.'/1') }}">
                            <img src="{{ asset('admin/public/assets/image/nav-image/'.$d->img_name) }}" class="imgFull" />
                            <h3>{{ $d->navigation_name }}</h3>
                        </a>
                    </div>
                </div>
                @endforeach
                @else
                <div class="col-xs-12 text-center"><h4>TIDAK ADA GROUP</h4></div>
                @endif
            </div>
        </div>
    </div>
    @endif
    <div class="titleProductWrap">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <div class="titleSubProductWrap" <?php echo ($menu != 'style') ? 'style="border-top:none"' : '' ?>>
                        <div class="row">
                            <div class="col-lg-1 col-md-1" style="padding-top:1.5%">
                                @if($paging > 1)
                                <label for="pg">Tampilkan:</label>
                                @endif
                            </div>
                            <div class="col-lg-1 col-md-1">
                                @if($paging > 1)
                                <select class="selectpicker" name="pg" id="pg">
                                    @if(isset($pg))
                                        @if($pg == 20)
                                    <option value="20" selected>20</option>
                                        @else
                                    <option value="20">20</option>
                                        @endif
                                        @if($pg == 40)
                                    <option value="40" selected>40</option>
                                        @else
                                    <option value="40">40</option>
                                        @endif
                                        @if($pg == 60)
                                    <option value="60" selected>60</option>
                                        @else
                                    <option value="60">60</option>
                                        @endif
                                    @else
                                    <option value="20">20</option>
                                    <option value="40">40</option>
                                    <option value="60">60</option>
                                    @endif
                                </select>
                                @endif
                            </div>
                            <div class="col-lg-1 col-md-1"></div>
                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                @if($menu == 'style')
                                <h2>{{ $selectedTag->tag_cta }}</h2>
                                @else
                                <h2>{{ $subtype }}</h2>
                                @endif
                            </div>
                            <div class="col-lg-1 col-md-1" style="padding-top:1.5%">
                                <label for="sorting">Urutkan:</label>
                            </div>
                            <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
                                <select class="selectpicker" name="s" id="sorting">
                                    @if(isset($s))
                                        @if($s == 3)
                                    <option value="3" selected>A - Z</option>
                                        @else
                                    <option value="3">A - Z</option>
                                        @endif
                                        @if($s == 4)
                                    <option value="4" selected>Harga termurah</option>
                                        @else
                                    <option value="4">Harga termurah</option>
                                        @endif
                                        @if($s == 5)
                                    <option value="5" selected>Harga termahal</option>
                                        @else
                                    <option value="5">Harga termahal</option>
                                        @endif
                                    @else
                                    <option value="3">A - Z</option>
                                    <option value="4">Harga termurah</option>
                                    <option value="5">Harga termahal</option>
                                    <option class="hidden" value="1">Produk terbaru</option>
                                    <option class="hidden" value="2">Produk terpopuler</option>
                                    @endif
                                </select>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="productListWrap">
        <div class="container">
            <div class="row">
                @if(sizeof($item) > 0)
                @foreach($item as $d)
                <div class="col-lg-3 col-md-3 col-sm-4 col-xs-6">
                    <div class="productBox">
                        @if($type != "Aksesoris")
                            <?php
                                $urlItemName = preg_replace('/ /', '_', $d->item_name);
                            ?>
                            <a href="{{ url($urlItemName.'/t') }}">
                        @else
                            <?php
                                $urlItemName = preg_replace('/ /', '_', $d->add_on_name);
                            ?>
                            <a href="{{ url($urlItemName.'/a') }}">
                        @endif
                            <div class="productImg">
                                @if($type != 'Aksesoris')
                                @if($d->img_name1 != "" && $d->img_name1 != null)
                                <img src="{{ asset('admin/public/assets/image/item-image/large/'.$d->img_name1) }}" class="imgFull" />
                                @else
                                <img src="{{ asset('admin/public/assets/image/no_image.png') }}" class="imgFull" />
                                @endif
                                @else
                                @if($d->img_name != "" && $d->img_name != null)
                                <img src="{{ asset('admin/public/assets/image/item-image/add-on/large/'.$d->img_name) }}" class="imgFull" />
                                @else
                                <img src="{{ asset('admin/public/assets/image/no_image.png') }}" class="imgFull" />
                                @endif
                                @endif
                                @if($d->disc > 0)
                                <div class="productImgDisc">
                                    <p>{{ $d->disc }}%<br/><span>OFF</span></p>
                                </div>
                                @endif
                            </div>
                            <div class="productDesc">
                                @if($type != 'Aksesoris')
                                <p class="productName">{{ $d->item_name }}</p>
                                @if($d->disc > 0)
                                    @if($d->calculator == 1)
                                <s class="productDisc">Rp {{ number_format($d->price_per_m2,0,'.','.') }}/m<sup>2</sup></s>
                                    @else
                                <s class="productDisc">Rp {{ number_format($d->price_per_m2,0,'.','.') }}/pc</s>
                                    @endif
                                @php
                                    $afterdisc = $d->price_per_m2 - ($d->price_per_m2 * $d->disc / 100);
                                @endphp
                                    @if($d->calculator == 1)
                                <p class="productPrice">Rp {{ number_format($afterdisc,0,'.','.') }}/m<sup>2</sup></p>
                                    @else
                                <p class="productPrice">Rp {{ number_format($afterdisc,0,'.','.') }}/pc</p>
                                    @endif
                                @else
                                <s class="productDisc" style="color:transparent">aaa</s>
                                    @if($d->calculator == 1)
                                <p class="productPrice">Rp {{ number_format(intval($d->price_per_m2),0,'.','.') }}/m<sup>2</sup></p>
                                    @else
                                <p class="productPrice">Rp {{ number_format(intval($d->price_per_m2),0,'.','.') }}/pc</p>
                                    @endif
                                @endif
                                @else
                                <p class="productName">{{ $d->add_on_name }}</p>
                                @if($d->disc > 0)
                                <s class="productDisc">Rp {{ number_format($d->price_per_pcs,0,'.','.') }}/pc</s>
                                @php
                                    $afterdisc = $d->price_per_m2 - ($d->price_per_pcs * $d->disc / 100);
                                @endphp
                                <p class="productPrice">Rp {{ number_format($afterdisc,0,'.','.') }}/pc</p>
                                @else
                                <s class="productDisc" style="color:transparent">aaa</s>
                                <p class="productPrice">Rp {{ number_format($d->price_per_pcs,0,'.','.') }}/pc</p>
                                @endif
                                @endif
                            </div>
                        </a>
                        @if($type != 'Aksesoris')
                        @if(Session::get('sesUserId') !== null)
                        <a class="btnHitung category" data-toggle="modal" data-target="#calculator" data-id="{{ $d->itemId }}">Hitung</a>
                        @endif
                        @endif
                    </div>
                </div>
                @endforeach
                @else
                @endif
                @if($paging > 1)
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-right">
                    <nav aria-label="Page navigation">
                        <ul class="pagination custom-pagination">
                            <li class="disabled">
                                <a href="#" aria-label="Previous">
                                    <span aria-hidden="true">&laquo;</span>
                                </a>
                            </li>
                            @for($i=0;$i<$paging;$i++)
                            @if($menu != 'search')
                            <li class="{{ ($i+1 == $page) ? 'active' : '' }}"><a href="{{ ($i+1 == $page) ? '#' : url('product/'.$menu.'/'.$type.'/'.$subtype.'/'.($i+1)) }}">{{ ($i+1) }}</a></li>
                            @else
                            <li class="{{ ($i+1 == $page) ? 'active' : '' }}"><a href="{{ ($i+1 == $page) ? '#' : url('product/search/'.($i+1).'?type='.$type.'&category='.$adv_category.'&project='.$adv_project.'&color='.$adv_color.'&price='.$adv_price.'&brand='.$adv_brand) }}">{{ ($i+1) }}</a></li>
                            @endif
                            @endfor
                            <!-- <li><a href="#">2</a></li>
                            <li><a href="#">3</a></li>
                            <li><a href="#">4</a></li>
                            <li><a href="#">5</a></li> -->
                            <li>
                                <a href="#" aria-label="Next">
                                    <span aria-hidden="true">&raquo;</span>
                                </a>
                            </li>
                        </ul>
                    </nav>
                </div>
                @endif
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

    @if($menu == 'search')
    <form id="sortingForm" method="GET" action="{{ url('product/search/1') }}">
        <input type="hidden" name="type" value="{{ $type }}">
        <input type="hidden" name="category" value="{{ $adv_category }}">
        <input type="hidden" name="project" value="{{ $adv_project }}">
        <input type="hidden" name="color" value="{{ $adv_color }}">
        <input type="hidden" name="price" value="{{ $adv_price }}">
        <input type="hidden" name="brand" value="{{ $adv_brand }}">
        <input type="hidden" name="s">
        <input type="hidden" name="pg">
    </form>
    @elseif($menu != 'navigation')
    <form id="sortingForm" method="GET" action="{{ url('product/'.$menu.'/'.$type.'/'.$subtype.'/1') }}">
        <input type="hidden" name="s">
        <input type="hidden" name="pg">
    </form>
    @else
    <form id="sortingForm" method="GET" action="{{ url('product/navigation/'.$name.'/1') }}">
        <input type="hidden" name="s">
        <input type="hidden" name="pg">
    </form>
    @endif
@stop