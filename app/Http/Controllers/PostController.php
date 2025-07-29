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


   public function home(Request $request)
   {
        $search = $request->input('search');

        $posts = Post::with('user')
            ->when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('title', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%")
                    ->orWhereJsonContains('tags', $search);
                });
            })
            ->latest()
            ->paginate(10);

        $mostLiked = Post::withCount('likes')->orderByDesc('likes_count')->limit(3)->get();

        return view('home', compact('posts', 'search', 'mostLiked'));
    }


    public function show($id)
    {
        $post = Post::findOrFail($id);
        $owner = User::find($post->owner_id);
        $comments = $post->comments()->with('user')->get();
        return view('posts.show', compact('post', 'owner', 'comments'));
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
            return redirect()->route('posts.show', $post->id)
                             ->with('error', 'Unauthorized action.');
        }

        $post->delete();

        return redirect("/")->with('success', 'Post deleted successfully');
    }


    public function like(Request $request, $id)
    {
        $post = Post::findOrFail($id);

        $post->likes()->attach($request->user()->id);

        return response()->json(['message' => 'Post liked successfully'], 200);
    }


    public function unlike(Request $request, $id)
    {
        $post = Post::findOrFail($id);

        $post->likes()->detach($request->user()->id);

        return response()->json(['message' => 'Post unliked successfully'], 200);
    }
}
