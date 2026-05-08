<x-app-layout>
    <x-slot:title>Edit Postingan — Balik.in</x-slot>

    <div style="max-width:660px;margin:0 auto">

        {{-- Breadcrumb --}}
        @php $backUrl = request('redirect_back') ?: old('redirect_back', route('postingan.show', $postingan->id)); @endphp
        <a href="{{ $backUrl }}"
           style="display:inline-flex;align-items:center;gap:0.35rem;font-size:0.82rem;color:var(--ink-muted);margin-bottom:1.5rem;transition:color 0.15s"
           onmouseover="this.style.color='var(--ink)'" onmouseout="this.style.color='var(--ink-muted)'">
            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none"
                 stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <polyline points="15 18 9 12 15 6"/>
            </svg>
            Kembali
        </a>

        <div class="bk-page-header" style="margin-bottom:1.5rem">
            <h1 class="bk-page-header__title">Edit Postingan</h1>
            <p class="bk-page-header__sub">Perbarui informasi postingan barang hilang atau temuan Anda.</p>
        </div>

        <div class="bk-card" style="padding:2rem;box-shadow:var(--shadow-md)">

            {{-- Validation Errors --}}
            @if($errors->any())
                <div style="background:var(--danger-light);border:1px solid #f5c0bc;border-radius:var(--radius-sm);padding:1rem;margin-bottom:1.5rem">
                    <div style="font-weight:600;font-size:0.85rem;color:var(--danger);margin-bottom:0.5rem">Terdapat kesalahan:</div>
                    <ul style="list-style:disc;padding-left:1.25rem;font-size:0.82rem;color:var(--danger)">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('postingan.update', $postingan->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                {{-- Redirect target setelah update (support admin redirect back) --}}
                <input type="hidden" name="redirect_back" value="{{ request('redirect_back', old('redirect_back')) }}">

                {{-- Tipe & Kategori --}}
                <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem;margin-bottom:1.25rem">
                    <div>
                        <label class="bk-label">Tipe Laporan</label>
                        <select name="tipe" class="bk-input" required>
                            <option value="hilang" {{ old('tipe', $postingan->tipe) == 'hilang' ? 'selected' : '' }}>
                                Kehilangan Barang
                            </option>
                            <option value="ditemukan" {{ old('tipe', $postingan->tipe) == 'ditemukan' ? 'selected' : '' }}>
                                Menemukan Barang
                            </option>
                            @auth
                                @if(auth()->user()->is_admin)
                                    <option value="diamankan" {{ old('tipe', $postingan->tipe) == 'diamankan' ? 'selected' : '' }}>Diamankan</option>
                                @endif
                            @endauth
                        </select>
                    </div>
                    <div>
                        <label class="bk-label">Kategori</label>
                        <select name="kategori" class="bk-input" required>
                            @foreach(['Elektronik','Dokumen/Kartu','Aksesoris','Kendaraan','Pakaian','Lainnya'] as $kat)
                                <option value="{{ $kat }}" {{ old('kategori', $postingan->kategori) == $kat ? 'selected' : '' }}>
                                    {{ $kat }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                {{-- Nama Barang --}}
                <div style="margin-bottom:1.25rem">
                    <label class="bk-label">Nama Barang</label>
                    <input type="text" name="nama_barang"
                           value="{{ old('nama_barang', $postingan->nama_barang) }}"
                           class="bk-input" placeholder="Contoh: Dompet kulit hitam" required>
                </div>

                {{-- Lokasi --}}
                <div style="margin-bottom:1.25rem">
                    <label class="bk-label">Lokasi Kejadian</label>
                    <input type="text" name="lokasi"
                           value="{{ old('lokasi', $postingan->lokasi) }}"
                           class="bk-input" placeholder="Contoh: Parkiran Gedung F, Lantai 2" required>
                </div>

                {{-- Waktu --}}
                <div style="margin-bottom:1.25rem">
                    <label class="bk-label">Waktu Kejadian</label>
                    <input type="datetime-local" name="waktu_kejadian"
                           value="{{ old('waktu_kejadian', \Carbon\Carbon::parse($postingan->waktu_kejadian)->format('Y-m-d\TH:i')) }}"
                           class="bk-input" required>
                </div>

                {{-- Deskripsi --}}
                <div style="margin-bottom:1.25rem">
                    <label class="bk-label">Deskripsi & Ciri-ciri</label>
                    <textarea name="deskripsi" rows="4" class="bk-input"
                              placeholder="Sebutkan ciri-ciri spesifik, warna, merek, atau detail lain..."
                              style="resize:vertical" required>{{ old('deskripsi', $postingan->deskripsi) }}</textarea>
                </div>

                {{-- Foto --}}
                <div style="margin-bottom:1.75rem">
                    <label class="bk-label">Foto Barang</label>

                    {{-- Preview foto existing --}}
                    @if($postingan->foto)
                        <div style="margin-bottom:0.875rem;position:relative;display:inline-block">
                            <img src="{{ asset('storage/' . $postingan->foto) }}"
                                 style="height:120px;border-radius:var(--radius-md);object-fit:cover;border:1px solid var(--border-subtle);display:block"
                                 alt="Foto saat ini">
                            <div style="font-size:0.72rem;color:var(--ink-faint);margin-top:0.3rem;text-align:center">Foto saat ini</div>
                        </div>
                    @endif

                    <div id="foto-drop"
                         style="border:2px dashed var(--border);border-radius:var(--radius-md);padding:1.25rem;text-align:center;cursor:pointer;transition:border-color 0.15s,background 0.15s"
                         onclick="document.getElementById('foto-input').click()"
                         ondragover="event.preventDefault();this.style.borderColor='var(--accent)';this.style.background='var(--accent-light)'"
                         ondragleave="this.style.borderColor='var(--border)';this.style.background=''"
                         ondrop="handleDrop(event)">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                             stroke="var(--ink-faint)" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"
                             style="margin:0 auto 0.4rem">
                            <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/>
                            <polyline points="17 8 12 3 7 8"/>
                            <line x1="12" y1="3" x2="12" y2="15"/>
                        </svg>
                        <p id="foto-label" style="font-size:0.82rem;color:var(--ink-faint)">
                            {{ $postingan->foto ? 'Klik atau seret untuk ganti foto' : 'Klik atau seret untuk unggah foto' }}
                        </p>
                        <input id="foto-input" type="file" name="foto" accept="image/*" style="display:none"
                               onchange="previewFoto(this)">
                    </div>
                </div>

                {{-- Action Buttons --}}
                <div style="display:flex;justify-content:space-between;align-items:center;gap:0.75rem;flex-wrap:wrap">
                    <a href="{{ request('redirect_back', old('redirect_back', route('postingan.show', $postingan->id))) }}" class="bk-btn bk-btn--ghost">
                        Batal
                    </a>
                    <button type="submit" class="bk-btn bk-btn--primary" style="padding:0.6rem 1.75rem">
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none"
                             stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/>
                            <polyline points="17 21 17 13 7 13 7 21"/>
                            <polyline points="7 3 7 8 15 8"/>
                        </svg>
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
    <script>
        function previewFoto(input) {
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = e => {
                    const label = document.getElementById('foto-label');
                    label.textContent = '✓ ' + input.files[0].name;
                    const drop = document.getElementById('foto-drop');
                    drop.style.borderColor = 'var(--success)';
                    drop.style.background = 'var(--success-light)';
                };
                reader.readAsDataURL(input.files[0]);
            }
        }

        function handleDrop(e) {
            e.preventDefault();
            const drop = document.getElementById('foto-drop');
            drop.style.borderColor = 'var(--border)';
            drop.style.background = '';
            const input = document.getElementById('foto-input');
            const dt = e.dataTransfer;
            if (dt.files.length) {
                input.files = dt.files;
                previewFoto(input);
            }
        }
    </script>
    @endpush
</x-app-layout>
