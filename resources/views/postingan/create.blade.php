<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <a href="{{ route('postingan.index') }}"
               class="text-gray-400 hover:text-gray-600 transition">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
            </a>
            <h2 class="text-xl font-bold text-gray-800 leading-tight">
                📝 Buat Postingan Baru
            </h2>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">

                {{-- Header card --}}
                <div class="bg-gradient-to-r from-indigo-600 to-violet-600 px-6 py-5">
                    <p class="text-white/90 text-sm">
                        Isi formulir di bawah ini untuk melaporkan barang yang hilang atau yang Anda temukan di area publik.
                    </p>
                </div>

                <form method="POST"
                      action="{{ route('postingan.store') }}"
                      enctype="multipart/form-data"
                      class="p-6 space-y-6">
                    @csrf

                    {{-- Jenis Postingan --}}
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Jenis Postingan <span class="text-red-500">*</span>
                        </label>
                        <div class="grid grid-cols-2 gap-3">
                            <label class="relative cursor-pointer">
                                <input type="radio" name="jenis" value="barangHilang"
                                       class="peer sr-only"
                                       {{ old('jenis', 'barangHilang') === 'barangHilang' ? 'checked' : '' }}>
                                <div class="flex items-center gap-3 border-2 border-gray-200 rounded-xl px-4 py-3 transition
                                            peer-checked:border-red-400 peer-checked:bg-red-50 hover:border-gray-300">
                                    <span class="text-2xl">🔴</span>
                                    <div>
                                        <p class="font-semibold text-sm text-gray-800">Barang Hilang</p>
                                        <p class="text-xs text-gray-500">Saya kehilangan barang</p>
                                    </div>
                                </div>
                            </label>
                            <label class="relative cursor-pointer">
                                <input type="radio" name="jenis" value="barangDitemukan"
                                       class="peer sr-only"
                                       {{ old('jenis') === 'barangDitemukan' ? 'checked' : '' }}>
                                <div class="flex items-center gap-3 border-2 border-gray-200 rounded-xl px-4 py-3 transition
                                            peer-checked:border-green-400 peer-checked:bg-green-50 hover:border-gray-300">
                                    <span class="text-2xl">🟢</span>
                                    <div>
                                        <p class="font-semibold text-sm text-gray-800">Barang Ditemukan</p>
                                        <p class="text-xs text-gray-500">Saya menemukan barang</p>
                                    </div>
                                </div>
                            </label>
                        </div>
                        @error('jenis')
                            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Nama Barang & Kategori --}}
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label for="namaBarang" class="block text-sm font-semibold text-gray-700 mb-1.5">
                                Nama Barang <span class="text-red-500">*</span>
                            </label>
                            <input type="text" id="namaBarang" name="namaBarang"
                                   value="{{ old('namaBarang') }}"
                                   placeholder="Contoh: Dompet Kulit Hitam"
                                   class="w-full text-sm border border-gray-200 rounded-lg px-3 py-2.5 focus:ring-2 focus:ring-indigo-300 focus:border-indigo-400 outline-none transition @error('namaBarang') border-red-400 @enderror">
                            @error('namaBarang')
                                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="kategori" class="block text-sm font-semibold text-gray-700 mb-1.5">
                                Kategori <span class="text-red-500">*</span>
                            </label>
                            <select id="kategori" name="kategori"
                                    class="w-full text-sm border border-gray-200 rounded-lg px-3 py-2.5 focus:ring-2 focus:ring-indigo-300 focus:border-indigo-400 outline-none transition bg-white @error('kategori') border-red-400 @enderror">
                                <option value="">Pilih Kategori</option>
                                @foreach(['Elektronik','Dompet/Tas','Kunci','Dokumen','Perhiasan','Hewan','Lainnya'] as $kat)
                                    <option value="{{ $kat }}" {{ old('kategori') === $kat ? 'selected' : '' }}>
                                        {{ $kat }}
                                    </option>
                                @endforeach
                            </select>
                            @error('kategori')
                                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    {{-- Lokasi --}}
                    <div>
                        <label for="lokasi" class="block text-sm font-semibold text-gray-700 mb-1.5">
                            Lokasi <span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="lokasi" name="lokasi"
                               value="{{ old('lokasi') }}"
                               placeholder="Contoh: Halte Bus Blok M, Jakarta Selatan"
                               class="w-full text-sm border border-gray-200 rounded-lg px-3 py-2.5 focus:ring-2 focus:ring-indigo-300 focus:border-indigo-400 outline-none transition @error('lokasi') border-red-400 @enderror">
                        @error('lokasi')
                            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Deskripsi --}}
                    <div>
                        <label for="deskripsi" class="block text-sm font-semibold text-gray-700 mb-1.5">
                            Deskripsi <span class="text-red-500">*</span>
                        </label>
                        <textarea id="deskripsi" name="deskripsi" rows="4"
                                  placeholder="Jelaskan ciri-ciri barang secara detail (warna, ukuran, merek, kondisi, dsb)..."
                                  class="w-full text-sm border border-gray-200 rounded-lg px-3 py-2.5 focus:ring-2 focus:ring-indigo-300 focus:border-indigo-400 outline-none transition resize-none @error('deskripsi') border-red-400 @enderror">{{ old('deskripsi') }}</textarea>
                        @error('deskripsi')
                            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Upload Foto --}}
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">
                            Foto Barang <span class="text-gray-400 font-normal">(opsional)</span>
                        </label>
                        <label for="foto"
                               class="flex flex-col items-center justify-center w-full h-36 border-2 border-dashed border-gray-200 rounded-xl cursor-pointer hover:border-indigo-400 hover:bg-indigo-50/30 transition group">
                            <svg class="h-8 w-8 text-gray-300 group-hover:text-indigo-400 transition mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            <p class="text-xs text-gray-400 group-hover:text-indigo-500">Klik untuk unggah foto</p>
                            <p class="text-xs text-gray-300 mt-1">JPG, PNG, WebP — maks. 2MB</p>
                            <input id="foto" name="foto" type="file" accept="image/*" class="sr-only">
                        </label>
                        <p id="foto-name" class="mt-1 text-xs text-gray-500"></p>
                        @error('foto')
                            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Informasi Kontak --}}
                    <div class="bg-gray-50 rounded-xl p-4 space-y-4">
                        <p class="text-sm font-semibold text-gray-700">📞 Informasi Kontak</p>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label for="namaKontak" class="block text-xs font-medium text-gray-600 mb-1.5">
                                    Nama Kontak <span class="text-red-500">*</span>
                                </label>
                                <input type="text" id="namaKontak" name="namaKontak"
                                       value="{{ old('namaKontak', auth()->user()->name) }}"
                                       placeholder="Nama lengkap Anda"
                                       class="w-full text-sm border border-gray-200 rounded-lg px-3 py-2.5 focus:ring-2 focus:ring-indigo-300 focus:border-indigo-400 outline-none transition bg-white @error('namaKontak') border-red-400 @enderror">
                                @error('namaKontak')
                                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="noKontak" class="block text-xs font-medium text-gray-600 mb-1.5">
                                    Nomor WhatsApp / HP <span class="text-red-500">*</span>
                                </label>
                                <input type="text" id="noKontak" name="noKontak"
                                       value="{{ old('noKontak') }}"
                                       placeholder="Contoh: 08123456789"
                                       class="w-full text-sm border border-gray-200 rounded-lg px-3 py-2.5 focus:ring-2 focus:ring-indigo-300 focus:border-indigo-400 outline-none transition bg-white @error('noKontak') border-red-400 @enderror">
                                @error('noKontak')
                                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    {{-- Submit --}}
                    <div class="flex items-center justify-end gap-3 pt-2">
                        <a href="{{ route('postingan.index') }}"
                           class="text-sm text-gray-500 hover:text-gray-700 px-4 py-2.5 rounded-lg border border-gray-200 hover:border-gray-300 transition">
                            Batal
                        </a>
                        <button type="submit"
                                class="bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold px-6 py-2.5 rounded-lg shadow transition">
                            Publikasikan Postingan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Preview nama file yang dipilih
        document.getElementById('foto').addEventListener('change', function () {
            const name = this.files[0] ? this.files[0].name : '';
            document.getElementById('foto-name').textContent = name ? `✅ File dipilih: ${name}` : '';
        });
    </script>
</x-app-layout>
