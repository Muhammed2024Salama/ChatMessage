// // import './bootstrap';
// //
// // // window.Echo.private(`chat.${receiverId}`)
// // //     .listen('MessageSentEvent', (message) => {
// // //         console.log('New message:', message);
// // //     });
// //
// // import Echo from 'laravel-echo';
// // import Pusher from 'pusher-js';
// //
// // window.Pusher = Pusher;
// // window.Echo = new Echo({
// //     broadcaster: 'pusher',
// //     key: import.meta.env.VITE_PUSHER_APP_KEY,
// //     cluster: import.meta.env.VITE_PUSHER_APP_CLUSTER,
// //     forceTLS: true,
// // });
// //
// // const receiverId = 1;
// // window.Echo.private(`chat.${receiverId}`)
// //     .listen('.message.sent', (data) => {
// //         console.log('Message Sent Successfully: ', data);
// //     });
//
// const senderId = 5;
//
// window.Echo.private(`chat.${senderId}`)
//     .listen('.message.sent', (data) => {
//         console.log('Message from backend:', data);
//     });

// resources/js/app.js

import './bootstrap';

const senderId = 5;
const receiverId = 1;

const channelName = `chat-${Math.min(senderId, receiverId)}-${Math.max(senderId, receiverId)}`;

window.Echo.private(channelName)
    .listen('.message.sent', (data) => {
        console.log('Message from backend:', data);
    });
