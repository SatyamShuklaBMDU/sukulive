const express = require('express');
const http = require('http');
const socketIo = require('socket.io');
const bodyParser = require('body-parser'); // To parse incoming JSON requests

const app = express();
app.use(bodyParser.json()); // Middleware to parse JSON bodies

const server = http.createServer(app);
const io = socketIo(server, {
    cors: {
        origin: "*",
        methods: ["GET", "POST"]
    }
});

// Handle WebSocket connections
io.on('connection', (socket) => {
    console.log('New client connected:', socket.id);

    // Emit messages to all clients
    socket.on('chatMessage', (msg) => {
        console.log('Message received: ', msg);
        io.emit('chatMessage', msg);  // Broadcast to all clients
    });

    socket.on('disconnect', () => {
        console.log('Client disconnected:', socket.id);
    });
});

// Handle POST request from Laravel
app.post('/chatMessage', (req, res) => {
    const message = req.body.message;
    console.log('POST request received: ', message);

    // Emit the message to all connected Socket.io clients
    io.emit('chatMessage', message);

    // Send a response back to the Laravel server
    res.status(200).json({ status: 'Message received', message: message });
});

const PORT = 3000;
server.listen(PORT, () => console.log(`Socket.io server running on port ${PORT}`));