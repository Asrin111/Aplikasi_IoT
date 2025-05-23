<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SensorLog;

class DashboardController extends Controller
{
    public function IndexPage()
{
    $logs = SensorLog::where('id', 1)->get();
    return view('admin.pages.dashboard.index', compact('logs'));
}
}