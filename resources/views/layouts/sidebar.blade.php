<aside id="custom-sidebar"
    class="fixed top-0 right-0 h-screen w-64 bg-[#0a0a0a] border-l border-slate-700 z-50 transform translate-x-full lg:translate-x-0 overflow-y-auto">
    <!-- Brand -->
    <div
        class="h-20 flex items-center justify-center border-b border-slate-700 bg-[#0a0a0a]/50 backdrop-blur-sm sticky top-0 z-10 px-4">
        <a href="{{ env('WEB_URL') }}"
            class="flex items-center gap-3 text-white hover:text-blue-400 transition w-full">

            @php
                $ownerId = \App\Services\StoreService::getStoreOwnerId();
                $storeUser = $ownerId ? \App\Models\User::find($ownerId) : null;
            @endphp

            @if ($storeUser && $storeUser->logo_url)
                <img src="{{ $storeUser->logo_url }}"
                    class="w-10 h-10 rounded-full object-cover border border-slate-600 shadow-sm" alt="Store Logo">
            @else
                <div
                    class="w-10 h-10 rounded-full bg-blue-600 flex items-center justify-center text-white font-bold border border-blue-400 shrink-0">
                    <i class="fas fa-store"></i>
                </div>
            @endif

            <div class="flex flex-col overflow-hidden">
                <span class="font-bold text-base truncate leading-tight">
                    {{ $storeUser->store_name ?? ($storeUser->name ?? 'لوحة التحكم') }}
                </span>
                @if ($storeUser && $storeUser->store_name)
                    <span class="text-[10px] text-slate-400 truncate">نظام الإدارة</span>
                @endif
            </div>
        </a>
    </div>

    <!-- Sidebar Menu -->
    <nav class="p-4 space-y-1">
        @php
            $user = auth()->user();
            $role = $user->role ?? null;

            $subscriptionExpired = auth()->check()
                && $role !== 'super_admin'
                && method_exists($user, 'hasActiveSubscription')
                && !$user->hasActiveSubscription();

            // لو عندك Layout مستقل للكاشير/اليوزر، خليه فاضي كما كان
            if ($role === 'user' || $role === 'cashier') {
                $menuItems = [];
            } else {
                $menuItems = config('navigation.' . $role, []);
            }
        @endphp

        @foreach ($menuItems as $item)
            @php
                $isDropdown = isset($item['type']) && $item['type'] === 'dropdown';

                $itemPermission = $item['permission'] ?? null;
                $canSeeItem = empty($itemPermission) || $role === 'super_admin' || $user->hasPackagePermission($itemPermission);

                $isActive = false;
                foreach ($item['active_routes'] ?? [] as $routePattern) {
                    if (fnmatch($routePattern, Route::currentRouteName()) || request()->routeIs($routePattern)) {
                        $isActive = true;
                        break;
                    }
                }

                $visibleChildren = collect($item['children'] ?? [])->filter(function ($child) use ($user, $role) {
                    $childPermission = $child['permission'] ?? null;
                    return empty($childPermission) || $role === 'super_admin' || $user->hasPackagePermission($childPermission);
                });

                if (!$isActive && $isDropdown) {
                    foreach (($item['children'] ?? []) as $child) {
                        foreach (($child['active_routes'] ?? []) as $childRoutePattern) {
                            if (fnmatch($childRoutePattern, Route::currentRouteName()) || request()->routeIs($childRoutePattern)) {
                                $isActive = true;
                                break 2;
                            }
                        }
                    }
                }

                // لو الاشتراك منتهي: أظهر كل العناصر لكن مقفولة
                // لو الاشتراك نشط: أظهر فقط العناصر المسموح بها
                $showItem = $subscriptionExpired
                    ? true
                    : ($isDropdown ? ($canSeeItem || $visibleChildren->isNotEmpty()) : $canSeeItem);

                $isOpen = $isActive || request('open') == str_replace('-menu', '', $item['id'] ?? '');
            @endphp

            @if ($showItem)
                @if (isset($item['type']) && $item['type'] === 'header')
                    <div class="px-4 mt-6 mb-2 text-xs font-bold text-gray-400 uppercase tracking-wider">
                        {{ $item['title'] }}
                    </div>
                @elseif ($isDropdown)
                    <div x-data="{ open: {{ $isOpen ? 'true' : 'false' }} }">
                        <button
                            @if (!$subscriptionExpired) onclick="toggleSubmenu('{{ $item['id'] }}', this)" @endif
                            class="nav-link-custom w-full flex justify-between group {{ $isOpen ? 'open' : '' }} {{ $subscriptionExpired ? 'disabled-menu' : '' }}">
                            <div class="flex items-center">
                                <i class="{{ $item['icon'] }} w-6 text-center ml-2"></i>
                                <span>{{ $item['title'] }}</span>

                                @if ($subscriptionExpired)
                                    <i class="fas fa-lock text-yellow-400 text-xs mr-2"></i>
                                @endif
                            </div>

                            <i
                                class="fas fa-chevron-left text-xs transition-transform transform {{ $isOpen ? '-rotate-90' : '' }}"></i>
                        </button>

                        <div id="{{ $item['id'] }}"
                            class="{{ $isOpen ? '' : 'hidden' }} bg-black pr-6 space-y-1 mt-1">
                            @foreach (($subscriptionExpired ? collect($item['children'] ?? []) : $visibleChildren) as $child)
                                @php
                                    $isChildActive = false;
                                    foreach ($child['active_routes'] ?? [] as $childRoutePattern) {
                                        if (fnmatch($childRoutePattern, Route::currentRouteName()) || request()->routeIs($childRoutePattern)) {
                                            $isChildActive = true;
                                            break;
                                        }
                                    }
                                @endphp

                                <a href="{{ $subscriptionExpired ? 'javascript:void(0)' : route($child['route']) }}"
                                    class="nav-link-custom text-sm rounded-lg {{ $subscriptionExpired
                                        ? 'disabled-menu text-gray-500 bg-white/5'
                                        : ($isChildActive
                                            ? 'bg-white text-black font-bold'
                                            : 'text-gray-400 hover:text-white hover:bg-white/10') }}">
                                    <i class="{{ $child['icon'] }} text-[10px] ml-2"></i>
                                    {{ $child['title'] }}

                                    @if ($subscriptionExpired)
                                        <i class="fas fa-lock text-yellow-400 text-[10px] mr-2"></i>
                                    @endif
                                </a>
                            @endforeach
                        </div>
                    </div>
                @else
                    @php
                        $singleActive = false;
                        foreach ($item['active_routes'] ?? [] as $routePattern) {
                            if (fnmatch($routePattern, Route::currentRouteName()) || request()->routeIs($routePattern)) {
                                $singleActive = true;
                                break;
                            }
                        }
                    @endphp

                    @if (isset($item['route']))
                        <a href="{{ $subscriptionExpired ? 'javascript:void(0)' : route($item['route']) }}"
                            class="nav-link-custom rounded-xl {{ $subscriptionExpired
                                ? 'disabled-menu text-gray-500 bg-white/5'
                                : ($singleActive
                                    ? 'bg-white text-black font-bold'
                                    : 'text-gray-300 hover:bg-white/10 hover:text-white') }} {{ isset($item['badge']) ? 'flex justify-between' : '' }}">

                            @if (isset($item['badge']))
                                <div class="flex items-center">
                                    <i class="{{ $item['icon'] }} w-6 text-center ml-2"></i>
                                    <span>{{ $item['title'] }}</span>

                                    @if ($subscriptionExpired)
                                        <i class="fas fa-lock text-yellow-400 text-xs mr-2"></i>
                                    @endif
                                </div>

                                @if ($item['badge']['type'] === 'subscription_pending' && isset($pendingSubscriptionsCount) && $pendingSubscriptionsCount > 0)
                                    <span
                                        class="{{ $item['badge']['class'] }} text-xs font-bold px-2 py-0.5 rounded-full">
                                        {{ $pendingSubscriptionsCount }}
                                    </span>
                                @endif
                            @else
                                <div class="flex items-center">
                                    <i class="{{ $item['icon'] }} w-6 text-center ml-2"></i>
                                    <span>{{ $item['title'] }}</span>

                                    @if ($subscriptionExpired)
                                        <i class="fas fa-lock text-yellow-400 text-xs mr-2"></i>
                                    @endif
                                </div>
                            @endif
                        </a>
                    @endif
                @endif
            @endif
        @endforeach
    </nav>
</aside>

<style>
    .disabled-menu {
        pointer-events: none;
        opacity: 0.55;
        cursor: not-allowed;
        filter: grayscale(20%);
    }
</style>