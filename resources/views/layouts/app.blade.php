<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', auth()->user()->store_name ?? 'لوحة التحكم')</title>
    
    <!-- Google Font: Tajawal -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Tajawal:wght@300;400;500;700&display=swap">
    <!-- Font Awesome -->
    <!--<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-u0y+9j5xFjP3Lo4bix5Kz8N0Oz8LQsvrwb0zWn3ENBN6heOyD0u5D4b4OZlKmwReXfwD3D7jzRj2PdvX2cC2Ww==" crossorigin="anonymous" referrerpolicy="no-referrer" />-->
    <!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <!-- Bootstrap 4 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <!-- AdminLTE CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
    <!-- Custom switch form -->
    <link rel="stylesheet" href="{{ asset('public/css/custom-switch.css') }}">
    <style>
        body {
            font-family: 'Tajawal', sans-serif;
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            min-height: 100vh;
        }
        
        .sidebar-dark-primary {
            background: linear-gradient(180deg, #1a252f 0%, #2c3b41 100%);
            width: 250px;
            box-shadow: 2px 0 10px rgba(0,0,0,0.1);
            border-left: 3px solid #007bff;
        }
        
        .nav-link {
            font-size: 1.1rem;
            padding: 0.75rem 1.5rem;
            transition: all 0.3s ease;
            text-align: right;
            white-space: normal;
            border-radius: 8px;
            margin: 2px 8px;
            position: relative;
            overflow: hidden;
        }
        
        .nav-link::before {
            content: '';
            position: absolute;
            top: 0;
            right: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.1), transparent);
            transition: right 0.5s;
        }
        
        .nav-link:hover::before {
            right: 100%;
        }
        
        .nav-link:hover {
            background: linear-gradient(45deg, #007bff, #0056b3);
            color: #fff !important;
            transform: translateX(-5px);
            box-shadow: 0 4px 15px rgba(0,123,255,0.3);
        }
        
        .nav-link.active {
            background: linear-gradient(45deg, #28a745, #20c997);
            color: #fff !important;
            box-shadow: 0 4px 15px rgba(40,167,69,0.3);
        }
        
        .nav-icon {
            margin-left: 0.5rem;
            margin-right: 0;
            font-size: 1.2rem;
            transition: transform 0.3s ease;
        }
        
        .nav-link:hover .nav-icon {
            transform: scale(1.1);
        }
        
        .brand-link {
            background: linear-gradient(135deg, #15202b, #1a252f);
            border-bottom: 2px solid #007bff;
            padding: 1rem 0;
            text-align: center;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        
        .brand-text {
            color: #fff !important;
            font-size: 1.3rem;
            text-shadow: 0 2px 4px rgba(0,0,0,0.3);
        }
        
        .navbar-white {
            background: linear-gradient(135deg, #ffffff, #f8f9fa);
            border-bottom: 1px solid #dee2e6;
            padding: 0.5rem 1rem;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        
        .content-wrapper {
            margin-left: 250px;
            min-height: calc(100vh - 120px);
            background: rgba(255,255,255,0.9);
            border-radius: 15px 0 0 0;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
        }
        
        .main-footer {
            background: linear-gradient(135deg, #ffffff, #f8f9fa);
            border-top: 2px solid #007bff;
            padding: 1rem;
            text-align: center;
            position: relative;
            bottom: 0;
            width: 100%;
            box-shadow: 0 -2px 10px rgba(0,0,0,0.1);
        }
        
        .main-sidebar {
            position: fixed;
            top: 0;
            left: 0;
            height: 100%;
            z-index: 1038;
        }
        
        .content-header {
            padding: 1rem;
            background: linear-gradient(135deg, #ffffff, #f8f9fa);
            border-bottom: 1px solid #dee2e6;
        }
        
        /* تحسين شريط التنقل العلوي */
        .navbar-nav .nav-item .nav-link {
            color: #495057 !important;
            font-weight: 500;
            transition: all 0.3s ease;
            border-radius: 20px;
            padding: 8px 16px;
            margin: 0 4px;
        }
        
        .navbar-nav .nav-item .nav-link:hover {
            background-color: #007bff;
            color: #fff !important;
            transform: translateY(-2px);
        }
        
        /* تحسين أيقونة الطلبات */
        .navbar-nav .nav-item .nav-link i.fa-shopping-cart {
            font-size: 1.2rem;
            margin-left: 5px;
        }
        
        .badge-danger {
            background: linear-gradient(45deg, #dc3545, #c82333);
            border-radius: 50%;
            padding: 4px 8px;
            font-size: 0.75rem;
            position: absolute;
            top: -5px;
            left: -5px;
            box-shadow: 0 2px 4px rgba(220,53,69,0.3);
        }
        
        /* تحسين الأزرار */
        .btn {
            border-radius: 25px;
            font-weight: 500;
            transition: all 0.3s ease;
            padding: 8px 20px;
        }
        
        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(0,0,0,0.2);
        }
        
        .text-danger {
            background: linear-gradient(45deg, #dc3545, #c82333);
            color: #fff !important;
            border: none;
        }
        
        .text-danger:hover {
            background: linear-gradient(45deg, #c82333, #a71e2a);
        }
        
        /* Badge للإشعارات */
        .badge.bg-warning {
            background: linear-gradient(45deg, #ffc107, #e0a800) !important;
            color: #212529 !important;
            border-radius: 12px;
            padding: 4px 8px;
            margin-right: 5px;
            font-weight: bold;
        }
        
        /* تأثيرات التمرير */
        .nav-pills .nav-link {
            border-radius: 10px;
        }
        
        .nav-sidebar .nav-item {
            margin-bottom: 3px;
        }
        
        /* تحسين الظلال والحدود */
        .elevation-4 {
            box-shadow: 0 4px 20px rgba(0,0,0,0.15) !important;
        }
        
        /* تحسين التمرير السلس */
        * {
            scroll-behavior: smooth;
        }
        
        /* تأثير عند التحميل */
        .nav-item {
            animation: slideInRight 0.3s ease-out;
        }
        
        
        @keyframes slideInRight {
            from {
                opacity: 0;
                transform: translateX(30px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }
       
    
    /* إصلاح مشكلة العرض على الشاشات الصغيرة */
    @media (max-width: 576px) {
        .modal-dialog {
            margin: 0.5rem;
        }
    }
        /* تأخير الرسوم المتحركة للعناصر */
        .nav-item:nth-child(1) { animation-delay: 0.1s; }
        .nav-item:nth-child(2) { animation-delay: 0.2s; }
        .nav-item:nth-child(3) { animation-delay: 0.3s; }
        .nav-item:nth-child(4) { animation-delay: 0.4s; }
        .nav-item:nth-child(5) { animation-delay: 0.5s; }
        .nav-item:nth-child(6) { animation-delay: 0.6s; }
        .nav-item:nth-child(7) { animation-delay: 0.7s; }
        .nav-item:nth-child(8) { animation-delay: 0.8s; }
        
        /* إصلاح مشكلة أيقونة عربة التسوق */
        .fa-shopping-cart::before {
            content: "\f07a";
            font-family: "Font Awesome 6 Free";
            font-weight: 900;
        }
        .nav.nav-pills.nav-sidebar.flex-column {
    padding: 0 !important;
}
.main-header.navbar.navbar-expand.navbar-white.navbar-light {
        direction: ltr !important;
    }
    </style>
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">
    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
            </li>
            <li class="nav-item d-none d-sm-inline-block">
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
                <a href="#" class="btn text-danger" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="fas fa-sign-out-alt"></i> تسجيل الخروج
                </a>
            </li>
        </ul>
        <ul class="navbar-nav ml-auto">
            @if(auth()->user()->role === 'admin')
            <li class="nav-item dropdown mr-5">
                <a href="{{route('orders.index')}}" class="nav-link">
                    <i class="fas fa-shopping-cart" style="font-size: 18px; margin-left: 5px;"></i>
                    <span class="badge badge-danger" style="position: absolute; top: 8px; left: 8px; font-size: 11px; min-width: 18px; height: 18px; line-height: 16px; border-radius: 9px;">
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
            <span class="brand-text font-weight-light">
                <i class="fas fa-store"></i>
                <b>{{ \App\Models\Setting::where('user_id', auth()->id())->where('key', 'name')->value('value') }}</b>
            </span>
        </a>
        
        <!-- Sidebar -->
        <div class="sidebar">
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                    @if(auth()->user()->role === 'admin')
                    <li class="nav-item">
                        <a href="{{ route('dashboard') }}" class="nav-link {{ (Route::is('dashboard')) ? 'active' : '' }}">
                            <i class="nav-icon fas fa-home"></i>
                            <p>الرئيسية</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{route('categories.index')}}" class="nav-link {{ (Route::is('categories.*')) ? 'active' : ''}}">
                            <i class="nav-icon fas fa-layer-group"></i>
                            <p>الفئات</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{route('products.index')}}" class="nav-link {{ (Route::is('products.*')) ? 'active' : ''}}">
                            <i class="nav-icon fas fa-utensils"></i>
                            <p>المنتجات</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{route('sliders.index')}}" class="nav-link {{ (Route::is('sliders.*')) ? 'active' : ''}}">
                            <i class="nav-icon fas fa-images"></i>
                            <p>البانرات</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{route('orders.index')}}" class="nav-link {{ (Route::is('orders.*')) ? 'active' : ''}}">
                            <i class="nav-icon fas fa-shopping-cart"></i>
                            <p>الطلبات</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{route('settings.index')}}" class="nav-link {{ (Route::is('settings.*')) ? 'active' : ''}}">
                            <i class="nav-icon fas fa-cog"></i>
                            <p>الإعدادات</p>
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
                            <p>إدارة الإدمن</p>
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
        </div>
    </aside>
    
    <!-- Content Wrapper -->
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
            </div>
        </section>
        <section class="content">
            @yield('main-content')
        </section>
    </div>
    
    <!-- Footer -->
    <footer class="main-footer">
        <strong>
            <i class="fas fa-heart text-danger"></i>
            لوحة التحكم &copy; {{ date('Y') }}
            <i class="fas fa-code text-primary"></i>
        </strong>
    </footer>
    
    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark"></aside>
</div>

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Bootstrap 4 JS -->
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.min.js"></script>
<!-- AdminLTE JS -->
<script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/resumablejs@1.1.0/resumable.min.js"></script>

@include('sweetalert::alert', ['cdn' => "https://cdn.jsdelivr.net/npm/sweetalert2@9"])

@php
    $role = auth()->user()->role;
    $redirectUrl = $role === 'super_admin' ? route('admins.index') : route('dashboard');
@endphp

<script>
    document.addEventListener("DOMContentLoaded", function () {
        // Redirect based on user role after login
        if (window.location.pathname === '/login' || window.location.pathname === '/') {
            window.location.href = '{{ $redirectUrl }}';
        }
        
        // إضافة تأثير للروابط النشطة
        const navLinks = document.querySelectorAll('.nav-sidebar .nav-link');
        navLinks.forEach(link => {
            link.addEventListener('click', function() {
                // إزالة الفئة النشطة من جميع الروابط
                navLinks.forEach(l => l.classList.remove('active'));
                // إضافة الفئة النشطة للرابط الحالي
                this.classList.add('active');
            });
        });
    });
</script>
</body>
</html>