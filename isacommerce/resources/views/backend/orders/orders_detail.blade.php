@extends('backend.layout.layout')
@section('singlecss')
<link href="{{ url('theme/backend/plugins/slidepushmenus/css/component.css') }}" rel="stylesheet" type="text/css"/>
@endsection
@section('content')
<body class="page-header-fixed">
    <div class="overlay"></div>
    <main class="page-content content-wrap">
        @include('backend.layout.navigation')
        <div class="page-inner">
            <div class="page-title">
                <h3>Orders</h3>
                <div class="page-breadcrumb">
                    <ol class="breadcrumb">
                        <li><a href="{{ url('/isa-cms/dashboard') }}">Dashboard</a></li>
                        <li><a href="{{ url('/isa-cms/orders') }}">Orders</a></li>
                        <li class="active">Detail</li>
                    </ol>
                </div>
            </div>
            <div id="main-wrapper">
                <div class="row">
                    <div class="col-md-12 invoice">
                        @if (session('status'))
                            <div role="alert" class="alert alert-success alert-dismissible">
                                <button aria-label="Close" data-dismiss="alert" class="close" type="button"><span aria-hidden="true">×</span></button>
                                {{ session('status') }}
                            </div>
                        @endif
                        @if ($errors->has('id'))
                            <div role="alert" class="alert alert-success alert-dismissible">
                                <button aria-label="Close" data-dismiss="alert" class="close" type="button"><span aria-hidden="true">×</span></button>
                                {{ $errors->first('id') }}
                            </div>
                        @endif
                        <form method="post" action="{{ url('/isa-cms/orders/update') }}">
                            <input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
                            <input type="hidden" name="id" value="{{ $order->id }}">
                            <div class="panel panel-white" id="outprint">
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <h1 class="m-b-md"><b>{{$order->invoice_no}} - {{$order->status}}</b></h1>
                                            <h4>{{$order->firstname}} {{$order->lastname}}</h4>
                                        </div>
                                        <div class="col-md-8 text-right">
                                            <h1>INVOICE</h1>
                                            <button type="button" class="btn btn-default" id="print"><i class="fa fa-print"></i> Print</button>
                                        </div>
                                        <div class="col-md-12">
                                            <hr>
                                            <p>
                                                <strong>Invoice to</strong><br>
                                                {{$order->firstname}} {{$order->lastname}}<br>
                                                {{$order->email}}
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
                                                    @foreach($detail as $d)
                                                        <?php 
                                                            $sub =  $d->price * $d->quantity; 
                                                            $total = $sub + $total;
                                                        ?>
                                                        <tr>
                                                            <td>{{$d->product_name}}</td>
                                                            <td>{{$d->quantity}}</td>
                                                            <td>{{number_format($d->price,2,',','.')}}</td>
                                                            <td class="text-right">{{number_format($sub,2,',','.')}}</td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="col-md-8">
                                            <h3>Thank you !</h3>
                                            <p>Nullam quis risus eget urna mollis ornare vel eu leo. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Nullam id dolor id nibh ultricies vehicula. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec ullamcorper nulla non metus auctor fringilla.</p>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="text-right">
                                                <h4 class="no-m m-t-sm">Total</h4>
                                                <h2 class="no-m">Rp. {{number_format($total,2,',','.')}}</h2>
                                                @if(Auth::guard('admin')->user()->can('orders-edit'))
                                                    @if($order->order_status_id=='1')
                                                        <hr>
                                                        <button class="btn btn-primary" type="submit">Change to Paid</button>
                                                    @endif
                                                @endif
                                            </div>
                                        </div>
                                    </div><!--row-->
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            @include('backend.layout.footer')
        </div><!-- Page Inner -->
    </main><!-- Page Content -->
    @include('backend.layout.hide-menu')
    <div class="cd-overlay"></div>
    @include('backend.layout.javascript')
    <script type="text/javascript">
        $( document ).ready(function() {
            $('#print').click(function(){
                window.print();
            });
        });
    </script>
</body>
@endsection