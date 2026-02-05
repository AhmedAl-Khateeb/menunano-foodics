<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', auth()->user()->store_name ?? 'لوحة التحكم')</title>

    <!-- Google Font: Tajawal -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Tajawal:wght@300;400;500;700;800;900&display=swap">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    
    <!-- Bootstrap 4 CSS (Required for Admin Pages) -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <!-- AdminLTE CSS (Only for components, Sidebar overridden) -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
    <!-- Custom switch form -->
    <link rel="stylesheet" href="{{ asset('css/custom-switch.css') }}">

    <!-- Vite Assets (Tailwind & JS) -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body { font-family: 'Tajawal', sans-serif; }
        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
        
        /* Disable Tailwind Preflight reset for borders to keep Bootstrap happy */
        *, ::before, ::after {
            border-width: 0;
            border-style: solid;
            border-color: #e5e7eb;
        }

        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }
        ::-webkit-scrollbar-track {
            background: #f1f1f1; 
        }
        ::-webkit-scrollbar-thumb {
            background: #c1c1c1; 
            border-radius: 4px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #a8a8a8; 
        }

        /* Navbar Tweaks for Bootstrap content below */
        .content-wrapper {
            background-color: #f4f6f9;
        }
        
        /* Alpine cloak */
        [x-cloak] { display: none !important; }
    </style>

    @livewireStyles
</head>

