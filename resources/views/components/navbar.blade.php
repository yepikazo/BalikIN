<nav class="bk-navbar" x-data="{ open: false }">
    <div class="bk-navbar__inner">

        {{-- Brand --}}
        <a href="{{ route('beranda') }}" class="bk-navbar__brand">
            <span class="bk-navbar__brand-main">Balik</span><span class="bk-navbar__brand-dot">.in</span>
        </a>

        {{-- Desktop Actions --}}
        <div class="bk-navbar__actions">
            @auth
                {{-- Create Report Icon --}}
                <a href="{{ route('postingan.create') }}" class="bk-icon-btn" title="Buat Laporan">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
                        <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
                    </svg>
                </a>

                {{-- Messages Icon --}}
                <a href="{{ route('pesan.index') }}" class="bk-icon-btn" title="Pesan">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/>
                    </svg>
                </a>

                {{-- Admin badge --}}
                @if(Auth::user()->is_admin)
                    <a href="{{ route('admin.dashboard') }}" class="bk-admin-badge">Admin</a>
                @endif

                {{-- Account Dropdown --}}
                <div class="bk-dropdown" x-data="{ dropOpen: false }">
                    <button @click="dropOpen = !dropOpen" class="bk-avatar-btn" title="Akun Saya">
                        <span>{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</span>
                    </button>
                    <div x-show="dropOpen" @click.outside="dropOpen = false" x-transition class="bk-dropdown__menu">
                        <div class="bk-dropdown__header">
                            <div class="bk-dropdown__name">{{ Auth::user()->name }}</div>
                            <div class="bk-dropdown__email">{{ Auth::user()->email }}</div>
                        </div>
                        <a href="{{ route('profile.edit') }}" class="bk-dropdown__item">
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                            Profil Saya
                        </a>
                        <a href="{{ route('pesan.index') }}" class="bk-dropdown__item">
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
                            Pesan
                        </a>
                        <a href="{{ route('laporan.index') }}" class="bk-dropdown__item">
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                            Laporan Saya
                        </a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="bk-dropdown__item bk-dropdown__item--danger">
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
                                Keluar
                            </button>
                        </form>
                    </div>
                </div>
            @else
                <a href="{{ route('login') }}" class="bk-btn bk-btn--ghost">Masuk</a>
                <a href="{{ route('register') }}" class="bk-btn bk-btn--primary">Daftar</a>
            @endauth
        </div>

        {{-- Mobile hamburger --}}
        <button @click="open = !open" class="bk-navbar__hamburger">
            <svg x-show="!open" xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="18" x2="21" y2="18"/></svg>
            <svg x-show="open" xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
        </button>
    </div>

    {{-- Mobile Menu --}}
    <div x-show="open" x-transition class="bk-navbar__mobile">
        @auth
            <a href="{{ route('postingan.create') }}" class="bk-mobile-link">Buat Laporan</a>
            <a href="{{ route('pesan.index') }}" class="bk-mobile-link">Pesan</a>
            <a href="{{ route('laporan.index') }}" class="bk-mobile-link">Laporan Saya</a>
            <a href="{{ route('profile.edit') }}" class="bk-mobile-link">Profil</a>
            @if(Auth::user()->is_admin)
                <a href="{{ route('admin.dashboard') }}" class="bk-mobile-link bk-mobile-link--admin">Admin Panel</a>
            @endif
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="bk-mobile-link bk-mobile-link--danger">Keluar</button>
            </form>
        @else
            <a href="{{ route('login') }}" class="bk-mobile-link">Masuk</a>
            <a href="{{ route('register') }}" class="bk-mobile-link bk-mobile-link--accent">Daftar</a>
        @endauth
    </div>
</nav>
