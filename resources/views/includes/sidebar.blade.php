<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center"
        href="{{ route('admin.dashboard.index') }}">
        <div class="sidebar-brand-icon">
            <img class=" rounded-circle" width="50px" height="50px" src="{{asset('assets/img/chackra.jpg')}}" alt="">
        </div>
        <div class="sidebar-brand-text" style=" font-size: 13px;">ADMIN DASHBOARD</div>
    </a>
    <div class="sidebar-heading mb-5">
        PT. Chakra Gahana Gemilang
    </div>
    <!-- Divider -->
    <hr class="sidebar-divider ">
    <div class="sidebar-heading">
        Data Analitik
    </div>
    <!-- Nav Item - Dashboard -->
    <li class="nav-item {{ Request::is('admin/dashboard*') ? ' active' : '' }}">
        <a class="nav-link" href="{{ route('admin.dashboard.index') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>ANALYTICAL</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Master
    </div>

    <!-- Nav Item - Pages Collapse Menu -->
    <li
        class="nav-item {{ Request::is('admin/category*') ? ' active' : '' }} {{ Request::is('admin/product*') ? ' active' : '' }}">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true"
            aria-controls="collapseTwo">
            <i class="fa fa-shopping-bag"></i>
            <span>DATA MASTER</span>
        </a>
        <div id="collapseTwo"
            class="collapse {{ Request::is('admin/category*') ? ' show' : '' }} {{ Request::is('admin/product*') ? ' show' : '' }}"
            aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Master Product</h6>
                <a class="collapse-item {{ Request::is('admin/category*') ? ' active' : '' }}"
                    href="{{ route('admin.category.index') }}">KATEGORI</a>
                <a class="collapse-item {{ Request::is('admin/product*') ? ' active' : '' }}"
                    href="{{ route('admin.product.index') }}">PRODUK</a>
                <a class="collapse-item {{ Request::is('admin/gallery*') ? ' active' : '' }}"
                    href="{{ route('admin.gallery.index') }}"> GALLERY PRODUK</a>
            </div>
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Tambah Slider</h6>
                <a class="collapse-item text-uppercase {{ Request::is('admin/slider*') ? ' active' : '' }}"
                    href="{{ route('admin.slider.index') }}">Slider-Banner</a>
            </div>
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Tambah Admin</h6>
                <a class="collapse-item text-uppercase {{ Request::is('admin/user*') ? ' active' : '' }}"
                    href="{{ route('admin.user.index') }}">Data Admin</a>
            </div>
        </div>
    </li>
    <hr class="sidebar-divider">

    <div class="sidebar-heading">
        Orders
    </div>

    <li class="nav-item {{ Request::is('admin/order*') ? ' active' : '' }}">
        <a class="nav-link" href="{{ route('admin.order.index') }}">
            <i class="fas fa-shopping-cart"></i>
            <span>DATA ORDERS</span></a>
    </li>
    <hr class="sidebar-divider">

    <div class="sidebar-heading">
        customers
    </div>
    <li class="nav-item {{ Request::is('admin/customer*') ? ' active' : '' }}">
        <a class="nav-link" href="{{ route('admin.customer.index') }}">
            <i class="fas fa-users"></i>
            <span>DATA CUSTOMERS</span></a>
    </li>
    <hr class="sidebar-divider">


    <div class="sidebar-heading">
        Keamanan
    </div>
    <li class="nav-item {{ Request::is('admin/profile*') ? ' active' : '' }}">
        <a class="nav-link" href="{{ route('admin.profile.index') }}">
            <i class="fas fa-user-circle"></i>
            <span>SCURITY</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>
<!-- End of Sidebar -->
