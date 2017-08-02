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
                                    <li><span></span><a href="{{ url('users/profile') }}">Personal Information</a></li>
                                    <li><span></span><a href="{{ url('users/shipping') }}">Shipping Address</a></li>
                                    <li><span></span><a href="{{ url('users/orders') }}">Orders History</a></li>
                                    <li class="active"><span></span><a href="{{ url('users/wishlist') }}">Wishlist</a></li>
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
                    <span class="page-heading-title2">My Wishlist</span>
                </h2>
                <!-- Content page -->
                <div class="content-text clearfix">
                    <table class="table table-bordered table-responsive cart_summary">
                    <thead>
                        <tr>
                            <th>Image</th>
                            <th>Product Name</th>
                            <th>Price</th>
                            <th>Added</th>
                            <th width="100">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <form method="post" action="checkout/quantity" name="cartForm">
                        @foreach($data['wishlist'] as $w)
                            <tr>
                                <td class="price"><img src="{{ url('theme/backend/images/product/', [$w->image])}}" alt="Product"></td>
                                <td class="price"><span>{{ $w->product_name }}</span></td>
                                <td class="price"><span>{{number_format($w->price, 2)}}</span></td>
                                <td class="price"><span>{{ date('d F Y', strtotime($w->created_at)) }}</span></td>
                                <td>
                                    <div aria-label="Justified button group" role="group" class="btn-group btn-group-justified">
                                        <a role="button" class="btn btn-info" href="{{ url('/buy',[$w->product_seo]) }}" data-toggle="tooltip" data-placement="top" title="Add to Cart"><i class="fa fa-shopping-cart" aria-hidden="true"></i></a>
                                        <a role="button" class="btn btn-danger" href="#" data-toggle="modal" title="Delete" data-target="#modal-delete-confirmation" data-action-target="{{ url('/users/wishlist/delete',[$w->id]) }}"><i class="fa fa-trash" aria-hidden="true"></i></a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </form>
                    </tbody> 
                </table>


                </div>
                <!-- ./Content page -->
            </div>
            <!-- ./ Center colunm -->
        </div>
        <!-- ./row-->
    </div>
</div>
<!-- ./page wapper-->
<div class="modal fade modal-danger" id="modal-delete-confirmation" tabindex="-1" role="dialog" aria-labelledby="delete-confirmation-title" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title" id="delete-confirmation-title">Confirmation</h4>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete this item? 
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-github" data-dismiss="modal">Cancel</button>
                    <a id="delete" href="" class="btn btn-danger"><i class="fa fa-trash"></i> Delete</a>
                </div>
            </div>
        </div>
    </div>

@include('frontend.default.partials.footer')
@include('frontend.default.partials.javascript')
<script type="text/javascript">
    $( document ).ready(function() {
        $('#modal-delete-confirmation').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var actionTarget = button.data('action-target');
            var modal = $(this);
            modal.find('#delete').attr('href', actionTarget);
        });
    });
</script>

</body>
</html>