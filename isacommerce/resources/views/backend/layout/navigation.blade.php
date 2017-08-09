<div class="navbar">
    <div class="navbar-inner">
        <div class="sidebar-pusher">
            <a href="javascript:void(0);" class="waves-effect waves-button waves-classic push-sidebar">
                <i class="fa fa-bars"></i>
            </a>
        </div>
        <div class="logo-box">
            <a href="{{ url('/isa-cms/dashboard') }}" class="logo-text"><span>ISA CMS</span></a>
        </div><!-- Logo Box -->
        <div class="topmenu-outer">
            <div class="top-menu">
                <ul class="nav navbar-nav navbar-left">
                    <li>        
                        <a href="javascript:void(0);" class="waves-effect waves-button waves-classic sidebar-toggle"><i class="fa fa-bars"></i></a>
                    </li>
                    <!-- <li>
                        <a href="#cd-nav" class="waves-effect waves-button waves-classic cd-nav-trigger"><i class="fa fa-diamond"></i></a>
                    </li> -->
                    <li>        
                        <a href="javascript:void(0);" class="waves-effect waves-button waves-classic toggle-fullscreen"><i class="fa fa-expand"></i></a>
                    </li>
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle waves-effect waves-button waves-classic" data-toggle="dropdown">
                            <span class="user-name">{{ Auth::guard('admin')->user()->name }}<i class="fa fa-angle-down"></i></span>
                            <img class="img-circle avatar" src="{{ url('theme/backend/images/avatar1.png') }}" width="40" height="40" alt="">
                        </a>
                        <ul class="dropdown-menu dropdown-list" role="menu">
                            <li role="presentation"><a href="{{ url('/isa-cms/profile',Auth::guard('admin')->user()->id) }}"><i class="fa fa-user"></i>Profile</a></li>
                            <li role="presentation"><a href="{{ url('/isa-cms/logout') }}"><i class="fa fa-sign-out m-r-xs"></i>Log out</a></li>
                        </ul>
                    </li>
                    <li>
                        <a href="{{ url('/isa-cms/logout') }}" class="log-out waves-effect waves-button waves-classic">
                            <span><i class="fa fa-sign-out m-r-xs"></i>Log out</span>
                        </a>
                    </li>
                </ul><!-- Nav -->
            </div><!-- Top Menu -->
        </div>
    </div>
</div><!-- Navbar -->
<div class="page-sidebar sidebar">
    <div class="page-sidebar-inner slimscroll">
        <div class="sidebar-header">
            <div class="sidebar-profile">
                <a href="#">
                    <div class="sidebar-profile-image">
                        <img src="{{ url('theme/backend/images/profile-menu-image.png') }}" class="img-circle img-responsive" alt="">
                    </div>
                    <div class="sidebar-profile-details">
                        <span>{{ Auth::guard('admin')->user()->name }}<br><small>{{ Auth::guard('admin')->user()->email }}</small></span>
                    </div>
                </a>
            </div>
        </div>
        <ul class="menu accordion-menu">
            <li><a href="{{ url('/isa-cms/dashboard') }}" class="waves-effect waves-button"><span class="menu-icon fa fa-home"></span><p>Dashboard</p></a></li>
            @if(Auth::guard('admin')->user()->can('orders'))
            <li><a href="{{ url('/isa-cms/orders') }}" class="waves-effect waves-button"><span class="menu-icon fa fa-shopping-cart"></span><p>Orders</p></a></li>
            @endif
            @if(Auth::guard('admin')->user()->can('customers'))
            <li><a href="{{ url('/isa-cms/customers') }}" class="waves-effect waves-button"><span class="menu-icon fa fa-users"></span><p>Customers</p></a></li>
            @endif
            @if(Auth::guard('admin')->user()->can('configuration'))
            <li class="droplink"><a href="#" class="waves-effect waves-button"><span class="menu-icon fa fa-th-large"></span><p>Catalog</p><span class="arrow"></span></a>
                <ul class="sub-menu">
                    @if(Auth::guard('admin')->user()->can('category'))<li><a href="{{ url('/isa-cms/categories') }}">Categories</a></li>@endif
                    @if(Auth::guard('admin')->user()->can('product'))<li><a href="{{ url('/isa-cms/products') }}">Products</a></li>@endif
                    @if(Auth::guard('admin')->user()->can('product'))<li><a href="{{ url('/isa-cms/attributes') }}">Attributes</a></li>@endif
                    @if(Auth::guard('admin')->user()->can('product'))<li><a href="{{ url('/isa-cms/brands') }}">Brands</a></li>@endif
                </ul>
            </li>
            @endif
            @if(Auth::guard('admin')->user()->can('configuration'))
            <li class="droplink"><a href="#" class="waves-effect waves-button"><span class="menu-icon fa fa-wrench"></span><p>Configuration</p><span class="arrow"></span></a>
                <ul class="sub-menu">
                    @if(Auth::guard('admin')->user()->can('admin'))<li><a href="{{ url('/isa-cms/users') }}">Users</a></li>@endif
                </ul>
            </li>
            @endif
        </ul>
    </div><!-- Page Sidebar Inner -->
</div><!-- Page Sidebar -->