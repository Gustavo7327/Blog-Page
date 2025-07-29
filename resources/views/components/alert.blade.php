@if(session('success') || session('error') || $errors->any())
    <div id="alert-progress" class="fixed top-4 left-1/2 transform -translate-x-1/2 bg-opacity-95 px-6 py-4 rounded shadow-lg z-[9999] w-full max-w-md text-white 
        @if(session('success')) bg-green-600 @elseif(session('error') || $errors->any()) bg-red-600 @endif
        flex flex-col gap-2">
        
        <div class="flex justify-between items-start gap-4">
            <div class="flex-1 text-sm">
                @if(session('success'))
                    {{ session('success') }}
                @elseif(session('error'))
                    {{ session('error') }}
                @elseif($errors->any())
                    <ul class="list-disc pl-4">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                @endif
            </div>
            <button onclick="document.getElementById('alert-progress').remove()" class="text-white hover:text-gray-300 font-bold ml-2 text-lg leading-none">&times;</button>
        </div>

        <div class="relative w-full h-1 bg-white bg-opacity-30 rounded overflow-hidden mt-2">
            <div id="progress-bar" class="absolute top-0 left-0 h-full bg-white w-full"></div>
        </div>
    </div>

    <script>
        const alertEl = document.getElementById('alert-progress');
        const progressBar = document.getElementById('progress-bar');
        const duration = 5000; // 5 seconds

        let start = null;
        function animateProgress(timestamp) {
            if (!start) start = timestamp;
            const elapsed = timestamp - start;
            const percent = Math.max(0, 100 - (elapsed / duration) * 100);
            progressBar.style.width = percent + '%';

            if (elapsed < duration) {
                requestAnimationFrame(animateProgress);
            } else {
                alertEl.remove();
            }
        }
        requestAnimationFrame(animateProgress);
    </script>
@endif

<script>
    setTimeout(() => {
        document.querySelectorAll('[class*="fixed"]').forEach(el => {
            el.style.transition = 'opacity 0.5s ease';
            el.style.opacity = '0';
            setTimeout(() => el.remove(), 500);
        });
    }, 4000);
</script>
