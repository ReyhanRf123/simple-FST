<?php

use App\Models\Complaint;
use App\Models\Facility;
use Livewire\Volt\Component;
use Livewire\Attributes\Layout;
use Livewire\WithPagination;

new #[Layout('layouts.app')] class extends Component {
    use WithPagination;

    // Properti untuk Filter
    public $startDate = '';
    public $endDate = '';
    public $filterStatus = '';
    public $filterFacility = '';

    // Me-reset paginasi setiap kali filter diubah
    public function updating($property)
    {
        $this->resetPage();
    }

    public function with()
    {
        $query = Complaint::with(['user', 'facility'])->latest();

        // Logika Filter
        if ($this->startDate) {
            $query->whereDate('created_at', '>=', $this->startDate);
        }
        if ($this->endDate) {
            $query->whereDate('created_at', '<=', $this->endDate);
        }
        if ($this->filterStatus) {
            $query->where('status', $this->filterStatus);
        }
        if ($this->filterFacility) {
            $query->where('facility_id', $this->filterFacility);
        }

        // Kalkulasi ringkasan berdasarkan filter saat ini
        $filteredCount = (clone $query)->count();
        $resolvedCount = (clone $query)->where('status', 'selesai')->count();

        return [
            'complaints' => $query->paginate(20),
            'facilities' => Facility::all(),
            'filteredCount' => $filteredCount,
            'resolvedCount' => $resolvedCount,
        ];
    }

    public function resetFilters()
    {
        $this->reset(['startDate', 'endDate', 'filterStatus', 'filterFacility']);
        $this->resetPage();
    }
}; ?>

