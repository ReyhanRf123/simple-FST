<x-app-layout>
    <div class="min-h-screen bg-[#FAFAFA] py-10 px-4 sm:px-6 font-sans flex items-center justify-center">
        
        <div class="w-full max-w-3xl bg-white rounded-[2rem] shadow-xl shadow-gray-200/40 border border-gray-100 overflow-hidden relative">
            
            <div class="px-8 py-6 border-b border-gray-100 flex justify-between items-start bg-white sticky top-0 z-10">
                <div>
                    <h2 class="text-3xl font-bold text-gray-900 tracking-tight">Buat Laporan Baru</h2>
                    <p class="text-sm text-gray-500 mt-2">Detailkan masalah yang Anda temui untuk segera kami tindaklanjuti.</p>
                </div>
                <a href="{{ route('dashboard') }}" class="p-2 bg-gray-50 text-gray-400 hover:text-rose-500 hover:bg-rose-50 rounded-full transition-all">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </a>
            </div>

            <div class="p-8" x-data="{ deskripsi: '{{ old('description') }}' }">
                
                @if(session('success'))
                    <div class="mb-8 bg-emerald-50 border border-emerald-100 text-emerald-700 px-5 py-4 rounded-2xl flex items-center gap-3">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        <span class="font-semibold">{{ session('success') }}</span>
                    </div>
                @endif

                <form action="{{ route('complaints.store') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
                    @csrf

                    <div class="space-y-6 bg-gray-50/50 p-6 rounded-3xl border border-gray-50">
                        <div>
                            <label for="facility_id" class="block text-sm font-bold text-gray-700 mb-2">Kategori Fasilitas</label>
                            <select name="facility_id" id="facility_id" required class="w-full rounded-2xl border-gray-200 bg-white focus:border-[#0A4D40] focus:ring-[#0A4D40] shadow-sm py-3 px-4 text-gray-700">
                                <option value="" disabled selected>-- Pilih fasilitas yang bermasalah --</option>
                                @foreach($facilities as $facility)
                                    <option value="{{ $facility->id }}" {{ old('facility_id') == $facility->id ? 'selected' : '' }}>{{ $facility->facility_name }}</option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('facility_id')" class="mt-2 text-rose-500 text-xs" />
                        </div>

                        <div>
                            <label for="location" class="block text-sm font-bold text-gray-700 mb-2">Lokasi Spesifik</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                </div>
                                <input type="text" name="location" id="location" placeholder="Contoh: Gedung A, Lantai 3, Ruang 301" required value="{{ old('location') }}" class="pl-11 w-full rounded-2xl border-gray-200 bg-white focus:border-[#0A4D40] focus:ring-[#0A4D40] shadow-sm py-3 px-4 text-gray-700">
                            </div>
                            <x-input-error :messages="$errors->get('location')" class="mt-2 text-rose-500 text-xs" />
                        </div>
                    </div>

                    <div>
                        <div class="flex justify-between items-end mb-2">
                            <label for="description" class="block text-sm font-bold text-gray-700">Deskripsi Kerusakan</label>
                        </div>
                        <textarea name="description" id="description" x-model="deskripsi" rows="4" placeholder="Jelaskan secara detail masalah yang terjadi..." required class="w-full rounded-2xl border-gray-200 bg-white focus:border-[#0A4D40] focus:ring-[#0A4D40] shadow-sm py-4 px-4 text-gray-700"></textarea>
                        
                        <div class="flex sm:hidden overflow-x-auto gap-2 mt-3 pb-1 hide-scrollbar">
                            <button type="button" @click="deskripsi = deskripsi ? deskripsi + ', Mati Total' : 'Mati Total'" class="shrink-0 px-3 py-1.5 bg-gray-100 text-gray-600 text-xs font-semibold rounded-full hover:bg-gray-200">Mati Total</button>
                            <button type="button" @click="deskripsi = deskripsi ? deskripsi + ', Bocor' : 'Bocor'" class="shrink-0 px-3 py-1.5 bg-gray-100 text-gray-600 text-xs font-semibold rounded-full hover:bg-gray-200">Bocor</button>
                            <button type="button" @click="deskripsi = deskripsi ? deskripsi + ', Rusak Fisik' : 'Rusak Fisik'" class="shrink-0 px-3 py-1.5 bg-gray-100 text-gray-600 text-xs font-semibold rounded-full hover:bg-gray-200">Rusak Fisik</button>
                        </div>
                        
                        <x-input-error :messages="$errors->get('description')" class="mt-2 text-rose-500 text-xs" />
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">            
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-3">Tingkat Kerusakan</label>
                            <div class="flex flex-col gap-3">
                                <label class="cursor-pointer relative">
                                    <input type="radio" name="severity_level" value="ringan" class="peer sr-only" required {{ old('severity_level') == 'ringan' ? 'checked' : '' }}>
                                    <div class="px-5 py-4 rounded-2xl border-2 border-gray-100 text-sm font-bold text-gray-500 peer-checked:border-[#0A4D40] peer-checked:bg-[#0A4D40]/5 peer-checked:text-[#0A4D40] hover:bg-gray-50 transition-all flex items-center justify-between">
                                        Ringan / Kosmetik
                                        <svg class="w-5 h-5 opacity-0 peer-checked:opacity-100 transition-opacity" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                                    </div>
                                </label>
                                <label class="cursor-pointer relative">
                                    <input type="radio" name="severity_level" value="sedang" class="peer sr-only" {{ old('severity_level') == 'sedang' ? 'checked' : '' }}>
                                    <div class="px-5 py-4 rounded-2xl border-2 border-gray-100 text-sm font-bold text-gray-500 peer-checked:border-amber-500 peer-checked:bg-amber-50 peer-checked:text-amber-700 hover:bg-gray-50 transition-all flex items-center justify-between">
                                        Sedang / Mengganggu
                                        <svg class="w-5 h-5 opacity-0 peer-checked:opacity-100 transition-opacity" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                                    </div>
                                </label>
                                <label class="cursor-pointer relative">
                                    <input type="radio" name="severity_level" value="kritis" class="peer sr-only" {{ old('severity_level') == 'kritis' ? 'checked' : '' }}>
                                    <div class="px-5 py-4 rounded-2xl border-2 border-gray-100 text-sm font-bold text-gray-500 peer-checked:border-rose-500 peer-checked:bg-rose-50 peer-checked:text-rose-700 hover:bg-gray-50 transition-all flex items-center justify-between">
                                        Kritis / Mati Total
                                        <svg class="w-5 h-5 opacity-0 peer-checked:opacity-100 transition-opacity" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                                    </div>
                                </label>
                            </div>
                            <x-input-error :messages="$errors->get('severity_level')" class="mt-2 text-rose-500 text-xs" />
                        </div>
                        <div class="flex flex-col h-full">
                            <label for="image" class="block text-sm font-bold text-gray-700 mb-3">Upload Bukti Foto <span class="text-gray-400 font-normal ml-1">(Opsional)</span></label>
                            
                            <div id="dropZone" class="flex-1 w-full relative border-2 border-dashed border-gray-200 bg-gray-50 hover:bg-gray-100 hover:border-[#0A4D40]/50 rounded-2xl transition-all flex flex-col items-center justify-center p-6 text-center cursor-pointer overflow-hidden group">
                                
                                <input type="file" name="image" id="image" accept="image/jpeg,image/png,image/jpg" 
                                    class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-20"
                                    onchange="
                                        if(this.files && this.files.length > 0) {
                                            document.getElementById('state-empty').style.display = 'none';
                                            document.getElementById('state-filled').style.display = 'flex';
                                            document.getElementById('file-name-display').innerText = this.files[0].name;
                                            document.getElementById('dropZone').classList.add('border-[#0A4D40]', 'bg-[#0A4D40]/5');
                                        } else {
                                            document.getElementById('state-empty').style.display = 'flex';
                                            document.getElementById('state-filled').style.display = 'none';
                                            document.getElementById('dropZone').classList.remove('border-[#0A4D40]', 'bg-[#0A4D40]/5');
                                        }
                                    ">
                                
                                <div id="state-empty" class="flex flex-col items-center justify-center pointer-events-none">
                                    <svg class="w-10 h-10 text-gray-300 group-hover:text-[#0A4D40] transition-colors mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                                    <p class="text-sm font-bold text-gray-700 group-hover:text-[#0A4D40] transition-colors">Klik atau Seret Foto Kesini</p>
                                    <p class="text-[10px] text-gray-400 mt-1 uppercase tracking-wider">JPG, PNG (Maks. 2MB)</p>
                                </div>

                                <div id="state-filled" style="display: none;" class="flex-col items-center justify-center w-full h-full pointer-events-none z-10">
                                    <div class="w-16 h-16 bg-white rounded-full shadow-sm flex items-center justify-center mb-4 border border-emerald-100">
                                        <svg class="w-8 h-8 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    </div>
                                    
                                    <div class="bg-white px-4 py-2 rounded-full shadow-sm border border-gray-200 flex items-center gap-2 max-w-[90%]">
                                        <svg class="w-4 h-4 text-emerald-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"></path></svg>
                                        <span id="file-name-display" class="text-xs font-bold text-gray-700 truncate"></span>
                                    </div>
                                    
                                    <p class="text-[10px] text-[#0A4D40] font-bold mt-3">Klik area ini untuk mengganti file</p>
                                </div>
                            </div>
                            <x-input-error :messages="$errors->get('image')" class="mt-2 text-rose-500 text-xs" />
                        </div>
                    </div>

                    <div class="pt-8 mt-4 flex flex-col sm:flex-row items-center justify-between gap-4 border-t border-gray-100">
                        <a href="{{ route('dashboard') }}" class="w-full sm:w-auto px-6 py-3.5 text-sm font-bold text-gray-500 hover:text-gray-800 hover:bg-gray-100 rounded-full transition-colors text-center">
                            Batalkan
                        </a>
                        <button type="submit" class="w-full sm:w-auto px-8 py-3.5 bg-[#0A4D40] text-white text-sm font-bold rounded-full shadow-lg shadow-[#0A4D40]/20 hover:bg-[#06382e] hover:-translate-y-0.5 transition-all flex items-center justify-center gap-2">
                            Kirim Pengaduan
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                        </button>
                    </div>

                </form>
            </div>
        </div>

    </div>
</x-app-layout>