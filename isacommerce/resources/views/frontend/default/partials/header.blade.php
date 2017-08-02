<!-- HEADER -->
<div id="header" class="header">
    <div class="top-header">
        <div class="container">
            <div class="top-bar-social">
                <a href="#"><i class="fa fa-facebook"></i></a>
                <a href="#"><i class="fa fa-twitter"></i></a>
                <a href="#"><i class="fa fa-pinterest"></i></a>
                <a href="#"><i class="fa fa-google-plus"></i></a>
            </div>
            <div class="support-link">
                <a href="#">Abount Us</a>
                <a href="#">Support</a>
            </div>

            <div id="user-info-top" class="user-info pull-right">
                @if(Auth::guard('user')->user())
                <div class="dropdown">
                    <a class="current-open" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" href="#"><span>My Account</span></a>
                    <ul class="dropdown-menu mega_dropdown" role="menu">
                        <li><a href="{{ url('users/profile') }}">Profile</a></li>
                        <li><a href="{{ url('signout') }}">Sign out</a></li>
                    </ul>
                </div>
                @else
                    <a class="current-open" href="{{ url('signin-signup') }}"><span>Sign in or Sign up</span></a>
                @endif
            </div>
        </div>
    </div>
    <!--/.top-header -->
    <!-- MAIN HEADER -->
    <div class="container main-header">
        <div class="row">
            <div class="col-xs-12 col-sm-3 logo">
                <a href="{{ url('/') }}"><img alt="WebDev Shop" src="{{ url('theme/frontend/default/assets/images/logo.png')}}" /></a>
            </div>
            <div class="col-xs-7 col-sm-7 header-search-box">
                <form class="form-inline">
                    {{ csrf_field() }}
                    <div class="form-group form-category">
                        <select id = "select-category" class="select-category" name="category">
                            <option value="all" selected>All Categories</option>
                            @foreach ($data['all_category'] as $c)
                                <option value="{{ $c->category_seo }}">{{ $c->category_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group input-serach">
                        <input type="text" id="keyword" placeholder="Keyword here..." name="keyword">
                        <input type="hidden" name="baseurl" id="baseurl" value="{{ url('/') }}">
                    </div>
                    <a id="js-search" class="pull-right btn-search"></a>
                </form>
            </div>
            <div id="cart-block" class="col-xs-5 col-sm-2 shopping-cart-box">
                <?php $cart = ($data['cart'] != 0 ? count($data['cart']) : 0); ?>
                <a class="cart-link" href="{{ url('cart') }}">
                    <span class="title">Shopping cart</span>
                    <span class="total" id="total">{{ $cart }} items</span>
                    <span class="notify notify-left" id="cart-elemen">{{ $cart }}</span>
                </a>
                <div class="cart-block">
                    <div class="cart-block-content">
                        @if($data['cart'] !=0)
                        <?php $total=0; $i=1; ?>
                        <h5 class="cart-title" id="cart-title">{{ $cart }} Items in my cart</h5>
                        <div class="cart-block-list">
                            <ul id="cart-list">
                                @foreach($data['cart'] as $c)
                                    <li class="product-info">
                                        <div class="p-left">
                                            <a class="remove_link" data-toggle="modal" data-target="#modal-delete-confirmation" data-action-target="{{ url('cart/delete',[$c->cart_id]) }}"></a>
                                            <a href="#">
                                            <img class="img-responsive" src="{{ url('theme/backend/images/product', [$c->image])}}" alt="p10">
                                            </a>
                                        </div>
                                        <div class="p-right">
                                            <p class="p-name">{{ $c->product_name }}</p>
                                            <p class="p-rice">{{number_format($c->price, 2)}}</p>
                                            <p>Qty: {{ $c->quantity }}</p>
                                        </div>
                                    </li>
                                <?php $total += $c->price*$c->quantity ; $i++; ?>
                                @endforeach
                            </ul>
                        </div>
                        <div class="toal-cart">
                            <span>Total</span>
                            <span class="toal-price pull-right" id="total-price">Rp. {{number_format($total, 2)}}</span>
                        </div>
                        <!-- <div class="toal-cart">
                            <span>Tax</span>
                            <span class="toal-price pull-right">Rp. {{number_format($total*0.1, 2)}}</span>
                        </div> -->
                        <div class="cart-buttons">
                            <a href="{{ url('cart') }}" class="btn-check-out">Checkout</a>
                        </div>
                         @else
                            <h5 class="cart-title">No Items in my cart</h5>
                        @endif
                    </div>
                </div>
            </div>
        </div>    
    </div>
    <!-- END MANIN HEADER -->
    <div id="nav-top-menu" class="nav-top-menu">
        <div class="container">
            <div class="row">
                <div id="main-menu" class="col-sm-12 main-menu">
                    <nav class="navbar navbar-default">
                        <div class="container-fluid">
                            <div class="navbar-header">
                                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                                    <i class="fa fa-bars"></i>
                                </button>
                                <a class="navbar-brand" href="#">MENU</a>
                            </div>
                            <div id="navbar" class="navbar-collapse collapse">
                                <ul class="nav navbar-nav">
                                    <li class="active"><a href="{{ url('/') }}">Home</a></li>
                                    @foreach ($data['all_category'] as $c)
                                    <li class="dropdown">
                                        <a href="{{url('c/'.$c->category_seo)}}" class="dropdown-toggle" data-toggle="dropdown">{{$c->category_name}}</a>
                                        <ul class="dropdown-menu mega_dropdown col-md-12" role="menu">
                                            @foreach ($data['category'] as $ca)
                                                @if($ca->parent_id == $c->id)
                                                    <li class="block-container col-sm-3">
                                                        <ul class="block">
                                                            <li class="link_container group_header">
                                                                <a href="{{ url('c/'.$c->category_seo.'/'.$ca->category_seo) }}">{{$ca->category_name}}</a>
                                                            </li>
                                                            @foreach ($data['category'] as $caa)
                                                                @if($caa->parent_id == $ca->id)
                                                                    <li class="link_container"><a href="{{ url('c/'.$c->category_seo.'/'.$ca->category_seo.'/'.$caa->category_seo) }}">{{$caa->category_name}}</a></li>
                                                                @endif
                                                            @endforeach
                                                        </ul>
                                                    </li>
                                                @endif
                                            @endforeach
                                        </ul>
                                    </li>
                                    @endforeach
                                </ul>
                            </div><!--/.nav-collapse -->
                        </div>
                    </nav>
                </div>
            </div>
            <!-- userinfo on top-->
            <div id="form-search-opntop">
            </div>
            <!-- userinfo on top-->
            <div id="user-info-opntop">

            </div>
            <!-- CART ICON ON MMENU -->
            <div id="shopping-cart-box-ontop">
                <i class="fa fa-shopping-cart"></i>
                <div class="shopping-cart-box-ontop-content"></div>
            </div>
        </div>
    </div>
</div>
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
<!-- end header -->
<script type="text/javascript" src="{{ url('theme/frontend/default/assets/lib/jquery/jquery-1.11.2.min.js')}}"></script>
<script type="text/javascript" src="{{ url('theme/frontend/default/assets/js/search-product.js')}}"></script>
