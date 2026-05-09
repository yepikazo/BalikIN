@php
    $layout = Auth::user()->is_admin ? 'admin-layout' : 'app-layout';
@endphp
<x-dynamic-component :component="$layout" title="Chat dengan {{ $otherUser->name }} — Balik.in">
    @if(!Auth::user()->is_admin)
        <x-slot:title>Chat dengan {{ $otherUser->name }} — Balik.in</x-slot>
    @endif



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
                    <div class="chat-msg-wrap" data-msg-id="{{ $msg->id }}" style="display:flex;flex-direction:column;align-items:{{ $isSent ? 'flex-end' : 'flex-start' }}">
                        @if($isSent)
                        <div class="msg-actions" style="display:none;gap:4px;margin-bottom:4px">
                            <button onclick="startEdit({{ $msg->id }})" class="msg-act-btn">Edit</button>
                            <button onclick="deleteMsg({{ $msg->id }})" class="msg-act-btn msg-act-btn--danger">Hapus</button>
                        </div>
                        @endif
                        <div class="msg-bubble" style="max-width:72%;padding:0.75rem 1rem;border-radius:{{ $isSent ? 'var(--radius-md) 4px var(--radius-md) var(--radius-md)' : '4px var(--radius-md) var(--radius-md) var(--radius-md)' }};font-size:0.875rem;line-height:1.5;word-break:break-word;background:{{ $isSent ? 'var(--ink)' : 'white' }};color:{{ $isSent ? 'white' : 'var(--ink)' }};border:{{ $isSent ? 'none' : '1px solid var(--border-subtle)' }}">{{ $msg->body }}</div>
                        <div class="msg-time" style="font-size:0.68rem;color:var(--ink-faint);margin-top:3px;padding:0 4px">{{ $msg->created_at->format('d M Y, H:i') }}</div>
                    </div>
                @empty
                        <div id="empty-state" style="flex:1;display:flex;flex-direction:column;align-items:center;justify-content:center;gap:0.75rem;padding:2rem;text-align:center;height:100%">
                            <div style="width:56px;height:56px;border-radius:var(--radius-full);background:var(--accent);color:white;font-size:1.2rem;font-weight:700;display:flex;align-items:center;justify-content:center">{{ strtoupper(substr($otherUser->name, 0, 1)) }}</div>
                            <p style="font-weight:600;font-size:0.9rem;color:var(--ink)">{{ $otherUser->name }}</p>
                            <p style="font-size:0.8rem;color:var(--ink-faint)">Mulai percakapan dengan mengirim pesan pertama.</p>
                        </div>
                @endforelse

                <div id="typing-indicator" style="display:none;align-items:flex-start">
                    <div style="padding:0.625rem 1rem;background:white;border:1px solid var(--border-subtle);border-radius:4px var(--radius-md) var(--radius-md) var(--radius-md);display:flex;gap:4px;align-items:center">
                        <span class="typing-dot"></span><span class="typing-dot" style="animation-delay:0.2s"></span><span class="typing-dot" style="animation-delay:0.4s"></span>
                    </div>
                </div>
            </div>

            <div style="padding:0.875rem 1.25rem;border-top:1px solid var(--border-subtle);background:white">
                <form id="chat-form" style="display:flex;gap:0.625rem;align-items:flex-end" onsubmit="sendMsg(event)">
                    <input type="text" id="msg-input" placeholder="Tulis pesan..." class="bk-input"
                        style="flex:1;min-width:0;border-radius:var(--radius-full);padding:0.6rem 1rem"
                        autocomplete="off" maxlength="1000"
                        value="{{ request('item') ? 'Saya ingin berbincang tentang postingan anda terkait ' . request('item') . ' Bisakah kita membahas ini lebih lanjut?' : '' }}">
                    <button type="submit" id="send-btn"
                        style="width:40px;height:40px;border-radius:var(--radius-full);background:var(--ink);color:white;border:none;cursor:pointer;display:flex;align-items:center;justify-content:center;flex-shrink:0;transition:all 0.15s"
                        onmouseover="this.style.background='var(--accent)'" onmouseout="this.style.background='var(--ink)'">
                        <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="22" y1="2" x2="11" y2="13"/><polygon points="22 2 15 22 11 13 2 9 22 2"/></svg>
                    </button>
                </form>
                <p style="font-size:0.7rem;color:var(--ink-faint);margin-top:0.4rem;text-align:center">Tekan Enter atau klik tombol kirim</p>
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
            width: 7px; height: 7px; border-radius: 50%;
            background: var(--border);
            animation: typingBounce 1.2s infinite;
        }
        @keyframes typingBounce {
            0%, 80%, 100% { transform: scale(0.7); opacity: 0.5; }
            40% { transform: scale(1); opacity: 1; }
        }
        .chat-msg-new { animation: msgFadeIn 0.25s ease; }
        @keyframes msgFadeIn {
            from { opacity: 0; transform: translateY(6px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        /* Tombol edit / hapus */
        .msg-act-btn {
            padding: 2px 10px;
            font-size: 0.7rem;
            font-weight: 600;
            font-family: var(--font-body);
            border-radius: var(--radius-sm);
            cursor: pointer;
            border: 1px solid var(--border);
            background: var(--surface-2);
            color: var(--ink-muted);
            transition: all 0.15s;
        }
        .msg-act-btn:hover { background: var(--surface-3); color: var(--ink); }
        .msg-act-btn--danger { background: var(--danger-light); color: var(--danger); border-color: rgba(192,57,43,0.25); }
        .msg-act-btn--danger:hover { background: var(--danger); color: white; }

        /* Hover state on sent message wraps */
        .chat-msg-wrap:hover .msg-actions { display: flex !important; }

        /* Edit form inside bubble */
        .msg-edit-input {
            background: rgba(255,255,255,0.15);
            border: 1px solid rgba(255,255,255,0.35);
            border-radius: 6px;
            padding: 5px 10px;
            color: white;
            font-size: 0.85rem;
            font-family: var(--font-body);
            outline: none;
            width: 100%;
            min-width: 160px;
        }
        .msg-edit-input:focus { border-color: rgba(255,255,255,0.6); }
        .msg-edited-label { font-size: 0.62rem; opacity: 0.65; margin-left: 6px; }
    </style>

    @push('scripts')
    <script>
        const currentUserId = {{ Auth::id() }};
        const receiverId    = {{ $otherUser->id }};
        const csrfToken     = document.querySelector('meta[name="csrf-token"]').content;
        let currentMessages = {!! $messages->map(fn($m)=>['id'=>$m->id,'body'=>$m->body,'sender_id'=>$m->sender_id,'updated_at'=>$m->updated_at])->values()->toJson() !!};
        let pollInterval    = null;

        const container = document.getElementById('messages-container');
        const input     = document.getElementById('msg-input');
        const sendBtn   = document.getElementById('send-btn');

        window.addEventListener('DOMContentLoaded', () => {
            scrollBottom();
            pollInterval = setInterval(pollMessages, 5000);
            input.focus();
        });

        function scrollBottom(smooth = false) {
            container.scrollTo({ top: container.scrollHeight, behavior: smooth ? 'smooth' : 'auto' });
        }

        function esc(text) {
            const d = document.createElement('div');
            d.textContent = text;
            return d.innerHTML;
        }

        function createMsgEl(id, body, isSent, timeStr, isEdited = false) {
            const wrap   = document.createElement('div');
            wrap.className   = 'chat-msg-wrap chat-msg-new';
            wrap.dataset.msgId = id;
            wrap.style.cssText = `display:flex;flex-direction:column;align-items:${isSent?'flex-end':'flex-start'}`;
            const r = isSent ? 'var(--radius-md) 4px var(--radius-md) var(--radius-md)' : '4px var(--radius-md) var(--radius-md) var(--radius-md)';
            const bg = isSent ? 'var(--ink)' : 'white';
            const cl = isSent ? 'white' : 'var(--ink)';
            const bd = isSent ? 'none' : '1px solid var(--border-subtle)';
            wrap.innerHTML = `
                ${isSent ? `<div class="msg-actions" style="display:none;gap:4px;margin-bottom:4px">
                    <button onclick="startEdit(${id})" class="msg-act-btn">Edit</button>
                    <button onclick="deleteMsg(${id})" class="msg-act-btn msg-act-btn--danger">Hapus</button>
                </div>` : ''}
                <div class="msg-bubble" style="max-width:72%;padding:0.75rem 1rem;border-radius:${r};font-size:0.875rem;line-height:1.5;word-break:break-word;background:${bg};color:${cl};border:${bd}">
                    ${esc(body)}${isEdited ? '<span class="msg-edited-label">(diedit)</span>' : ''}
                </div>
                <div class="msg-time" style="font-size:0.68rem;color:var(--ink-faint);margin-top:3px;padding:0 4px">${timeStr}</div>`;
            return wrap;
        }

        function formatTime(isoStr) {
            try {
                const d=new Date(isoStr),now=new Date();
                const t=d.toLocaleTimeString('id-ID',{hour:'2-digit',minute:'2-digit'});
                return d.toDateString()===now.toDateString() ? 'Hari ini, '+t
                    : d.toLocaleDateString('id-ID',{day:'numeric',month:'short',year:'numeric'})+', '+t;
            } catch(e){return '';}
        }

        async function sendMsg(e) {
            e.preventDefault();
            const body = input.value.trim();
            if (!body) return;
            input.value=''; input.disabled=true; sendBtn.disabled=true; sendBtn.style.opacity='0.5';
            document.getElementById('empty-state')?.remove();

            const tempEl = createMsgEl('tmp', body, true, 'Mengirim...');
            container.insertBefore(tempEl, document.getElementById('typing-indicator'));
            scrollBottom(true);
            try {
                const payload = { receiver_id: receiverId, body };

                const res  = await fetch('/pesan', {method:'POST',headers:{'Content-Type':'application/json','X-CSRF-TOKEN':csrfToken,'Accept':'application/json'},body:JSON.stringify(payload)});
                const data = await res.json();
                if (res.ok && data.message) {
                    tempEl.dataset.msgId = data.message.id;
                    tempEl.querySelector('.msg-time').textContent = formatTime(data.message.created_at);

                    currentMessages.push({id:data.message.id,body,sender_id:currentUserId,updated_at:data.message.updated_at});
                } else { tempEl.remove(); input.value=body; showToast(data.error||'Gagal mengirim pesan.','error'); }
            } catch(err) { tempEl.remove(); input.value=body; showToast('Koneksi gagal.','error'); }
            input.disabled=false; sendBtn.disabled=false; sendBtn.style.opacity='1'; input.focus();
        }

        function startEdit(id) {
            const wrap=document.querySelector(`[data-msg-id="${id}"]`);
            if(!wrap) return;
            const bubble=wrap.querySelector('.msg-bubble');
            const orig=bubble.firstChild?.textContent?.trim()??'';
            bubble.innerHTML=`<div style="display:flex;flex-direction:column;gap:0.375rem;min-width:180px">
                <input id="edit-input-${id}" class="msg-edit-input" value="${orig.replace(/"/g,'&quot;')}"
                       onkeydown="if(event.key==='Enter')saveEdit(${id});if(event.key==='Escape')cancelEdit(${id})">
                <div style="display:flex;gap:0.375rem">
                    <button onclick="saveEdit(${id})" style="flex:1;padding:4px 8px;background:rgba(255,255,255,0.2);border:1px solid rgba(255,255,255,0.35);border-radius:4px;color:white;font-size:0.75rem;font-weight:600;cursor:pointer;font-family:var(--font-body)">Simpan</button>
                    <button onclick="cancelEdit(${id})" style="flex:1;padding:4px 8px;background:transparent;border:1px solid rgba(255,255,255,0.2);border-radius:4px;color:rgba(255,255,255,0.7);font-size:0.75rem;cursor:pointer;font-family:var(--font-body)">Batal</button>
                </div></div>`;
            document.getElementById(`edit-input-${id}`)?.focus();
        }

        function cancelEdit(id) {
            const msg=currentMessages.find(m=>m.id==id);
            if(!msg) return;
            const bubble=document.querySelector(`[data-msg-id="${id}"] .msg-bubble`);
            if(bubble) bubble.innerHTML=esc(msg.body) + (msg.updated_at !== msg.created_at ? '<span class="msg-edited-label">(diedit)</span>' : '');
        }

        async function saveEdit(id) {
            const inputEl=document.getElementById(`edit-input-${id}`);
            if(!inputEl) return;
            const newBody=inputEl.value.trim();
            if(!newBody) return;
            try {
                const res=await fetch(`/pesan/${id}`,{method:'PUT',headers:{'Content-Type':'application/json','X-CSRF-TOKEN':csrfToken,'Accept':'application/json'},body:JSON.stringify({body:newBody})});
                const data=await res.json();
                if(res.ok) {
                    const bubble=document.querySelector(`[data-msg-id="${id}"] .msg-bubble`);
                    if(bubble) bubble.innerHTML=esc(newBody)+'<span class="msg-edited-label">(diedit)</span>';
                    const m=currentMessages.find(m=>m.id==id); if(m) { m.body=newBody; m.updated_at = new Date().toISOString(); }
                } else { showToast(data.error||'Gagal menyimpan.','error'); cancelEdit(id); }
            } catch(err) { showToast('Koneksi gagal.','error'); cancelEdit(id); }
        }

        async function deleteMsg(id) {
            if(!confirm('Hapus pesan ini?')) return;
            try {
                const res=await fetch(`/pesan/${id}`,{method:'DELETE',headers:{'X-CSRF-TOKEN':csrfToken,'Accept':'application/json'}});
                if(res.ok) {
                    const wrap=document.querySelector(`[data-msg-id="${id}"]`);
                    if(wrap){wrap.style.transition='opacity 0.2s,transform 0.2s';wrap.style.opacity='0';wrap.style.transform='translateX(20px)';setTimeout(()=>wrap.remove(),200);}
                    currentMessages=currentMessages.filter(m=>m.id!=id);
                } else { showToast('Gagal menghapus pesan.','error'); }
            } catch(err) { showToast('Koneksi gagal.','error'); }
        }

        async function pollMessages() {
            try {
                const res=await fetch(`/api/messages/${receiverId}`,{headers:{'X-CSRF-TOKEN':csrfToken,'Accept':'application/json'}});
                if(!res.ok) return;
                const data=await res.json();
                const clientIds=new Set(currentMessages.map(m=>m.id));
                const wasAtBottom=container.scrollTop+container.clientHeight>=container.scrollHeight-60;
                let hasNew=false;
                data.forEach(msg=>{
                    if(!clientIds.has(msg.id)){
                        const isSent=msg.sender_id===currentUserId;
                        const el=createMsgEl(msg.id,msg.body,isSent,formatTime(msg.created_at));
                        container.insertBefore(el,document.getElementById('typing-indicator'));
                        currentMessages.push({id:msg.id,body:msg.body,sender_id:msg.sender_id,updated_at:msg.updated_at});
                        hasNew=true;
                    }
                });
                if(hasNew && wasAtBottom) scrollBottom(true);
            } catch(e){}
        }

        input.addEventListener('keydown',e=>{
            if(e.key==='Enter'&&!e.shiftKey){e.preventDefault();document.getElementById('chat-form').dispatchEvent(new Event('submit'));}
        });

        function showToast(msg,type='error'){
            const t=document.createElement('div');
            t.style.cssText=`position:fixed;bottom:1.5rem;left:50%;transform:translateX(-50%);padding:0.75rem 1.25rem;background:${type==='error'?'var(--danger)':'var(--success)'};color:white;border-radius:var(--radius-sm);font-size:0.85rem;font-weight:500;z-index:9999;box-shadow:var(--shadow-lg);animation:msgFadeIn 0.25s ease`;
            t.textContent=msg; document.body.appendChild(t); setTimeout(()=>t.remove(),3000);
        }
    </script>
    @endpush
</x-dynamic-component>
