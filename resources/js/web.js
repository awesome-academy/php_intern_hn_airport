var request_type;
var to_airport_pickup;
var to_airport_dropoff;
var from_airport_pickup;
var from_airport_dropoff;
var request_car_type;
var request_province;

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
})

$('#request-province').change(function () 
{
    $.ajax({
        type: 'GET',
        url: '/api/province-airport/' + request_province.val(),
        success: function (data) {
            if (data.provinceAirport) {
              to_airport_dropoff.val(data.provinceAirport.name);
              from_airport_pickup.val(data.provinceAirport.name);
            }
        }
    });
})
