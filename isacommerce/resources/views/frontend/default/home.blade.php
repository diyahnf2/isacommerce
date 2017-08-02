<!DOCTYPE html>
<html>
<head>
    @include('frontend.default.partials.meta')
    <title>{{ $data['title'] }}</title>
</head>
<body class="option6">
@include('frontend.default.partials.header')
<!-- Home slideder-->
<div id="home-slider">
    <div class="container">
        <div class="section-home-top-6">
            <div class="box-left">
                <div class="homeslider">
                    <ul id="contenhomeslider-customPage">
                      <li><img alt="Funky roots" src="{{ url('theme/frontend/default/assets/data/option6/slide1.jpg')}}" title="Funky roots" /></li>
                      <li><img alt="Funky roots" src="{{ url('theme/frontend/default/assets/data/option6/slide1.jpg')}}" title="Funky roots" /></li>
                      <li><img  alt="Funky roots" src="{{ url('theme/frontend/default/assets/data/option6/slide1.jpg')}}" title="Funky roots" /></li>
                    </ul>
                    <div class="bx-control">
                        <div class="slide-prev">
                            <span id="bx-prev"></span>
                        </div>
                        <div id="bx-pager" class="slide-pager">
                              <a data-slide-index="0" href="">1</a>
                              <a data-slide-index="1" href="">2</a>
                              <a data-slide-index="2" href="">3</a>
                        </div>
                        <div class="slide-next">
                            <span id="bx-next"></span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="box-right">
                <div class="group-banner-slider left">
                    <div class="item banner-opacity">
                        <a href="#"><img src="{{ url('theme/frontend/default/assets/data/option6/banner9.jpg')}}" alt="Banner"></a>
                    </div>
                    <div class="item banner-opacity">
                        <a href="#"><img src="{{ url('theme/frontend/default/assets/data/option6/banner10.jpg')}}" alt="Banner"></a>
                    </div>
                    <div class="item banner-opacity">
                        <a href="#"><img src="{{ url('theme/frontend/default/assets/data/option6/banner11.jpg')}}" alt="Banner"></a>
                    </div>
                </div>
                <div class="group-banner-slider right">
                   <div class="item banner-opacity">
                        <a href="#"><img src="{{ url('theme/frontend/default/assets/data/option6/banner-top.jpg')}}" alt="Banner"></a>
                    </div>
                    <div class="item banner-opacity">
                        <a href="#"><img src="{{ url('theme/frontend/default/assets/data/option6/banner12.jpg')}}" alt="Banner"></a>
                    </div>
                    <div class="item banner-opacity">
                        <a href="#"><img src="{{ url('theme/frontend/default/assets/data/option6/banner13.jpg')}}" alt="Banner"></a>
                    </div>
                </div>
            </div>
            </div>
        </div>
    </div>
</div>
<!-- END Home slideder-->

