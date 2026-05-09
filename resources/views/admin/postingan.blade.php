<x-admin-layout title="Kelola Postingan">

    <div style="margin-bottom:0.5rem">
        <span style="font-size:0.7rem;font-weight:700;letter-spacing:0.1em;text-transform:uppercase;color:var(--danger)">Administrator</span>
    </div>
    <div style="display:flex;align-items:flex-start;justify-content:space-between;gap:1rem;flex-wrap:wrap;margin-bottom:2rem">
        <div>
            <h1 style="font-size:1.75rem;font-weight:800;letter-spacing:-0.03em;color:var(--ink);margin-bottom:0.35rem">Kelola Postingan</h1>
            <p style="font-size:0.9rem;color:var(--ink-muted)">Pantau dan ubah status semua postingan dari pengguna.</p>
        </div>
        <a href="{{ route('postingan.create', ['redirect_back' => url()->current()]) }}"
                class="bk-btn bk-btn--primary" style="flex-shrink:0;display:flex;align-items:center;gap:0.4rem;text-decoration:none">
            <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none"
                 stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                <line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/>
            </svg>
            Tambah Postingan
        </a>
    </div>

    {{-- Stats Row --}}
    <div style="display:grid;grid-template-columns:repeat(5,1fr);gap:1rem;margin-bottom:1.5rem">
        @foreach([
            ['key' => '', 'label'=>'Total','val'=>$stats['total'],'color'=>'var(--accent)','bg'=>'var(--accent-light)'],
            ['key' => 'hilang', 'label'=>'Hilang','val'=>$stats['hilang'],'color'=>'var(--danger)','bg'=>'var(--danger-light)'],
            ['key' => 'ditemukan', 'label'=>'Ditemukan','val'=>$stats['ditemukan'],'color'=>'var(--success)','bg'=>'var(--success-light)'],
            ['key' => 'diamankan', 'label'=>'Diamankan','val'=>$stats['diamankan'],'color'=>'#1e40af','bg'=>'#dbeafe'],
            ['key' => 'suspend', 'label'=>'Suspend','val'=>$stats['suspend'],'color'=>'#374151','bg'=>'#f3f4f6'],
        ] as $s)
            <a href="{{ request()->fullUrlWithQuery(['tipe' => $s['key']]) }}" class="bk-card" style="padding:1.25rem;border-left:3px solid {{ $s['color'] }};text-decoration:none;display:block;{{ (request('tipe') ?? '') === $s['key'] ? 'background:'.$s['bg'].';' : '' }} transition: all 0.2s;">
                <div style="font-size:0.66rem;font-weight:700;text-transform:uppercase;letter-spacing:0.07em;color:var(--ink-faint);margin-bottom:0.3rem">{{ $s['label'] }}</div>
                <div style="font-size:1.85rem;font-weight:800;color:{{ $s['color'] }};line-height:1">{{ $s['val'] }}</div>
            </a>
        @endforeach
    </div>

    {{-- Filter Bar --}}
    <div class="bk-card" style="padding:1rem 1.25rem;margin-bottom:1.25rem">
        <form method="GET" action="{{ route('admin.postingan.index') }}"
              style="display:flex;gap:0.75rem;align-items:center;width:100%">
            @if(request('tipe'))
                <input type="hidden" name="tipe" value="{{ request('tipe') }}">
            @endif
            <div style="flex:1;min-width:0;position:relative">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="var(--ink-faint)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="position:absolute;left:0.75rem;top:50%;transform:translateY(-50%);pointer-events:none">
                    <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
                </svg>
                <input type="text" name="q" value="{{ request('q') }}"
                       placeholder="Cari nama barang atau pemilik..."
                       class="bk-input" style="width:100%;font-size:0.875rem;padding-left:2.4rem;padding-right:5.5rem">
                <button type="submit" class="bk-btn bk-btn--primary" style="position:absolute;right:0.35rem;top:0.35rem;bottom:0.35rem;padding:0 1rem;font-size:0.8rem;min-height:unset;height:auto;border-radius:4px">
                    Cari
                </button>
            </div>
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
                        <th style="padding:0.875rem 1.25rem;text-align:center;font-size:0.68rem;font-weight:700;letter-spacing:0.06em;text-transform:uppercase;color:var(--ink-faint);white-space:nowrap;width:60px">Edit</th>
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

                            {{-- Edit Postingan --}}
                            <td style="padding:0.75rem 0.75rem;text-align:center">
                                <a href="{{ route('postingan.edit', $post->id) }}?redirect_back={{ urlencode(url()->current()) }}"
                                   class="bk-btn bk-btn--ghost"
                                   style="font-size:0.75rem;padding:0.35rem 0.65rem;display:inline-flex;align-items:center;gap:0.3rem"
                                   title="Edit postingan">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none"
                                         stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
                                        <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
                                    </svg>
                                    Edit
                                </a>
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
                                              onsubmit="return confirm('Aktifkan kembali postingan ini? Tipe akan dikembalikan ke: {{ $tipePulih }}.') ">
                                            @csrf @method('PUT')
                                            <input type="hidden" name="tipe" value="restore">
                                            <button type="submit" class="bk-btn bk-btn--ghost" style="width:100%;font-size:0.75rem;padding:0.35rem 0.6rem;font-weight:600;justify-content:center">
                                                Aktifkan
                                            </button>
                                        </form>
                                    @endif

                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" style="padding:4rem 1.5rem;text-align:center">
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
            {{-- <a href="{{ route('beranda') }}" style="color:var(--accent-dark);font-weight:500;font-size:0.8rem" target="_blank">
                Lihat Beranda →
            </a> --}}
        </div>
    </div>



</x-admin-layout>
