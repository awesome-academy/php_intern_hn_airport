import Echo from "laravel-echo"
import {
    functionsIn
} from "lodash";

var user_id;
var list_noti;
var num_noti;
const pickup = 0;
const dropoff = 1;

$(document).ready(function () {
    initVarible();
    connenctChannel(user_id);
    getNotification();
})

function initVarible() {
    user_id = $('#user_id').val();
    list_noti = $('#list-noti');
    if ($('#table-notification-new').length > 0) {
        $('#table-notification-new').DataTable();
    }
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
            list_noti.prepend(html);
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
                    success: function (data) {
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
                    error: function (data) {

                    }
                })
            }

            if ($('#table-notification-new').length > 0) {
                let table = $('#table-notification-new').DataTable();
                var row = [];
                row.push(parseInt(array[0]) + 1);
                row.push(notification.title);
                row.push(`<a href="${notification.link }">${notification.link}</a>`);
                row.push(`<button class="btn btn-success btn-noti" data-id="${notification.id}">
                    <i class="fas fa-check"></i>&nbsp;Read</button>`);

                table.row.add(row).draw(false);
            }

            const Toast = Swal.mixin({
                toast: true,
                position: 'bottom-end',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer)
                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                }
            })

            Toast.fire({
                icon: 'info',
                title: notification.title,
            })
        });
}

function getNotification() {
    $.ajax({
        type: 'GET',
        url: '/notifications',
        success: function (data) {
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
            <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i>${moment(data.created_at.toString()).fromNow()}</p>
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

$("body").delegate("a.item-noti", "click", function (e) {
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
        success: function (data) {
            window.location.href = href;
        },
        error: function (data) {

        }
    })
})

if ($('#table-notification-new').length > 0) {
    $('#table-notification-new').on('click', 'button.btn-noti', function () {
        let notiId = $(this).data("id");
        let row = $('#table-notification-new').DataTable().row($(this).parent());
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            type: 'PUT',
            url: `/notifications/${notiId}`,
            success: function (data) {
                row.remove().draw();
                let check_noti = $("#list-noti").find(`[data-id='${notiId}']`);
                if (check_noti.length > 0) {
                    check_noti.remove();
                    let array = num_noti.split(" ");
                    num_noti = `${parseInt(array[0]) - 1} ${array[1]}`
                    $('#num-noti').text(num_noti);
                }
            },
            error: function (data) {
    
            }
        });
    });

    $('#table-notification-new').on('click', 'a', function (e) {
        e.preventDefault();
        let href = $(this).attr('href');

        $(this).parent().parent().find('button').click();
        window.location.href = href;  
    });
}
