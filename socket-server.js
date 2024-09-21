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
    // io.brodcast.emit("hello","world");

    socket.on('joinRoom', ({ sender_id, receiver_id }) => {
        const room = getRoomName(sender_id, receiver_id);
        socket.join(room);
        console.log(`User ${sender_id} joined room: ${room}`);
    });
    console.log("1");
    socket.on("chatMessage", (dat) => {
        io.brodcast.emit("mess", JSON.stringify({"mess":"hiii"}));
        data =  JSON.parse(dat);

        console.log("Received chatMessage event:", data);
        
        // io.emit("RecievedMessage",data);
        if (!data) {
            console.error("Invalid request data:", data);
            return;
        }

        const { room, message_data } = data;
        if (!room || !message_data) {
            console.error("Invalid request data:", data);
            return;
        }
        // io.to(room).emit("chatMessage", message_data);
        console.log(`Message received in room ${room}:`, message_data);
        io.to(room).emit("chatMessage", message_data);
    });

    socket.on("disconnect", () => {
        console.log("Client disconnected:", socket.id);
    });
});

app.post('/chatMessage', (req, res) => {
    console.log('Headers:', req.headers); // Log the headers
    console.log('POST request received:', req.body); // Log the entire body

    const { room, message_data } = req.body;

    // Check if room or message_data is undefined
    if (!room || !message_data) {
        console.error('Missing room or message_data');
        return res.status(400).json({ error: 'Missing room or message_data' });
    }

    // Emit message to the specified room
    io.to(room).emit('chatMessage', message_data);
    res.status(200).json({ status: 'Message delivered', message_data });
});
const getRoomName = (sender_id, receiver_id) => {
    return sender_id < receiver_id ? `room_${sender_id}_${receiver_id}` : `room_${receiver_id}_${sender_id}`;
};
const PORT = 3000;
server.listen(PORT, () => console.log(`Server running on port ${PORT}`));