<div class="content-page">
    <div class="container">
        <!-- featured category fashion -->
        <div class="category-featured fashion">
            <nav class="navbar nav-menu show-brand">
              <div class="container">
                <!-- Brand and toggle get grouped for better mobile display -->
                  <div class="navbar-brand"><a href="{{url('c/fashion')}}"><img alt="fashion" src="{{ url('theme/frontend/default/assets/data/icon-fashion.png')}}" />fashion</a></div>
                  <span class="toggle-menu"></span>
                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="collapse navbar-collapse">           
                  <ul class="nav navbar-nav">
                    <li class="active"><a data-toggle="tab" href="#tab-1">Best salers</a></li>
                    <li><a data-toggle="tab" href="#tab-2">New Arrivals</a></li>
                    <li><a data-toggle="tab" href="#tab-3">Trending</a></li>
                  </ul>
                </div><!-- /.navbar-collapse -->
              </div><!-- /.container-fluid -->
              <div id="elevator-1" class="floor-elevator">
                    <a href="#" class="btn-elevator up disabled fa fa-angle-up"></a>
                    <a href="#elevator-2" class="btn-elevator down fa fa-angle-down"></a>
              </div>
            </nav>
           <div class="product-featured clearfix">
                <div class="row">
                    <div class="col-sm-2 sub-category-wapper">
                        <ul class="sub-category-list">
                            @foreach($data['fashion_cat'] as $fasCat)
                                <li><a href="{{ url('c/fashion/'.$fasCat->category_seo)}}">{{$fasCat->category_name}}</a></li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="col-sm-10 col-right-tab">
                        <div class="product-featured-tab-content">
                            <div class="tab-container">
                                <div class="tab-panel active" id="tab-1">
                                   <div class="box-left">
                                       <div class="banner-img">
                                            <a href="#"><img src="{{ url('theme/frontend/default/assets/data/option6/banner3.jpg')}}" alt="Banner Product"></a>
                                        </div>
                                   </div>
                                   <div class="box-right">
                                       <ul class="product-list row">
                                            @foreach($data['fashion_seller'] as $fasSel)
                                                <li class="col-sm-4">
                                                    <div class="right-block">
                                                        <h5 class="product-name"><a href="{{url('product/'.$fasSel->product_seo)}}">{{$fasSel->product_name}}</a></h5>
                                                        <div class="content_price">
                                                            <span class="price product-price">Rp{{number_format($fasSel->price,0)}}</span>
                                                        </div>
                                                    </div>
                                                    <div class="left-block">
                                                        <a href="{{url('product/'.$fasSel->product_seo)}}"><img class="img-responsive" alt="product" src="{{ url('theme/backend/images/product/', [$fasSel->image])}}" /></a>
                                                        <div class="add-to-cart">
                                                            <a title="Add to Cart" href="buy/{{$fasSel->product_seo}}">Add to Cart</a>
                                                        </div>
                                                    </div>
                                                </li>
                                            @endforeach
                                       </ul>
                                   </div>
                                </div>
                                <div class="tab-panel" id="tab-2">
                                    <div class="box-left">
                                       <div class="banner-img">
                                            <a href="#"><img src="{{ url('theme/frontend/default/assets/data/option6/banner3.jpg')}}" alt="Banner Product"></a>
                                        </div>
                                   </div>
                                   <div class="box-right">
                                       <ul class="product-list row">
                                            @foreach($data['fashion_new'] as $fasNew)
                                                <li class="col-sm-4">
                                                    <div class="right-block">
                                                        <h5 class="product-name"><a href="{{url('product/'.$fasNew->product_seo)}}">{{$fasNew->product_name}}</a></h5>
                                                        <div class="content_price">
                                                            <span class="price product-price">Rp{{number_format($fasNew->price,0)}}</span>
                                                        </div>
                                                    </div>
                                                    <div class="left-block">
                                                        <a href="{{url('product/'.$fasNew->product_seo)}}"><img class="img-responsive" alt="product" src="{{ url('theme/backend/images/product/', [$fasNew->image])}}" /></a>
                                                        <div class="add-to-cart">
                                                            <a title="Add to Cart" href="buy/{{$fasNew->product_seo}}">Add to Cart</a>
                                                        </div>
                                                    </div>
                                                </li>
                                            @endforeach
                                       </ul>
                                   </div>
                                </div>
                                <div class="tab-panel" id="tab-3">
                                   <div class="box-left">
                                       <div class="banner-img">
                                            <a href="#"><img src="{{ url('theme/frontend/default/assets/data/option6/banner3.jpg')}}" alt="Banner Product"></a>
                                        </div>
                                   </div>
                                   <div class="box-right">
                                       <ul class="product-list row">
                                            @foreach($data['fashion_populer'] as $fasPop)
                                                <li class="col-sm-4">
                                                    <div class="right-block">
                                                        <h5 class="product-name"><a href="{{url('product/'.$fasPop->product_seo)}}">{{$fasPop->product_name}}</a></h5>
                                                        <div class="content_price">
                                                            <span class="price product-price">Rp{{number_format($fasPop->price,0)}}</span>
                                                        </div>
                                                    </div>
                                                    <div class="left-block">
                                                        <a href="{{url('product/'.$fasPop->product_seo)}}"><img class="img-responsive" alt="product" src="{{ url('theme/backend/images/product/', [$fasPop->image])}}" /></a>
                                                        <div class="add-to-cart">
                                                            <a title="Add to Cart" href="buy/{{$fasPop->product_seo}}">Add to Cart</a>
                                                        </div>
                                                    </div>
                                                </li>
                                            @endforeach
                                       </ul>
                                   </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
           </div>
        </div>
        <!-- end featured category fashion -->
        <!-- featured category Digital -->
        <div class="category-featured digital">
            <nav class="navbar nav-menu show-brand">
              <div class="container">
                <!-- Brand and toggle get grouped for better mobile display -->
                  <div class="navbar-brand"><a href="{{url('c/elektronik')}}"><img alt="fashion" src="{{ url('theme/frontend/default/assets/data/icon-digital.png')}}" />ELECTRONIC</a></div>
                  <span class="toggle-menu"></span>
                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="collapse navbar-collapse">           
                  <ul class="nav navbar-nav">
                    <li class="active"><a data-toggle="tab" href="#tab-4">Best salers</a></li>
                    <li><a data-toggle="tab" href="#tab-5">New Arrivals</a></li>
                    <li><a data-toggle="tab" href="#tab-6">Trending</a></li>
                  </ul>
                </div><!-- /.navbar-collapse -->
              </div><!-- /.container-fluid -->
              <div id="elevator-2" class="floor-elevator">
                    <a href="#elevator-1" class="btn-elevator up fa fa-angle-up"></a>
                    <a href="#" class="btn-elevator down disabled fa fa-angle-down"></a>
              </div>
            </nav>
           <div class="product-featured clearfix">
                <div class="row">
                    <div class="col-sm-2 sub-category-wapper">
                        <ul class="sub-category-list">
                             @foreach($data['elektronik_cat'] as $elCat)
                                <li><a href="{{ url('c/elektronik/'.$elCat->category_seo)}}">{{$elCat->category_name}}</a></li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="col-sm-10 col-right-tab">
                        <div class="product-featured-tab-content">
                            <div class="tab-container">
                                <div class="tab-panel active" id="tab-4">
                                   <div class="box-left">
                                       <div class="banner-img">
                                            <a href="#"><img src="{{ url('theme/frontend/default/assets/data/option6/banner5.jpg')}}" alt="Banner Product"></a>
                                        </div>
                                   </div>
                                   <div class="box-right">
                                       <ul class="product-list row">
                                            @foreach($data['elektronik_seller'] as $elSel)
                                                <li class="col-sm-4">
                                                    <div class="right-block">
                                                        <h5 class="product-name"><a href="{{url('product/'.$elSel->product_seo)}}">{{$elSel->product_name}}</a></h5>
                                                        <div class="content_price">
                                                            <span class="price product-price">Rp{{number_format($elSel->price,0)}}</span>
                                                        </div>
                                                    </div>
                                                    <div class="left-block">
                                                        <a href="{{url('product/'.$elSel->product_seo)}}"><img class="img-responsive" alt="product" src="{{ url('theme/backend/images/product/', [$elSel->image])}}" /></a>
                                                        <div class="add-to-cart">
                                                            <a title="Add to Cart" href="buy/{{$elSel->product_seo}}">Add to Cart</a>
                                                        </div>
                                                    </div>
                                                </li>
                                            @endforeach
                                       </ul>
                                   </div>
                                </div>
                                <div class="tab-panel" id="tab-5">
                                    <div class="box-left">
                                       <div class="banner-img">
                                            <a href="#"><img src="{{ url('theme/frontend/default/assets/data/option6/banner5.jpg')}}" alt="Banner Product"></a>
                                        </div>
                                   </div>
                                   <div class="box-right">
                                       <ul class="product-list row">
                                            @foreach($data['elektronik_new'] as $elNew)
                                                <li class="col-sm-4">
                                                    <div class="right-block">
                                                        <h5 class="product-name"><a href="{{url('product/'.$elNew->product_seo)}}">{{$elNew->product_name}}</a></h5>
                                                        <div class="content_price">
                                                            <span class="price product-price">Rp{{number_format($elNew->price,0)}}</span>
                                                        </div>
                                                    </div>
                                                    <div class="left-block">
                                                        <a href="{{url('product/'.$elNew->product_seo)}}"><img class="img-responsive" alt="product" src="{{ url('theme/backend/images/product/', [$elNew->image])}}" /></a>
                                                        <div class="add-to-cart">
                                                            <a title="Add to Cart" href="buy/{{$elNew->product_seo}}">Add to Cart</a>
                                                        </div>
                                                    </div>
                                                </li>
                                            @endforeach
                                       </ul>
                                   </div>
                                </div>
                                <div class="tab-panel" id="tab-6">
                                   <div class="box-left">
                                       <div class="banner-img">
                                            <a href="#"><img src="{{ url('theme/frontend/default/assets/data/option6/banner5.jpg')}}" alt="Banner Product"></a>
                                        </div>
                                   </div>
                                   <div class="box-right">
                                       <ul class="product-list row">
                                            @foreach($data['elektronik_populer'] as $elPop)
                                                <li class="col-sm-4">
                                                    <div class="right-block">
                                                        <h5 class="product-name"><a href="{{url('product/'.$elPop->product_seo)}}">{{$elPop->product_name}}</a></h5>
                                                        <div class="content_price">
                                                            <span class="price product-price">Rp{{number_format($elPop->price,0)}}</span>
                                                        </div>
                                                    </div>
                                                    <div class="left-block">
                                                        <a href="{{url('product/'.$elPop->product_seo)}}"><img class="img-responsive" alt="product" src="{{ url('theme/backend/images/product/', [$elPop->image])}}" /></a>
                                                        <div class="add-to-cart">
                                                            <a title="Add to Cart" href="buy/{{$elPop->product_seo}}">Add to Cart</a>
                                                        </div>
                                                    </div>
                                                </li>
                                            @endforeach
                                       </ul>
                                   </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
           </div>
        </div>
        <!-- end featured category Digital-->
    </div>
