<section style="max-width:36rem">
    <header style="margin-bottom:1.5rem">
        <h2 style="font-size:1.25rem;font-weight:700;color:var(--ink)">
            {{ __('Informasi Profil') }}
        </h2>
        <p style="font-size:0.875rem;color:var(--ink-muted);margin-top:0.35rem">
            {{ __("Perbarui nama dan alamat email akun Anda.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" style="display:flex;flex-direction:column;gap:1.25rem">
        @csrf
        @method('patch')

        <div>
            <label for="name" class="bk-label">{{ __('Nama') }}</label>
            <input id="name" name="name" type="text" class="bk-input" value="{{ old('name', $user->name) }}" required autofocus autocomplete="name" />
            @error('name')
                <div style="font-size:0.75rem;color:var(--danger);margin-top:0.3rem">{{ $message }}</div>
            @enderror
        </div>

        <div>
            <label for="email" class="bk-label">{{ __('Email') }}</label>
            <input id="email" name="email" type="email" class="bk-input" value="{{ old('email', $user->email) }}" required autocomplete="username" />
            @error('email')
                <div style="font-size:0.75rem;color:var(--danger);margin-top:0.3rem">{{ $message }}</div>
            @enderror

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div style="margin-top:0.75rem">
                    <p style="font-size:0.875rem;color:var(--ink-muted)">
                        {{ __('Alamat email Anda belum diverifikasi.') }}

                        <button form="send-verification" style="background:none;border:none;padding:0;font:inherit;color:var(--accent-dark);text-decoration:underline;cursor:pointer">
                            {{ __('Klik di sini untuk mengirim ulang email verifikasi.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p style="font-size:0.875rem;color:var(--success);margin-top:0.35rem;font-weight:500">
                            {{ __('Link verifikasi baru telah dikirim ke alamat email Anda.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div style="display:flex;align-items:center;gap:1rem;margin-top:0.5rem">
            <button type="submit" class="bk-btn bk-btn--primary">{{ __('Simpan') }}</button>

            @if (session('status') === 'profile-updated')
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
