<!DOCTYPE html>

<html>

<head>

    @include('frontend.default.partials.meta')

    <title>ISA Commerce - Best Ecommerce Platform</title>

</head>

<body class="option6 category-page">

@include('frontend.default.partials.header')



<!-- page wapper-->

<div class="columns-container">

    <div class="container" id="columns">

        <!-- breadcrumb -->

        <div class="breadcrumb clearfix">

            <a class="home" href="{{url('/')}}" title="Return to Home">Home</a>

            <span class="navigation-pipe">&nbsp;</span>

            <span class="navigation_page">Your shopping cart</span>

            <input type="hidden" name="baseurl" id="baseurl" value="{{ url('/') }}">

        </div>

        <!-- ./breadcrumb -->

        <!-- page heading-->

        <h2 class="page-heading no-line">

            <span class="page-heading-title2">Shopping Cart Summary</span>

        </h2>

        <!-- ../page heading-->

        <div class="page-content page-order">

            <ul class="step">

                <li><span>01. Summary</span></li>

                <li><span>02. Sign in</span></li>

                <li class="current-step"><span>03. Address</span></li>

                <li><span>04. Shipping</span></li>

                <li><span>05. Payment</span></li>

            </ul>

            <div class="heading-counter warning">This is Your Current Address

                

            </div>

            <div class="order-detail-content">

                <div class="row">

                    <div class="col-sm-12">

                        <div class="box-authentication">

                            @if (session('status'))

                                <div role="alert" class="alert alert-success alert-dismissible">

                                    <button aria-label="Close" data-dismiss="alert" class="close" type="button"><span aria-hidden="true">×</span></button>

                                    {{ session('status') }}

                                </div>

                            @endif

                            <form class="form-horizontal ale-form" method="post" name="addressForm" action="{{ url('checkout/update-address') }}">

                                    {{ csrf_field() }}

                                    <div class="form-group">

                                    <label class="col-sm-2 control-label">Country<span class="text-danger">*</span></label>

                                        <div class="col-sm-10">

                                            <?php $country_id = (isset($data['address']->country_id) ? $data['address']->country_id : null); ?>

                                            <select name="state" class="form-control">

                                                <option value="">Country</option>

                                                @foreach($data['country'] as $c)

                                                    @if ($c->id == $country_id)

                                                        <option value="{{ $c->id }}" selected>{{ $c->name }}</option>

                                                    @else

                                                        <option value="{{ $c->id }}">{{ $c->name }}</option>

                                                    @endif

                                                @endforeach

                                            </select>

                                        </div>

                                    </div>

                                    <div class="form-group">

                                        <label class="col-sm-2 control-label">Province<span class="text-danger">*</span></label>

                                        <div class="col-sm-10">

                                            <?php $province_id = (isset($data['address']->province_id) ? $data['address']->province_id : null); ?>

                                            <select class="form-control" name="province" required id="province">

                                                <option value="">Select Country First</option>

                                                @foreach($data['province'] as $p)

                                                    @if ($p->country_id == $country_id)

                                                        @if ($p->id == $province_id)

                                                            <option value="{{ $p->id }}" selected>{{ $p->name }}</option>

                                                        @else

                                                            <option value="{{ $p->id }}">{{ $p->name }}</option>

                                                        @endif

                                                    @endif

                                                @endforeach

                                            </select>

                                        </div>

                                    </div>

                                    <div class="form-group">

                                        <label class="col-sm-2 control-label">City</label>

                                        <div class="col-sm-10">

                                            <?php $city = (isset($data['address']->city) ? $data['address']->city : null); ?>

                                            <input type="text" class="form-control" placeholder="city" name="city" required value="{{$city}}" required>

                                            @if ($errors->has('city'))

                                                <p class="text-danger">

                                                    {{ $errors->first('city') }}

                                                </p>

                                            @endif

                                        </div>

                                    </div>

                                    <div class="form-group">

                                        <label class="col-sm-2 control-label">Post Code</label>

                                        <div class="col-sm-10">

                                            <?php $postcode = (isset($data['address']->postcode) ? $data['address']->postcode : null); ?>

                                            <input type="text" class="form-control" placeholder="postcode" name="postcode" required value="{{$postcode}}" required>

                                            @if ($errors->has('postcode'))

                                                <p class="text-danger">

                                                    {{ $errors->first('postcode') }}

                                                </p>

                                            @endif

                                        </div>

                                    </div>

                                    <div class="form-group">

                                        <label class="col-sm-2 control-label">Address</label>

                                        <div class="col-sm-10">

                                            <?php $address = ( isset($data['address']->address) ? $data['address']->address : ''); ?>

                                            <input type="text" class="form-control" placeholder="address" name="address" required value="{{$address}}" required>

                                            @if ($errors->has('address'))

                                                <p class="text-danger">

                                                    {{ $errors->first('address') }}

                                                </p>

                                            @endif

                                        </div>

                                    </div>

                                    <?php $id = (isset($data['address']->id) ? $data['address']->id : null); ?>

                                    <input type="hidden" class="form-control" name="address_id" required value="{{$id}}">

                            </form>

                        </div> 

                    </div> 

                </div>

                <div class="cart_navigation">

                    <a class="prev-btn" href="{{ url('cart') }}">Back</a>

                    <a class="next-btn" href="#" onclick="document.forms['addressForm'].submit();return false;">Proceed to checkout</a> 

                </div>

            </div>

        </div>

    </div>

</div>

<!-- ./page wapper-->



@include('frontend.default.partials.footer')

@include('frontend.default.partials.javascript')

<script src="{{ url('theme/frontend/default/assets/js/jquery.js')}}"></script>

<script type="text/javascript">

    $(document).ready(function() {

        $('select[name="state"]').on('change', function() {

            var stateID = $(this).val();

            var baseUrl = $("#baseurl").val();

            if(stateID) {

                $.ajax({

                    url: baseUrl+'/province/'+stateID,

                    type: "GET",

                    dataType: "json",

                    success:function(data) {

                        $('select[name="province"]').empty();

                        $.each(data, function(key, value) {

                            $('select[name="province"]').append('<option value="'+ key +'">'+ value +'</option>');

                        });

                    }

                });

            }else{

                $('select[name="province"]').empty();

            }

        });

    });

</script>



</body>

</html>