<x-app-layout>
    <x-slot:title>Daftar Barang Hilang & Temuan - Balik.in</x-slot>

    <div class="flex justify-between items-center mb-8">
        <h1 class="text-3xl font-extrabold text-gray-800">Postingan Terbaru</h1>
        <div class="flex gap-2">
            <button class="px-4 py-2 bg-white rounded-lg shadow-sm border text-sm">Semua</button>
            <button class="px-4 py-2 bg-white rounded-lg shadow-sm border text-sm text-red-500 font-bold">Hilang</button>
            <button class="px-4 py-2 bg-white rounded-lg shadow-sm border text-sm text-green-500 font-bold">Ditemukan</button>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        @forelse ($postingan as $item)
            <x-post-card :post="$item" />
        @empty
            <div class="col-span-full py-20 text-center">
                <p class="text-gray-500 text-lg">Belum ada postingan barang.</p>
            </div>
        @endforelse
    </div>
</x-app-layout>