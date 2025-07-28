<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $post->title }} | ByteTech</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-900 min-h-screen flex flex-col">
    @include('components.navbar')

    <main class="flex-1 flex flex-col items-center justify-center px-4 py-8">
        <div class="w-full max-w-5xl bg-gray-800 rounded-lg shadow-lg p-4">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6 gap-4">
                <div>
                    <h1 class="text-4xl font-bold text-white mb-2">{{ $post->title }}</h1>
                    <p class="text-blue-400 font-semibold text-sm mb-2">{{ ucfirst(str_replace('_', ' ', $post->category)) }}</p>
                </div>
                <div class="flex items-center gap-3">
                    @if($owner->photo_url)
                    <a href="{{ route('profile.show', $owner->id) }}">
                        <img src="{{ $owner->photo_url }}" alt="Author photo" class="w-12 h-12 rounded-full object-cover border-2 border-blue-500">
                    </a>
                    @else
                        <a href="{{ route('profile.show', $owner->id) }}" class="w-12 h-12 rounded-full bg-gray-700 flex items-center justify-center text-blue-400 font-bold border-2 border-blue-500">
                            {{ strtoupper(substr($owner->name, 0, 1)) }}
                        </a>
                    @endif
                    <div>
                        <div class="text-white font-semibold">{{ $owner->name }}</div>
                        <div class="text-gray-400 text-xs">Published on {{ $post->created_at->format('F j, Y') }}</div>
                    </div>
                </div>
            </div>
            <p class="text-gray-300 mb-4 text-lg">{{ $post->description }}</p>
            <div class="flex flex-wrap gap-6 mb-6">
                <div class="flex items-center gap-2 bg-gray-700 px-3 py-1 rounded text-gray-200 text-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="w-5" fill="#3b82f6"><path d="M13 21V23H11V21H3C2.44772 21 2 20.5523 2 20V4C2 3.44772 2.44772 3 3 3H9C10.1947 3 11.2671 3.52375 12 4.35418C12.7329 3.52375 13.8053 3 15 3H21C21.5523 3 22 3.44772 22 4V20C22 20.5523 21.5523 21 21 21H13ZM20 19V5H15C13.8954 5 13 5.89543 13 7V19H20ZM11 19V7C11 5.89543 10.1046 5 9 5H4V19H11Z"></path></svg>
                    {{ $post->estimated_reading_time }} min read
                </div>
                <div class="flex items-center gap-2 bg-gray-700 px-3 py-1 rounded text-gray-200 text-sm">
                    <form 
                        id="like-post-form"
                        action="{{ route('posts.like', $post->id) }}"
                        method="POST"
                        class="flex items-center mb-0"
                    >
                        @csrf
                        <input type="hidden" name="_method" value="{{ auth()->check() && $post->likes->contains(auth()->user()->id) ? 'DELETE' : 'POST' }}">
                        <button
                            type="submit"
                            class="focus:outline-none"
                            aria-label="Like post"
                        >
                            @php
                                $postLiked = auth()->check() && $post->likes->contains(auth()->user()->id);
                            @endphp
                            <svg id="like-post-heart" class="w-5 h-5 transition" fill="{{ $postLiked ? 'red' : 'none' }}" stroke="{{ $postLiked ? 'red' : '#6b7280' }}" viewBox="0 0 24 24">
                                <path stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" d="M12.001 4.52853C14.35 2.42 17.98 2.49 20.2426 4.75736C22.5053 7.02472 22.583 10.637 20.4786 12.993L11.9999 21.485L3.52138 12.993C1.41705 10.637 1.49571 7.01901 3.75736 4.75736C6.02157 2.49315 9.64519 2.41687 12.001 4.52853Z"></path>
                            </svg>
                        </button>
                        <span id="like-post-count" class="ml-1">{{ $post->likes->count() }} Likes</span>
                    </form>
                </div>
                <div class="flex items-center gap-2 bg-gray-700 px-3 py-1 rounded text-gray-200 text-sm">
                    <svg class="w-5 h-5 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="2" fill="none"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6l4 2"/></svg>
                    Last updated: {{ $post->updated_at->format('F j, Y') }}
                </div>
            </div>
            <div class="prose prose-invert lg:prose-xl max-w-none bg-gray-900 rounded p-6 mb-8">
                {!! $post->content !!}
            </div>
            <div class="flex justify-between items-center mt-4">
                <a href="/" class="text-blue-400 hover:text-blue-600 font-semibold transition">← Back to Home</a>
                @if(auth()->check() && auth()->user()->id === $owner->id)
                    <a href="{{ route('posts.edit', $post->id) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded transition">Edit Post</a>
                @endif
            </div>
            <section class="mt-8 flex flex-col items-center w-full">
                <h2 class="text-2xl font-bold text-white mt-8 mb-4">Comments</h2>
                @if(auth()->check())
                    <div class="w-full mb-6">
                        <span class="w-full flex items-end justify-end">
                            <button
                            id="show-comment-form"
                            type="button"
                            class="w-30 items-start flex items-center justify-center gap-2 bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded transition"
                        >
                            Add a comment
                        </button>
                        </span>
                        
                        <form
                            id="comment-form"
                            action="{{ route('comments.store', $post->id) }}"
                            method="POST"
                            class="hidden mt-4"
                        >
                            @csrf
                            <textarea name="content" rows="3" class="w-full p-3 bg-gray-700 text-gray-200 rounded-lg border border-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Add a comment..." required></textarea>
                            <div class="flex justify-end gap-2 mt-2">
                                <button type="button" id="cancel-comment" class="bg-gray-600 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded transition">Cancel</button>
                                <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded transition">Post Comment</button>
                            </div>
                        </form>
                    </div>
                    
                @endif
                <div id="comments-list" class="w-full flex flex-col gap-4">
                    @if($comments->isEmpty())
                        <p class="text-gray-400">No comments yet. Be the first to comment!</p>
                    @else
                        @foreach($comments as $comment)
                            <x-comment :comment="$comment" />
                        @endforeach
                    @endif
                </div>
            </section>
        </div>
    </main>

    @include('components.footer')

