<header class="w-full flex items-center justify-center sticky top-0 text-white bg-gray-800 z-50">
    <div class="flex justify-between items-center p-4 h-20 w-full max-w-7xl">
        <div>
            <h1 class="text-3xl font-bold">ByteTech</h1>
        </div>

        <button id="menu-mobile" class="md:hidden flex items-center justify-center w-10 h-10 text-white hover:bg-gray-700 rounded-lg transition-colors">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
            </svg>
        </button>

        <nav class="hidden md:flex">
            <ul class="flex flex-row justify-between text-lg pr-4 space-x-16">
                <li><a href="/">Home</a></li>
                <li><a href="/#articles">Articles</a></li>
                <li><a href="/#about">About</a></li>
            </ul>
        </nav>

        @if (auth()->check())
            <div class="hidden md:flex flex-row space-x-4 items-center">
                <a href="/posts/create" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded w-48 text-center">Write a post</a>
                @if(auth()->user()->photo_url)
                    <a href="/profile"><img src="{{ Auth::user()->photo_url }}" alt="" class="rounded-full aspect-square object-cover w-12 h-12"></a>
                @else
                    <a href="/profile" class="w-12 h-12 rounded-full bg-gray-700 flex items-center justify-center text-blue-400 font-bold border-2 border-blue-500">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </a>
                @endif
            </div>
        @else
            <div class="hidden md:flex flex-row space-x-4">
                <a href="/login" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded w-24 text-center">Login</a>
                <a href="/register" class="bg-transparent hover:bg-blue-700 text-white font-semibold hover:text-white py-2 px-4 border border-blue-500 hover:border-transparent rounded w-24 text-center">Register</a>
            </div>
        @endif

        <nav id="menu-mobile-links" class="fixed top-20 right-0 w-44 bg-gray-800 p-4 transform translate-x-full transition-transform duration-300 h-screen overflow-y-auto md:hidden shadow-lg z-50">
            <ul class="flex flex-col gap-4">
                <li class="link"><a href="/">Home</a></li>
                <li class="link"><a href="/#articles">Articles</a></li>
                <li class="link"><a href="/#contact">Contact</a></li>
                <hr class="border-gray-600 my-2">
                @if (auth()->check())
                    <li><a href="/posts/create" class="block w-full bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded text-center">Write a post</a></li>
                    <li class="flex justify-center">
                        @if(auth()->user()->photo_url)
                            <a href="/profile"><img src="{{ Auth::user()->photo_url }}" alt="" class="rounded-full aspect-square object-cover w-12 h-12"></a>
                        @else
                            <a href="/profile" class="w-12 h-12 rounded-full bg-gray-700 flex items-center justify-center text-blue-400 font-bold border-2 border-blue-500">
                                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                            </a>
                        @endif
                    </li>
                @else
                    <li><a href="/login" class="block w-full bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded text-center">Login</a></li>
                    <li><a href="/register" class="block w-full bg-transparent hover:bg-blue-700 text-white font-semibold hover:text-white py-2 px-4 border border-blue-500 hover:border-transparent rounded text-center">Register</a></li>
                @endif
            </ul>
        </nav>
    </div>
</header>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const btnMenu = document.getElementById('menu-mobile');
    const menuMobile = document.getElementById('menu-mobile-links');
    const linksMobile = document.querySelectorAll('.link');

    const toggleMenu = () => {
        const isOpen = !menuMobile.classList.contains('translate-x-full');
        if (isOpen) {
            menuMobile.classList.add('translate-x-full');
            menuMobile.classList.remove('translate-x-0');
        } else {
            menuMobile.classList.remove('translate-x-full');
            menuMobile.classList.add('translate-x-0');
        }
    };

    btnMenu.addEventListener('click', (e) => {
        e.stopPropagation();
        toggleMenu();
    });

    linksMobile.forEach(link => {
        link.addEventListener('click', () => {
            menuMobile.classList.add('translate-x-full');
            menuMobile.classList.remove('translate-x-0');
        });
    });

    document.addEventListener('click', (e) => {
        if (!menuMobile.contains(e.target) && !btnMenu.contains(e.target)) {
            menuMobile.classList.add('translate-x-full');
            menuMobile.classList.remove('translate-x-0');
        }
    });
});
</script>
