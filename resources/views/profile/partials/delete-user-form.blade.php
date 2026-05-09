<section style="max-width:36rem">
    <header style="margin-bottom:1.5rem">
        <h2 style="font-size:1.25rem;font-weight:700;color:var(--danger)">
            {{ __('Hapus Akun') }}
        </h2>
        <p style="font-size:0.875rem;color:var(--ink-muted);margin-top:0.35rem">
            {{ __('Setelah akun Anda dihapus, semua sumber daya dan data akan dihapus secara permanen. Sebelum menghapus akun Anda, harap unduh data atau informasi apa pun yang ingin Anda simpan.') }}
        </p>
    </header>

    <button
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
        class="bk-btn bk-btn--danger"
    >{{ __('Hapus Akun') }}</button>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" style="padding:2rem">
            @csrf
            @method('delete')

            <h2 style="font-size:1.25rem;font-weight:700;color:var(--ink);margin-bottom:0.5rem">
                {{ __('Apakah Anda yakin ingin menghapus akun Anda?') }}
            </h2>

            <p style="font-size:0.875rem;color:var(--ink-muted);margin-bottom:1.25rem;line-height:1.6">
                {{ __('Setelah akun Anda dihapus, semua sumber daya dan data akan dihapus secara permanen. Silakan masukkan kata sandi Anda untuk mengonfirmasi bahwa Anda ingin menghapus akun Anda secara permanen.') }}
            </p>

            <div style="margin-bottom:1.5rem">
                <label for="password" style="display:none">{{ __('Kata Sandi') }}</label>
                <input
                    id="password"
                    name="password"
                    type="password"
                    class="bk-input"
                    placeholder="{{ __('Kata Sandi') }}"
                    style="width:100%"
                />
                @error('password', 'userDeletion')
                    <div style="font-size:0.75rem;color:var(--danger);margin-top:0.3rem">{{ $message }}</div>
                @enderror
            </div>

            <div style="display:flex;justify-content:flex-end;gap:0.75rem">
                <button type="button" x-on:click="$dispatch('close')" class="bk-btn bk-btn--ghost">
                    {{ __('Batal') }}
                </button>

                <button type="submit" class="bk-btn bk-btn--danger">
                    {{ __('Hapus Akun') }}
                </button>
            </div>
        </form>
    </x-modal>
</section>
