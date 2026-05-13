<?php
namespace App\Http\Controllers;

use App\Models\Complaint;
use App\Models\Facility;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Menambahkan Facade Auth
use Illuminate\Support\Facades\Storage;

class ComplaintController extends Controller
{
    public function index()
{
    $userId = Auth::id(); // Menggunakan Facade Auth sesuai permintaan Anda

    // 1. Ambil statistik ringkasan milik user
    $stats = [
        'total' => Complaint::where('user_id', $userId)->count(),
        'processed' => Complaint::where('user_id', $userId)->where('status', 'diproses')->count(),
        'completed' => Complaint::where('user_id', $userId)->where('status', 'selesai')->count(),
    ];

    // 2. Ambil riwayat pengaduan terbaru milik user
    $complaints = Complaint::with('facility')
        ->where('user_id', $userId)
        ->latest()
        ->paginate(5);

    return view('dashboard', compact('stats', 'complaints'));
}

    public function create()
        {
            // Mengambil semua data fasilitas untuk ditampilkan di pilihan (dropdown)
            $facilities = Facility::all();
            
            return view('complaints.create', compact('facilities'));
        }
    /**
     * Menangani pengiriman laporan baru oleh Mahasiswa/Dosen
     */
    public function store(Request $request)
    {
        // 1. Validasi Input
        $validated = $request->validate([
            'facility_id' => 'required|exists:facilities,id',
            'location' => 'required|string|max:255',
            'description' => 'required|string',
            'severity_level' => 'required|in:ringan,sedang,kritis',
            // Diubah menjadi nullable agar opsional bagi pelapor
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048', 
        ]);

        // 2. Handle Upload Foto Kerusakan (Hanya jika ada file)
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('complaints', 'public');
        }

        // 3. Hitung Skor Prioritas secara otomatis
        $priorityScore = Complaint::calculatePriority(
            $validated['facility_id'], 
            $validated['severity_level']
        );

        // 4. Simpan Data ke Database menggunakan Auth::id()
        $complaint = Complaint::create([
            'user_id' => Auth::id(), 
            'facility_id' => $validated['facility_id'],
            'location' => $validated['location'],
            'description' => $validated['description'],
            'severity_level' => $validated['severity_level'],
            'priority_score' => $priorityScore,
            'status' => 'menunggu',
            'image' => $imagePath,
        ]);

        return redirect()->to('/login')->with('success', 'Laporan berhasil dikirim!');
    }

    /**
     * Menangani pembaruan status laporan oleh Admin/Petugas
     */
    public function updateStatus(Request $request, $id)
    {
        $complaint = Complaint::findOrFail($id);

        $request->validate([
            'status' => 'required|in:menunggu,diproses,selesai,ditolak',
            'catatan_teknisi' => 'nullable|string',
            'resolved_image' => 'required_if:status,selesai|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $oldStatus = $complaint->status;
        $newStatus = $request->status;

        if ($request->hasFile('resolved_image')) {
            $resolvedPath = $request->file('resolved_image')->store('complaints/resolved', 'public');
            $complaint->resolved_image = $resolvedPath;
        }

        $complaint->status = $newStatus;
        if ($request->filled('catatan_teknisi')) {
            $complaint->catatan_teknisi = $request->catatan_teknisi;
        }
        $complaint->save();

        // 4. Catat Histori Perubahan Status menggunakan Auth::id()
        $complaint->statusLogs()->create([
            'admin_id' => Auth::id(),
            'old_status' => $oldStatus,
            'new_status' => $newStatus,
        ]);

        return redirect()->back()->with('success', 'Status laporan berhasil diperbarui!');
    }
}