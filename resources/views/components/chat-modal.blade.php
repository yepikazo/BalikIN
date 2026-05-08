{{-- Chat Modal Component --}}
<div id="chat-modal"
    style="position:fixed;inset:0;background:rgba(0,0,0,0.3);display:none;z-index:9998;animation:chatFadeIn 0.2s;backdrop-filter:blur(2px)"
    onclick="if(event.target.id === 'chat-modal') closeChatModal()">
    <div style="position:fixed;bottom:0;right:0;width:100%;max-width:400px;height:100%;background:white;display:flex;flex-direction:column;box-shadow:-2px 0 12px rgba(0,0,0,0.15);animation:chatSlideIn 0.3s;border-radius:var(--radius-md) var(--radius-md) 0 0"
        class="chat-panel">
        {{-- Header --}}
        <div
            style="padding:1rem 1.25rem;border-bottom:1px solid var(--border-subtle);display:flex;justify-content:space-between;align-items:center;background:linear-gradient(135deg,var(--accent),var(--accent-dark))">
            <div style="display:flex;align-items:center;gap:0.75rem;flex:1;min-width:0">
                <div id="chat-avatar"
                    style="width:36px;height:36px;border-radius:var(--radius-full);background:rgba(255,255,255,0.2);color:white;font-size:0.85rem;font-weight:700;display:flex;align-items:center;justify-content:center;flex-shrink:0">
                    A
                </div>
                <div style="min-width:0;flex:1">
                    <div id="chat-user-name"
                        style="font-weight:700;color:white;font-size:0.95rem;overflow:hidden;text-overflow:ellipsis">
                        Chat</div>
                    <div style="font-size:0.7rem;color:rgba(255,255,255,0.8)">Chat pribadi</div>
                </div>
            </div>
            <button onclick="closeChatModal()"
                style="background:rgba(255,255,255,0.2);color:white;border:none;width:32px;height:32px;border-radius:var(--radius-full);cursor:pointer;display:flex;align-items:center;justify-content:center;transition:all 0.15s;flex-shrink:0"
                onmouseover="this.style.background='rgba(255,255,255,0.3)'"
                onmouseout="this.style.background='rgba(255,255,255,0.2)'">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="18" y1="6" x2="6" y2="18" />
                    <line x1="6" y1="6" x2="18" y2="18" />
                </svg>
            </button>
        </div>

        {{-- Messages Container --}}
        <div id="chat-messages"
            style="flex:1;overflow-y:auto;padding:1.25rem;display:flex;flex-direction:column;gap:0.75rem;background:var(--surface)">
            <div style="text-align:center;padding:2rem 1rem;color:var(--ink-faint)">
                <p style="font-size:0.85rem">Memuat percakapan...</p>
            </div>
        </div>

        {{-- Input Area --}}
        <div style="padding:1rem;border-top:1px solid var(--border-subtle);background:white">
            <form id="chat-form" style="display:flex;gap:0.5rem" onsubmit="sendMessage(event)">
                <input type="text" id="chat-input" placeholder="Tulis pesan..." class="bk-input"
                    style="font-size:0.85rem;flex:1;min-width:0" required>
                <button type="submit" class="bk-btn bk-btn--accent"
                    style="white-space:nowrap;font-size:0.85rem;display:flex;align-items:center;gap:0.4rem">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round">
                        <line x1="22" y1="2" x2="11" y2="13" />
                        <polygon points="22 2 15 22 11 13 2 9 22 2" />
                    </svg>
                    <span class="send-text">Kirim</span>
                </button>
            </form>
        </div>
    </div>
</div>

<style>
    @keyframes chatFadeIn {
        from {
            opacity: 0;
        }

        to {
            opacity: 1;
        }
    }

    @keyframes chatSlideIn {
        from {
            transform: translateX(100%);
            opacity: 0;
        }

        to {
            transform: translateX(0);
            opacity: 1;
        }
    }

    @keyframes chatSlideOut {
        from {
            transform: translateX(0);
            opacity: 1;
        }

        to {
            transform: translateX(100%);
            opacity: 0;
        }
    }

    @keyframes chatSpin {
        from {
            transform: rotate(0deg);
        }

        to {
            transform: rotate(360deg);
        }
    }

    #chat-messages {
        scrollbar-width: thin;
        scrollbar-color: var(--border) transparent;
    }

    #chat-messages::-webkit-scrollbar {
        width: 6px;
    }

    #chat-messages::-webkit-scrollbar-track {
        background: transparent;
    }

    #chat-messages::-webkit-scrollbar-thumb {
        background: var(--border);
        border-radius: 3px;
    }

    #chat-messages::-webkit-scrollbar-thumb:hover {
        background: var(--border-subtle);
    }

    .chat-message {
        display: flex;
        gap: 0.5rem;
        animation: chatFadeIn 0.3s;
    }

    .chat-message.sent {
        justify-content: flex-end;
    }

    .chat-message.received {
        justify-content: flex-start;
    }

    .chat-bubble {
        max-width: 80%;
        padding: 0.75rem 1rem;
        border-radius: var(--radius-md);
        font-size: 0.875rem;
        line-height: 1.5;
        word-break: break-word;
    }

    .chat-bubble.sent {
        background: var(--accent);
        color: white;
        border-radius: var(--radius-md) 4px var(--radius-md) var(--radius-md);
    }

    .chat-bubble.received {
        background: var(--surface-2);
        color: var(--ink);
        border-radius: 4px var(--radius-md) var(--radius-md) var(--radius-md);
    }

    .chat-time {
        font-size: 0.7rem;
        color: var(--ink-faint);
        margin-top: 2px;
    }

    @media (max-width: 600px) {
        .chat-panel {
            max-width: 100% !important;
        }
    }
