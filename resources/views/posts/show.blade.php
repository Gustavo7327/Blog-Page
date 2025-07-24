
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
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="w-5" fill="red"><path d="M12.001 4.52853C14.35 2.42 17.98 2.49 20.2426 4.75736C22.5053 7.02472 22.583 10.637 20.4786 12.993L11.9999 21.485L3.52138 12.993C1.41705 10.637 1.49571 7.01901 3.75736 4.75736C6.02157 2.49315 9.64519 2.41687 12.001 4.52853Z"></path></svg>
                    {{ $post->likes }} Likes
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
        </div>
    </main>

    @include('components.footer')
</body>
</html>