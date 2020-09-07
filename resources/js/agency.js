const { divide } = require("lodash");

$.widget.bridge('uibutton', $.ui.button);

var to_airport_province;
var to_airport_airport;
var from_airport_province;
var from_airport_airport;
var number_to_airport_pickup = 1;
var number_to_airport_drop_off = 1;
var number_from_airport_drop_off = 1;
var to_airport_ways;
var province_airport_id;


$(document).ready(function () 
{
    initVarible();

    $.fn.dataTable.ext.errMode = 'none';

    var table_request_new = $('#table-request-new').DataTable({
        processing: true,
        serverSide: true,
        ajax: '/requests?type=new',
        columns: [{
                data: 'id'
            },
            {
                data: 'DT_RowData.pickup_location.location'
            },
            {
                data: 'DT_RowData.dropoff_location.location'
            },
            {
                data: 'pickup'
            },
            {
                data: 'DT_RowData.car_types'
            },
            {
                data: 'action'
            },
        ]
    });

    var table_request_cancel = $('#table-request-canceled').DataTable({
        processing: true,
        serverSide: true,
        ajax: '/requests?type=cancel',
        columns: [{
                data: 'id'
            },
            {
                data: 'DT_RowData.pickup_location.location'
            },
            {
                data: 'DT_RowData.dropoff_location.location'
            },
            {
                data: 'pickup'
            },
            {
                data: 'DT_RowData.car_types'
            },
            {
                data: 'action'
            },
        ]
    });

    $('#table-request-new').on('click', 'button.btn-delete-request', function () {
        var data = table_request_new.row($(this).parent()).data();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            type: 'DELETE',
            url: '/requests/' + data.id,
            success: function (data) {
                Swal.fire({
                    icon: 'success',
                    title: data,
                    showConfirmButton: false,
                    timer: 1500
                }).then((result) => {
                    window.location.href = "/requests";
                });
            },
            error: function (data) {
                Swal.fire({
                    icon: 'error',
                    title: data,
                    showConfirmButton: false,
                    timer: 1500
                })
            }
        });
    });
});

function initVarible() 
{
    to_airport_province = $('#to-airport-province');
    to_airport_airport = $('#to-airport-airport');
    from_airport_province = $('#from-airport-province');
    from_airport_airport = $('#from-airport-airport');
    province_airport_id = $('#airport-province-airport-id').val();
}

$('.btn-clear').click(function () {
    if (this.parentElement.parentElement) {
        this.parentElement.parentElement.remove();
    }
});

$('#btn-airport-add-pickup').click(function () {
    addInput("airport-pickup", "aiport-pickup-");
});

$('#btn-airport-add-drop-off').click(function () {
    addInput("airport-drop-off", "aiport-drop-off-");
});

function addInput(name, id) {
    let div = document.createElement("div");
    div.classList.add("input-group");

    let divPrepend = document.createElement("div");
    divPrepend.classList.add("input-group-append");

    let button = document.createElement("button");
    button.classList.add("btn");
    button.classList.add("btn-default");
    button.type = "button";
    button.textContent = "x";
    button.onclick = clearInput;
    divPrepend.appendChild(button);

    let input = document.createElement("input");
    input.type = "text";
    input.classList.add("form-control");

    div.appendChild(input);
    div.appendChild(divPrepend);

    document.getElementsByClassName(name)[0].appendChild(div);
}

function clearInput() 
{
    if (this.parentElement.parentElement) {
        this.parentElement.parentElement.remove();
    }
}


$('#to-airport-province').change(function () 
{
    $.ajax({
        type: 'GET',
        url: '/api/province-airport/' + to_airport_province.val(),
        success: function (data) {
            if (data.provinceAirport) {
                to_airport_airport.val(data.provinceAirport.name);
                province_airport_id = data.provinceAirport.id;
            }
        }
    });
});

