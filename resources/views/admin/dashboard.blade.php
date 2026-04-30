<x-app-layout>
    <x-slot:title>Dashboard Admin - Balik.in</x-slot>

    <h1 class="text-3xl font-extrabold text-gray-900 mb-2">Panel Administrator</h1>
    <p class="text-gray-500 mb-8">Ringkasan aktivitas aplikasi Balik.in</p>

    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200 border-l-4 border-l-blue-500">
            <div class="text-sm text-gray-500 font-bold uppercase">Total Postingan</div>
            <div class="text-3xl font-extrabold mt-2">{{ $totalPostingan }}</div>
        </div>
        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200 border-l-4 border-l-green-500">
            <div class="text-sm text-gray-500 font-bold uppercase">Total User</div>
            <div class="text-3xl font-extrabold mt-2">{{ $totalUser }}</div>
        </div>
        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200 border-l-4 border-l-yellow-500">
            <div class="text-sm text-gray-500 font-bold uppercase">Total Laporan Masuk</div>
            <div class="text-3xl font-extrabold mt-2">{{ $totalLaporan }}</div>
        </div>
        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200 border-l-4 border-l-red-500">
            <div class="text-sm text-red-500 font-bold uppercase">Laporan Pending</div>
            <div class="text-3xl font-extrabold mt-2 text-red-600">{{ $laporanPending }}</div>
        </div>
    </div>

    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200 text-center">
        <h2 class="text-xl font-bold mb-4">Aksi Cepat Admin</h2>
        <a href="{{ route('admin.laporan') }}" class="inline-block bg-red-600 text-white px-6 py-3 rounded-lg font-bold hover:bg-red-700 transition">
            Tinjau & Kelola Laporan Fiktif &rarr;
        </a>
    </div>
</x-app-layout>