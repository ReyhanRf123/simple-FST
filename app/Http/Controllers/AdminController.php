<?php

namespace App\Http\Controllers;

use App\Models\Complaint;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        // 1. Mengambil data statistik untuk kartu dashboard [cite: 1111]
        $stats = [
            'total' => Complaint::count(),
            'pending' => Complaint::where('status', 'menunggu')->count(),
            'processed' => Complaint::where('status', 'diproses')->count(),
            'completed' => Complaint::where('status', 'selesai')->count(),
        ];

        // 2. Mengambil daftar pengaduan diurutkan berdasarkan skor prioritas tertinggi [cite: 706, 1112]
        $complaints = Complaint::with(['user', 'facility'])
            ->orderBy('priority_score', 'desc')
            ->orderBy('created_at', 'desc')
            ->paginate(10); // Menggunakan paginasi agar performa tetap cepat

        return view('admin.dashboard', compact('stats', 'complaints'));
    }
}