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
    <!-- Alpine.js (Commented out as Livewire 3 bundles it) -->
    {{-- <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script> --}}
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
    @livewireStyles
</head>

<body class="bg-gray-100 overflow-x-hidden">

    <!-- Mobile Overlay -->
    <div id="mobile-overlay" class="fixed inset-0 bg-black bg-opacity-50 z-40 hidden lg:hidden"
        onclick="toggleSidebar()"></div>

    <!-- Main Sidebar -->
    @include('layouts.sidebar')

    <!-- Main Content Wrapper -->
    <div id="content-wrapper" class="min-h-screen bg-gray-50 lg:mr-64 transition-all duration-300">

        <!-- Navbar -->
        <nav
            class="main-header navbar navbar-expand navbar-white navbar-light sticky top-0 z-30 shadow-sm border-b border-gray-200">
            <div
                class="container-fluid max-w-7xl mx-auto flex items-center justify-between w-full px-4 sm:px-6 lg:px-8">
                <!-- Right Side (Hamburger) -->
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <button class="p-2 rounded-md hover:bg-gray-100 focus:outline-none transition-colors"
                            onclick="toggleSidebar()">
                            <i class="fas fa-bars text-gray-600 text-xl"></i>
                        </button>
                    </li>
                </ul>

                <!-- Left Side (User & Actions) -->
                <ul class="navbar-nav flex items-center gap-3">
                    @if (session('impersonated_by'))
                        <li class="nav-item">
                            <a href="{{ route('impersonate.leave') }}"
                                class="btn btn-danger btn-sm rounded-pill px-3 shadow-md font-bold animate-pulse flex items-center gap-1">
                                <i class="fas fa-sign-out-alt"></i> خروج
                            </a>
                        </li>
                    @endif

                    @if (auth()->user()->role === 'admin')
                        <li class="nav-item relative">
                            <a href="{{ route('orders.index') }}"
                                class="p-2 text-gray-600 hover:text-blue-600 relative transition-colors">
                                <i class="fas fa-shopping-cart text-xl"></i>
                                <span
                                    class="absolute top-0 right-0 bg-red-500 text-white text-[10px] font-bold px-1.5 py-0.5 rounded-full shadow-sm">
                                    {{ \App\Models\Order::where('status', 'pending')->where('user_id', auth()->id())->count() }}
                                </span>
                            </a>
                        </li>
                    @endif

                    <!-- User Dropdown -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle flex items-center gap-2 p-1 rounded-full hover:bg-gray-50 transition-all border border-transparent hover:border-gray-200"
                            href="#" id="userDropdown" role="button" data-toggle="dropdown">
                            <div
                                class="w-9 h-9 rounded-full bg-gradient-to-br from-blue-100 to-blue-50 flex items-center justify-center text-blue-600 shadow-sm">
                                <i class="fas fa-user"></i>
                            </div>
                        </a>
                        <div class="dropdown-menu dropdown-menu-left shadow-xl border-0 rounded-xl mt-2 p-1 w-48"
                            aria-labelledby="userDropdown">
                            <div class="px-4 py-2 border-b border-gray-50 mb-1">
                                <p class="text-sm font-bold text-gray-900 mb-0">{{ auth()->user()->name }}</p>
                                <p class="text-xs text-gray-400 mb-0">{{ auth()->user()->email }}</p>
                            </div>
                            @php
                                $activeShiftForLogout = auth()->check()
                                    ? \App\Models\Shift::where('user_id', auth()->id())
                                        ->where('status', 'active')
                                        ->latest()
                                        ->first()
                                    : null;
                            @endphp

                            <form id="logout-form" action="{{ route('logout') }}" method="POST">
                                @csrf

                                <div class="modal fade" id="logoutShiftModal" tabindex="-1" role="dialog"
                                    aria-labelledby="logoutShiftModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered" role="document" dir="rtl">
                                        <div class="modal-content border-0 rounded-xl shadow-lg">

                                            <div class="modal-header bg-dark text-white">
                                                <h5 class="modal-title" id="logoutShiftModalLabel">
                                                    إنهاء الشفت وتسجيل الخروج
                                                </h5>

                                                <button type="button" class="close text-white ml-0"
                                                    data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>

                                            <div class="modal-body text-right">
                                                @if ($activeShiftForLogout)
                                                    <p class="text-muted mb-3">
                                                        من فضلك أدخل رصيد نهاية الدرج قبل تسجيل الخروج.
                                                    </p>

                                                    <label class="font-weight-bold">
                                                        رصيد نهاية الدرج <span class="text-danger">*</span>
                                                    </label>

                                                    <input type="number" step="0.5" min="0"
                                                        name="ending_cash"
                                                        class="form-control form-control-lg text-right"
                                                        placeholder="0.00" required>
                                                @else
                                                    <div class="alert alert-info mb-0">
                                                        لا يوجد شفت مفتوح حاليًا، سيتم تسجيل الخروج مباشرة.
                                                    </div>
                                                @endif
                                            </div>

                                            <div class="modal-footer justify-content-between">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                                                    إلغاء
                                                </button>

                                                <button type="submit" class="btn btn-danger">
                                                    <i class="fas fa-sign-out-alt"></i>
                                                    {{ $activeShiftForLogout ? 'إنهاء الشفت والخروج' : 'تسجيل الخروج' }}
                                                </button>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </li>
                </ul>
            </div>
        </nav>

        <!-- Page Content -->
        <div class="{{ request()->routeIs('pos.index') ? '' : 'p-4 sm:p-6 lg:p-8' }}">
            @if (!request()->routeIs('pos.index'))
                <section class="content-header mb-6">
                    <div class="container-fluid">
                        <!-- Breadcrumbs can go here -->
                    </div>
                </section>
            @endif

            @yield('main-content')
            {{ $slot ?? '' }}
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
    document.addEventListener('DOMContentLoaded', function () {
        const logoutBtn = document.getElementById('openLogoutModal');

        if (logoutBtn) {
            logoutBtn.addEventListener('click', function (e) {
                e.preventDefault();
                $('#logoutShiftModal').modal('show');
            });
        }
    });
</script>


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
    @stack('scripts')
    @livewireScripts
</body>

</html>
