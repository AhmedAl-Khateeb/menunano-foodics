<?php

return [
    'super_admin' => [
        [
            'title' => 'إعدادات النشاط',
            'icon' => 'fas fa-cogs',
            'route' => 'business_settings.index',
            'active_routes' => ['business_settings.*'],
        ],
        [
            'title' => 'إدارة الإدمن',
            'icon' => 'fas fa-users',
            'route' => 'admins.index',
            'active_routes' => ['admins.*'],
        ],
        [
            'title' => 'الشروط والأحكام',
            'icon' => 'fas fa-file-contract',
            'route' => 'terms.index',
            'active_routes' => ['terms.*'],
        ],
        [
            'title' => 'إدارة الباقات',
            'icon' => 'fas fa-box',
            'route' => 'packages.index',
            'active_routes' => ['packages.*'],
        ],
        [
            'title' => 'وسائل الدفع',
            'icon' => 'fas fa-credit-card',
            'route' => 'payment-methods.index',
            'active_routes' => ['payment-methods.*'],
        ],
        [
            'title' => 'إدارة الطلبات',
            'icon' => 'fas fa-file-invoice-dollar',
            'route' => 'subscriptions.index',
            'active_routes' => ['subscriptions.*'],
            'badge' => [
                'type' => 'subscription_pending', // Special handler for badge logic
                'class' => 'bg-yellow-500 text-black',
            ]
        ],
        [
            'title' => 'الأقسام',
            'icon' => 'fas fa-list-alt',
            'route' => 'sections.index',
            'active_routes' => ['sections.*'],
        ],
    ],
    'admin' => [
        [
            'title' => 'الرئيسية',
            'icon' => 'fas fa-home',
            'route' => 'dashboard',
            'active_routes' => ['dashboard'],
        ],
        // E-Menu Module
        [
            'title' => 'المنيو الإلكتروني',
            'icon' => 'fas fa-tablet-alt',
            'type' => 'dropdown',
            'id' => 'emenu-menu',
            'active_routes' => ['categories.*', 'products.*', 'sliders.*', 'orders.*'],
            'children' => [
                 // Categories
                [
                    'title' => 'الفئات',
                    'icon' => 'far fa-circle',
                    'route' => 'categories.index',
                    'active_routes' => ['categories.*'],
                ],
                // Products
                [
                    'title' => 'المنتجات',
                    'icon' => 'far fa-circle',
                    'route' => 'products.index',
                    'active_routes' => ['products.index', 'products.show', 'products.store', 'products.update'],
                ],
                // Banners
                [
                    'title' => 'البنرات (Sliders)',
                    'icon' => 'far fa-circle',
                    'route' => 'sliders.index',
                    'active_routes' => ['sliders.*'],
                ],
                // Orders
                [
                    'title' => 'الطلبات',
                    'icon' => 'far fa-circle',
                    'route' => 'orders.index',
                    'active_routes' => ['orders.index', 'orders.show'],
                ],
            ]
        ],
        // Users Group
        [
            'title' => 'الأشخاص',
            'icon' => 'fas fa-users',
            'type' => 'dropdown',
            'id' => 'users-menu',
            'active_routes' => ['users.*', 'roles.*'],
            'children' => [
                [
                    'title' => 'أصحاب المتجر',
                    'icon' => 'far fa-circle',
                    'route' => 'users.store-admins',
                    'active_routes' => ['users.store-admins'],
                ],
                [
                    'title' => 'الموظفين (الكاشير)',
                    'icon' => 'far fa-circle',
                    'route' => 'users.staff',
                    'active_routes' => ['users.staff'],
                ],
                [
                    'title' => 'العملاء',
                    'icon' => 'far fa-circle',
                    'route' => 'users.customers',
                    'active_routes' => ['users.customers'],
                ],
                [
                    'title' => 'الأدوار والصلاحيات',
                    'icon' => 'far fa-circle',
                    'route' => 'roles.index',
                    'active_routes' => ['roles.*'],
                ],
            ]
        ],
        // Inventory & Items Module
        [
            'title' => 'الأصناف والمخزون',
            'icon' => 'fas fa-boxes',
            'type' => 'dropdown',
            'id' => 'inventory-menu',
            'active_routes' => ['inventory.*'],
            'children' => [
                [
                    'title' => 'المنتجات الجاهزة',
                    'icon' => 'far fa-circle',
                    'route' => 'inventory.ready.index',
                    'active_routes' => ['inventory.ready.*'],
                ],
                [
                    'title' => 'المنتجات المركبة',
                    'icon' => 'far fa-circle',
                    'route' => 'inventory.composite.index',
                    'active_routes' => ['inventory.composite.*'],
                ],
                [
                    'title' => 'المواد الخام',
                    'icon' => 'far fa-circle',
                    'route' => 'inventory.raw.index',
                    'active_routes' => ['inventory.raw.*'],
                ],
                [
                    'title' => 'فئات المخزون',
                    'icon' => 'far fa-circle',
                    'route' => 'inventory.categories.index',
                    'active_routes' => ['inventory.categories.*'],
                ],
                [
                    'title' => 'حركات المخزون',
                    'icon' => 'far fa-circle',
                    'route' => 'inventory.movements.index',
                    'active_routes' => ['inventory.movements.*'],
                ],
            ]
        ],

        // Reports Group
        [
            'title' => 'التقارير',
            'icon' => 'fas fa-chart-line',
            'type' => 'dropdown',
            'id' => 'reports-menu',
            'active_routes' => ['reports.*'],
            'children' => [
                [
                    'title' => 'المبيعات',
                    'icon' => 'far fa-circle',
                    'route' => 'reports.sales',
                    'active_routes' => ['reports.sales'],
                ],
                [
                    'title' => 'المنتجات الأكثر مبيعاً',
                    'icon' => 'far fa-circle',
                    'route' => 'reports.top-products',
                    'active_routes' => ['reports.top-products'],
                ],
                [
                    'title' => 'أداء الموظفين',
                    'icon' => 'far fa-circle',
                    'route' => 'reports.staff-performance',
                    'active_routes' => ['reports.staff-performance'],
                ],
            ]
        ],
        // Settings Group
        [
            'title' => 'الإعدادات',
            'icon' => 'fas fa-cogs',
            'type' => 'dropdown',
            'id' => 'settings-menu',
            'active_routes' => ['settings.*'],
            'children' => [
                 [
                    'title' => 'الإعدادات العامة',
                    'icon' => 'far fa-circle',
                    'route' => 'settings.index',
                    'active_routes' => ['settings.index', 'settings.update'],
                ],
                [
                    'title' => 'وسائل الدفع',
                    'icon' => 'far fa-circle',
                    'route' => 'payment-methods.index',
                    'active_routes' => ['payment-methods.*'],
                ],
                [
                    'title' => 'الطاولات والأماكن',
                    'icon' => 'far fa-circle',
                    'route' => 'tables.index',
                    'active_routes' => ['tables.*', 'areas.*'],
                ],
                [
                    'title' => 'وحدات القياس',
                    'icon' => 'far fa-circle',
                    'route' => 'units.index',
                    'active_routes' => ['units.*'],
                ],
                [
                    'title' => 'الضرائب والرسوم',
                    'icon' => 'far fa-circle',
                    'route' => 'charges.index',
                    'active_routes' => ['charges.*'],
                ],
            ]
        ],
    ],
    'cashier' => [
        [
            'title' => 'البيع السريع',
            'icon' => 'fas fa-cash-register',
            'route' => 'pos.index',
            'active_routes' => ['pos.*'],
        ],
    ]
];
