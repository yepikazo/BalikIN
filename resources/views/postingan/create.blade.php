<x-app-layout>
    <x-slot:title>Buat Laporan — Balik.in</x-slot>

    <div style="max-width:640px;margin:0 auto">
        <div class="bk-page-header">
            <h1 class="bk-page-header__title">Buat Laporan</h1>
            <p class="bk-page-header__sub">Isi detail barang hilang atau barang temuan Anda.</p>
        </div>

        <div class="bk-card" style="padding:2rem;box-shadow:var(--shadow-md)">
            <form action="{{ route('postingan.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem;margin-bottom:1.25rem">
                    <div>
                        <label class="bk-label">Tipe Laporan</label>
                        <select name="tipe" class="bk-input" required>
                            <option value="hilang" {{ old('tipe') == 'hilang' ? 'selected' : '' }}>Kehilangan Barang</option>
                            <option value="ditemukan" {{ old('tipe') == 'ditemukan' ? 'selected' : '' }}>Menemukan Barang</option>
                        </select>
                    </div>
                    <div>
                        <label class="bk-label">Kategori</label>
                        <select name="kategori" class="bk-input" required>
                            <option value="Elektronik">Elektronik</option>
                            <option value="Dokumen/Kartu">Dokumen / Kartu</option>
                            <option value="Aksesoris">Aksesoris</option>
                            <option value="Kendaraan">Kendaraan</option>
                            <option value="Pakaian">Pakaian</option>
                            <option value="Lainnya">Lainnya</option>
                        </select>
                    </div>
                </div>

                <div style="margin-bottom:1.25rem">
                    <label class="bk-label">Nama Barang</label>
                    <input type="text" name="nama_barang" value="{{ old('nama_barang') }}" class="bk-input" placeholder="Contoh: Dompet kulit hitam" required>
                </div>

                <div style="margin-bottom:1.25rem">
                    <label class="bk-label">Lokasi Kejadian</label>
                    <input type="text" name="lokasi" value="{{ old('lokasi') }}" class="bk-input" placeholder="Contoh: Parkiran Gedung F, Lantai 2" required>
                </div>

                <div style="margin-bottom:1.25rem">
                    <label class="bk-label">Waktu Kejadian</label>
                    <input type="datetime-local" name="waktu_kejadian" value="{{ old('waktu_kejadian') }}" class="bk-input" required>
                </div>

                <div style="margin-bottom:1.25rem">
                    <label class="bk-label">Deskripsi & Ciri-ciri</label>
                    <textarea name="deskripsi" rows="4" class="bk-input" placeholder="Sebutkan ciri-ciri spesifik, warna, merek, atau detail lain yang membantu..." style="resize:vertical" required>{{ old('deskripsi') }}</textarea>
                </div>

                <div style="margin-bottom:1.75rem">
                    <label class="bk-label">Foto Barang</label>

                    <div id="foto-preview-container" style="display:none;margin-bottom:0.875rem;position:relative;">
                        <div style="display:inline-block;position:relative">
                            <img id="foto-preview-img" src="" style="height:140px;border-radius:var(--radius-md);object-fit:cover;border:1px solid var(--border-subtle);display:block" alt="Preview Foto">
                            <button type="button" onclick="hapusFoto()" style="position:absolute;top:-10px;right:-10px;background:var(--danger);color:white;border:none;border-radius:50%;width:26px;height:26px;cursor:pointer;display:flex;align-items:center;justify-content:center;box-shadow:0 2px 4px rgba(0,0,0,0.2);transition:transform 0.1s" onmouseover="this.style.transform='scale(1.1)'" onmouseout="this.style.transform='scale(1)'">
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                            </button>
                        </div>
                    </div>

                    <div id="foto-drop" style="border:2px dashed var(--border);border-radius:var(--radius-md);padding:1.5rem;text-align:center;cursor:pointer;transition:border-color 0.15s, background 0.15s" onclick="document.getElementById('foto-input').click()" ondragover="event.preventDefault();this.style.borderColor='var(--accent)';this.style.background='var(--accent-light)'" ondragleave="this.style.borderColor='var(--border)';this.style.background=''" ondrop="handleDrop(event)">
                        <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="var(--ink-faint)" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" style="margin:0 auto 0.5rem"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" y1="3" x2="12" y2="15"/></svg>
                        <p id="foto-label" style="font-size:0.82rem;color:var(--ink-faint)">Klik atau seret untuk unggah foto</p>
                        <input id="foto-input" type="file" name="foto" accept="image/*" style="display:none" onchange="previewFoto(this)">
                    </div>
                </div>

                <div style="display:flex;justify-content:space-between;align-items:center">
                    <a href="{{ route('beranda') }}" class="bk-btn bk-btn--ghost">Batal</a>
                    <button type="submit" class="bk-btn bk-btn--primary" style="padding:0.6rem 1.75rem">Posting Laporan</button>
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
                    document.getElementById('foto-preview-img').src = e.target.result;
                    document.getElementById('foto-preview-container').style.display = 'block';
                    document.getElementById('foto-drop').style.display = 'none';
                };
                reader.readAsDataURL(input.files[0]);
            }
        }
        function hapusFoto() {
            document.getElementById('foto-input').value = '';
            document.getElementById('foto-preview-container').style.display = 'none';
            document.getElementById('foto-drop').style.display = 'block';
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
