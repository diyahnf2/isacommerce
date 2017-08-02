@extends('backend.layout.layout')
@section('singlecss')
<link href="{{ url('theme/backend/plugins/slidepushmenus/css/component.css') }}" rel="stylesheet" type="text/css"/>
<link href="{{ url('theme/backend/plugins/summernote-master/summernote.css') }}" rel="stylesheet" type="text/css"/>
@endsection
@section('content')
<body class="page-header-fixed">
    <div class="overlay"></div>
    <main class="page-content content-wrap">
        @include('backend.layout.navigation')
        <div class="page-inner">
            <div class="page-title">
                <h3>Categories</h3>
                <div class="page-breadcrumb">
                    <ol class="breadcrumb">
                        <li><a href="{{ url('/isa-cms/dashboard') }}">Dashboard</a></li>
                        <li><a href="{{ url('/isa-cms/categories') }}">Categories</a></li>
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
                        <form method="post" action="{{ url('/isa-cms/categories/store') }}">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                            <div class="panel panel-white">
                                <div class="panel-heading clearfix">
                                    <h4 class="panel-title">Add Category</h4>
                                </div>
                                <div class="panel-body form-horizontal">
                                    <div class="form-group{{ $errors->has('category_name') ? ' has-error' : '' }}">
                                        <label class="col-sm-2 control-label">Name<span class="text-danger">*</span></label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" name="category_name" value="{{ old('category_name') }}" required>
                                            @if ($errors->has('category_name'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('category_name') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">Parent Category</label>
                                        <div class="col-sm-10">
                                            <select class="form-control" name="parent_id" required id="province">
                                                <option value="0" selected>Select Parent Category</option>
                                                   @foreach($category as $c)
                                                        @if ($c->parent_id == 0)
                                                            <option value="{{ $c->id }}">{{ $c->category_name }}</option>
                                                            {{ $x = $c->id }}

                                                            @foreach($category as $ca)
                                                                @if ($ca->parent_id == $x)
                                                                    <option value="{{ $ca->id }}">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;> {{ $ca->category_name }}</option>
                                                                @endif
                                                            @endforeach
                                                        @endif
                                                   @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group{{ $errors->has('category_meta_title') ? ' has-error' : '' }}">
                                        <label class="col-sm-2 control-label">Meta Title<span class="text-danger">*</span></label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" name="category_meta_title" value="{{ old('category_meta_title') }}" required>
                                            @if ($errors->has('category_meta_title'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('category_meta_title') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group{{ $errors->has('category_meta_description') ? ' has-error' : '' }}">
                                        <label class="col-sm-2 control-label">Meta Tag Description<span class="text-danger">*</span></label>
                                        <div class="col-sm-10">
                                            <textarea class="form-control" name="category_meta_description" required>{{ old('category_meta_description') }}</textarea>
											@if ($errors->has('category_meta_description'))
												<span class="help-block">
												   <strong>{{ $errors->first('category_meta_description') }}</strong>
												</span>
											@endif
                                        </div>
                                    </div>
                                    <div class="form-group{{ $errors->has('category_meta_keyword') ? ' has-error' : '' }}">
                                        <label class="col-sm-2 control-label">Meta Tag Keywords<span class="text-danger">*</span></label>
                                        <div class="col-sm-10">
                                            <textarea class="form-control" name="category_meta_keyword" required>{{ old('category_meta_keyword') }}</textarea>
											@if ($errors->has('category_meta_keyword'))
												<span class="help-block">
												   <strong>{{ $errors->first('category_meta_keyword') }}</strong>
												</span>
											@endif
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">Status<span class="text-danger">*</span></label>
                                        <div class="col-sm-10">
                                            <label class="radio-inline">
                                              <input type="radio" name="status" id="inlineRadio1" value="Y" checked> Enable
                                            </label>
                                            <label class="radio-inline">
                                              <input type="radio" name="status" id="inlineRadio2" value="N"> Disable
                                            </label>
                                        </div>
                                    </div>
                                </div>
								<div class="panel-footer">
									<button class="btn btn-success btn-space" type="submit">Submit</button>
									<a class="btn btn-danger btn-space" href="{{ url('/isa-cms/services') }}">Cancel</a>
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
    <script src="{{ url('theme/backend/plugins/summernote-master/summernote.min.js') }}"></script>
    <script>
    $(document).ready(function() {
        $('.summernote').summernote({
            height: 150
        });
    });
    </script>
</body>
@endsection