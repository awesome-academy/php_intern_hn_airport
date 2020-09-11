const {
    pick
} = require("lodash");

var request_type;
var to_airport_pickup;
var to_airport_dropoff;
var from_airport_pickup;
var from_airport_dropoff;
var request_car_type;
var request_province;
var province_airport_id;

$(document).ready(function () {
    initVarible();
    initAutocomplete();
    $('#datetimepicker').datetimepicker({
        format: 'yyyy-mm-dd hh:ii'
    });
});

function initVarible() {
    request_type = $('#request-type');
    to_airport_pickup = $('#to-airport-pickup');
    to_airport_dropoff = $('#to-airport-dropoff');
    from_airport_pickup = $('#from-airport-pickup');
    from_airport_dropoff = $('#from-airport-dropoff');
    request_car_type = $('#request-car-type');
    request_province = $('#request-province');
    var options = {
        componentRestrictions: {
            country: 'VN'
        }
    };
    autoCompletePickUp = new google.maps.places.Autocomplete(document.getElementById('to-airport-pickup'), options);
    autoCompleteDropOff = new google.maps.places.Autocomplete(document.getElementById('from-airport-dropoff'), options);
    autoCompletePickUp.addListener("place_changed", () => {
        const place = autoCompletePickUp.getPlace();
        var result_array_length = place.address_components.length;
        for (var index = 0; index < result_array_length; index++) {
            if (place.address_components[index].types[0] == "administrative_area_level_1") {
                var city_name = place.address_components[index].short_name.trim();
            }
        }
        $.ajax({
            type: 'GET',
            url: `/api/province-search?city=${city_name}`,
            success: function (data) {
                var html = $("#default-select-province").children()[1].children;
                html[0].innerHTML = data.name;
                html[1].querySelector(`.option[data-value="${data.id}"]`).classList.add("selected");
                $.ajax({
                    type: 'GET',
                    url: `/api/province-airport/${data.id}`,
                    success: function (data) {
                        if (data.provinceAirport) {
                            to_airport_dropoff.val(data.provinceAirport.name);
                            from_airport_pickup.val(data.provinceAirport.name);
                            province_airport_id = data.provinceAirport.id;
                        }
                    }
                });
            }
        })
    });
    autoCompleteDropOff.addListener("place_changed", () => {
        const place = autoCompleteDropOff.getPlace();
    });
}

function initAutocomplete() {

}

$('#request-type').change(function () {
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

$('#btn-checkout').click(function (e) {
    e.preventDefault();
    resetError();

    var pickup_location = [];
    var dropoff_location = [];
    var origins;
    var destinations;
    if (request_type.val() == 0) {
        if ($("input[name=dropoff_to_airport]").val()) {
            destinations = $("input[name=dropoff_to_airport]").val()
            dropoff_location.push(destinations);
        }
        if ($("input[name=pickup_to_airport]").val()) {
            origins = $("input[name=pickup_to_airport]").val();
            pickup_location.push(origins);

        }
    } else if (request_type.val() == 1) {
        if ($("input[name=dropoff_from_airport]").val()) {
            destinations = $("input[name=dropoff_from_airport]").val();
            dropoff_location.push(destinations);
        }
        if ($("input[name=pickup_from_airport]").val()) {
            origins = $("input[name=pickup_from_airport]").val()
            pickup_location.push(origins);
        }
    }

    var car_type_id = $("select[name=car_type]").val();
    var pickup = $("#datetimepicker").val();
    var name = $("input[name=name]").val();
    var phone = $("input[name=phone]").val();

    dataCalculate = {
        name: name,
        phone: phone,
        car_type_id: car_type_id,
        province_airport_id: province_airport_id,
        pickup: pickup,
        dropoff_location: dropoff_location,
        pickup_location: pickup_location,
        budget: 0,
    }

    $.ajax({
        type: 'POST',
        url: 'api/calculate-price',
        data: dataCalculate,
        success: function (data) {
            Swal.fire({
                title: data.title,
                text: data.message,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes'
            }).then((result) => {
                if (result.isConfirmed) {
                    data = {
                        name: name,
                        phone: phone,
                        car_type_id: car_type_id,
                        province_airport_id: province_airport_id,
                        pickup: pickup,
                        dropoff_location: dropoff_location,
                        pickup_location: pickup_location,
                        budget: data.budget,
                    }

                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });

                    $.ajax({
                        type: 'POST',
                        url: '/',
                        data: data,
                        success: function (data) {
                            Swal.fire({
                                icon: 'success',
                                title: data,
                                showConfirmButton: false,
                                timer: 1500
                            }).then((result) => {
                                window.location.reload();
                            })
                        },
                        error: function (data) {
                            Swal.fire({
                                icon: 'error',
                                title: data,
                                showConfirmButton: false,
                                timer: 1500,
                            })
                        },
                    });
                }
            })
        },
        error: function (data) {
            var errors = data.responseJSON;
            if (errors.errors) {
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
            } else {
                Swal.fire({
                    icon: 'error',
                    title: errors,
                    showConfirmButton: false,
                    timer: 1500,
                })
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
