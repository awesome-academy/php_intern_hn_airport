$(document).ready(function () {
    $.fn.dataTable.ext.errMode = 'none';

    var table_request_new = $('#table-request-new').DataTable({
        processing: true,
        serverSide: true,
        ajax: '/requests?type=new',
        columns: [{
                data: 'DT_RowIndex'
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
                data: 'DT_RowData.budget'
            },
            {
                data: 'action'
            },
        ]
    });

    var table_contract_new = $('#table-contract-new').DataTable({
        processing: true,
        serverSide: true,
        ajax: '/contracts?type=new',
        columns: [{
                data: 'DT_RowIndex'
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
                data: 'DT_RowData.budget'
            },
            {
                data: 'action'
            },
        ]
    });

    var table_contract_cancel = $('#table-contract-cancel').DataTable({
        processing: true,
        serverSide: true,
        ajax: '/contracts?type=cancel',
        columns: [{
                data: 'DT_RowIndex'
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
                data: 'DT_RowData.budget'
            },
            {
                data: 'action'
            },
        ]
    });

    $('#table-contract-new').on('click', 'button.btn-delete-contract', function () {
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                var data = table_contract_new.row($(this).parent()).data();
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    type: 'DELETE',
                    url: '/contracts/' + data.id,
                    success: function (data) {
                        Swal.fire({
                            icon: 'success',
                            title: data,
                            showConfirmButton: false,
                            timer: 1500
                        }).then((result) => {
                            window.location.href = "/contracts";
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
            }
        })
    });
})

$('#driver-avatar').click(function () {
    $('input[name=avatar]').click();
});

$('input[name=avatar]').change(function (e) {
    var file = this.files[0];
    var reader = new FileReader();
    reader.onload = function () {
        $('#driver-avatar').attr('src', this.result);
    };
    reader.readAsDataURL(file);
});
