<?php

namespace App\Services;

use App\Models\Order;
use App\Models\Expense;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;

class ShowDashboardService
{
    public function index(Request $request)
    {


       // $filter = $request->get('filter', 'day')??null;

       $filter = $request->get('filter')??null;


        if($filter!=NULL){
        switch ($filter) {
            case 'week':


$Expense=Expense::whereBetween('created_at', [
    Carbon::now()->startOfWeek(),
    Carbon::now()->endOfWeek(),
    ])->sum('Amount');

$Orders=Order::where('type','delivery')->whereBetween('created_at', [
    Carbon::now()->startOfWeek(),
    Carbon::now()->endOfWeek(),
    ])->get();
$delivery=Order::where('type','delivery')->whereBetween('created_at', [
            Carbon::now()->startOfWeek(),
            Carbon::now()->endOfWeek(),
            ])->get();
$takeaway=Order::where('type','takeaway')->whereBetween('created_at', [
    Carbon::now()->startOfWeek(),
    Carbon::now()->endOfWeek(),
    ])->get();
$free_seating=Order::where('type','free_seating')->whereBetween('created_at', [
    Carbon::now()->startOfWeek(),
    Carbon::now()->endOfWeek(),
    ])->get();




                $startDate = Carbon::now()->startOfWeek();
                $endDate = Carbon::now()->endOfWeek();
                $format = 'D';

                break;          // exit switch
            case 'day':

$Expense=Expense::whereDate('created_at', Carbon::today())->sum('Amount');

$Orders=Order::whereDate('created_at', Carbon::today())->get();
$delivery=Order::where('type','delivery')->whereDate('created_at', Carbon::today())->get();
$takeaway=Order::where('type','takeaway')->whereDate('created_at', Carbon::today())->get();
$free_seating=Order::where('type','free_seating')->whereDate('created_at', Carbon::today())->get();
$startDate = Carbon::now()->startOfMonth();
$endDate = Carbon::now()->endOfMonth();
$format = 'd';
                break;          // exit switch


                case 'month':


$Expense=Expense::whereBetween('created_at', [
    Carbon::now()->startOfMonth(),
            Carbon::now()->endOfMonth(),
    ])->sum('Amount');

$Orders=Order::whereDate('created_at', Carbon::today())->get();
$delivery=Order::where('type','delivery')->whereBetween('created_at', [
    Carbon::now()->startOfMonth(),
            Carbon::now()->endOfMonth(),
    ])->get();

$takeaway=Order::where('type','takeaway')->whereBetween('created_at', [
Carbon::now()->startOfMonth(),
        Carbon::now()->endOfMonth(),
])->get();

$free_seating=Order::where('type','free_seating')->whereBetween('created_at', [
Carbon::now()->startOfMonth(),
        Carbon::now()->endOfMonth(),
])->get();

$startDate = Carbon::now()->startOfMonth();
$endDate = Carbon::now()->endOfMonth();
$format = 'd';
    break;
          // exit switch
            default:


        }

    }else{
        $Expense=Expense::sum('Amount');
        $Orders=Order::get();
        $delivery=Order::where('type','delivery')->get();
        $takeaway=Order::where('type','takeaway')->get();
        $free_seating=Order::where('type','free_seating')->get();

        $startDate = Carbon::today();
        $endDate = Carbon::today();
        $format = 'd/m';  // no break needed here (end of switch)

    }



        $orderCards = [
            [
                'title' => 'كل الطلبات',
                'key' => 'allOrdersChart',
                'type' => null,
                'source' => null,
                'value'=>count($Orders)
            ],
            [
                'title' => 'طلبات التوصيل',
                'key' => 'deliveryChart',
                'type' => 'delivery',
                'source' => null,
                'value'=>count($delivery)
            ],
            [
                'title' => 'طلبات الاستلام',
                'key' => 'pickupChart',
                'type' => 'takeaway',
                'source' => null,
                'value'=>count($takeaway),
            ],
            [
                'title' => 'طلبات طاولات ',
                'key' => 'localChart',
                'type' => 'local',
                'source' => null,
                'value'=>count($free_seating),
            ],


            [
                'title' => 'صافي مبيعات',
                'key' => 'localChart',
                'type' => 'local',
                'source' => null,
                'value'=>'0',
            ],


            [
                'title' => 'صافي مصروفات',
                'key' => 'localChart',
                'type' => 'local',
                'source' => null,
                'value'=>$Expense,
            ],

        ];

        foreach ($orderCards as &$card) {
            $labels = [];
            $data = [];

            $period = CarbonPeriod::create($startDate, $endDate);

            foreach ($period as $date) {
                $labels[] = $date->translatedFormat($format);

                $query = Order::where('user_id', auth()->id())
                    ->whereDate('created_at', $date->toDateString());

                if ($card['type']) {
                    if ($card['type'] === 'local') {
                        $query->whereIn('type', ['table', 'free_seating']);
                    } else {
                        $query->where('type', $card['type']);
                    }
                }

                if ($card['source']) {
                    $query->where('source', $card['source']);
                }

                $data[] = $query->count();
            }

            $totalQuery = Order::where('user_id', auth()->id());

            if ($card['type']) {
                if ($card['type'] === 'local') {
                    $totalQuery->whereIn('type', ['table', 'free_seating']);
                } else {
                    $totalQuery->where('type', $card['type']);
                }
            }

            if ($card['source']) {
                $totalQuery->where('source', $card['source']);
            }



            $card['labels'] = $labels;
            $card['data'] = $data;
            //$card['value'] = $totalQuery->count();
        }

        return view('summary', compact('orderCards', 'filter'));
    }
}
