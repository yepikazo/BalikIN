<x-admin-layout title="Kelola Postingan">

    <div style="margin-bottom:0.5rem">
        <span style="font-size:0.7rem;font-weight:700;letter-spacing:0.1em;text-transform:uppercase;color:var(--danger)">Administrator</span>
    </div>
    <h1 style="font-size:1.75rem;font-weight:800;letter-spacing:-0.03em;color:var(--ink);margin-bottom:0.35rem">Kelola Postingan</h1>
    <p style="font-size:0.9rem;color:var(--ink-muted);margin-bottom:2rem">Pantau dan ubah status semua postingan dari pengguna.</p>

    {{-- Stats Row --}}
    @php
        $totalAll       = $postingan->count();
        $totalHilang    = $postingan->where('tipe','hilang')->count();
        $totalDitemukan = $postingan->where('tipe','ditemukan')->count();
        $totalDiamankan = $postingan->where('tipe','diamankan')->count();
        $totalSuspend   = $postingan->where('tipe','suspend')->count();
    @endphp
    <div style="display:grid;grid-template-columns:repeat(5,1fr);gap:1rem;margin-bottom:1.5rem">
        @foreach([
            ['label'=>'Total','val'=>$totalAll,'color'=>'var(--accent)'],
            ['label'=>'Hilang','val'=>$totalHilang,'color'=>'var(--danger)'],
            ['label'=>'Ditemukan','val'=>$totalDitemukan,'color'=>'var(--success)'],
            ['label'=>'Diamankan','val'=>$totalDiamankan,'color'=>'#1e40af'],
            ['label'=>'Suspend','val'=>$totalSuspend,'color'=>'#374151'],
        ] as $s)
            <div class="bk-card" style="padding:1.25rem;border-left:3px solid {{ $s['color'] }}">
                <div style="font-size:0.66rem;font-weight:700;text-transform:uppercase;letter-spacing:0.07em;color:var(--ink-faint);margin-bottom:0.3rem">{{ $s['label'] }}</div>
                <div style="font-size:1.85rem;font-weight:800;color:{{ $s['color'] }};line-height:1">{{ $s['val'] }}</div>
            </div>
        @endforeach
    </div>

    {{-- Filter Bar --}}
    <div class="bk-card" style="padding:1rem 1.25rem;margin-bottom:1.25rem">
        <form method="GET" action="{{ route('admin.postingan.index') }}"
              style="display:flex;gap:0.75rem;align-items:center;width:100%">
            <input type="text" name="q" value="{{ request('q') }}"
                   placeholder="Cari nama barang atau pemilik..."
                   class="bk-input" style="flex:1;min-width:0;font-size:0.875rem">
            <select name="tipe" class="bk-input" style="width:160px;flex-shrink:0;font-size:0.875rem">
                <option value="">Semua Tipe</option>
                @foreach(['hilang','ditemukan','diamankan','selesai','suspend'] as $t)
                    <option value="{{ $t }}" {{ request('tipe') === $t ? 'selected' : '' }}>
                        {{ ucfirst($t) }}
                    </option>
                @endforeach
            </select>
            <button type="submit" class="bk-btn bk-btn--primary" style="flex-shrink:0;font-size:0.875rem">
                <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none"
                     stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
                </svg>
                Filter
            </button>
            @if(request()->anyFilled(['q','tipe']))
                <a href="{{ route('admin.postingan.index') }}" class="bk-btn bk-btn--ghost" style="flex-shrink:0;font-size:0.875rem">
                    Reset
                </a>
            @endif
        </form>
    </div>

    {{-- Table --}}
    <div class="bk-card" style="overflow:hidden">
        <div style="overflow-x:auto">
            <table style="width:100%;border-collapse:collapse;font-size:0.875rem">
                <thead>
                    <tr style="background:var(--surface-2);border-bottom:1px solid var(--border)">
                        <th style="padding:0.875rem 1.25rem;text-align:center;font-size:0.68rem;font-weight:700;letter-spacing:0.06em;text-transform:uppercase;color:var(--ink-faint);white-space:nowrap">Pemilik</th>
                        <th style="padding:0.875rem 1.25rem;text-align:left;font-size:0.68rem;font-weight:700;letter-spacing:0.06em;text-transform:uppercase;color:var(--ink-faint)">Nama Postingan</th>
                        <th style="padding:0.875rem 1.25rem;text-align:left;font-size:0.68rem;font-weight:700;letter-spacing:0.06em;text-transform:uppercase;color:var(--ink-faint);white-space:nowrap">Tgl. Kejadian</th>
                        <th style="padding:0.875rem 1.25rem;text-align:center;font-size:0.68rem;font-weight:700;letter-spacing:0.06em;text-transform:uppercase;color:var(--ink-faint)">Status</th>
                        <th style="padding:0.875rem 1.25rem;text-align:center;font-size:0.68rem;font-weight:700;letter-spacing:0.06em;text-transform:uppercase;color:var(--ink-faint);white-space:nowrap;width:160px">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($postingan as $post)
                        <tr style="border-bottom:1px solid var(--border-subtle);transition:background 0.1s"
                            onmouseover="this.style.background='var(--surface-2)'"
                            onmouseout="this.style.background=''">

                            {{-- Pemilik --}}
                            <td style="padding:1rem 1.25rem">
                                <div style="display:flex;align-items:center;gap:0.6rem">
                                    <div style="width:32px;height:32px;border-radius:var(--radius-full);background:var(--ink);color:white;font-size:0.78rem;font-weight:700;display:flex;align-items:center;justify-content:center;flex-shrink:0">
                                        {{ strtoupper(substr($post->user->name ?? '?', 0, 1)) }}
                                    </div>
                                    <div>
                                        <div style="font-weight:600;font-size:0.85rem;color:var(--ink)">{{ $post->user->name ?? 'N/A' }}</div>
                                        <div style="font-size:0.71rem;color:var(--ink-faint)">{{ $post->user->email ?? '' }}</div>
                                    </div>
                                </div>
                            </td>

                            {{-- Nama Postingan --}}
                            <td style="padding:1rem 1.25rem">
                                <a href="{{ route('postingan.show', $post->id) }}" target="_blank"
                                   style="font-weight:600;color:var(--accent-dark);font-size:0.875rem;display:block;max-width:220px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap"
                                   title="{{ $post->nama_barang }}"
                                   onmouseover="this.style.textDecoration='underline'"
                                   onmouseout="this.style.textDecoration='none'">
                                    {{ $post->nama_barang }}
                                </a>
                                <div style="font-size:0.71rem;color:var(--ink-faint);margin-top:2px">
                                    {{ $post->kategori }}
                                </div>
                            </td>

                            {{-- Tanggal --}}
                            <td style="padding:1rem 1.25rem;white-space:nowrap">
                                <div style="font-size:0.85rem;font-weight:500;color:var(--ink)">
                                    {{ \Carbon\Carbon::parse($post->waktu_kejadian)->format('d M Y') }}
                                </div>
                                <div style="font-size:0.71rem;color:var(--ink-faint);margin-top:1px">
                                    {{ \Carbon\Carbon::parse($post->waktu_kejadian)->format('H:i') }}
                                </div>
                            </td>

                            {{-- Tipe Badge --}}
                            <td style="padding:1rem 1.25rem;text-align:center">
                                <span class="bk-badge bk-badge--{{ $post->tipe }}">{{ $post->tipe }}</span>
                            </td>

                            {{-- Aksi Ubah Tipe --}}
                            <td style="padding:0.75rem 1rem">
                                <div style="display:flex;flex-direction:column;gap:0.35rem;align-items:stretch;min-width:130px">

                                    @if($post->tipe !== 'diamankan' && $post->tipe !== 'selesai' && $post->tipe !== 'suspend')
                                        <form action="{{ route('admin.postingan.updateTipe', $post->id) }}" method="POST"
                                              onsubmit="return confirm('Tandai postingan ini sebagai Diamankan? Chat akan diarahkan ke admin.')">
                                            @csrf @method('PUT')
                                            <input type="hidden" name="tipe" value="diamankan">
                                            <button type="submit" class="bk-btn" style="width:100%;font-size:0.75rem;padding:0.35rem 0.6rem;background:#dbeafe;color:#1e40af;border:1px solid #bfdbfe;font-weight:600;justify-content:center">
                                                Amankan
                                            </button>
                                        </form>
                                    @endif

                                    @if($post->tipe !== 'selesai' && $post->tipe !== 'suspend')
                                        <form action="{{ route('admin.postingan.updateTipe', $post->id) }}" method="POST"
                                              onsubmit="return confirm('Tandai postingan ini sebagai Selesai?')">
                                            @csrf @method('PUT')
                                            <input type="hidden" name="tipe" value="selesai">
                                            <button type="submit" class="bk-btn" style="width:100%;font-size:0.75rem;padding:0.35rem 0.6rem;background:var(--success-light);color:var(--success);border:1px solid #b7e0c5;font-weight:600;justify-content:center">
                                                Selesaikan
                                            </button>
                                        </form>
                                    @endif

                                    @if($post->tipe !== 'suspend' && $post->tipe !== 'diamankan' && $post->tipe !== 'selesai')
                                        <form action="{{ route('admin.postingan.updateTipe', $post->id) }}" method="POST"
                                              onsubmit="return confirm('Suspend postingan ini? Tidak akan muncul di beranda.')">
                                            @csrf @method('PUT')
                                            <input type="hidden" name="tipe" value="suspend">
                                            <button type="submit" class="bk-btn bk-btn--danger" style="width:100%;font-size:0.75rem;padding:0.35rem 0.6rem;font-weight:600;justify-content:center">
                                                Suspend
                                            </button>
                                        </form>
                                    @endif

                                    @if($post->tipe == 'suspend')
                                        @php
                                            $tipePulih = $post->tipe_sebelumnya ?? 'hilang';
                                        @endphp
                                        <form action="{{ route('admin.postingan.updateTipe', $post->id) }}" method="POST"
                                              onsubmit="return confirm('Aktifkan kembali postingan ini? Tipe akan dikembalikan ke: {{ $tipePulih }}.')">
                                            @csrf @method('PUT')
                                            <input type="hidden" name="tipe" value="restore">
                                            <button type="submit" class="bk-btn bk-btn--ghost" style="width:100%;font-size:0.75rem;padding:0.35rem 0.6rem;font-weight:600;justify-content:center">
                                                Aktifkan
                                                {{-- <span style="font-size:0.65rem;opacity:0.7;display:block;font-weight:400;margin-top:1px">→ {{ $tipePulih }}</span> --}}
                                            </button>
                                        </form>
                                    @endif

                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" style="padding:4rem 1.5rem;text-align:center">
                                <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="none"
                                     stroke="var(--surface-3)" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"
                                     style="margin:0 auto 1rem;display:block">
                                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                                    <polyline points="14 2 14 8 20 8"/>
                                </svg>
                                <p style="color:var(--ink-muted);font-weight:500">Tidak ada postingan ditemukan.</p>
                                <p style="color:var(--ink-faint);font-size:0.82rem;margin-top:0.3rem">Coba ubah filter pencarian.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div style="padding:0.875rem 1.25rem;border-top:1px solid var(--border-subtle);font-size:0.8rem;color:var(--ink-faint);display:flex;justify-content:space-between;align-items:center">
            <span>Menampilkan <strong style="color:var(--ink)">{{ $postingan->count() }}</strong> postingan</span>
            <a href="{{ route('beranda') }}" style="color:var(--accent-dark);font-weight:500;font-size:0.8rem" target="_blank">
                Lihat Beranda →
            </a>
        </div>
    </div>

</x-admin-layout>
