<x-app-layout>
    <div x-data="{ openModal: false, modalImgUrl: '', modalImgTitle: '' }" class="min-h-screen bg-[#FAFAFA] pt-8 pb-12 font-sans">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <h2 class="text-2xl font-bold text-[#0A4D40] mb-8 mt-12">Riwayat Pengaduan</h2>
            
            <div class="relative border-l-2 border-gray-200 ml-4 space-y-8">
                @forelse($complaints as $complaint)
                <div class="relative ml-8">
                    <div class="absolute -left-[41px] top-4 w-5 h-5 rounded-full bg-emerald-500 border-4 border-[#FAFAFA]"></div>
                    <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-100 flex flex-col md:flex-row gap-6">
                        
                        <div class="flex-1">
                            <div class="flex justify-between items-start mb-3">
                                <p class="text-xs text-gray-400 font-medium">{{ $complaint->created_at->format('d M Y, H:i') }}</p>
                                <span class="px-4 py-1 text-[10px] font-bold rounded-full {{ $complaint->status == 'menunggu' ? 'bg-amber-100 text-amber-700' : ($complaint->status == 'diproses' ? 'bg-blue-100 text-blue-700' : 'bg-emerald-100 text-emerald-700') }} uppercase tracking-wider">{{ $complaint->status }}</span>
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
                                    <img @click="openModal = true; modalImgUrl = '{{ asset('storage/' . $complaint->image) }}'; modalImgTitle = 'Bukti Kerusakan: {{ $complaint->facility->facility_name }}'" 
                                         src="{{ asset('storage/' . $complaint->image) }}" 
                                         class="w-full h-20 rounded-xl object-cover border border-gray-200 cursor-pointer hover:opacity-75 transition-opacity duration-200 shadow-sm">
                                </div>
                            @endif
                            @if($complaint->status === 'selesai' && $complaint->resolved_image)
                                <div>
                                    <p class="text-[10px] text-emerald-600 font-bold uppercase mb-1">Bukti Perbaikan</p>
                                    <img @click="openModal = true; modalImgUrl = '{{ asset('storage/' . $complaint->resolved_image) }}'; modalImgTitle = 'Bukti Perbaikan: {{ $complaint->facility->facility_name }}'" 
                                         src="{{ asset('storage/' . $complaint->resolved_image) }}" 
                                         class="w-full h-20 rounded-xl object-cover border-2 border-emerald-400 cursor-pointer hover:opacity-75 transition-opacity duration-200 shadow-sm">
                                </div>
                            @endif
                        </div>

                    </div>
                </div>
                @empty
                    <p class="ml-8 text-gray-400 italic">Belum ada riwayat pengaduan.</p>
                @endforelse
            </div>

            </div>

        <div x-show="openModal" style="display: none;" class="fixed inset-0 z-[99] flex items-center justify-center bg-black bg-opacity-80 backdrop-blur-sm p-4 transition-opacity">
            <div @click.away="openModal = false" class="relative max-w-4xl w-full flex flex-col items-center">
                <button @click="openModal = false" class="absolute -top-12 right-0 text-white hover:text-emerald-400 transition-colors">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
                
                <img :src="modalImgUrl" class="max-w-full max-h-[80vh] rounded-2xl shadow-2xl object-contain border-4 border-white/10">
                
                <p x-text="modalImgTitle" class="mt-4 text-white font-semibold text-lg tracking-wide"></p>
            </div>
        </div>
        
    </div>
</x-app-layout>