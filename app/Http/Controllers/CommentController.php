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

        return redirect()->back()
                         ->with('success', 'Comment added successfully');
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

        return redirect()->back()
                         ->with('success', 'Comment updated successfully');
    }

    public function destroy(Request $request, $id)
    {
        $comment = Comment::findOrFail($id);

        if ($comment->user_id !== $request->user()->id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $comment->delete();

        return redirect()->back()
                         ->with('success', 'Comment deleted successfully');
    }
}
