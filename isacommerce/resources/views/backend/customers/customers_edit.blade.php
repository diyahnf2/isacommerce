@extends('backend.layout.layout')
@section('singlecss')
<link href="{{ url('theme/backend/plugins/slidepushmenus/css/component.css') }}" rel="stylesheet" type="text/css"/>
<script src="http://demo.itsolutionstuff.com/plugin/jquery.js"></script>
<link rel="stylesheet" href="http://demo.itsolutionstuff.com/plugin/bootstrap-3.min.css">
@endsection
@section('content')
<body class="page-header-fixed">
    <div class="overlay"></div>
    <main class="page-content content-wrap">
        @include('backend.layout.navigation')
        <div class="page-inner">
            <div class="page-title">
                <h3>Customers</h3>
                <div class="page-breadcrumb">
                    <ol class="breadcrumb">
                        <li><a href="{{ url('isa-cms/dashboard') }}">Dashboard</a></li>
                        <li><a href="{{ url('isa-cms/customers') }}">Customers</a></li>
                        <li class="active">Edit</li>
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
                        @if ($errors->has('id'))
                            <div role="alert" class="alert alert-success alert-dismissible">
                                <button aria-label="Close" data-dismiss="alert" class="close" type="button"><span aria-hidden="true">×</span></button>
                                {{ $errors->first('id') }}
                            </div>
                        @endif
                        <form method="post" action="{{ url('/isa-cms/customers/update') }}">
                            <input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
                            <input type="hidden" name="id" value="{{ $data['customer']->id }}">
                            @if(!empty($data['customer']->address->id))
                                <input type="hidden" name="id_address" value="{{ $data['customer']->address->id }}">
                            @endif
                            <div class="panel panel-white">
                                <div class="panel-heading clearfix">
                                    <h4 class="panel-title">Basic Info</h4>
                                </div>
                                <div class="panel-body form-horizontal">
                                    <div class="form-group{{ $errors->has('firstname') ? ' has-error' : '' }}">
                                        <label class="col-sm-2 control-label">First Name<span class="text-danger">*</span></label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" name="firstname" value="{{ $data['customer']->firstname }}" required>
                                            @if ($errors->has('firstname'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('firstname') }}</strong>
                                                </span>
                                            @endif
                                        </span>
                                        </div>
                                    </div>
                                    <div class="form-group{{ $errors->has('lastname') ? ' has-error' : '' }}">
                                        <label class="col-sm-2 control-label">Last Name<span class="text-danger">*</span></label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" name="lastname" value="{{ $data['customer']->lastname }}" required>
                                            @if ($errors->has('lastname'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('lastname') }}</strong>
                                                </span>
                                            @endif
                                        </span>
                                        </div>
                                    </div>
                                    <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                        <label class="col-sm-2 control-label">Email<span class="text-danger">*</span></label>
                                        <div class="col-sm-10">
                                            <input type="email" class="form-control" name="email" value="{{ $data['customer']->email }}" required>
                                            @if ($errors->has('email'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('email') }}</strong>
                                                </span>
                                            @endif
                                        </span>
                                        </div>
                                    </div>
                                    <div class="form-group{{ $errors->has('phone') ? ' has-error' : '' }}">
                                        <label class="col-sm-2 control-label">Mobile<span class="text-danger">*</span></label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" name="phone" value="{{ $data['customer']->phone }}" required>
                                            @if ($errors->has('phone'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('phone') }}</strong>
                                                </span>
                                            @endif
                                        </span>
                                        </div>
                                    </div>
                                    <div class="form-group{{ $errors->has('address') ? ' has-error' : '' }}">
                                        <label class="col-sm-2 control-label">Address<span class="text-danger">*</span></label>
                                        <div class="col-sm-10">
                                            <?php $address = (isset($data['customer']->address->address) ? $data['customer']->address->address : null); ?>
                                            <input type="text" class="form-control" name="address" value="{{ $address }}" required>
                                            @if ($errors->has('address'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('address') }}</strong>
                                                </span>
                                            @endif
                                        </span>
                                        </div>
                                    </div>
                                    <div class="form-group{{ $errors->has('city') ? ' has-error' : '' }}">
                                        <label class="col-sm-2 control-label">City<span class="text-danger">*</span></label>
                                        <div class="col-sm-10">
                                            <?php $city = (isset($data['customer']->address->city) ? $data['customer']->address->city : null); ?>
                                            <input type="text" class="form-control" name="city" value="{{ $city }}" required>
                                            @if ($errors->has('city'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('city') }}</strong>
                                                </span>
                                            @endif
                                        </span>
                                        </div>
                                    </div>
                                    <div class="form-group{{ $errors->has('postcode') ? ' has-error' : '' }}">
                                        <label class="col-sm-2 control-label">Postcode<span class="text-danger">*</span></label>
                                        <div class="col-sm-10">
                                            <?php $postcode = (isset($data['customer']->address->postcode) ? $data['customer']->address->postcode : null); ?>
                                            <input type="text" class="form-control" name="postcode" value="{{ $postcode }}" required>
                                            @if ($errors->has('postcode'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('postcode') }}</strong>
                                                </span>
                                            @endif
                                        </span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">Country<span class="text-danger">*</span></label>
                                        <div class="col-sm-10">
                                        <?php $country_id = (isset($data['customer']->address->country_id) ? $data['customer']->address->country_id : null); ?>
                                        <select name="state" class="form-control">
                                            <option value="">--- Select State ---</option>
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
                                            <?php $province_id = (isset($data['customer']->address->province_id) ? $data['customer']->address->province_id : null); ?>
                                            <select class="form-control" name="province" required id="province">
                                                @foreach($data['province'] as $p)
                                                    @if ($p->id == $province_id)
                                                        <option value="{{ $p->id }}" selected>{{ $p->name }}</option>
                                                    @else
                                                        <option value="{{ $p->id }}">{{ $p->name }}</option>
                                                    @endif
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                <div class="panel-footer">
                                    <button class="btn btn-success" type="submit">Submit</button>
                                    <a class="btn btn-danger" href="{{ url('/isa-cms/customers') }}">Cancel</a>
                                    <input type="hidden" name="baseurl" id="baseurl" value="{{ url('/') }}">
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
@endsection