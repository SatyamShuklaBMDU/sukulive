<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class PostController extends Controller
{
    public function uploadMedia(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'media' => 'required|file|mimes:jpg,jpeg,png,gif,mp4,mov,avi|max:20480',
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => false, 'message' => 'validation fails.', 'error' => $validator->messages()], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        $login = Auth::user();
        $customer = Customer::findOrFail($login->id);
        $customer->addMedia($request->file('media'))->toMediaCollection('posts');
        return response()->json(['message' => 'Media uploaded successfully'], Response::HTTP_OK);
    }

    public function getMedia()
    {
        $login = Auth::user();
        $customer = Customer::findOrFail($login->id);
        $media = $customer->getMedia('posts');
        return response()->json($media);
    }
}
