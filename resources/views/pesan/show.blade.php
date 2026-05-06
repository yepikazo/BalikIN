<x-app-layout>
    <x-slot:title>Chat dengan {{ $otherUser->name }} — Balik.in</x-slot>

    <div style="max-width:780px;margin:0 auto">
        {{-- Header --}}
        <div style="display:flex;align-items:center;gap:1rem;margin-bottom:1.5rem">
            <a href="{{ route('pesan.index') }}" class="bk-btn bk-btn--ghost" style="font-size:0.82rem;flex-shrink:0">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="15 18 9 12 15 6"/>
                </svg>
                Kembali
            </a>
            <div style="display:flex;align-items:center;gap:0.75rem;flex:1;min-width:0">
                <div style="width:44px;height:44px;border-radius:var(--radius-full);background:var(--ink);color:white;font-size:1rem;font-weight:700;display:flex;align-items:center;justify-content:center;flex-shrink:0">
                    {{ strtoupper(substr($otherUser->name, 0, 1)) }}
                </div>
                <div style="min-width:0">
                    <h1 style="font-size:1.05rem;font-weight:700;color:var(--ink);white-space:nowrap;overflow:hidden;text-overflow:ellipsis">{{ $otherUser->name }}</h1>
                    <p style="font-size:0.75rem;color:var(--ink-faint)">Chat pribadi</p>
                </div>
            </div>
        </div>

        {{-- Chat Box --}}
        <div class="bk-card" style="display:flex;flex-direction:column;height:600px;overflow:hidden">

            {{-- Messages Area --}}
            <div id="messages-container"
                style="flex:1;overflow-y:auto;padding:1.25rem;display:flex;flex-direction:column;gap:0.75rem;background:var(--surface)">

                @forelse($messages as $msg)
                    @php $isSent = $msg->sender_id === Auth::id(); @endphp
                    <div class="chat-msg-wrap {{ $isSent ? 'sent' : 'received' }}" style="display:flex;flex-direction:column;align-items:{{ $isSent ? 'flex-end' : 'flex-start' }}">
                        <div style="max-width:72%;padding:0.75rem 1rem;border-radius:{{ $isSent ? 'var(--radius-md) 4px var(--radius-md) var(--radius-md)' : '4px var(--radius-md) var(--radius-md) var(--radius-md)' }};font-size:0.875rem;line-height:1.5;word-break:break-word;background:{{ $isSent ? 'var(--ink)' : 'white' }};color:{{ $isSent ? 'white' : 'var(--ink)' }};border:{{ $isSent ? 'none' : '1px solid var(--border-subtle)' }}">
                            {{ $msg->body }}
                        </div>
                        <div style="font-size:0.68rem;color:var(--ink-faint);margin-top:3px;padding:0 4px">
                            {{ $msg->created_at->format('d M Y, H:i') }}
                        </div>
                    </div>
                @empty
                    <div id="empty-state" style="flex:1;display:flex;flex-direction:column;align-items:center;justify-content:center;gap:0.75rem;padding:2rem;text-align:center;height:100%">
                        <div style="width:56px;height:56px;border-radius:var(--radius-full);background:var(--accent);color:white;font-size:1.2rem;font-weight:700;display:flex;align-items:center;justify-content:center;margin-bottom:0.25rem">
                            {{ strtoupper(substr($otherUser->name, 0, 1)) }}
                        </div>
                        <p style="font-weight:600;font-size:0.9rem;color:var(--ink)">{{ $otherUser->name }}</p>
                        <p style="font-size:0.8rem;color:var(--ink-faint)">Mulai percakapan dengan mengirim pesan pertama.</p>
                    </div>
                @endforelse

                {{-- Typing indicator (hidden) --}}
                <div id="typing-indicator" style="display:none;align-items:flex-start">
                    <div style="padding:0.625rem 1rem;background:white;border:1px solid var(--border-subtle);border-radius:4px var(--radius-md) var(--radius-md) var(--radius-md);display:flex;gap:4px;align-items:center">
                        <span class="typing-dot"></span>
                        <span class="typing-dot" style="animation-delay:0.2s"></span>
                        <span class="typing-dot" style="animation-delay:0.4s"></span>
                    </div>
                </div>
            </div>

            {{-- Input --}}
            <div style="padding:0.875rem 1.25rem;border-top:1px solid var(--border-subtle);background:white">
                <form id="chat-form" style="display:flex;gap:0.625rem;align-items:flex-end" onsubmit="sendMsg(event)">
                    <input type="text" id="msg-input"
                        placeholder="Tulis pesan..."
                        class="bk-input"
                        style="flex:1;min-width:0;border-radius:var(--radius-full);padding:0.6rem 1rem"
                        autocomplete="off"
                        maxlength="1000">
                    <button type="submit" id="send-btn"
                        style="width:40px;height:40px;border-radius:var(--radius-full);background:var(--ink);color:white;border:none;cursor:pointer;display:flex;align-items:center;justify-content:center;flex-shrink:0;transition:all 0.15s"
                        onmouseover="this.style.background='var(--accent)'"
                        onmouseout="this.style.background='var(--ink)'">
                        <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <line x1="22" y1="2" x2="11" y2="13"/>
                            <polygon points="22 2 15 22 11 13 2 9 22 2"/>
                        </svg>
                    </button>
                </form>
                <p style="font-size:0.7rem;color:var(--ink-faint);margin-top:0.4rem;text-align:center">
                    Tekan Enter atau klik tombol kirim
                </p>
            </div>
        </div>
    </div>

    <style>
        #messages-container {
            scrollbar-width: thin;
            scrollbar-color: var(--border) transparent;
        }
        #messages-container::-webkit-scrollbar { width: 5px; }
        #messages-container::-webkit-scrollbar-track { background: transparent; }
        #messages-container::-webkit-scrollbar-thumb { background: var(--border); border-radius: 3px; }

        .typing-dot {
            width: 7px;
            height: 7px;
            border-radius: 50%;
            background: var(--border);
            animation: typingBounce 1.2s infinite;
        }

        @keyframes typingBounce {
            0%, 80%, 100% { transform: scale(0.7); opacity: 0.5; }
            40% { transform: scale(1); opacity: 1; }
        }

        .chat-msg-new {
            animation: msgFadeIn 0.25s ease;
        }

        @keyframes msgFadeIn {
            from { opacity: 0; transform: translateY(6px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>

    @push('scripts')
    <script>
        const currentUserId = {{ Auth::id() }};
        const receiverId = {{ $otherUser->id }};
        const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
        let lastMessageCount = {{ $messages->count() }};
        let pollInterval = null;

        const container = document.getElementById('messages-container');
        const input = document.getElementById('msg-input');
        const sendBtn = document.getElementById('send-btn');

        // Scroll ke bawah saat load
        window.addEventListener('DOMContentLoaded', () => {
            scrollBottom();
            // Poll setiap 5 detik untuk pesan baru
            pollInterval = setInterval(pollMessages, 5000);
        });

        function scrollBottom(smooth = false) {
            container.scrollTo({ top: container.scrollHeight, behavior: smooth ? 'smooth' : 'auto' });
        }

        function createMsgEl(body, isSent, timeStr) {
            const wrap = document.createElement('div');
            wrap.className = 'chat-msg-new';
            wrap.style.cssText = `display:flex;flex-direction:column;align-items:${isSent ? 'flex-end' : 'flex-start'}`;

            const bubble = document.createElement('div');
            bubble.style.cssText = `max-width:72%;padding:0.75rem 1rem;border-radius:${isSent ? 'var(--radius-md) 4px var(--radius-md) var(--radius-md)' : '4px var(--radius-md) var(--radius-md) var(--radius-md)'};font-size:0.875rem;line-height:1.5;word-break:break-word;background:${isSent ? 'var(--ink)' : 'white'};color:${isSent ? 'white' : 'var(--ink)'};border:${isSent ? 'none' : '1px solid var(--border-subtle)'}`;
            bubble.textContent = body;

            const time = document.createElement('div');
            time.style.cssText = 'font-size:0.68rem;color:var(--ink-faint);margin-top:3px;padding:0 4px';
            time.textContent = timeStr;

            wrap.appendChild(bubble);
            wrap.appendChild(time);
            return wrap;
        }

        function formatTime(isoStr) {
            try {
                const d = new Date(isoStr);
                const now = new Date();
                const isToday = d.toDateString() === now.toDateString();
                const timeStr = d.toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit' });
                if (isToday) return 'Hari ini, ' + timeStr;
                return d.toLocaleDateString('id-ID', { day: 'numeric', month: 'short', year: 'numeric' }) + ', ' + timeStr;
            } catch(e) { return ''; }
        }

        async function sendMsg(e) {
            e.preventDefault();
            const body = input.value.trim();
            if (!body) return;

            // Optimistic UI
            input.value = '';
            input.disabled = true;
            sendBtn.disabled = true;
            sendBtn.style.opacity = '0.5';

            // Hapus empty state
            const emptyState = document.getElementById('empty-state');
            if (emptyState) emptyState.remove();

            const tempEl = createMsgEl(body, true, 'Mengirim...');
            container.appendChild(tempEl);
            scrollBottom(true);

            try {
                const res = await fetch('/pesan', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({ receiver_id: receiverId, body })
                });

                const data = await res.json();

                if (res.ok && data.message) {
                    // Update waktu pesan
                    const timeEl = tempEl.querySelector('div:last-child');
                    if (timeEl) timeEl.textContent = formatTime(data.message.created_at);
                    lastMessageCount++;
                } else {
                    // Rollback
                    tempEl.remove();
                    input.value = body;
                    const errMsg = data.error || 'Gagal mengirim pesan.';
                    showToast(errMsg, 'error');
                }
            } catch(e) {
                tempEl.remove();
                input.value = body;
                showToast('Koneksi gagal. Coba lagi.', 'error');
            }

            input.disabled = false;
            sendBtn.disabled = false;
            sendBtn.style.opacity = '1';
            input.focus();
        }

        async function pollMessages() {
            try {
                const res = await fetch(`/api/messages/${receiverId}`, {
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    }
                });
                if (!res.ok) return;
                const data = await res.json();

                if (data.length > lastMessageCount) {
                    // Ada pesan baru dari lawan bicara
                    const newMessages = data.slice(lastMessageCount);
                    const wasAtBottom = container.scrollTop + container.clientHeight >= container.scrollHeight - 60;

                    newMessages.forEach(msg => {
                        const isSent = msg.sender_id === currentUserId;
                        const el = createMsgEl(msg.body, isSent, formatTime(msg.created_at));
                        container.appendChild(el);
                    });

                    lastMessageCount = data.length;
                    if (wasAtBottom) scrollBottom(true);
                }
            } catch(e) {}
        }

        // Kirim dengan Enter
        input.addEventListener('keydown', (e) => {
            if (e.key === 'Enter' && !e.shiftKey) {
                e.preventDefault();
                document.getElementById('chat-form').dispatchEvent(new Event('submit'));
            }
        });

        function showToast(msg, type = 'error') {
            const toast = document.createElement('div');
            toast.style.cssText = `position:fixed;bottom:1.5rem;left:50%;transform:translateX(-50%);padding:0.75rem 1.25rem;background:${type === 'error' ? 'var(--danger)' : 'var(--success)'};color:white;border-radius:var(--radius-sm);font-size:0.85rem;font-weight:500;z-index:9999;box-shadow:var(--shadow-lg);animation:msgFadeIn 0.25s ease`;
            toast.textContent = msg;
            document.body.appendChild(toast);
            setTimeout(() => toast.remove(), 3000);
        }
    </script>
    @endpush
</x-app-layout>
