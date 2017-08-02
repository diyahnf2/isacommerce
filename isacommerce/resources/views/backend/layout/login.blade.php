@extends('backend.layout.layout')
@section('singlecss')
@endsection
@section('content')
<body class="page-login">
    <main class="page-content">
        <div class="page-inner">
            <div id="main-wrapper">
                <div class="row">
                    <div class="col-md-3 center">
                        <div class="login-box">
                            <a href="#" class="logo-name text-lg text-center">ISA CMS</a>
                            <p class="text-center m-t-md">Please login into your account.</p>
                            <form class="m-t-md" role="form" method="POST" action="{{ url('/isa-cms/login') }}">
                                {!! csrf_field() !!}
                                <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                    <input type="email" class="form-control" name="email" value="{{ old('email') }}" placeholder="E-Mail Address" required>
                                    @if ($errors->has('email'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                    <input type="password" class="form-control" name="password" placeholder="Password" required>
                                    @if ($errors->has('password'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('password') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <button type="submit" class="btn btn-success btn-block">Login</button>
                                <a href="{{ url('/isa-cms/password-reset') }}" class="display-block text-center m-t-md text-sm">Forgot Password?</a>
                            </form>
                            <p class="text-center m-t-xs text-sm">2016 &copy; PT. Ide Solusi Asia.</p>
                        </div>
                    </div>
                </div><!-- Row -->
            </div><!-- Main Wrapper -->
        </div><!-- Page Inner -->
    </main><!-- Page Content -->
    @include('backend.layout.javascript')
</body>
@endsection