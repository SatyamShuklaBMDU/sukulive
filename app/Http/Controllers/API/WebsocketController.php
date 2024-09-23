<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Ratchet\ConnectionInterface;
use Ratchet\MessageComponentInterface;

class WebsocketController implements MessageComponentInterface
{
    protected $clients;
    private $subscriptions;
    private $users;
    private $userresources;

    public function __construct()
    {
        $this->clients = new \SplObjectStorage;
        $this->subscriptions = [];
        $this->users = [];
        $this->userresources = [];
    }

    public function onOpen(ConnectionInterface $conn)
    {
        $this->clients->attach($conn);
        $this->users[$conn->resourceId] = $conn;
    }
    public function onMessage(ConnectionInterface $conn, $msg)
    {
        echo $msg;
        $data = json_decode($msg);

        if (isset($data->command)) {
            switch ($data->command) {
                case "subscribe":
                    // Store subscription to a conversation channel
                    $this->subscriptions[$conn->resourceId] = $data->conversation_id;
                    break;

                case "message":
                    // Forward message to the target conversation
                    if (isset($this->subscriptions[$conn->resourceId])) {
                        $conversation_id = $this->subscriptions[$conn->resourceId];

                        // Broadcast the message to all clients in the same conversation
                        foreach ($this->subscriptions as $resourceId => $subscribedConversation) {
                            if ($subscribedConversation == $conversation_id && $resourceId != $conn->resourceId) {
                                $this->users[$resourceId]->send(json_encode([
                                    'conversation_id' => $conversation_id,
                                    'sender_id' => $data->sender_id,
                                    'sender_name' => $data->sender_name,
                                    'message' => $data->message,
                                    'time' => $data->time
                                ]));
                            }
                        }
                    }
                    break;
            }
        }
    }

    public function onClose(ConnectionInterface $conn)
    {
        $this->clients->detach($conn);
        echo "Connection {$conn->resourceId} has disconnected\n";
        unset($this->users[$conn->resourceId]);
        unset($this->subscriptions[$conn->resourceId]);

        foreach ($this->userresources as &$userId) {
            foreach ($userId as $key => $resourceId) {
                if ($resourceId == $conn->resourceId) {
                    unset($userId[$key]);
                }
            }
        }
    }

    public function onError(ConnectionInterface $conn, \Exception $e)
    {
        echo "An error has occurred: {$e->getMessage()}\n";
        $conn->close();
    }
}
