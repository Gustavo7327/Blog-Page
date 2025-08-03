<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Post | {{ $post->title }} | ByteTech</title>
    @vite('resources/css/app.css')
    <script src="{{ env('VITE_TINYMCE_API_KEY') }}" referrerpolicy="origin"></script>
</head>
<body class="bg-gray-900 min-h-screen flex flex-col">
    @include('components.navbar')
    <main class="flex-1 flex flex-col items-center justify-center">
        <div class="max-w-4xl w-full mx-auto p-8 bg-gray-800 rounded-lg shadow-lg mt-10 flex flex-col gap-4">
            <h2 class="text-2xl font-bold text-white mb-6 text-center">Edit Post</h2>
            <form method="POST" action="{{ route('posts.update', $post->id) }}" class="space-y-6">
                @csrf
                @method('PATCH')
                <div>
                    <label for="title" class="block text-white mb-2">Title</label>
                    <input type="text" id="title" name="title" value="{{ old('title', $post->title) }}" required class="w-full p-2 rounded bg-gray-700 text-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                    @error('title')
                        <span class="text-red-400 text-sm">{{ $message }}</span>
                    @enderror
                </div>
                <div>
                    <label for="description" class="block text-white mb-2">Description</label>
                    <input type="text" id="description" name="description" value="{{ old('description', $post->description) }}" required class="w-full p-2 rounded bg-gray-700 text-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                    @error('description')
                        <span class="text-red-400 text-sm">{{ $message }}</span>
                    @enderror
                </div>
                <div class="flex flex-col md:flex-row gap-8">
                    <div class="mb-6 flex-1">
                        <label for="estimated_reading_time" class="block text-white mb-2">Estimated Reading Time</label>
                        <input type="number" id="estimated_reading_time" name="estimated_reading_time" min="1" value="{{ old('estimated_reading_time', $post->estimated_reading_time) }}" required class="w-full h-12 p-3 rounded bg-gray-700 text-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                        @error('estimated_reading_time')
                            <span class="text-red-400 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-6 flex-1">
                        <label for="category" class="block text-white mb-2">Category</label>
                        <select id="category" name="category" required class="w-full h-12 p-3 rounded bg-gray-700 text-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="" disabled>Select a category</option>
                            @php
                                $categories = [
                                    "programming" => "Programming",
                                    "web_development" => "Web Development",
                                    "mobile_development" => "Mobile Development",
                                    "artificial_intelligence" => "Artificial Intelligence",
                                    "machine_learning" => "Machine Learning",
                                    "data_science" => "Data Science",
                                    "information_security" => "Information Security",
                                    "cloud_computing" => "Cloud Computing",
                                    "devops" => "DevOps",
                                    "hardware" => "Hardware",
                                    "software" => "Software",
                                    "networks" => "Networks",
                                    "iot" => "Internet of Things (IoT)",
                                    "blockchain" => "Blockchain",
                                    "virtual_reality" => "Virtual Reality",
                                    "augmented_reality" => "Augmented Reality",
                                    "games" => "Games",
                                    "robotics" => "Robotics",
                                    "databases" => "Databases",
                                    "front_end" => "Front-End",
                                    "back_end" => "Back-End",
                                    "full_stack" => "Full Stack",
                                    "ui_ux" => "UI/UX Design",
                                    "automation" => "Automation",
                                    "big_data" => "Big Data",
                                    "mobile" => "Mobile",
                                    "open_source" => "Open Source",
                                    "educational_technology" => "Educational Technology",
                                    "software_engineering" => "Software Engineering",
                                    "others" => "Others"
                                ];
                            @endphp
                            @foreach($categories as $key => $label)
                                <option value="{{ $key }}" @if(old('category', $post->category) == $key) selected @endif>{{ $label }}</option>
                            @endforeach
                        </select>
                        @error('category')
                            <span class="text-red-400 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div>
                    <label for="tags" class="block text-white mb-2">Tags <span class="text-sm text-gray-400">(optional)</span></label>
                    <div class="w-full p-2 rounded bg-gray-700 text-white focus-within:ring-2 focus-within:ring-blue-500">
                        <div id="tag-container" class="flex flex-wrap gap-2 mb-2">
                            @php
                                $tagsValue = old('tags', $post->tags);
                                $tags = is_string($tagsValue) ? json_decode($tagsValue, true) : $tagsValue;
                            @endphp

                            @if(is_array($tags))
                                @foreach($tags as $tag)
                                    <span class="bg-blue-600 text-white px-3 py-1 rounded-full flex items-center gap-2 text-sm">
                                        {{ $tag }}
                                        <button type="button" class="ml-1 text-white hover:text-red-300" onclick="removeTag('{{ $tag }}')">&times;</button>
                                    </span>
                                @endforeach
                            @endif
                        </div>
                        <input
                            type="text"
                            id="tag-input"
                            placeholder="Type a tag and press Enter"
                            class="w-full bg-transparent outline-none placeholder-gray-400"
                        />
                    </div>
                    @php
                        $tagsValue = old('tags', $post->tags);
                        $tagsJson = is_string($tagsValue) ? $tagsValue : json_encode($tagsValue);
                    @endphp
                    <input type="hidden" name="tags" id="tags-hidden" value="{{ $tagsJson }}">
                </div>
                <div>
                    <label for="content" class="block text-white mb-2">Content</label>
                    <textarea id="content" name="content" class="w-full min-h-[300px] rounded bg-gray-700 text-white">{{ old('content', $post->content) }}</textarea>
                    @error('content')
                        <span class="text-red-400 text-sm">{{ $message }}</span>
                    @enderror
                </div>
                <div class="flex flex-row flex-wrap items-center gap-4">
                     <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 font-bold">
                        Update Post
                    </button>           
                </div>     
            </form>
            <form action="{{ route('posts.destroy', $post->id) }}" method="post">
                @csrf
                @method('DELETE')
                <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700 font-bold">
                    Delete Post
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
                'checklist', 'mediaembed', 'casechange', 'formatpainter', 'pageembed', 'a11ychecker', 'tinymcespellchecker', 'permanentpen', 'powerpaste', 'advtable', 'advcode', 'editimage', 'advtemplate', 'mentions', 'tinycomments', 'tableofcontents', 'footnotes', 'mergetags', 'autocorrect', 'typography', 'inlinecss', 'markdown','importword', 'exportword', 'exportpdf'
            ],
            toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table mergetags | addcomment showcomments | spellcheckdialog a11ycheck typography | align lineheight | checklist numlist bullist indent outdent | emoticons charmap | removeformat',
            tinycomments_mode: 'embedded',
            tinycomments_author: 'Author name',
            mergetags_list: [
                { value: 'First.Name', title: 'First Name' },
                { value: 'Email', title: 'Email' },
            ],
            setup: function (editor) {
                editor.on('keyup change', function () {
                    document.getElementById('content-preview').innerHTML = editor.getContent();
                });
            }
        });

        let tags = [];
        const tagInput = document.getElementById('tag-input');
        const tagContainer = document.getElementById('tag-container');
        const hiddenInput = document.getElementById('tags-hidden');

        try {
            tags = JSON.parse(hiddenInput.value) || [];
        } catch (e) {
            tags = [];
        }
        renderTags();

        tagInput.addEventListener('keydown', function (e) {
            if (e.key === 'Enter' || e.key === ',') {
                e.preventDefault();
                const value = tagInput.value.trim();
                if (value && !tags.includes(value)) {
                    tags.push(value);
                    renderTags();
                    tagInput.value = '';
                }
            }
        });

        function renderTags() {
            tagContainer.innerHTML = '';
            tags.forEach((tag, index) => {
                const tagEl = document.createElement('span');
                tagEl.className = 'bg-blue-600 text-white px-3 py-1 rounded-full flex items-center gap-2 text-sm';
                tagEl.innerHTML = `${tag} <button type="button" class="ml-1 text-white hover:text-red-300" onclick="removeTag(${index})">&times;</button>`;
                tagContainer.appendChild(tagEl);
            });
            hiddenInput.value = JSON.stringify(tags);
        }

        function removeTag(index) {
            tags.splice(index, 1);
            renderTags();
        }
    </script>
</body>
</html>