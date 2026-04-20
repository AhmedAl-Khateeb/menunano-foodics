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
            'title' => 'إدارة أنواع النشاط',
            'icon' => 'fas fa-briefcase',
            'route' => 'business-types.index',
            'active_routes' => ['business-types.*'],
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
            ],
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
            ],
        ],
        // Orders Group

        [
            'title' => 'الطلبات',
            'icon' => 'fas fa-shopping-cart',
            'type' => 'dropdown',
            'id' => 'orders-menu',
            'active_routes' => ['pos.index', 'orders.*'],
            'children' => [
                [
                    'title' => 'كل الطلبات',
                    'icon' => 'fas fa-list',
                    'route' => 'orders.index',
                    'active_routes' => ['orders.index', 'orders.show'],
                ],
                [
                    'title' => 'طلبات التوصيل',
                    'icon' => 'fas fa-motorcycle',
                    'route' => 'orders.delivery',
                    'active_routes' => ['orders.delivery'],
                ],
                [
                    'title' => 'طلبات الاستلام',
                    'icon' => 'fas fa-hand-holding',
                    'route' => 'orders.pickup',
                    'active_routes' => ['orders.pickup'],
                ],
                [
                    'title' => 'الطلبات المحلية',
                    'icon' => 'fas fa-store',
                    'route' => 'orders.local',
                    'active_routes' => ['orders.local'],
                ],
            ],
        ],

        // Users Group
        [
            'title' => 'الأدارة',
            'icon' => 'fas fa-user-shield',
            'type' => 'dropdown',
            'id' => 'users-menu',
            'active_routes' => ['users.*', 'roles.*'],
            'children' => [
                [
                    'title' => 'المستخدمين',
                    'icon' => 'fas fa-user',
                    'route' => 'users.index',
                    'active_routes' => ['users.index', 'users.create', 'users.edit'],
                ],
                // [
                //     'title' => 'العملاء',
                //     'icon' => 'far fa-circle',
                //     'route' => 'users.customers',
                //     'active_routes' => ['users.customers'],
                // ],
                [
                    'title' => 'الأدوار والصلاحيات',
                    'icon' => 'fas fa-key',
                    'route' => 'roles.index',
                    'active_routes' => ['roles.*'],
                ],
                [
                    'title' => 'الفروع',
                    'icon' => 'fas fa-store',
                    'route' => 'branches.index',
                    'active_routes' => ['branches.*'],
                ],
                [
                    'title' => 'الشيفتات',
                    'icon' => 'fas fa-user-clock',
                    'route' => 'shifts.index',
                    'active_routes' => ['shifts.*'],
                ],
                [
                    'title' => 'تسجيل الحضور والانصراف',
                    'icon' => 'fas fa-clock',
                    'route' => 'attendances.index',
                    'active_routes' => ['attendances.*'],
                ],
            ],
        ],
        // Inventory & Items Module
        [
            'title' => 'المخزن',
            'icon' => 'fas fa-warehouse',
            'type' => 'dropdown',
            'id' => 'inventory-menu',
            'active_routes' => ['inventory.*'],
            'children' => [
                [
                    'title' => 'الموردون',
                    'icon' => 'fas fa-truck',
                    'route' => 'inventory.suppliers.index',
                    'active_routes' => ['inventory.suppliers.*'],
                ],
                [
                    'title' => 'فئات المخزون',
                    'icon' => 'fas fa-tags',
                    'route' => 'inventory.categories.index',
                    'active_routes' => ['inventory.categories.*'],
                ],
                [
                    'title' => 'وحدات القياس',
                    'icon' => 'fas fa-balance-scale',
                    'route' => 'units.index',
                    'active_routes' => ['units.*'],
                ],
                [
                    'title' => 'مواد المخزن',
                    'icon' => 'fas fa-boxes',
                    'route' => 'inventory.materials.index',
                    'active_routes' => ['inventory.materials.*'],
                ],

                [
                    'title' => 'طلبات الشراء',
                    'icon' => 'fas fa-file-alt',
                    'route' => 'inventory.purchase-requests.index',
                    'active_routes' => ['inventory.purchase-requests.*'],
                ],
                [
                    'title' => 'أوامر الشراء',
                    'icon' => 'fas fa-shopping-cart',
                    'route' => 'inventory.purchase-orders.index',
                    'active_routes' => ['inventory.purchase-orders.*'],
                ],
                [
                    'title' => 'الشراء / الاستلام',
                    'icon' => 'fas fa-dolly',
                    'route' => 'inventory.receipts.index',
                    'active_routes' => ['inventory.receipts.*'],
                ],

                [
                    'title' => 'الإنتاج',
                    'icon' => 'fas fa-industry',
                    'route' => 'inventory.production-orders.index',
                    'active_routes' => ['inventory.production-orders.*'],
                ],
                [
                    'title' => 'طلبات التحويل',
                    'icon' => 'fas fa-exchange-alt',
                    'route' => 'inventory.transfer-requests.index',
                    'active_routes' => ['inventory.transfer-requests.*'],
                ],

                [
                    'title' => 'جرد المخزن',
                    'icon' => 'fas fa-clipboard-check text-warning',
                    'route' => 'inventory.stock-counts.index',
                    'active_routes' => ['inventory.stock-counts.*'],
                ],
                [
                    'title' => 'حركات المخزون',
                    'icon' => 'fas fa-random',
                    'route' => 'inventory.movements.index',
                    'active_routes' => ['inventory.movements.*'],
                ],
                [
                    'title' => 'لوحة المخزن',
                    'icon' => 'fas fa-chart-line',
                    'route' => 'inventory.dashboard',
                    'active_routes' => ['inventory.dashboard'],
                ],
            ],
        ],

        // Purchases Module
        // [
        //     'title' => 'المشتريات',
        //     'icon' => 'fas fa-shopping-cart',
        //     'type' => 'dropdown',
        //     'id' => 'purchases-menu',
        //     'active_routes' => ['suppliers.*', 'purchases.*'],
        //     'children' => [
        //         [
        //             'title' => 'الموردين',
        //             'icon' => 'far fa-circle',
        //             'route' => 'inventory.suppliers.index',
        //             'active_routes' => ['suppliers.*'],
        //         ],
        //     ],
        // ],

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
            ],
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
                    'title' => 'الضرائب والرسوم',
                    'icon' => 'far fa-circle',
                    'route' => 'charges.index',
                    'active_routes' => ['charges.*'],
                ],
            ],
        ],
    ],
    'cashier' => [
        [
            'title' => 'البيع السريع',
            'icon' => 'fas fa-cash-register',
            'route' => 'pos.index',
            'active_routes' => ['pos.*'],
        ],
    ],
];
