<x-admin-layout title="Kelola Postingan">

    <div style="margin-bottom:0.5rem">
        <span style="font-size:0.7rem;font-weight:700;letter-spacing:0.1em;text-transform:uppercase;color:var(--danger)">Administrator</span>
    </div>
    <div style="display:flex;align-items:flex-start;justify-content:space-between;gap:1rem;flex-wrap:wrap;margin-bottom:2rem">
        <div>
            <h1 style="font-size:1.75rem;font-weight:800;letter-spacing:-0.03em;color:var(--ink);margin-bottom:0.35rem">Kelola Postingan</h1>
            <p style="font-size:0.9rem;color:var(--ink-muted)">Pantau dan ubah status semua postingan dari pengguna.</p>
        </div>
        <button onclick="document.getElementById('modal-tambah-post').style.display='flex'"
                class="bk-btn bk-btn--primary" style="flex-shrink:0;display:flex;align-items:center;gap:0.4rem">
            <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none"
                 stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                <line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/>
            </svg>
            Tambah Postingan
        </button>
    </div>

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
            <select name="tipe" class="bk-input" style="width:160px;flex-shrink:0;font-size:0.875rem" onchange="this.form.submit()">
                <option value="">Semua Tipe</option>
                @foreach(['hilang','ditemukan','diamankan','selesai','suspend'] as $t)
                    <option value="{{ $t }}" {{ request('tipe') === $t ? 'selected' : '' }}>
                        {{ ucfirst($t) }}
                    </option>
                @endforeach
            </select>
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
            <a href="{{ route('beranda') }}" style="color:var(--accent-dark);font-weight:500;font-size:0.8rem" target="_blank">
                Lihat Beranda →
            </a>
        </div>
    </div>

