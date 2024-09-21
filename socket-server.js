const { log } = require("console");
const express = require("express");
const http = require("http");
const WebSocket = require("ws");
const cors = require("cors");

const app = express();
app.use(express.json());
app.use(cors());

const server = http.createServer(app);

// Initialize WebSocket server
const wss = new WebSocket.Server({ server });

// Utility function to create a room name
const getRoomName = (sender_id, receiver_id) => {
  return sender_id < receiver_id ? `room_${sender_id}_${receiver_id}` : `room_${receiver_id}_${sender_id}`;
};

// Object to hold the connected clients and their rooms
const clients = {};

// Handle WebSocket connections
wss.on("connection", (ws) => {
  console.log("New client connected");

  // Store the client and its room once they join
  ws.on("message", (message) => {
    try {
      const data = JSON.parse(message);

      // Handle joining room
      if (data.event === "joinRoom") {
        const { sender_id, receiver_id } = data;
        const room = getRoomName(sender_id, receiver_id);

        // Store the client connection
        if (!clients[room]) {
          clients[room] = [];
        }
        clients[room].push(ws);
        ws.room = room;

        console.log(`User ${sender_id} joined room: ${room}`);
      }

      // Handle chat message
      if (data.event === "chatMessage") {
        const { room, message_data } = data;

        // Validate room and message
        if (!room || !message_data) {
          console.error("Invalid request data:", data);
          return;
        }

        console.log(`Message received in room ${room}:`, message_data);

        // Broadcast message to all clients in the room
        if (clients[room]) {
          clients[room].forEach((client) => {
            if (client.readyState === WebSocket.OPEN) {
              client.send(JSON.stringify({ event: "chatMessage", data: message_data }));
            }
          });
        }
      }
    } catch (error) {
      console.error("Error processing message:", error);
    }
  });

  // Handle client disconnection
  ws.on("close", () => {
    console.log("Client disconnected");

    // Remove the client from the room
    if (ws.room && clients[ws.room]) {
      clients[ws.room] = clients[ws.room].filter((client) => client !== ws);
    }
  });
});

// Handle HTTP POST requests to send chat messages to a room
app.post("/chatMessage", (req, res) => {
  console.log("POST request received:", req.body);

  const { room, message_data } = req.body;

  if (!room || !message_data) {
    console.error("Missing room or message_data");
    return res.status(400).json({ error: "Missing room or message_data" });
  }

  // Broadcast message to all clients in the room
  if (clients[room]) {
    clients[room].forEach((client) => {
      if (client.readyState === WebSocket.OPEN) {
        client.send(JSON.stringify({ event: "chatMessage", data: message_data }));
      }
    });
  }

  res.status(200).json({ status: "Message delivered", message_data });
});

// Start the server
const PORT = 3000;
server.listen(PORT, () => console.log(`Server running on port ${PORT}`));
