<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'Balik.in — Temukan Barang Hilang' }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        /* ===========================
           BALIK.IN DESIGN SYSTEM
        =========================== */
        :root {
            --ink: #0f0e0d;
            --ink-muted: #5a5650;
            --ink-faint: #9e9890;
            --surface: #faf9f7;
            --surface-2: #f2f0ec;
            --surface-3: #e8e4de;
            --border: #ddd9d1;
            --border-subtle: #ede9e2;
            --accent: #c8922a;
            --accent-light: #f5e9d0;
            --accent-dark: #a37320;
            --danger: #c0392b;
            --danger-light: #fdecea;
            --success: #2d7d46;
            --success-light: #e6f4eb;
            --shadow-sm: 0 1px 3px rgba(15, 14, 13, 0.07), 0 1px 2px rgba(15, 14, 13, 0.04);
            --shadow-md: 0 4px 12px rgba(15, 14, 13, 0.08), 0 2px 6px rgba(15, 14, 13, 0.05);
            --shadow-lg: 0 16px 40px rgba(15, 14, 13, 0.10), 0 4px 12px rgba(15, 14, 13, 0.06);
            --radius-sm: 6px;
            --radius-md: 10px;
            --radius-lg: 16px;
            --radius-full: 999px;
            --font-display: 'Inter', system-ui, sans-serif;
            --font-body: 'Inter', system-ui, sans-serif;
        }

        *,
        *::before,
        *::after {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        html {
            font-size: 16px;
            -webkit-font-smoothing: antialiased;
        }

        body {
            font-family: var(--font-body);
            background-color: var(--surface);
            color: var(--ink);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        a {
            color: inherit;
            text-decoration: none;
        }

        /* ===========================
           NAVBAR
        =========================== */
        .bk-navbar {
            position: sticky;
            top: 0;
            z-index: 100;
            background: rgba(250, 249, 247, 0.92);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border-bottom: 1px solid var(--border-subtle);
        }

        .bk-navbar__inner {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 1.5rem;
            height: 60px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 1rem;
        }

        .bk-navbar__brand {
            font-family: var(--font-body);
            font-size: 1.4rem;
            font-weight: 800;
            letter-spacing: -0.04em;
            color: var(--ink);
            flex-shrink: 0;
        }

        .bk-navbar__brand-dot {
            color: var(--accent);
        }

        .bk-navbar__actions {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .bk-icon-btn {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 38px;
            height: 38px;
            border-radius: var(--radius-sm);
            color: var(--ink-muted);
            transition: color 0.15s, background 0.15s;
        }

        .bk-icon-btn:hover {
            color: var(--ink);
            background: var(--surface-2);
        }

        .bk-admin-badge {
            font-size: 0.7rem;
            font-weight: 600;
            letter-spacing: 0.05em;
            text-transform: uppercase;
            padding: 3px 8px;
            border-radius: var(--radius-full);
            background: var(--danger);
            color: white;
        }

        /* Avatar button */
        .bk-avatar-btn {
            width: 34px;
            height: 34px;
            border-radius: var(--radius-full);
            background: var(--ink);
            color: var(--surface);
            font-weight: 600;
            font-size: 0.8rem;
            display: flex;
            align-items: center;
            justify-content: center;
            border: none;
            cursor: pointer;
            transition: opacity 0.15s;
        }

        .bk-avatar-btn:hover {
            opacity: 0.8;
        }

        /* Dropdown */
        .bk-dropdown {
            position: relative;
        }

        .bk-dropdown__menu {
            position: absolute;
            top: calc(100% + 8px);
            right: 0;
            background: white;
            border: 1px solid var(--border);
            border-radius: var(--radius-md);
            box-shadow: var(--shadow-lg);
            min-width: 200px;
            overflow: hidden;
        }

        .bk-dropdown__header {
            padding: 0.75rem 1rem;
            border-bottom: 1px solid var(--border-subtle);
        }

        .bk-dropdown__name {
            font-weight: 600;
            font-size: 0.875rem;
        }

        .bk-dropdown__email {
            font-size: 0.75rem;
            color: var(--ink-faint);
            margin-top: 1px;
        }

        .bk-dropdown__item {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            width: 100%;
            padding: 0.625rem 1rem;
            font-size: 0.875rem;
            color: var(--ink-muted);
            background: none;
            border: none;
            cursor: pointer;
            text-align: left;
            transition: background 0.1s, color 0.1s;
            font-family: var(--font-body);
        }

        .bk-dropdown__item:hover {
            background: var(--surface-2);
            color: var(--ink);
        }

        .bk-dropdown__item--danger:hover {
            background: var(--danger-light);
            color: var(--danger);
        }

        /* Buttons */
        .bk-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.4rem;
            padding: 0.45rem 1rem;
            border-radius: var(--radius-sm);
            font-size: 0.875rem;
            font-weight: 500;
            font-family: var(--font-body);
            cursor: pointer;
            border: 1px solid transparent;
            transition: all 0.15s;
        }

        .bk-btn--ghost {
            color: var(--ink-muted);
            border-color: var(--border);
            background: transparent;
        }

        .bk-btn--ghost:hover {
            background: var(--surface-2);
            color: var(--ink);
        }

        .bk-btn--primary {
            background: var(--ink);
            color: var(--surface);
            border-color: var(--ink);
        }

        .bk-btn--primary:hover {
            background: #2a2825;
        }

        .bk-btn--accent {
            background: var(--accent);
            color: white;
            border-color: var(--accent);
        }

        .bk-btn--accent:hover {
            background: var(--accent-dark);
        }

        .bk-btn--danger {
            background: var(--danger);
            color: white;
            border-color: var(--danger);
        }

        .bk-btn--danger:hover {
            background: #a93226;
        }

        .bk-btn--outline-accent {
            color: var(--accent-dark);
            border-color: var(--accent);
            background: var(--accent-light);
        }

        .bk-btn--outline-accent:hover {
            background: var(--accent);
            color: white;
        }

        /* Mobile navbar */
        .bk-navbar__hamburger {
            display: none;
            flex-direction: column;
            gap: 4px;
            background: none;
            border: none;
            cursor: pointer;
            color: var(--ink);
            padding: 4px;
        }

        .bk-navbar__mobile {
            padding: 0.75rem 1.5rem 1rem;
            border-top: 1px solid var(--border-subtle);
            display: flex;
            flex-direction: column;
            gap: 2px;
        }

        .bk-mobile-link {
            display: block;
            padding: 0.625rem 0.75rem;
            border-radius: var(--radius-sm);
            font-size: 0.9rem;
            color: var(--ink-muted);
            background: none;
            border: none;
            width: 100%;
            text-align: left;
            font-family: var(--font-body);
            cursor: pointer;
            transition: background 0.1s, color 0.1s;
        }

        .bk-mobile-link:hover {
            background: var(--surface-2);
            color: var(--ink);
        }

        .bk-mobile-link--accent {
            color: var(--accent);
            font-weight: 600;
        }

        .bk-mobile-link--admin {
            color: var(--danger);
            font-weight: 600;
        }

        .bk-mobile-link--danger:hover {
            background: var(--danger-light);
            color: var(--danger);
        }

        @media (max-width: 640px) {
            .bk-navbar__actions .bk-btn {
                display: none;
            }

            .bk-navbar__hamburger {
                display: flex;
            }

            .bk-navbar__actions .bk-icon-btn,
            .bk-navbar__actions .bk-avatar-btn,
            .bk-navbar__actions .bk-admin-badge,
            .bk-navbar__actions .bk-dropdown {
                display: none;
            }
        }

        /* ===========================
           LAYOUT
        =========================== */
        .bk-main {
            flex: 1;
            max-width: 1200px;
            width: 100%;
            margin: 0 auto;
            padding: 2rem 1.5rem;
        }

        /* ===========================
           CARDS
        =========================== */
        .bk-card {
            background: white;
            border: 1px solid var(--border-subtle);
            border-radius: var(--radius-lg);
            overflow: hidden;
            transition: box-shadow 0.2s, transform 0.2s;
        }

        .bk-card:hover {
            box-shadow: var(--shadow-md);
            transform: translateY(-2px);
        }

        /* ===========================
           BADGE
        =========================== */
        .bk-badge {
            display: inline-block;
            font-size: 0.65rem;
            font-weight: 700;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            padding: 3px 8px;
            border-radius: var(--radius-full);
        }

        .bk-badge--hilang {
            background: var(--danger-light);
            color: var(--danger);
        }

        .bk-badge--ditemukan {
            background: var(--success-light);
            color: var(--success);
        }

        .bk-badge--aktif {
            background: var(--success-light);
            color: var(--success);
        }

        .bk-badge--selesai {
            background: var(--surface-3);
            color: var(--ink-muted);
        }

        /* ===========================
           FORM ELEMENTS
        =========================== */
        .bk-input {
            width: 100%;
            padding: 0.65rem 0.875rem;
            border: 1px solid var(--border);
            border-radius: var(--radius-sm);
            font-size: 0.9rem;
            font-family: var(--font-body);
            background: white;
            color: var(--ink);
            outline: none;
            transition: border-color 0.15s, box-shadow 0.15s;
        }

        .bk-input:focus {
            border-color: var(--accent);
            box-shadow: 0 0 0 3px var(--accent-light);
        }

        .bk-input::placeholder {
            color: var(--ink-faint);
        }

        .bk-label {
            display: block;
            font-size: 0.8rem;
            font-weight: 600;
            letter-spacing: 0.03em;
            color: var(--ink-muted);
            margin-bottom: 0.4rem;
            text-transform: uppercase;
        }

        /* ===========================
           ALERT
        =========================== */
        .bk-alert {
            padding: 0.75rem 1rem;
            border-radius: var(--radius-sm);
            font-size: 0.875rem;
            margin-bottom: 1rem;
        }

        .bk-alert--success {
            background: var(--success-light);
            color: var(--success);
            border: 1px solid #b7e0c5;
        }

        .bk-alert--error {
            background: var(--danger-light);
            color: var(--danger);
            border: 1px solid #f5c0bc;
        }

        /* ===========================
           PAGE HEADER
        =========================== */
        .bk-page-header {
            margin-bottom: 2rem;
        }

        .bk-page-header__title {
            font-family: var(--font-display);
            font-size: 2rem;
            font-weight: 800;
            letter-spacing: -0.03em;
            color: var(--ink);
            line-height: 1.2;
        }

        .bk-page-header__sub {
            font-size: 0.9rem;
            color: var(--ink-muted);
            margin-top: 0.4rem;
        }

        /* ===========================
           FOOTER
        =========================== */
        .bk-footer {
            border-top: 1px solid var(--border-subtle);
            padding: 1.25rem 1.5rem;
            text-align: center;
            font-size: 0.8rem;
            color: var(--ink-faint);
        }

        /* ===========================
           CHAT PANEL
        =========================== */
        .bk-chat-panel {
            position: fixed;
            bottom: 1.5rem;
            right: 1.5rem;
            z-index: 200;
        }

        .bk-chat-fab {
            width: 52px;
            height: 52px;
            border-radius: var(--radius-full);
            background: var(--ink);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            border: none;
            box-shadow: var(--shadow-lg);
            transition: transform 0.2s;
        }

        .bk-chat-fab:hover {
            transform: scale(1.05);
        }

        .bk-chat-window {
            position: absolute;
            bottom: 64px;
            right: 0;
            width: 340px;
            max-height: 500px;
            background: white;
            border: 1px solid var(--border);
            border-radius: var(--radius-lg);
            box-shadow: var(--shadow-lg);
            display: flex;
            flex-direction: column;
            overflow: hidden;
        }

        .bk-chat-header {
            padding: 0.875rem 1rem;
            border-bottom: 1px solid var(--border-subtle);
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .bk-chat-header__title {
            font-weight: 600;
            font-size: 0.9rem;
        }

        .bk-chat-header__close {
            background: none;
            border: none;
            cursor: pointer;
            color: var(--ink-muted);
            padding: 2px;
        }

        .bk-chat-convo-list {
            overflow-y: auto;
            flex: 1;
        }

        .bk-chat-convo-item {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.75rem 1rem;
            cursor: pointer;
            transition: background 0.1s;
            border-bottom: 1px solid var(--border-subtle);
        }

        .bk-chat-convo-item:hover {
            background: var(--surface-2);
        }

        .bk-chat-convo-avatar {
            width: 38px;
            height: 38px;
            border-radius: var(--radius-full);
            background: var(--surface-3);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 0.85rem;
            flex-shrink: 0;
        }

        .bk-chat-convo-info {
            flex: 1;
            min-width: 0;
        }

        .bk-chat-convo-name {
            font-weight: 600;
            font-size: 0.875rem;
        }

        .bk-chat-convo-last {
            font-size: 0.75rem;
            color: var(--ink-faint);
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .bk-chat-messages {
            flex: 1;
            overflow-y: auto;
            padding: 1rem;
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }

        .bk-chat-msg {
            max-width: 75%;
            padding: 0.5rem 0.75rem;
            border-radius: 14px;
            font-size: 0.85rem;
            line-height: 1.4;
        }

        .bk-chat-msg--sent {
            background: var(--ink);
            color: white;
            align-self: flex-end;
            border-bottom-right-radius: 4px;
        }

        .bk-chat-msg--received {
            background: var(--surface-2);
            color: var(--ink);
            align-self: flex-start;
            border-bottom-left-radius: 4px;
        }

        .bk-chat-input-row {
            padding: 0.75rem;
            border-top: 1px solid var(--border-subtle);
            display: flex;
            gap: 0.5rem;
        }

        .bk-chat-input-row input {
            flex: 1;
            padding: 0.5rem 0.75rem;
            border: 1px solid var(--border);
            border-radius: var(--radius-full);
            font-size: 0.85rem;
            font-family: var(--font-body);
            outline: none;
        }

        .bk-chat-input-row input:focus {
            border-color: var(--accent);
        }

        .bk-chat-send-btn {
            width: 34px;
            height: 34px;
            border-radius: var(--radius-full);
            background: var(--ink);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            border: none;
            cursor: pointer;
            flex-shrink: 0;
            transition: background 0.15s;
        }

        .bk-chat-send-btn:hover {
            background: var(--accent);
        }

        /* Mention badge in post */
        .bk-mention-btn {
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            padding: 0.45rem 0.875rem;
            border: 1px solid var(--border);
            border-radius: var(--radius-full);
            font-size: 0.8rem;
            font-weight: 500;
            color: var(--ink-muted);
            background: var(--surface-2);
            cursor: pointer;
            transition: all 0.15s;
        }

        .bk-mention-btn:hover {
            border-color: var(--accent);
            color: var(--accent-dark);
            background: var(--accent-light);
        }

        /* ===========================
           UTILITIES
        =========================== */
        .text-muted {
            color: var(--ink-muted);
        }

        .text-faint {
            color: var(--ink-faint);
        }

        .text-accent {
            color: var(--accent);
        }

        .text-danger {
            color: var(--danger);
        }

        .font-display {
            font-family: var(--font-display);
        }
    </style>
    @stack('styles')
</head>

<body>
    <x-navbar />

    <main class="bk-main">
        <x-alert />
        {{ $slot }}
    </main>

    <footer class="bk-footer">
        &copy; {{ date('Y') }} Balik.in &mdash; Universitas Siliwangi
    </footer>

    @auth
        <!-- WebSocket Chat Panel -->
        <div class="bk-chat-panel" x-data="chatApp()" x-init="init()">

            <!-- FAB Button -->
            <button @click="togglePanel()" class="bk-chat-fab" title="Pesan">
                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z" />
                </svg>
                <span x-show="unread > 0" class="bk-chat-unread-badge" x-text="unread > 9 ? '9+' : unread"></span>
            </button>

            <!-- Chat Window -->
            <div x-show="open" x-transition.origin.bottom.right class="bk-chat-window">

                <!-- ==================== CONVERSATION LIST ==================== -->
                <template x-if="!activeConvo">
                    <div style="display:flex;flex-direction:column;height:100%">
                        <!-- Header -->
                        <div class="bk-chat-header">
                            <div style="display:flex;align-items:center;gap:0.5rem">
                                <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24"
                                    fill="none" stroke="var(--accent)" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round">
                                    <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z" />
                                </svg>
                                <span class="bk-chat-header__title">Pesan</span>
                            </div>
                            <button @click="open = false" class="bk-chat-header__close" title="Tutup">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round">
                                    <line x1="18" y1="6" x2="6" y2="18" />
                                    <line x1="6" y1="6" x2="18" y2="18" />
                                </svg>
                            </button>
                        </div>

                        <!-- Loading state -->
                        <template x-if="loadingConvos">
                            <div style="padding:2rem 1rem;text-align:center">
                                <div class="bk-chat-spinner"></div>
                                <p style="font-size:0.8rem;color:var(--ink-faint);margin-top:0.5rem">Memuat percakapan...
                                </p>
                            </div>
                        </template>

                        <!-- List percakapan -->
                        <template x-if="!loadingConvos">
                            <div class="bk-chat-convo-list">
                                <template x-for="convo in conversations" :key="convo.id">
                                    <div @click="openConvo(convo)" class="bk-chat-convo-item">
                                        <div class="bk-chat-convo-avatar" x-text="convo.name.charAt(0).toUpperCase()"></div>
                                        <div class="bk-chat-convo-info">
                                            <div class="bk-chat-convo-name" x-text="convo.name"></div>
                                            <div class="bk-chat-convo-last" x-text="convo.lastMessage || 'Belum ada pesan'">
                                            </div>
                                        </div>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14"
                                            viewBox="0 0 24 24" fill="none" stroke="var(--ink-faint)" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round" style="flex-shrink:0">
                                            <polyline points="9 18 15 12 9 6" />
                                        </svg>
                                    </div>
                                </template>

                                <!-- Empty state -->
                                <div x-show="conversations.length === 0" style="padding:2.5rem 1.25rem;text-align:center">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="36" height="36"
                                        viewBox="0 0 24 24" fill="none" stroke="var(--surface-3)" stroke-width="1.5"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        style="margin:0 auto 0.75rem;display:block">
                                        <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z" />
                                    </svg>
                                    <p style="font-size:0.85rem;font-weight:600;color:var(--ink-muted)">Belum ada
                                        percakapan</p>
                                    <p style="font-size:0.78rem;color:var(--ink-faint);margin-top:0.3rem">Klik "Hubungi
                                        Pelapor" di halaman detail barang.</p>
                                </div>
                            </div>
                        </template>
                    </div>
                </template>

                <!-- ==================== ACTIVE CONVERSATION ==================== -->
                <template x-if="activeConvo">
                    <div style="display:flex;flex-direction:column;height:100%">

                        <!-- Header percakapan -->
                        <div class="bk-chat-header">
                            <div style="display:flex;align-items:center;gap:0.625rem;min-width:0">
                                <button @click="backToList()" class="bk-chat-header__close" title="Kembali ke daftar">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"
                                        stroke-linecap="round" stroke-linejoin="round">
                                        <polyline points="15 18 9 12 15 6" />
                                    </svg>
                                </button>
                                <!-- Avatar -->
                                <div style="width:32px;height:32px;border-radius:var(--radius-full);background:var(--accent);color:white;font-size:0.8rem;font-weight:700;display:flex;align-items:center;justify-content:center;flex-shrink:0"
                                    x-text="activeConvo.name.charAt(0).toUpperCase()"></div>
                                <div style="min-width:0">
                                    <div class="bk-chat-header__title" x-text="activeConvo.name"
                                        style="white-space:nowrap;overflow:hidden;text-overflow:ellipsis"></div>
                                    <div style="font-size:0.68rem;color:var(--ink-faint)"
                                        x-text="activeConvo.context || ''"></div>
                                </div>
                            </div>
                            <button @click="open = false" class="bk-chat-header__close" title="Tutup">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round">
                                    <line x1="18" y1="6" x2="6" y2="18" />
                                    <line x1="6" y1="6" x2="18" y2="18" />
                                </svg>
                            </button>
                        </div>

                        <!-- Loading messages -->
                        <template x-if="loadingMessages">
                            <div
                                style="flex:1;display:flex;align-items:center;justify-content:center;flex-direction:column;gap:0.5rem">
                                <div class="bk-chat-spinner"></div>
                                <p style="font-size:0.78rem;color:var(--ink-faint)">Memuat pesan...</p>
                            </div>
                        </template>

                        <!-- Daftar pesan -->
                        <template x-if="!loadingMessages">
                            <div class="bk-chat-messages" id="chat-messages-box">

                                <!-- Pesan sambutan jika percakapan baru -->
                                <template x-if="activeMessages.length === 0">
                                    <div style="text-align:center;padding:1.5rem 1rem">
                                        <div style="width:48px;height:48px;border-radius:var(--radius-full);background:var(--accent);color:white;font-size:1.1rem;font-weight:700;display:flex;align-items:center;justify-content:center;margin:0 auto 0.75rem"
                                            x-text="activeConvo.name.charAt(0).toUpperCase()"></div>
                                        <p style="font-size:0.85rem;font-weight:600;color:var(--ink)"
                                            x-text="activeConvo.name"></p>
                                        <p style="font-size:0.78rem;color:var(--ink-faint);margin-top:0.3rem">Mulai
                                            percakapan dengan mengirim pesan.</p>
                                    </div>
                                </template>

                                <template x-for="msg in activeMessages" :key="msg.id">
                                    <div
                                        :class="msg.sent ? 'bk-chat-msg-wrap bk-chat-msg-wrap--sent' :
                                            'bk-chat-msg-wrap bk-chat-msg-wrap--received'">
                                        <div
                                            :class="msg.sent ? 'bk-chat-msg bk-chat-msg--sent' :
                                                'bk-chat-msg bk-chat-msg--received'">
                                            <span x-text="msg.body"></span>
                                        </div>
                                        <div class="bk-chat-msg-time" x-text="msg.time || ''"></div>
                                    </div>
                                </template>

                                <!-- Typing indicator -->
                                <div x-show="sending" class="bk-chat-msg-wrap bk-chat-msg-wrap--sent"
                                    style="opacity:0.6">
                                    <div class="bk-chat-msg bk-chat-msg--sent">
                                        <div class="bk-chat-typing-dots">
                                            <span></span><span></span><span></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </template>

                        <!-- Input area -->
                        <div class="bk-chat-input-row">
                            <input x-model="newMsg" @keydown.enter.prevent="sendMsg()" type="text"
                                placeholder="Tulis pesan..." :disabled="sending" maxlength="500">
                            <button @click="sendMsg()" class="bk-chat-send-btn" :disabled="!newMsg.trim() || sending"
                                :style="(!newMsg.trim() || sending) ? 'opacity:0.5;cursor:not-allowed' : ''">
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round">
                                    <line x1="22" y1="2" x2="11" y2="13" />
                                    <polygon points="22 2 15 22 11 13 2 9 22 2" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </template>
            </div>
        </div>

        <style>
            .bk-chat-unread-badge {
                position: absolute;
                top: -4px;
                right: -4px;
                background: var(--danger);
                color: white;
                border-radius: var(--radius-full);
                font-size: 0.62rem;
                font-weight: 700;
                min-width: 18px;
                height: 18px;
                display: flex;
                align-items: center;
                justify-content: center;
                padding: 0 4px;
                border: 2px solid var(--surface);
            }

            .bk-chat-fab {
                position: relative;
            }

            /* Pesan wrap & timestamp */
            .bk-chat-msg-wrap {
                display: flex;
                flex-direction: column;
            }

            .bk-chat-msg-wrap--sent {
                align-items: flex-end;
            }

            .bk-chat-msg-wrap--received {
                align-items: flex-start;
            }

            .bk-chat-msg-time {
                font-size: 0.62rem;
                color: var(--ink-faint);
                margin-top: 2px;
                padding: 0 4px;
            }

            /* Typing dots animation */
            .bk-chat-typing-dots {
                display: flex;
                gap: 3px;
                align-items: center;
                padding: 2px 4px;
            }

            .bk-chat-typing-dots span {
                width: 6px;
                height: 6px;
                border-radius: 50%;
                background: rgba(255, 255, 255, 0.7);
                animation: bk-bounce 1.2s infinite;
            }

            .bk-chat-typing-dots span:nth-child(2) {
                animation-delay: 0.2s;
            }

            .bk-chat-typing-dots span:nth-child(3) {
                animation-delay: 0.4s;
            }

            @keyframes bk-bounce {

                0%,
                80%,
                100% {
                    transform: scale(0.7);
                    opacity: 0.5;
                }

                40% {
                    transform: scale(1);
                    opacity: 1;
                }
            }

            /* Spinner */
            .bk-chat-spinner {
                width: 24px;
                height: 24px;
                border-radius: 50%;
                border: 2px solid var(--surface-3);
                border-top-color: var(--accent);
                animation: bk-spin 0.7s linear infinite;
                margin: 0 auto;
            }

            @keyframes bk-spin {
                to {
                    transform: rotate(360deg);
                }
            }

            /* Input disabled state */
            .bk-chat-input-row input:disabled {
                background: var(--surface-2);
                cursor: not-allowed;
            }
        </style>

        <script>
            function chatApp() {
                return {
                    open: false,
                    unread: 0,
                    conversations: [],
                    activeConvo: null,
                    activeMessages: [],
                    newMsg: '',
                    sending: false,
                    loadingConvos: false,
                    loadingMessages: false,
                    pollTimer: null,
                    currentUserId: {{ Auth::id() }},

                    init() {
                        this.loadConversations();

                        // Polling pesan masuk setiap 8 detik
                        this.pollTimer = setInterval(() => {
                            if (this.open && this.activeConvo) {
                                this.pollMessages();
                            } else if (this.open) {
                                this.loadConversations();
                            }
                        }, 8000);

                        // Event: Hubungi Pelapor dari halaman detail postingan
                        window.addEventListener('open-chat-with', async (e) => {
                            const {
                                userId,
                                userName,
                                autoMsg
                            } = e.detail;
                            const convo = {
                                id: userId,
                                name: userName,
                                lastMessage: '',
                                context: 'Pelapor barang'
                            };
                            await this.openConvo(convo);
                            this.open = true;

                            // Jika ada pesan pembuka otomatis, isi ke input
                            if (autoMsg) {
                                this.newMsg = autoMsg;
                                this.$nextTick(() => {
                                    const input = document.querySelector('.bk-chat-input-row input');
                                    if (input) input.focus();
                                });
                            }
                        });
                    },

                    csrfToken() {
                        return document.querySelector('meta[name=csrf-token]').content;
                    },

                    async loadConversations() {
                        this.loadingConvos = true;
                        try {
                            const res = await fetch('/api/conversations', {
                                headers: {
                                    'X-CSRF-TOKEN': this.csrfToken(),
                                    'Accept': 'application/json'
                                }
                            });
                            if (res.ok) this.conversations = await res.json();
                        } catch (e) {}
                        this.loadingConvos = false;
                    },

                    async openConvo(convo) {
                        this.activeConvo = convo;
                        this.activeMessages = [];
                        this.loadingMessages = true;
                        try {
                            const res = await fetch('/api/messages/' + convo.id, {
                                headers: {
                                    'X-CSRF-TOKEN': this.csrfToken(),
                                    'Accept': 'application/json'
                                }
                            });
                            if (res.ok) {
                                const data = await res.json();
                                this.activeMessages = data.map(m => ({
                                    id: m.id,
                                    body: m.body,
                                    sent: m.sender_id === this.currentUserId,
                                    time: m.created_at ? this.formatTime(m.created_at) : ''
                                }));
                            }
                        } catch (e) {}
                        this.loadingMessages = false;
                        this.$nextTick(() => this.scrollToBottom());
                    },

                    async pollMessages() {
                        if (!this.activeConvo) return;
                        try {
                            const res = await fetch('/api/messages/' + this.activeConvo.id, {
                                headers: {
                                    'X-CSRF-TOKEN': this.csrfToken(),
                                    'Accept': 'application/json'
                                }
                            });
                            if (res.ok) {
                                const data = await res.json();
                                const mapped = data.map(m => ({
                                    id: m.id,
                                    body: m.body,
                                    sent: m.sender_id === this.currentUserId,
                                    time: m.created_at ? this.formatTime(m.created_at) : ''
                                }));
                                // Deteksi pesan baru dari lawan bicara
                                const prevCount = this.activeMessages.filter(m => !m.sent).length;
                                const newCount = mapped.filter(m => !m.sent).length;
                                if (newCount > prevCount) {
                                    this.unread += (newCount - prevCount);
                                }
                                this.activeMessages = mapped;
                                this.$nextTick(() => this.scrollToBottom());
                            }
                        } catch (e) {}
                    },

                    async sendMsg() {
                        if (!this.newMsg.trim() || !this.activeConvo || this.sending) return;
                        const body = this.newMsg.trim();
                        this.newMsg = '';
                        this.sending = true;
                        const tempId = 'tmp_' + Date.now();
                        this.activeMessages.push({
                            id: tempId,
                            body,
                            sent: true,
                            time: 'Mengirim...'
                        });
                        this.$nextTick(() => this.scrollToBottom());
                        try {
                            const res = await fetch('/pesan', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': this.csrfToken(),
                                    'Accept': 'application/json'
                                },
                                body: JSON.stringify({
                                    receiver_id: this.activeConvo.id,
                                    body
                                })
                            });
                            if (res.ok) {
                                // Refresh pesan dari server agar ID real tersimpan
                                await this.pollMessages();
                                this.loadConversations();
                            } else {
                                // Rollback
                                this.activeMessages = this.activeMessages.filter(m => m.id !== tempId);
                                this.newMsg = body;
                            }
                        } catch (e) {
                            this.activeMessages = this.activeMessages.filter(m => m.id !== tempId);
                            this.newMsg = body;
                        }
                        this.sending = false;
                    },

                    backToList() {
                        this.activeConvo = null;
                        this.activeMessages = [];
                        this.loadConversations();
                    },

                    togglePanel() {
                        this.open = !this.open;
                        if (this.open) {
                            this.unread = 0;
                            this.loadConversations();
                        }
                    },

                    scrollToBottom() {
                        const box = document.getElementById('chat-messages-box');
                        if (box) box.scrollTop = box.scrollHeight;
                    },

                    formatTime(isoStr) {
                        try {
                            const d = new Date(isoStr);
                            const now = new Date();
                            const isToday = d.toDateString() === now.toDateString();
                            if (isToday) {
                                return d.toLocaleTimeString('id-ID', {
                                    hour: '2-digit',
                                    minute: '2-digit'
                                });
                            }
                            return d.toLocaleDateString('id-ID', {
                                    day: 'numeric',
                                    month: 'short'
                                }) +
                                ' ' + d.toLocaleTimeString('id-ID', {
                                    hour: '2-digit',
                                    minute: '2-digit'
                                });
                        } catch (e) {
                            return '';
                        }
                    }
                }
            }
        </script>
    @endauth

    {{-- Chat Modal --}}
    @auth
        <x-chat-modal />
    @endauth

    @auth
    {{-- Fungsi global openChatWith() — tersedia di semua halaman --}}
    <script>
        /**
         * Membuka chat panel dan langsung menuju percakapan dengan pelapor.
         * Dapat dipanggil dari card postingan (beranda) maupun halaman detail.
         *
         * @param {number} userId    - ID user pelapor
         * @param {string} userName  - Nama pelapor
         * @param {string} itemName  - Nama barang (opsional, untuk pesan pembuka)
         */
        function openChatWith(userId, userName, itemName) {
            // Animasikan tombol jika ada ID btn-hubungi (halaman detail)
            const btn = document.getElementById('btn-hubungi');
            if (btn) {
                const origHtml = btn.innerHTML;
                btn.textContent = 'Membuka chat...';
                btn.disabled = true;
                setTimeout(() => {
                    btn.innerHTML = origHtml;
                    btn.disabled = false;
                }, 1200);
            }

            // Pesan pembuka otomatis
            const autoMsg = itemName
                ? `Halo, saya tertarik dengan laporan "${itemName}". Boleh saya tahu lebih lanjut?`
                : '';

            window.dispatchEvent(new CustomEvent('open-chat-with', {
                detail: { userId, userName, autoMsg }
            }));
        }
    </script>
    @endauth

    @stack('scripts')

</body>

</html>
