<!DOCTYPE html>
<html>
<head>
    @include('frontend.default.partials.meta')
    <title>{{ $data['title'] }}</title>
</head>
<body class="option6 category-page">
@include('frontend.default.partials.header')

<!-- page wapper-->
<div class="columns-container">
    <div class="container" id="columns">
        <!-- breadcrumb -->
        <div class="breadcrumb clearfix">
            <a class="home" href="#" title="Return to Home">Home</a>
            <span class="navigation-pipe">&nbsp;</span>
            <span class="navigation_page">Profile</span>
        </div>
        <!-- ./breadcrumb -->
        <!-- row -->
        <div class="row">
            <!-- Left colunm -->
            <div class="column col-xs-12 col-sm-3" id="left_column">
                <!-- block category -->
                <div class="block left-module">
                    <p class="title_block">My Account</p>
                    <div class="block_content">
                        <!-- layered -->
                        <div class="layered layered-category">
                            <div class="layered-content">
                                <ul class="tree-menu">
                                    <li><span></span><a href="{{ url('users/profile') }}">Personal Information</a></li>
                                    <li><span></span><a href="{{ url('users/shipping') }}">Shipping Address</a></li>
                                    <li class="active"><span></span><a href="{{ url('users/orders') }}">Orders History</a></li>
                                    <li><span></span><a href="{{ url('users/wishlist') }}">Wishlist</a></li>
                                    <li><span></span><a href="{{ url('signout') }}">Sign out</a></li>
                                </ul>
                            </div>
                        </div>
                        <!-- ./layered -->
                    </div>
                </div>
                <!-- ./block category  -->
                <!-- Banner silebar -->
                <div class="block left-module">
                    <div class="banner-opacity">
                        <a href="#"><img src="{{ url('theme/frontend/default/assets/data/slide-left.jpg')}}" alt="ads-banner"></a>
                    </div>
                </div>
                <!-- ./Banner silebar -->
            </div>
            <!-- ./left colunm -->
            <!-- Center colunm-->
            <div class="center_column col-xs-12 col-sm-9" id="center_column">
                <!-- page heading-->
                <h2 class="page-heading">
                    <span class="page-heading-title2">Order Detail</span>
                </h2>
                <!-- Content page -->
                <div class="content-text clearfix">
                    <form method="post" action="{{ url('/isa-cms/order/update') }}">
                            <input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
                            <input type="hidden" name="id" value="">
                            <div class="panel panel-white" id="outprint">
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <h5 class="m-b-md"><b>{{$data['order']->invoice_no}} - {{$data['order']->status}}</b></h5>
                                        </div>
                                        <div class="col-md-6 text-right">
                                            <h3>INVOICE</h3>
                                            <br/>
                                            <!-- <button type="button" class="btn btn-default" id="print"><i class="fa fa-print"></i> Print</button> -->
                                        </div>
                                        <div class="col-md-12">
                                            <hr>
                                            <p>
                                                <strong>Invoice to</strong><br>
                                                {{$data['order']->firstname}} {{$data['order']->lastname}} - {{$data['order']->email}}<br>
                                                {{$data['order']->address}} {{$data['order']->city}}, {{$data['order']->postcode}}<br>
                                                {{$data['order']->province}} - {{$data['order']->country}} 
                                            </p>
                                            
                                        </div>
                                        <div class="col-md-12">
                                            <table class="table table-striped">
                                                <thead>
                                                    <tr>
                                                        <th>Item</th>
                                                        <th>Quantity</th>
                                                        <th>Price</th>
                                                        <th class="text-right">Subtotal</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php $total=0; ?>
                                                    @foreach($data['detail'] as $d)
                                                        <?php 
                                                            $sub =  $d->price * $d->quantity; 
                                                            $total = $sub + $total;
                                                        ?>
                                                        <tr>
                                                            <td>{{$d->product_name}}</td>
                                                            <td>{{$d->quantity}}</td>
                                                            <td>{{number_format($d->price, 2)}}</td>
                                                            <td class="text-right">{{number_format($sub, 2)}}</td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                         <div class="col-md-9">
                                            <div class="text-right">
                                                <h5 class="no-m m-t-sm">Tax</h5>                                               
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="text-right">
                                                <h5 class="no-m">{{number_format($total*0.1, 2)}}</h5>
                                            </div>
                                        </div>
                                        <div class="col-md-9">
                                            <div class="text-right">
                                                <h5 class="no-m m-t-sm">Total</h5>                                               
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="text-right">
                                                <h5 class="no-m">{{number_format($total, 2)}}</h5>
                                            </div>
                                        </div>
                                        <div class="col-md-9">
                                            <div class="text-right">
                                                <h5 class="no-m m-t-sm">Grand Total</h5>                                               
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="text-right">
                                                <h5 class="no-m">{{number_format($total+($total*0.1), 2)}}</h5>
                                            </div>
                                            <?php $gross_amount = $total+($total*0.1) ?>
                                        </div>
                                        <div class="col-md-12">
                                            <h3>Thank you !</h3>
                                            <br/>
                                            <p>Nullam quis risus eget urna mollis ornare vel eu leo. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. </p>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="text-right">
                                                @if($data['order']->order_status_id=='1')
                                                    <hr>
                                                    <a class="btn btn-primary" href="{{ url('/vtweb/'.$data['order']->invoice_no.'/'.$gross_amount) }}">Pay Now</a>
                                                @endif
                                            </div>
                                        </div>
                                    </div><!--row-->
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- ./Content page -->
            </div>
            <!-- ./ Center colunm -->
        </div>
        <!-- ./row-->
    </div>
</div>
<!-- ./page wapper-->

@include('frontend.default.partials.footer')
@include('frontend.default.partials.javascript')

</body>
</html>