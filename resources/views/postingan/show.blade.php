<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <a href="{{ route('postingan.index') }}" class="text-gray-400 hover:text-gray-600 transition">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
            </a>
            <h2 class="text-xl font-bold text-gray-800">Detail Postingan</h2>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

            @foreach (['success' => 'green', 'error' => 'red'] as $key => $color)
                @if (session($key))
                    <div class="flex items-center gap-3 bg-{{ $color }}-50 border border-{{ $color }}-200 text-{{ $color }}-800 rounded-lg px-4 py-3 text-sm">
                        {{ session($key) }}
                    </div>
                @endif
            @endforeach

            {{-- Card Detail --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                @if ($postingan->foto)
                    <img src="{{ asset('storage/' . $postingan->foto) }}" alt="{{ $postingan->namaBarang }}"
                         class="w-full h-64 object-cover">
                @else
                    <div class="w-full h-40 bg-gray-50 flex items-center justify-center">
                        <svg class="h-14 w-14 text-gray-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1"
                                  d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                    </div>
                @endif

                <div class="p-6">
                    {{-- Badges --}}
                    <div class="flex flex-wrap gap-2 mb-3">
                        <span class="text-xs font-bold px-3 py-1 rounded-full {{ $postingan->jenis === 'barangHilang' ? 'bg-red-100 text-red-700' : 'bg-green-100 text-green-700' }}">
                            {{ $postingan->jenis === 'barangHilang' ? '🔴 Barang Hilang' : '🟢 Barang Ditemukan' }}
                        </span>
                        <span class="text-xs px-3 py-1 rounded-full font-medium
                            {{ $postingan->status === 'dibuat' ? 'bg-yellow-100 text-yellow-700' : ($postingan->status === 'diamankan' ? 'bg-blue-100 text-blue-700' : 'bg-gray-100 text-gray-600') }}">
                            {{ ucfirst($postingan->status) }}
                        </span>
                        <span class="text-xs px-3 py-1 rounded-full bg-gray-50 text-gray-400">{{ $postingan->kategori }}</span>
                    </div>

                    <h1 class="text-2xl font-bold text-gray-900 mb-2">{{ $postingan->namaBarang }}</h1>

                    <p class="flex items-center gap-1 text-sm text-gray-500 mb-4">
                        <svg class="h-4 w-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0zM15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                        {{ $postingan->lokasi }}
                    </p>

                    <p class="text-sm text-gray-600 leading-relaxed mb-6">{{ $postingan->deskripsi }}</p>

                    {{-- Kontak --}}
                    <div class="bg-indigo-50 rounded-xl p-4 mb-5">
                        <p class="text-xs font-semibold text-indigo-700 mb-1">📞 Informasi Kontak</p>
                        <p class="text-sm font-medium text-gray-800">{{ $postingan->namaKontak }}</p>
                        <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $postingan->noKontak) }}"
                           target="_blank"
                           class="inline-flex items-center gap-1 text-sm text-green-600 hover:underline font-medium mt-1">
                            📱 {{ $postingan->noKontak }}
                        </a>
                    </div>

                    <div class="flex items-center justify-between text-xs text-gray-400 pt-4 border-t border-gray-100">
                        <span>Oleh <strong class="text-gray-600">{{ $postingan->pelapor->name ?? 'Anonim' }}</strong></span>
                        <span>{{ $postingan->created_at->format('d M Y, H:i') }}</span>
                    </div>
                </div>
            </div>

            {{-- Action Buttons --}}
            <div class="flex flex-wrap gap-3">
                @can('update', $postingan)
                    <a href="{{ route('postingan.edit', $postingan) }}"
                       class="bg-amber-500 hover:bg-amber-600 text-white text-sm font-semibold px-4 py-2.5 rounded-lg transition">
                        ✏️ Edit Postingan
                    </a>
                @endcan

                @can('delete', $postingan)
                    <form method="POST" action="{{ route('postingan.destroy', $postingan) }}"
                          onsubmit="return confirm('Hapus postingan ini?')">
                        @csrf @method('DELETE')
                        <button class="bg-red-500 hover:bg-red-600 text-white text-sm font-semibold px-4 py-2.5 rounded-lg transition">
                            🗑️ Hapus
                        </button>
                    </form>
                @endcan

                @if (!auth()->user()->isAdmin() && auth()->id() !== $postingan->id_pelapor)
                    <button onclick="document.getElementById('modal-laporan').classList.remove('hidden')"
                            class="text-sm text-gray-500 hover:text-red-600 border border-gray-200 hover:border-red-200 px-4 py-2.5 rounded-lg transition">
                        ⚠️ Laporkan
                    </button>
                @endif
            </div>

            {{-- Laporan (admin only) --}}
            @if (auth()->user()->isAdmin() && $postingan->laporan->count() > 0)
                <div class="bg-white rounded-2xl border border-amber-100 overflow-hidden">
                    <div class="px-6 py-3 bg-amber-50 border-b border-amber-100">
                        <p class="text-sm font-bold text-amber-700">⚠️ {{ $postingan->laporan->count() }} Laporan Masuk</p>
                    </div>
                    @foreach ($postingan->laporan as $laporan)
                        <div class="px-6 py-4 flex items-start justify-between gap-4 border-b border-gray-50 last:border-0">
                            <div>
                                <p class="text-xs font-semibold text-gray-700">{{ $laporan->pelapor->name ?? '-' }}</p>
                                <p class="text-sm text-gray-600 mt-1">{{ $laporan->alasan }}</p>
                                <p class="text-xs text-gray-400 mt-1">{{ $laporan->created_at->format('d M Y') }}</p>
                            </div>
                            <form method="POST" action="{{ route('admin.laporan.destroy', $laporan) }}">
                                @csrf @method('DELETE')
                                <button class="text-xs text-amber-600 hover:text-amber-800 font-medium transition whitespace-nowrap">Selesaikan</button>
                            </form>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>

    {{-- Modal Laporan --}}
    <div id="modal-laporan" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/40 px-4">
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md">
            <div class="px-6 py-4 border-b border-gray-100">
                <h3 class="text-base font-bold text-gray-800">⚠️ Laporkan Postingan</h3>
                <p class="text-xs text-gray-500 mt-1">Laporkan jika postingan ini bersifat fiktif/penipuan.</p>
            </div>
            <form method="POST" action="{{ route('laporan.store') }}" class="p-6 space-y-4">
                @csrf
                <input type="hidden" name="id_postingan" value="{{ $postingan->id }}">
                <div>
                    <label for="alasan" class="block text-sm font-semibold text-gray-700 mb-1.5">
                        Alasan <span class="text-red-500">*</span>
                    </label>
                    <textarea id="alasan" name="alasan" rows="4"
                              placeholder="Jelaskan alasan laporan Anda (min. 20 karakter)..."
                              class="w-full text-sm border border-gray-200 rounded-lg px-3 py-2.5 focus:ring-2 focus:ring-red-200 outline-none resize-none"></textarea>
                    @error('alasan') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                </div>
                <div class="flex gap-3">
                    <button type="button" onclick="document.getElementById('modal-laporan').classList.add('hidden')"
                            class="flex-1 text-sm text-gray-500 border border-gray-200 py-2.5 rounded-lg hover:bg-gray-50 transition">
                        Batal
                    </button>
                    <button type="submit"
                            class="flex-1 bg-red-500 hover:bg-red-600 text-white text-sm font-semibold py-2.5 rounded-lg transition">
                        Kirim Laporan
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
