<?php

use App\Models\Facility;
use App\Models\Complaint;
use Livewire\Volt\Component;
use Livewire\Attributes\Layout;

new #[Layout('layouts.app')] class extends Component {
    public $facilities;
    public $facility_name = '';
    public $facility_score = ''; // Tambahkan properti ini
    public $editingId = null;
    public $isModalOpen = false;

    public function mount() {
        $this->loadFacilities();
    }

    public function loadFacilities() {
        $this->facilities = Facility::latest()->get();
    }

    public function openModal($id = null) {
        $this->resetValidation();
        $this->facility_name = '';
        $this->facility_score = ''; // Reset properti
        $this->editingId = $id;

        if ($id) {
            $facility = Facility::find($id);
            $this->facility_name = $facility->facility_name;
            $this->facility_score = $facility->facility_score; // Muat data saat edit
        }

        $this->isModalOpen = true;
    }

    public function closeModal() {
        $this->isModalOpen = false;
    }

    public function save() {
        // Tambahkan validasi untuk facility_score
        $this->validate([
            'facility_name' => 'required|string|max:255',
            'facility_score' => 'required|integer|min:1|max:5', // Asumsi bobot 1 sampai 5
        ]);

        if ($this->editingId) {
            Facility::find($this->editingId)->update([
                'facility_name' => $this->facility_name,
                'facility_score' => $this->facility_score, // Masukkan ke query update
            ]);
            session()->flash('success', 'Fasilitas berhasil diperbarui!');
        } else {
            Facility::create([
                'facility_name' => $this->facility_name,
                'facility_score' => $this->facility_score, // Masukkan ke query create
            ]);
            session()->flash('success', 'Fasilitas baru berhasil ditambahkan!');
        }

        $this->closeModal();
        $this->loadFacilities();
    }

    public function delete($id) {
        $isInUse = Complaint::where('facility_id', $id)->exists();
        
        if($isInUse) {
            session()->flash('error', 'Gagal: Fasilitas tidak dapat dihapus karena sudah memiliki riwayat pengaduan.');
            return;
        }

        Facility::find($id)->delete();
        session()->flash('success', 'Fasilitas berhasil dihapus secara permanen!');
        $this->loadFacilities();
    }
}; ?>

<div class="min-h-screen bg-[#FAFAFA] flex flex-col md:flex-row font-sans overflow-hidden">
    
    <x-admin-sidebar />

    <div class="flex-1 p-8 overflow-y-auto">
        <div class="mb-10 flex justify-between items-end">
            <div>
                <h1 class="text-4xl font-bold text-[#0A4D40]">Master Fasilitas</h1>
                <p class="text-gray-500 mt-2">Kelola daftar kategori fasilitas dan bobot prioritasnya.</p>
            </div>
            <button wire:click="openModal" class="bg-[#0A4D40] text-white px-6 py-3 rounded-full font-bold shadow-sm hover:bg-[#06382e] transition-colors flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                Tambah Fasilitas
            </button>
        </div>

        @if (session()->has('success'))
            <div class="mb-6 bg-emerald-50 text-emerald-700 px-4 py-3 rounded-xl border border-emerald-100 flex items-center gap-3">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                {{ session('success') }}
            </div>
        @endif
        @if (session()->has('error'))
            <div class="mb-6 bg-rose-50 text-rose-700 px-4 py-3 rounded-xl border border-rose-100 flex items-center gap-3">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                {{ session('error') }}
            </div>
        @endif

        <div class="bg-white rounded-[2rem] border border-gray-100 shadow-sm overflow-hidden">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50/50 border-b border-gray-100">
                        <th class="py-4 px-6 text-xs font-bold text-gray-400 uppercase tracking-wider w-16">ID</th>
                        <th class="py-4 px-6 text-xs font-bold text-gray-400 uppercase tracking-wider">Nama Fasilitas</th>
                        <th class="py-4 px-6 text-xs font-bold text-gray-400 uppercase tracking-wider text-center">Bobot (Score)</th>
                        <th class="py-4 px-6 text-xs font-bold text-gray-400 uppercase tracking-wider text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($facilities as $facility)
                        <tr class="hover:bg-gray-50/50 transition-colors">
                            <td class="py-4 px-6 text-sm text-gray-500 font-medium">#{{ $facility->id }}</td>
                            <td class="py-4 px-6 text-base font-bold text-gray-800">{{ $facility->facility_name }}</td>
                            <td class="py-4 px-6 text-center">
                                <span class="bg-emerald-50 text-emerald-700 font-black px-3 py-1 rounded-full text-sm">
                                    {{ $facility->facility_score }}
                                </span>
                            </td>
                            <td class="py-4 px-6 text-right">
                                <button wire:click="openModal({{ $facility->id }})" class="text-amber-500 hover:text-amber-600 font-bold text-sm px-3 py-1 bg-amber-50 rounded-lg mr-2 transition-colors">Edit</button>
                                <button wire:click="delete({{ $facility->id }})" wire:confirm="Yakin ingin menghapus fasilitas ini secara permanen?" class="text-rose-500 hover:text-rose-600 font-bold text-sm px-3 py-1 bg-rose-50 rounded-lg transition-colors">Hapus</button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="py-12 text-center text-gray-400 italic">Belum ada data fasilitas.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    @if($isModalOpen)
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-black/40 backdrop-blur-sm p-4">
            <div class="bg-white rounded-[2rem] shadow-2xl max-w-md w-full p-8 relative" @click.away="$wire.closeModal()">
                <button wire:click="closeModal" class="absolute top-6 right-6 text-gray-400 hover:text-gray-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
                
                <h3 class="text-2xl font-bold text-[#0A4D40] mb-6">{{ $editingId ? 'Edit Fasilitas' : 'Tambah Fasilitas Baru' }}</h3>
                
                <form wire:submit="save" class="space-y-4">
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Nama Fasilitas</label>
                        <input type="text" wire:model="facility_name" placeholder="Contoh: Listrik / AC Ruangan" required class="w-full rounded-xl border-gray-200 focus:border-[#0A4D40] focus:ring-[#0A4D40] shadow-sm py-3 px-4">
                        <x-input-error :messages="$errors->get('facility_name')" class="mt-2 text-rose-500 text-xs" />
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Bobot Prioritas (1-5)</label>
                        <input type="number" wire:model="facility_score" min="1" max="5" placeholder="Makin tinggi makin mendesak" required class="w-full rounded-xl border-gray-200 focus:border-[#0A4D40] focus:ring-[#0A4D40] shadow-sm py-3 px-4">
                        <p class="text-[10px] text-gray-400 mt-1">Bobot ini digunakan untuk mengkalkulasi skor antrean otomatis.</p>
                        <x-input-error :messages="$errors->get('facility_score')" class="mt-2 text-rose-500 text-xs" />
                    </div>

                    <div class="flex gap-3 pt-4">
                        <button type="button" wire:click="closeModal" class="flex-1 py-3 px-4 text-gray-600 font-bold bg-gray-100 rounded-xl hover:bg-gray-200 transition-colors">Batal</button>
                        <button type="submit" class="flex-1 py-3 px-4 text-white font-bold bg-[#0A4D40] rounded-xl hover:bg-[#06382e] transition-colors">Simpan Data</button>
                    </div>
                </form>
            </div>
        </div>
    @endif

</div>