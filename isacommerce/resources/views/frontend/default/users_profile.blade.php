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
                                    <li class="active"><span></span><a href="{{ url('users/profile') }}">Personal Information</a></li>
                                    <li><span></span><a href="{{ url('users/shipping') }}">Shipping Address</a></li>
                                    <li><span></span><a href="{{ url('users/orders') }}">Orders History</a></li>
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
                    <span class="page-heading-title2">My Profile</span>
                </h2>
                <!-- Content page -->
                <div class="content-text clearfix">
                    @if (session('status'))
                        <div role="alert" class="alert alert-success alert-dismissible">
                            <button aria-label="Close" data-dismiss="alert" class="close" type="button"><span aria-hidden="true">×</span></button>
                            {{ session('status') }}
                        </div>
                    @endif
                    <form class="form-horizontal ale-form" method="post" action="{{ url('update-profile') }}">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label class="col-sm-2 control-label">First Name</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" placeholder="First name" name="firstname" value="{{Auth::user()->firstname}}" required>
                                @if ($errors->has('firstname'))
                                    <p class="text-danger">
                                        {{ $errors->first('firstname') }}
                                    </p>
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Last Name</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" placeholder="Last name" name="lastname" value="{{Auth::user()->lastname}}" required>
                                @if ($errors->has('lastname'))
                                    <p class="text-danger">
                                        {{ $errors->first('lastname') }}
                                    </p>
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Email</label>
                            <div class="col-sm-10">
                                <input type="email" class="form-control" placeholder="Email" name="email" required value="{{Auth::user()->email}}">
                                @if ($errors->has('email'))
                                    <p class="text-danger">
                                        {{ $errors->first('email') }}
                                    </p>
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Phone</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" placeholder="phone" name="phone" required value="{{Auth::user()->phone}}">
                                @if ($errors->has('phone'))
                                    <p class="text-danger">
                                        {{ $errors->first('phone') }}
                                    </p>
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Password</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="password">
                                <p>Leave the fill blank if the password remains unchanged.</p>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-10">
                                <button type="submit" class="button">Update</button>
                            </div>
                        </div>
                    </form>
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