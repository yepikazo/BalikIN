<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">
            <h2 class="text-xl font-bold text-gray-800 leading-tight">
                🛡️ Admin Dashboard — Balik.in
            </h2>
            <span class="text-sm text-gray-500">
                {{ now()->translatedFormat('l, d F Y') }}
            </span>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">

            {{-- Alert --}}
            @if (session('success'))
                <div class="flex items-center gap-3 bg-green-50 border border-green-200 text-green-800 rounded-lg px-4 py-3 text-sm">
                    <svg class="h-5 w-5 text-green-500 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                    {{ session('success') }}
                </div>
            @endif

            {{-- ─── STAT CARDS ─────────────────────────────────────────────────── --}}
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4">

                @php
                    $cards = [
                        ['label' => 'Total Postingan', 'value' => $stats['totalPostingan'],  'icon' => '📋', 'color' => 'indigo'],
                        ['label' => 'Barang Hilang',   'value' => $stats['barangHilang'],    'icon' => '🔴', 'color' => 'red'],
                        ['label' => 'Barang Ditemukan','value' => $stats['barangDitemukan'], 'icon' => '🟢', 'color' => 'green'],
                        ['label' => 'Total Laporan',   'value' => $stats['totalLaporan'],    'icon' => '⚠️', 'color' => 'amber'],
                        ['label' => 'Total Pelapor',   'value' => $stats['totalUser'],       'icon' => '👤', 'color' => 'violet'],
                    ];
                    $colorMap = [
                        'indigo' => 'bg-indigo-50 border-indigo-100 text-indigo-700',
                        'red'    => 'bg-red-50 border-red-100 text-red-700',
                        'green'  => 'bg-green-50 border-green-100 text-green-700',
                        'amber'  => 'bg-amber-50 border-amber-100 text-amber-700',
                        'violet' => 'bg-violet-50 border-violet-100 text-violet-700',
                    ];
                @endphp

                @foreach ($cards as $card)
                    <div class="bg-white rounded-xl border {{ $colorMap[$card['color']] }} border shadow-sm p-4 flex flex-col gap-1">
                        <span class="text-2xl">{{ $card['icon'] }}</span>
                        <p class="text-2xl font-bold mt-1 text-gray-800">{{ $card['value'] }}</p>
                        <p class="text-xs font-medium text-gray-500">{{ $card['label'] }}</p>
                    </div>
                @endforeach
            </div>

            {{-- ─── TABEL POSTINGAN ─────────────────────────────────────────────── --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
                    <h3 class="text-base font-bold text-gray-800">📋 Daftar Semua Postingan</h3>
                    <span class="text-xs text-gray-400">{{ $postingans->total() }} total</span>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead class="bg-gray-50 text-xs uppercase text-gray-500 tracking-wide">
                            <tr>
                                <th class="px-4 py-3 text-left">#</th>
                                <th class="px-4 py-3 text-left">Nama Barang</th>
                                <th class="px-4 py-3 text-left">Jenis</th>
                                <th class="px-4 py-3 text-left">Kategori</th>
                                <th class="px-4 py-3 text-left">Lokasi</th>
                                <th class="px-4 py-3 text-left">Pelapor</th>
                                <th class="px-4 py-3 text-center">Laporan</th>
                                <th class="px-4 py-3 text-center">Status</th>
                                <th class="px-4 py-3 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            @forelse ($postingans as $post)
                                <tr class="hover:bg-gray-50/60 transition">
                                    <td class="px-4 py-3 text-gray-400">{{ $post->id }}</td>
                                    <td class="px-4 py-3 font-medium text-gray-800 max-w-[160px] truncate">
                                        {{ $post->namaBarang }}
                                    </td>
                                    <td class="px-4 py-3">
                                        <span class="text-xs font-semibold px-2 py-0.5 rounded-full
                                            {{ $post->jenis === 'barangHilang' ? 'bg-red-100 text-red-700' : 'bg-green-100 text-green-700' }}">
                                            {{ $post->jenis === 'barangHilang' ? 'Hilang' : 'Ditemukan' }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3 text-gray-500">{{ $post->kategori }}</td>
                                    <td class="px-4 py-3 text-gray-500 max-w-[140px] truncate">{{ $post->lokasi }}</td>
                                    <td class="px-4 py-3 text-gray-600">{{ $post->pelapor->name ?? '-' }}</td>
                                    <td class="px-4 py-3 text-center">
                                        @if ($post->laporan_count > 0)
                                            <span class="inline-flex items-center justify-center w-6 h-6 rounded-full bg-red-100 text-red-700 text-xs font-bold">
                                                {{ $post->laporan_count }}
                                            </span>
                                        @else
                                            <span class="text-gray-300">—</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3 text-center">
                                        {{-- Toggle status --}}
                                        <form method="POST" action="{{ route('admin.postingan.status', $post) }}">
                                            @csrf @method('PATCH')
                                            <button type="submit"
                                                    title="Klik untuk ganti status"
                                                    class="text-xs px-2.5 py-1 rounded-full font-semibold transition cursor-pointer
                                                        {{ $post->status === 'dibuat'    ? 'bg-yellow-100 text-yellow-700 hover:bg-yellow-200' :
                                                          ($post->status === 'diamankan' ? 'bg-blue-100 text-blue-700 hover:bg-blue-200'   :
                                                                                           'bg-gray-100 text-gray-600 hover:bg-gray-200') }}">
                                                {{ ucfirst($post->status) }}
                                            </button>
                                        </form>
                                    </td>
                                    <td class="px-4 py-3 text-center">
                                        <div class="flex items-center justify-center gap-2">
                                            <a href="{{ route('postingan.show', $post) }}"
                                               class="text-xs text-indigo-600 hover:text-indigo-800 font-medium transition">
                                                Detail
                                            </a>
                                            <form method="POST" action="{{ route('admin.postingan.destroy', $post) }}"
                                                  onsubmit="return confirm('Hapus postingan \'{{ addslashes($post->namaBarang) }}\'?')">
                                                @csrf @method('DELETE')
                                                <button class="text-xs text-red-500 hover:text-red-700 font-medium transition">
                                                    Hapus
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9" class="px-4 py-10 text-center text-gray-400 text-sm">
                                        Belum ada postingan.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if ($postingans->hasPages())
                    <div class="px-6 py-4 border-t border-gray-100">
                        {{ $postingans->links() }}
                    </div>
                @endif
            </div>

            {{-- ─── TABEL LAPORAN ───────────────────────────────────────────────── --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
                    <h3 class="text-base font-bold text-gray-800">⚠️ Daftar Laporan Postingan Fiktif</h3>
                    <span class="text-xs text-gray-400">{{ $laporans->total() }} laporan</span>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead class="bg-gray-50 text-xs uppercase text-gray-500 tracking-wide">
                            <tr>
                                <th class="px-4 py-3 text-left">#</th>
                                <th class="px-4 py-3 text-left">Dilaporkan oleh</th>
                                <th class="px-4 py-3 text-left">Postingan</th>
                                <th class="px-4 py-3 text-left">Alasan Laporan</th>
                                <th class="px-4 py-3 text-left">Tanggal</th>
                                <th class="px-4 py-3 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            @forelse ($laporans as $laporan)
                                <tr class="hover:bg-amber-50/30 transition">
                                    <td class="px-4 py-3 text-gray-400">{{ $laporan->id }}</td>
                                    <td class="px-4 py-3 font-medium text-gray-700">
                                        {{ $laporan->pelapor->name ?? '-' }}
                                    </td>
                                    <td class="px-4 py-3">
                                        @if ($laporan->postingan)
                                            <a href="{{ route('postingan.show', $laporan->postingan) }}"
                                               class="text-indigo-600 hover:underline font-medium">
                                                {{ Str::limit($laporan->postingan->namaBarang, 30) }}
                                            </a>
                                        @else
                                            <span class="text-gray-400 italic">Postingan dihapus</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3 text-gray-600 max-w-[240px]">
                                        <p class="line-clamp-2">{{ $laporan->alasan }}</p>
                                    </td>
                                    <td class="px-4 py-3 text-gray-400 whitespace-nowrap">
                                        {{ $laporan->created_at->format('d M Y') }}
                                    </td>
                                    <td class="px-4 py-3 text-center">
                                        <form method="POST" action="{{ route('admin.laporan.destroy', $laporan) }}"
                                              onsubmit="return confirm('Selesaikan laporan ini?')">
                                            @csrf @method('DELETE')
                                            <button class="text-xs bg-amber-50 hover:bg-amber-100 text-amber-700 font-semibold px-3 py-1 rounded-lg transition">
                                                Selesaikan
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-4 py-10 text-center text-gray-400 text-sm">
                                        🎉 Tidak ada laporan. Semua postingan bersih!
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if ($laporans->hasPages())
                    <div class="px-6 py-4 border-t border-gray-100">
                        {{ $laporans->links() }}
                    </div>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>
