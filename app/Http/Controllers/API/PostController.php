<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Media;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class PostController extends Controller
{
    public function uploadMedia(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'media' => 'required|file',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation fails.',
                'error' => $validator->messages()
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        $login = Auth::user();
        $customer = Customer::findOrFail($login->id);
        $folderPath = 'public/' . $login->customer_id . '/media';
        $mediaItem = $customer->addMedia($request->file('media'))
            ->usingFileName($request->file('media')->getClientOriginalName())
            ->toMediaCollection('posts', 'public');
        $mediaUrl = $mediaItem->getUrl();
        return response()->json([
            'message' => 'Media uploaded successfully',
            'media_url' => $mediaUrl
        ], Response::HTTP_OK);
    }

    public function getMedia()
    {
        $login = Auth::user();
        $customer = Customer::findOrFail($login->id);
        $media = $customer->getMedia('posts')->map(function ($item) {
            return $item->toArray();
        })->toArray();
        return response()->json(array_values($media));
    }

    public function randomPost(Request $request)
    {
        $mediaItems = Media::inRandomOrder()->get();
        $mainData = [];
        $url = "https://sukulive.com/";
        $status = null;
        $customer = Customer::findOrFail(Auth::id());
        foreach ($mediaItems as $media) {
            if($customer->hasLiked($media)) {
                $status = true;
            }else{
                $status = false;
            }
            $user = $media->model_type::findOrFail($media->model_id);
            $path = "storage/{$media->id}/{$media->file_name}";
            $mediaUrl = asset($path);
            $mainData[] = [
                "media_id" => $media->id,
                "user_id" => $user->id,
                "user_name" => $user->name,
                "user_profile" => $user->profile_url ?? 'https://cdn.pixabay.com/photo/2015/10/05/22/37/blank-profile-picture-973460_1280.png',
                'file_name' => $media->file_name,
                'uuid' => $media->uuid,
                'original_url' => $url . $mediaUrl,
                "like_count" => $media->likes()->count(),
                "comment_count" => $media->comments()->count(),
                "like_status" => $status
            ];
        }

        return response()->json([
            'media' => $mainData
        ]);
    }
}
