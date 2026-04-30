<nav class="bg-blue-600 text-white shadow-lg">
    <div class="container mx-auto px-4 py-4 flex justify-between items-center">
        <a href="{{ route('beranda') }}" class="text-2xl font-bold tracking-tighter">Balik.<span class="text-yellow-400">in</span></a>
        
        <div class="space-x-4 flex items-center">
            <a href="{{ route('beranda') }}" class="hover:text-yellow-200">Beranda</a>
            @auth
                <a href="{{ route('postingan.create') }}" class="bg-yellow-500 px-4 py-2 rounded-lg font-semibold hover:bg-yellow-400">Buat Laporan</a>
                <a href="{{ route('messages.index') }}" class="hover:text-yellow-200">Pesan</a>
                
                @if(Auth::user()->is_admin)
                    <a href="{{ route('admin.dashboard') }}" class="bg-red-500 px-3 py-1 rounded text-sm">Admin</a>
                @endif

                <form method="POST" action="{{ route('logout') }}" class="inline">
                    @csrf
                    <button class="text-sm border-l pl-4 border-blue-400 hover:text-red-300">Keluar</button>
                </form>
            @else
                <a href="{{ route('login') }}" class="hover:text-yellow-200">Masuk</a>
                <a href="{{ route('register') }}" class="bg-white text-blue-600 px-4 py-2 rounded-lg font-semibold">Daftar</a>
            @endauth
        </div>
    </div>
</nav>