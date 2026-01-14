<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>@yield('title', auth()->user()->store_name ?? 'لوحة التحكم')</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-u0y+9j5xFjP3Lo4bix5Kz8N0Oz8LQsvrwb0zWn3ENBN6heOyD0u5D4b4OZlKmwReXfwD3D7jzRj2PdvX2cC2Ww==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Theme style -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

  <!-- Bootstrap 4 CSS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">

  <!-- AdminLTE CSS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
  <!--{{-- custome switch form --}}-->
  <link rel="stylesheet" href="{{ asset('public/css/custom-switch.css') }}">
</head>
<body class="hold-transition sidebar-mini">
<!-- Site wrapper -->
<div class="wrapper">

    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
        <!-- Left navbar links -->
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
            </li>
            <li class="nav-item d-none d-sm-inline-block">
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
                <a href="#" class="btn text-danger" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    Log out
                </a>
            </li>
        </ul>
        <!-- Right navbar links -->
        <ul class="navbar-nav ml-auto">
            <!-- Messages Dropdown Menu -->
            @if(auth()->user()->role === 'admin')
            <li class="nav-item dropdown mr-5">
                <a href="{{route('orders.index')}}" class="nav-link">
                    <i class="fa fa-shopping-cart"></i>
                    <span class="badge badge-danger navbar-badge">
                        {{\App\Models\Order::where('status','pending')->where('user_id', auth()->id())->count()}}
                    </span>
                </a>
            </li>
            @endif
        </ul>
    </nav>

    <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{env('WEB_URL')}}" class="brand-link text-center">
      <span class="brand-text font-weight-light ">
          <b>{{ \App\Models\Setting::where('user_id', auth()->id())
            ->where('key', 'name')
            ->value('value') }}</b>
      </span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar Menu -->
      <nav class="mt-2">
          <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            @if(auth()->user()->role === 'admin')
            <li class="nav-item">
    <a href="{{ route('dashboard') }}" class="nav-link {{ (Route::is('dashboard')) ? 'active' : '' }}">
        <i class="nav-icon fas fa-home"></i>
        <p>Home</p>
    </a>
</li>
              <li class="nav-item ">
                  <a href="{{route('categories.index')}}" class="nav-link {{ (Route::is('categories.*')) ? 'active' : ''}}">
                      <i class="nav-icon fa fa-layer-group"></i>
                      <p>
                          Categories
                      </p>
                  </a>
              </li>
              <li class="nav-item ">
                  <a href="{{route('products.index')}}" class="nav-link {{ (Route::is('products.*')) ? 'active' : ''}}">
                      <i class="nav-icon fas fa-utensils"></i>
                      <p>
                          Products
                      </p>
                  </a>
              </li>
              <li class="nav-item ">
                  <a href="{{route('sliders.index')}}" class="nav-link {{ (Route::is('sliders.*')) ? 'active' : ''}}">
                      <i class="nav-icon fa fa-images"></i>
                      <p>
                          Banners
                      </p>
                  </a>
              </li>
              <li class="nav-item ">
                  <a href="{{route('orders.index')}}" class="nav-link {{ (Route::is('orders.*')) ? 'active' : ''}}">
                      <i class="nav-icon fa fa-shopping-cart"></i>
                      <p>
                          Orders
                      </p>
                  </a>
              </li>
              <li class="nav-item ">
                  <a href="{{route('settings.index')}}" class="nav-link {{ (Route::is('settings.*')) ? 'active' : ''}}">
                      <i class="nav-icon fa fa-cog"></i>
                      <p>
                          Settings
                      </p>
                  </a>
              </li>
              @endif
              @if(auth()->check() && auth()->user()->role === 'super_admin')
    <li class="nav-item">
        <a href="{{ route('business_settings.index') }}" class="nav-link">
            <i class="nav-icon fas fa-cogs"></i>
            <p>إعدادات النشاط</p>
        </a>
    </li>
    <li class="nav-item">
        <a href="{{ route('admins.index') }}" class="nav-link">
            <i class="nav-icon fas fa-users"></i>
            <p>إدارة الادمن</p>
        </a>
    </li>
    <li class="nav-item">
        <a href="{{ route('terms.index') }}" class="nav-link">
            <i class="nav-icon fas fa-file-contract"></i>
            <p>الشروط والأحكام</p>
        </a>
    </li>
    <li class="nav-item">
        <a href="{{ route('packages.index') }}" class="nav-link">
            <i class="nav-icon fas fa-box"></i>
            <p>إدارة الباقات</p>
        </a>
    </li>
    <li class="nav-item">
        <a href="{{ route('payment-methods.index') }}" class="nav-link">
            <i class="nav-icon fas fa-credit-card"></i>
            <p>وسائل الدفع</p>
        </a>
    </li>
    <li class="nav-item">
    <a href="{{ route('subscriptions.index') }}" class="nav-link">
        <i class="nav-icon fas fa-file-invoice-dollar"></i>
        <p>
            إدارة الطلبات
            @if($pendingSubscriptionsCount > 0)
                <span class="badge bg-warning text-dark">{{ $pendingSubscriptionsCount }}</span>
            @endif
        </p>
    </a>
</li>
<li class="nav-item">
    <a href="{{ route('sections.index') }}" class="nav-link">
        <i class="nav-icon fas fa-list-alt"></i>
        <p>الأقسام</p>
    </a>
</li>
@endif
          </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
      <section class="content-header">
          <div class="container-fluid">

          </div>
          <!-- /.container-fluid -->
      </section>
    <!-- Main content -->
    <section class="content">
      @yield('main-content')
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <footer class="main-footer">

  </footer>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
{{-- <script src="{{asset('plugins/jquery/jquery.min.js')}}"></script> --}}
<!-- Bootstrap 4 -->
{{-- <script src="{{asset('plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script> --}}
<!-- AdminLTE App -->
{{-- <script src="{{asset('dist/js/adminlte.min.js')}}"></script> --}}
<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Bootstrap 4 JS -->
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.min.js"></script>

<!-- AdminLTE JS -->
<script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>

{{-- <script>
    document.addEventListener("DOMContentLoaded", function () {
        document.getElementById('languageSelector').addEventListener('change', function () {
            const url = this.value;
            if (url) {
                window.location.href = url;
            }
        });
    });
</script> --}}
<script src="https://cdn.jsdelivr.net/npm/resumablejs@1.1.0/resumable.min.js"></script>

@include('sweetalert::alert', ['cdn' => "https://cdn.jsdelivr.net/npm/sweetalert2@9"])
</body>
</html>




