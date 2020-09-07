var request_type;
var to_airport_pickup;
var to_airport_dropoff;
var from_airport_pickup;
var from_airport_dropoff;
var request_car_type;
var request_province;
var province_airport_id;

$(document).ready(function () 
{
    initVarible();
});

function initVarible() 
{
    request_type = $('#request-type');
    to_airport_pickup = $('#to-airport-pickup');
    to_airport_dropoff = $('#to-airport-dropoff');
    from_airport_pickup = $('#from-airport-pickup');
    from_airport_dropoff = $('#from-airport-dropoff');
    request_car_type = $('#request-car-type');
    request_province = $('#request-province');
}

$('#request-type').change(function () 
{
    resetError();
    if (request_type.val() == 0) {
        to_airport_pickup.css("display", "block");
        to_airport_dropoff.css("display", "block");
        from_airport_pickup.css("display", "none");
        from_airport_dropoff.css("display", "none");
    } else if (request_type.val() == 1) {
        to_airport_pickup.css("display", "none");
        to_airport_dropoff.css("display", "none");
        from_airport_pickup.css("display", "block");
        from_airport_dropoff.css("display", "block");
    }
});

$('#request-province').change(function () {
    $.ajax({
        type: 'GET',
        url: '/api/province-airport/' + request_province.val(),
        success: function (data) {
            if (data.provinceAirport) {
                to_airport_dropoff.val(data.provinceAirport.name);
                from_airport_pickup.val(data.provinceAirport.name);
                province_airport_id = data.provinceAirport.id;
            }
        }
    });
});

$('#btn-checkout').click(function (e) 
{
    resetError();

    var pickup_location = [];
    var dropoff_location = [];
    e.preventDefault();
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    var name = $("input[name=name]").val();
    var phone = $("input[name=phone]").val();
    var car_type_id = $("select[name=car_type]").val();
    var pickup = $("input[name=datetime]").val();
    // Budget hiện tại fix cứng viết hàm tính tiền sau
    var budget = 100000;

    if (request_type.val() == 0) {
        if ($("input[name=dropoff_to_airport]").val()) {
            dropoff_location.push($("input[name=dropoff_to_airport]").val());
        }
        if ($("input[name=pickup_to_airport]").val()) {
            pickup_location.push($("input[name=pickup_to_airport]").val());
        }
    } else if (request_type.val() == 1) {
        if ($("input[name=dropoff_from_airport]").val()) {
            dropoff_location.push($("input[name=dropoff_from_airport]").val());
        }
        if ($("input[name=pickup_from_airport]").val()) {
            pickup_location.push($("input[name=pickup_from_airport]").val());
        }
    }

    data = {
        name: name,
        phone: phone,
        car_type_id: car_type_id,
        province_airport_id: province_airport_id,
        pickup: pickup,
        dropoff_location: dropoff_location,
        pickup_location: pickup_location,
        budget: budget,
    }

    $.ajax({
        type: 'POST',
        url: '/',
        data: data,
        success: function (data) {
            alert(data)
            window.location.reload();
        },
        error: function (data) {
            var errors = data.responseJSON;
            if (errors.errors.car_type_id) {
                $('#error-car-type').text(errors.errors.car_type_id[0]);
            }
            if (errors.errors.pickup_location) {
                if (request_type.val() == 0) {
                    $('#error-to-airport-pickup').text(errors.errors.pickup_location[0]);
                } else if (request_type.val() == 1) {
                    $('#error-from-airport-pickup').text(errors.errors.pickup_location[0]);
                }
            }
            if (errors.errors.pickup) {
                $('#error-datetime').text(errors.errors.pickup[0]);
            }
            if (errors.errors.dropoff_location) {
                if (request_type.val() == 0) {
                    $('#error-to-airport-dropoff').text(errors.errors.dropoff_location[0]);
                } else if (request_type.val() == 1) {
                    $('#error-from-airport-dropoff').text(errors.errors.dropoff_location[0]);
                }
            }
            if (errors.errors.province_airport_id) {
                $('#error-province').text(errors.errors.province_airport_id[0]);
            }
            if (errors.errors.name) {
                $('#error-name').text(errors.errors.name[0]);
            }
            if (errors.errors.phone) {
                $('#error-phone').text(errors.errors.phone[0]);
            }
        },
    });
});

function resetError() {
    if (request_type.val() == 0) {
        $('#error-car-type').text("");
        $('#error-from-airport-pickup').text("");
        $('#error-from-airport-dropoff').text("");
        $('#error-datetime').text("");
        $('#error-province').text("");
        $('#error-name').text("");
        $('#error-phone').text("");
    } else if (request_type.val() == 1) {
        $('#error-car-type').text("");
        $('#error-to-airport-pickup').text("");
        $('#error-to-airport-dropoff').text("");
        $('#error-datetime').text("");
        $('#error-province').text("");
        $('#error-name').text("");
        $('#error-phone').text("");
    }
}
