@extends('base')

@section('content')
    <div id="html-error-msg"></div>
    <div id="wrapper">

        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Order Detail</h1>
                    <a href="{{ url('order-manager/edit/'.$header->id) }}" class="btn btn-warning pull-right">Edit</a>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                
                <form method="POST" action="doEditOrder" id="changeOrderForm">
                <div class="col-xs-12" style="font-weight:normal">
                    <div class="col-xs-12" style="padding-bottom:1%">
                        <h3>Header Data</h3>
                        <div class="header-data">
                            <div class="form-group col-xs-7" style="padding:0.2% 0">
                                <div class="col-xs-4" style="padding:0.5% 0">Customer Name: </div>
                                <div class="col-xs-8" style="padding:0">
                                    <input type="text" class="form-control" name="username" value="{{ $header->name }}">
                                </div>
                            </div>
                            <div class="col-xs-3 name-error" style="color:red"></div>
                            <div class="form-group col-xs-7" style="padding:0.2% 0">
                                <div class="col-xs-4" style="padding:0.5% 0">Email: </div>
                                <div class="col-xs-8" style="padding:0">
                                    <input type="text" class="form-control" name="email" value="{{ $header->email }}">
                                </div>
                            </div>
                            <div class="form-group col-xs-7" style="padding:0.2% 0">
                                <div class="col-xs-4" style="padding:0.5% 0">Receiver Name: </div>
                                <div class="col-xs-8" style="padding:0">
                                    <input type="text" class="form-control" name="username" value="{{ $header->receiver_name }}">
                                </div>
                            </div>
                            <div class="col-xs-3 email-error" style="color:red"></div>
                            <div class="form-group col-xs-7" style="padding:0.2% 0">
                                <div class="col-xs-4" style="padding:0.5% 0">Receiver Address: </div>
                                <div class="col-xs-8" style="padding:0">
                                    <textarea type="text" class="form-control" name="address">{{ $header->receiver_address }}</textarea>
                                </div>
                                <!-- <div class="col-xs-12 text-center address-section" style="padding:0; min-height:50px; border:1px solid black">
                                	<div class="loading-div text-center hidden" style="margin-top:1%">
                                		<span class="fa fa-spinner fa-spin fa-2x"></span>
                                	</div>
                                    <div class="no-address" style="font-size:18px">No Address Data</div>
                                    <div class="address-list hidden"></div>
                                </div> -->
                            </div>
                            <div class="form-group col-xs-7" style="padding:0.2% 0">
                                <div class="col-xs-4" style="padding:0.5% 0">Admin Note: </div>
                                <div class="col-xs-8" style="padding:0">
                                    <input type="text" class="form-control" name="note" value="{{ $header->admin_note }}">
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
                    			<table class="table table-bordered col-xs-12" id="item-list-table">
			                        <thead>
			                        	<tr>
			                        		<th class="text-center col-xs-1">Type</th>
			                        		<th class="text-center col-xs-1">Code</th>
                                            <th class="text-center col-xs-2">Image</th>
			                        		<th class="text-center col-xs-2">Name</th>
			                        		<th class="text-center col-xs-2">Quantity</th>
                                            <th class="text-center col-xs-2">Price/pc</th>
                                            <th class="text-center col-xs-2">Desc</th>
			                        	</tr>
			                        </thead>
                                    <tbody>
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
                                                    $desc .= $dd->add_on_name.', ';
                                                }
                                            }
                                            if($pair == false) {
                                                $desc = '';
                                            }
                                            $totalQty += $d->total_item;
                                            $totalPrice += $d->total_item * $d->price_per_m2;
                                        ?>
                                        <tr>
                                            <td class="text-center">Tile</td>
                                            <td class="text-center">{{ $d->item_code }}</td>
                                            <td class="text-center">
                                                <img src="{{ asset('public/assets/image/item-image/small/'.$d->img_name1) }}">
                                            </td>
                                            <td class="text-center">{{ $d->item_name }}</td>
                                            <td class="text-center">{{ $d->total_item }}</td>
                                            <td class="text-center">Rp. {{ number_format(($d->total_item * $d->price_per_m2),0,'.','.') }}</td>
                                            <td class="text-center">{{ substr($desc,0,-2) }}</td>
                                        </tr>
                                        @endforeach
                                        @foreach($detail_add_on as $d)
                                        <?php
                                            $desc = 'Paired with ';
                                            $pair = false;
                                            foreach($detail_tile as $dd) {
                                                if($d->id == $dd->add_on_1 || $d->id == $dd->add_on_2 || $d->id == $dd->add_on_3) {
                                                    $pair = true;
                                                    $desc .= $dd->item_name.', ';
                                                }
                                            }
                                            if($pair == false) {
                                                $desc = '';
                                            }
                                            $totalQty += $d->total_item;
                                            $totalPrice += $d->total_item * $d->price_per_pcs;
                                        ?>
                                        <tr>
                                            <td class="text-center">Add On</td>
                                            <td class="text-center">{{ $d->item_code }}</td>
                                            <td class="text-center">
                                                <img src="{{ asset('public/assets/image/item-image/add-on/small/'.$d->img_name) }}">
                                            </td>
                                            <td class="text-center">{{ $d->add_on_name }}</td>
                                            <td class="text-center">{{ $d->total_item }}</td>
                                            <td class="text-center">Rp. {{ number_format(($d->total_item * $d->price_per_pcs),0,'.','.') }}</td>
                                            <td class="text-center">{{ substr($desc,0,-2) }}</td>
                                        </tr>
                                        @endforeach
                                        <tr>
                                            <th colspan="4" class="text-center">TOTAL</th>
                                            <th class="text-center">{{ $totalQty }}</th>
                                            <th class="text-center">Rp. {{ number_format($totalPrice,0,'.','.') }}</th>
                                        </tr>
                                    </tbody>
			                    </table>
                                <div class="col-xs-4 col-xs-offset-8">
                                    <div class="form-group col-xs-12">
                                        <div class="col-xs-5" style="padding-top:1.5%">Total Price</div>
                                        <div class="col-xs-7">
                                            <input type="text" class="form-control text-right" value="{{ number_format($totalPrice,0,'.','.') }}">
                                        </div>
                                    </div>
                                    <div class="form-group col-xs-12">
                                        <div class="col-xs-5" style="padding-top:1.5%">Shipping Fee</div>
                                        <div class="col-xs-7">
                                            <input type="text" class="form-control text-right" value="{{ number_format($header->fee,0,'.','.') }}">
                                        </div>
                                    </div>
                                    <div class="form-group col-xs-12">
                                        <div class="col-xs-5" style="padding-top:1.5%">Subtotal</div>
                                        <div class="col-xs-7">
                                            <input type="text" class="form-control text-right" value="{{ number_format(($totalPrice+$header->fee),0,'.','.') }}">
                                        </div>
                                    </div>
                                </div>
                    		</div>
                    	</div>
                    </div>
                </div>
                </form>

            </div>
        </div>
    </div>

    <script type="text/javascript" src="{{ asset('public/assets/js/order.js') }}"></script>
@endsection