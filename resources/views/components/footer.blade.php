<footer class="bg-gray-800 text-gray-300 py-8 mt-10 border-t border-gray-700" id="about">
    <div class="max-w-7xl mx-auto px-4 flex flex-col md:flex-row justify-between items-center">
        <div class="mb-4 md:mb-0">
            <h2 class="text-xl font-bold text-white">ByteTech</h2>
            <p class="text-sm mt-2 max-w-xs">
                A project designed to share informative articles and posts about technology, programming, and innovation.
                Participate, read, write, and share knowledge!
            </p>
        </div>
        <div class="flex flex-row gap-6 items-center">
            <a href="/" class="hover:text-blue-400 transition-colors">Home</a>
            <a href="/#articles" class="hover:text-blue-400 transition-colors">Articles</a>
            <a href="/#about" class="hover:text-blue-400 transition-colors">About</a>
            <a href="https://github.com/Gustavo7327/BlogPage" target="_blank" class="hover:text-blue-400 transition-colors flex items-center">
                <svg class="w-5 h-5 mr-1" fill="currentColor" viewBox="0 0 24 24"><path d="M12 .5C5.73.5.5 5.73.5 12c0 5.08 3.29 9.39 7.86 10.91.58.11.79-.25.79-.56 0-.28-.01-1.02-.02-2-3.2.7-3.88-1.54-3.88-1.54-.53-1.34-1.3-1.7-1.3-1.7-1.06-.72.08-.7.08-.7 1.17.08 1.78 1.2 1.78 1.2 1.04 1.78 2.73 1.27 3.4.97.11-.75.41-1.27.74-1.56-2.56-.29-5.26-1.28-5.26-5.7 0-1.26.45-2.29 1.19-3.1-.12-.29-.52-1.46.11-3.05 0 0 .97-.31 3.18 1.18a11.1 11.1 0 0 1 2.9-.39c.98 0 1.97.13 2.9.39 2.2-1.49 3.17-1.18 3.17-1.18.63 1.59.23 2.76.12 3.05.74.81 1.19 1.84 1.19 3.1 0 4.43-2.7 5.41-5.27 5.7.42.36.79 1.09.79 2.2 0 1.59-.01 2.87-.01 3.26 0 .31.21.67.8.56C20.71 21.39 24 17.08 24 12c0-6.27-5.23-11.5-12-11.5z"/></svg>
                GitHub
            </a>
        </div>
    </div>
    <div class="text-center text-xs text-gray-500 mt-6">
        &copy; {{ date('Y') }} ByteTech. All rights reserved.
    </div>
</footer>