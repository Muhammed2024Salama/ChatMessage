import './bootstrap';

const senderId = 5;
const receiverId = 1;

const channelName = `chat-${Math.min(senderId, receiverId)}-${Math.max(senderId, receiverId)}`;

window.Echo.private(channelName)
    .listen('.message.sent', (data) => {
        console.log('Message from backend:', data);
    });
