<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SensorLog;

class DashboardController extends Controller
{
    public function IndexPage()
    {
        // Ambil 20 data terakhir berdasarkan kolom 'created_at' (pastikan tabel memiliki kolom timestamp)
        $logs = SensorLog::latest()->take(20)->get();

        return view('admin.pages.dashboard.index', compact('logs'));
    }
}