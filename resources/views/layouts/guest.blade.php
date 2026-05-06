<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Balik.in') }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:opsz,wght@9..40,300;9..40,400;9..40,500;9..40,600;9..40,700&family=DM+Serif+Display:ital@0;1&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        :root {
            --ink: #0f0e0d;
            --ink-muted: #5a5650;
            --ink-faint: #9e9890;
            --surface: #faf9f7;
            --surface-2: #f2f0ec;
            --border: #ddd9d1;
            --border-subtle: #ede9e2;
            --accent: #c8922a;
            --accent-light: #f5e9d0;
            --accent-dark: #a37320;
            --danger: #c0392b;
            --danger-light: #fdecea;
            --success: #2d7d46;
            --success-light: #e6f4eb;
            --radius-sm: 6px;
            --radius-md: 10px;
            --radius-lg: 16px;
            --font-display: 'DM Serif Display', Georgia, serif;
            --font-body: 'DM Sans', system-ui, sans-serif;
        }
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        html { -webkit-font-smoothing: antialiased; }
        body { font-family: var(--font-body); background: var(--surface); color: var(--ink); min-height: 100vh; display: flex; }
        a { color: inherit; text-decoration: none; }

        .guest-layout {
            display: flex;
            min-height: 100vh;
            width: 100%;
        }

        /* Left panel - decorative */
        .guest-panel {
            flex: 1;
            background: var(--ink);
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            padding: 3rem;
            position: relative;
            overflow: hidden;
        }
        @media (max-width: 768px) { .guest-panel { display: none; } }

        .guest-panel__brand {
            font-family: var(--font-display);
            font-size: 2rem;
            color: white;
            letter-spacing: -0.02em;
        }
        .guest-panel__brand span { color: var(--accent); }

        .guest-panel__tagline {
            color: rgba(255,255,255,0.5);
            font-size: 0.85rem;
            margin-top: 0.3rem;
        }

        .guest-panel__visual {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 320px;
            height: 320px;
            border-radius: 50%;
            border: 1px solid rgba(200,146,42,0.2);
        }
        .guest-panel__visual::after {
            content: '';
            position: absolute;
            top: 20px; left: 20px; right: 20px; bottom: 20px;
            border-radius: 50%;
            border: 1px solid rgba(200,146,42,0.15);
        }

        .guest-panel__quote {
            color: rgba(255,255,255,0.4);
            font-size: 0.82rem;
            line-height: 1.6;
            max-width: 280px;
        }

        /* Right panel - form */
        .guest-form-panel {
            width: 440px;
            flex-shrink: 0;
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 3rem 2.5rem;
            background: white;
            border-left: 1px solid var(--border-subtle);
        }
        @media (max-width: 768px) {
            .guest-form-panel { width: 100%; border-left: none; }
        }

        .guest-form-title {
            font-family: var(--font-display);
            font-size: 1.7rem;
            letter-spacing: -0.02em;
            margin-bottom: 0.4rem;
        }
        .guest-form-sub { font-size: 0.85rem; color: var(--ink-muted); margin-bottom: 2rem; }

        .form-group { margin-bottom: 1.1rem; }
        .form-label {
            display: block;
            font-size: 0.75rem;
            font-weight: 600;
            letter-spacing: 0.05em;
            text-transform: uppercase;
            color: var(--ink-muted);
            margin-bottom: 0.4rem;
        }
        .form-input {
            width: 100%;
            padding: 0.65rem 0.875rem;
            border: 1px solid var(--border);
            border-radius: var(--radius-sm);
            font-size: 0.9rem;
            font-family: var(--font-body);
            color: var(--ink);
            outline: none;
            transition: border-color 0.15s, box-shadow 0.15s;
            background: var(--surface);
        }
        .form-input:focus { border-color: var(--accent); box-shadow: 0 0 0 3px var(--accent-light); background: white; }
        .form-input::placeholder { color: var(--ink-faint); }

        .form-error { font-size: 0.78rem; color: var(--danger); margin-top: 0.3rem; }

        .form-submit {
            width: 100%;
            padding: 0.75rem;
            background: var(--ink);
            color: white;
            border: none;
            border-radius: var(--radius-sm);
            font-size: 0.9rem;
            font-weight: 600;
            font-family: var(--font-body);
            cursor: pointer;
            transition: background 0.15s;
            margin-top: 0.5rem;
        }
        .form-submit:hover { background: #2a2825; }

        .form-divider {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            margin: 1.25rem 0;
            color: var(--ink-faint);
            font-size: 0.78rem;
        }
        .form-divider::before, .form-divider::after {
            content: '';
            flex: 1;
            height: 1px;
            background: var(--border);
        }

        /* OAuth buttons */
        .oauth-btn {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.6rem;
            width: 100%;
            padding: 0.65rem 1rem;
            border: 1px solid var(--border);
            border-radius: var(--radius-sm);
            font-size: 0.875rem;
            font-family: var(--font-body);
            font-weight: 500;
            color: var(--ink);
            background: white;
            cursor: pointer;
            text-decoration: none;
            transition: background 0.15s, border-color 0.15s;
            margin-bottom: 0.6rem;
        }
        .oauth-btn:hover { background: var(--surface-2); border-color: var(--border); }

        .form-footer { font-size: 0.82rem; color: var(--ink-muted); margin-top: 1.5rem; text-align: center; }
        .form-footer a { color: var(--accent-dark); font-weight: 600; }

        .form-link {
            font-size: 0.82rem;
            color: var(--ink-faint);
            display: block;
            margin-top: 0.5rem;
        }
        .form-link:hover { color: var(--accent); }

        .checkbox-row { display: flex; align-items: center; gap: 0.5rem; margin-top: 0.5rem; }
        .checkbox-row input { accent-color: var(--accent); }
        .checkbox-row label { font-size: 0.85rem; color: var(--ink-muted); cursor: pointer; }

        /* Alert */
        .auth-alert { padding: 0.7rem 0.875rem; border-radius: var(--radius-sm); font-size: 0.82rem; margin-bottom: 1rem; background: var(--success-light); color: var(--success); border: 1px solid #b7e0c5; }
    </style>
</head>
<body>
<div class="guest-layout">
    <!-- Decorative left panel -->
    <div class="guest-panel">
        <div>
            <div class="guest-panel__brand">Balik<span>.in</span></div>
            <div class="guest-panel__tagline">Platform Barang Hilang & Temuan</div>
        </div>
        <div class="guest-panel__visual"></div>
        <div class="guest-panel__quote">
            Setiap barang yang hilang meninggalkan jejak. Bersama, kita telusuri.
        </div>
    </div>

    <!-- Form panel -->
    <div class="guest-form-panel">
        {{ $slot }}
    </div>
</div>
</body>
</html>
