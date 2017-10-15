<div class="headerWrap hidden-xs">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="headerSec1">
                    <a href="{{ url('/') }}" class="logoWrap">
                        <img src="{{ asset('public/img/logo/logo-primary.png') }}" class="imgFull" />
                    </a>
                </div>
                <div class="headerSec2">
                    <div class="searchWrap">
                        <form action="{{ url('product/search/1') }}" id="all-search-form">
                            <input type="hidden" name="type" value="all_search">
                            <input type="hidden" name="item_type" value="Tile">
                            <div class="input-group" id="all-search-wrapper">
                                <div class="input-group-btn">
                                    <button type="button" class="btn btn-default dropdown-toggle" id="all-search-item-type" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Tile <span class="caret"></span></button>
                                    <ul class="dropdown-menu">
                                        <li><a href="#" class="all-search-item-type-link">Tile</a></li>
                                        <li><a href="#" class="all-search-item-type-link">Add On</a></li>
                                    </ul>
                                </div>
                                <input type="text" class="form-control" name="keyword" aria-label="..." id="all-search-text">
                                <div class="col-xs-12" id="autocomplete-all-search-section"></div>
                            </div>
                            <button class="searchBtn" type="submit"><i class="fa fa-search" aria-hidden="true"></i></button>
                        </form>
                    </div>
                </div>
                <div class="headerSec3 visible-md visible-lg">
                    <div class="callWrap">
                        <p>Butuh bantuan?</p>
                        <h5><i class="fa fa-phone" aria-hidden="true"></i> 021-2245-5224</h5>
                    </div>
                </div>
                <div class="headerSec4">
                    <ul class="list-inline list-unstyled">
                        <li>
                            <p>Selamat datang</p>
                            <div class="dropdown custom-dropdown">
                                <button class="btn btn-default dropdown-toggle account-dropdown" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                    @if(Session::get('sesUserId') === null)
                                    Daftar / Masuk <span class="caret"></span>
                                    @else
                                    {{ Session::get('sesUsername') }} <span class="caret"></span>
                                    @endif
                                </button>
                                <ul class="dropdown-menu account-dropmenu" aria-labelledby="dropdownMenu1">
                                    @if(Session::get('sesUserId') === null)
                                    <li><a href="{{ url('login') }}">Masuk</a></li>
                                    <hr style="margin: 0px; border-top:2px solid #eee">
                                    <li><a href="{{ url('register') }}">Daftar</a></li>
                                    @else
                                    <li><a href="{{ url('profile') }}">Profil</a></li>
                                    <li><a href="{{ url('confirmation') }}">Konfirmasi Pembayaran</a></li>
                                    <hr style="margin: 0px; border-top:2px solid #eee">
                                    <li><a href="{{ url('doLogout') }}">Keluar</a></li>
                                    @endif
                                </ul>
                            </div>
                        </li>
                        @if(Session::get('sesUserId') !== null)
                        <li class="borLeft">
                            <div class="dropdown custom-dropdown">
                                <button class="btn btn-default dropdown-toggle cart-dropdown" type="button" id="dropdownMenu3" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                    <div class="cart-dropdown-inside">
                                        <span class="badge">{{ sizeof(json_decode(Session::get('cart'))) }}</span>
                                    </div>
                                    <p>Troli</p>
                                </button>
                                @if(sizeof(json_decode(Session::get('cart'))) > 0)
                                <ul class="dropdown-menu cart-dropmenu" aria-labelledby="dropdownMenu3">
                                    <li>
                                        <div class="cart-dropwrap">
                                            @foreach(json_decode(Session::get('cart')) as $d)
                                            <a href="#">
                                                <div class="cart-dropdown">
                                                    @if($d->type == 'tile')
                                                    <div class="cart-droppic"><img src="{{ asset('admin/public/assets/image/item-image/small/'.$d->image) }}" alt="item" class="imgFull"></div>
                                                    @else
                                                    <div class="cart-droppic"><img src="{{ asset('admin/public/assets/image/item-image/add-on/small/'.$d->image) }}" alt="item" class="imgFull"></div>
                                                    @endif
                                                    <div class="cart-dropdetail">
                                                        <div class="cart-dropname">{{ $d->name }}</div>
                                                        <div class="cart-dropqty">{{ $d->qty }} pc(s)</div>
                                                        <div class="cart-dropprice">Rp {{ number_format($d->qty * $d->price,0,'.','.') }}</div>
                                                    </div>
                                                    <div style="clear: both"></div>
                                                </div>
                                            </a>
                                            @endforeach
                                        </div>
                                    </li>
                                    <li class="text-center">
                                        <a href="{{ url('cart') }}">See All</a>
                                    </li>
                                </ul>
                                @endif
                            </div>
                        </li>
                        @endif
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="mobileHeader visible-xs">
    <div class="mobileHeaderRow1">
        <a href="#menu" id="menuHit">
            <span class="menuStrip"></span>
            <span class="menuStrip"></span>
            <span class="menuStrip"></span>
        </a>
    </div>
    <div class="mobileHeaderRow2">
        <div class="mobileLogo">
            <a href="{{ url('/') }}" class="logoWrap">
                <img src="{{ asset('public/img/logo/logo-primary.png') }}" />
            </a>
        </div>
    </div>
    <div class="mobileHeaderRow3">
        <button class="triggerSearch pull-right" type="button"><i class="fa fa-search" aria-hidden="true"></i></button>
        <a href="#" class="cartMobile pull-right">
            <span class="badge">{{ sizeof(json_decode(Session::get('cart'))) }}</span>
        </a>
    </div>
    <div class="searchMobile">
        <div class="searchWrap">
            <form action="#">
                <div class="input-group">
                    <div class="input-group-btn">
                        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Semua <span class="caret"></span></button>
                        <ul class="dropdown-menu">
                            <li><a href="#" class="all-search-item-type-link">Tile</a></li>
                            <li><a href="#" class="all-search-item-type-link">Add On</a></li>
                        </ul>
                    </div>
                    <input type="text" class="form-control" name="keyword" aria-label="..." id="all-search-text-mobile">
                    <div class="col-xs-12" id="autocomplete-all-search-section-mobile"></div>
                </div>
            </form>
        </div>
    </div>
</div>