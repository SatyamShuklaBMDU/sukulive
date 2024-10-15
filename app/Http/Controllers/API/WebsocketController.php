<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Ratchet\ConnectionInterface;
use Ratchet\MessageComponentInterface;

class WebsocketController implements MessageComponentInterface
{
    protected $clients = [];
    public function onOpen(ConnectionInterface $conn)
    {
        echo "New connection Connected! ({$conn->resourceId})\n";
    }

    public function onMessage(ConnectionInterface $conn, $message)
    {
        $data = json_decode($message, true);
        if ($data['command'] === 'register') {
            $userId = $data['userId'];
            $this->clients[$userId] = $conn;
            echo "User $userId registered.\n";
        }
        if ($data['command'] === 'message') {
            $fromUserId = $data['from'];
            $toUserId = $data['to'];
            $msg = $data['message'];
            echo "Message from User $fromUserId to User $toUserId: $msg\n";
            if (isset($this->clients[$toUserId])) {
                $toClient = $this->clients[$toUserId];
                $toClient->send(json_encode([
                    'command' => 'message',
                    'from' => $fromUserId,
                    'message' => $msg
                ]));
            } else {
                echo "User $toUserId is not connected.\n";
            }
        }
    }
    public function onClose(ConnectionInterface $conn)
    {
        echo "Connection {$conn->resourceId} has disconnected\n";
        foreach ($this->clients as $userId => $client) {
            if ($client === $conn) {
                unset($this->clients[$userId]);
                echo "User $userId has been disconnected.\n";
                break;
            }
        }
    }

    public function onError(ConnectionInterface $conn, \Exception $e)
    {
        echo "An error has occurred: {$e->getMessage()}\n";
        $conn->close();
    }
}
