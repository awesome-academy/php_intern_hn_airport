var table_distiance;
var table_config;
var config_basic_id;

$(document).ready(function() {
    initVarible();   
    
    table_distiance.on('click', 'button.btn-distance-detail', function () {
        $('#modal-distance-detail').modal('show');
        let data = table_distiance.row($(this).parent()).data();
        let min = data[1].split(" ")[0];
        let max = data[2].split(" ")[0];
        $('#distance-id').val($(this).data('id'));
        $('#distance-min').val(min);
        $('#distance-max').val(max);
    });

    table_distiance.on('click', 'button.btn-distance-delete', function () {
        Swal.fire({
            title: 'Are you sure!',
            text: 'You are about to delete a config distance',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                let config_id = $(this).data('id');
                $.ajax({
                    type: 'DELETE',
                    url: `configs/${config_id}`,
                    success: function(data) {
                        Swal.fire({
                            icon: 'success',
                            title: data.title,
                            showConfirmButton: false,
                            timer: 1500
                        }).then((result) => {
                            window.location.reload();
                        });
                    },
                    error: function(data) {
                        Swal.fire({
                            icon: 'error',
                            title: data.message,
                            showConfirmButton: false,
                            timer: 1500
                        })
                    }
                })
            }
        });
    });

    table_config.on('click', 'button.btn-config-detail', function () {
        $('#modal-config-detail').modal('show');
        let data = table_config.row($(this).parent()).data();
        $('#detail-car-type').val(data[1]);
        $('#detail-min').val(data[2]);
        $('#detail-max').val(data[3]);
        let cost = data[4].split(" ")[0];
        $('#detail-cost').val(cost);
        config_basic_id = $(this).data('id');
    });
})

function initVarible() {
    table_config = $('#table-config-basic').DataTable();
    table_distiance = $('#table-distance-basic').DataTable();
}

$('#btn-detail').on("click", function() {
    $('#modal-detail').modal('show');
});

$('#btn-submit-update-distance').click(function() {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    let config_id = $('input[id="distance-id"]').val();
    let data = {
        min: $('input[id="distance-min"]').val(),
        max: $('input[id="distance-max"]').val(),
    };
    $.ajax({
        type: 'PUT',
        url: `configs/${config_id}?type=distance`,
        data: data,
        success: function(data) {
            Swal.fire({
                icon: 'success',
                title: data.title,
                showConfirmButton: false,
                timer: 1500
            }).then((result) => {
                window.location.reload();
            });
        },
        error: function(data) {
            let message = '';
            if (data.responseJSON) {
                message = data.responseJSON.message;
            } else {
                message = data.message;     
            }
            Swal.fire({
                icon: 'error',
                title: message,
                showConfirmButton: false,
                timer: 1500
            })
        },
    })
});

$('#btn-submit-update-config').click(function() {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    let data = {
        cost : $('input[id="detail-cost"]').val(),
        min: $('input[id="detail-min"]').val().split(" ")[0],
        max: $('input[id="detail-max"]').val().split(" ")[0],
    };
    $.ajax({
        type: 'PUT',
        url: `configs/${config_basic_id}?type=cost`,
        data: data,
        success: function(data) {
            Swal.fire({
                icon: 'success',
                title: data.title,
                showConfirmButton: false,
                timer: 1500
            }).then((result) => {
                window.location.reload();
            });
        },
        error: function(data) {
            let message = '';
            if (data.responseJSON) {
                message = data.responseJSON.message;
            } else {
                message = data.message;     
            }
            Swal.fire({
                icon: 'error',
                title: message,
                showConfirmButton: false,
                timer: 1500
            })
        },
    })
});