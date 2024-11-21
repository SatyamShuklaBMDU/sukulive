<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\LiveVideCall;
use App\Models\LiveVideoCallJoiner;
use Carbon\Carbon;
use Illuminate\Http\Request;
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
        LiveVideoCallJoiner::where('user_id', $userId)
            ->where('join_status', 'joined')
            ->update(['join_status' => 'quit', 'updated_at' => Carbon::now()]);
        $joinSession = LiveVideoCallJoiner::create([
            'live_id' => $liveId,
            'user_id' => $userId,
            'user_name' => $userName,
            'join_status' => 'joined',
            'join_date' => Carbon::now(),
        ]);
        return response()->json([
            "status_code" => Response::HTTP_OK,
            "status" => true,
            "message" => "User successfully joined the live session.",
            "data" => $joinSession,
        ], Response::HTTP_OK);
    }

    public function getLiveVideos(Request $request)
    {
        $today = Carbon::today();
        $data = LiveVideCall::whereDate("live_date", $today)->where('live_status', 'running')->latest()->get();
        return response()->json([
            "status_code" => Response::HTTP_OK,
            "status" => true,
            "message" => "All Live Sessions",
            "data" => $data,
        ], Response::HTTP_OK);
    }
}