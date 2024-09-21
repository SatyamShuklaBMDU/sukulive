<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Socket.io Test</title>
    <script src="https://cdn.socket.io/4.0.0/socket.io.min.js"></script>
</head>
<body>
    <script>
        const socket = io('http://13.202.220.240:3000');

        socket.on('connect', () => {
            console.log('Connected to Socket.io server!');
        });

        socket.on('connect_error', (err) => {
            console.error('Connection error:', err);
        });
    </script>
</body>
</html>
