<x-app-layout>
    <div class="py-12 bg-[#fafaf9] min-h-screen">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            
            <div class="bg-white rounded-3xl shadow-sm border border-stone-200 overflow-hidden">
                <div class="px-8 py-6 border-b border-stone-100 flex justify-between items-center">
                    <div>
                        <h2 class="text-2xl font-bold text-gray-900">Buat Laporan Baru</h2>
                        <p class="text-sm text-gray-500 mt-1">Detailkan masalah yang Anda temui untuk segera kami tindaklanjuti.</p>
                    </div>
                    <a href="{{ route('dashboard') }}" class="text-gray-400 hover:text-gray-600 transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </a>
                </div>

                <div class="p-8">
                    @if(session('success'))
                        <div class="mb-6 bg-emerald-50 border border-emerald-200 text-emerald-700 px-4 py-3 rounded-xl">
                            {{ session('success') }}
                        </div>
                    @endif

                    <form action="{{ route('complaints.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                        @csrf

                        <div>
                            <label for="facility_id" class="block text-sm font-semibold text-gray-700 mb-2">Pilih Kategori Fasilitas</label>
                            <select name="facility_id" id="facility_id" required class="w-full rounded-xl border-stone-300 focus:border-[#064e3b] focus:ring-[#064e3b] shadow-sm">
                                <option value="" disabled selected>-- Pilih fasilitas yang bermasalah --</option>
                                @foreach($facilities as $facility)
                                    <option value="{{ $facility->id }}">{{ $facility->facility_name }}</option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('facility_id')" class="mt-2" />
                        </div>

                        <div>
                            <label for="location" class="block text-sm font-semibold text-gray-700 mb-2">Lokasi Spesifik</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                </div>
                                <input type="text" name="location" id="location" placeholder="Contoh: Gedung A, Lantai 3, Ruang 301" required value="{{ old('location') }}" class="pl-10 w-full rounded-xl border-stone-300 focus:border-[#064e3b] focus:ring-[#064e3b] shadow-sm">
                            </div>
                            <x-input-error :messages="$errors->get('location')" class="mt-2" />
                        </div>

                        <div>
                            <label for="description" class="block text-sm font-semibold text-gray-700 mb-2">Deskripsi Kerusakan</label>
                            <textarea name="description" id="description" rows="4" placeholder="Jelaskan secara detail masalah yang terjadi..." required class="w-full rounded-xl border-stone-300 focus:border-[#064e3b] focus:ring-[#064e3b] shadow-sm">{{ old('description') }}</textarea>
                            <x-input-error :messages="$errors->get('description')" class="mt-2" />
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Tingkat Kerusakan (Estimasi Anda)</label>
                            <div class="grid grid-cols-3 gap-4">
                                <label class="cursor-pointer">
                                    <input type="radio" name="severity_level" value="ringan" class="peer sr-only" required>
                                    <div class="text-center px-4 py-3 rounded-xl border border-stone-200 text-sm font-medium text-gray-600 peer-checked:border-[#064e3b] peer-checked:bg-teal-50 peer-checked:text-[#064e3b] hover:bg-stone-50 transition-colors">Ringan / Kosmetik</div>
                                </label>
                                <label class="cursor-pointer">
                                    <input type="radio" name="severity_level" value="sedang" class="peer sr-only">
                                    <div class="text-center px-4 py-3 rounded-xl border border-stone-200 text-sm font-medium text-gray-600 peer-checked:border-amber-500 peer-checked:bg-amber-50 peer-checked:text-amber-700 hover:bg-stone-50 transition-colors">Sedang / Mengganggu</div>
                                </label>
                                <label class="cursor-pointer">
                                    <input type="radio" name="severity_level" value="kritis" class="peer sr-only">
                                    <div class="text-center px-4 py-3 rounded-xl border border-stone-200 text-sm font-medium text-gray-600 peer-checked:border-rose-500 peer-checked:bg-rose-50 peer-checked:text-rose-700 hover:bg-stone-50 transition-colors">Kritis / Mati Total</div>
                                </label>
                            </div>
                            <x-input-error :messages="$errors->get('severity_level')" class="mt-2" />
                        </div>

                        <div>
                            <label for="image" class="block text-sm font-semibold text-gray-700 mb-2">Upload Bukti Foto <span class="text-gray-400 font-normal">(Opsional)</span></label>
                            <input type="file" name="image" id="image" accept="image/jpeg,image/png,image/jpg" class="w-full text-sm text-gray-500 file:mr-4 file:py-3 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-teal-50 file:text-[#064e3b] hover:file:bg-teal-100 transition-colors cursor-pointer border border-stone-200 rounded-xl p-1">
                            <p class="mt-1 text-xs text-gray-500">Maksimal 2MB. Format JPG, PNG.</p>
                            <x-input-error :messages="$errors->get('image')" class="mt-2" />
                        </div>

                        <div class="pt-6 flex items-center justify-end gap-4 border-t border-stone-100">
                            <a href="{{ route('dashboard') }}" class="text-sm font-medium text-gray-500 hover:text-gray-700 transition-colors">
                                Kembali
                            </a>
                            <button type="submit" class="px-6 py-3 bg-[#064e3b] text-white text-sm font-semibold rounded-xl shadow-sm hover:bg-teal-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#064e3b] transition-all">
                                Kirim Pengaduan →
                            </button>
                        </div>

                    </form>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>