<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\DashboardService;

class DashboardController extends Controller
{
    protected DashboardService $dashboardService;

    public function __construct(DashboardService $dashboardService)
    {
        $this->dashboardService = $dashboardService;
    }

    /**
     * ダッシュボード表示
     */
    public function index()
    {
        $userId = Auth::id();

        $annualSummary = $this->dashboardService
            ->getAnnualSummaryForUser($userId);

        return view('dashboard.home', compact('annualSummary'));
    }
    public function notifications()
    {
        $notifications = $this->dashboardService->getNotifications();

        return view('dashboard.notifications', [
            'notifications' => $notifications,
        ]);
    }
}