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
            <form method="POST" action="{{ route('posts.store') }}" class="space-y-6">
                @csrf
                <div>
                    <label for="title" class="block text-white mb-2">Title</label>
                    <input type="text" id="title" name="title" placeholder="Enter post title" required class="w-full p-2 rounded bg-gray-700 text-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                    @error('title')
                        <span class="text-red-400 text-sm">{{ $message }}</span>
                    @enderror
                </div>
                <div>
                    <label for="description" class="block text-white mb-2">Description</label>
                    <input type="text" id="description" placeholder="Enter post description" name="description" required class="w-full p-2 rounded bg-gray-700 text-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                    @error('description')
                        <span class="text-red-400 text-sm">{{ $message }}</span>
                    @enderror
                </div>
                <div class="flex flex-row gap-12">
                    <div class="mb-6">
                        <label for="estimated_reading_time" class="block text-white mb-2">Estimated Reading Time</label>
                        <input type="number" id="estimated_reading_time" name="estimated_reading_time" required min="1" class="w-60 h-10 p-2 rounded bg-gray-700 text-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                        @error('estimated_reading_time')
                            <span class="text-red-400 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-6">
                        <label for="category" class="block text-white mb-2">Category</label>
                        <select id="category" name="category" required class="w-60 h-10 p-2 rounded bg-gray-700 text-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="" disabled selected>Select a category</option>
                            <option value="programming">Programming</option>
                            <option value="web_development">Web Development</option>
                            <option value="mobile_development">Mobile Development</option>
                            <option value="artificial_intelligence">Artificial Intelligence</option>
                            <option value="machine_learning">Machine Learning</option>
                            <option value="data_science">Data Science</option>
                            <option value="information_security">Information Security</option>
                            <option value="cloud_computing">Cloud Computing</option>
                            <option value="devops">DevOps</option>
                            <option value="hardware">Hardware</option>
                            <option value="software">Software</option>
                            <option value="networks">Networks</option>
                            <option value="iot">Internet of Things (IoT)</option>
                            <option value="blockchain">Blockchain</option>
                            <option value="virtual_reality">Virtual Reality</option>
                            <option value="augmented_reality">Augmented Reality</option>
                            <option value="games">Games</option>
                            <option value="robotics">Robotics</option>
                            <option value="databases">Databases</option>
                            <option value="front_end">Front-End</option>
                            <option value="back_end">Back-End</option>
                            <option value="full_stack">Full Stack</option>
                            <option value="ui_ux">UI/UX Design</option>
                            <option value="automation">Automation</option>
                            <option value="big_data">Big Data</option>
                            <option value="mobile">Mobile</option>
                            <option value="open_source">Open Source</option>
                            <option value="educational_technology">Educational Technology</option>
                            <option value="software_engineering">Software Engineering</option>
                            <option value="others">Others</option>
                        </select>
                        @error('category')
                            <span class="text-red-400 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div>
                    <label for="tags" class="block text-white mb-2">Tags <span class="text-sm text-gray-400">(optional)</span></label>
                    <div class="w-full p-2 rounded bg-gray-700 text-white focus-within:ring-2 focus-within:ring-blue-500">
                        <div id="tag-container" class="flex flex-wrap gap-2 mb-2"></div>
                        <input
                            type="text"
                            id="tag-input"
                            placeholder="Type a tag and press Enter"
                            class="w-full bg-transparent outline-none placeholder-gray-400"
                        />
                    </div>
                    <input type="hidden" name="tags" id="tags-hidden">
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

    <script>
        const tagInput = document.getElementById('tag-input');
        const tagContainer = document.getElementById('tag-container');
        const hiddenInput = document.getElementById('tags-hidden');
        let tags = [];

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