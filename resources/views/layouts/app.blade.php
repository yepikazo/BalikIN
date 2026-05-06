<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'Balik.in — Temukan Barang Hilang' }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,300;0,9..40,400;0,9..40,500;0,9..40,600;0,9..40,700;1,9..40,400&family=DM+Serif+Display:ital@0;1&display=swap" rel="stylesheet">
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
            --shadow-sm: 0 1px 3px rgba(15,14,13,0.07), 0 1px 2px rgba(15,14,13,0.04);
            --shadow-md: 0 4px 12px rgba(15,14,13,0.08), 0 2px 6px rgba(15,14,13,0.05);
            --shadow-lg: 0 16px 40px rgba(15,14,13,0.10), 0 4px 12px rgba(15,14,13,0.06);
            --radius-sm: 6px;
            --radius-md: 10px;
            --radius-lg: 16px;
            --radius-full: 999px;
            --font-display: 'DM Serif Display', Georgia, serif;
            --font-body: 'DM Sans', system-ui, sans-serif;
        }

        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        html { font-size: 16px; -webkit-font-smoothing: antialiased; }

        body {
            font-family: var(--font-body);
            background-color: var(--surface);
            color: var(--ink);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        a { color: inherit; text-decoration: none; }

        /* ===========================
           NAVBAR
        =========================== */
        .bk-navbar {
            position: sticky;
            top: 0;
            z-index: 100;
            background: rgba(250,249,247,0.92);
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
            font-family: var(--font-display);
            font-size: 1.4rem;
            letter-spacing: -0.02em;
            color: var(--ink);
            flex-shrink: 0;
        }

        .bk-navbar__brand-dot { color: var(--accent); }

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
        .bk-icon-btn:hover { color: var(--ink); background: var(--surface-2); }

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
        .bk-avatar-btn:hover { opacity: 0.8; }

        /* Dropdown */
        .bk-dropdown { position: relative; }

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
        .bk-dropdown__name { font-weight: 600; font-size: 0.875rem; }
        .bk-dropdown__email { font-size: 0.75rem; color: var(--ink-faint); margin-top: 1px; }

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
        .bk-dropdown__item:hover { background: var(--surface-2); color: var(--ink); }
        .bk-dropdown__item--danger:hover { background: var(--danger-light); color: var(--danger); }

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
        .bk-btn--ghost:hover { background: var(--surface-2); color: var(--ink); }
        .bk-btn--primary {
            background: var(--ink);
            color: var(--surface);
            border-color: var(--ink);
        }
        .bk-btn--primary:hover { background: #2a2825; }
        .bk-btn--accent {
            background: var(--accent);
            color: white;
            border-color: var(--accent);
        }
        .bk-btn--accent:hover { background: var(--accent-dark); }
        .bk-btn--danger { background: var(--danger); color: white; border-color: var(--danger); }
        .bk-btn--danger:hover { background: #a93226; }
        .bk-btn--outline-accent {
            color: var(--accent-dark);
            border-color: var(--accent);
            background: var(--accent-light);
        }
        .bk-btn--outline-accent:hover { background: var(--accent); color: white; }

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
        .bk-mobile-link:hover { background: var(--surface-2); color: var(--ink); }
        .bk-mobile-link--accent { color: var(--accent); font-weight: 600; }
        .bk-mobile-link--admin { color: var(--danger); font-weight: 600; }
        .bk-mobile-link--danger:hover { background: var(--danger-light); color: var(--danger); }

        @media (max-width: 640px) {
            .bk-navbar__actions .bk-btn { display: none; }
            .bk-navbar__hamburger { display: flex; }
            .bk-navbar__actions .bk-icon-btn,
            .bk-navbar__actions .bk-avatar-btn,
            .bk-navbar__actions .bk-admin-badge,
            .bk-navbar__actions .bk-dropdown { display: none; }
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
        .bk-card:hover { box-shadow: var(--shadow-md); transform: translateY(-2px); }

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
        .bk-badge--hilang { background: var(--danger-light); color: var(--danger); }
        .bk-badge--ditemukan { background: var(--success-light); color: var(--success); }
        .bk-badge--aktif { background: var(--success-light); color: var(--success); }
        .bk-badge--selesai { background: var(--surface-3); color: var(--ink-muted); }

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
        .bk-input:focus { border-color: var(--accent); box-shadow: 0 0 0 3px var(--accent-light); }
        .bk-input::placeholder { color: var(--ink-faint); }

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
        .bk-alert { padding: 0.75rem 1rem; border-radius: var(--radius-sm); font-size: 0.875rem; margin-bottom: 1rem; }
        .bk-alert--success { background: var(--success-light); color: var(--success); border: 1px solid #b7e0c5; }
        .bk-alert--error { background: var(--danger-light); color: var(--danger); border: 1px solid #f5c0bc; }

        /* ===========================
           PAGE HEADER
        =========================== */
        .bk-page-header { margin-bottom: 2rem; }
        .bk-page-header__title {
            font-family: var(--font-display);
            font-size: 2rem;
            letter-spacing: -0.02em;
            color: var(--ink);
            line-height: 1.2;
        }
        .bk-page-header__sub { font-size: 0.9rem; color: var(--ink-muted); margin-top: 0.4rem; }

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
        .bk-chat-fab:hover { transform: scale(1.05); }

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
        .bk-chat-header__title { font-weight: 600; font-size: 0.9rem; }
        .bk-chat-header__close { background: none; border: none; cursor: pointer; color: var(--ink-muted); padding: 2px; }

        .bk-chat-convo-list { overflow-y: auto; flex: 1; }
        .bk-chat-convo-item {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.75rem 1rem;
            cursor: pointer;
            transition: background 0.1s;
            border-bottom: 1px solid var(--border-subtle);
        }
        .bk-chat-convo-item:hover { background: var(--surface-2); }
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
        .bk-chat-convo-info { flex: 1; min-width: 0; }
        .bk-chat-convo-name { font-weight: 600; font-size: 0.875rem; }
        .bk-chat-convo-last { font-size: 0.75rem; color: var(--ink-faint); white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }

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
        .bk-chat-input-row input:focus { border-color: var(--accent); }
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
        .bk-chat-send-btn:hover { background: var(--accent); }

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
        .bk-mention-btn:hover { border-color: var(--accent); color: var(--accent-dark); background: var(--accent-light); }

        /* ===========================
           UTILITIES
        =========================== */
        .text-muted { color: var(--ink-muted); }
        .text-faint { color: var(--ink-faint); }
        .text-accent { color: var(--accent); }
        .text-danger { color: var(--danger); }
        .font-display { font-family: var(--font-display); }
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
        <!-- FAB -->
        <button @click="togglePanel()" class="bk-chat-fab" title="Pesan">
            <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/>
            </svg>
            <span x-show="unread > 0" class="bk-chat-unread-badge" x-text="unread"></span>
        </button>

        <!-- Chat Window -->
        <div x-show="open" x-transition class="bk-chat-window">
            <!-- Conversation List -->
            <template x-if="!activeConvo">
                <div style="display:flex;flex-direction:column;height:100%">
                    <div class="bk-chat-header">
                        <span class="bk-chat-header__title">Pesan</span>
                        <button @click="open = false" class="bk-chat-header__close">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                        </button>
                    </div>
                    <div class="bk-chat-convo-list">
                        <template x-for="convo in conversations" :key="convo.id">
                            <div @click="openConvo(convo)" class="bk-chat-convo-item">
                                <div class="bk-chat-convo-avatar" x-text="convo.name.charAt(0).toUpperCase()"></div>
                                <div class="bk-chat-convo-info">
                                    <div class="bk-chat-convo-name" x-text="convo.name"></div>
                                    <div class="bk-chat-convo-last" x-text="convo.lastMessage"></div>
                                </div>
                            </div>
                        </template>
                        <div x-show="conversations.length === 0" style="padding:2rem 1rem;text-align:center;font-size:0.85rem;color:var(--ink-faint)">
                            Belum ada percakapan
                        </div>
                    </div>
                </div>
            </template>

            <!-- Active Conversation -->
            <template x-if="activeConvo">
                <div style="display:flex;flex-direction:column;height:100%">
                    <div class="bk-chat-header">
                        <div style="display:flex;align-items:center;gap:0.5rem">
                            <button @click="activeConvo = null" class="bk-chat-header__close">
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"/></svg>
                            </button>
                            <span class="bk-chat-header__title" x-text="activeConvo.name"></span>
                        </div>
                        <button @click="open = false" class="bk-chat-header__close">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                        </button>
                    </div>
                    <div class="bk-chat-messages" x-ref="msgBox" id="chat-messages-box">
                        <template x-for="msg in activeMessages" :key="msg.id">
                            <div :class="msg.sent ? 'bk-chat-msg bk-chat-msg--sent' : 'bk-chat-msg bk-chat-msg--received'" x-text="msg.body"></div>
                        </template>
                    </div>
                    <div class="bk-chat-input-row">
                        <input x-model="newMsg" @keydown.enter="sendMsg()" type="text" placeholder="Tulis pesan...">
                        <button @click="sendMsg()" class="bk-chat-send-btn">
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="22" y1="2" x2="11" y2="13"/><polygon points="22 2 15 22 11 13 2 9 22 2"/></svg>
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
        font-size: 0.65rem;
        font-weight: 700;
        min-width: 18px;
        height: 18px;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 0 4px;
        border: 2px solid var(--surface);
    }
    .bk-chat-fab { position: relative; }
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
            ws: null,
            currentUserId: {{ Auth::id() }},

            init() {
                this.loadConversations();
                this.connectWS();

                // Listen for mention-to-chat events from other parts of the page
                window.addEventListener('open-chat-with', (e) => {
                    const { userId, userName } = e.detail;
                    const convo = { id: userId, name: userName, lastMessage: '' };
                    this.openConvo(convo);
                    this.open = true;
                });
            },

            connectWS() {
                // WebSocket connection to Laravel Reverb or Pusher
                // Using Laravel Echo if available
                if (typeof window.Echo !== 'undefined') {
                    window.Echo.private('chat.' + this.currentUserId)
                        .listen('NewMessage', (e) => {
                            this.handleIncoming(e.message);
                        });
                }
            },

            handleIncoming(msg) {
                this.unread++;
                if (this.activeConvo && this.activeConvo.id === msg.sender_id) {
                    this.activeMessages.push({ id: msg.id, body: msg.body, sent: false });
                    this.$nextTick(() => this.scrollToBottom());
                    this.unread = Math.max(0, this.unread - 1);
                }
                // Update conversation list
                this.loadConversations();
            },

            async loadConversations() {
                try {
                    const res = await fetch('/api/conversations', {
                        headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content, 'Accept': 'application/json' }
                    });
                    if (res.ok) {
                        const data = await res.json();
                        this.conversations = data;
                    }
                } catch (e) { /* fail silently */ }
            },

            async openConvo(convo) {
                this.activeConvo = convo;
                this.activeMessages = [];
                try {
                    const res = await fetch('/api/messages/' + convo.id, {
                        headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content, 'Accept': 'application/json' }
                    });
                    if (res.ok) {
                        const data = await res.json();
                        this.activeMessages = data.map(m => ({
                            id: m.id,
                            body: m.body,
                            sent: m.sender_id === this.currentUserId
                        }));
                    }
                } catch(e) {}
                this.$nextTick(() => this.scrollToBottom());
            },

            async sendMsg() {
                if (!this.newMsg.trim() || !this.activeConvo) return;
                const body = this.newMsg.trim();
                this.newMsg = '';
                // Optimistic UI
                this.activeMessages.push({ id: Date.now(), body, sent: true });
                this.$nextTick(() => this.scrollToBottom());
                try {
                    await fetch('/pesan', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content,
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({ receiver_id: this.activeConvo.id, body })
                    });
                    this.loadConversations();
                } catch(e) {}
            },

            togglePanel() {
                this.open = !this.open;
                if (this.open) this.unread = 0;
            },

            scrollToBottom() {
                const box = document.getElementById('chat-messages-box');
                if (box) box.scrollTop = box.scrollHeight;
            }
        }
    }
    </script>
    @endauth

    @stack('scripts')
</body>
</html>
