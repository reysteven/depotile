@extends('base')

@section('content')
    <div id="html-error-msg"></div>
    <div id="wrapper">

        <input type="hidden" id="imgPath" value="{{ asset('public/assets/image/item-image') }}">
        <input type="hidden" id="getItemDataLink" value="{{ url('doGetItemData') }}">
        <input type="hidden" id="orderId" value="{{ $header->id }}">
        <input type="hidden" id="feeData" value="{{ json_encode($fee) }}">

        <div class="modal fade" id="myModalAddress" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog" style="width:50%">
                <div class="modal-content">
                    <div class="modal-header" style="background-color:#224098; color:white">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h4 class="title text-center">Address List</h4>
                    </div>
                    <div class="modal-body row" style="color:black">
                        <div class="error-msg col-sm-12 text-center" style="margin-top:1%; color:red"></div>
                        <div class="loading-div text-center hidden">
                            <span class="fa fa-spinner fa-spin fa-2x"></span>
                        </div>
                        <div class="content">
                            <div class="col-xs-12">
                                @php $count=0; @endphp
                                @foreach($address as $d)
                                    @if($count == 2)
                                        @php $count = 0; @endphp
                                        </div>
                                        <div class="col-xs-12">
                                    @endif
                                <div class="col-xs-6 address-wrapper">
                                    <div class="col-xs-1">
                                        <input type="radio" name="address-opt">
                                    </div>
                                    <div class="col-xs-10">
                                        <p><strong name="address-name">{{ $d->name }}</strong></p>
                                        <p style="font-weight:400">
                                            <span name="full-address">{{ $d->address }}, {{ $d->city_name }}, {{ $d->province_name }}</span><br>
                                            @if($d->telp2 == '' || $d->telp2 == 'null')
                                            Telp: <span name="telp1">{{ $d->telp1 }}</span>
                                            @else
                                            Telp 1: <span name="telp1">{{ $d->telp1 }}</span><br>
                                            Telp 2: <span name="telp2">{{ $d->telp2 }}</span>
                                            @endif
                                        </p>
                                    </div>
                                </div>
                                @php $count++ @endphp
                                @endforeach
                            </div>
                            <input type="button" id="address-choose-btn" class="btn btn-primary pull-right" value="choose" style="margin:0 1%" disabled>
                            <input type="button" class="btn btn-default pull-right" value="cancel" data-dismiss="modal" style="margin:0 1%">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="myModalItem" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog" style="width:50%">
                <div class="modal-content">
                    <div class="modal-header" style="background-color:#224098; color:white">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h4 class="title text-center">Item List</h4>
                    </div>
                    <div class="modal-body row" style="color:black">
                        <div class="error-msg col-sm-12 text-center" style="margin-top:1%; color:red"></div>
                        <div class="loading-div text-center hidden">
                            <span class="fa fa-spinner fa-spin fa-2x"></span>
                        </div>
                        <div class="content">
                            <ul class="nav nav-tabs">
                                <li class="active"><a data-toggle="tab" href="#tile">Tile</a></li>
                                <li><a data-toggle="tab" href="#addon">Add On</a></li>
                            </ul>
                            <div class="tab-content">
                                <div id="tile" class="tab-pane fade in active">
                                    <div class="col-xs-12">
                                    @php $count=0; @endphp
                                    @foreach($tile as $d)
                                        @if($count == 4)
                                            @php $count=0; @endphp
                                            </div>
                                            <div class="col-xs-12">
                                        @endif
                                        <div class="col-xs-3 text-center" style="padding:1%" data-code="{{ $d->item_code }}">
                                            <img src="{{ asset('public/assets/image/item-image/small/'.$d->img_name1) }}">
                                            <div class="text-center">{{ $d->item_code }}</div>
                                            <div class="check-wrapper">
                                                <input type="checkbox" name="item-opt" data-id="{{ $d->id }}">
                                            </div>
                                        </div>
                                        @php $count++ @endphp
                                    @endforeach
                                    </div>
                                </div>
                                <div id="addon" class="tab-pane fade">
                                    <div class="col-xs-12">
                                    @php $count=0; @endphp
                                    @foreach($add_on as $d)
                                        @if($count == 4)
                                            @php $count=0; @endphp
                                            </div>
                                            <div class="col-xs-12">
                                        @endif
                                        <div class="col-xs-3 text-center" style="padding:1%" data-code="">
                                            <img src="{{ asset('public/assets/image/item-image/add-on/small/'.$d->img_name) }}">
                                            <div class="text-center">{{ $d->add_on_name }}</div>
                                            <div class="check-wrapper">
                                                <input type="checkbox" name="item-opt" data-id="{{ $d->id }}">
                                            </div>
                                        </div>
                                        @php $count++ @endphp
                                    @endforeach
                                    </div>
                                </div>
                                <input type="button" class="btn btn-primary pull-right" id="submit-add-item" value="choose" style="margin: 1%">
                                <input type="button" class="btn btn-default pull-right" value="cancel" data-dismiss="modal" style="margin: 1%">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <form method="POST" action="{{ ($type == 'add') ? url('doAddOrder') : url('doEditOrder') }}" id="order-form">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <input type="hidden" name="id" value="{{ $header->id }}">
        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12 header-wrapper">
                    <h1 class="page-header col-xs-10">Add Order</h1>
                    <div class="col-xs-2 submit-section pull-right">
                        <input type="submit" class="btn btn-primary pull-right" id="order-submit-btn" value="Submit">
                        <a href="{{ url('order-manager/detail/'.$header->id) }}" class="btn btn-default pull-right">Cancel</a>
                    </div>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                
                <div class="col-xs-12" style="font-weight:normal">
                    <div class="col-xs-12" style="padding-bottom:1%">
                        <h3>Header Data</h3>
                        <div class="header-data">
                            <div class="form-group col-xs-8" style="padding:0.2% 0">
                                <div class="col-xs-4" style="padding:0.5% 0">Customer Name: </div>
                                <div class="col-xs-7" style="padding:0">
                                    <input type="text" class="form-control" value="{{ $header->name }}" disabled>
                                </div>
                            </div>
                            <div class="col-xs-3 name-error" style="color:red"></div>
                            <div class="form-group col-xs-8" style="padding:0.2% 0">
                                <div class="col-xs-4" style="padding:0.5% 0">Email: </div>
                                <div class="col-xs-7" style="padding:0">
                                    <input type="text" class="form-control" value="{{ $header->email }}" disabled>
                                </div>
                            </div>
                            <div class="form-group col-xs-8" style="padding:0.2% 0">
                                <div class="col-xs-4" style="padding:0.5% 0">Receiver Name: </div>
                                <div class="col-xs-7" style="padding:0">
                                    <input type="text" class="form-control" name="username" value="{{ $header->receiver_name }}" disabled>
                                </div>
                                <div class="col-xs-1" style="padding:0.5% 2%">
                                    <a href="#" class="edit-field">
                                        <span class="fa fa-pencil"></span>
                                    </a>
                                </div>
                            </div>
                            <div class="col-xs-3 email-error" style="color:red"></div>
                            <div class="form-group col-xs-8" style="padding:0.2% 0">
                                <div class="col-xs-4" style="padding:0.5% 0">Receiver Address: </div>
                                <div class="col-xs-7" style="padding:0">
                                    <textarea type="text" class="form-control" name="address" disabled>{{ $header->receiver_address }}</textarea>
                                </div>
                                <div class="col-xs-1" style="padding:0.5% 2%">
                                    <a href="#" class="edit-field" data-type="address" data-toggle="modal" data-target="#myModalAddress">
                                        <span class="fa fa-pencil"></span>
                                    </a>
                                </div>
                                <!-- <div class="col-xs-12 text-center address-section" style="padding:0; min-height:50px; border:1px solid black">
                                    <div class="loading-div text-center hidden" style="margin-top:1%">
                                        <span class="fa fa-spinner fa-spin fa-2x"></span>
                                    </div>
                                    <div class="no-address" style="font-size:18px">No Address Data</div>
                                    <div class="address-list hidden"></div>
                                </div> -->
                            </div>
                            <div class="form-group col-xs-8" style="padding:0.2% 0">
                                <div class="col-xs-4" style="padding:0.5% 0">Receiver Phone 1: </div>
                                <div class="col-xs-7" style="padding:0">
                                    <input type="text" class="form-control" name="receiverTelp1" value="{{ $header->receiver_telp1 }}" disabled>
                                </div>
                                <div class="col-xs-1" style="padding:0.5% 2%">
                                    <a href="#" class="edit-field">
                                        <span class="fa fa-pencil"></span>
                                    </a>
                                </div>
                            </div>
                            <div class="form-group col-xs-8" style="padding:0.2% 0">
                                <div class="col-xs-4" style="padding:0.5% 0">Receiver Phone 2: </div>
                                <div class="col-xs-7" style="padding:0">
                                    <input type="text" class="form-control" name="receiverTelp2" value="{{ $header->receiver_telp2 }}" disabled>
                                </div>
                                <div class="col-xs-1" style="padding:0.5% 2%">
                                    <a href="#" class="edit-field">
                                        <span class="fa fa-pencil"></span>
                                    </a>
                                </div>
                            </div>
                            <div class="form-group col-xs-8" style="padding:0.2% 0">
                                <div class="col-xs-4" style="padding:0.5% 0">Admin Note: </div>
                                <div class="col-xs-7" style="padding:0">
                                    <input type="text" class="form-control" name="note" value="{{ $header->admin_note }}" disabled>
                                </div>
                                <div class="col-xs-1" style="padding:0.5% 2%">
                                    <a href="#" class="edit-field">
                                        <span class="fa fa-pencil" disabled></span>
                                    </a>
                                </div>
                            </div>
                            <!-- <div class="form-group col-xs-7" style="padding:0.2% 0">
                                <input type="submit" class="btn btn-primary pull-right" value="Submit">
                                <input type="button" class="btn btn-default pull-right" value="Clear">
                            </div> -->
                        </div>
                    </div>
                    <div class="col-xs-12">
                    	<div class="panel panel-default">
                    		<div class="panel-heading">Item List</div>
                    		<div class="panel-body">
                                <input type="button" class="btn btn-primary pull-right" value="Add Item" data-toggle="modal" data-target="#myModalItem" style="margin-bottom:1%">
                    			<table class="table table-bordered col-xs-12" id="item-list-table">
			                        <thead>
                                        <tr>
                                            <th class="hidden"></th>
                                            <th class="text-center col-xs-1">Type</th>
                                            <th class="text-center col-xs-1">Code</th>
                                            <th class="text-center col-xs-2">Image</th>
                                            <th class="text-center col-xs-1">Name</th>
                                            <th class="text-center col-xs-1">Desc</th>
                                            <th class="text-center col-xs-2">Price/pc</th>
                                            <th class="text-center col-xs-1">Quantity</th>
                                            <th class="text-center col-xs-2">Total Price</th>
                                            <th class="text-center col-xs-1">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody class="detail-body">
                                        <?php
                                            $totalQty = 0;
                                            $totalPrice = 0;
                                        ?>
                                        @foreach($detail_tile as $d)
                                        <?php
                                            $desc = 'Paired with ';
                                            $pair = false;
                                            foreach($detail_add_on as $dd) {
                                                if($dd->id == $d->add_on_1 || $dd->id == $d->add_on_2 || $dd->id == $d->add_on_3) {
                                                    $pair = true;
                                                    $desc .= $dd->add_on_name.' '.$dd->item_code.', ';
                                                }
                                            }
                                            if($pair == false) {
                                                $desc = '';
                                            }
                                            $totalQty += $d->total_item;
                                            $totalPrice += $d->total_item * $d->price_per_m2;
                                        ?>
                                        <tr data-fee="{{ $d->header_fee_id }}" data-city="{{ $city }}">
                                            <td class="hidden">
                                                <input type="hidden" name="itemId[]" value="{{ $d->item_id }}">
                                                <input type="hidden" name="itemQty[]" value="{{ $d->total_item }}">
                                                <input type="hidden" name="itemType[]" value="tile">
                                            </td>
                                            <td class="text-center type">Tile</td>
                                            <td class="text-center">{{ $d->item_code }}</td>
                                            <td class="text-center">
                                                <img src="{{ asset('public/assets/image/item-image/small/'.$d->img_name1) }}">
                                            </td>
                                            <td class="text-center">{{ $d->item_name }}</td>
                                            <td class="text-center desc">{{ substr($desc,0,-2) }}</td>
                                            <td class="text-center price_per_pc">Rp. {{ number_format($d->price_per_m2,0,'.','.') }}</td>
                                            <td class="text-center">
                                                <input type="number" name="item_number[]" min="0" value="{{ $d->total_item }}" onkeydown="return false" style="width:55px">
                                            </td>
                                            <td class="text-center total_price">Rp. {{ number_format(($d->total_item * $d->price_per_m2),0,'.','.') }}</td>
                                            <td class="text-center">
                                                <a href="#">
                                                    <span class="fa fa-trash"></span>
                                                </a>
                                            </td>
                                        </tr>
                                        @endforeach
                                        @foreach($detail_add_on as $d)
                                        <?php
                                            $desc = 'Paired with ';
                                            $pair = false;
                                            foreach($detail_tile as $dd) {
                                                if($d->id == $dd->add_on_1 || $d->id == $dd->add_on_2 || $d->id == $dd->add_on_3) {
                                                    $pair = true;
                                                    $desc .= $dd->item_name.' '.$dd->item_code.', ';
                                                }
                                            }
                                            if($pair == false) {
                                                $desc = '';
                                            }
                                            $totalQty += $d->total_item;
                                            $totalPrice += $d->total_item * $d->price_per_pcs;
                                        ?>
                                        <tr data-fee="{{ $d->header_fee_id }}" data-city="{{ $city }}">
                                            <td class="hidden">
                                                <input type="hidden" name="itemId[]" value="{{ $d->item_id }}">
                                                <input type="hidden" name="itemQty[]" value="{{ $d->total_item }}">
                                                <input type="hidden" name="itemType[]" value="addon">
                                            </td>
                                            <td class="text-center type">Add On</td>
                                            <td class="text-center">{{ $d->item_code }}</td>
                                            <td class="text-center">
                                                <img src="{{ asset('public/assets/image/item-image/add-on/small/'.$d->img_name) }}">
                                            </td>
                                            <td class="text-center">{{ $d->add_on_name }}</td>
                                            <td class="text-center desc">{{ substr($desc,0,-2) }}</td>
                                            <td class="text-center price_per_pc">Rp. {{ number_format($d->price_per_pcs,0,'.','.') }}</td>
                                            <td class="text-center">
                                                <input type="number" name="item_number[]" min="0" value="{{ $d->total_item }}" onkeydown="return false" style="width:55px">
                                            </td>
                                            <td class="text-center total_price">Rp. {{ number_format(($d->total_item * $d->price_per_pcs),0,'.','.') }}</td>
                                            <td class="text-center">
                                                <a href="#">
                                                    <span class="fa fa-trash"></span>
                                                </a>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                    <tbody>
                                        <tr>
                                            <th colspan="6" class="text-center">TOTAL</th>
                                            <th class="text-center total_qty">{{ $totalQty }}</th>
                                            <th class="text-center grand_total_price">Rp. {{ number_format($totalPrice,0,'.','.') }}</th>
                                        </tr>
                                    </tbody>
			                    </table>
                                <div class="col-xs-4 col-xs-offset-8">
                                    <div class="form-group col-xs-12">
                                        <div class="col-xs-5" style="padding-top:1.5%">Total Price</div>
                                        <div class="col-xs-7">
                                            <input type="text" class="form-control text-right" name="grand_total_price" value="{{ number_format($totalPrice,0,'.','.') }}" disabled>
                                        </div>
                                    </div>
                                    <div class="form-group col-xs-12">
                                        <div class="col-xs-5" style="padding-top:1.5%">Shipping Fee</div>
                                        <div class="col-xs-7">
                                            <input type="text" class="form-control text-right" name="fee" value="{{ number_format($header->fee,0,'.','.') }}" disabled>
                                        </div>
                                    </div>
                                    <div class="form-group col-xs-12">
                                        <div class="col-xs-5" style="padding-top:1.5%">Subtotal</div>
                                        <div class="col-xs-7">
                                            <input type="text" class="form-control text-right" name="subtotal_price" value="{{ number_format(($totalPrice+$header->fee),0,'.','.') }}" disabled>
                                        </div>
                                    </div>
                                </div>
                    		</div>
                    	</div>
                    </div>
                </div>

            </div>
        </div>
        </form>
    </div>

    <script type="text/javascript" src="{{ asset('public/assets/js/order.js') }}"></script>
@endsection