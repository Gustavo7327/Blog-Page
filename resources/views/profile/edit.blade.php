<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile | ByteTech</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-900 min-h-screen flex flex-col">
    @include('components.navbar')

    <main class="flex-1 flex flex-col items-center justify-center px-4 py-8">
        <div class="w-full max-w-2xl bg-gray-800 rounded-lg shadow-lg p-8">
            <h1 class="text-3xl font-bold text-white mb-6 text-center">Edit Profile</h1>
            <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="space-y-6">
                @csrf
                @method('PATCH')
                <div>
                    <label for="name" class="block text-white mb-2">Name</label>
                    <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" required class="w-full p-3 rounded bg-gray-700 text-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                    @error('name')
                        <span class="text-red-400 text-sm">{{ $message }}</span>
                    @enderror
                </div>
                <div>
                    <label for="biography" class="block text-white mb-2">Biography</label>
                    <textarea id="biography" name="biography" rows="4" class="w-full p-3 rounded bg-gray-700 text-white focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Tell us about yourself...">{{ old('biography', $user->biography) }}</textarea>
                    @error('biography')
                        <span class="text-red-400 text-sm">{{ $message }}</span>
                    @enderror
                </div>
                <div>
                    <label for="photo_url" class="block text-white mb-2">Profile Photo</label>
                    <input type="file" id="photo_url" name="photo_url" class="w-full p-3 rounded bg-gray-700 text-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                    @error('photo_url')
                        <span class="text-red-400 text-sm">{{ $message }}</span>
                    @enderror
                </div>
                <button type="submit" class="w-full bg-blue-600 text-white px-4 py-3 rounded hover:bg-blue-700 font-bold transition">Save Changes</button>
            </form>
            <div class="mt-8 flex flex-col items-center">
                <h2 class="text-lg text-blue-400 font-semibold mb-2">Profile Preview</h2>
                @if(old('photo_url', $user->photo_url))
                    <img src="{{ old('photo_url', $user->photo_url) }}" alt="Profile photo preview" class="w-24 h-24 rounded-full object-cover border-4 border-blue-500 shadow mb-2">
                @else
                    <div class="w-24 h-24 rounded-full bg-gray-700 flex items-center justify-center text-blue-400 text-3xl font-bold border-4 border-blue-500 shadow mb-2">
                        {{ strtoupper(substr(old('name', $user->name), 0, 1)) }}
                    </div>
                @endif
                <div class="text-white font-semibold">{{ old('name', $user->name) }}</div>
                @if(old('biography', $user->biography))
                    <p class="text-gray-200 text-sm mt-2 text-center">{{ old('biography', $user->biography) }}</p>
                @endif
            </div>
        </div>
    </main>
    @include('components.footer')
</body>
</html>