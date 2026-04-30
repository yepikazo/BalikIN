<x-app-layout>
    <x-slot:title>{{ $postingan->nama_barang }} - Balik.in</x-slot>

    <div class="max-w-4xl mx-auto bg-white rounded-xl shadow-md overflow-hidden mb-10 border border-gray-200">
        
        <div class="p-6 md:p-8 border-b">
            <div class="flex justify-between items-start">
                <div>
                    <span class="px-3 py-1 rounded-full text-xs font-bold uppercase {{ $postingan->tipe == 'hilang' ? 'bg-red-500 text-white' : 'bg-green-500 text-white' }}">
                        {{ $postingan->tipe }}
                    </span>
                    <h1 class="text-3xl font-extrabold text-gray-900 mt-4">{{ $postingan->nama_barang }}</h1>
                    <p class="text-gray-500 text-sm mt-1">Diposting oleh <span class="font-bold text-gray-800">{{ $postingan->user->name }}</span> • {{ $postingan->created_at->format('d M Y, H:i') }}</p>
                </div>

                @auth
                    @if(Auth::id() === $postingan->user_id || Auth::user()->is_admin)
                        <div class="flex gap-2">
                            <a href="{{ route('postingan.edit', $postingan->id) }}" class="px-4 py-2 bg-yellow-400 text-yellow-900 text-sm font-bold rounded hover:bg-yellow-500">Edit</a>
                            <form action="{{ route('postingan.destroy', $postingan->id) }}" method="POST" onsubmit="return confirm('Hapus postingan ini secara permanen?');">
                                @csrf
                                @method('DELETE')
                                <button class="px-4 py-2 bg-red-600 text-white text-sm font-bold rounded hover:bg-red-700">Hapus</button>
                            </form>
                        </div>
                    @endif
                @endauth
            </div>

            <div class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                @if($postingan->foto)
                    <img src="{{ asset('storage/'.$postingan->foto) }}" class="rounded-lg shadow w-full object-cover max-h-80" alt="Foto Barang">
                @else
                    <div class="bg-gray-100 rounded-lg shadow flex items-center justify-center h-40 md:h-80 text-gray-400">Tidak ada foto dilampirkan</div>
                @endif

                <div>
                    <h3 class="text-lg font-bold border-b pb-2 mb-3">Detail Barang</h3>
                    <ul class="space-y-3 text-sm text-gray-700">
                        <li><strong>Kategori:</strong> {{ $postingan->kategori }}</li>
                        <li><strong>Lokasi Kejadian:</strong> {{ $postingan->lokasi }}</li>
                        <li><strong>Waktu Kejadian:</strong> {{ \Carbon\Carbon::parse($postingan->waktu_kejadian)->format('d M Y, H:i') }}</li>
                        <li><strong>Status:</strong> 
                            <span class="{{ $postingan->status == 'aktif' ? 'text-green-600' : 'text-gray-500' }} font-bold uppercase">{{ $postingan->status }}</span>
                        </li>
                    </ul>

                    <h3 class="text-lg font-bold border-b pb-2 mb-2 mt-6">Deskripsi</h3>
                    <p class="text-gray-700 text-sm leading-relaxed whitespace-pre-line">{{ $postingan->deskripsi }}</p>
                    
                    @auth
                        @if(Auth::id() !== $postingan->user_id)
                            <div class="mt-6 p-4 bg-blue-50 rounded-lg border border-blue-100">
                                <p class="text-sm text-blue-800 mb-2 font-semibold">Bukan barang Anda atau ada kecurigaan?</p>
                                <form action="{{ route('laporan.store') }}" method="POST" class="flex gap-2">
                                    @csrf
                                    <input type="hidden" name="postingan_id" value="{{ $postingan->id }}">
                                    <input type="text" name="alasan" placeholder="Alasan lapor (misal: penipuan)..." class="text-sm rounded border-gray-300 w-full" required>
                                    <button type="submit" class="bg-red-500 hover:bg-red-600 text-white text-xs font-bold px-3 py-2 rounded">Laporkan</button>
                                </form>
                            </div>
                        @endif
                    @endauth
                </div>
            </div>
        </div>

        <div class="p-6 md:p-8 bg-gray-50">
            <h2 class="text-xl font-extrabold text-gray-900 mb-6">Komentar Diskusi ({{ $postingan->comments->count() }})</h2>

            @auth
                <div class="mb-8 flex space-x-4 items-start">
                    <div class="h-12 w-12 rounded-full bg-blue-600 flex-shrink-0 flex items-center justify-center text-white font-bold text-xl uppercase">
                        {{ substr(Auth::user()->name, 0, 1) }}
                    </div>
                    <form action="{{ route('comment.store') }}" method="POST" class="w-full">
                        @csrf
                        <input type="hidden" name="postingan_id" value="{{ $postingan->id }}">
                        <textarea name="content" rows="3" placeholder="Tambahkan komentar Anda ke postingan ini..." class="w-full border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 p-3 text-sm" required></textarea>
                        <div class="text-right mt-2">
                            <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded font-bold hover:bg-blue-700 transition shadow">Kirim Komentar</button>
                        </div>
                    </form>
                </div>
            @else
                <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 mb-8">
                    <p class="text-sm text-yellow-700">Silakan <a href="{{ route('login') }}" class="font-bold underline">Login</a> atau <a href="{{ route('register') }}" class="font-bold underline">Daftar</a> terlebih dahulu untuk ikut berdiskusi.</p>
                </div>
            @endauth

            <div class="space-y-6">
                @forelse ($postingan->comments as $comment)
                    <x-comment-item :comment="$comment" />
                @empty
                    <p class="text-center text-gray-500 text-sm py-4">Belum ada diskusi untuk barang ini. Jadilah yang pertama berkomentar!</p>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>