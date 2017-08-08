<!DOCTYPE html>
<html>
<head>
    @include('frontend.default.partials.meta')
    <title>ISA Commerce - Best Ecommerce Platform</title>
</head>
<body class="option6 category-page">
@include('frontend.default.partials.header')

<div class="columns-container">
    <div class="container" id="columns">
        <!-- breadcrumb -->
        <div class="breadcrumb clearfix">
            <a class="home" href="{{ url('/')}}" title="Return to Home">Home</a>
            <span class="navigation-pipe">&nbsp;</span>
            <a class="home" href="{{ url('c/'.$data['title_1']->category_seo)}}">{{$data['title_1']->category_name}}</a>
            <span class="navigation-pipe">&nbsp;</span>
            <a class="home" href="{{ url('c/'.$data['title_1']->category_seo.'/'.$data['title_2']->category_seo)}}">{{$data['title_2']->category_name}}</a>
            <span class="navigation-pipe">&nbsp;</span>
            <a class="home" href="{{ url('c/'.$data['title_1']->category_seo.'/'.$data['title_2']->category_seo.'/'.$data['title_3']->category_seo)}}">{{$data['title_3']->category_name}}</a>
        </div>
        <!-- ./breadcrumb -->
        <!-- row -->
        <div class="row">
            <!-- Left colunm -->
            <div class="column col-xs-12 col-sm-3" id="left_column">
                <!-- block category -->
                <div class="block left-module">
                    <p class="title_block">Product types</p>
                    <div class="block_content">
                        <!-- layered -->
                        <div class="layered layered-category">
                            <div class="layered-content">
                                <ul class="tree-menu">
                                    @foreach($data['category'] as $c)
                                        @if($c->parent_id == $data['title_1']->id)
                                            <li>
                                            <span></span><a href="{{ url('c/'.$data['title_1']->category_seo.'/'.$c->category_seo)}}">
                                            {{ $c->category_name }}</a>
                                            <ul class="tree-menu">
                                                @foreach($data['category'] as $ca)
                                                    @if($ca->parent_id == $c->id)
                                                        @if($ca->id == $data['title_3']->id)
                                                            <li class="active">
                                                        @else
                                                            <li>
                                                        @endif
                                                        <span></span><a href="{{ url('c/'.$data['title_1']->category_seo.'/'.$c->category_seo.'/'.$ca->category_seo)}}">
                                                        {{ $ca->category_name }}</a>
                                                    @endif
                                                    </li>
                                                @endforeach
                                            </ul>
                                        @endif
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                        <!-- ./layered -->
                    </div>
                </div>
                <!-- ./block category  -->
                <!-- block filter -->
                <div class="block left-module">
                    <p class="title_block">Filter selection</p>
                    <div class="block_content">
                        <!-- layered -->
                        <div class="layered layered-filter-price">
                            <!-- filter price -->
                            <div class="layered_subtitle">price</div>
                            @if($data['title_1']->id == 31)
                            <div class="layered-content slider-range">
                                <form method="post" action="{{ url('c/filter_3') }}" name="priceForm_1">
                                {{ csrf_field() }}
                                <input type="hidden" name="seo_1" value="{{$data['title_1']->category_seo}}"/> 
                                <input type="hidden" name="seo_2" value="{{$data['title_2']->category_seo}}"/> 
                                <input type="hidden" name="seo_3" value="{{$data['title_3']->category_seo}}"/> 
                                    <ul class="check-box-list">
                                        <li>
                                            <input type="checkbox" id="p0" class="price-range" name="price[0]" value="0-500000"/>
                                            <label for="p0">
                                            <span class="button"></span>
                                            Rp.0K - Rp.500K<span class="count"></span>
                                            </label>   
                                        </li>
                                        <li>
                                            <input type="checkbox" id="p1" class="price-range" name="price[1]" value="500000-1000000"/>
                                            <label for="p1">
                                            <span class="button"></span>
                                            Rp.500K - Rp.1000K<span class="count"></span>
                                            </label>   
                                        </li>
                                        <li>
                                            <input type="checkbox" id="p2" class="price-range" name="price[2]" value="1000000-2500000"/>
                                            <label for="p2">
                                            <span class="button"></span>
                                            Rp.1000K - Rp.2500K<span class="count"></span>
                                            </label>   
                                        </li>
                                        <li>
                                            <input type="checkbox" id="p3" class="price-range" name="price[3]" value="2500000-5000000"/>
                                            <label for="p3">
                                            <span class="button"></span>
                                            Rp.2500K - Rp.5000K<span class="count"></span>
                                            </label>   
                                        </li>
                                        <li>
                                            <input type="checkbox" id="p4" class="price-range" name="price[4]" value="5000000-lebih"/>
                                            <label for="p4">
                                            <span class="button"></span>
                                            Rp.5000K - Lebih<span class="count"></span>
                                            </label>   
                                        </li>
                                    </ul>
                                </form>
                                <div class="products-block">
                                    <div class="products-block-price">
                                        <a class="link-all" id="js-filter">Submit</a>
                                    </div>
                                </div>
                            </div>
                            @else
                            <div class="layered-content slider-range">
                                <div data-label-reasult="Range:" data-min="0" data-max="500" data-unit="Rp." class="slider-range-price" data-value-min="50" data-value-max="350"></div>
                                <div class="amount-range-price">Range: Rp.50K - Rp.500K</div>
                                <form method="post" action="{{ url('c/filter_3') }}" name="priceForm_2">
                                {{ csrf_field() }}
                                <input type="hidden" name="seo_1" value="{{$data['title_1']->category_seo}}"/> 
                                <input type="hidden" name="seo_2" value="{{$data['title_2']->category_seo}}"/> 
                                <input type="hidden" name="seo_3" value="{{$data['title_3']->category_seo}}"/> 
                                    <ul class="check-box-list">
                                        <li>
                                            <input type="checkbox" id="p0" class="price-range" name="price[0]" value="0-50000"/>
                                            <label for="p0">
                                            <span class="button"></span>
                                            Rp.0K - Rp.50K<span class="count"></span>
                                            </label>   
                                        </li>
                                        <li>
                                            <input type="checkbox" id="p1" class="price-range" name="price[1]" value="50000-100000"/>
                                            <label for="p1">
                                            <span class="button"></span>
                                            Rp.50K - Rp.100K<span class="count"></span>
                                            </label>   
                                        </li>
                                        <li>
                                            <input type="checkbox" id="p2" class="price-range" name="price[2]" value="100000-250000"/>
                                            <label for="p2">
                                            <span class="button"></span>
                                            Rp.100K - Rp.250K<span class="count"></span>
                                            </label>   
                                        </li>
                                        <li>
                                            <input type="checkbox" id="p3" class="price-range" name="price[3]" value="250000-500000"/>
                                            <label for="p3">
                                            <span class="button"></span>
                                            Rp.250K - Rp.500K<span class="count"></span>
                                            </label>   
                                        </li>
                                        <li>
                                            <input type="checkbox" id="p4" class="price-range" name="price[4]" value="500000-lebih"/>
                                            <label for="p4">
                                            <span class="button"></span>
                                            Rp.500K - Lebih<span class="count"></span>
                                            </label>   
                                        </li>
                                    </ul>
                                </form>
                                <div class="products-block">
                                    <div class="products-block-price">
                                        <a class="link-all" id="js-filter">Submit</a>
                                    </div>
                                </div>
                            </div>
                            @endif
                            <!-- ./filter price -->
                        </div>
                        <!-- ./layered -->
                    </div>
                </div>
                <!-- ./block filter  -->
                
                <!-- left silide -->
                <div class="col-left-slide left-module">
                    <ul class="owl-carousel owl-style2" data-loop="true" data-nav = "false" data-margin = "30" data-autoplayTimeout="1000" data-autoplayHoverPause = "true" data-items="1" data-autoplay="true">
                        <li><a href="#"><img src="{{ url('theme/frontend/default/assets/data/slide-left.jpg')}}" alt="slide-left"></a></li>
                        <li><a href="#"><img src="{{ url('theme/frontend/default/assets/data/slide-left2.jpg')}}" alt="slide-left"></a></li>
                        <li><a href="#"><img src="{{ url('theme/frontend/default/assets/data/slide-left3.png')}}" alt="slide-left"></a></li>
                    </ul>

                </div>
                <!--./left silde-->
                <!-- Testimonials -->
                <div class="block left-module">
                    <p class="title_block">Testimonials</p>
                    <div class="block_content">
                        <ul class="testimonials owl-carousel" data-loop="true" data-nav = "false" data-margin = "30" data-autoplayTimeout="1000" data-autoplay="true" data-autoplayHoverPause = "true" data-items="1">
                            <li>
                                <div class="client-mane">Roverto & Maria</div>
                                <div class="client-avarta">
                                    <img src="{{ url('theme/frontend/default/assets/data/testimonial.jpg')}}" alt="client-avarta">
                                </div>
                                <div class="testimonial">
                                    "Your product needs to improve more. To suit the needs and update your image up"
                                </div>
                            </li>
                            <li>
                                <div class="client-mane">Roverto & Maria</div>
                                <div class="client-avarta">
                                    <img src="{{ url('theme/frontend/default/assets/data/testimonial.jpg')}}" alt="client-avarta">
                                </div>
                                <div class="testimonial">
                                    "Your product needs to improve more. To suit the needs and update your image up"
                                </div>
                            </li>
                            <li>
                                <div class="client-mane">Roverto & Maria</div>
                                <div class="client-avarta">
                                    <img src="{{ url('theme/frontend/default/assets/data/testimonial.jpg')}}" alt="client-avarta">
                                </div>
                                <div class="testimonial">
                                    "Your product needs to improve more. To suit the needs and update your image up"
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
                <!-- ./Testimonials -->
            </div>
            <!-- ./left colunm -->
            <!-- Center colunm-->
            <div class="center_column col-xs-12 col-sm-9" id="center_column">
                <!-- category-slider -->
                <div class="category-slider">
                    <ul class="owl-carousel owl-style2" data-dots="false" data-loop="true" data-nav = "true" data-autoplayTimeout="1000" data-autoplayHoverPause = "true" data-items="1">
                        <li>
                            <img src="{{ url('theme/frontend/default/assets/data/category-slide.jpg')}}" alt="category-slider">
                        </li>
                        <li>
                            <img src="{{ url('theme/frontend/default/assets/data/slide-cart2.jpg')}}" alt="category-slider">
                        </li>
                    </ul>
                </div>
                <!-- ./category-slider -->
                <!-- view-product-list-->
                <div id="view-product-list" class="view-product-list">
                    <h2 class="page-heading">
                        {{$data['title_3']->category_name}}
                    </h2>
                    <ul class="display-product-option">
                        <li class="view-as-grid selected">
                            <span>grid</span>
                        </li>
                        <li class="view-as-list">
                            <span>list</span>
                        </li>
                    </ul>
                    <!-- PRODUCT LIST -->
                    <ul class="row product-list grid" id="product-list-index">
                        <?php $i =0; //jangan dihapus nnti indexnya error ?>
                        @foreach($data['product'] as $p)
                        <li class="col-sx-12 col-sm-4">
                            <div class="product-container">
                                <div class="left-block">
                                    <a href="{{url('product/'.$p->product_seo)}}">
                                        <img class="img-responsive" alt="product" src="{{ url('theme/backend/images/product/', [$p->image])}}" />
                                    </a>
                                    <div class="quick-view">
                                            <a title="Add to my wishlist" class="heart wishlist_{{$p->id}}" href="#" onclick="wishlist({{$p->id}})" id="{{$p->id}}"></a>
                                            <a title="Add to compare" class="compare" href="#"></a>
                                            <a title="Quick view" class="search" href="#"></a>
                                    </div>
                                    <div class="add-to-cart">
                                        <input type="hidden" name="seo" id="seo_{{$i}}" value="{{ $p->product_seo }}">
                                        <input type="hidden" name="product_id" id="product_id_{{$i}}" value="{{ $p->id }}">
                                        <input type="hidden" name="quantity" id="quantity_{{$i}}" value="{{ $p->quantity }}">
                                        <input type="hidden" name="baseurl" id="baseurl" value="{{ url('/') }}">
                                        <a title="Add to Cart" class="cart-to-add" href="#">Add to Cart</a>
                                    </div>
                                </div>
                                <div class="right-block">
                                    <h5 class="product-name"><a href="{{url('product/'.$p->product_seo)}}">{{$p->product_name}}</a></h5>
                                    <div class="content_price">
                                        <?php 
                                        $date = date('Y-m-d H:i:s');
                                        if(!empty($p->discount_amount ) && ($p->is_active == 'Y') && ($p->expiry > $date )){
                                            $old_price = $p->price;
                                            if($p->discount_operation == '-'){
                                                $disc_price = $p->price - $p->discount_amount;
                                            }elseif($p->discount_operation == '%'){
                                                $disc_price = $p->price - ($p->price*$p->discount_amount/100);
                                            }elseif($p->discount_operation == 's'){
                                                $disc_price = $p->discount_amount;
                                            }
                                            echo '<span class="price product-price">Rp. '.number_format($disc_price, 2).'</span>';
                                            echo "<br/>";
                                            echo '<span class="price old-price">Rp. '.number_format($old_price, 2).'</span>';
                                        }else{
                                            echo '<span class="price product-price">Rp. '.number_format($p->price, 2).'</span>';
                                        }
                                        ?>
                                    </div>
                                    <div class="info-orther">
                                        <p>Item Code: #453217907</p>
                                        <p class="availability">Availability: <span>In stock</span></p>
                                        <div class="product-desc">
                                            Vestibulum eu odio. Suspendisse potenti. Morbi mollis tellus ac sapien. Praesent egestas tristique nibh. Nullam dictum felis eu pede mollis pretium. Fusce egestas elit eget lorem. In auctor lobortis lacus. Suspendisse faucibus, nunc et pellentesque egestas, lacus ante convallis tellus, vitae iaculis lacus elit id tortor.
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                         <?php $i++; ?>
                        @endforeach
                    </ul>
                    <!-- ./PRODUCT LIST -->
                </div>
                <!-- ./view-product-list-->
                <div class="sortPagiBar">
                    <div class="bottom-pagination">
                        <nav>
                          {{ $data['product']->links() }}
                        </nav>
                    </div>
                    <!-- <div class="show-product-item">
                        <select name="">
                            <option value="">Show 9</option>
                            <option value="">Show 18</option>
                            <option value="">Show 27</option>
                            <option value="">Show 36</option>
                        </select>
                    </div>
                    <div class="sort-product">
                        <select>
                            <option value="">Product Name</option>
                            <option value="">Price</option>
                        </select>
                        <div class="sort-product-icon">
                            <i class="fa fa-sort-alpha-asc"></i>
                        </div>
                    </div> -->
                </div>
            </div>
            <!-- ./ Center colunm -->
        </div>
        <!-- ./row-->
    </div>
</div>

@include('frontend.default.partials.footer')
@include('frontend.default.partials.javascript')
<script type="text/javascript" src="{{ url('theme/frontend/default/assets/js/accounting.min.js')}}"></script>
<script type="text/javascript" src="{{ url('theme/frontend/default/assets/js/category_product.js')}}"></script>
<script type="text/javascript" src="{{ url('theme/frontend/default/assets/js/filter-category-3.js')}}"></script>
<script type="text/javascript" src="{{ url('theme/frontend/default/assets/js/wishlist.js')}}"></script>
</body>
</html>