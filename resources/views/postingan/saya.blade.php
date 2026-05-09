<x-app-layout>
    <x-slot:title>Postingan Saya — Balik.in</x-slot>

    {{-- Header --}}
    <div class="bk-page-header" style="margin-bottom:2rem">
        <div style="font-size:0.75rem;font-weight:700;letter-spacing:0.1em;text-transform:uppercase;color:var(--accent);margin-bottom:0.4rem">Akun Saya</div>
        <div style="display:flex;justify-content:space-between;align-items:flex-end;flex-wrap:wrap;gap:1rem">
            <div>
                <h1 class="bk-page-header__title">Postingan Saya</h1>
                <p class="bk-page-header__sub">Semua postingan barang hilang atau ditemukan yang pernah Anda buat.</p>
            </div>
            <a href="{{ route('postingan.create') }}" class="bk-btn bk-btn--primary" style="gap:0.5rem;flex-shrink:0">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/>
                </svg>
                Buat Postingan
            </a>
        </div>
    </div>

    {{-- Flash Messages --}}
    @if(session('success'))
        <div style="margin-bottom:1.25rem;padding:0.875rem 1.25rem;background:var(--success-light);border:1px solid #b7e0c5;border-radius:var(--radius-md);display:flex;align-items:center;gap:0.625rem;color:var(--success)">
            <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div style="margin-bottom:1.25rem;padding:0.875rem 1.25rem;background:var(--danger-light);border:1px solid #f5c0bc;border-radius:var(--radius-md);display:flex;align-items:center;gap:0.625rem;color:var(--danger)">
            <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
            {{ session('error') }}
        </div>
    @endif

    @forelse($postingan as $post)
        <div class="bk-card" style="margin-bottom:1rem;padding:1.25rem 1.5rem">
            <div style="display:flex;gap:1.25rem;align-items:flex-start;flex-wrap:wrap">

                {{-- Thumbnail --}}
                <a href="{{ route('postingan.show', $post->id) }}" style="flex-shrink:0">
                    @if($post->foto)
                        <img src="{{ asset('storage/'.$post->foto) }}"
                             style="width:72px;height:72px;object-fit:cover;border-radius:var(--radius-md);border:1px solid var(--border-subtle);display:block"
                             alt="{{ $post->nama_barang }}">
                    @else
                        <div style="width:72px;height:72px;background:var(--surface-2);border-radius:var(--radius-md);border:1px solid var(--border-subtle);display:flex;align-items:center;justify-content:center">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="var(--surface-3)" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                                <rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/>
                            </svg>
                        </div>
                    @endif
                </a>

                {{-- Info --}}
                <div style="flex:1;min-width:0">
                    <div style="display:flex;align-items:center;gap:0.5rem;flex-wrap:wrap;margin-bottom:0.4rem">
                        <span class="bk-badge bk-badge--{{ $post->tipe }}">{{ $post->tipe }}</span>
                    </div>
                    <a href="{{ route('postingan.show', $post->id) }}"
                       style="font-size:1rem;font-weight:700;color:var(--ink);letter-spacing:-0.01em;display:block;margin-bottom:0.25rem"
                       onmouseover="this.style.color='var(--accent-dark)'" onmouseout="this.style.color='var(--ink)'">
                        {{ $post->nama_barang }}
                    </a>
                    <div style="display:flex;gap:1rem;flex-wrap:wrap;font-size:0.78rem;color:var(--ink-faint)">
                        <span style="display:flex;align-items:center;gap:0.3rem">
                            <svg xmlns="http://www.w3.org/2000/svg" width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
                            {{ $post->lokasi }}
                        </span>
                        <span style="display:flex;align-items:center;gap:0.3rem">
                            <svg xmlns="http://www.w3.org/2000/svg" width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                            {{ $post->created_at->diffForHumans() }}
                        </span>
                        <span>{{ $post->kategori }}</span>
                    </div>
                </div>

                {{-- Aksi --}}
                <div style="display:flex;gap:0.5rem;align-items:center;flex-shrink:0">
                    <a href="{{ route('postingan.show', $post->id) }}" class="bk-btn bk-btn--ghost"
                       style="font-size:0.8rem;padding:0.4rem 0.8rem">
                        <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                        Lihat
                    </a>
                    @if (!in_array($post->tipe, ['diamankan', 'suspend']) || Auth::user()->is_admin)
                        <a href="{{ route('postingan.edit', $post->id) }}" class="bk-btn bk-btn--ghost"
                           style="font-size:0.8rem;padding:0.4rem 0.8rem">
                            <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                            Edit
                        </a>
                        <form action="{{ route('postingan.destroy', $post->id) }}" method="POST"
                              onsubmit="return confirm('Hapus postingan \'{{ addslashes($post->nama_barang) }}\'? Tindakan ini tidak bisa dibatalkan.')">
                            @csrf @method('DELETE')
                            <button type="submit" class="bk-btn bk-btn--danger" style="font-size:0.8rem;padding:0.4rem 0.8rem">
                                <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/></svg>
                                Hapus
                            </button>
                        </form>
                    
                    @endif
                </div>

            </div>
        </div>
    @empty
        <div class="bk-card" style="padding:4rem 2rem;text-align:center">
            <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none"
                 stroke="var(--surface-3)" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"
                 style="margin:0 auto 1rem;display:block">
                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                <polyline points="14 2 14 8 20 8"/>
            </svg>
            <p style="color:var(--ink-muted);font-size:0.95rem;font-weight:500;margin-bottom:0.5rem">Belum ada postingan.</p>
            <p style="color:var(--ink-faint);font-size:0.82rem;margin-bottom:1.5rem">Buat postingan pertama Anda untuk mulai mencari atau melaporkan barang.</p>
            <a href="{{ route('postingan.create') }}" class="bk-btn bk-btn--primary">
                Buat Postingan Pertama
            </a>
        </div>
    @endforelse

</x-app-layout>
