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
            <span class="navigation_page">Search</span>
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
                                        @if($c->parent_id == 0)
                                            <li><span></span><a href="{{url('c/'.$c->category_seo)}}">{{ $c->category_name }}</a>
                                            <ul class="tree-menu">
                                                @foreach($data['category'] as $ca)
                                                    @if($ca->parent_id == $c->id)
                                                        <li><span></span><a href="{{url('c/'.$c->category_seo.'/'.$ca->category_seo)}}">{{ $ca->category_name }}</a>
                                                        <ul class="tree-menu">
                                                            @foreach($data['category'] as $caa)
                                                                @if($caa->parent_id == $ca->id)
                                                                    <li><span></span><a href="{{url('c/'.$c->category_seo.'/'.$ca->category_seo.'/'.$caa->category_seo)}}">{{ $caa->category_name }}</a>
                                                                @endif
                                                                </li>
                                                            @endforeach
                                                        </ul>
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
                            <div class="layered-content slider-range">
                                <form method="post" name="priceForm_1">
                                    {{ csrf_field() }}
                                    <input type="hidden" name="keyword" value="{{ $data['keyword'] }}"/> 
                                    <ul class="check-box-list">
                                        <li>
                                            <input type="checkbox" id="p0" class = "price-range" name="price[0]" value="0-500000"/>
                                            <label for="p0">
                                            <span class="button"></span>
                                            Rp.0K - Rp.500K<span class="count"></span>
                                            </label>   
                                        </li>
                                        <li>
                                            <input type="checkbox" id="p1" class = "price-range" name="price[1]" value="500000-1000000"/>
                                            <label for="p1">
                                            <span class="button"></span>
                                            Rp.500K - Rp.1000K<span class="count"></span>
                                            </label>   
                                        </li>
                                        <li>
                                            <input type="checkbox" id="p2" class = "price-range" name="price[2]" value="1000000-2500000"/>
                                            <label for="p2">
                                            <span class="button"></span>
                                            Rp.1000K - Rp.2500K<span class="count"></span>
                                            </label>   
                                        </li>
                                        <li>
                                            <input type="checkbox" id="p3" class = "price-range" name="price[3]" value="2500000-5000000"/>
                                            <label for="p3">
                                            <span class="button"></span>
                                            Rp.2500K - Rp.5000K<span class="count"></span>
                                            </label>   
                                        </li>
                                        <li>
                                            <input type="checkbox" id="p4" class = "price-range" name="price[4]" value="5000000-lebih"/>
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
                        Hasil Pencarian <span class="navigation_page"> "{{$data['keyword']}}"</span>
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
                    <ul class="row product-list grid">
                        @foreach($data['product'] as $p)
                        <li class="col-sx-12 col-sm-4">
                            <div class="product-container">
                                <div class="left-block">
                                    <a href="{{url('product/'.$p->product_seo)}}">
                                        <img class="img-responsive" alt="product" src="{{ url('theme/backend/images/product/', [$p->image])}}" />
                                    </a>
                                    <div class="quick-view">
                                            <a title="Add to my wishlist" class="heart" href="#"></a>
                                            <a title="Add to compare" class="compare" href="#"></a>
                                            <a title="Quick view" class="search" href="#"></a>
                                    </div>
                                    <div class="add-to-cart">
                                        <a title="Add to Cart" href="{{ url('buy',[$p->product_seo]) }}">Add to Cart</a>
                                    </div>
                                </div>
                                <div class="right-block">
                                    <h5 class="product-name"><a href="{{url('product/'.$p->product_seo)}}">{{$p->product_name}}</a></h5>
                                    <div class="content_price">
                                        <span class="price product-price">Rp. {{number_format($p->price, 2)}}</span>
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
                   <!--  <div class="show-product-item">
                        <select name="">
                            <option value="">Show 18</option>
                            <option value="">Show 20</option>
                            <option value="">Show 50</option>
                            <option value="">Show 100</option>
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
<script type="text/javascript" src="{{ url('theme/frontend/default/assets/js/filter-product.js')}}"></script>
</body>
</html>