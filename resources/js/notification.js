import Echo from "laravel-echo"

window.io = require('socket.io-client');

window.Echo = new Echo({
    broadcaster: 'socket.io',
    host: window.location.hostname + ':6001'
});

var user_id = $('#user_id').val();

window.Echo.private(`user_channel_${user_id}`)
    .listen('.request_notification', (e) => {

    });
