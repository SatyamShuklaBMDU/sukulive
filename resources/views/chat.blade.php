<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Socket.io Test</title>
    <script src="https://cdn.socket.io/4.0.0/socket.io.min.js"></script>
</head>

<body>
    <script>
        var conn = new WebSocket('ws://localhost:8090');
        conn.onopen = function(e) {
            console.log("Connection established!");
        };
    </script>
</body>

</html>