<body class="bg-gray-100 fixed inset-0 w-full h-full overflow-hidden flex flex-col font-sans antialiased" 
      x-data="{ 
          sidebarOpen: window.innerWidth >= 900 && {{ in_array(auth()->user()->role, ['admin', 'super_admin', 'supper_admin']) ? 'true' : 'false' }},
          isMobile: window.innerWidth < 1024
      }" 
      @resize.window="isMobile = window.innerWidth < 1024">
    
    <!-- Navbar -->
    <nav class="bg-gray-900 text-white shadow-md h-[50px] flex items-center px-4 justify-between shrink-0 sticky top-0 z-[60]">
        <!-- Left: Brand & Sidebar Toggle -->
        <div class="flex items-center gap-3">
             <!-- Hamburger Menu -->
            <button @click="sidebarOpen = !sidebarOpen" 
                    class="p-2 rounded-lg bg-gray-800 hover:bg-gray-700 text-white transition-all focus:outline-none">
                <i class="fas fa-bars text-lg"></i>
            </button>
            
            <div class="flex items-center gap-2">
                @if(auth()->user()->role === 'admin' && auth()->user()->logo_url)
                     <img src="{{ auth()->user()->logo_url }}" class="w-8 h-8 rounded-full object-cover border border-gray-600" alt="Logo">
                @else
                    <i class="fas fa-building text-blue-400 text-xl"></i>
                @endif
                <span class="font-bold text-lg tracking-wider hidden sm:inline">{{ auth()->user()->store_name ?? (auth()->user()->role === 'super_admin' ? 'الإدارة العليا' : 'لوحة التحكم') }}</span>
            </div>
        </div>

        <!-- Right: Actions -->
        <div class="flex items-center gap-3">
            @if (session('impersonated_by'))
                <a href="{{ route('impersonate.leave') }}" 
                   class="bg-red-500 hover:bg-red-600 text-white text-xs font-bold px-3 py-1.5 rounded-full flex items-center gap-1 transition-colors shadow-sm">
                    <i class="fas fa-sign-out-alt"></i> إنهاء الدخول
                </a>
            @endif

            <a href="{{ url('orders') }}" class="relative w-9 h-9 rounded-full bg-gray-800 text-white flex items-center justify-center hover:bg-gray-700 transition-colors">
                <i class="fas fa-bell"></i>
                @php
                    $pendingOrdersCount = \App\Models\Order::where('user_id', auth()->id())
                                            ->where('status', 'pending')
                                            ->count();
                @endphp
                @if($pendingOrdersCount > 0)
                    <span class="absolute -top-1 -right-1 bg-red-600 text-white text-[10px] font-bold px-1.5 py-0.5 rounded-full border-2 border-gray-900 leading-none">
                        {{ $pendingOrdersCount }}
                    </span>
                @endif
            </a>

            <div x-data="{ open: false }" class="relative">
                <button @click="open = !open" 
                        class="w-9 h-9 rounded-full bg-gradient-to-br from-blue-500 to-indigo-600 text-white flex items-center justify-center font-bold text-sm shadow-md hover:shadow-lg transition-all transform hover:scale-105 border-2 border-gray-800 focus:outline-none focus:ring-2 focus:ring-blue-400">
                    @php
                        $displayName = auth()->user()->store_name ?: auth()->user()->name ?: 'U';
                    @endphp
                    {{ mb_strtoupper(mb_substr($displayName, 0, 1)) }}
                </button>
                
                <!-- Dropdown -->
                <div x-show="open" 
                     @click.away="open = false"
                     class="absolute left-0 top-full mt-2 w-48 bg-white rounded-xl shadow-xl py-2 z-50 text-gray-800 border border-gray-100 transform origin-top-left"
                     x-transition:enter="transition ease-out duration-100"
                     x-transition:enter-start="transform opacity-0 scale-95"
                     x-transition:enter-end="transform opacity-100 scale-100"
                     x-transition:leave="transition ease-in duration-75"
                     x-transition:leave-start="transform opacity-100 scale-100"
                     x-transition:leave-end="transform opacity-0 scale-95"
                     style="display: none;">
                    <div class="px-4 py-2 text-xs text-gray-400 font-bold border-b border-gray-50 mb-1">
                        تم تسجيل الدخول كـ <br>
                        <span class="text-blue-600 text-sm">{{ auth()->user()->name }}</span>
                    </div>
                    
                    @if(auth()->user()->role === 'admin')
                        <a href="{{ route('pos.index') }}" class="block px-4 py-2 text-sm hover:bg-gray-50 flex items-center gap-2 text-green-600 font-bold transition-colors">
                            <i class="fas fa-cash-register"></i> نقطة البيع
                        </a>
                    @endif

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="w-full text-right px-4 py-2 text-sm text-red-600 hover:bg-red-50 flex items-center gap-2 transition-colors">
                            <i class="fas fa-sign-out-alt"></i> تسجيل الخروج
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Layout Wrapper -->
    <div class="flex flex-1 overflow-hidden relative w-full h-full">
        
        <!-- Sidebar (Integrated) -->
        <aside x-show="sidebarOpen"
               x-cloak
               x-transition:enter="transition ease-in-out duration-300 transform"
               x-transition:enter-start="translate-x-full"
               x-transition:enter-end="translate-x-0"
               x-transition:leave="transition ease-in-out duration-300 transform"
               x-transition:leave-start="translate-x-0"
               x-transition:leave-end="translate-x-full"
               class="w-64 bg-black shadow-xl shrink-0 border-l border-gray-800 flex flex-col h-full">
            
            <!-- Sidebar Header -->
            <div class="bg-black text-white h-[60px] flex items-center justify-between px-4 shrink-0 border-b border-gray-800">
                <div class="flex items-center gap-3">
                    @if(auth()->user()->role === 'admin' && auth()->user()->logo_url)
                        <img src="{{ auth()->user()->logo_url }}" class="w-10 h-10 rounded-full object-cover border-2 border-blue-400 shadow-lg" alt="Logo">
                    @else
                        <div class="w-10 h-10 rounded-full bg-gradient-to-br from-blue-500 to-blue-600 flex items-center justify-center shadow-lg">
                            <i class="fas fa-store text-white text-lg"></i>
                        </div>
                    @endif
                    <div class="flex flex-col">
                        <span class="font-bold text-sm leading-tight">{{ auth()->user()->store_name ?? 'لوحة التحكم' }}</span>
                        <span class="text-xs text-gray-400">{{ auth()->user()->role === 'super_admin' ? 'مدير النظام' : 'الإدارة' }}</span>
                    </div>
                </div>
                <button @click="sidebarOpen = false" 
                        class="p-2 rounded-lg bg-gray-900 text-white hover:bg-gray-800 transition-all">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>

            <!-- Sidebar Links -->
            <div class="flex-1 overflow-y-auto no-scrollbar py-4 space-y-2 text-right">
                @php
                    $role = auth()->user()->role;
                    $menuItems = config('navigation.' . $role, []);
                @endphp

                @foreach ($menuItems as $item)
                    @if (isset($item['type']) && $item['type'] === 'dropdown')
                        @php
                            $hasActiveChild = false;
                            foreach ($item['children'] as $child) {
                                if (request()->routeIs($child['active_routes'])) {
                                    $hasActiveChild = true;
                                    break;
                                }
                            }
                        @endphp
                        <div x-data="{ openSub: {{ $hasActiveChild ? 'true' : 'false' }} }">
                             <button @click="openSub = !openSub" 
                                    class="flex items-center justify-between w-full px-4 py-3 bg-black text-white hover:bg-gray-800 font-bold transition-colors">
                                <div class="flex items-center gap-3">
                                    <i class="{{ $item['icon'] }} text-lg w-6 text-center"></i>
                                    <span>{{ $item['title'] }}</span>
                                </div>
                                <i class="fas fa-chevron-left text-xs transition-transform" :class="{ '-rotate-90': openSub }"></i>
                            </button>
                            <div x-show="openSub" class="bg-[#1a1a1a] space-y-1 mt-1 border-r-2 border-gray-700">
                                 @foreach ($item['children'] as $child)
                                    <a href="{{ route($child['route']) }}" 
                                       class="flex items-center gap-3 px-6 py-2 text-sm {{ request()->routeIs($child['active_routes']) ? 'bg-white text-black font-bold' : 'text-gray-400 hover:text-white hover:bg-gray-800' }} transition-colors">
                                        <i class="{{ $child['icon'] }} text-xs"></i>
                                        <span>{{ $child['title'] }}</span>
                                    </a>
                                 @endforeach
                            </div>
                        </div>
                    @elseif (isset($item['type']) && $item['type'] === 'header')
                         <div class="px-4 mt-4 mb-2 text-xs font-bold text-gray-500 uppercase tracking-wider">
                            {{ $item['title'] }}
                        </div>
                    @else
                        <a href="{{ route($item['route']) }}" 
                           class="flex items-center gap-3 px-4 py-3 {{ request()->routeIs($item['active_routes']) ? 'bg-white text-black' : 'text-gray-300 hover:bg-gray-800 hover:text-white' }} font-bold transition-colors">
                            <i class="{{ $item['icon'] }} text-lg w-6 text-center"></i>
                            <span>{{ $item['title'] }}</span>
                        </a>
                    @endif
                @endforeach
            </div>
        </aside>

        <!-- Main Content Area -->
        <main class="flex-1 h-full overflow-y-auto bg-gray-100 transition-all duration-300 relative">
            <div class="{{ request()->routeIs('pos.index') ? 'p-0' : 'p-4' }} min-h-full">
                @yield('main-content')
                {{ $slot ?? '' }}
            </div>
        </main>
    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.min.js"></script>
    <!-- AdminLTE JS -->
    <script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/resumablejs@1.1.0/resumable.min.js"></script>

    @include('sweetalert::alert', ['cdn' => 'https://cdn.jsdelivr.net/npm/sweetalert2@9'])
    @stack('scripts')
    @livewireScripts
</body>
</html>
