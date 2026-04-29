<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <h2 class="text-xl font-bold text-gray-800 leading-tight">
                🔍 Forum Barang Hilang & Ditemukan
            </h2>
            <a href="{{ route('postingan.create') }}"
               class="inline-flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold px-4 py-2 rounded-lg shadow transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Buat Postingan
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- Alert Notifikasi --}}
            @if (session('success'))
                <div class="mb-6 flex items-center gap-3 bg-green-50 border border-green-200 text-green-800 rounded-lg px-4 py-3 text-sm">
                    <svg class="h-5 w-5 text-green-500 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                    {{ session('success') }}
                </div>
            @endif
            @if (session('error'))
                <div class="mb-6 flex items-center gap-3 bg-red-50 border border-red-200 text-red-800 rounded-lg px-4 py-3 text-sm">
                    <svg class="h-5 w-5 text-red-500 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                    </svg>
                    {{ session('error') }}
                </div>
            @endif

            {{-- Filter & Search Bar --}}
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 mb-8">
                <form method="GET" action="{{ route('postingan.index') }}" class="flex flex-col sm:flex-row gap-3">
                    {{-- Search --}}
                    <div class="relative flex-1">
                        <svg class="absolute left-3 top-1/2 -translate-y-1/2 h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                        <input type="text" name="search" value="{{ request('search') }}"
                               placeholder="Cari nama barang atau lokasi..."
                               class="w-full pl-10 pr-4 py-2 text-sm border border-gray-200 rounded-lg focus:ring-2 focus:ring-indigo-300 focus:border-indigo-400 outline-none transition">
                    </div>

                    {{-- Filter Jenis --}}
                    <select name="jenis"
                            class="text-sm border border-gray-200 rounded-lg px-3 py-2 focus:ring-2 focus:ring-indigo-300 focus:border-indigo-400 outline-none transition bg-white">
                        <option value="">Semua Jenis</option>
                        <option value="barangHilang" {{ request('jenis') === 'barangHilang' ? 'selected' : '' }}>Barang Hilang</option>
                        <option value="barangDitemukan" {{ request('jenis') === 'barangDitemukan' ? 'selected' : '' }}>Barang Ditemukan</option>
                    </select>

                    {{-- Filter Kategori --}}
                    <select name="kategori"
                            class="text-sm border border-gray-200 rounded-lg px-3 py-2 focus:ring-2 focus:ring-indigo-300 focus:border-indigo-400 outline-none transition bg-white">
                        <option value="">Semua Kategori</option>
                        @foreach(['Elektronik','Dompet/Tas','Kunci','Dokumen','Perhiasan','Hewan','Lainnya'] as $kat)
                            <option value="{{ $kat }}" {{ request('kategori') === $kat ? 'selected' : '' }}>{{ $kat }}</option>
                        @endforeach
                    </select>

                    <button type="submit"
                            class="bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold px-5 py-2 rounded-lg transition">
                        Cari
                    </button>
                    @if(request()->hasAny(['search','jenis','kategori']))
                        <a href="{{ route('postingan.index') }}"
                           class="text-sm text-gray-500 hover:text-red-500 px-3 py-2 rounded-lg border border-gray-200 hover:border-red-300 transition flex items-center">
                            Reset
                        </a>
                    @endif
                </form>
            </div>

            {{-- Jumlah hasil --}}
            <p class="text-sm text-gray-500 mb-4">
                Menampilkan <span class="font-semibold text-gray-700">{{ $postingans->total() }}</span> postingan
                @if(request()->hasAny(['search','jenis','kategori'])) (hasil filter) @endif
            </p>

            {{-- Grid Postingan --}}
            @if ($postingans->isEmpty())
                <div class="flex flex-col items-center justify-center py-24 text-gray-400">
                    <svg class="h-16 w-16 mb-4 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <p class="text-lg font-medium">Belum ada postingan.</p>
                    <p class="text-sm mt-1">Jadilah yang pertama membuat postingan!</p>
                    <a href="{{ route('postingan.create') }}"
                       class="mt-4 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold px-5 py-2.5 rounded-lg transition">
                        Buat Postingan
                    </a>
                </div>
            @else
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-5">
                    @foreach ($postingans as $post)
                        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md hover:-translate-y-0.5 transition-all duration-200 flex flex-col">

                            {{-- Foto / Placeholder --}}
                            <div class="relative h-44 bg-gray-100 overflow-hidden">
                                @if ($post->foto)
                                    <img src="{{ asset('storage/' . $post->foto) }}"
                                         alt="{{ $post->namaBarang }}"
                                         class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-gray-300">
                                        <svg class="h-14 w-14" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                        </svg>
                                    </div>
                                @endif

                                {{-- Badge Jenis --}}
                                <span class="absolute top-2 left-2 text-xs font-bold px-2.5 py-1 rounded-full shadow
                                    {{ $post->jenis === 'barangHilang'
                                        ? 'bg-red-100 text-red-700'
                                        : 'bg-green-100 text-green-700' }}">
                                    {{ $post->jenis === 'barangHilang' ? '🔴 Hilang' : '🟢 Ditemukan' }}
                                </span>

                                {{-- Badge Status --}}
                                <span class="absolute top-2 right-2 text-xs px-2 py-0.5 rounded-full font-medium
                                    {{ $post->status === 'dibuat' ? 'bg-yellow-100 text-yellow-700' :
                                      ($post->status === 'diamankan' ? 'bg-blue-100 text-blue-700' : 'bg-gray-100 text-gray-600') }}">
                                    {{ ucfirst($post->status) }}
                                </span>
                            </div>

                            {{-- Body --}}
                            <div class="p-4 flex flex-col flex-1">
                                <h3 class="font-semibold text-gray-800 text-base leading-snug line-clamp-1">
                                    {{ $post->namaBarang }}
                                </h3>
                                <p class="text-xs text-gray-400 mt-1">{{ $post->kategori }}</p>

                                <div class="flex items-center gap-1 text-xs text-gray-500 mt-2">
                                    <svg class="h-3.5 w-3.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    </svg>
                                    <span class="line-clamp-1">{{ $post->lokasi }}</span>
                                </div>

                                <p class="text-xs text-gray-500 mt-2 line-clamp-2 flex-1">{{ $post->deskripsi }}</p>

                                <div class="mt-3 pt-3 border-t border-gray-100 flex items-center justify-between">
                                    <span class="text-xs text-gray-400">{{ $post->pelapor->name ?? 'Anonim' }}</span>
                                    <span class="text-xs text-gray-400">{{ $post->created_at->diffForHumans() }}</span>
                                </div>

                                {{-- Actions --}}
                                <div class="mt-3 flex gap-2">
                                    <a href="{{ route('postingan.show', $post) }}"
                                       class="flex-1 text-center text-xs font-semibold bg-indigo-50 hover:bg-indigo-100 text-indigo-700 py-1.5 rounded-lg transition">
                                        Detail
                                    </a>
                                    @can('update', $post)
                                        <a href="{{ route('postingan.edit', $post) }}"
                                           class="text-xs font-semibold bg-amber-50 hover:bg-amber-100 text-amber-700 px-3 py-1.5 rounded-lg transition">
                                            Edit
                                        </a>
                                    @endcan
                                    @can('delete', $post)
                                        <form method="POST" action="{{ route('postingan.destroy', $post) }}"
                                              onsubmit="return confirm('Hapus postingan ini?')">
                                            @csrf @method('DELETE')
                                            <button class="text-xs font-semibold bg-red-50 hover:bg-red-100 text-red-600 px-3 py-1.5 rounded-lg transition">
                                                Hapus
                                            </button>
                                        </form>
                                    @endcan
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                {{-- Pagination --}}
                <div class="mt-8">
                    {{ $postingans->links() }}
                </div>
            @endif

        </div>
    </div>
</x-app-layout>
