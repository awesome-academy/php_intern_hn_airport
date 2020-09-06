var detail_id;

$(document).ready(function () 
{
    var table = $('#datatable').DataTable({
        processing: true,
        serverSide: true,
        ajax: '/',
        columns: [{
                data: 'number',
                name: 'id'
            },
            {
                data: 'provinces.name',
                name: 'province'
            },
            {
                data: 'DT_RowData.car_types',
                name: 'car_type'
            },
            {
                data: 'quantity',
                name: 'quantity'
            },
            {
                data: 'action',
                name: 'action'
            },
        ]
    });

    $('#datatable tbody').on('click', 'button.btn-detail', function () {
        var data = table.row($(this).parent()).data();
        detail_id = data.id;
        $('#detail-province').append(new Option(data.provinces.name, data.provinces.id, true));
        $('#detail-car-type').append(new Option(data.DT_RowData.car_types, data.car_types.id, true));
        $('#detail-quantity').val(data.quantity);
        $('#modal-detail').modal('toggle');
    });

    $('#datatable tbody').on('click', 'button.btn-delete', function () {
        var data = table.row($(this).parent()).data();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            type: 'DELETE',
            url: '/' + data.id,
            success: function(data) {
                Swal.fire({
                    icon: 'success',
                    title: data,
                    showConfirmButton: false,
                    timer: 1500
                }).then((result) => {
                    window.location.href = "/";  
                });
            },
            error: function(data) {
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

$('#modal-detail').on('hide.bs.modal', function () 
{
    $('#detail-province').children().remove();
    $('#detail-car-type').children().remove();
    $('#detail-quantity').val('');
})

$('#btn-submit-update').click(function(e) 
{
    e.preventDefault();
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    var province_id = $('#detail-province').val();
    var car_type_id = $('#detail-car-type').val();
    var quantity = $('#detail-quantity').val();

    var data = {
        province_id: province_id,
        car_type_id: car_type_id,
        quantity: quantity,
    }
    $.ajax({
        type: 'PUT',
        url: '/' + detail_id,
        data: data,
        success: function(data) {
            Swal.fire({
                icon: 'success',
                title: data,
                showConfirmButton: false,
                timer: 1500
            }).then((result) => {
                window.location.href = "/";  
            });
        },
        error: function(data) {
            var errors = data.responseJSON;
            if (errors.errors.quantity) {
                $('#error-quantity').text(errors.errors.quantity[0]);
            }
        }
    });
});
