$(document).ready(function() {
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
})
