<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Media;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class CommentController extends Controller
{
    public function addComment(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'comment' => 'required|string|max:255',
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => false, 'message' => 'validation fails.', 'error' => $validator->messages()], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        $customer = Customer::findOrFail(Auth::id());
        $post = Media::findOrFail($request->post_id);
        $comment = $post->commentAsUser($customer, $request->comment);
        return response()->json(['message' => 'Comment added successfully.', 'comment' => $comment], Response::HTTP_OK);
    }

    public function getComments(Request $request)
    {
        $posts = Media::findOrFail($request->post_id);
        $comments = $posts->comments;
        $data = [];
        $comments->each(function ($item) {
            $customer = Customer::findOrFail($item->user_id);
            $data[] = [
                'user_id' => $customer->id,
                'user_name' => $customer->name,
                'comment_id' => $item->commentable_id,
                'comment' => $item->comment,
            ];
        });
        return response()->json(['comments' => $data], Response::HTTP_OK);
    }

    public function deleteComment(Request $request)
    {
        $login = Auth::user();
        $customer = Customer::findOrFail($login->id);
        $comment = $customer->comments()->findOrFail($request->comment_id);
        $comment->delete();
        return response()->json(['message', 'Comment delete successfully.'], Response::HTTP_OK);
    }
}
