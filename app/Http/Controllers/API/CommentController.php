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
}
