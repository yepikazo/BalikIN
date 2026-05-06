<x-app-layout>
    <x-slot:title>Laporan Barang — Balik.in</x-slot>

    <div class="bk-page-header" style="display:flex;justify-content:space-between;align-items:flex-end;flex-wrap:wrap;gap:1rem">
        <div>
            <div style="font-size:0.75rem;font-weight:700;letter-spacing:0.1em;text-transform:uppercase;color:var(--accent);margin-bottom:0.4rem">Komunitas</div>
            <h1 class="bk-page-header__title">Laporan Terkini</h1>
            <p class="bk-page-header__sub">Bantu sesama menemukan barang yang hilang atau menyerahkan barang temuan.</p>
        </div>
        <div style="display:flex;gap:0.5rem;flex-wrap:wrap" id="filter-buttons">
            <button onclick="filterPosts('semua')" class="bk-btn bk-btn--ghost filter-btn active-filter" data-filter="semua">Semua</button>
            <button onclick="filterPosts('hilang')" class="bk-btn bk-btn--ghost filter-btn" data-filter="hilang" style="color:var(--danger)">Hilang</button>
            <button onclick="filterPosts('ditemukan')" class="bk-btn bk-btn--ghost filter-btn" data-filter="ditemukan" style="color:var(--success)">Ditemukan</button>
        </div>
    </div>

    <div id="posts-grid" style="display:grid;grid-template-columns:repeat(auto-fill,minmax(240px,1fr));gap:1.25rem">
        @forelse ($postingan as $item)
            <div class="post-item" data-tipe="{{ $item->tipe }}">
                <x-post-card :post="$item" />
            </div>
        @empty
            <div style="grid-column:1/-1;padding:4rem 1rem;text-align:center">
                <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="var(--ink-faint)" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" style="margin:0 auto 1rem"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                <p style="color:var(--ink-muted);font-size:0.95rem">Belum ada postingan barang.</p>
            </div>
        @endforelse
    </div>
</x-app-layout>

@push('scripts')
<script>
function filterPosts(tipe) {
    document.querySelectorAll('.post-item').forEach(el => {
        if (tipe === 'semua' || el.dataset.tipe === tipe) {
            el.style.display = '';
        } else {
            el.style.display = 'none';
        }
    });
    document.querySelectorAll('.filter-btn').forEach(btn => {
        btn.classList.toggle('active-filter', btn.dataset.filter === tipe);
    });
}
</script>
<style>
.filter-btn.active-filter { background: var(--ink); color: white; border-color: var(--ink); }
</style>
@endpush
