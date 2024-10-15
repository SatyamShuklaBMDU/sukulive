const { log } = require("console");
const express = require("express");
const http = require("http");
const socketIo = require("socket.io");
const cors = require('cors');

const app = express();
app.use(express.json());
const server = http.createServer(app);
app.use(cors());

const io = socketIo(server, {
    cors: {
        origin: "*",
        methods: ["GET", "POST"],
    },
});

io.on("connection", (socket) => {
    console.log("New client connected:", socket.id);

    socket.on('joinConversation', (conversation_id) => {
        try {
            socket.join(`conversation_${conversation_id}`);
            console.log(`User has joined conversation ${conversation_id}`);
        } catch (err) {
            console.log(err);
        }
    });

    socket.on("chatMessage", (data) => {
        try {
            console.log("Received chatMessage event:", data);

            const { conversation_id, message_data } = data;
            if (!conversation_id || !message_data) {
                console.error("Invalid request data:", data);
                return;
            }

            console.log(`Message received in conversation ${conversation_id}:`, message_data);
            io.to(`conversation_${conversation_id}`).emit("chatMessage", message_data);
        } catch (error) {
            console.error("Error processing chatMessage:", error);
            socket.disconnect();
        }
    });

    socket.on("disconnect", () => {
        console.log("Client disconnected:", socket.id);
    });
});

    app.post('/chatMessage', (req, res) => {
    console.log('POST request received:', req.body);

    const { conversation_id, message_data } = req.body;

    if (!conversation_id || !message_data) {
        console.error('Missing conversation_id or message_data');
        return res.status(400).json({ error: 'Missing conversation_id or message_data' });
    }

    io.to(`conversation_${conversation_id}`).emit('chatMessage', message_data);
    res.status(200).json({ status: 'Message delivered', message_data });
});

const PORT = 3000;
server.listen(PORT, () => console.log(`Server running on port ${PORT}`));