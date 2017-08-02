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
                <li class="current-step"><span>02. Sign in</span></li>
                <li><span>03. Address</span></li>
                <li><span>04. Shipping</span></li>
                <li><span>05. Payment</span></li>
            </ul>
            <div class="heading-counter warning">
                
            </div>
            <div class="order-detail-content">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="box-authentication">
                        <h3>Continue checkout without login</h3>
                            <form method="post" action="guest">
                                {{ csrf_field() }}
                                <label>First Name</label>
                                <input type="text" class="form-control" name="firstname" required value="{{ old('firstname') }}">
                                @if ($errors->has('firstname'))
                                    <p class="text-danger">
                                        {{ $errors->first('firstname') }}
                                    </p>
                                @endif
                                <label>Last Name</label>
                                <input type="text" class="form-control" name="lastname" required value="{{ old('lastname') }}">
                                @if ($errors->has('lastname'))
                                    <p class="text-danger">
                                        {{ $errors->first('lastname') }}
                                    </p>
                                @endif
                                <label>Email address</label>
                                <input type="email" class="form-control" name="email" required value="{{ old('email') }}">
                                @if ($errors->has('email'))
                                    <p class="text-danger">
                                        {{ $errors->first('email') }}
                                    </p>
                                @endif
                                <label>Phone</label>
                                <input type="text" class="form-control" name="phone" required value="{{ old('phone') }}">
                                @if ($errors->has('phone'))
                                    <p class="text-danger">
                                        {{ $errors->first('phone') }}
                                    </p>
                                @endif
                                <button class="button" type="submit">Guest Checkout</button>
                            </form>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="box-authentication">
                                <h3>Already registered?</h3>
                                    <form method="post" action="{{ url('process-login') }}">
                                        {{ csrf_field() }}
                                        <label>Email address</label>
                                        <input type="email" class="form-control" name="login_email" required value="{{ old('login_email') }}">
                                        @if ($errors->has('login_email'))
                                            <p class="text-danger">
                                            /[lokjhl ]
                                                {{ $errors->first('login_email') }}
                                            </p>
                                        @endif
                                        <label>Password</label>
                                        <input type="password" class="form-control" name="login_password" required value="{{ old('login_password') }}">
                                        @if ($errors->has('login_password'))
                                            <p class="block text-danger">
                                                {{ $errors->first('login_password') }}
                                            </p>
                                        @endif
                                        <p class="forgot-pass"><a href="#">Forgot your password?</a></p>
                                        <button class="button" type="submit"><i class="fa fa-lock"></i> Sign in</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="heading-counter warning"><h3>Not a member?</h3><br/>
                        Come register now ! Enjoy free shipping facilities across Indonesia and other benefits .<br/><br/>
                        <a class="next-btn" href="{{ url('signin-signup') }}">Register ></a> 
                        </div>
                    </div>
                </div>
                <div class="cart_navigation">
                    <a class="prev-btn" href="{{ url('cart') }}">Back</a>
                    <!-- <a class="next-btn" href="#" onclick="document.forms['addressForm'].submit();return false;">Proceed to checkout</a> -->
                </div>
            </div>
        </div>
    </div>
</div>
<!-- ./page wapper-->

@include('frontend.default.partials.footer')
@include('frontend.default.partials.javascript')
<script src="http://demo.itsolutionstuff.com/plugin/jquery.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $('select[name="state"]').on('change', function() {
            var stateID = $(this).val();
            if(stateID) {
                $.ajax({
                    url: 'http://localhost/isacommerce.com/province/'+stateID,
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