<x-app-layout>
    <x-slot:title>Buat Postingan Baru - Balik.in</x-slot>

    <div class="max-w-2xl mx-auto bg-white p-8 rounded-xl shadow-md border border-gray-200">
        <h1 class="text-2xl font-extrabold text-gray-900 mb-6">Laporkan Barang</h1>

        <form action="{{ route('postingan.store') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
            @csrf
            
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1">Tipe Laporan</label>
                    <select name="tipe" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500" required>
                        <option value="hilang">Saya Kehilangan Barang</option>
                        <option value="ditemukan">Saya Menemukan Barang</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1">Kategori</label>
                    <select name="kategori" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500" required>
                        <option value="Elektronik">Elektronik</option>
                        <option value="Dokumen/Kartu">Dokumen/Kartu</option>
                        <option value="Aksesoris">Aksesoris</option>
                        <option value="Lainnya">Lainnya</option>
                    </select>
                </div>
            </div>

            <div>
                <label class="block text-sm font-bold text-gray-700 mb-1">Nama Barang</label>
                <input type="text" name="nama_barang" placeholder="Contoh: Dompet Kulit Hitam" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500" required>
            </div>

            <div>
                <label class="block text-sm font-bold text-gray-700 mb-1">Lokasi Kejadian</label>
                <input type="text" name="lokasi" placeholder="Contoh: Parkiran Gedung F" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500" required>
            </div>

            <div>
                <label class="block text-sm font-bold text-gray-700 mb-1">Waktu Kejadian</label>
                <input type="datetime-local" name="waktu_kejadian" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500" required>
            </div>

            <div>
                <label class="block text-sm font-bold text-gray-700 mb-1">Deskripsi & Ciri-ciri</label>
                <textarea name="deskripsi" rows="4" placeholder="Sebutkan ciri-ciri spesifik barang..." class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500" required></textarea>
            </div>

            <div>
                <label class="block text-sm font-bold text-gray-700 mb-1">Unggah Foto (Opsional)</label>
                <input type="file" name="foto" accept="image/*" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
            </div>

            <div class="pt-4 text-right">
                <a href="{{ route('beranda') }}" class="text-gray-500 mr-4 hover:underline">Batal</a>
                <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg font-bold hover:bg-blue-700 shadow-md">Posting Sekarang</button>
            </div>
        </form>
    </div>
</x-app-layout>