<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Advanced Chatbot</title>
    <link rel="stylesheet" href="chatbot/style.css">
</head>
<body>

<!-- Floating Button -->
<div id="chatbot-btn" aria-label="Open Chatbot">
    💬 Chat
</div>

<!-- Chatbot Interface -->
<div id="chatbot" aria-live="polite">
    <div id="chatbot-header">
        Green Tea Bot
    </div>
    <div id="chatbot-messages"></div>
    <div id="chatbot-input">
        <textarea id="user-input" rows="1" placeholder="Type your message..." aria-label="Type your message here"></textarea>
        <button id="send-btn" aria-label="Send Message">Send</button>
    </div>
</div>
<script src="chatbot/script.js"></script>
</body>
</html>
