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
    </main>
    @include('components.footer')
    @if(auth()->check())
    <div>Usuário autenticado: {{ auth()->user()->email }}</div>
@else
    <div>Não autenticado</div>
@endif
</body>
</html>