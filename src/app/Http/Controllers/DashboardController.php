<?php

namespace App\Http\Controllers;

use App\Services\DashboardService;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    private DashboardService $dashboardService;

    public function __construct(DashboardService $dashboardService)
    {
        $this->dashboardService = $dashboardService;
    }

    /**
     * ダッシュボードトップ
     */
    public function home()
    {
        $data = $this->dashboardService->getDashboardData();

        return view('dashboard.home', $data);
    }
}