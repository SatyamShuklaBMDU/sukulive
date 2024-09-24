<?php

namespace App\Http\Controllers\API;

use App\Events\MessageSent;
use App\Http\Controllers\Controller;
use App\Models\Conversation;
use App\Models\Customer;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use WebSocket\Client;

class MessageController extends Controller
{
    public function sendMessage(Request $request)
    {
        $request->validate([
            'receiver_id' => 'required|exists:customers,id',
            'message' => 'required|string|max:500',
        ]);

        $sender_id = Auth::id();
        $receiver_id = $request->receiver_id;

        // Create or retrieve the conversation
        $conversation = Conversation::firstOrCreate(
            [
                'sender_id' => $sender_id,
                'reciever_id' => $receiver_id,
            ],
            [
                'sender_id' => $sender_id,
                'reciever_id' => $receiver_id,
            ]
        );

        // Save message in database
        $message = Message::create([
            'conversation_id' => $conversation->id,
            'sender_id' => $sender_id,
            'receiver_id' => $receiver_id,
            'message' => $request->message,
        ]);
        try {
            $client = new Client("ws://13.202.220.240:8090");
            $client->send(json_encode([
                'command' => 'message',
                'conversation_id' => $conversation->id,
                'sender_id' => $message->sender_id,
                'sender_name' => Auth::user()->name, 
                'receiver_id' => $message->receiver_id,
                'receiver_name' => Customer::find($message->receiver_id)->name,
                'message' => $message->message,
                'time' => $message->created_at->toDateTimeString(),
            ]));
            $client->close();
        } catch (\Exception $e) {
            Log::error('Error sending message to WebSocket server:', ['error' => $e->getMessage()]);
        }

        // Return response to the sender
        return response()->json([
            'message' => 'Message sent successfully!',
            'data' => $message,
        ], 201);
    }


    public function showChatRoom()
    {
        return view('chat',);
    }
    public function getMessages($conversation_id)
    {
        $messages = Message::where('conversation_id', $conversation_id)
            ->orderBy('created_at', 'asc')
            ->get();

        return response()->json([
            'conversation_id' => $conversation_id,
            'messages' => $messages
        ]);
    }
}
