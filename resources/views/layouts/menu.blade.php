<div class="menuWrap hidden-xs">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="menuSubWrap">
                    <ul class="list-inline list-unstyled">
                        <li><a href="{{ url('/') }}"><span class="menuFirst">Home</span></a></li>
                        <li class="dropdown">
                            <a href="#"><span class="menuSecond">Browse Style <div class="caret"></div></span></a>
                            <div class="dropdown-menu" role="menu">
                                <div class="row">
                                    @php
                                        $cond = 1;
                                        foreach($tag as $d) {
                                            if(sizeof($d['detail']) > 5) {
                                                $cond = 2;
                                            }
                                        }
                                        $count = 0;
                                    @endphp
                                    @if($cond == 1)
                                    @else
                                        @foreach($tag as $d)
                                            @if($count == 0)
                                    <div class="col-sm-4">
                                        <div class="subMenuTitle">
                                            browse {{ $d['tag_name'] }}
                                        </div>
                                        <ul class="list-unstyled">
                                            @foreach($d['detail'] as $dd)
                                            <li><a href="{{ url('product/style/'.$d['tag_name'].'/'.$dd->detail_tag_name).'/1' }}">{{ $dd->detail_tag_name }}</a></li>
                                            @endforeach
                                        </ul>
                                    </div>
                                            @else
                                    <div class="col-sm-8">
                                        <div class="subMenuTitle">
                                            browse {{ $d['tag_name'] }}
                                        </div>
                                        <?php
                                            $col1 = '';
                                            $col2 = '';
                                            $col = 1;
                                            foreach($d['detail'] as $dd) {
                                                if($col == 1) {
                                                    $col1 .= '<li><a href="'.url('product/style/'.$d['tag_name'].'/'.$dd->detail_tag_name.'/1').'">'.$dd->detail_tag_name.'</a></li>';
                                                    $col = 2;
                                                }else {
                                                    $col2 .= '<li><a href="'.url('product/style/'.$d['tag_name'].'/'.$dd->detail_tag_name.'/1').'">'.$dd->detail_tag_name.'</a></li>';
                                                    $col = 1;
                                                }
                                            }
                                        ?>
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <ul class="list-unstyled">
                                                    {!! $col1 !!}
                                                </ul>
                                            </div>
                                            <div class="col-sm-6">
                                                <ul class="list-unstyled">
                                                    {!! $col2 !!}
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                            @endif
                                            @php
                                                $count++;
                                            @endphp
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                        </li>
                        <li class="dropdown">
                            <a href="#"><span class="menuThird">Collection <div class="caret"></div></span></a>
                            <div class="dropdown-menu" role="menu">
                                <div class="row">
                                    <div class="col-sm-8">
                                        <div class="subMenuTitle">
                                            pilih material
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <ul class="list-unstyled material-name">
                                                    @php
                                                        $count = 0;
                                                    @endphp
                                                    @foreach($category as $d)
                                                    <li class="{{ ($count++ == 0) ? 'active' : '' }}" data-id="{{ $d['id'] }}"><a href="#" data-name="{{ $d['category_name'] }}">{{ $d['category_name'] }}</a></li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                            <div class="col-sm-1">
                                                <ul class="list-unstyled expand-link">
                                                    @php
                                                        $count = 0;
                                                    @endphp
                                                    @foreach($category as $d)
                                                        @if($count++ == 0)
                                                    <li class="active"><a href="#" data-id="{{ $d['id'] }}" data-name="{{ $d['category_name'] }}">-</a></li>
                                                        @else
                                                    <li><a href="#" data-id="{{ $d['id'] }}" data-name="{{ $d['category_name'] }}">+</a></li>
                                                        @endif
                                                    @endforeach
                                                </ul>
                                            </div>
                                            <div class="col-sm-4">
                                                @php
                                                    $count = 0;
                                                @endphp
                                                @foreach($category as $d)
                                                <ul class="list-unstyled sub-material {{ ($count++ != 0) ? 'hidden' : '' }}" data-id="{{ $d['id'] }}">
                                                    @foreach($d['detail'] as $dd)
                                                    <li><a href="{{ url('product/collection/'.$d['category_name'].'/'.$dd->detail_category_name.'/1') }}">{{ $dd->detail_category_name }}</a></li>
                                                    @endforeach
                                                </ul>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="subMenuTitle">
                                            aksesoris
                                        </div>
                                        <ul class="list-unstyled">
                                            @foreach($acc as $d)
                                            <li><a href="{{ url('product/collection/Aksesoris/'.$d['detail_category_name'].'/1') }}">{{ $d['detail_category_name'] }}</a></li>
                                            @endforeach
                                        </ul>

                                    </div>
                                </div>
                            </div>
                        </li>
                        <li><a href="{{ url('lookbook') }}"><span class="menuFourth">Lookbook</span></a></li>
                        <li><a href="{{ url('showroom') }}"><span class="menuFifth">Showroom</span></a></li>
                        <!-- <li><a href="#" class="sale visible-sm">SALE</a></li> -->
                    </ul>
                    <!-- <a class="saleMenu hidden-sm" href="#">SALE</a> -->
                </div>
            </div>
        </div>
    </div>
</div>