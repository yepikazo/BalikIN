<x-app-layout>
    <x-slot:title>Kelola Laporan - Balik.in</x-slot>

    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-extrabold text-gray-900">Daftar Laporan Postingan Fiktif</h1>
        <a href="{{ route('admin.dashboard') }}" class="text-blue-600 hover:underline text-sm font-bold">&larr; Kembali ke Dashboard</a>
    </div>

    <div class="bg-white rounded-xl shadow overflow-hidden border border-gray-200">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm whitespace-nowrap">
                <thead class="bg-gray-100 text-gray-700">
                    <tr>
                        <th class="p-4 font-bold">Pelapor</th>
                        <th class="p-4 font-bold">Barang Dilaporkan</th>
                        <th class="p-4 font-bold">Alasan</th>
                        <th class="p-4 font-bold">Status</th>
                        <th class="p-4 font-bold text-center">Aksi Admin</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($laporan as $lap)
                        <tr class="hover:bg-gray-50">
                            <td class="p-4">
                                <span class="font-bold block">{{ $lap->pelapor->name }}</span>
                                <span class="text-xs text-gray-500">{{ $lap->tanggal_laporan }}</span>
                            </td>
                            <td class="p-4">
                                @if($lap->postingan)
                                    <a href="{{ route('postingan.show', $lap->postingan->id) }}" target="_blank" class="text-blue-600 font-bold hover:underline">
                                        {{ $lap->postingan->nama_barang }}
                                    </a>
                                    <div class="text-xs text-gray-500 mt-1">Pemilik: {{ $lap->postingan->user->name }}</div>
                                @else
                                    <span class="text-red-500 line-through">Postingan telah dihapus</span>
                                @endif
                            </td>
                            <td class="p-4 whitespace-normal min-w-[200px]">
                                {{ $lap->alasan }}
                            </td>
                            <td class="p-4">
                                <form action="{{ route('admin.laporan.update', $lap->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <select name="status_laporan" onchange="this.form.submit()" class="text-xs rounded border-gray-300 font-bold p-1 
                                        {{ $lap->status_laporan == 'pending' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                        {{ $lap->status_laporan == 'diproses' ? 'bg-blue-100 text-blue-800' : '' }}
                                        {{ $lap->status_laporan == 'selesai' ? 'bg-green-100 text-green-800' : '' }}
                                    ">
                                        <option value="pending" {{ $lap->status_laporan == 'pending' ? 'selected' : '' }}>Pending</option>
                                        <option value="diproses" {{ $lap->status_laporan == 'diproses' ? 'selected' : '' }}>Diproses</option>
                                        <option value="selesai" {{ $lap->status_laporan == 'selesai' ? 'selected' : '' }}>Selesai</option>
                                    </select>
                                </form>
                            </td>
                            <td class="p-4 text-center">
                                @if($lap->postingan)
                                    <form action="{{ route('admin.postingan.destroy', $lap->postingan->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin postingan ini fiktif/spam dan ingin menghapusnya permanen?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="bg-red-500 text-white px-3 py-1 rounded text-xs font-bold hover:bg-red-600">Hapus Postingan</button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="p-8 text-center text-gray-500">Hore! Belum ada laporan fiktif saat ini.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>