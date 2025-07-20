<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ByteTech - Register</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-900">
    <main class="h-screen">
        <section>
            <h1 class="text-3xl text-white font-bold text-center mt-10">Register</h1>
            <form action="/register" method="POST" class="max-w-md mx-auto mt-8 bg-gray-800 p-6 rounded-lg shadow-lg">
                @csrf
                <div class="mb-4">
                    <label for="name" class="block text-white mb-2">Name</label>
                    <input type="text" id="name" name="name" placeholder="Enter your name" required class="w-full p-2 rounded bg-gray-700 text-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                    @error('name')
                        <span class="text-red-400 text-sm">{{ $message }}</span>
                    @enderror
                </div>
                <div class="mb-4">
                    <label for="email" class="block text-white mb-2">Email</label>
                    <input type="email" id="email" name="email" placeholder="Enter your email" required class="w-full p-2 rounded bg-gray-700 text-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                    @error('email')
                        <span class="text-red-400 text-sm">{{ $message }}</span>
                    @enderror
                </div>
                <div class="mb-4">
                    <label for="password" class="block text-white mb-2">Password</label>
                    <input type="password" id="password" placeholder="Enter your password" name="password" required class="w-full p-2 rounded bg-gray-700 text-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                    @error('password')
                        <span class="text-red-400 text-sm">{{ $message }}</span>
                    @enderror
                </div>
                <button type="submit" class="w-full bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Register</button>
            </form>
        </section>
    </main>
</body>
</html>