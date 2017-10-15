<form class="form-horizontal custom-form noMar" method="POST" action="{{ url('doAddAddonToCart') }}">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <input type="hidden" name="id">
    <input type="hidden" name="qty">
    <input type="hidden" name="tile">
    <div class="modal-body">
        <div class="addOnWrap">
            <div class="loading-div text-center hidden">
                <span class="fa fa-spin fa-spinner fa-2x"></span>
            </div>
            <div class="content hidden">
                <div class="row">
                    <div class="col-xs-12 col-sm-6 col-md-4">
                        <div class="productBox active addon1">
                            <input type="hidden" class="addonid">
                            <a>
                                <div class="productImg">
                                    <img src="{{ asset('img/product/product1.jpg') }}" class="imgFull" />
                                </div>
                                <div class="productDesc">
                                    <p class="productName">Serene Deep Sea</p>
                                    <div class="row">
                                        <div class="col-xs-6">
                                            <p class="addOnPrice">Rp 150.000</p>
                                        </div>
                                        <div class="col-xs-6 qty-box hidden">
                                            <div class="LeftFormatCalc mini">
                                                <div class="form-group">
                                                    <label for="box">Qty.</label>
                                                    <input maxlength="2" type="text" class="form-control" placeholder="0">
                                                </div>
                                            </div>
                                            <div class="clearBoth"></div>
                                        </div>
                                    </div>

                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-4">
                        <div class="productBox addon2">
                            <input type="hidden" class="addonid">
                            <a>
                                <div class="productImg">
                                    <img src="{{ asset('img/product/product1.jpg') }}" class="imgFull" />
                                </div>
                                <div class="productDesc">
                                    <p class="productName">Serene Deep Sea</p>
                                    <div class="row">
                                        <div class="col-xs-6">
                                            <p class="addOnPrice">Rp 150.000</p>
                                        </div>
                                        <div class="col-xs-6 qty-box hidden">
                                            <div class="LeftFormatCalc mini">
                                                <div class="form-group">
                                                    <label for="box">Qty.</label>
                                                    <input maxlength="2" type="text" class="form-control" placeholder="0">
                                                </div>
                                            </div>
                                            <div class="clearBoth"></div>
                                        </div>
                                    </div>

                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-4">
                        <div class="productBox addon3">
                            <input type="hidden" class="addonid">
                            <a>
                                <div class="productImg">
                                    <img src="{{ asset('img/product/product1.jpg') }}" class="imgFull" />
                                </div>
                                <div class="productDesc">
                                    <p class="productName">Serene Deep Sea</p>
                                    <div class="row">
                                        <div class="col-xs-6">
                                            <p class="addOnPrice">Rp 150.000</p>
                                        </div>
                                        <div class="col-xs-6 qty-box hidden">
                                            <div class="LeftFormatCalc mini">
                                                <div class="form-group">
                                                    <label for="box">Qty.</label>
                                                    <input maxlength="2" type="text" class="form-control" placeholder="0">
                                                </div>
                                            </div>
                                            <div class="clearBoth"></div>
                                        </div>
                                    </div>

                                </div>
                            </a>
                        </div>
                    </div>
                </div>
                @if(isset($item))
                <p class="login-notif hidden" style="font-size:16px; padding-bottom:10px"><b>Anda harus <a href="{{ url('login?type=tile&product='.$item->itemId) }}">login</a> terlebih dahulu untuk dapat membeli produk ini</b></p>
                @else
                <p class="login-notif hidden" style="font-size:16px; padding-bottom:10px"><b>Anda harus <a href="{{ url('login') }}">login</a> terlebih dahulu untuk dapat membeli produk ini</b></p>
                @endif
                <div class="addOnDesc">
                    <p class="addOnDesc1"><b>Grout Putih Standart</b> untuk homogenous Tile uk60x60, <span>1 pack grout untuk 2m&sup2;</span></p>
                    <p class="addOnDesc2"><b>Grout Putih Standart</b> untuk homogenous Tile uk60x60, <span>1 pack grout untuk 2m&sup2;</span></p>
                    <p class="addOnDesc3"><b>Grout Putih Standart</b> untuk homogenous Tile uk60x60, <span>1 pack grout untuk 2m&sup2;</span></p>
                </div>
                <button type="button" class="calcBtn big">tambahkan ke troli</button>
            </div>
        </div>
    </div>
</form>
<script type="application/javascript">
    $(document).ready(function(){
        $('.productBox').click(function(){
            $('.productBox').removeClass('active');
            $(this).addClass('active')
        });
    })
</script>