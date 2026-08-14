<?php

namespace App\Http\Controllers\Admin;

use App\Services\DashboardService;
use Illuminate\View\View;

class DashboardController extends BaseAdminController
{
    public function __construct(protected DashboardService $dashboardService)
    {
    }

    public function index(): View
    {
        $data = $this->dashboardService->getDashboardData();

        return $this->renderView('admin.dashboard', $data);
    }
}
