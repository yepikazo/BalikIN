@props(['comment'])

<div class="mt-4">
    <div class="flex space-x-3">
        <div class="flex-shrink-0">
            <div class="h-10 w-10 rounded-full bg-blue-100 border border-blue-300 flex items-center justify-center text-blue-700 font-bold uppercase">
                {{ substr($comment->user->name, 0, 1) }}
            </div>
        </div>
        
        <div class="flex-grow">
            <div class="bg-gray-100 p-3 rounded-2xl inline-block min-w-[200px]">
                <a href="#" class="font-bold text-sm text-blue-800 hover:underline">{{ $comment->user->name }}</a>
                <p class="text-gray-800 text-sm mt-1">{{ $comment->content }}</p>
            </div>
            
            <div class="flex items-center space-x-4 mt-1 ml-3 text-xs text-gray-500 font-semibold">
                <span>{{ $comment->created_at->diffForHumans() }}</span>
                
                @auth
                    <button onclick="document.getElementById('reply-form-{{ $comment->id }}').classList.toggle('hidden')" class="hover:underline hover:text-gray-800">Balas</button>
                    
                    @if(Auth::id() === $comment->user_id || Auth::user()->is_admin)
                        <form action="{{ route('comment.destroy', $comment->id) }}" method="POST" class="inline" onsubmit="return confirm('Hapus komentar ini?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-500 hover:underline">Hapus</button>
                        </form>
                    @endif
                @endauth
            </div>

            @auth
            <div id="reply-form-{{ $comment->id }}" class="hidden mt-3 max-w-lg">
                <form action="{{ route('comment.store') }}" method="POST" class="flex gap-2 items-center">
                    @csrf
                    <input type="hidden" name="postingan_id" value="{{ $comment->postingan_id }}">
                    <input type="hidden" name="parent_id" value="{{ $comment->id }}">
                    
                    <input type="text" name="content" placeholder="Tulis balasan ke {{ $comment->user->name }}..." class="w-full border-gray-300 rounded-full px-4 py-2 text-sm focus:ring-blue-500 focus:border-blue-500" required>
                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-full text-sm font-bold hover:bg-blue-700 transition">Kirim</button>
                </form>
            </div>
            @endauth
        </div>
    </div>

    @if($comment->replies->count() > 0)
        <div class="ml-12 mt-2 border-l-2 border-gray-200 pl-4 space-y-2">
            @foreach($comment->replies as $reply)
                <x-comment-item :comment="$reply" />
            @endforeach
        </div>
    @endif
</div>