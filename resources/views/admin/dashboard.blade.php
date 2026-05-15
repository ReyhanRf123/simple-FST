<x-app-layout>
    <div x-data="{ openModal: false, modalImgUrl: '', modalImgTitle: '' }" class="min-h-screen bg-[#FAFAFA] flex flex-col md:flex-row font-sans overflow-hidden">
        
        <x-admin-sidebar />
        
        <div class="flex-1 p-8 overflow-y-auto">
            <div class="mb-10 flex justify-between items-end">
                <div>
                    <h1 class="text-4xl font-bold text-[#0A4D40]">Daftar Tunggu Prioritas</h1>
                    <p class="text-gray-500 mt-2">Kelola dan prioritaskan keluhan fasilitas secara efisien.</p>
                </div>
            </div>

            <div class="space-y-6">
                @foreach($complaints as $complaint)
                    @php
                        $isUrgent = $complaint->priority_score >= 6;
                        $isMedium = $complaint->priority_score >= 3 && $complaint->priority_score < 6;
                        
                        $borderClass = $isUrgent ? 'bg-rose-600' : ($isMedium ? 'bg-amber-500' : 'bg-gray-500');
                        $boxBgClass = $isUrgent ? 'bg-rose-50' : ($isMedium ? 'bg-amber-50' : 'bg-gray-50');
                        $textClass = $isUrgent ? 'text-rose-600' : ($isMedium ? 'text-amber-600' : 'text-gray-600');
                        $urgencyText = $isUrgent ? 'URGENT' : ($isMedium ? 'MEDIUM' : 'LOW');
                    @endphp

                    <div class="bg-white rounded-[2rem] shadow-sm border border-gray-100 p-2 pr-6 flex flex-col md:flex-row items-center gap-6 relative overflow-visible transition hover:shadow-md">
                        
                        <div class="absolute left-0 top-0 bottom-0 w-2 {{ $borderClass }} rounded-l-[2rem]"></div>

                        <div class="ml-4 w-24 h-24 {{ $boxBgClass }} rounded-3xl flex flex-col items-center justify-center shrink-0">
                            <span class="text-3xl font-black {{ $textClass }}">{{ $complaint->priority_score }}</span>
                            <span class="text-[9px] font-bold text-white {{ $borderClass }} px-2 py-0.5 rounded-full mt-1 uppercase">{{ $urgencyText }}</span>
                        </div>

                        <div class="flex-1 py-2 w-full">
                            <h3 class="text-xl font-bold text-gray-900">{{ $complaint->facility->facility_name }}</h3>
                            <p class="text-xs text-gray-600 line-clamp-1 mt-1">{{ $complaint->description }}</p>
                            <div class="flex flex-wrap items-center gap-4 text-xs text-gray-500 mt-3 font-medium">
                                <span class="flex items-center gap-1"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg> {{ $complaint->user->name }}</span>
                                <span class="flex items-center gap-1"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg> {{ $complaint->location }}</span>
                                <span class="flex items-center gap-1"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg> {{ $complaint->created_at->diffForHumans() }}</span>
                            </div>
                        </div>

                        <div class="flex gap-2 shrink-0">
                            @if($complaint->image)
                                <img @click="openModal = true; modalImgUrl = '{{ asset('storage/' . $complaint->image) }}'; modalImgTitle = 'Bukti Laporan: {{ $complaint->facility->facility_name }}'" src="{{ asset('storage/' . $complaint->image) }}" class="w-16 h-16 rounded-xl object-cover border border-gray-200 shadow-sm cursor-pointer hover:opacity-75 transition-opacity" alt="Bukti">
                            @endif
                            @if($complaint->status === 'selesai' && $complaint->resolved_image)
                                <img @click="openModal = true; modalImgUrl = '{{ asset('storage/' . $complaint->resolved_image) }}'; modalImgTitle = 'Hasil Perbaikan: {{ $complaint->facility->facility_name }}'" src="{{ asset('storage/' . $complaint->resolved_image) }}" class="w-16 h-16 rounded-xl object-cover border-2 border-emerald-400 shadow-sm cursor-pointer hover:opacity-75 transition-opacity" alt="Selesai">
                            @endif
                        </div>

                        <div class="shrink-0 md:w-48 bg-gray-50 p-3 rounded-2xl border border-gray-100" x-data="{ status: '{{$complaint->status}}' }">
                            <form action="{{ route('complaints.updateStatus', $complaint->id) }}" method="POST" enctype="multipart/form-data">
                                @csrf @method('PATCH')
                                <select name="status" x-model="status" class="w-full text-xs font-bold rounded-full border-0 bg-white shadow-sm focus:ring-2 focus:ring-emerald-400 py-2 px-3 text-gray-700">
                                    <option value="menunggu">Menunggu</option>
                                    <option value="diproses">Proses</option>
                                    <option value="selesai">Selesai</option>
                                </select>

                                <div x-show="status === 'selesai' && '{{$complaint->status}}' !== 'selesai'" class="mt-2 space-y-2" style="display: none;">
                                    <input type="file" name="resolved_image" class="w-full text-[9px] file:py-1 file:px-2 file:border-0 file:rounded-full file:bg-emerald-100 file:text-emerald-700" :required="status === 'selesai'">
                                    <input type="text" name="catatan_teknisi" placeholder="Catatan perbaikan..." class="w-full text-[10px] rounded-lg border-gray-200 px-2 py-1">
                                    <button type="submit" class="w-full bg-[#0A4D40] text-white text-[10px] font-bold py-1.5 rounded-full">Kirim Bukti</button>
                                </div>

                                <div x-show="status !== 'selesai' && status !== '{{$complaint->status}}'" class="mt-2" style="display: none;">
                                    <button type="submit" class="w-full bg-[#0A4D40] text-white text-[10px] font-bold py-1.5 rounded-full hover:bg-emerald-800 transition">Update Status</button>
                                </div>
                            </form>
                        </div>

                        <div class="w-full px-6 pb-4">
                            <livewire:complaint-comments :complaint="$complaint" :key="'admin-comment-'.$complaint->id" />
                        </div>
                        
                    </div>
                @endforeach
            </div>

            <div class="mt-8">
                {{ $complaints->links() }}
            </div>
        </div>

        <div x-show="openModal" style="display: none;" class="fixed inset-0 z-[99] flex items-center justify-center bg-black bg-opacity-80 backdrop-blur-sm p-4 transition-opacity">
            <div @click.away="openModal = false" class="relative max-w-5xl w-full flex flex-col items-center">
                <button @click="openModal = false" class="absolute -top-12 right-0 text-white hover:text-emerald-400 transition-colors">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
                <img :src="modalImgUrl" class="max-w-full max-h-[85vh] rounded-2xl shadow-2xl object-contain border-4 border-white/10">
                <p x-text="modalImgTitle" class="mt-4 text-white font-bold text-xl tracking-wide"></p>
            </div>
        </div>

    </div>
</x-app-layout>