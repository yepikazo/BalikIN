<x-app-layout>
    <x-slot:title>Laporan Barang — Balik.in</x-slot>

    {{-- Page Header --}}
    <div class="bk-page-header" style="margin-bottom:1.5rem">
        <div style="font-size:0.75rem;font-weight:700;letter-spacing:0.1em;text-transform:uppercase;color:var(--accent);margin-bottom:0.4rem">Komunitas</div>
        <h1 class="bk-page-header__title">Laporan Terkini</h1>
        <p class="bk-page-header__sub">Bantu sesama menemukan barang yang hilang atau menyerahkan barang temuan.</p>
    </div>

    {{-- Search & Filter Bar --}}
    <form method="GET" action="{{ route('beranda') }}" id="filter-form">
        <div style="display:flex;flex-wrap:wrap;gap:0.75rem;margin-bottom:1.75rem;align-items:center">
            {{-- Search Input --}}
            <div style="flex:1;min-width:220px;position:relative">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="var(--ink-faint)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="position:absolute;left:0.75rem;top:50%;transform:translateY(-50%);pointer-events:none">
                    <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
                </svg>
                <input
                    type="text"
                    name="q"
                    value="{{ request('q') }}"
                    placeholder="Cari nama barang, lokasi, deskripsi..."
                    class="bk-input"
                    style="padding-left:2.4rem"
                >
            </div>

            {{-- Filter Kategori --}}
            <select name="kategori" class="bk-input" style="width:auto;min-width:160px" onchange="document.getElementById('filter-form').submit()">
                <option value="">Semua Kategori</option>
                @foreach($kategoriList as $kat)
                    <option value="{{ $kat }}" {{ request('kategori') === $kat ? 'selected' : '' }}>{{ ucfirst($kat) }}</option>
                @endforeach
            </select>

            {{-- Filter Tipe --}}
            <div style="display:flex;gap:0.4rem;flex-wrap:wrap">
                <button type="submit" name="tipe" value="" class="bk-btn bk-btn--ghost filter-tipe-btn {{ !request('tipe') ? 'active-filter' : '' }}">Semua</button>
                <button type="submit" name="tipe" value="hilang" class="bk-btn bk-btn--ghost filter-tipe-btn {{ request('tipe') === 'hilang' ? 'active-filter' : '' }}" style="{{ request('tipe') !== 'hilang' ? 'color:var(--danger)' : '' }}">Hilang</button>
                <button type="submit" name="tipe" value="ditemukan" class="bk-btn bk-btn--ghost filter-tipe-btn {{ request('tipe') === 'ditemukan' ? 'active-filter' : '' }}" style="{{ request('tipe') !== 'ditemukan' ? 'color:var(--success)' : '' }}">Ditemukan</button>
            </div>

            {{-- Tombol Search --}}
            <button type="submit" class="bk-btn bk-btn--primary">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                Cari
            </button>

            @if(request('q') || request('tipe') || request('kategori'))
                <a href="{{ route('beranda') }}" class="bk-btn bk-btn--ghost" style="color:var(--ink-faint)">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                    Reset
                </a>
            @endif
        </div>
    </form>

    {{-- Info hasil filter --}}
    @if(request('q') || request('tipe') || request('kategori'))
        <div style="margin-bottom:1.25rem;font-size:0.875rem;color:var(--ink-muted)">
            Menampilkan <strong style="color:var(--ink)">{{ $postingan->count() }}</strong> hasil
            @if(request('q')) untuk "<strong style="color:var(--ink)">{{ request('q') }}</strong>"@endif
            @if(request('tipe')) &mdash; tipe: <span class="bk-badge bk-badge--{{ request('tipe') }}">{{ request('tipe') }}</span>@endif
            @if(request('kategori')) &mdash; kategori: <strong>{{ request('kategori') }}</strong>@endif
        </div>
    @endif

    {{-- Grid Postingan --}}
    <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(240px,1fr));gap:1.25rem">
        @forelse ($postingan as $item)
            <x-post-card :post="$item" />
        @empty
            <div style="grid-column:1/-1;padding:4rem 1rem;text-align:center">
                <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="var(--ink-faint)" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" style="margin:0 auto 1rem"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                <p style="color:var(--ink-muted);font-size:0.95rem">Tidak ada postingan yang sesuai.</p>
                <a href="{{ route('beranda') }}" style="font-size:0.85rem;color:var(--accent);margin-top:0.5rem;display:inline-block">Tampilkan semua</a>
            </div>
        @endforelse
    </div>
</x-app-layout>

@push('styles')
<style>
.filter-tipe-btn.active-filter { background: var(--ink); color: white !important; border-color: var(--ink); }
</style>
@endpush
