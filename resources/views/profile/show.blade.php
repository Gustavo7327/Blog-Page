<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $user->name }}'s Profile | ByteTech</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-900 min-h-screen flex flex-col">
    @include('components.navbar')

    <main class="flex-1 flex flex-col items-center justify-center px-4 py-8">
        <div class="w-full max-w-5xl bg-gray-800 rounded-lg shadow-lg p-8">
            <div class="flex flex-col md:flex-row md:items-center md:gap-8 mb-8">
                <div class="flex justify-center md:justify-start mb-6 md:mb-0">
                    @if($user->photo_url)
                        <img src="{{ $user->photo_url }}" alt="Profile photo" class="w-32 h-32 rounded-full object-cover border-4 border-blue-500 shadow">
                    @else
                        <div class="w-32 h-32 rounded-full bg-gray-700 flex items-center justify-center text-blue-400 text-5xl font-bold border-4 border-blue-500 shadow">
                            {{ strtoupper(substr($user->name, 0, 1)) }}
                        </div>
                    @endif
                </div>
                <div class="flex-1">
                    <h1 class="text-3xl font-bold text-white mb-2">{{ $user->name }}</h1>
                    <p class="text-gray-400 text-sm mb-4">{{ $user->email }}</p>
                    @if($user->biography)
                        <div class="mb-4">
                            <h2 class="text-lg text-blue-400 font-semibold mb-1">Biography</h2>
                            <p class="text-gray-200">{{ $user->biography }}</p>
                        </div>
                    @endif
                    <div class="flex flex-wrap gap-4 mt-4">
                        <div class="bg-gray-700 px-4 py-2 rounded text-gray-200 text-sm flex items-center gap-2">
                            @if(auth()->check() && auth()->user()->id !== $user->id && auth()->user()->follows()->where('user_followed', $user->id)->exists())
                                <form action="{{ route('unfollow', $user->id) }}" method="POST" class="flex items-center">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class=""><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="#3b82f6" class="w-5 h-5"><path d="M13 14.0619V22H4C4 17.5817 7.58172 14 12 14C12.3387 14 12.6724 14.021 13 14.0619ZM12 13C8.685 13 6 10.315 6 7C6 3.685 8.685 1 12 1C15.315 1 18 3.685 18 7C18 10.315 15.315 13 12 13ZM17.7929 19.9142L21.3284 16.3787L22.7426 17.7929L17.7929 22.7426L14.2574 19.2071L15.6716 17.7929L17.7929 19.9142Z"></path></svg></button>
                                </form>
                            @elseif(auth()->check() && auth()->user()->id !== $user->id && !auth()->user()->follows()->where('user_followed', $user->id)->exists())
                                <form action="{{ route('follow', $user->id) }}" method="POST" class="flex items-center">
                                    @csrf
                                    <button type="submit" class=""><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="#3b82f6" class="w-5 h-5"><path d="M14 14.252V22H4C4 17.5817 7.58172 14 12 14C12.6906 14 13.3608 14.0875 14 14.252ZM12 13C8.685 13 6 10.315 6 7C6 3.685 8.685 1 12 1C15.315 1 18 3.685 18 7C18 10.315 15.315 13 12 13ZM19 16.5858L21.1213 14.4645L22.5355 15.8787L20.4142 18L22.5355 20.1213L21.1213 21.5355L19 19.4142L16.8787 21.5355L15.4645 20.1213L17.5858 18L15.4645 15.8787L16.8787 14.4645L19 16.5858Z"></path></svg></button>
                                </form>
                            @else
                                <svg class="w-5 h-5" viewBox="0 0 24 24" fill="#3b82f6"><path d="M4 22C4 17.5817 7.58172 14 12 14C16.4183 14 20 17.5817 20 22H4ZM12 13C8.685 13 6 10.315 6 7C6 3.685 8.685 1 12 1C15.315 1 18 3.685 18 7C18 10.315 15.315 13 12 13Z"></path></svg>
                            @endif
                            <span>{{ $user->followers()->count() }} Followers</span>
                        </div>
                        <div class="bg-gray-700 px-4 py-2 rounded text-gray-200 text-sm flex items-center gap-2">
                            <svg class="w-5 h-5 text-green-400" viewBox="0 0 24 24" fill="currentColor"><path d="M4 22C4 17.5817 7.58172 14 12 14C16.4183 14 20 17.5817 20 22H4ZM12 13C8.685 13 6 10.315 6 7C6 3.685 8.685 1 12 1C15.315 1 18 3.685 18 7C18 10.315 15.315 13 12 13Z"></path></svg>
                            <span>{{ $user->follows()->count() }} Following</span>
                        </div>
                        <div class="bg-gray-700 px-4 py-2 rounded text-gray-200 text-sm flex items-center gap-2 h-10">
                            <svg class="w-5 h-5 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21H5a2 2 0 0 1-2-2V7a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 3v4M7 3v4"/></svg>
                            <span>{{ $user->posts()->count() }} Posts</span>
                        </div>
                        @if(auth()->check() && auth()->user()->id === $user->id)
                            <div class="flex items-center gap-4">
                                <a href="{{ route('profile.edit', $user->id) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded transition">Edit Profile</a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            <div>
                <h2 class="text-xl text-white font-semibold mb-4">Recent Posts</h2>
                <div class="grid gap-4">
                    @forelse($user->posts()->latest()->take(5)->get() as $post)
                        <a href="{{ route('posts.show', $post->id) }}" class="block bg-gray-700 hover:bg-gray-600 rounded p-4 transition">
                            <h3 class="text-lg text-blue-400 font-bold mb-1">{{ $post->title }}</h3>
                            <p class="text-gray-300 text-sm mb-1">{{ Str::limit($post->description, 80) }}</p>
                            <span class="text-xs text-gray-400">{{ $post->created_at->format('M d, Y') }}</span>
                        </a>
                    @empty
                        <p class="text-gray-400">No posts yet.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </main>
    @include('components.footer')
</body>
</html>