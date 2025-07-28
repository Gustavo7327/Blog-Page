@props(['comment'])

@php
    $user = auth()->user();
    $liked = $user ? $comment->likes->contains($user->id) : false;
@endphp

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
            @if($comment->updated_at && $comment->created_at != $comment->updated_at)
                <span class="text-xs text-gray-500">(edited)</span>
            @endif
        </div>
        <div class="text-gray-200 mb-2" id="comment-content-{{ $comment->id }}">
            {!! nl2br(e($comment->content)) !!}
        </div>
        <form 
            id="edit-form-{{ $comment->id }}" 
            action="{{ route('comments.update', $comment->id) }}" 
            method="POST" 
            class="hidden mb-2">

            @csrf
            @method('PATCH')
            <textarea name="content" rows="3" class="w-full p-2 rounded bg-gray-700 text-white mb-2 focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('content', $comment->content) }}</textarea>
            <div class="flex gap-2">
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-4 rounded transition">Save</button>
                <button type="button" class="bg-gray-600 hover:bg-gray-700 text-white font-bold py-1 px-4 rounded transition" onclick="toggleEditForm('{{ $comment->id }}', false)">Cancel</button>
            </div>
        </form>
        <div class="flex items-center gap-3">
            <form 
                id="like-form-{{ $comment->id }}"
                action="{{ route('comments.like', $comment->id) }}"
                method="POST"
                class="flex items-center mb-0"
            >
                @csrf
                <input type="hidden" name="_method" value="{{ $liked ? 'DELETE' : 'POST' }}">
                <button
                    type="submit"
                    class="focus:outline-none"
                    aria-label="Like"
                >
                    <svg class="w-5 h-5 transition" id="like-heart-{{ $comment->id }}" fill="{{ $liked ? 'red' : 'none' }}" stroke="{{ $liked ? 'red' : '#6b7280' }}" viewBox="0 0 20 20">
                        <path stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z"/>
                    </svg>
                </button>
                <span id="like-count-{{ $comment->id }}" class="ml-1 text-gray-200">{{ $comment->likes->count() }}</span>
            </form>

            @if(auth()->check() && auth()->user()->id === $comment->user_id)
                <form 
                    id="delete-form-{{ $comment->id }}"
                    action="{{ route('comments.destroy', $comment->id) }}" 
                    method="post" 
                    class="flex items-center justify-center mb-0"
                >
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="text-red-400 hover:text-red-600 transition flex items-center gap-1 mb-0">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="currentColor"><path d="M4 8H20V21C20 21.5523 19.5523 22 19 22H5C4.44772 22 4 21.5523 4 21V8ZM7 5V3C7 2.44772 7.44772 2 8 2H16C16.5523 2 17 2.44772 17 3V5H22V7H2V5H7ZM9 4V5H15V4H9ZM9 12V18H11V12H9ZM13 12V18H15V12H13Z"></path></svg>
                    </button>
                </form>
                <button type="button" onclick="toggleEditForm('{{ $comment->id }}', true)" class="ml-2 text-blue-400 hover:text-blue-600 transition flex items-center gap-1 mb-0">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="currentColor"><path d="M12.8995 6.85453L17.1421 11.0972L7.24264 20.9967H3V16.754L12.8995 6.85453ZM14.3137 5.44032L16.435 3.319C16.8256 2.92848 17.4587 2.92848 17.8492 3.319L20.6777 6.14743C21.0682 6.53795 21.0682 7.17112 20.6777 7.56164L18.5563 9.68296L14.3137 5.44032Z"></path></svg>
                </button>
            @endif
        </div>
    </div>
</div>

@if(auth()->check())
<script>
document.addEventListener('DOMContentLoaded', function () {
    const likeForm = document.getElementById('like-form-{{ $comment->id }}');
    const editForm = document.getElementById('edit-form-{{ $comment->id }}');
    const deleteForm = document.getElementById('delete-form-{{ $comment->id }}');

    if (likeForm) {
        likeForm.addEventListener('submit', function (e) {
            e.preventDefault();
            const heart = document.getElementById('like-heart-{{ $comment->id }}');
            const countSpan = document.getElementById('like-count-{{ $comment->id }}');
            let liked = heart.getAttribute('fill') === 'red';
            let method = liked ? 'DELETE' : 'POST';

            fetch(likeForm.action, {
                method: method,
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                let count = parseInt(countSpan.textContent);
                if (!liked) {
                    heart.setAttribute('fill', 'red');
                    heart.setAttribute('stroke', 'red');
                    countSpan.textContent = count + 1;
                } else {
                    heart.setAttribute('fill', 'none');
                    heart.setAttribute('stroke', '#6b7280');
                    countSpan.textContent = count - 1;
                }
            })
            .catch(() => {
                alert('Could not process like. Please try again.');
            });
        });
    }

    if (editForm) {
        editForm.addEventListener('submit', function (e) {
            e.preventDefault();
            const formData = new FormData(editForm);
            fetch(editForm.action, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                },
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.comment.content) {
                    document.getElementById('comment-content-{{ $comment->id }}').innerHTML = data.comment.content.replace(/\n/g, '<br>');
                    toggleEditForm('{{ $comment->id }}', false);
                } else if (data.message) {
                    alert(data.message);
                }
            })
            .catch(() => {
                alert('Could not update comment. Please try again.');
            });
        });
    }

    if (deleteForm) {
        deleteForm.addEventListener('submit', function (e) {
            e.preventDefault();
            if (!confirm('Are you sure you want to delete this comment?')) return;
            fetch(deleteForm.action, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                },
                body: new FormData(deleteForm)
            })
            .then(response => response.json())
            .then(data => {
                if (data.deleted) {
                    // Remove o comentário da tela
                    deleteForm.closest('.bg-gray-800').remove();
                } else if (data.message) {
                    alert(data.message);
                }
            })
            .catch(() => {
                alert('Could not delete comment. Please try again.');
            });
        });
    }
});
</script>
@endif
<script>
    function toggleEditForm(commentId, show) {
        const form = document.getElementById('edit-form-' + commentId);
        const content = document.getElementById('comment-content-' + commentId);
        if (show) {
            form.classList.remove('hidden');
            content.classList.add('hidden');
        } else {
            form.classList.add('hidden');
            content.classList.remove('hidden');
        }
    }
</script>