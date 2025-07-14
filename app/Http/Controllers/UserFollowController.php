<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserFollowController extends Controller
{
    
    public function follow(Request $request, $userId)
    {
        $user = $request->user();
        $userToFollow = User::findOrFail($userId);

        if ($user->id === $userToFollow->id) {
            return response()->json(['message' => 'You cannot follow yourself'], 400);
        }

        if ($user->following()->where('followed_user_id', $userToFollow->id)->exists()) {
            return response()->json(['message' => 'You are already following this user'], 400);
        }

        $user->following()->attach($userToFollow->id);

        return response()->json(['message' => 'Successfully followed user'], 200);
    }

    public function unfollow(Request $request, $userId)
    {
        $user = $request->user();
        $userToUnfollow = User::findOrFail($userId);

        if ($user->id === $userToUnfollow->id) {
            return response()->json(['message' => 'You cannot unfollow yourself'], 400);
        }

        if (!$user->following()->where('followed_user_id', $userToUnfollow->id)->exists()) {
            return response()->json(['message' => 'You are not following this user'], 400);
        }

        $user->following()->detach($userToUnfollow->id);

        return response()->json(['message' => 'Successfully unfollowed user'], 200);
    }
}
