@props(['title' => 'Admin Panel'])
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title }} — Balik.in Admin</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
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
            --shadow-sm: 0 1px 3px rgba(15,14,13,0.07),0 1px 2px rgba(15,14,13,0.04);
            --shadow-md: 0 4px 12px rgba(15,14,13,0.08),0 2px 6px rgba(15,14,13,0.05);
            --shadow-lg: 0 16px 40px rgba(15,14,13,0.10),0 4px 12px rgba(15,14,13,0.06);
            --radius-sm: 6px;
            --radius-md: 10px;
            --radius-lg: 16px;
            --radius-full: 999px;
            --font-body: 'Inter', system-ui, sans-serif;
            --admin-sidebar-w: 240px;
        }
        *,*::before,*::after{box-sizing:border-box;margin:0;padding:0}
        html{font-size:16px;-webkit-font-smoothing:antialiased}
        body{font-family:var(--font-body);background:#f0efec;color:var(--ink);min-height:100vh}
        a{color:inherit;text-decoration:none}

        /* ---- SHELL ---- */
        .admin-shell{display:flex;min-height:100vh}

        /* ---- SIDEBAR ---- */
        .admin-sidebar{
            width:var(--admin-sidebar-w);
            background:#111110;
            display:flex;flex-direction:column;
            position:fixed;top:0;left:0;bottom:0;
            z-index:50;
            overflow-y:auto;
            transition:transform 0.25s ease;
        }
        .adm-brand{
            padding:1.25rem 1.5rem;
            border-bottom:1px solid rgba(255,255,255,0.07);
            display:flex;align-items:center;gap:0.5rem;flex-shrink:0
        }
        .adm-brand__logo{font-size:1.2rem;font-weight:800;letter-spacing:-0.04em;color:#fff}
        .adm-brand__dot{color:var(--accent)}
        .adm-brand__badge{
            font-size:0.6rem;font-weight:700;letter-spacing:0.1em;text-transform:uppercase;
            background:var(--danger);color:#fff;padding:2px 7px;border-radius:var(--radius-full);margin-left:auto
        }
        .adm-nav-section{padding:1rem 0.75rem 0.25rem}
        .adm-nav-label{
            font-size:0.6rem;font-weight:700;letter-spacing:0.12em;text-transform:uppercase;
            color:rgba(255,255,255,0.28);padding:0 0.75rem;margin-bottom:0.3rem;display:block
        }
        .adm-nav-item{
            display:flex;align-items:center;gap:0.6rem;
            padding:0.55rem 0.875rem;border-radius:var(--radius-sm);
            font-size:0.855rem;font-weight:500;color:rgba(255,255,255,0.5);
            transition:background 0.15s,color 0.15s;cursor:pointer;
            border:none;background:none;width:100%;text-align:left;font-family:var(--font-body);
            margin-bottom:1px;
        }
        .adm-nav-item:hover{background:rgba(255,255,255,0.06);color:rgba(255,255,255,0.85)}
        .adm-nav-item.is-active{background:rgba(200,146,42,0.15);color:var(--accent)}
        .adm-nav-item.is-active svg{stroke:var(--accent) !important}
        .adm-nav-badge{margin-left:auto;background:var(--danger);color:#fff;border-radius:var(--radius-full);font-size:0.6rem;font-weight:700;padding:1px 6px;min-width:18px;text-align:center}
        .adm-sidebar-footer{margin-top:auto;padding:0.75rem 0.75rem 1rem;border-top:1px solid rgba(255,255,255,0.07);flex-shrink:0}
        .adm-user{display:flex;align-items:center;gap:0.6rem;padding:0.5rem 0.75rem}
        .adm-user__avatar{width:30px;height:30px;border-radius:var(--radius-full);background:var(--accent);color:#fff;font-size:0.75rem;font-weight:700;display:flex;align-items:center;justify-content:center;flex-shrink:0}
        .adm-user__name{font-size:0.8rem;font-weight:600;color:rgba(255,255,255,0.8);white-space:nowrap;overflow:hidden;text-overflow:ellipsis}
        .adm-user__role{font-size:0.67rem;color:rgba(255,255,255,0.3)}

        /* ---- TOPBAR ---- */
        .admin-content{margin-left:var(--admin-sidebar-w);flex:1;display:flex;flex-direction:column;min-height:100vh}
        .admin-topbar{
            height:54px;background:#fff;border-bottom:1px solid var(--border-subtle);
            display:flex;align-items:center;justify-content:space-between;
            padding:0 1.75rem;position:sticky;top:0;z-index:40;box-shadow:var(--shadow-sm)
        }
        .adm-breadcrumb{display:flex;align-items:center;gap:0.5rem;font-size:0.855rem;color:var(--ink-muted)}
        .adm-breadcrumb a{color:var(--ink-faint);transition:color 0.15s}
        .adm-breadcrumb a:hover{color:var(--ink)}
        .adm-topbar-actions{display:flex;align-items:center;gap:0.75rem}
        .adm-topbar-toggle{display:none;background:none;border:none;cursor:pointer;color:var(--ink-muted);padding:4px}

        /* ---- MAIN ---- */
        .admin-main{flex:1;padding:1.75rem 2rem}
        .admin-footer{padding:1rem 2rem;border-top:1px solid var(--border-subtle);text-align:center;font-size:0.77rem;color:var(--ink-faint)}

        /* ---- SHARED COMPONENTS ---- */
        .bk-card{background:#fff;border:1px solid var(--border-subtle);border-radius:var(--radius-lg);overflow:hidden}
        .bk-btn{display:inline-flex;align-items:center;justify-content:center;gap:0.4rem;padding:0.45rem 1rem;border-radius:var(--radius-sm);font-size:0.875rem;font-weight:500;font-family:var(--font-body);cursor:pointer;border:1px solid transparent;transition:all 0.15s}
        .bk-btn--ghost{color:var(--ink-muted);border-color:var(--border);background:transparent}
        .bk-btn--ghost:hover{background:var(--surface-2);color:var(--ink)}
        .bk-btn--primary{background:var(--ink);color:#fff;border-color:var(--ink)}
        .bk-btn--primary:hover{background:#2a2825}
        .bk-btn--danger{background:var(--danger);color:#fff;border-color:var(--danger)}
        .bk-btn--danger:hover{background:#a93226}
        .bk-btn--success{background:var(--success);color:#fff;border-color:var(--success)}
        .bk-btn--success:hover{background:#235f36}
        .bk-btn--accent{background:var(--accent);color:#fff;border-color:var(--accent)}
        .bk-btn--accent:hover{background:var(--accent-dark)}
        .bk-badge{display:inline-block;font-size:0.65rem;font-weight:700;letter-spacing:0.08em;text-transform:uppercase;padding:3px 8px;border-radius:var(--radius-full)}
        .bk-badge--hilang{background:var(--danger-light);color:var(--danger)}
        .bk-badge--ditemukan{background:var(--success-light);color:var(--success)}
        .bk-badge--diamankan{background:#dbeafe;color:#1e40af}
        .bk-badge--selesai{background:var(--surface-3);color:var(--ink-muted)}
        .bk-badge--suspend{background:#1f1f1f;color:#f87171}
        .bk-input{width:100%;padding:0.65rem 0.875rem;border:1px solid var(--border);border-radius:var(--radius-sm);font-size:0.9rem;font-family:var(--font-body);background:#fff;color:var(--ink);outline:none;transition:border-color 0.15s,box-shadow 0.15s}
        .bk-input:focus{border-color:var(--accent);box-shadow:0 0 0 3px var(--accent-light)}
        .bk-input::placeholder{color:var(--ink-faint)}
        .bk-label{display:block;font-size:0.78rem;font-weight:600;letter-spacing:0.03em;color:var(--ink-muted);margin-bottom:0.4rem;text-transform:uppercase}
        .bk-alert{padding:0.75rem 1rem;border-radius:var(--radius-sm);font-size:0.875rem;margin-bottom:1rem;display:flex;align-items:center;gap:0.5rem}
        .bk-alert--success{background:var(--success-light);color:var(--success);border:1px solid #b7e0c5}
        .bk-alert--error{background:var(--danger-light);color:var(--danger);border:1px solid #f5c0bc}

        /* ---- MOBILE ---- */
        @media(max-width:768px){
            .admin-sidebar{transform:translateX(-100%)}
            .admin-sidebar.sidebar-open{transform:translateX(0)}
            .admin-content{margin-left:0}
            .adm-topbar-toggle{display:flex}
            .admin-main{padding:1.25rem}
        }
    </style>
    @stack('styles')
</head>
<body>
<div class="admin-shell">

    {{-- ============ SIDEBAR ============ --}}
    <aside class="admin-sidebar" id="admin-sidebar">

        {{-- Brand --}}
        <div class="adm-brand">
            <span class="adm-brand__logo">Balik<span class="adm-brand__dot">.</span>in</span>
            <span class="adm-brand__badge">Admin</span>
        </div>

        {{-- Navigation --}}
        <div class="adm-nav-section" style="flex:1">
            <span class="adm-nav-label">Menu Utama</span>

            <a href="{{ route('admin.dashboard') }}"
               class="adm-nav-item {{ request()->routeIs('admin.dashboard') ? 'is-active' : '' }}">
                <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none"
                     stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/>
                    <rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/>
                </svg>
                Dashboard
            </a>

            <span class="adm-nav-label" style="margin-top:1rem">Manajemen</span>

            <a href="{{ route('admin.postingan.index') }}"
               class="adm-nav-item {{ request()->routeIs('admin.postingan.*') ? 'is-active' : '' }}">
                <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none"
                     stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                    <polyline points="14 2 14 8 20 8"/>
                    <line x1="16" y1="13" x2="8" y2="13"/>
                    <line x1="16" y1="17" x2="8" y2="17"/>
                </svg>
                Kelola Postingan
            </a>

            <a href="{{ route('admin.laporan') }}"
               class="adm-nav-item {{ request()->routeIs('admin.laporan') ? 'is-active' : '' }}">
                <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none"
                     stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/>
                    <line x1="12" y1="9" x2="12" y2="13"/>
                    <line x1="12" y1="17" x2="12.01" y2="17"/>
                </svg>
                Kelola Laporan
                @php $pc = \App\Models\Laporan::where('status_laporan','pending')->count(); @endphp
                @if($pc > 0)
                    <span class="adm-nav-badge">{{ $pc }}</span>
                @endif
            </a>

            <span class="adm-nav-label" style="margin-top:1rem">Lainnya</span>

            <a href="{{ route('pesan.index') }}" class="adm-nav-item">
                <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none"
                     stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"></path>
                </svg>
                Lihat Pesan
            </a>
        </div>

        {{-- User Footer --}}
        <div class="adm-sidebar-footer">
            <div class="adm-user">
                <div class="adm-user__avatar">{{ strtoupper(substr(Auth::user()->name ?? '?', 0, 1)) }}</div>
                <div style="min-width:0;flex:1">
                    <div class="adm-user__name">{{ Auth::user()->name ?? 'Admin' }}</div>
                    <div class="adm-user__role">Administrator</div>
                </div>
            </div>
            <form method="POST" action="{{ route('logout') }}" style="padding:0 0.5rem">
                @csrf
                <button type="submit" class="adm-nav-item"
                        style="color:rgba(248,113,113,0.65)"
                        onmouseover="this.style.background='rgba(192,57,43,0.15)';this.style.color='#f87171'"
                        onmouseout="this.style.background='';this.style.color='rgba(248,113,113,0.65)'">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none"
                         stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/>
                        <polyline points="16 17 21 12 16 7"/>
                        <line x1="21" y1="12" x2="9" y2="12"/>
                    </svg>
                    Keluar
                </button>
            </form>
        </div>
    </aside>

    {{-- ============ CONTENT AREA ============ --}}
    <div class="admin-content">

        {{-- Topbar --}}
        <header class="admin-topbar">
            <div style="display:flex;align-items:center;gap:0.75rem">
                <button class="adm-topbar-toggle" onclick="toggleSidebar()" title="Toggle menu">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                         stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="3" y1="12" x2="21" y2="12"/>
                        <line x1="3" y1="6" x2="21" y2="6"/>
                        <line x1="3" y1="18" x2="21" y2="18"/>
                    </svg>
                </button>
                <div class="adm-breadcrumb">
                    <a href="{{ route('admin.dashboard') }}">Admin</a>
                    <svg xmlns="http://www.w3.org/2000/svg" width="11" height="11" viewBox="0 0 24 24" fill="none"
                         stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="9 18 15 12 9 6"/>
                    </svg>
                    <span style="color:var(--ink);font-weight:600">{{ $title }}</span>
                </div>
            </div>
            <div class="adm-topbar-actions">
                <span style="font-size:0.77rem;color:var(--ink-faint)">
                    {{ now()->translatedFormat('d M Y') }}
                </span>
            </div>
        </header>

        {{-- Flash messages --}}
        @if(session('success') || session('error'))
            <div style="padding:1.25rem 2rem 0">
                @if(session('success'))
                    <div class="bk-alert bk-alert--success">
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none"
                             stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <polyline points="20 6 9 17 4 12"/>
                        </svg>
                        {{ session('success') }}
                    </div>
                @endif
                @if(session('error'))
                    <div class="bk-alert bk-alert--error">
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none"
                             stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="12" r="10"/>
                            <line x1="15" y1="9" x2="9" y2="15"/>
                            <line x1="9" y1="9" x2="15" y2="15"/>
                        </svg>
                        {{ session('error') }}
                    </div>
                @endif
            </div>
        @endif

        {{-- Page Content --}}
        <main class="admin-main">
            {{ $slot }}
        </main>

        <footer class="admin-footer">
            &copy; {{ date('Y') }} Balik.in — Panel Administrator
        </footer>
    </div>
</div>

{{-- Mobile overlay --}}
<div id="sidebar-overlay" onclick="toggleSidebar()"
     style="display:none;position:fixed;inset:0;background:rgba(0,0,0,0.45);z-index:49;backdrop-filter:blur(2px)"></div>

<script>
    function toggleSidebar() {
        const sidebar = document.getElementById('admin-sidebar');
        const overlay = document.getElementById('sidebar-overlay');
        const isOpen  = sidebar.classList.contains('sidebar-open');
        sidebar.classList.toggle('sidebar-open');
        overlay.style.display = isOpen ? 'none' : 'block';
    }
</script>
@stack('scripts')
</body>
</html>
