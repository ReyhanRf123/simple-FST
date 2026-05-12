<x-app-layout>
    <div class="min-h-screen bg-[#FAFAFA] pt-8 pb-12 font-sans">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="mb-10">
                <h1 class="text-4xl font-bold text-[#0A4D40] tracking-tight">Selamat Pagi, {{ Auth::user()->name }}</h1>
                <p class="text-gray-500 text-sm mt-2">Ringkasan aktivitas pengaduan fasilitas kampus Anda.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-12">
                <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 relative overflow-hidden">
                    <div class="absolute left-0 top-0 bottom-0 w-1.5 bg-emerald-400"></div>
                    <div class="flex justify-between items-start">
                        <p class="text-xs text-gray-500 font-semibold mb-2">Total Laporan</p>
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    </div>
                    <h2 class="text-4xl font-bold text-gray-900 mt-2">{{ $stats['total'] }}</h2>
                </div>
                <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 relative overflow-hidden">
                    <div class="absolute left-0 top-0 bottom-0 w-1.5 bg-amber-400"></div>
                    <div class="flex justify-between items-start">
                        <p class="text-xs text-gray-500 font-semibold mb-2">Diproses</p>
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                    </div>
                    <h2 class="text-4xl font-bold text-gray-900 mt-2">{{ $stats['processed'] }}</h2>
                </div>
                <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 relative overflow-hidden">
                    <div class="absolute left-0 top-0 bottom-0 w-1.5 bg-emerald-500"></div>
                    <div class="flex justify-between items-start">
                        <p class="text-xs text-gray-500 font-semibold mb-2">Selesai</p>
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <h2 class="text-4xl font-bold text-gray-900 mt-2">{{ $stats['completed'] }}</h2>
                </div>
            </div>

            <h2 class="text-2xl font-bold text-[#0A4D40] mb-8">Riwayat Pengaduan</h2>
            
            <div class="relative border-l-2 border-gray-200 ml-4 space-y-8">
                @forelse($complaints as $complaint)
                <div class="relative ml-8">
                    <div class="absolute -left-[41px] top-4 w-5 h-5 rounded-full bg-emerald-500 border-4 border-[#FAFAFA]"></div>
                    
                    <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-100 flex flex-col md:flex-row gap-6">
                        <div class="flex-1">
                            <div class="flex justify-between items-start mb-3">
                                <p class="text-xs text-gray-400 font-medium">{{ $complaint->created_at->format('d M Y, H:i') }}</p>
                                <span class="px-4 py-1 text-[10px] font-bold rounded-full 
                                    {{ $complaint->status == 'menunggu' ? 'bg-amber-100 text-amber-700' : 
                                      ($complaint->status == 'diproses' ? 'bg-blue-100 text-blue-700' : 'bg-emerald-100 text-emerald-700') }} uppercase tracking-wider">
                                    {{ $complaint->status }}
                                </span>
                            </div>
                            <h3 class="text-xl font-bold text-gray-800">{{ $complaint->facility->facility_name }}</h3>
                            <p class="text-xs font-semibold text-gray-500 mb-2">📍 {{ $complaint->location }}</p>
                            <p class="text-sm text-gray-600 leading-relaxed">{{ $complaint->description }}</p>

                            @if($complaint->status == 'selesai' && $complaint->catatan_teknisi)
                                <div class="mt-4 p-3 bg-emerald-50 rounded-xl text-sm text-emerald-800 border border-emerald-100">
                                    <strong>Catatan Teknisi:</strong> {{ $complaint->catatan_teknisi }}
                                </div>
                            @endif
                        </div>

                        <div class="flex flex-col gap-3 shrink-0 md:w-32">
                            @if($complaint->image)
                                <div>
                                    <p class="text-[10px] text-gray-400 font-bold uppercase mb-1">Bukti Kerusakan</p>
                                    <img src="{{ asset('storage/' . $complaint->image) }}" class="w-full h-20 rounded-xl object-cover border border-gray-200">
                                </div>
                            @endif
                            @if($complaint->status === 'selesai' && $complaint->resolved_image)
                                <div>
                                    <p class="text-[10px] text-emerald-600 font-bold uppercase mb-1">Bukti Perbaikan</p>
                                    <img src="{{ asset('storage/' . $complaint->resolved_image) }}" class="w-full h-20 rounded-xl object-cover border-2 border-emerald-400">
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                @empty
                    <p class="ml-8 text-gray-400 italic">Belum ada riwayat pengaduan.</p>
                @endforelse
            </div>

            <a href="{{ route('complaints.create') }}" class="fixed bottom-8 right-8 bg-[#0A4D40] text-white w-14 h-14 rounded-full flex items-center justify-center shadow-lg hover:bg-[#06382e] transition-transform hover:scale-105">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            </a>
        </div>
    </div>
</x-app-layout>