</div>

<div id="content-wrap">
    <div class="container">
        <!-- service 2 -->
        <div class="services2">
            <ul>
                <li class="col-xs-12 col-sm-6 col-md-4 services2-item">
                    <div class="service-wapper">
                        <div class="row">
                            <div class="col-sm-6 image">
                                <div class="icon">
                                    <img src="{{ url('theme/frontend/default/assets/data/icon-s1.png')}}" alt="service">
                                </div>
                                <h3 class="title"><a href="#">Great Value</a></h3>
                            </div>
                            <div class="col-sm-6 text">
                                We offer competitive prices on our 100 million plus product range.
                            </div>
                        </div>
                    </div>
                </li>
                <li class="col-xs-12 col-sm-6 col-md-4 services2-item">
                    <div class="service-wapper">
                        <div class="row">
                            <div class="col-sm-6 image">
                                <div class="icon">
                                    <img src="{{ url('theme/frontend/default/assets/data/icon-s2.png')}}" alt="service">
                                </div>
                                <h3 class="title"><a href="#">Worldwide Delivery</a></h3>
                            </div>
                            <div class="col-sm-6 text">
                                With sites in 5 languages, we ship to over 200 countries & regions.
                            </div>
                        </div>
                    </div>
                </li>
                <li class="col-xs-12 col-sm-6 col-md-4 services2-item">
                    <div class="service-wapper">
                        <div class="row">
                            <div class="col-sm-6 image">
                                <div class="icon">
                                    <img src="{{ url('theme/frontend/default/assets/data/icon-s3.png')}}" alt="service">
                                </div>
                                <h3 class="title"><a href="#">Safe Payment</a></h3>
                            </div>
                            <div class="col-sm-6 text">
                                Pay with the world’s most popular and secure payment methods.
                            </div>
                        </div>
                    </div>
                </li>
                <li class="col-xs-12 col-sm-6 col-md-4 services2-item">
                    <div class="service-wapper">
                        <div class="row">
                            <div class="col-sm-6 image">
                                <div class="icon">
                                    <img src="{{ url('theme/frontend/default/assets/data/icon-s4.png')}}" alt="service">
                                </div>
                                <h3 class="title"><a href="#">Shop with Confidence</a></h3>
                            </div>
                            <div class="col-sm-6 text">
                                Our Buyer Protection covers your purchase from click to delivery.
                            </div>
                        </div>
                    </div>
                </li>
                <li class="col-xs-12 col-sm-6 col-md-4 services2-item">
                    <div class="service-wapper">
                        <div class="row">
                            <div class="col-sm-6 image">
                                <div class="icon">
                                    <img src="{{ url('theme/frontend/default/assets/data/icon-s5.png')}}" alt="service">
                                </div>
                                <h3 class="title"><a href="#">24/7 Help Center</a></h3>
                            </div>
                            <div class="col-sm-6 text">
                                Round-the-clock assistance for a smooth shopping experience.
                            </div>
                        </div>
                    </div>
                </li>
                <li class="col-xs-12 col-sm-6 col-md-4 services2-item">
                    <div class="service-wapper">
                        <div class="row">
                            <div class="col-sm-6 image">
                                <div class="icon">
                                    <img src="{{ url('theme/frontend/default/assets/data/icon-s6.png')}}" alt="service">
                                </div>
                                <h3 class="title"><a href="#">Shop On-The-Go</a></h3>
                            </div>
                            <div class="col-sm-6 text">
                                Download the app and get the world of KuteShop at your fingertips.
                            </div>
                        </div>
                    </div>
                </li>

            </ul>
        </div>
        <!-- ./service 2 -->
    </div> <!-- /.container -->
</div>

@include('frontend.default.partials.footer')
@include('frontend.default.partials.javascript')

</body>
</html>