import './bootstrap';

// window.Echo.private(`chat.${receiverId}`)
//     .listen('MessageSentEvent', (message) => {
//         console.log('New message:', message);
//     });

import Echo from 'laravel-echo';
import Pusher from 'pusher-js';

window.Pusher = Pusher;
window.Echo = new Echo({
    broadcaster: 'pusher',
    key: import.meta.env.VITE_PUSHER_APP_KEY,
    cluster: import.meta.env.VITE_PUSHER_APP_CLUSTER,
    forceTLS: true,
});

const receiverId = 1;
window.Echo.private(`chat.${receiverId}`)
    .listen('.message.sent', (data) => {
        console.log('تم استقبال الرسالة:', data);
    });
