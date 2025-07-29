<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ByteTech - Home</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-900 min-h-screen flex flex-col">
    @include('components.navbar')
    <main class="container mx-auto px-4 py-8 flex flex-col items-center flex-1">
        <h2 class="text-3xl text-white font-bold mt-8">Read and write articles!</h2>
        <p class="text-gray-400 mt-2 mb-6">Explore a variety of topics, share your thoughts, and connect with others.</p>

        <section class="w-full max-w-5xl mt-8 bg-gray-800/80 rounded-xl shadow-lg p-6 border border-gray-700" id="articles">
        <form method="GET" action="{{ route('home') }}" class="flex items-center space-x-2 mb-8">
            <input
                type="text"
                name="search"
                value="{{ request('search') }}"
                placeholder="Search posts by title, description or tags..."
                class="w-full p-3 rounded-lg bg-gray-900 text-white border border-gray-600 focus:ring-2 focus:ring-blue-600 transition"
            >
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-lg font-semibold transition">Search</button>
        </form>

        @if($posts->count())
            <div class="space-y-5">
                @foreach($posts as $post)
                    <article class="bg-gray-900/80 hover:bg-gray-800 transition p-5 rounded-lg flex flex-col gap-2 border border-gray-700 shadow group">
                        <a href="{{ route('posts.show', $post->id) }}" class="text-xl text-blue-400 group-hover:text-blue-300 font-bold underline underline-offset-2 decoration-blue-600 hover:decoration-blue-400 transition">
                            {{ $post->title }}
                        </a>
                        <p class="text-gray-300">{{ Str::limit(strip_tags($post->description), 100) }}</p>
                        <div class="flex flex-wrap gap-2 mt-1">
                            @foreach($post->tags as $tag)
                                <span class="bg-blue-700/80 text-white px-3 py-1 rounded-full text-xs font-medium">{{ $tag }}</span>
                            @endforeach
                        </div>
                    </article>
                @endforeach
            </div>
            <div class="mt-8 flex justify-center">
                {{ $posts->links() }}
            </div>
        @else
            <p class="text-gray-400 text-center">No posts found for your search.</p>
        @endif
    </section>

    <section class="w-full max-w-5xl mt-12">
        <h3 class="text-2xl text-white font-bold mb-6 flex items-center gap-2">
            <svg class="w-7 h-7 text-pink-500" fill="currentColor" viewBox="0 0 20 20"><path d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z"/></svg>
            Most Liked Posts
        </h3>
        <div class="grid gap-5">
            @forelse($mostLiked as $post)
                <article class="bg-gray-800/90 border border-gray-600/40 rounded-lg p-5 flex flex-col gap-2 shadow hover:shadow-pink-500/20 transition">
                    <div class="flex items-center justify-between">
                        <a href="{{ route('posts.show', $post->id) }}" class="text-xl text-blue-400 hover:text-blue-300 font-bold underline underline-offset-2 decoration-blue-600 hover:decoration-blue-400 transition">
                            {{ $post->title }}
                        </a>
                        <span class="flex items-center gap-1 text-pink-400 font-semibold text-sm">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z"/></svg>
                            {{ $post->likes_count }}
                        </span>
                    </div>
                    <p class="text-gray-300">{{ Str::limit(strip_tags($post->description), 80) }}</p>
                    <div class="flex flex-wrap gap-2 mt-1">
                        @foreach($post->tags as $tag)
                            <span class="bg-blue-700/80 text-white px-3 py-1 rounded-full text-xs font-medium">{{ $tag }}</span>
                        @endforeach
                    </div>
                </article>
            @empty
                <p class="text-gray-400">No liked posts yet.</p>
            @endforelse
        </div>
    </section>

    </main>
    @include('components.footer')
</body>
</html>