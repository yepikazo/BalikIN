<x-app-layout>
    <x-slot:title>Pesan — Balik.in</x-slot>

    <div style="max-width:700px;margin:0 auto">
        <div class="bk-page-header">
            <h1 class="bk-page-header__title">Kotak Pesan</h1>
            <p class="bk-page-header__sub">Riwayat percakapan Anda dengan pengguna lain.</p>
        </div>

        <div class="bk-card" style="overflow:visible">
            @forelse($messages as $msg)
                <div style="padding:1.25rem 1.5rem;border-bottom:1px solid var(--border-subtle);display:flex;gap:1rem;align-items:flex-start">
                    <div style="width:40px;height:40px;border-radius:999px;background:var(--surface-3);flex-shrink:0;display:flex;align-items:center;justify-content:center;font-weight:700;font-size:0.9rem;color:var(--ink-muted)">
                        {{ strtoupper(substr($msg->sender_id === Auth::id() ? $msg->receiver->name : $msg->sender->name, 0, 1)) }}
                    </div>
                    <div style="flex:1;min-width:0">
                        <div style="display:flex;justify-content:space-between;align-items:baseline;gap:0.5rem;margin-bottom:0.3rem">
                            <div>
                                @if($msg->sender_id === Auth::id())
                                    <span style="font-size:0.7rem;font-weight:700;text-transform:uppercase;letter-spacing:0.06em;color:var(--ink-faint)">Ke:</span>
                                    <span style="font-weight:600;margin-left:0.25rem;font-size:0.9rem">{{ $msg->receiver->name }}</span>
                                @else
                                    <span style="font-size:0.7rem;font-weight:700;text-transform:uppercase;letter-spacing:0.06em;color:var(--success)">Dari:</span>
                                    <span style="font-weight:600;margin-left:0.25rem;font-size:0.9rem">{{ $msg->sender->name }}</span>
                                @endif
                            </div>
                            <span style="font-size:0.75rem;color:var(--ink-faint);white-space:nowrap">{{ $msg->created_at->diffForHumans() }}</span>
                        </div>
                        <p style="font-size:0.875rem;color:var(--ink-muted);background:var(--surface-2);padding:0.5rem 0.75rem;border-radius:var(--radius-sm);display:inline-block;max-width:100%;word-break:break-word">{{ $msg->body }}</p>

                        @if($msg->sender_id !== Auth::id())
                            <form action="{{ route('messages.store') }}" method="POST" style="margin-top:0.75rem;display:flex;gap:0.5rem">
                                @csrf
                                <input type="hidden" name="receiver_id" value="{{ $msg->sender_id }}">
                                <input type="text" name="body" placeholder="Balas pesan..." class="bk-input" style="font-size:0.85rem" required>
                                <button type="submit" class="bk-btn bk-btn--primary" style="white-space:nowrap;font-size:0.85rem">Balas</button>
                            </form>
                        @endif
                    </div>
                </div>
            @empty
                <div style="padding:3.5rem 1.5rem;text-align:center">
                    <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="var(--ink-faint)" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" style="margin:0 auto 1rem"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
                    <p style="color:var(--ink-muted);font-size:0.9rem">Belum ada riwayat pesan.</p>
                    <p style="color:var(--ink-faint);font-size:0.82rem;margin-top:0.4rem">Hubungi pemilik laporan dari halaman detail barang.</p>
                </div>
            @endforelse
        </div>
    </div>
</x-app-layout>
