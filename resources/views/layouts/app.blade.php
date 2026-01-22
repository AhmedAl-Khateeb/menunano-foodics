<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', auth()->user()->store_name ?? 'لوحة التحكم')</title>

    <!-- Google Font: Tajawal -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Tajawal:wght@300;400;500;700&display=swap">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <!-- Bootstrap 4 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <!-- AdminLTE CSS (Only for components, Sidebar overridden) -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
    <!-- Custom switch form -->
    <link rel="stylesheet" href="{{ asset('css/custom-switch.css') }}">

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            corePlugins: {
                preflight: false,
            },
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Tajawal', 'sans-serif'],
                    },
                    colors: {
                        primary: '#007bff',
                        secondary: '#6c757d',
                        dark: '#343a40',
                        sidebar: {
                            DEFAULT: '#1e293b',
                            dark: '#0f172a',
                        }
                    }
                }
            }
        }
    </script>

    <style>
        body {
            font-family: 'Tajawal', sans-serif;
            background-color: #f3f4f6;
            margin: 0;
            direction: rtl;
        }

        /* Custom Sidebar Styling */
        #custom-sidebar {
            transition: transform 0.3s ease-in-out;
            background: linear-gradient(180deg, #1e293b 0%, #0f172a 100%);
            box-shadow: 4px 0 24px rgba(0, 0, 0, 0.1);
        }

        /* Nav Link Styling */
        .nav-link-custom {
            display: flex;
            align-items: center;
            padding: 0.75rem 1rem;
            color: #cbd5e1;
            transition: all 0.2s;
            border-radius: 0.5rem;
            margin-bottom: 0.25rem;
            text-decoration: none;
            background: transparent;
            /* Reset button background */
            width: 100%;
            /* Ensure buttons take full width */
            border: none;
            /* Reset button border */
            outline: none;
            cursor: pointer;
        }

        .nav-link-custom:hover {
            background-color: rgba(255, 255, 255, 0.05);
            color: #fff;
            text-decoration: none;
            transform: translateX(-2px);
        }

        .nav-link-custom.active {
            background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
            color: white;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }

        /* Content Wrapper Transition */
        #content-wrapper {
            transition: margin-right 0.3s ease-in-out;
        }

        /* Mobile Overlay */
        #mobile-overlay {
            transition: opacity 0.3s ease-in-out, visibility 0.3s ease-in-out;
        }

        /* Disable Tailwind Preflight reset for borders to keep Bootstrap happy */
        *,
        ::before,
        ::after {
            border-width: 0;
            border-style: solid;
            border-color: #e5e7eb;
        }

        /* Navbar Tweaks */
        .main-header {
            margin-right: 0;
            /* Managed by JS/Tailwind now */
            border-bottom: 1px solid #e2e8f0;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(8px);
        }
    </style>
</head>

