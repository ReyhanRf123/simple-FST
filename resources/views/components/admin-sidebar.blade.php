<div class="w-72 bg-white border-r border-gray-100 hidden md:flex flex-col justify-between py-8 shadow-[4px_0_24px_rgba(0,0,0,0.02)] z-10 shrink-0">
    <div>
        <div class="px-8 mb-12 flex items-center gap-4">
            <div class="w-12 h-12 bg-[#0A4D40] rounded-2xl flex items-center justify-center text-white font-bold shadow-lg shadow-[#0A4D40]/20">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
            </div>
            <div>
                <h2 class="text-xl font-black text-[#0A4D40] leading-tight tracking-tight">Fasilitas<br>Kampus</h2>
            </div>
        </div>

        <nav class="px-4 space-y-2">
            <a href="{{ route('admin.dashboard') }}" class="group flex items-center gap-4 px-4 py-3.5 {{ request()->routeIs('admin.dashboard') ? 'bg-[#6EE7B7]/20 text-[#0A4D40]' : 'text-gray-500 hover:bg-gray-50 hover:text-[#0A4D40]' }} font-bold rounded-2xl transition-all relative overflow-hidden">
                @if(request()->routeIs('admin.dashboard'))
                    <div class="absolute left-0 top-0 bottom-0 w-1.5 bg-[#0A4D40] rounded-r-full"></div>
                @endif
                <svg class="w-5 h-5 {{ request()->routeIs('admin.dashboard') ? 'text-[#0A4D40]' : 'text-gray-400 group-hover:text-[#0A4D40]' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                Daftar Antrean
            </a>

            <a href="{{ route('admin.facilities') }}" class="group flex items-center gap-4 px-4 py-3.5 {{ request()->routeIs('admin.facilities') ? 'bg-[#6EE7B7]/20 text-[#0A4D40]' : 'text-gray-500 hover:bg-gray-50 hover:text-[#0A4D40]' }} font-bold rounded-2xl transition-all relative overflow-hidden">
                @if(request()->routeIs('admin.facilities'))
                    <div class="absolute left-0 top-0 bottom-0 w-1.5 bg-[#0A4D40] rounded-r-full"></div>
                @endif
                <svg class="w-5 h-5 {{ request()->routeIs('admin.facilities') ? 'text-[#0A4D40]' : 'text-gray-400 group-hover:text-[#0A4D40]' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                Master Fasilitas
            </a>

            <a href="{{ route('admin.reports') }}" class="group flex items-center gap-4 px-4 py-3.5 {{ request()->routeIs('admin.reports') ? 'bg-[#6EE7B7]/20 text-[#0A4D40]' : 'text-gray-500 hover:bg-gray-50 hover:text-[#0A4D40]' }} font-bold rounded-2xl transition-all relative overflow-hidden">
                @if(request()->routeIs('admin.reports'))
                    <div class="absolute left-0 top-0 bottom-0 w-1.5 bg-[#0A4D40] rounded-r-full"></div>
                @endif
                <svg class="w-5 h-5 {{ request()->routeIs('admin.reports') ? 'text-[#0A4D40]' : 'text-gray-400 group-hover:text-[#0A4D40]' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                Rekap Laporan
            </a>
        </nav>
    </div>

    <div class="px-6 fixed bottom-0 left-0">
        <div class="p-4 bg-gray-50 rounded-2xl flex items-center gap-3 mb-4 border border-gray-100">
            <div class="w-10 h-10 rounded-full bg-[#0A4D40] text-white flex items-center justify-center font-bold text-lg shadow-inner">
                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
            </div>
            <div class="overflow-hidden flex-1">
                <p class="text-sm font-bold text-gray-900 truncate">{{ Auth::user()->name }}</p>
                <p class="text-[10px] text-emerald-600 font-black uppercase tracking-wider">{{ Auth::user()->role }}</p>
            </div>
        </div>
        <livewire:admin.logout-button />
    </div>
</div>