</style>

<script>
    let currentChatUserId = null;
    let currentChatUserName = '';

    // Dengarkan event ketika tombol hubungi diklik
    window.addEventListener('open-chat-with', (e) => {
        const {
            userId,
            userName,
            autoMsg
        } = e.detail;
        openChatModal(userId, userName, autoMsg);
    });

    function openChatModal(userId, userName, autoMsg = '') {
        currentChatUserId = userId;
        currentChatUserName = userName;

        const modal = document.getElementById('chat-modal');
        const chatInput = document.getElementById('chat-input');
        const messagesContainer = document.getElementById('chat-messages');

        // Update header
        document.getElementById('chat-user-name').textContent = userName;
        const firstLetter = userName.charAt(0).toUpperCase();
        document.getElementById('chat-avatar').textContent = firstLetter;

        // Tampilkan modal
        modal.style.display = 'block';

        // Kosongkan pesan lama dan load percakapan
        messagesContainer.innerHTML =
            '<div style="text-align:center;padding:2rem 1rem;color:var(--ink-faint)"><p style="font-size:0.85rem">Memulai percakapan...</p></div>';

        // Set auto message jika ada
        if (autoMsg) {
            chatInput.value = autoMsg;
        }

        // Focus ke input
        setTimeout(() => chatInput.focus(), 100);

        // Load messages
        loadChatMessages(userId);
    }

    function closeChatModal() {
        const modal = document.getElementById('chat-modal');
        modal.style.animation = 'chatSlideOut 0.2s';
        setTimeout(() => {
            modal.style.display = 'none';
            modal.style.animation = '';
        }, 200);
    }

    function loadChatMessages(userId) {
        const messagesContainer = document.getElementById('chat-messages');
        const currentUserId = {{ Auth::id() }};

        // Fetch messages via AJAX — API mengembalikan array langsung
        fetch(`/api/messages/${userId}`, {
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json'
            }
        })
            .then(res => res.json())
            .then(data => {
                // data adalah array langsung (bukan {messages: []})
                if (Array.isArray(data) && data.length > 0) {
                    messagesContainer.innerHTML = '';
                    data.forEach(msg => {
                        addMessageToChat(msg.body, msg.sender_id === currentUserId, msg.created_at);
                    });
                    // Scroll ke bawah
                    messagesContainer.scrollTop = messagesContainer.scrollHeight;
                } else {
                    messagesContainer.innerHTML =
                        '<div style="text-align:center;padding:2rem 1rem;color:var(--ink-faint)"><p style="font-size:0.85rem">Mulai percakapan dengan ' +
                        currentChatUserName + '</p></div>';
                }
            })
            .catch(err => {
                console.error('Error loading messages:', err);
                messagesContainer.innerHTML =
                    '<div style="text-align:center;padding:2rem 1rem;color:var(--danger)"><p style="font-size:0.85rem">Gagal memuat pesan</p></div>';
            });
    }

    function addMessageToChat(body, isSent, timestamp) {
        const messagesContainer = document.getElementById('chat-messages');

        const time = new Date(timestamp);
        const timeStr = time.toLocaleTimeString('id-ID', {
            hour: '2-digit',
            minute: '2-digit'
        });

        const messageDiv = document.createElement('div');
        messageDiv.className = `chat-message ${isSent ? 'sent' : 'received'}`;
        messageDiv.innerHTML = `
        <div>
            <div class="chat-bubble ${isSent ? 'sent' : 'received'}">${escapeHtml(body)}</div>
            <div class="chat-time">${timeStr}</div>
        </div>
    `;

        // Remove loading messages
        const loadingMsgs = messagesContainer.querySelectorAll('[style*="padding:2rem"]');
        if (loadingMsgs.length > 0) {
            loadingMsgs.forEach(msg => msg.remove());
        }

        messagesContainer.appendChild(messageDiv);
        messagesContainer.scrollTop = messagesContainer.scrollHeight;
    }

    function sendMessage(e) {
        e.preventDefault();

        if (!currentChatUserId) return;

        const input = document.getElementById('chat-input');
        const body = input.value.trim();

        if (!body) return;

        const sendBtn = e.target.querySelector('button');
        const originalHtml = sendBtn.innerHTML;
        sendBtn.disabled = true;
        sendBtn.innerHTML =
            '<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="animation:chatSpin 1s linear infinite"><polyline points="23 4 23 10 17 10"/><path d="M20.49 15a9 9 0 1 1 .64-8.64"/></svg>';

        // Send via AJAX
        fetch(`/pesan`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    receiver_id: currentChatUserId,
                    body: body
                })
            })
            .then(res => res.json())
            .then(data => {
                if (data.message) {
                    addMessageToChat(body, true, data.message.created_at);
                    input.value = '';
                    input.focus();
                } else if (data.error) {
                    alert('Gagal: ' + data.error);
                }
            })
            .catch(err => {
                console.error('Error sending message:', err);
                alert('Gagal mengirim pesan');
            })
            .finally(() => {
                sendBtn.disabled = false;
                sendBtn.innerHTML = originalHtml;
            });
    }

    function escapeHtml(text) {
        const map = {
            '&': '&amp;',
            '<': '&lt;',
            '>': '&gt;',
            '"': '&quot;',
            "'": '&#039;'
        };
        return text.replace(/[&<>"']/g, m => map[m]);
    }
</script>