{{-- ═══════════════════════════════════════════════════════════════ --}}
{{-- Modal Tambah Postingan (Admin)                                  --}}
{{-- ═══════════════════════════════════════════════════════════════ --}}
<div id="modal-tambah-post"
     style="display:none;position:fixed;inset:0;z-index:9000;align-items:center;justify-content:center;background:rgba(0,0,0,0.45);backdrop-filter:blur(3px)"
     onclick="if(event.target===this)this.style.display='none'">
    <div style="background:var(--surface);border-radius:var(--radius-lg);box-shadow:var(--shadow-xl);width:100%;max-width:600px;max-height:90vh;overflow-y:auto;margin:1rem">

        {{-- Modal Header --}}
        <div style="display:flex;align-items:center;justify-content:space-between;padding:1.5rem 1.75rem;border-bottom:1px solid var(--border)">
            <div>
                <h2 style="font-size:1.1rem;font-weight:700;color:var(--ink);margin:0">Tambah Postingan</h2>
                <p style="font-size:0.78rem;color:var(--ink-faint);margin:0.2rem 0 0">Buat postingan baru sebagai Admin</p>
            </div>
            <button onclick="document.getElementById('modal-tambah-post').style.display='none'"
                    style="background:none;border:none;cursor:pointer;padding:0.35rem;border-radius:var(--radius-sm);color:var(--ink-muted)"
                    onmouseover="this.style.background='var(--surface-2)'" onmouseout="this.style.background='none'">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none"
                     stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/>
                </svg>
            </button>
        </div>

        {{-- Modal Body --}}
        <div style="padding:1.75rem">

            @if($errors->any())
                <div style="background:var(--danger-light);border:1px solid #f5c0bc;border-radius:var(--radius-sm);padding:1rem;margin-bottom:1.25rem">
                    <div style="font-weight:600;font-size:0.83rem;color:var(--danger);margin-bottom:0.4rem">Terdapat kesalahan:</div>
                    <ul style="list-style:disc;padding-left:1.25rem;font-size:0.8rem;color:var(--danger)">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.postingan.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                {{-- Redirect back ke halaman admin setelah submit --}}
                <input type="hidden" name="redirect_back" value="{{ url()->current() }}">

                {{-- Tipe & Kategori --}}
                <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem;margin-bottom:1.25rem">
                    <div>
                        <label class="bk-label">Tipe Laporan</label>
                        <select name="tipe" class="bk-input" required>
                            <option value="hilang"    {{ old('tipe') == 'hilang'    ? 'selected' : '' }}>Kehilangan Barang</option>
                            <option value="ditemukan" {{ old('tipe') == 'ditemukan' ? 'selected' : '' }}>Menemukan Barang</option>
                            <option value="diamankan" {{ old('tipe') == 'diamankan' ? 'selected' : '' }}>Diamankan</option>
                        </select>
                    </div>
                    <div>
                        <label class="bk-label">Kategori</label>
                        <select name="kategori" class="bk-input" required>
                            @foreach(['Elektronik','Dokumen/Kartu','Aksesoris','Kendaraan','Pakaian','Lainnya'] as $kat)
                                <option value="{{ $kat }}" {{ old('kategori') == $kat ? 'selected' : '' }}>{{ $kat }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                {{-- Nama Barang --}}
                <div style="margin-bottom:1.25rem">
                    <label class="bk-label">Nama Barang</label>
                    <input type="text" name="nama_barang" value="{{ old('nama_barang') }}"
                           class="bk-input" placeholder="Contoh: Dompet kulit hitam" required>
                </div>

                {{-- Lokasi --}}
                <div style="margin-bottom:1.25rem">
                    <label class="bk-label">Lokasi Kejadian</label>
                    <input type="text" name="lokasi" value="{{ old('lokasi') }}"
                           class="bk-input" placeholder="Contoh: Parkiran Gedung F, Lantai 2" required>
                </div>

                {{-- Waktu --}}
                <div style="margin-bottom:1.25rem">
                    <label class="bk-label">Waktu Kejadian</label>
                    <input type="datetime-local" name="waktu_kejadian" value="{{ old('waktu_kejadian') }}"
                           class="bk-input" required>
                </div>

                {{-- Deskripsi --}}
                <div style="margin-bottom:1.25rem">
                    <label class="bk-label">Deskripsi & Ciri-ciri</label>
                    <textarea name="deskripsi" rows="3" class="bk-input"
                              placeholder="Sebutkan ciri-ciri spesifik, warna, merek, atau detail lain..."
                              style="resize:vertical" required>{{ old('deskripsi') }}</textarea>
                </div>

                {{-- Foto --}}
                <div style="margin-bottom:1.75rem">
                    <label class="bk-label">Foto Barang (Opsional)</label>
                    <div style="border:2px dashed var(--border);border-radius:var(--radius-md);padding:1.25rem;text-align:center;cursor:pointer;transition:border-color 0.15s"
                         onclick="document.getElementById('modal-foto-input').click()">
                        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none"
                             stroke="var(--ink-faint)" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"
                             style="margin:0 auto 0.35rem;display:block">
                            <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/>
                            <polyline points="17 8 12 3 7 8"/><line x1="12" y1="3" x2="12" y2="15"/>
                        </svg>
                        <p id="modal-foto-label" style="font-size:0.8rem;color:var(--ink-faint);margin:0">Klik untuk unggah foto</p>
                        <input id="modal-foto-input" type="file" name="foto" accept="image/*" style="display:none"
                               onchange="modalPreviewFoto(this)">
                    </div>
                </div>

                {{-- Actions --}}
                <div style="display:flex;justify-content:flex-end;gap:0.75rem">
                    <button type="button" onclick="document.getElementById('modal-tambah-post').style.display='none'"
                            class="bk-btn bk-btn--ghost">Batal</button>
                    <button type="submit" class="bk-btn bk-btn--primary" style="display:flex;align-items:center;gap:0.4rem">
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none"
                             stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/>
                            <polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/>
                        </svg>
                        Simpan Postingan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function modalPreviewFoto(input) {
        if (input.files && input.files[0]) {
            document.getElementById('modal-foto-label').textContent = '✓ ' + input.files[0].name;
        }
    }
    // Buka modal kembali jika ada error validasi (setelah redirect back)
    @if($errors->any())
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('modal-tambah-post').style.display = 'flex';
        });
    @endif
</script>
@endpush

</x-admin-layout>
