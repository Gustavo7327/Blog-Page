<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    
    public function store(Request $request, $post_id)
    {
        $validatedData = $request->validate([
            'content' => 'required|string|max:255',
        ]);

        $comment = new Comment([
            'post_id' => $post_id,
            'user_id' => $request->user()->id,
            'content' => $validatedData['content'],
        ]);

        $comment->save();

        return response()->json([
            'comment' => [
                'content' => $comment->content,
            ],
            'user' => [
                'name' => request()->user()->name,
                'photo_url' => request()->user()->photo_url,
            ]
        ], 201);
    }

    
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'content' => 'required|string|max:255',
        ]);

        $comment = Comment::findOrFail($id);

        if ($comment->user_id !== $request->user()->id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $validatedData['updated_at'] = now();

        $comment->update($validatedData);

        return response()->json(['message' => 'Comment updated successfully',
            'comment' => $comment
        ], 200);
    }


    public function destroy(Request $request, $id)
    {
        $comment = Comment::findOrFail($id);

        if ($comment->user_id !== $request->user()->id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $comment->delete();

        return response()->json(['message' => 'Comment deleted successfully',
            'deleted' => true,
        ], 200);
    }


    public function like(Request $request, $id)
    {
        $comment = Comment::findOrFail($id);

        $comment->likes()->attach($request->user()->id);

        return response()->json(['message' => 'Comment liked successfully'], 200);
    }


    public function unlike(Request $request, $id)
    {
        $comment = Comment::findOrFail($id);

        $comment->likes()->detach($request->user()->id);

        return response()->json(['message' => 'Comment unliked successfully'], 200);
    }
}