<div class="min-h-screen bg-[#FAFAFA] flex flex-col md:flex-row font-sans overflow-hidden">
    
    <div class="print:hidden shrink-0">
        <x-admin-sidebar />
    </div>

    <div class="flex-1 p-8 overflow-y-auto print:p-0 print:overflow-visible">
        
        <div class="mb-8 flex justify-between items-end print:mb-4">
            <div>
                <h1 class="text-4xl font-bold text-[#0A4D40] print:text-2xl">Rekap Laporan</h1>
                <p class="text-gray-500 mt-2 print:text-sm">Ringkasan data pengaduan fasilitas berdasarkan filter spesifik.</p>
            </div>
            <button onclick="window.print()" class="print:hidden bg-emerald-100 text-emerald-800 px-5 py-2.5 rounded-full font-bold shadow-sm hover:bg-emerald-200 transition-colors flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                Cetak PDF / Print
            </button>
        </div>

        <div class="print:hidden bg-white p-5 rounded-2xl shadow-sm border border-gray-100 mb-8 flex flex-wrap gap-4 items-end">
            <div>
                <label class="block text-xs font-bold text-gray-500 mb-1">Mulai Tanggal</label>
                <input type="date" wire:model.live="startDate" class="rounded-xl border-gray-200 text-sm focus:ring-[#0A4D40] focus:border-[#0A4D40]">
            </div>
            <div>
                <label class="block text-xs font-bold text-gray-500 mb-1">Sampai Tanggal</label>
                <input type="date" wire:model.live="endDate" class="rounded-xl border-gray-200 text-sm focus:ring-[#0A4D40] focus:border-[#0A4D40]">
            </div>
            <div>
                <label class="block text-xs font-bold text-gray-500 mb-1">Status</label>
                <select wire:model.live="filterStatus" class="rounded-xl border-gray-200 text-sm focus:ring-[#0A4D40] focus:border-[#0A4D40] min-w-[150px]">
                    <option value="">Semua Status</option>
                    <option value="menunggu">Menunggu</option>
                    <option value="diproses">Diproses</option>
                    <option value="selesai">Selesai</option>
                    <option value="ditolak">Ditolak</option>
                </select>
            </div>
            <div>
                <label class="block text-xs font-bold text-gray-500 mb-1">Kategori Fasilitas</label>
                <select wire:model.live="filterFacility" class="rounded-xl border-gray-200 text-sm focus:ring-[#0A4D40] focus:border-[#0A4D40] min-w-[150px]">
                    <option value="">Semua Fasilitas</option>
                    @foreach($facilities as $facility)
                        <option value="{{ $facility->id }}">{{ $facility->facility_name }}</option>
                    @endforeach
                </select>
            </div>
            <button wire:click="resetFilters" class="px-4 py-2 text-sm font-bold text-gray-500 bg-gray-100 hover:bg-gray-200 rounded-xl transition-colors">
                Reset Filter
            </button>
        </div>

        <div class="flex gap-4 mb-6">
            <div class="px-4 py-2 border-l-4 border-[#0A4D40] bg-[#0A4D40]/5 rounded-r-lg print:border-black print:bg-transparent">
                <p class="text-xs text-gray-500 font-bold uppercase tracking-wider">Total Data Tersaring</p>
                <p class="text-xl font-black text-[#0A4D40] print:text-black">{{ $filteredCount }} Laporan</p>
            </div>
            <div class="px-4 py-2 border-l-4 border-emerald-500 bg-emerald-50 rounded-r-lg print:border-black print:bg-transparent">
                <p class="text-xs text-gray-500 font-bold uppercase tracking-wider">Berhasil Diselesaikan</p>
                <p class="text-xl font-black text-emerald-700 print:text-black">{{ $resolvedCount }} Laporan</p>
            </div>
        </div>

        <div class="bg-white rounded-[2rem] border border-gray-100 shadow-sm overflow-hidden print:border-black print:rounded-none print:shadow-none">
            <table class="w-full text-left border-collapse print:text-xs">
                <thead>
                    <tr class="bg-gray-50/50 border-b border-gray-100 print:border-b-2 print:border-black print:bg-transparent">
                        <th class="py-4 px-6 text-xs font-bold text-gray-400 uppercase tracking-wider print:text-black print:py-2">Tanggal</th>
                        <th class="py-4 px-6 text-xs font-bold text-gray-400 uppercase tracking-wider print:text-black print:py-2">Pelapor</th>
                        <th class="py-4 px-6 text-xs font-bold text-gray-400 uppercase tracking-wider print:text-black print:py-2">Fasilitas / Lokasi</th>
                        <th class="py-4 px-6 text-xs font-bold text-gray-400 uppercase tracking-wider print:text-black print:py-2">Detail Kerusakan</th>
                        <th class="py-4 px-6 text-xs font-bold text-gray-400 uppercase tracking-wider print:text-black print:py-2">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 print:divide-black">
                    @forelse($complaints as $complaint)
                        <tr class="hover:bg-gray-50/50 transition-colors">
                            <td class="py-4 px-6 text-sm text-gray-500 print:text-black print:py-2">{{ $complaint->created_at->format('d/m/Y') }}</td>
                            <td class="py-4 px-6 text-sm font-bold text-gray-800 print:text-black print:py-2">{{ $complaint->user->name }}</td>
                            <td class="py-4 px-6 print:py-2">
                                <p class="text-sm font-bold text-gray-800 print:text-black">{{ $complaint->facility->facility_name }}</p>
                                <p class="text-xs text-gray-500 print:text-black">{{ $complaint->location }}</p>
                            </td>
                            <td class="py-4 px-6 text-sm text-gray-600 print:text-black print:py-2 max-w-xs line-clamp-2">{{ $complaint->description }}</td>
                            <td class="py-4 px-6 print:py-2">
                                @php
                                    $statusColor = match($complaint->status) {
                                        'menunggu' => 'bg-amber-100 text-amber-700',
                                        'diproses' => 'bg-blue-100 text-blue-700',
                                        'selesai' => 'bg-emerald-100 text-emerald-700',
                                        'ditolak' => 'bg-rose-100 text-rose-700',
                                        default => 'bg-gray-100 text-gray-700',
                                    };
                                @endphp
                                <span class="px-3 py-1 text-[10px] font-black rounded-full uppercase tracking-wider {{ $statusColor }} print:border print:border-black print:bg-transparent print:text-black">
                                    {{ $complaint->status }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-12 text-center text-gray-400 italic print:text-black">Tidak ada data laporan yang sesuai dengan filter.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-8 print:hidden">
            {{ $complaints->links() }}
        </div>

    </div>
</div>