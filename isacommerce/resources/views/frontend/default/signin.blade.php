<!DOCTYPE html>
<html>
<head>
    @include('frontend.default.partials.meta')
    <title>{{ $data['title'] }}</title>
</head>
<body class="option6">
@include('frontend.default.partials.header')

<!-- page wapper-->
<div class="columns-container">
    <div class="container" id="columns">
        <!-- breadcrumb -->
        <div class="breadcrumb clearfix">
            <a class="home" href="#" title="Return to Home">Home</a>
            <span class="navigation-pipe">&nbsp;</span>
            <span class="navigation_page">Sign in or Sign up</span>
        </div>
        <!-- ./breadcrumb -->
        <!-- page heading-->
        <h2 class="page-heading">
            <span class="page-heading-title2">Sign in or Sign up</span>
        </h2>
        <!-- ../page heading-->
        <div class="page-content">
            <div class="row">
                <div class="col-sm-6">
                    <div class="box-authentication">
                        @if (session('status'))
                            <div role="alert" class="alert alert-success alert-dismissible">
                                <button aria-label="Close" data-dismiss="alert" class="close" type="button"><span aria-hidden="true">×</span></button>
                                {{ session('status') }}
                            </div>
                        @endif
                        <h3>Create an account</h3>
                        <p>Please enter your email address to create an account.</p>
                        <form method="post" action="{{ url('process-register') }}">
                            {{ csrf_field() }}
                            <label>First Name</label>
                            <input type="text" class="form-control" name="firstname" value="{{ old('firstname') }}" required>
                            @if ($errors->has('firstname'))
                                <p class="text-danger">
                                    {{ $errors->first('firstname') }}
                                </p>
                            @endif
                            <label>Last Name</label>
                            <input type="text" class="form-control" name="lastname" value="{{ old('lastname') }}" required>
                            @if ($errors->has('lastname'))
                                <p class="text-danger">
                                    {{ $errors->first('lastname') }}
                                </p>
                            @endif
                            <label>Email address</label>
                            <input type="email" class="form-control" name="email" value="{{ old('email') }}" required>
                            @if ($errors->has('email'))
                                <p class="text-danger">
                                    {{ $errors->first('email') }}
                                </p>
                            @endif
                            <label>Password</label>
                            <input type="password" class="form-control" name="password" value="{{ old('password') }}" required>
                            @if ($errors->has('password'))
                                <p class="block text-danger">
                                    {{ $errors->first('password') }}
                                </p>
                            @endif
                            <button class="button"><i class="fa fa-user"></i> Create an account</button>
                        </form>  
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="box-authentication">
                        @if (session('signout'))
                            <div role="alert" class="alert alert-success alert-dismissible">
                                <button aria-label="Close" data-dismiss="alert" class="close" type="button"><span aria-hidden="true">×</span></button>
                                {{ session('signout') }}
                            </div>
                        @endif
                        <h3>Already registered?</h3>
                        <form method="post" action="{{ url('process-login') }}">
                            {{ csrf_field() }}
                            <label>Email address</label>
                            <input type="email" class="form-control" name="login_email" required value="{{ old('login_email') }}">
                            @if ($errors->has('login_email'))
                                <p class="text-danger">
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
        </div>
    </div>
</div>
<!-- ./page wapper-->

@include('frontend.default.partials.footer')
@include('frontend.default.partials.javascript')

</body>
</html>