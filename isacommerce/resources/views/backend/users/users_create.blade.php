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
                <h3>Users</h3>
                <div class="page-breadcrumb">
                    <ol class="breadcrumb">
                        <li><a href="{{ url('/isa-cms/dashboard') }}">Dashboard</a></li>
                        <li><a href="{{ url('/isa-cms/users') }}">Users</a></li>
                        <li class="active">Create</li>
                    </ol>
                </div>
            </div>
            <div id="main-wrapper">
                <div class="row">
                    <div class="col-md-12">
                        @if (session('status'))
                            <div role="alert" class="alert alert-success alert-dismissible">
                                <button aria-label="Close" data-dismiss="alert" class="close" type="button"><span aria-hidden="true">×</span></button>
                                {{ session('status') }}
                            </div>
                        @endif
                        <form method="post" action="{{ url('/isa-cms/users/store') }}" enctype="multipart/form-data">
                            <input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
                            <div class="panel panel-white">
                                <div class="panel-heading clearfix">
                                    <h4 class="panel-title">Basic Info</h4>
                                </div>
                                <div class="panel-body form-horizontal">
                                    <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                        <label class="col-sm-2 control-label">Name<span class="text-danger">*</span></label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" name="name" value="{{ old('name') }}">
                                            @if ($errors->has('name'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('name') }}</strong>
                                                </span>
                                            @endif
                                        </span>
                                        </div>
                                    </div>
                                    <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                        <label class="col-sm-2 control-label">Email<span class="text-danger">*</span></label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" name="email" value="{{ old('email') }}">
                                            @if ($errors->has('email'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('email') }}</strong>
                                                </span>
                                            @endif
                                        </span>
                                        </div>
                                    </div>
                                    <div class="form-group{{ $errors->has('role') ? ' has-error' : '' }}">
                                        <label class="col-sm-2 control-label">Role<span class="text-danger">*</span></label>
                                        <div class="col-sm-10">
                                            <select class="form-control" name="role" required>
                                                <option value="0" selected>Select Role</option>
                                                @foreach($roles as $r)
                                                    <option value="{{ $r->id }}">{{ $r->name }}</option>
                                                @endforeach
                                            </select>
                                            @if ($errors->has('role'))
                                            <span class="help-block">
                                                    <strong>{{ $errors->first('role') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                        <label class="col-sm-2 control-label">Password<span class="text-danger">*</span></label>
                                        <div class="col-sm-10">
                                            <input type="password" class="form-control" name="password">
                                            @if ($errors->has('password'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('password') }}</strong>
                                                </span>
                                            @endif
                                        </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="panel-footer">
                                    <button class="btn btn-success" type="submit" id="btnSubmit">Submit</button>
                                    <a class="btn btn-danger" href="{{ url('/isa-cms/users') }}">Cancel</a>
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

</body>
@endsection