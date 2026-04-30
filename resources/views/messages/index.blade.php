<x-app-layout>
    <x-slot:title>Kotak Masuk - Balik.in</x-slot>

    <div class="max-w-4xl mx-auto">
        <h1 class="text-2xl font-extrabold text-gray-900 mb-6">Kotak Masuk Pesan</h1>

        <div class="bg-white rounded-xl shadow border border-gray-200 divide-y">
            @forelse($messages as $msg)
                <div class="p-4 md:p-6 flex flex-col md:flex-row gap-4 justify-between items-start md:items-center hover:bg-gray-50 transition">
                    <div>
                        @if($msg->sender_id === Auth::id())
                            <span class="text-xs font-bold text-gray-500 uppercase">Pesan Keluar ke:</span>
                            <h3 class="font-bold text-blue-700">{{ $msg->receiver->name }}</h3>
                        @else
                            <span class="text-xs font-bold text-green-500 uppercase">Pesan Masuk dari:</span>
                            <h3 class="font-bold text-gray-900">{{ $msg->sender->name }}</h3>
                        @endif
                        
                        <p class="text-gray-700 text-sm mt-1 bg-gray-100 p-3 rounded-lg border border-gray-200 inline-block">{{ $msg->body }}</p>
                        <div class="text-xs text-gray-400 mt-2">{{ $msg->created_at->diffForHumans() }}</div>
                    </div>

                    @if($msg->sender_id !== Auth::id())
                        <form action="{{ route('messages.store') }}" method="POST" class="flex w-full md:w-auto gap-2">
                            @csrf
                            <input type="hidden" name="receiver_id" value="{{ $msg->sender_id }}">
                            <input type="text" name="body" placeholder="Balas pesan..." class="text-sm rounded border-gray-300 flex-grow md:w-48" required>
                            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded text-sm font-bold">Balas</button>
                        </form>
                    @endif
                </div>
            @empty
                <div class="p-8 text-center text-gray-500">
                    Belum ada riwayat pesan.
                </div>
            @endforelse
        </div>
    </div>
</x-app-layout>