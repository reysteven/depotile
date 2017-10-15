@extends('layouts.depotile', ['title' => 'Profil Alamat'])

@section('css')
@stop

@section('js')
<script type="application/javascript">
    $(document).ready(function(){
        $('.starLi').click(function(){
            $('.starLi').removeClass('active');
            var index = $(this).index();
            for(var i = 0;i<(index+1);i++)
            {
                console.log(i)
                $('.starLi').eq((i)).addClass('active');
            }
        })
    })
</script>
@stop

@section('content')
    <div class="titleProfileWrap">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <div class="titleSubProfileWrap">
                        <h2 class="category1">Profil Saya</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="profileContent">
        <div class="container">
            <div class="row">
                <div class="col-sm-3">
                    @include('profile.profileMenu')
                </div>
                <div class="col-sm-9 leftBor">
                    <div class="profileMain">
                        <h3>Daftar Ulasan</h3>
                        <div class="orderRow">
                            <div class="orderRowTitle">
                                <h4>#Order 000000</h4>
                            </div>
                            <div class="orderRowContent">
                                <form class="custom-form noMar" action="">
                                    <div class="reviewRow">
                                        <div class="leftReview">
                                            <img src="{{ asset('img/product/product1.jpg') }}" class="imgFull" />
                                        </div>
                                        <div class="rightReview">
                                            <h2>stone marble tiles</h2>
                                            <input class="form-control" type="text" placeholder="Tulis ulasan anda" />
                                        </div>
                                        <div class="rating">
                                            <ul class="ratingSubWrap">
                                                <li class="starLi"><img src="{{ asset('img/icon/rate-nyala.png') }}" class="imgFull" /></li>
                                                <li class="starLi"><img src="{{ asset('img/icon/rate-nyala.png') }}" class="imgFull" /></li>
                                                <li class="starLi"><img src="{{ asset('img/icon/rate-nyala.png') }}" class="imgFull" /></li>
                                                <li class="starLi"><img src="{{ asset('img/icon/rate-nyala.png') }}" class="imgFull" /></li>
                                                <li class="starLi"><img src="{{ asset('img/icon/rate-nyala.png') }}" class="imgFull" /></li>
                                            </ul>
                                            <p>Rating Produk</p>
                                            <div class="clearBoth"></div>
                                        </div>
                                        <div class="clearBoth"></div>
                                    </div>
                                    <button class="profileBtn btnReview" type="submit">kirim ulasan</button>
                                    <div class="clearBoth"></div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop