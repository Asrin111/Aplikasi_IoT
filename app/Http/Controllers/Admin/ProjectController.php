<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Device;

class ProjectController extends Controller
{
    // HAPUS PROJECT DI dashboard
    public function destroy($id)
    {
        $device = Device::findOrFail($id);
        $device->delete();

        return redirect()->route('dashboard')->with('success', 'Project berhasil dihapus.');
    }

    // Tampilkan detail project berdasarkan id perangkat
    public function detail($id)
    {
        // Mengambil data perangkat berdasarkan id dari database
        $device = Device::findOrFail($id);

        // Mengembalikan view detail project dengan data perangkat
        return view('admin.pages.project_detail', compact('device'));
    }
}