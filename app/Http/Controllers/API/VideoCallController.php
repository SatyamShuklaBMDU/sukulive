<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\LiveVideCall;
use App\Models\LiveVideoCallJoiner;
use App\Models\Story;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class VideoCallController extends Controller
{
    public function startLive(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "live_id" => "required|string",
            "user_id" => "required|exists:customers,id",
            "user_name" => "required",
        ]);

        if ($validator->fails()) {
            return response()->json(["status_code" => Response::HTTP_BAD_REQUEST, "status" => false, "message" => $validator->errors()], Response::HTTP_BAD_REQUEST);
        }
        $userId = $request->input('user_id');

        LiveVideCall::where('user_id', $userId)
            ->where('live_status', 'running')
            ->update(['live_status' => 'ended', 'updated_at' => Carbon::now()]);

        $liveVideo = LiveVideCall::create([
            'live_id' => $request->input('live_id'),
            'user_id' => $userId,
            'user_name' => $request->input('user_name'),
            'live_status' => 'running',
            'live_date' => Carbon::now(),
        ]);

        return response()->json([
            'status_code' => Response::HTTP_OK,
            'status' => true,
            'message' => 'Live session started successfully.',
            'data' => $liveVideo
        ], Response::HTTP_OK);
    }

    public function stopLive(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "live_id" => "required|string",
            "user_id" => "required|exists:customers,id",
            "date" => [
                "required",
                "regex:/^\d{4}-\d{2}-\d{2}$/"
            ],
        ], [
            "date.regex" => "The date must be in the format yyyy-mm-dd."
        ]);
        if ($validator->fails()) {
            return response()->json([
                "status_code" => Response::HTTP_BAD_REQUEST,
                "status" => false,
                "message" => $validator->errors(),
            ], Response::HTTP_BAD_REQUEST);
        }
        $userId = $request->input('user_id');

        $liveVideo = LiveVideCall::where('user_id', $userId)
            ->where('live_id', $request->live_id)
            ->where('live_status', 'running')
            ->whereDate('live_date', $request->date)
            ->update(['live_status' => 'ended', 'updated_at' => Carbon::now()]);

        return response()->json([
            'status_code' => Response::HTTP_OK,
            'status' => true,
            'message' => 'Live session ended successfully.',
            'data' => $liveVideo
        ], Response::HTTP_OK);
    }
    public function joinLive(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "live_id" => "required|string",
            "user_id" => "required|exists:customers,id",
            "user_name" => "required",
        ]);
        if ($validator->fails()) {
            return response()->json([
                "status_code" => Response::HTTP_BAD_REQUEST,
                "status" => false,
                "message" => $validator->errors(),
            ], Response::HTTP_BAD_REQUEST);
        }
        $liveId = $request->input("live_id");
        $userId = $request->input("user_id");
        $userName = $request->input("user_name");
        LiveVideoCallJoiner::where('user_id',  $userId)
            ->where('join_status', 'joined')
            ->update(['join_status' => 'quit', 'updated_at' => Carbon::now()]);
        $joinSession = LiveVideoCallJoiner::create([
            'live_id' => $liveId,
            'user_id' => $userId,
            'user_name' => $userName,
            'join_status' => 'joined',
            'join_date' => Carbon::now(),
        ]);
        $liveuser = LiveVideCall::where('live_id', $liveId)->where('live_status','running')->whereDate('created_at',Carbon::now())->first();
        return response()->json([
            "status_code" => Response::HTTP_OK,
            "status" => true,
            "message" => "User successfully joined the live session.",
            "user_id" => $liveuser->user_id,
            "data" => $joinSession,
        ], Response::HTTP_OK);
    }

    public function getLiveVideos(Request $request)
    {
        $today = Carbon::today();
        $data = LiveVideCall::whereDate("live_date",  $today)->where('live_status', 'running')->with('customer')->latest()->get();
        $data->each(function ($video) {
            $video->customer->profile_pic = $video->customer->profile_pic ? $video->customer->profile_pic : 'https://cdn.pixabay.com/photo/2015/10/05/22/37/blank-profile-picture-973460_1280.png';
        });
        return response()->json([
            "status_code" => Response::HTTP_OK,
            "status" => true,
            "message" => "All Live Sessions",
            "data" => $data,
        ], Response::HTTP_OK);
    }

    public function uploadStory(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'media' => 'required|file',
            'caption' => 'nullable|string',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status_code' => Response::HTTP_BAD_REQUEST,
                'status' => false,
                'message' => $validator->errors(),
            ], Response::HTTP_BAD_REQUEST);
        }
        $user = Auth::user();
        $story = new Story();
        $story->customers_id = $user->id;
        if ($request->hasFile('media')) {
            $media = $request->file('media');
            $mediaName = time() . '_media.' . $media->getClientOriginalExtension();
            $media->move(public_path($user->customer_id . '/story'), $mediaName);
            $story->media_path = asset($user->customer_id . '/story/' . $mediaName);
        }
        $story->caption = $request->caption;
        $story->expires_at = now()->addDay();
        $story->save();
        return response()->json(['message' => 'Story uploaded successfully', 'story' => $story], Response::HTTP_CREATED);
    }

    public function getStories(Request $request)
    {
        $stories = Story::where('expires_at', '>', now())
            ->orderBy('created_at', 'desc')
            ->with('customer:id,name,profile_pic')
            ->get();
        $path = "https://sukulive.com";
        $groupedStories = $stories->groupBy('customers_id')->map(function ($storiesGroup) use ($path) {
            $customer = $storiesGroup->first()->customer;
            $storiesList = $storiesGroup->map(function ($story) use ($path) {
                $extension = pathinfo($story->media_path, PATHINFO_EXTENSION);
                $type = match (strtolower($extension)) {
                    'jpg', 'jpeg', 'png' => 'image',
                    'mp4', 'mov', 'avi' => 'video',
                    default => 'unknown',
                };

                $story->type = $type;
                $story->media_path = $path . $story->media_path;
                return $story->only([
                    'id',
                    'customers_id',
                    'media_path',
                    'caption',
                    'expires_at',
                    'created_at',
                    'updated_at',
                    'type'
                ]);
            });
            return [
                'id' => $customer->id,
                'name' => $customer->name,
                'profile_pic' => $customer->profile_pic,
                'stories' => $storiesList
            ];
        })->values();
        return response()->json(['customers' => $groupedStories], Response::HTTP_OK);
    }
}
