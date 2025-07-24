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
            return redirect()->back()->with('error', 'You cannot follow yourself');
        }

        if ($user->follows()->where('user_followed', $userToFollow->id)->exists()) {
            return redirect()->back()->with('error', 'You are already following this user');
        }

        $user->follows()->attach($userToFollow->id);

        return redirect()->back()->with('success', 'Successfully followed user');
    }

    public function unfollow(Request $request, $userId)
    {
        $user = $request->user();
        $userToUnfollow = User::findOrFail($userId);

        if ($user->id === $userToUnfollow->id) {
            return redirect()->back()->with('error', 'You cannot unfollow yourself');
        }

        if (!$user->follows()->where('user_followed', $userToUnfollow->id)->exists()) {
            return redirect()->back()->with('error', 'You are not following this user');
        }

        $user->follows()->detach($userToUnfollow->id);

        return redirect()->back()->with('success', 'Successfully unfollowed user');
    }
}