<body class="bg-gray-100 overflow-x-hidden">

    <!-- Mobile Overlay -->
    <div id="mobile-overlay" class="fixed inset-0 bg-black bg-opacity-50 z-40 hidden lg:hidden"
        onclick="toggleSidebar()"></div>

    <!-- Main Sidebar -->
    <aside id="custom-sidebar"
        class="fixed top-0 right-0 h-screen w-64 bg-slate-900 border-l border-slate-700 z-50 transform translate-x-full lg:translate-x-0 overflow-y-auto">
        <!-- Brand -->
        <div
            class="h-16 flex items-center justify-center border-b border-slate-700 bg-slate-900/50 backdrop-blur-sm sticky top-0 z-10">
            <a href="{{ env('WEB_URL') }}"
                class="flex items-center space-x-2 space-x-reverse text-white hover:text-blue-400 transition">
                <i class="fas fa-store text-xl"></i>
                <span
                    class="font-bold text-lg mr-2">{{ \App\Models\Setting::where('user_id', auth()->id())->where('key', 'name')->value('value') ?? 'لوحة التحكم' }}</span>
            </a>
        </div>

        <!-- Sidebar Menu -->
        <nav class="p-4 space-y-1">
            @if (auth()->user()->role === 'admin')
                <a href="{{ route('dashboard') }}" class="nav-link-custom {{ Route::is('dashboard') ? 'active' : '' }}">
                    <i class="fas fa-home w-6 text-center ml-2"></i>
                    <span>الرئيسية</span>
                </a>

                <a href="{{ route('categories.index') }}"
                    class="nav-link-custom {{ Route::is('categories.*') ? 'active' : '' }}">
                    <i class="fas fa-layer-group w-6 text-center ml-2"></i>
                    <span>الفئات</span>
                </a>

                <a href="{{ route('products.index') }}"
                    class="nav-link-custom {{ Route::is('products.*') ? 'active' : '' }}">
                    <i class="fas fa-utensils w-6 text-center ml-2"></i>
                    <span>المنتجات</span>
                </a>

                <a href="{{ route('sliders.index') }}"
                    class="nav-link-custom {{ Route::is('sliders.*') ? 'active' : '' }}">
                    <i class="fas fa-images w-6 text-center ml-2"></i>
                    <span>البانرات</span>
                </a>

                @if (
                    (auth()->user()->role === 'super_admin' || auth()->user()->role === 'admin') &&
                        !request()->is('admins*') &&
                        !request()->is('super*'))
                    <!-- Multi-level Dropdown for Persons -->
                    <div x-data="{ open: {{ request('open') == 'persons' || Route::is('users.*') || Route::is('roles.*') ? 'true' : 'false' }} }">
                        <button onclick="toggleSubmenu('persons-menu', this)"
                            class="nav-link-custom w-full flex justify-between group">
                            <div class="flex items-center">
                                <i class="fas fa-users w-6 text-center ml-2"></i>
                                <span>الأشخاص</span>
                            </div>
                            <i
                                class="fas fa-chevron-left text-xs transition-transform transform group-[.open]:-rotate-90"></i>
                        </button>
                        <div id="persons-menu"
                            class="hidden pr-6 space-y-1 mt-1 {{ request('open') == 'persons' || Route::is('users.*') || Route::is('roles.*') ? '!block' : '' }}">
                            <a href="{{ route('users.index') }}"
                                class="nav-link-custom text-sm {{ Route::is('users.index') ? 'active' : '' }}">
                                <i class="far fa-circle text-[10px] ml-2"></i> المستخدمين
                            </a>
                            <a href="{{ route('roles.index') }}"
                                class="nav-link-custom text-sm {{ Route::is('roles.*') ? 'active' : '' }}">
                                <i class="far fa-circle text-[10px] ml-2"></i> الأدوار
                            </a>
                        </div>
                    </div>

                    <!-- Payment Methods -->
                    <div x-data="{ open: {{ request('open') == 'payment' || Route::is('payment-methods.*') ? 'true' : 'false' }} }">
                        <button onclick="toggleSubmenu('payment-menu', this)"
                            class="nav-link-custom w-full flex justify-between group">
                            <div class="flex items-center">
                                <i class="fas fa-wallet w-6 text-center ml-2"></i>
                                <span>الدفع</span>
                            </div>
                            <i class="fas fa-chevron-left text-xs transition-transform transform"></i>
                        </button>
                        <div id="payment-menu"
                            class="hidden pr-6 space-y-1 mt-1 {{ request('open') == 'payment' || Route::is('payment-methods.*') ? '!block' : '' }}">
                            <a href="{{ route('payment-methods.index') }}"
                                class="nav-link-custom text-sm {{ Route::is('payment-methods.index') ? 'active' : '' }}">
                                <i class="far fa-circle text-[10px] ml-2"></i> وسائل الدفع
                            </a>
                        </div>
                    </div>
                @endif

                <a href="{{ route('orders.index') }}"
                    class="nav-link-custom {{ Route::is('orders.*') ? 'active' : '' }}">
                    <i class="fas fa-shopping-cart w-6 text-center ml-2"></i>
                    <span>الطلبات</span>
                </a>

                <a href="{{ route('settings.index') }}"
                    class="nav-link-custom {{ Route::is('settings.*') ? 'active' : '' }}">
                    <i class="fas fa-cog w-6 text-center ml-2"></i>
                    <span>الإعدادات</span>
                </a>
            @endif

            @if (auth()->check() && auth()->user()->role === 'super_admin')
                <div class="pt-4 pb-2">
                    <p class="px-4 text-xs font-semibold text-slate-400 uppercase tracking-wider">الإدارة العليا</p>
                </div>

                <a href="{{ route('business_settings.index') }}" class="nav-link-custom">
                    <i class="fas fa-cogs w-6 text-center ml-2"></i> إعدادات النشاط
                </a>
                <a href="{{ route('admins.index') }}" class="nav-link-custom">
                    <i class="fas fa-users w-6 text-center ml-2"></i> إدارة الإدمن
                </a>
                <a href="{{ route('terms.index') }}" class="nav-link-custom">
                    <i class="fas fa-file-contract w-6 text-center ml-2"></i> الشروط والأحكام
                </a>
                <a href="{{ route('packages.index') }}" class="nav-link-custom">
                    <i class="fas fa-box w-6 text-center ml-2"></i> إدارة الباقات
                </a>
                <a href="{{ route('payment-methods.index') }}" class="nav-link-custom">
                    <i class="fas fa-credit-card w-6 text-center ml-2"></i> وسائل الدفع
                </a>
                <a href="{{ route('subscriptions.index') }}" class="nav-link-custom flex justify-between">
                    <div class="flex items-center">
                        <i class="fas fa-file-invoice-dollar w-6 text-center ml-2"></i> إدارة الطلبات
                    </div>
                    @if ($pendingSubscriptionsCount > 0)
                        <span
                            class="bg-yellow-500 text-black text-xs font-bold px-2 py-0.5 rounded-full">{{ $pendingSubscriptionsCount }}</span>
                    @endif
                </a>
                <a href="{{ route('sections.index') }}" class="nav-link-custom">
                    <i class="fas fa-list-alt w-6 text-center ml-2"></i> الأقسام
                </a>
            @endif
        </nav>
    </aside>

    <!-- Main Content Wrapper -->
    <div id="content-wrapper" class="min-h-screen bg-gray-50 lg:mr-64 transition-all duration-300">

        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light sticky top-0 z-30 shadow-sm">
            <!-- Hamburger Button -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <button class="p-2 rounded-md hover:bg-gray-100 focus:outline-none" onclick="toggleSidebar()">
                        <i class="fas fa-bars text-gray-600 text-xl"></i>
                    </button>
                </li>
            </ul>

            <!-- Left Navbar Items -->
            <ul class="navbar-nav mr-auto flex items-center gap-2">
                @if (auth()->user()->role === 'admin')
                    <li class="nav-item relative">
                        <a href="{{ route('orders.index') }}" class="p-2 text-gray-600 hover:text-blue-600 relative">
                            <i class="fas fa-shopping-cart text-xl"></i>
                            <span
                                class="absolute top-0 right-0 bg-red-500 text-white text-[10px] font-bold px-1.5 py-0.5 rounded-full">
                                {{ \App\Models\Order::where('status', 'pending')->where('user_id', auth()->id())->count() }}
                            </span>
                        </a>
                    </li>
                @endif

                <!-- User Dropdown -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle flex items-center gap-2" href="#" id="userDropdown"
                        role="button" data-toggle="dropdown">
                        <div class="w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center text-blue-600">
                            <i class="fas fa-user"></i>
                        </div>
                    </a>
                    <div class="dropdown-menu dropdown-menu-left shadow-lg border-0 rounded-xl mt-2"
                        aria-labelledby="userDropdown">
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                        <a class="dropdown-item text-red-600 hover:bg-red-50 rounded-lg flex items-center gap-2 px-4 py-2"
                            href="#"
                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i class="fas fa-sign-out-alt"></i> تسجيل الخروج
                        </a>
                    </div>
                </li>
            </ul>
        </nav>

        <!-- Page Content -->
        <div class="p-4 sm:p-6 lg:p-8">
            <section class="content-header mb-6">
                <div class="container-fluid">
                    <!-- Breadcrumbs can go here -->
                </div>
            </section>

            @yield('main-content')
        </div>

        <!-- Footer -->
        <footer class="bg-white border-t border-gray-200 p-4 text-center text-sm text-gray-600">
            <strong>
                <i class="fas fa-heart text-red-500 mx-1"></i>
                لوحة التحكم &copy; {{ date('Y') }}
                <i class="fas fa-code text-blue-500 mx-1"></i>
            </strong>
        </footer>
    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.min.js"></script>
    <!-- AdminLTE JS (Optional components only) -->
    <script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/resumablejs@1.1.0/resumable.min.js"></script>

    @include('sweetalert::alert', ['cdn' => 'https://cdn.jsdelivr.net/npm/sweetalert2@9'])

    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('custom-sidebar');
            const overlay = document.getElementById('mobile-overlay');
            const wrapper = document.getElementById('content-wrapper');

            // Check if mobile (default translate-x-full on mobile means hidden)
            const isMobile = window.innerWidth < 1024;

            if (isMobile) {
                if (sidebar.classList.contains('translate-x-full')) {
                    // Open Sidebar
                    sidebar.classList.remove('translate-x-full');
                    overlay.classList.remove('hidden');
                } else {
                    // Close Sidebar
                    sidebar.classList.add('translate-x-full');
                    overlay.classList.add('hidden');
                }
            } else {
                // Desktop Toggle (Collapse)
                if (sidebar.classList.contains('lg:translate-x-0')) {
                    // Collapse
                    sidebar.classList.remove('lg:translate-x-0');
                    sidebar.classList.add('lg:translate-x-full'); // Hide off-screen right
                    wrapper.classList.remove('lg:mr-64'); // Remove margin
                } else {
                    // Expand
                    sidebar.classList.remove('lg:translate-x-full');
                    sidebar.classList.add('lg:translate-x-0');
                    wrapper.classList.add('lg:mr-64'); // Restore margin
                }
            }
        }

        function toggleSubmenu(id, btn) {
            const menu = document.getElementById(id);
            const icon = btn.querySelector('.fa-chevron-left');

            if (menu.classList.contains('hidden')) {
                menu.classList.remove('hidden');
                btn.classList.add('open');
                if (icon) icon.style.transform = 'rotate(-90deg)';
            } else {
                menu.classList.add('hidden');
                btn.classList.remove('open');
                if (icon) icon.style.transform = 'rotate(0deg)';
            }
        }
    </script>
</body>

</html>