$('#airport-province').change(function () {
    $.ajax({
        type: 'GET',
        url: '/api/province-airport/' + $('#airport-province').val(),
        success: function (data) {
            if (data.provinceAirport) {
                $('#airport-province-airport').val(data.provinceAirport.name);
                province_airport_id = data.provinceAirport.id;
            }
        }
    });
});

$('#from-airport-province').change(function () 
{
    $.ajax({
        type: 'GET',
        url: '/api/province-airport/' + from_airport_province.val(),
        success: function (data) {
            if (data.provinceAirport) {
                from_airport_airport.val(data.provinceAirport.name);
                province_airport_id = data.provinceAirport.id;
            }
        }
    });
});

$('#btn-to-airport-add-pickup').click(function() 
{
    addInput("to-airport-pickup", "to-aiport-pickup-");
});

$('#btn-to-airport-add-drop-off').click(function() 
{
    addInput("to-airport-drop-off", "to-aiport-drop-off-");
});

$('#btn-from-airport-add-drop-off').click(function() 
{
    addInput("from-airport-drop-off", "from-airport-drop-off-");
});

$('input[name=ways]').change(function() 
{
    to_airport_ways = $('input[name=ways]:checked').val();
    if (to_airport_ways == 0) {
        $('.to-airport-drop-off').css('display', 'none');
    } else if (to_airport_ways == 1) {
        $('.to-airport-drop-off').css('display', 'block');
    }
});

$('#btn-to-airport-submit').click(function(e) 
{
    e.preventDefault();
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    var car_type_id = $('#to-airport-car-type').val();
    var pickup = $('#to-airport-datetime').val();
    // Hiện tại để budget mặc định viết hàm tính tiền sau
    var budget = 100000;
    var note = $('#to-airport-note').val();

    var pickup_location = [];
    let pickup_inputs = $('.to-airport-pickup').children().find('input');
    for (let index = 0; index < pickup_inputs.length; index++) {
        let pickup = pickup_inputs[index].value;
        if (pickup) {
            pickup_location.push(pickup);
        }
    }
    var dropoff_location = [];
    if (to_airport_airport.val()) {
        dropoff_location.push(to_airport_airport.val());
    }
    if (to_airport_ways == 0) {
        let dropoff_inputs = $('.to-airport-drop-off').children().find('input');
        for (let index = 0; index < dropoff_inputs.length; index++) {
            let dropoff = dropoff_inputs[index].value;
            if (dropoff) {
                dropoff_location.push(dropoff);
            }
        }
    }

    var data = {
        car_type_id: car_type_id,
        province_airport_id: province_airport_id,
        pickup: pickup,
        budget: budget,
        pickup_location: pickup_location,
        dropoff_location: dropoff_location,
        note: note,
    }

    $.ajax({
        type: 'POST',
        url: '/requests',
        data: data,
        success: function (data) {
            Swal.fire({
                icon: 'success',
                title: data,
                showConfirmButton: false,
                timer: 1500
            }).then((result) => {
                window.location.href = "/requests";  
            });
        },
        error: function(data) {
            var errors = data.responseJSON;
            if (errors.errors.car_type_id) {
                $('#to-airport-car-type-error').text(errors.errors.car_type_id[0]);
            } 
            if (errors.errors.pickup_location) {
                $('#to-airport-pickup-error').text(errors.errors.pickup_location[0]);
            } 
            if (errors.errors.pickup) {
                $('#to-airport-datetime-error').text(errors.errors.pickup[0]);
            }
            if (errors.errors.dropoff_location) {
                $('#to-airport-province-error').text(errors.errors.dropoff_location[0]);
            }
        },
    })
});

