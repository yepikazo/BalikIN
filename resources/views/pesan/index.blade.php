@php
    $layout = Auth::user()->is_admin ? 'admin-layout' : 'app-layout';
@endphp
<x-dynamic-component :component="$layout" title="Pesan — Balik.in">
    @if(!Auth::user()->is_admin)
        <x-slot:title>Pesan — Balik.in</x-slot>
    @endif

    <div style="max-width:900px;margin:0 auto">
        <div class="bk-page-header" style="display:flex;justify-content:space-between;align-items:flex-end;flex-wrap:wrap;gap:1rem;margin-bottom:1.5rem">
            <div>
                <h1 class="bk-page-header__title">Kotak Pesan</h1>
                <p class="bk-page-header__sub">Percakapan pribadi Anda dengan pengguna lain.</p>
            </div>
        </div>

        @if(empty($conversations))
            <div class="bk-card" style="padding:4rem 2rem;text-align:center">
                <div style="width:72px;height:72px;border-radius:var(--radius-full);background:var(--surface-2);display:flex;align-items:center;justify-content:center;margin:0 auto 1.25rem">
                    <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="var(--ink-faint)" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/>
                    </svg>
                </div>
                <p style="font-weight:600;font-size:0.95rem;color:var(--ink-muted);margin-bottom:0.3rem">Belum ada percakapan</p>
                <p style="font-size:0.82rem;color:var(--ink-faint)">Hubungi pelapor dari halaman detail postingan barang.</p>
                <a href="{{ route('beranda') }}" class="bk-btn bk-btn--ghost" style="margin-top:1.25rem;font-size:0.82rem">Jelajahi Postingan</a>
            </div>
        @else
            <div class="bk-card" style="overflow:hidden">
                @foreach($conversations as $convo)
                    <a href="{{ route('pesan.show', $convo['user']->id) }}"
                        style="display:flex;align-items:center;gap:1rem;padding:1.125rem 1.5rem;border-bottom:1px solid var(--border-subtle);text-decoration:none;color:inherit;transition:background 0.15s"
                        onmouseover="this.style.background='var(--surface-2)'"
                        onmouseout="this.style.background=''">

                        {{-- Avatar --}}
                        <div style="width:48px;height:48px;border-radius:var(--radius-full);background:var(--ink);color:white;font-size:1rem;font-weight:700;display:flex;align-items:center;justify-content:center;flex-shrink:0;position:relative">
                            {{ strtoupper(substr($convo['user']->name, 0, 1)) }}
                            @if($convo['unread'] > 0)
                                <span style="position:absolute;top:-3px;right:-3px;background:var(--danger);color:white;border-radius:var(--radius-full);font-size:0.6rem;font-weight:700;min-width:18px;height:18px;display:flex;align-items:center;justify-content:center;padding:0 4px;border:2px solid white">
                                    {{ $convo['unread'] > 9 ? '9+' : $convo['unread'] }}
                                </span>
                            @endif
                        </div>

                        {{-- Info --}}
                        <div style="flex:1;min-width:0">
                            <div style="display:flex;justify-content:space-between;align-items:baseline;gap:0.5rem">
                                <span style="font-weight:{{ $convo['unread'] > 0 ? '700' : '600' }};font-size:0.9rem;color:var(--ink)">
                                    {{ $convo['user']->name }}
                                </span>
                                <span style="font-size:0.73rem;color:var(--ink-faint);white-space:nowrap;flex-shrink:0">
                                    {{ $convo['last_message']->created_at->diffForHumans() }}
                                </span>
                            </div>
                            <div style="font-size:0.82rem;color:{{ $convo['unread'] > 0 ? 'var(--ink-muted)' : 'var(--ink-faint)' }};margin-top:2px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;font-weight:{{ $convo['unread'] > 0 ? '500' : '400' }}">
                                @if($convo['last_message']->sender_id === Auth::id())
                                    <span style="color:var(--ink-faint);font-size:0.78rem">Anda: </span>
                                @endif
                                {{ $convo['last_message']->body }}
                            </div>
                        </div>

                        {{-- Chevron --}}
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="var(--ink-faint)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="flex-shrink:0">
                            <polyline points="9 18 15 12 9 6"/>
                        </svg>
                    </a>
                @endforeach
            </div>
        @endif
    </div>
</x-dynamic-component>
