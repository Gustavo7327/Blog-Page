<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ByteTech - Create Post</title>
    @vite('resources/css/app.css')
    <script src="https://cdn.tiny.cloud/1/cbzo1eo34tua55xfyuqp0kof5hrxy6omwmr5rro0h08o42v3/tinymce/7/tinymce.min.js" referrerpolicy="origin"></script>
</head>
<body class="bg-gray-900 min-h-screen flex flex-col">
    @include('components.navbar')
    <main class="flex-1 flex flex-col items-center justify-center">
        <div class="max-w-4xl w-full mx-auto p-8 bg-gray-800 rounded-lg shadow-lg mt-10">
            <h2 class="text-2xl font-bold text-white mb-6">Create new post</h2>
            <form method="POST" action="{{ route('posts.store') }}" enctype="multipart/form-data" class="space-y-6">
                @csrf
                <div>
                    <label for="title" class="block text-white mb-2">Title</label>
                    <input type="text" id="title" name="title" required class="w-full p-2 rounded bg-gray-700 text-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                    @error('title')
                        <span class="text-red-400 text-sm">{{ $message }}</span>
                    @enderror
                </div>
                <div>
                    <label for="content" class="block text-white mb-2">Content</label>
                    <textarea id="content" name="content" class="w-full min-h-[300px] rounded bg-gray-700 text-white"></textarea>
                    @error('content')
                        <span class="text-red-400 text-sm">{{ $message }}</span>
                    @enderror
                </div>
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 font-bold">
                    Publish
                </button>
            </form>
            <div class="mt-8">
                <h3 class="text-lg font-semibold text-white mb-2">Content Preview:</h3>
                <div id="content-preview" class="prose prose-invert max-w-none p-4 bg-gray-900 rounded shadow min-h-[100px]"></div>
            </div>
        </div>
    </main>
    @include('components.footer')
    <script>
        tinymce.init({
            selector: '#content',
            skin: 'oxide-dark',
            content_css: 'dark',
            plugins: [
                'anchor', 'autolink', 'charmap', 'codesample', 'emoticons', 'image', 'link', 'lists', 'media', 'searchreplace', 'table', 'visualblocks', 'wordcount',
                'checklist', 'mediaembed', 'casechange', 'formatpainter', 'pageembed', 'a11ychecker', 'tinymcespellchecker', 'permanentpen', 'powerpaste', 'advtable', 'advcode', 'editimage', 'advtemplate', 'ai', 'mentions', 'tinycomments', 'tableofcontents', 'footnotes', 'mergetags', 'autocorrect', 'typography', 'inlinecss', 'markdown','importword', 'exportword', 'exportpdf'
            ],
            toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table mergetags | addcomment showcomments | spellcheckdialog a11ycheck typography | align lineheight | checklist numlist bullist indent outdent | emoticons charmap | removeformat',
            tinycomments_mode: 'embedded',
            tinycomments_author: 'Author name',
            mergetags_list: [
                { value: 'First.Name', title: 'First Name' },
                { value: 'Email', title: 'Email' },
            ],
            ai_request: (request, respondWith) => respondWith.string(() => Promise.reject('See docs to implement AI Assistant')),
            setup: function (editor) {
                editor.on('keyup change', function () {
                    document.getElementById('content-preview').innerHTML = editor.getContent();
                });
            }
        });
    </script>
</body>
</html>