@if(auth()->check())
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const showBtn = document.getElementById('show-comment-form');
        const form = document.getElementById('comment-form');
        const cancelBtn = document.getElementById('cancel-comment');
        const commentsList = document.getElementById('comments-list');
        if (showBtn && form) {
            showBtn.addEventListener('click', () => {
                form.classList.remove('hidden');
                showBtn.classList.add('hidden');
            });
        }
        if (cancelBtn && form && showBtn) {
            cancelBtn.addEventListener('click', () => {
                form.classList.add('hidden');
                showBtn.classList.remove('hidden');
                form.querySelector('textarea').value = '';
            });
        }
        if (form && commentsList) {
            form.addEventListener('submit', function (e) {
                e.preventDefault();
                const textarea = form.querySelector('textarea');
                const content = textarea.value.trim();
                if (!content) return;
                fetch(form.action, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({ content })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.comment && data.user) {
                        // Remove mensagem "No comments yet" se existir
                        const emptyMsg = commentsList.querySelector('p.text-gray-400');
                        if (emptyMsg) emptyMsg.remove();
                        // Adiciona o novo comentário no topo
                        const html = `
                            <div class="flex items-start gap-4 bg-gray-800 rounded-lg p-4 mb-4 shadow w-full">
                                ${data.user.photo_url
                                    ? `<img src="${data.user.photo_url}" alt="Profile photo" class="w-10 h-10 rounded-full object-cover border-2 border-blue-500">`
                                    : `<div class="w-10 h-10 rounded-full bg-gray-700 flex items-center justify-center text-blue-400 font-bold border-2 border-blue-500">${data.user.name.charAt(0).toUpperCase()}</div>`
                                }
                                <div class="flex-1">
                                    <div class="flex items-center gap-2 mb-1">
                                        <span class="text-white font-semibold">${data.user.name}</span>
                                        <span class="text-xs text-gray-400">just now</span>
                                    </div>
                                    <div class="text-gray-200 mb-2">${data.comment.content.replace(/\n/g, '<br>')}</div>
                                    <div class="flex items-center gap-3">
                                        <span class="text-sm text-gray-400 flex items-center gap-1">
                                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="#6b7280" viewBox="0 0 20 20">
                                                <path stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z"/>
                                            </svg>
                                            0
                                        </span>
                                    </div>
                                </div>
                            </div>
                        `;
                        commentsList.insertAdjacentHTML('afterbegin', html);
                        form.classList.add('hidden');
                        showBtn.classList.remove('hidden');
                        textarea.value = '';
                    }
                })
                .catch(() => {
                    alert('Could not add comment. Please try again.');
                });
            });
        }

        const likePostForm = document.getElementById('like-post-form');
        if (likePostForm) {
            likePostForm.addEventListener('submit', function (e) {
                e.preventDefault();
                const heart = document.getElementById('like-post-heart');
                const countSpan = document.getElementById('like-post-count');
                let liked = heart.getAttribute('fill') === 'red';
                let method = liked ? 'DELETE' : 'POST';

                fetch(likePostForm.action, {
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
                        countSpan.textContent = (count + 1) + ' Likes';
                    } else {
                        heart.setAttribute('fill', 'none');
                        heart.setAttribute('stroke', '#6b7280');
                        countSpan.textContent = (count - 1) + ' Likes';
                    }
                })
                .catch(() => {
                    alert('Could not process like. Please try again.');
                });
            });
        }
    });
</script>
@endif
</body>
</html>