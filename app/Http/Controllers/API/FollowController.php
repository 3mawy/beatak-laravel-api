<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class FollowController extends Controller
{
    public function followUserById(Request $request)
    {
        $currentUser = JWTAuth::user();
        $user = $request->user_id;
        try {
            $currentUser->followings()->attach($user);

        } catch (QueryException $exception) {
            return response()->json(['error' => 'your are already following this user'], 422);
        }
        return response($currentUser->followings->count());
    }

    public function getFollowers($user)
    {
        $followers = User::find($user)->followers;
        return response($followers, 200);
    }

    public function getCurrentUserFollowers()
    {
        return $this->getFollowers(JWTAuth::user()->id);
    }

    public function getFollowings($user)
    {
        $followings = User::find($user)->followings;
        return response($followings, 200);
    }

    public function getCurrentUserFollowings()
    {
        return $this->getFollowings(JWTAuth::user()->id);
    }

    public function unfollowUserById($following)
    {
        $currentUser = JWTAuth::user();
        $currentUser->followings()->detach($following);
        return response($currentUser->followings, 200);
    }
}
