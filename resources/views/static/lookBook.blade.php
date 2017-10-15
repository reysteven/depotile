@extends('layouts.depotile', ['title' => 'Showroom'])

@section('css')
@stop

@section('js')
    <script>
        var swiper = new Swiper('.swiper-container', {
            nextButton: '.swiper-button-next',
            prevButton: '.swiper-button-prev'
        });
    </script>

@stop

@section('content')
    <!-- <div class="showroomWrap">
        <div class="showroomLeft">
            <div class="showroomTitle">
                <h1>showroom kami</h1>
                <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.</p>
            </div>
        </div>
        <div class="showroomRight">
            <!-- Swiper 
            <div class="swiper-container">
                <div class="swiper-wrapper">
                    <div class="swiper-slide"> <img src="{{ asset('img/showroom/showroom1.jpg') }}" class="imgFull" /></div>
                    <div class="swiper-slide"> <img src="{{ asset('img/showroom/showroom1.jpg') }}" class="imgFull" /></div>
                    <div class="swiper-slide"> <img src="{{ asset('img/showroom/showroom1.jpg') }}" class="imgFull" /></div>
                </div>
                <div class="swiper-button-prev"></div>
                <div class="swiper-button-next"></div>
            </div>
        </div>
        <div class="clearBoth"></div>
    </div>
    <div class="showroomContent">
        <div class="container">
            <div class="row">
                <div class="col-sm-4 col-xs-6">
                    <h2>Hubungi Kami</h2>
                    <span>Alamat</span>
                    <p>Danau Sunter Utara G3/26 Jakarta Utara 14350</p>
                    <span>Email</span>
                    <p>Hello@depotile.com</p>
                    <span>Telp</span>
                    <p>021 6400 480</p>
                </div>
                <div class="col-sm-4  col-xs-6 borLeft">
                    <h2>Jam Operasional</h2>
                    <span>Senin - Jumat</span>
                    <p>10.00 - 18.00 WIB</p>
                    <span>Sabtu</span>
                    <p>10.00 - 15.00 WIB</p>
                </div>
                <div class="col-sm-4  col-xs-12 borLeft">
                    <div class="dividerShowroom"></div>
                    <h2>Peta Showroom</h2>
                </div>
            </div>
        </div>
    </div> -->
    <div class="content text-center">
        <h1 style="color:#224098; font-size:60px; padding:2% 0">COMING SOON</h1>
    </div>
@stop