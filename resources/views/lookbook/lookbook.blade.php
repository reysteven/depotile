@extends('layouts.depotile', ['title' => 'Lookbook Depotile'])

@section('css')
@stop

@section('js')

@stop

@section('content')
    <div class="titleGlobalWrap">
        <div class="lookbook-mainslide">
            <img src="{{ asset('img/banner/banner1.jpg') }}" class="imgFull" />
            <h2 class="lookbook-hanging">wooden bathroom</h2>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="lookbook-section2">
                        <div class="row">
                            <div class="col-lg-4 col-md-4">
                                <h3 class="lookbook-title">Lorem Ipsum is simply dummy text</h3>
                                <p class="lookbook-desc">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting</p>
                                <a class="lookbook-link" href="#">SHOP THE LOOK ></a>
                            </div>
                            <div class="col-lg-8 col-md-8">
                                <div class="row">
                                    <div class="col-sm-3 col-xs-6">
                                        <div class="itemBox">
                                            <a href="#">
                                                <img src="{{ asset('img/product/product1.jpg') }}" class="imgFull" />
                                                <div class="itemDesc">
                                                    <h4>Serene Deep Sea</h4>
                                                    <p class="itemPrice">Rp <span>250</span>.000/set</p>
                                                </div>
                                            </a>
                                            <a class="btnHitung" data-toggle="modal" data-target="#calculator" >Hitung</a>
                                        </div>
                                    </div>
                                    <div class="col-sm-3 col-xs-6">
                                        <div class="itemBox">
                                            <a href="#">
                                                <img src="{{ asset('img/product/product1.jpg') }}" class="imgFull" />
                                                <div class="itemDesc">
                                                    <h4>Serene Deep Sea</h4>
                                                    <p class="itemPrice">Rp <span>250</span>.000/set</p>
                                                </div>
                                            </a>
                                            <a class="btnHitung" data-toggle="modal" data-target="#calculator" >Hitung</a>
                                        </div>
                                    </div>
                                    <div class="col-sm-3 col-xs-6">
                                        <div class="itemBox">
                                            <a href="#">
                                                <img src="{{ asset('img/product/product1.jpg') }}" class="imgFull" />
                                                <div class="itemDesc">
                                                    <h4>Serene Deep Sea</h4>
                                                    <p class="itemPrice">Rp <span>250</span>.000/set</p>
                                                </div>
                                            </a>
                                            <a class="btnHitung" data-toggle="modal" data-target="#calculator" >Hitung</a>
                                        </div>
                                    </div>
                                    <div class="col-sm-3 col-xs-6">
                                        <div class="itemBox">
                                            <a href="#">
                                                <img src="{{ asset('img/product/product1.jpg') }}" class="imgFull" />
                                                <div class="itemDesc">
                                                    <h4>Serene Deep Sea</h4>
                                                    <p class="itemPrice">Rp <span>250</span>.000/set</p>
                                                </div>
                                            </a>
                                            <a class="btnHitung" data-toggle="modal" data-target="#calculator" >Hitung</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="lookbook-secondslide">
            <h2 class="lookbook-hanging">wooden bedroom</h2>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="lookbook-mainslide">
                        <div class="row">
                            <div class="col-sm-8">
                                <img src="{{ asset('img/banner/banner1.jpg') }}" class="imgFull" />
                            </div>
                            <div class="col-sm-4">
                                <div class="row mobile-pad">
                                    <div class="col-sm-12 col-xs-6">
                                        <img src="{{ asset('img/banner/banner1.jpg') }}" class="imgFull" />
                                    </div>
                                    <div class="col-sm-12 col-xs-6">
                                        <img src="{{ asset('img/banner/banner1.jpg') }}" class="imgFull" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="lookbook-section2">
                        <div class="row">
                            <div class="col-lg-4">
                                <h3 class="lookbook-title">Lorem Ipsum is simply dummy text</h3>
                                <p class="lookbook-desc">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting</p>
                                <a class="lookbook-link" href="#">SHOP THE LOOK ></a>
                            </div>
                            <div class="col-lg-8">
                                <div class="row">
                                    <div class="col-sm-3 col-xs-6">
                                        <div class="itemBox">
                                            <a href="#">
                                                <img src="{{ asset('img/product/product1.jpg') }}" class="imgFull" />
                                                <div class="itemDesc">
                                                    <h4>Serene Deep Sea</h4>
                                                    <p class="itemPrice">Rp <span>250</span>.000/set</p>
                                                </div>
                                            </a>
                                            <a class="btnHitung" data-toggle="modal" data-target="#calculator" >Hitung</a>
                                        </div>
                                    </div>
                                    <div class="col-sm-3 col-xs-6">
                                        <div class="itemBox">
                                            <a href="#">
                                                <img src="{{ asset('img/product/product1.jpg') }}" class="imgFull" />
                                                <div class="itemDesc">
                                                    <h4>Serene Deep Sea</h4>
                                                    <p class="itemPrice">Rp <span>250</span>.000/set</p>
                                                </div>
                                            </a>
                                            <a class="btnHitung" data-toggle="modal" data-target="#calculator" >Hitung</a>
                                        </div>
                                    </div>
                                    <div class="col-sm-3 col-xs-6">
                                        <div class="itemBox">
                                            <a href="#">
                                                <img src="{{ asset('img/product/product1.jpg') }}" class="imgFull" />
                                                <div class="itemDesc">
                                                    <h4>Serene Deep Sea</h4>
                                                    <p class="itemPrice">Rp <span>250</span>.000/set</p>
                                                </div>
                                            </a>
                                            <a class="btnHitung" data-toggle="modal" data-target="#calculator" >Hitung</a>
                                        </div>
                                    </div>
                                    <div class="col-sm-3 col-xs-6">
                                        <div class="itemBox">
                                            <a href="#">
                                                <img src="{{ asset('img/product/product1.jpg') }}" class="imgFull" />
                                                <div class="itemDesc">
                                                    <h4>Serene Deep Sea</h4>
                                                    <p class="itemPrice">Rp <span>250</span>.000/set</p>
                                                </div>
                                            </a>
                                            <a class="btnHitung" data-toggle="modal" data-target="#calculator" >Hitung</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@stop