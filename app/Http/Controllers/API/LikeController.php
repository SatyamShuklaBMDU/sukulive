<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Media;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{
    public function likeOrUnlikePost(Request $request)
    {
        $customer = Customer::findOrFail(Auth::id());
        $post = Media::findOrFail($request->post_id);
        if ($customer->hasLiked($post)) {
            $customer->unlike($post);
            $message = 'Post unliked successfully';
        } else {
            $customer->like($post);
            $message = 'Post liked successfully';
        }
        $likeCount = $post->likers()->count();
        return response()->json([
            'message' => $message,
            'total_likes' => $likeCount,
        ]);
    }
}
