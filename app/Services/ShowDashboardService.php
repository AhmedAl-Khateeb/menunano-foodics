<?php

namespace App\Services;

use App\Models\Order;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ShowDashboardService
{
    public function index(Request $request)
    {
        $selectedDate = $request->get('date');
        // $filter = $request->get('filter', 'day');

        $filter = $request->get('filter') ?? null;

        if (in_array(auth()->user()->role, ['user', 'cashier'])) {
            return redirect()->route('pos.index');
        }

        // ======================
        // تحديد الفترة الزمنية
        // ======================

        if ($filter) {
            switch ($filter) {
                case 'week':
                    $startDate = Carbon::now()->startOfWeek();
                    $endDate = Carbon::now()->endOfWeek();
                    $step = '1 day';
                    $format = 'D';
                    break;

                case 'month':
                    $startDate = Carbon::now()->startOfMonth();
                    $endDate = Carbon::now()->endOfMonth();
                    $step = '1 day';
                    $format = 'd';
                    break;

                default: // day
                    $startDate = Carbon::today()->startOfDay();
                    $endDate = Carbon::now();
                    $step = '1 hour';
                    $format = 'H:00';
                    break;
            }
        } elseif ($selectedDate) {
            $startDate = Carbon::parse($selectedDate)->startOfDay();
            $endDate = Carbon::parse($selectedDate)->endOfDay();
            $step = '1 hour';
            $format = 'H:00';
        } else {
            $startDate = Carbon::today()->startOfDay();
            $endDate = Carbon::now();
            $step = '1 hour';
            $format = 'H:00';
        }

        // ======================
        // Base Query (موحد لكل الإحصائيات)
        // ======================
        $baseQuery = Order::where('user_id', auth()->id())
            ->whereBetween('created_at', [$startDate, $endDate]);

        // ======================
        // كروت الطلبات + الرسوم الصغيرة
        // ======================
        $orderCards = [
            ['title' => 'كل الطلبات', 'key' => 'allOrdersChart', 'type' => null],
            ['title' => 'التوصيل', 'key' => 'deliveryChart', 'type' => 'delivery'],
            ['title' => 'الاستلام', 'key' => 'pickupChart', 'type' => 'takeaway'],
            ['title' => 'محلي', 'key' => 'localChart', 'type' => 'local'],
        ];

        foreach ($orderCards as &$card) {
            $labels = [];
            $data = [];

            $period = CarbonPeriod::create($startDate, $step, $endDate);

            foreach ($period as $p) {
                $labels[] = $p->format($format);

                $q = Order::where('user_id', auth()->id())
                    ->whereBetween('created_at', [
                        $step === '1 hour' ? $p->copy()->startOfHour() : $p->copy()->startOfDay(),
                        $step === '1 hour' ? $p->copy()->endOfHour() : $p->copy()->endOfDay(),
                    ]);

                if ($card['type'] === 'local') {
                    $q->whereIn('type', ['table', 'free_seating']);
                } elseif ($card['type']) {
                    $q->where('type', $card['type']);
                }

                $data[] = $q->count();
            }

            $card['labels'] = $labels;
            $card['data'] = $data;
            $card['value'] = (clone $baseQuery)
                ->when($card['type'], function ($q) use ($card) {
                    if ($card['type'] === 'local') {
                        $q->whereIn('type', ['table', 'free_seating']);
                    } else {
                        $q->where('type', $card['type']);
                    }
                })
                ->count();
        }

        // ======================
        // المبيعات لكل ساعة / يوم
        // ======================
        $salesLabels = [];
        $salesData = [];

        $period = CarbonPeriod::create($startDate, $step, $endDate);

        foreach ($period as $p) {
            $salesLabels[] = $p->format($format);

            $salesData[] = Order::where('user_id', auth()->id())
                ->whereBetween('created_at', [
                    $step === '1 hour' ? $p->copy()->startOfHour() : $p->copy()->startOfDay(),
                    $step === '1 hour' ? $p->copy()->endOfHour() : $p->copy()->endOfDay(),
                ])
                ->sum('total_price');
        }

        // ======================
        // أعلى الفروع (خاص بالمستخدم + الفرع موجود)
        // ======================
        $topBranches = (clone $baseQuery)
            ->whereNotNull('branch_id')
            ->with('branch')
            ->selectRaw('branch_id, SUM(total_price) as total_sales')
            ->groupBy('branch_id')
            ->orderByDesc('total_sales')
            ->take(5)
            ->get();

        // ======================
        // أعلى المنتجات (خاص بالمستخدم)
        // ======================
        $topProducts = DB::table('order_product_sizes')
           ->join('orders', 'orders.id', '=', 'order_product_sizes.order_id')
           ->join('product_sizes', 'product_sizes.id', '=', 'order_product_sizes.product_size_id')
            ->join('products', 'products.id', '=', 'product_sizes.product_id')

            ->where('orders.user_id', auth()->id())

              ->whereBetween('orders.created_at', [
                  $startDate,
                  $endDate,
              ])

           ->whereNotNull('order_product_sizes.price')
          ->whereNotNull('order_product_sizes.quantity')
            ->where('order_product_sizes.quantity', '>', 0)

            ->selectRaw('
             products.id,
             products.name,
             SUM(order_product_sizes.price * order_product_sizes.quantity) as total_sales
                ')
              ->groupBy('products.id', 'products.name')
               ->havingRaw('SUM(order_product_sizes.price * order_product_sizes.quantity) > 0')
               ->orderByDesc('total_sales')
                ->take(5)
             ->get();

        // ======================
        // طرق الدفع (تنظيف التكرار)
        // ======================
        $topPayments = Order::where('user_id', auth()->id())
            ->whereBetween('created_at', [$startDate, $endDate])
            ->selectRaw('payment_method, COUNT(*) as total')
            ->groupBy('payment_method')
            ->orderByDesc('total')
            ->get();

        // QR Code
        $qrBaseUrl = env('QR_BASE_URL', config('app.url'));

        $storeName = auth()->user()->store_name;

        $storeUrl = $qrBaseUrl.'/'.$storeName;

        return view('summary', compact(
            'orderCards',
            'filter',
            'salesLabels',
            'salesData',
            'topBranches',
            'topProducts',
            'topPayments',
            'storeUrl',
        ));
    }
}
