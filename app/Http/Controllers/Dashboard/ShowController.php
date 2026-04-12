<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Services\ShowDashboardService;
use Illuminate\Http\Request;

class ShowController extends Controller
{
    public function __construct(private readonly ShowDashboardService $showDashboardService)
    {
    }

    public function index(Request $request)
    {
        return $this->showDashboardService->index($request);
    }
}
