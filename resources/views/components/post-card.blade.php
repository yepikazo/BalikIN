@props(['post'])

<div class="bg-white rounded-xl shadow-md overflow-hidden border border-gray-200 hover:shadow-xl transition">
    <div class="relative">
        @if($post->foto)
            <img class="h-48 w-full object-cover" src="{{ asset('storage/'.$post->foto) }}" alt="{{ $post->nama_barang }}">
        @else
            <div class="h-48 w-full bg-gray-200 flex items-center justify-center text-gray-400">Tidak ada foto</div>
        @endif
        
        <span class="absolute top-2 right-2 px-3 py-1 rounded-full text-xs font-bold uppercase {{ $post->tipe == 'hilang' ? 'bg-red-500 text-white' : 'bg-green-500 text-white' }}">
            {{ $post->tipe }}
        </span>
    </div>
    
    <div class="p-5">
        <div class="text-sm text-blue-600 font-semibold uppercase tracking-wide">{{ $post->kategori }}</div>
        <a href="{{ route('postingan.show', $post->id) }}" class="block mt-1 text-lg leading-tight font-bold text-black hover:underline">
            {{ $post->nama_barang }}
        </a>
        <p class="mt-2 text-gray-600 text-sm line-clamp-2">{{ $post->deskripsi }}</p>
        
        <div class="mt-4 flex items-center text-gray-500 text-xs">
            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
            {{ $post->lokasi }}
        </div>
        
        <div class="mt-4 pt-4 border-t flex justify-between items-center">
            <span class="text-xs text-gray-400">{{ $post->created_at->diffForHumans() }}</span>
            <a href="{{ route('postingan.show', $post->id) }}" class="text-blue-600 font-bold text-sm">Detail &rarr;</a>
        </div>
    </div>
</div>