$('#btn-from-airport-submit').click(function(e) 
{
    e.preventDefault();
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    var car_type_id = $('#from-airport-car-type').val();
    var pickup = $('#from-airport-datetime').val();
    // Hiện tại để budget mặc định viết hàm tính tiền sau
    var budget = 100000;
    var flight_no = $('#from-airport-flight').val()
    var note;
    if (flight_no) {
        note = "<li>Fligt no: " + flight_no + "</li> ";
    }
    note += $('#from-airport-note').val();

    var pickup_location = [];
    if (from_airport_airport.val()) {
        pickup_location.push(from_airport_airport.val());
    }

    var dropoff_location = [];
    let dropoff_inputs = $('.from-airport-drop-off').children().find('input');
    for (let index = 0; index < dropoff_inputs.length; index++) {
        let dropoff = dropoff_inputs[index].value;
        if (dropoff) {
            dropoff_location.push(dropoff);
        }
    }

    var data = {
        car_type_id: car_type_id,
        province_airport_id: province_airport_id,
        pickup: pickup,
        budget: budget,
        pickup_location: pickup_location,
        dropoff_location: dropoff_location,
        note: note,
    }

    $.ajax({
        type: 'POST',
        url: '/requests',
        success: function (data) {
            Swal.fire({
                icon: 'success',
                title: data,
                showConfirmButton: false,
                timer: 1500
            }).then((result) => {
                window.location.href = "/requests";  
            });
        },
        error: function(data) {
            var errors = data.responseJSON;
            if (errors.errors.car_type_id) {
                $('#from-airport-car-type-error').text(errors.errors.car_type_id[0]);
            } 
            if (errors.errors.dropoff_location) {
                $('#from-airport-drop-off-error').text(errors.errors.dropoff_location[0]);
            } 
            if (errors.errors.pickup) {
                $('#from-airport-datetime-error').text(errors.errors.pickup[0]);
            }
            if (errors.errors.pickup_location) {
                $('#from-airport-province-error').text(errors.errors.pickup_location[0]);
            }
        },
    })
});

$('#btn-update-request').click(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    var id = $('#request-id').val();
    var car_type_id = $('#airport-car-type').val();
    var pickup = $('#airport-datetime').val();
    // Hiện tại để budget mặc định viết hàm tính tiền sau
    var budget = 100000;
    var note = $('#airport-note').val();

    var pickup_location = [];
    let pickup_inputs = $('.airport-pickup').children().find('input');
    for (let index = 0; index < pickup_inputs.length; index++) {
        let pickup = pickup_inputs[index].value;
        if (pickup) {
            pickup_location.push(pickup);
        }
    } 

    var dropoff_location = [];
    let dropoff_inputs = $('.airport-drop-off').children().find('input');
    for (let index = 0; index < dropoff_inputs.length; index++) {
        let dropoff = dropoff_inputs[index].value;
        if (dropoff) {
            dropoff_location.push(dropoff);
        }
    }

    if ($('#request-type').val() == 0) {
        pickup_location.push($('#airport-province-airport').val());
    } else if ($('#request-type').val() == 1) {
        dropoff_location.push($('#airport-province-airport').val());
    }

    var data = {
        car_type_id: car_type_id,
        province_airport_id: province_airport_id,
        pickup: pickup,
        budget: budget,
        pickup_location: pickup_location,
        dropoff_location: dropoff_location,
        note: note,
    }

    $.ajax({
        type: 'PUT',
        url: '/requests/' + id,
        data: data,
        success: function (data) {
            Swal.fire({
                icon: 'success',
                title: data,
                showConfirmButton: false,
                timer: 1500
            }).then((result) => {
                window.location.href = "/requests";   
            });
        },
        error: function (data) {
            var errors = data.responseJSON;
            if (errors.errors.car_type_id) {
                $('#airport-car-type-error').text(errors.errors.car_type_id[0]);
            }
            if (errors.errors.pickup_location) {
                $('#airport-pickup-error').text(errors.errors.pickup_location[0]);
            }
            if (errors.errors.pickup) {
                $('#airport-datetime-error').text(errors.errors.pickup[0]);
            }
            if (errors.errors.dropoff_location) {
                $('#airport-province-error').text(errors.errors.dropoff_location[0]);
            }
        },
    })
});
