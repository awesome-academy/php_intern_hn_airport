import Echo from "laravel-echo"
import { functionsIn } from "lodash";

var user_id;
var list_noti;
var num_noti;
const pickup = 0;
const dropoff = 1;

$(document).ready(function() {
    initVarible();
    connenctChannel(user_id);
    getNotification();
})

function initVarible() {
    user_id = $('#user_id').val();
    list_noti = $('#list-noti');
}

function connenctChannel(user_id) {
    window.io = require('socket.io-client');

    window.Echo = new Echo({
        broadcaster: 'socket.io',
        host: window.location.hostname + ':6001'
    });


    window.Echo.private(`user_channel_${user_id}`)
        .notification((notification) => {
            let html = notiHtml(notification);
            list_noti.append(html);
            if (list_noti.children("a").length > 2) {
                list_noti.children("a").last().remove();
            }
            let array = num_noti.split(" ");
            num_noti = `${parseInt(array[0]) + 1} ${array[1]}`
            $('#num-noti').text(num_noti);

            if ($('#noti').children('span').length == 0) {
                $('#noti').append(`<span class="badge text-danger navbar-badge"><i class="fas fa-circle"></i></span>`);
            }

            if ($('#table-request-new').length > 0) {
                let table = $('#table-request-new').DataTable();
                let arrayLink = notification.link.split("/")
                let requestId = arrayLink[4];
                $.ajax({
                    type: 'GET',
                    url: `/requests/${requestId}`,
                    success: function(data) {
                        var row = [];
                        for (let index = 0; index < data.requestDetail.request_destinations.length; index++) {
                            if (data.requestDetail.request_destinations[index].type == pickup) {
                                row.push(data.requestDetail.request_destinations[index].location);
                                break;
                            }
                        }
                        for (let index = data.requestDetail.request_destinations.length - 1; index > 0; index--) {
                            if (data.requestDetail.request_destinations[index].type == dropoff) {
                                row.push(data.requestDetail.request_destinations[index].location);
                                break;
                            }
                        }
                        row.push(data.requestDetail.pickup);
                        row.push(`${data.requestDetail.car_types.type} ${data.seat}`);
                        row.push(`${data.requestDetail.budget} ${data.vnd}`);
                        row.push(`<a href="${notification.link}" class="btn btn-warning btn-detail">
                        <i class="fa fa-eye"></i>View</a>`);
                        
                        table.row.add(row).draw(false);
                    },
                    error: function(data) {
            
                    }
                })
            }
        });
}

function getNotification() {
    $.ajax({
        type: 'GET',
        url: '/notifications',
        success: function(data) {
            num_noti = data.numNoti;
            $('#num-noti').text(num_noti);
            for (let index = 0; index < data.notifications.length; index++) {
                let html = notiHtml(data.notifications[index]);
                list_noti.append(html);
            }
            if (data.notifications.length > 0) {
                $('#noti').append(`<span class="badge text-danger navbar-badge"><i class="fas fa-circle"></i></span>`);
            }
        }
    })
}

function notiHtml(data) {
    let html;
    if (data.data) {
        html = 
        `<a href="${data.data.link}" class="dropdown-item item-noti" data-id="${data.id}">
            <i class="fas fa-file mr-2"></i> ${data.data.title}
            <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i>${moment(data.create_at).fromNow()}</p>
        </a>
        <div class="dropdown-divider"></div>`;
    } else {
        html = 
        `<a href="${data.link}" class="dropdown-item item-noti" data-id="${data.id}">
            <i class="fas fa-file mr-2"></i> ${data.title}
            <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i>${moment().fromNow()}</p>
        </a>
        <div class="dropdown-divider"></div>`;
    }
    
    return html;
}

$("body").delegate("a.item-noti", "click", function(e) {
    e.preventDefault();
    let notiId = $(this).data("id");
    let href = $(this).attr('href');
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        type: 'PUT',
        url: `/notifications/${notiId}`,
        success: function(data) {
            window.location.href = href;
        },
        error: function(data) {

        }
    })
})


