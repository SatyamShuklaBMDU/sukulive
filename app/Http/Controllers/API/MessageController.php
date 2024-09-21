<?php

namespace App\Http\Controllers\API;

use App\Events\MessageSent;
use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Message;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class MessageController extends Controller
{
    public function sendMessage(Request $request)
    {
        $request->validate([
            'receiver_id' => 'required|exists:customers,id',
            'message' => 'required|string|max:500',
        ]);
        // $token = Auth::user()->getRememberTokenName();
        $message = Message::create([
            'sender_id' => Auth::id(),
            'receiver_id' => $request->receiver_id,
            'message' => $request->message,
        ]);
        $client = new Client();
        $sender_id = Auth::id();
        $receiver_id = $request->receiver_id;    
        $room = $sender_id < $receiver_id ? "room_{$sender_id}_{$receiver_id}" : "room_{$receiver_id}_{$sender_id}";
        try {
            $response = $client->post('http://localhost:3000/chatMessage', [
                'json' => [
                    'room' => $room,
                    'message_data' => [
                        'sender_id' => $message->sender_id,
                        'sender_name' => Auth::user()->name, // Make sure this is not null
                        'receiver_id' => $message->receiver_id,
                        'receiver_name' => Customer::find($message->receiver_id)->name, // Make sure this is not null
                        'message' => $message->message,
                        'time' => $message->created_at->toDateTimeString(),
                    ]
                ],
                'headers' => [
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json',
                ],
            ]);
        } catch (\Exception $e) {
            Log::error('Error sending message to Socket.io:', ['error' => $e->getMessage()]);
        }

        return response()->json([
            'message' => 'Message sent successfully!',
            'data' => $message,
        ], 201);
    }

    private function getChatRoomName($senderId, $receiverId)
    {
        return 'chat_' . min($senderId, $receiverId) . '_' . max($senderId, $receiverId);
    }

    public function showChatRoom($senderId, $receiverId)
    {
        return view('chat', compact('senderId','receiverId'));
    }
    public function getMessages($userId)
    {
        $messages = Message::where(function ($query) use ($userId) {
            $query->where('sender_id', Auth::id())
                ->where('receiver_id', $userId);
        })->orWhere(function ($query) use ($userId) {
            $query->where('sender_id', $userId)
                ->where('receiver_id', Auth::id());
        })->orderBy('created_at', 'asc')->get();

        return response()->json([
            'messages' => $messages
        ], 200);
    }
}
