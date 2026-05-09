<x-app-layout>
    <x-slot:title>Profil Saya — Balik.in</x-slot>

    <div style="max-width:880px;margin:0 auto;padding-bottom:3rem">
        <div class="bk-page-header" style="margin-bottom:2rem">
            <h1 class="bk-page-header__title" style="font-size:1.85rem;font-weight:800;letter-spacing:-0.03em;color:var(--ink)">Profil Saya</h1>
            <p class="bk-page-header__sub" style="font-size:0.95rem;color:var(--ink-muted);margin-top:0.35rem">Kelola informasi akun dan pengaturan keamanan Anda.</p>
        </div>

        <div style="display:flex;flex-direction:column;gap:1.5rem">
            <div class="bk-card" style="padding:2rem">
                @include('profile.partials.update-profile-information-form')
            </div>

            <div class="bk-card" style="padding:2rem">
                @include('profile.partials.update-password-form')
            </div>

            <div class="bk-card" style="padding:2rem;border-color:#f5c0bc;background:var(--danger-light)">
                @include('profile.partials.delete-user-form')
            </div>
        </div>
    </div>
</x-app-layout>
