<header class="w-full flex items-center justify-center sticky top-0 bg-white dark:bg-gray-800">
    <div class="flex justify-between items-center p-4 h-20 w-full max-w-[850px] ">
        <div class="max-w-6xl mx-auto">
            <h1 class="text-2xl font-bold text-gray-600">ByteTech: Read and write articles!</h1>
        </div>
        <nav>
            <ul class="flex flex-row justify-between text-lg text-gray-900 dark:text-white pr-4 space-x-16">
                <li><a href="/">Home</a></li>
                <li><a href="/#articles">Articles</a></li>
                <li><a href="/#contact">Contact</a></li>
            </ul>
        </nav> 
        @auth
            <div>
                <a href="/posts" class="">Write a post</a>
                <a href="/profile"><img src="{{Auth::user()->photo_url}}" alt=""></a>
            </div>
        @endauth
    </div>
</header>