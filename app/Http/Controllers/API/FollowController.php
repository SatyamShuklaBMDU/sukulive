<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class FollowController extends Controller
{
    public function follow(Request $request)
    {
        $login = Auth::user();
        $followable = Customer::findOrFail($login->id);
        $follower = Customer::findOrFail($request->follower_id);
        if ($followable->isFollowing($follower)) {
            return response()->json(['message' => 'Already followed.'], Response::HTTP_OK);
        }
        $followable->follow($follower);
        $count = $followable->followings()->count();
        return response()->json(['count' => $count], Response::HTTP_OK);
    }

    public function unfollow(Request $request)
    {
        $login = Auth::user();
        $unfollowable = Customer::findOrFail($login->id);
        $unfollower = Customer::findOrFail($request->follower_id);
        if ($unfollowable->isFollowing($unfollower)) {
            $unfollowable->unfollow($unfollower);
        }
        $count = $unfollowable->followings()->count();
        return response()->json(['count' => $count], Response::HTTP_OK);
    }

    public function counting()
    {
        $login = Auth::user();
        $person = Customer::findOrFail(id: $login->id);
        $follower = $person->followers()->count();
        $followings = $person->followings()->count();
        return response()->json(['followers'=>$follower,'followings'=>$followings],Response::HTTP_OK);
    }
}
