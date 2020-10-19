var table_distiance;
var table_config;

$(document).ready(function() {
    initVarible();   
    
    table_distiance.on('click', 'button.btn-distance-detail', function () {
        $('#modal-distance-detail').modal('show');
        let data = table_distiance.row($(this).parent()).data();
        let min = data[1].split(" ")[0];
        let max = data[2].split(" ")[0];
        $('#distance-min').val(min);
        $('#distance-max').val(max);
    });

    table_config.on('click', 'button.btn-config-detail', function () {
        $('#modal-config-detail').modal('show');
        let data = table_config.row($(this).parent()).data();
        $('#detail-car-type').val(data[1]);
        $('#detail-min').val(data[2]);
        $('#detail-max').val(data[3]);
        let cost = data[4].split(" ")[0];
        $('#detail-cost').val(cost);
    });
})

function initVarible() {
    table_config = $('#table-config-basic').DataTable();
    table_distiance = $('#table-distance-basic').DataTable();
}

$('#btn-detail').on("click", function() {
    $('#modal-detail').modal('show');
});
