<x-app-layout>
    <div class="min-h-screen bg-[#FAFAFA] flex flex-col md:flex-row font-sans overflow-hidden">
        
        <div class="w-64 bg-[#FAFAFA] border-r border-gray-100 hidden md:flex flex-col py-8">
            <div class="px-8 mb-12 flex items-center gap-3">
                <div class="w-10 h-10 bg-[#0A4D40] rounded-full flex items-center justify-center text-white font-bold">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                </div>
                <div>
                    <h2 class="text-xl font-bold text-[#0A4D40] leading-tight">Fasilitas<br>Kampus</h2>
                    <p class="text-[9px] text-gray-500 tracking-widest uppercase">Sistem Pengaduan</p>
                </div>
            </div>
            <nav class="flex-1 px-4 space-y-2">
                <a href="#" class="flex items-center gap-3 px-4 py-3 bg-[#6EE7B7] text-[#0A4D40] font-bold rounded-2xl shadow-sm">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                    Dashboard
                </a>
            </nav>
        </div>

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
                        $colorGroup = $complaint->priority_score >= 6 ? 'rose' : ($complaint->priority_score >= 3 ? 'amber' : 'black');
                        $urgencyText = $complaint->priority_score >= 6 ? 'URGENT' : ($complaint->priority_score >= 3 ? 'MEDIUM' : 'LOW');
                    @endphp

                    <div class="bg-white rounded-[2rem] shadow-sm border border-gray-100 p-2 pr-6 flex flex-col md:flex-row items-center gap-6 relative overflow-visible transition hover:shadow-md">
                        
                        <div class="absolute left-0 top-0 bottom-0 w-2 bg-{{$colorGroup}}-600 rounded-l-[2rem]"></div>

                        <div class="ml-4 w-24 h-24 bg-{{$colorGroup}}-50 rounded-3xl flex flex-col items-center justify-center shrink-0">
                            <span class="text-3xl font-black text-{{$colorGroup}}-600">{{ $complaint->priority_score }}</span>
                            <span class="text-[9px] font-bold text-white bg-{{$colorGroup}}-600 px-2 py-0.5 rounded-full mt-1 uppercase">{{ $urgencyText }}</span>
                        </div>

                        <div class="flex-1 py-2">
                            <h3 class="text-xl font-bold text-gray-900">{{ $complaint->facility->facility_name }}</h3>
                            <p class="text-xs text-gray-600 line-clamp-1 mt-1">{{ $complaint->description }}</p>
                            <div class="flex items-center gap-4 text-xs text-gray-500 mt-3 font-medium">
                                <span class="flex items-center gap-1"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg> {{ $complaint->user->name }}</span>
                                <span class="flex items-center gap-1"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg> {{ $complaint->location }}</span>
                                <span class="flex items-center gap-1"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg> {{ $complaint->created_at->diffForHumans() }}</span>
                            </div>
                        </div>

                        <div class="flex gap-2 shrink-0">
                            @if($complaint->image)
                                <img src="{{ asset('storage/' . $complaint->image) }}" class="w-16 h-16 rounded-xl object-cover border border-gray-200 shadow-sm" alt="Bukti">
                            @endif
                            @if($complaint->status === 'selesai' && $complaint->resolved_image)
                                <img src="{{ asset('storage/' . $complaint->resolved_image) }}" class="w-16 h-16 rounded-xl object-cover border-2 border-emerald-400 shadow-sm" alt="Selesai">
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

                                <div x-show="status === 'selesai' && '{{$complaint->status}}' !== 'selesai'" class="mt-2 space-y-2">
                                    <input type="file" name="resolved_image" class="w-full text-[9px] file:py-1 file:px-2 file:border-0 file:rounded-full file:bg-emerald-100 file:text-emerald-700" required>
                                    <input type="text" name="catatan_teknisi" placeholder="Catatan perbaikan..." class="w-full text-[10px] rounded-lg border-gray-200 px-2 py-1">
                                    <button type="submit" class="w-full bg-[#0A4D40] text-white text-[10px] font-bold py-1.5 rounded-full">Kirim Bukti</button>
                                </div>

                                <div x-show="status !== 'selesai' && status !== '{{$complaint->status}}'" class="mt-2">
                                    <button type="submit" class="w-full bg-[#0A4D40] text-white text-[10px] font-bold py-1.5 rounded-full hover:bg-emerald-800 transition">Update Status</button>
                                </div>
                            </form>
                        </div>
                        
                    </div>
                @endforeach
            </div>

            <div class="mt-8">
                {{ $complaints->links() }}
            </div>
        </div>
    </div>
</x-app-layout>