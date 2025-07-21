<?php

namespace App\Http\Controllers;

use App\Models\Post;
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
        return view('posts.show', compact('post'));
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
            'description' => 'nullable|string|max:255',
            'categorie' => 'required|string|max:255',
            'tags' => 'nullable|array',
        ]);

        $post = new Post([
            'owner_id' => $request->user()->id,
            'title' => $request->input('title'),
            'content' => $request->input('content'),
            'estimated_reading_time' => $request->input('estimated_reading_time'),
            'likes' => 0, 
            'description' => $request->input('description'),
            'categorie' => $request->input('categorie'),
            'tags' => $request->input('tags'),
        ]);

        $post->save();

        return response()->json(['message' => 'Post created successfully'], 201);
    }

    public function update(Request $request, $id)
    {
        $post = Post::findOrFail($id);

        if ($post->owner_id !== $request->user()->id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $validatedData = $request->validate([
            'title' => 'sometimes|string|max:255',
            'content' => 'sometimes|string',
            'estimated_reading_time' => 'sometimes|integer|min:1',
            'description' => 'sometimes|string|max:255',
            'categorie' => 'sometimes|string|max:255',
            'tags' => 'nullable|array',
        ]);

        $post->update($validatedData);

        return response()->json(['message' => 'Post updated successfully'], 200);
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
