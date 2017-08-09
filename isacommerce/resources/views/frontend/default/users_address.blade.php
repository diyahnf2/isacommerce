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

            <span class="navigation_page">Shipping Address</span>

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

                                    <li class="active"><span></span><a href="{{ url('users/shipping') }}">Shipping Address</a></li>

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

                    <span class="page-heading-title2">My Address</span>

                </h2>

                <!-- Content page -->

                <div class="content-text clearfix">

                    @if (session('status'))

                        <div role="alert" class="alert alert-success alert-dismissible">

                            <button aria-label="Close" data-dismiss="alert" class="close" type="button"><span aria-hidden="true">×</span></button>

                            {{ session('status') }}

                        </div>

                    @endif

                    <form class="form-horizontal ale-form" method="post" action="{{ url('update-shipping') }}">

                        {{ csrf_field() }}

                       <div class="form-group">

                                    <label class="col-sm-2 control-label">Country<span class="text-danger">*</span></label>

                                        <div class="col-sm-10">

                                            <?php $country_id = (isset($data['address']->country_id) ? $data['address']->country_id : null); ?>

                                            <select name="state" class="form-control">

                                                <option value="">-- Country --</option>

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