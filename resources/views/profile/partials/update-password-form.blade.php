<section style="max-width:36rem">
    <header style="margin-bottom:1.5rem">
        <h2 style="font-size:1.25rem;font-weight:700;color:var(--ink)">
            {{ __('Ubah Kata Sandi') }}
        </h2>
        <p style="font-size:0.875rem;color:var(--ink-muted);margin-top:0.35rem">
            {{ __('Pastikan akun Anda menggunakan kata sandi panjang dan acak untuk tetap aman.') }}
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}" style="display:flex;flex-direction:column;gap:1.25rem">
        @csrf
        @method('put')

        <div>
            <label for="update_password_current_password" class="bk-label">{{ __('Kata Sandi Saat Ini') }}</label>
            <input id="update_password_current_password" name="current_password" type="password" class="bk-input" autocomplete="current-password" />
            @error('current_password', 'updatePassword')
                <div style="font-size:0.75rem;color:var(--danger);margin-top:0.3rem">{{ $message }}</div>
            @enderror
        </div>

        <div>
            <label for="update_password_password" class="bk-label">{{ __('Kata Sandi Baru') }}</label>
            <input id="update_password_password" name="password" type="password" class="bk-input" autocomplete="new-password" />
            @error('password', 'updatePassword')
                <div style="font-size:0.75rem;color:var(--danger);margin-top:0.3rem">{{ $message }}</div>
            @enderror
        </div>

        <div>
            <label for="update_password_password_confirmation" class="bk-label">{{ __('Konfirmasi Kata Sandi') }}</label>
            <input id="update_password_password_confirmation" name="password_confirmation" type="password" class="bk-input" autocomplete="new-password" />
            @error('password_confirmation', 'updatePassword')
                <div style="font-size:0.75rem;color:var(--danger);margin-top:0.3rem">{{ $message }}</div>
            @enderror
        </div>

        <div style="display:flex;align-items:center;gap:1rem;margin-top:0.5rem">
            <button type="submit" class="bk-btn bk-btn--primary">{{ __('Simpan') }}</button>

            @if (session('status') === 'password-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    style="font-size:0.875rem;color:var(--ink-muted)"
                >{{ __('Tersimpan.') }}</p>
            @endif
        </div>
    </form>
</section>
