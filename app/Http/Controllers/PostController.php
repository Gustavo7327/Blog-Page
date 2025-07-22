<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;

class PostController extends Controller
{
    
    public function create()
    {
        return view('posts.create');
    }

    public function show($id)
    {
        $post = Post::findOrFail($id);
        $owner = User::find($post->owner_id);
        return view('posts.show', compact('post', 'owner'));
    }

    public function edit(Request $request, $id)
    {
        $post = Post::findOrFail($id);
        if ($post->owner_id !== $request->user()->id) {
            abort(403, 'Unauthorized action.');
        }
        return view('posts.edit', compact('post'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'estimated_reading_time' => 'required|integer|min:1',
            'description' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'tags' => 'nullable|string|max:1000',
        ]);

        $post = new Post([
            'owner_id' => $request->user()->id,
            'title' => $request->input('title'),
            'content' => $request->input('content'),
            'estimated_reading_time' => $request->input('estimated_reading_time'),
            'likes' => 0, 
            'description' => $request->input('description'),
            'category' => $request->input('category'),
            'tags' => $request->input('tags'),
        ]);

        $post->save();

        return redirect()->route('posts.show', $post->id)
                         ->with('success', 'Post created successfully');
    }

    public function update(Request $request, $id)
    {
        $post = Post::findOrFail($id);

        if ($post->owner_id !== $request->user()->id) {
            return redirect()->route('posts.show', $post->id)
                             ->with('error', 'Unauthorized action.');
        }

        $validatedData = $request->validate([
            'title' => 'sometimes|string|max:255',
            'content' => 'sometimes|string',
            'estimated_reading_time' => 'sometimes|integer|min:1',
            'description' => 'sometimes|string|max:255',
            'category' => 'sometimes|string|max:255',
            'tags' => 'nullable',
        ]);

        if (isset($validatedData['tags']) && is_string($validatedData['tags'])) {
            $decoded = json_decode($validatedData['tags'], true);
            $validatedData['tags'] = is_array($decoded) ? $decoded : [];
        }

        $post->update($validatedData);

        return redirect()->route('posts.show', $post->id)
                         ->with('success', 'Post updated successfully');
    }

    public function destroy(Request $request, $id)
    {
        $post = Post::findOrFail($id);

        if ($post->owner_id !== $request->user()->id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $post->delete();

        return response()->json(['message' => 'Post deleted successfully'], 200);
    }
}
