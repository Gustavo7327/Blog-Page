@props(['comment'])

<div class="flex items-start gap-4 bg-gray-800 rounded-lg p-4 mb-4 shadow w-full">
    @if($comment->user->photo_url)
        <img src="{{ $comment->user->photo_url }}" alt="Profile photo" class="w-10 h-10 rounded-full object-cover border-2 border-blue-500">
    @else
        <div class="w-10 h-10 rounded-full bg-gray-700 flex items-center justify-center text-blue-400 font-bold border-2 border-blue-500">
            {{ strtoupper(substr($comment->user->name ?? '?', 0, 1)) }}
        </div>
    @endif
    <div class="flex-1">
        <div class="flex items-center gap-2 mb-1">
            <span class="text-white font-semibold">{{ $comment->user->name ?? 'Unknown' }}</span>
            <span class="text-xs text-gray-400">{{ $comment->created_at->diffForHumans() }}</span>
        </div>
        <div class="text-gray-200 mb-2">
            {!! nl2br(e($comment->content)) !!}
        </div>
        <div class="flex items-center gap-3">
            <span class="text-sm text-gray-400 flex items-center gap-1">
                <svg class="w-5 h-5 text-red-400" fill="currentColor" viewBox="0 0 20 20"><path d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z"/></svg>
                {{ $comment->likes ?? 0 }}
            </span>

            @if(auth()->check() && auth()->user()->id === $comment->user_id)
                <form action="{{ route('comments.destroy', $comment->id) }}" method="post" class="flex items-center justify-center mb-0">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="text-red-400 hover:text-red-600 transition flex items-center gap-1">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="currentColor"><path d="M4 8H20V21C20 21.5523 19.5523 22 19 22H5C4.44772 22 4 21.5523 4 21V8ZM7 5V3C7 2.44772 7.44772 2 8 2H16C16.5523 2 17 2.44772 17 3V5H22V7H2V5H7ZM9 4V5H15V4H9ZM9 12V18H11V12H9ZM13 12V18H15V12H13Z"></path></svg>
                    </button>
                </form>
            @endif
        </div>
    </div>
</div>