<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat Debugging</title>
</head>

<body>
    <h1>Chat Debugging - Room: {{ $senderId . '_' . $receiverId }}</h1>

    <!-- Display the messages in this div -->
    <div id="messages">
        <h2>Messages:</h2>
        <ul id="messageList"></ul>
    </div>

    <!-- Include Socket.io Client -->
    <script src="https://cdn.socket.io/4.0.0/socket.io.min.js"></script>

    <script>
        var sender_id = {{ $senderId }};
        var receiver_id = {{ $receiverId }};
        const socket = io('http://localhost:3000');

        const room = sender_id < receiver_id ? `room_${sender_id}_${receiver_id}` : `room_${receiver_id}_${sender_id}`;

        socket.emit('joinRoom', {
            sender_id,
            receiver_id
        });
        console.log(`Joined room: ${room}`);

        // Listen for messages in the room
        socket.on('chatMessage', (data) => {
            if (!data || !data.sender_name || !data.message) {
                console.error('Received incomplete data:', data);
                return;
            }

            console.log('Message received:', data);
            const messageList = document.getElementById('messageList');
            const li = document.createElement('li');
            li.textContent = `From: ${data.sender_name} - Message: ${data.message} - Time: ${data.time}`;
            messageList.appendChild(li);
        });
    </script>
</body>

</html>
