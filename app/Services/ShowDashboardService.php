<?php

namespace App\Services;

use App\Models\Order;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;

class ShowDashboardService
{
    public function index(Request $request)
    {
        if (in_array(auth()->user()->role, ['user', 'cashier'])) {
            return redirect()->route('pos.index');
        }

        $filter = $request->get('filter', 'day');

        if ($filter === 'week') {
            $startDate = Carbon::now()->startOfWeek();
            $endDate = Carbon::now()->endOfWeek();
            $format = 'D';
        } elseif ($filter === 'month') {
            $startDate = Carbon::now()->startOfMonth();
            $endDate = Carbon::now()->endOfMonth();
            $format = 'd';
        } else {
            $startDate = Carbon::today();
            $endDate = Carbon::today();
            $format = 'd/m';
        }

        $orderCards = [
            [
                'title' => 'كل الطلبات',
                'key' => 'allOrdersChart',
                'type' => null,
                'source' => null,
            ],
            [
                'title' => 'طلبات السفري',
                'key' => 'takeawayChart',
                'type' => 'takeaway',
                'source' => null,
            ],
            [
                'title' => 'طلبات الطاولات',
                'key' => 'tableChart',
                'type' => 'table',
                'source' => null,
            ],
            [
                'title' => 'الجلوس الحر',
                'key' => 'freeSeatingChart',
                'type' => 'free_seating',
                'source' => null,
            ],
            [
                'title' => 'طلبات التوصيل',
                'key' => 'deliveryChart',
                'type' => 'delivery',
                'source' => null,
            ],
            [
                'title' => 'طلبات الويب',
                'key' => 'webOrdersChart',
                'type' => null,
                'source' => 'web',
            ],
            [
                'title' => 'طلبات التطبيق',
                'key' => 'appOrdersChart',
                'type' => null,
                'source' => 'app',
            ],
            [
                'title' => 'طلبات الكاشير',
                'key' => 'posOrdersChart',
                'type' => null,
                'source' => 'pos',
            ],
        ];

        foreach ($orderCards as &$card) {
            $labels = [];
            $data = [];

            // تحديد الفترة حسب الفلتر
            $period = CarbonPeriod::create($startDate, $endDate);

            foreach ($period as $date) {
                $labels[] = $date->translatedFormat($format);

                // استعلام للحصول على عدد الطلبات
                $query = Order::where('user_id', auth()->id())
                              ->whereDate('created_at', $date->toDateString());

                // تطبيق الفلاتر على النوع والمصدر
                if ($card['type']) {
                    $query->where('type', $card['type']);
                }

                if ($card['source']) {
                    $query->where('source', $card['source']);
                }

                $data[] = $query->count(); // إضافة العدد لكل يوم
            }

            // حساب الإجمالي بناءً على الفلتر
            $totalQuery = Order::where('user_id', auth()->id());

            // إضافة الفلاتر الخاصة بالـ type و الـ source
            if ($card['type']) {
                $totalQuery->where('type', $card['type']);
            }

            if ($card['source']) {
                $totalQuery->where('source', $card['source']);
            }

            // تطبيق الفلتر على الفترة الزمنية
            if ($filter === 'day') {
                $totalQuery->whereDate('created_at', Carbon::today());
            } elseif ($filter === 'week') {
                $totalQuery->whereBetween('created_at', [
                    Carbon::now()->startOfWeek(),
                    Carbon::now()->endOfWeek()
                ]);
            } else {
                $totalQuery->whereBetween('created_at', [
                    Carbon::now()->startOfMonth(),
                    Carbon::now()->endOfMonth()
                ]);
            }

            // إضافة النتائج إلى الكارت
            $card['labels'] = $labels;
            $card['data'] = $data;
            $card['value'] = $totalQuery->count(); // مجموع الطلبات
        }

        return view('dashboard', compact('orderCards', 'filter'));
    }
}