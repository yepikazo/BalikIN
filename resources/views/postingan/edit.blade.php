<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <a href="{{ route('postingan.show', $postingan) }}" class="text-gray-400 hover:text-gray-600 transition">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
            </a>
            <h2 class="text-xl font-bold text-gray-800">✏️ Edit Postingan</h2>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">

                <div class="bg-gradient-to-r from-amber-500 to-orange-500 px-6 py-5">
                    <p class="text-white/90 text-sm">Perbarui informasi postingan barang Anda di bawah ini.</p>
                </div>

                <form method="POST" action="{{ route('postingan.update', $postingan) }}"
                      enctype="multipart/form-data" class="p-6 space-y-6">
                    @csrf @method('PUT')

                    {{-- Jenis --}}
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Jenis Postingan <span class="text-red-500">*</span></label>
                        <div class="grid grid-cols-2 gap-3">
                            <label class="relative cursor-pointer">
                                <input type="radio" name="jenis" value="barangHilang" class="peer sr-only"
                                       {{ old('jenis', $postingan->jenis) === 'barangHilang' ? 'checked' : '' }}>
                                <div class="flex items-center gap-3 border-2 border-gray-200 rounded-xl px-4 py-3 transition
                                            peer-checked:border-red-400 peer-checked:bg-red-50">
                                    <span class="text-2xl">🔴</span>
                                    <div>
                                        <p class="font-semibold text-sm text-gray-800">Barang Hilang</p>
                                        <p class="text-xs text-gray-500">Saya kehilangan barang</p>
                                    </div>
                                </div>
                            </label>
                            <label class="relative cursor-pointer">
                                <input type="radio" name="jenis" value="barangDitemukan" class="peer sr-only"
                                       {{ old('jenis', $postingan->jenis) === 'barangDitemukan' ? 'checked' : '' }}>
                                <div class="flex items-center gap-3 border-2 border-gray-200 rounded-xl px-4 py-3 transition
                                            peer-checked:border-green-400 peer-checked:bg-green-50">
                                    <span class="text-2xl">🟢</span>
                                    <div>
                                        <p class="font-semibold text-sm text-gray-800">Barang Ditemukan</p>
                                        <p class="text-xs text-gray-500">Saya menemukan barang</p>
                                    </div>
                                </div>
                            </label>
                        </div>
                        @error('jenis') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                    </div>

                    {{-- Nama & Kategori --}}
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label for="namaBarang" class="block text-sm font-semibold text-gray-700 mb-1.5">Nama Barang <span class="text-red-500">*</span></label>
                            <input type="text" id="namaBarang" name="namaBarang"
                                   value="{{ old('namaBarang', $postingan->namaBarang) }}"
                                   class="w-full text-sm border border-gray-200 rounded-lg px-3 py-2.5 focus:ring-2 focus:ring-amber-300 focus:border-amber-400 outline-none transition @error('namaBarang') border-red-400 @enderror">
                            @error('namaBarang') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label for="kategori" class="block text-sm font-semibold text-gray-700 mb-1.5">Kategori <span class="text-red-500">*</span></label>
                            <select id="kategori" name="kategori"
                                    class="w-full text-sm border border-gray-200 rounded-lg px-3 py-2.5 focus:ring-2 focus:ring-amber-300 focus:border-amber-400 outline-none bg-white transition @error('kategori') border-red-400 @enderror">
                                @foreach(['Elektronik','Dompet/Tas','Kunci','Dokumen','Perhiasan','Hewan','Lainnya'] as $kat)
                                    <option value="{{ $kat }}" {{ old('kategori', $postingan->kategori) === $kat ? 'selected' : '' }}>{{ $kat }}</option>
                                @endforeach
                            </select>
                            @error('kategori') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    {{-- Lokasi --}}
                    <div>
                        <label for="lokasi" class="block text-sm font-semibold text-gray-700 mb-1.5">Lokasi <span class="text-red-500">*</span></label>
                        <input type="text" id="lokasi" name="lokasi"
                               value="{{ old('lokasi', $postingan->lokasi) }}"
                               class="w-full text-sm border border-gray-200 rounded-lg px-3 py-2.5 focus:ring-2 focus:ring-amber-300 focus:border-amber-400 outline-none transition @error('lokasi') border-red-400 @enderror">
                        @error('lokasi') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                    </div>

                    {{-- Deskripsi --}}
                    <div>
                        <label for="deskripsi" class="block text-sm font-semibold text-gray-700 mb-1.5">Deskripsi <span class="text-red-500">*</span></label>
                        <textarea id="deskripsi" name="deskripsi" rows="4"
                                  class="w-full text-sm border border-gray-200 rounded-lg px-3 py-2.5 focus:ring-2 focus:ring-amber-300 focus:border-amber-400 outline-none resize-none transition @error('deskripsi') border-red-400 @enderror">{{ old('deskripsi', $postingan->deskripsi) }}</textarea>
                        @error('deskripsi') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                    </div>

                    {{-- Foto --}}
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">Foto Barang <span class="text-gray-400 font-normal">(opsional — kosongkan jika tidak diganti)</span></label>
                        @if ($postingan->foto)
                            <img src="{{ asset('storage/' . $postingan->foto) }}" alt="Foto saat ini"
                                 class="h-24 w-24 object-cover rounded-lg mb-2 border border-gray-200">
                        @endif
                        <label for="foto"
                               class="flex flex-col items-center justify-center w-full h-28 border-2 border-dashed border-gray-200 rounded-xl cursor-pointer hover:border-amber-400 hover:bg-amber-50/30 transition group">
                            <svg class="h-7 w-7 text-gray-300 group-hover:text-amber-400 mb-1 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            <p class="text-xs text-gray-400">Klik untuk ganti foto</p>
                            <input id="foto" name="foto" type="file" accept="image/*" class="sr-only">
                        </label>
                        <p id="foto-name" class="mt-1 text-xs text-gray-500"></p>
                        @error('foto') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                    </div>

                    {{-- Kontak --}}
                    <div class="bg-gray-50 rounded-xl p-4 space-y-4">
                        <p class="text-sm font-semibold text-gray-700">📞 Informasi Kontak</p>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label for="namaKontak" class="block text-xs font-medium text-gray-600 mb-1.5">Nama Kontak <span class="text-red-500">*</span></label>
                                <input type="text" id="namaKontak" name="namaKontak"
                                       value="{{ old('namaKontak', $postingan->namaKontak) }}"
                                       class="w-full text-sm border border-gray-200 rounded-lg px-3 py-2.5 focus:ring-2 focus:ring-amber-300 outline-none bg-white transition @error('namaKontak') border-red-400 @enderror">
                                @error('namaKontak') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label for="noKontak" class="block text-xs font-medium text-gray-600 mb-1.5">Nomor WA / HP <span class="text-red-500">*</span></label>
                                <input type="text" id="noKontak" name="noKontak"
                                       value="{{ old('noKontak', $postingan->noKontak) }}"
                                       class="w-full text-sm border border-gray-200 rounded-lg px-3 py-2.5 focus:ring-2 focus:ring-amber-300 outline-none bg-white transition @error('noKontak') border-red-400 @enderror">
                                @error('noKontak') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center justify-end gap-3 pt-2">
                        <a href="{{ route('postingan.show', $postingan) }}"
                           class="text-sm text-gray-500 hover:text-gray-700 px-4 py-2.5 rounded-lg border border-gray-200 transition">
                            Batal
                        </a>
                        <button type="submit"
                                class="bg-amber-500 hover:bg-amber-600 text-white text-sm font-semibold px-6 py-2.5 rounded-lg shadow transition">
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('foto').addEventListener('change', function () {
            const n = this.files[0] ? this.files[0].name : '';
            document.getElementById('foto-name').textContent = n ? `✅ File baru: ${n}` : '';
        });
    </script>
</x-app-layout>
