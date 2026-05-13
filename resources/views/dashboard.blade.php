<x-app-layout>
    <div x-data="{ openModal: false, modalImgUrl: '', modalImgTitle: '' }" class="min-h-screen bg-[#FAFAFA] font-sans">
        
        <header class="bg-white/80 backdrop-blur-md border-b border-gray-100 sticky top-0 z-40 shadow-sm">
            <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 h-20 flex items-center justify-between">
                
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-[#0A4D40] rounded-2xl flex items-center justify-center text-white shadow-lg shadow-[#0A4D40]/20">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                    </div>
                    <div>
                        <h1 class="text-lg font-black text-[#0A4D40] leading-none tracking-tight">SIMPEL<span class="text-emerald-500">FST</span></h1>
                        <p class="text-[9px] text-gray-400 font-bold tracking-widest uppercase mt-0.5">Portal Pelaporan</p>
                    </div>
                </div>

                <div class="flex items-center gap-5">
                    <div class="hidden sm:flex items-center gap-3 text-right">
                        <div>
                            <p class="text-sm font-bold text-gray-900 leading-tight">{{ Auth::user()->name }}</p>
                            <p class="text-[10px] text-emerald-600 font-black uppercase tracking-widest">{{ Auth::user()->role }}</p>
                        </div>
                        <div class="w-10 h-10 rounded-full bg-emerald-50 text-[#0A4D40] flex items-center justify-center font-black text-lg border border-emerald-100">
                            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                        </div>
                    </div>
                    
                    <div class="hidden sm:block h-8 w-px bg-gray-200"></div>
                    
                    <livewire:user.logout-button />
                </div>
            </div>
        </header>

        <main class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-10 pb-32">
            
            <div class="mb-12 bg-[#0A4D40] rounded-[2rem] p-8 sm:p-10 text-white relative overflow-hidden shadow-xl shadow-[#0A4D40]/10">
                <div class="absolute top-0 right-0 -mt-10 -mr-10 w-64 h-64 bg-emerald-500 rounded-full mix-blend-multiply filter blur-3xl opacity-30"></div>
                <div class="absolute bottom-0 left-0 -mb-10 -ml-10 w-48 h-48 bg-teal-400 rounded-full mix-blend-multiply filter blur-3xl opacity-20"></div>
                
                <div class="relative z-10">
                    <h2 class="text-3xl sm:text-4xl font-bold tracking-tight mb-2">Halo, {{ explode(' ', Auth::user()->name)[0] }}! 👋</h2>
                    <p class="text-emerald-100 max-w-xl text-sm sm:text-base leading-relaxed">Punya keluhan terkait fasilitas kampus? Pantau terus status laporanmu di sini. Kami siap mewujudkan lingkungan belajar yang lebih baik.</p>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 mb-16">
                <div class="bg-white rounded-[2rem] p-6 shadow-sm border border-gray-100 hover:-translate-y-1 hover:shadow-md transition-all duration-300 relative overflow-hidden group">
                    <div class="absolute inset-y-0 left-0 w-2 bg-emerald-400 rounded-l-[2rem]"></div>
                    <div class="flex justify-between items-start ml-2">
                        <div>
                            <p class="text-xs text-gray-500 font-bold uppercase tracking-wider mb-1">Total Laporan</p>
                            <h3 class="text-4xl font-black text-gray-900">{{ $stats['total'] }}</h3>
                        </div>
                        <div class="p-3 bg-gray-50 rounded-2xl group-hover:bg-emerald-50 group-hover:text-emerald-600 transition-colors text-gray-400">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        </div>
                    </div>
                </div>
                <div class="bg-white rounded-[2rem] p-6 shadow-sm border border-gray-100 hover:-translate-y-1 hover:shadow-md transition-all duration-300 relative overflow-hidden group">
                    <div class="absolute inset-y-0 left-0 w-2 bg-amber-400 rounded-l-[2rem]"></div>
                    <div class="flex justify-between items-start ml-2">
                        <div>
                            <p class="text-xs text-gray-500 font-bold uppercase tracking-wider mb-1">Diproses</p>
                            <h3 class="text-4xl font-black text-gray-900">{{ $stats['processed'] }}</h3>
                        </div>
                        <div class="p-3 bg-gray-50 rounded-2xl group-hover:bg-amber-50 group-hover:text-amber-600 transition-colors text-gray-400">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                        </div>
                    </div>
                </div>
                <div class="bg-white rounded-[2rem] p-6 shadow-sm border border-gray-100 hover:-translate-y-1 hover:shadow-md transition-all duration-300 relative overflow-hidden group">
                    <div class="absolute inset-y-0 left-0 w-2 bg-[#0A4D40] rounded-l-[2rem]"></div>
                    <div class="flex justify-between items-start ml-2">
                        <div>
                            <p class="text-xs text-gray-500 font-bold uppercase tracking-wider mb-1">Telah Selesai</p>
                            <h3 class="text-4xl font-black text-gray-900">{{ $stats['completed'] }}</h3>
                        </div>
                        <div class="p-3 bg-gray-50 rounded-2xl group-hover:bg-emerald-50 group-hover:text-[#0A4D40] transition-colors text-gray-400">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex items-center justify-between mb-8">
                <h2 class="text-2xl font-bold text-[#0A4D40]">Perkembangan Laporan</h2>
            </div>
            
            <div class="relative border-l-2 border-dashed border-gray-200 ml-4 space-y-10">
                @forelse($complaints as $complaint)
                    @php
                        $statusData = match($complaint->status) {
                            'menunggu' => ['color' => 'amber', 'dot' => 'bg-amber-400', 'bg' => 'bg-amber-50', 'text' => 'text-amber-700'],
                            'diproses' => ['color' => 'blue', 'dot' => 'bg-blue-400', 'bg' => 'bg-blue-50', 'text' => 'text-blue-700'],
                            'selesai' => ['color' => 'emerald', 'dot' => 'bg-emerald-500', 'bg' => 'bg-emerald-50', 'text' => 'text-emerald-700'],
                            'ditolak' => ['color' => 'rose', 'dot' => 'bg-rose-500', 'bg' => 'bg-rose-50', 'text' => 'text-rose-700'],
                            default => ['color' => 'gray', 'dot' => 'bg-gray-400', 'bg' => 'bg-gray-50', 'text' => 'text-gray-700'],
                        };
                    @endphp
                    
                    <div class="relative ml-8 group">
                        <div class="absolute -left-[41px] top-5 w-5 h-5 rounded-full {{ $statusData['dot'] }} border-4 border-[#FAFAFA] group-hover:scale-125 transition-transform duration-300"></div>
                        
                        <div class="bg-white rounded-[2rem] p-6 shadow-sm border border-gray-100 flex flex-col md:flex-row gap-6 hover:shadow-lg transition-all duration-300">
                            
                            <div class="flex-1">
                                <div class="flex justify-between items-center mb-4">
                                    <p class="text-xs text-gray-400 font-bold flex items-center gap-1">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                        {{ $complaint->created_at->translatedFormat('d M Y, H:i') }}
                                    </p>
                                    <span class="px-4 py-1 text-[10px] font-black rounded-full {{ $statusData['bg'] }} {{ $statusData['text'] }} uppercase tracking-widest">
                                        {{ $complaint->status }}
                                    </span>
                                </div>
                                
                                <h3 class="text-xl font-bold text-gray-900 mb-1">{{ $complaint->facility->facility_name }}</h3>
                                <p class="text-xs font-bold text-emerald-600 mb-3 flex items-center gap-1">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                    {{ $complaint->location }}
                                </p>
                                <p class="text-sm text-gray-600 leading-relaxed bg-gray-50 p-4 rounded-2xl">{{ $complaint->description }}</p>

                                @if($complaint->status == 'selesai' && $complaint->catatan_teknisi)
                                    <div class="mt-4 p-4 bg-emerald-50/50 rounded-2xl text-sm border border-emerald-100 flex gap-3">
                                        <svg class="w-5 h-5 text-emerald-500 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                        <div>
                                            <p class="font-bold text-emerald-800 mb-1">Tanggapan Teknisi:</p>
                                            <p class="text-emerald-700">{{ $complaint->catatan_teknisi }}</p>
                                        </div>
                                    </div>
                                @endif
                            </div>

                            <div class="flex flex-row md:flex-col gap-3 shrink-0">
                                @if($complaint->image)
                                    <div class="flex-1 md:w-32">
                                        <p class="text-[9px] text-gray-400 font-black uppercase tracking-widest mb-1.5 text-center md:text-left">Bukti Laporan</p>
                                        <img @click="openModal = true; modalImgUrl = '{{ asset('storage/' . $complaint->image) }}'; modalImgTitle = 'Bukti Kerusakan: {{ $complaint->facility->facility_name }}'" 
                                             src="{{ asset('storage/' . $complaint->image) }}" 
                                             class="w-full h-24 rounded-2xl object-cover border-2 border-gray-100 cursor-pointer hover:border-[#0A4D40] transition-colors shadow-sm">
                                    </div>
                                @endif
                                @if($complaint->status === 'selesai' && $complaint->resolved_image)
                                    <div class="flex-1 md:w-32">
                                        <p class="text-[9px] text-emerald-600 font-black uppercase tracking-widest mb-1.5 text-center md:text-left">Hasil Perbaikan</p>
                                        <img @click="openModal = true; modalImgUrl = '{{ asset('storage/' . $complaint->resolved_image) }}'; modalImgTitle = 'Bukti Perbaikan: {{ $complaint->facility->facility_name }}'" 
                                             src="{{ asset('storage/' . $complaint->resolved_image) }}" 
                                             class="w-full h-24 rounded-2xl object-cover border-2 border-emerald-400 cursor-pointer hover:opacity-75 transition-opacity shadow-sm">
                                    </div>
                                @endif
                            </div>

                        </div>
                    </div>
                @empty
                    <div class="ml-8 bg-white p-10 rounded-[2rem] border border-gray-100 text-center shadow-sm">
                        <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path></svg>
                        <h3 class="text-lg font-bold text-gray-900 mb-1">Belum Ada Riwayat</h3>
                        <p class="text-gray-500 text-sm">Anda belum pernah mengajukan laporan kerusakan fasilitas.</p>
                    </div>
                @endforelse
            </div>

            <div class="fixed bottom-8 right-8 z-40">
                <a href="{{ route('complaints.create') }}" class="group flex items-center gap-3 bg-[#0A4D40] text-white px-6 py-4 rounded-full shadow-lg shadow-[#0A4D40]/30 hover:bg-[#06382e] hover:scale-105 transition-all duration-300">
                    <svg class="w-6 h-6 group-hover:rotate-90 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    <span class="font-bold tracking-wide">Buat Laporan Baru</span>
                </a>
            </div>

        </main>

        <div x-show="openModal" style="display: none;" class="fixed inset-0 z-[100] flex items-center justify-center bg-black/90 backdrop-blur-sm p-4 transition-opacity">
            <div @click.away="openModal = false" class="relative max-w-4xl w-full flex flex-col items-center">
                <button @click="openModal = false" class="absolute -top-12 right-0 text-white hover:text-emerald-400 transition-colors bg-white/10 p-2 rounded-full backdrop-blur-md">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
                <img :src="modalImgUrl" class="max-w-full max-h-[80vh] rounded-2xl shadow-2xl object-contain border border-white/20">
                <p x-text="modalImgTitle" class="mt-6 text-white font-bold text-lg tracking-wide"></p>
            </div>
        </div>
        
    </div>
</x-app-layout>