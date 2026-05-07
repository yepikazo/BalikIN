<x-guest-layout>
    <h1 class="guest-form-title">Buat Akun</h1>
    <p class="guest-form-sub">Bergabunglah dengan komunitas Balik.in</p>

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <div class="form-group">
            <label class="form-label" for="name">Nama Lengkap</label>
            <input id="name" class="form-input" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name" placeholder="Nama Anda">
            @error('name')<div class="form-error">{{ $message }}</div>@enderror
        </div>

        <div class="form-group">
            <label class="form-label" for="email">Email</label>
            <input id="email" class="form-input" type="email" name="email" value="{{ old('email') }}" required autocomplete="username" placeholder="nama@email.com">
            @error('email')<div class="form-error">{{ $message }}</div>@enderror
        </div>

        <div class="form-group">
            <label class="form-label" for="password">Kata Sandi</label>
            <input id="password" class="form-input" type="password" name="password" required autocomplete="new-password" placeholder="Minimal 8 karakter">
            @error('password')<div class="form-error">{{ $message }}</div>@enderror
        </div>

        <div class="form-group">
            <label class="form-label" for="password_confirmation">Konfirmasi Kata Sandi</label>
            <input id="password_confirmation" class="form-input" type="password" name="password_confirmation" required autocomplete="new-password" placeholder="Ulangi kata sandi">
            @error('password_confirmation')<div class="form-error">{{ $message }}</div>@enderror
        </div>

        <button type="submit" class="form-submit">Buat Akun</button>
    </form>

    <div class="form-footer">
        Sudah punya akun? <a href="{{ route('login') }}">Masuk</a>
    </div>
</x-guest-layout>
