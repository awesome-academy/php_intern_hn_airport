const {
    get
} = require("lodash")

$(document).ready(function () {

})

function monthlyChart() {
    $.ajax({
        type: 'get',
        url: '?type=monthly',
        success: function (data) {
            var monthlyChart = {
                labels: data[1],
                datasets: [{
                        label: data[0][0],
                        backgroundColor: 'rgba(60,141,188,0.9)',
                        borderColor: 'rgba(60,141,188,0.8)',
                        pointRadius: false,
                        pointColor: '#3b8bba',
                        pointStrokeColor: 'rgba(60,141,188,1)',
                        pointHighlightFill: '#fff',
                        pointHighlightStroke: 'rgba(60,141,188,1)',
                        data: data[2],
                    },
                    {
                        label: data[0][1],
                        backgroundColor: 'rgba(210, 214, 222, 1)',
                        borderColor: 'rgba(210, 214, 222, 1)',
                        pointRadius: false,
                        pointColor: 'rgba(210, 214, 222, 1)',
                        pointStrokeColor: '#c1c7d1',
                        pointHighlightFill: '#fff',
                        pointHighlightStroke: 'rgba(220,220,220,1)',
                        data: data[3],
                    },
                ]
            }
            var areaChartOptions = {
                maintainAspectRatio: false,
                responsive: true,
                datasetFill: false
            }

            // This will get the first returned node in the jQuery collection.
            var lineChartCanvas = $('#monthChart').get(0).getContext('2d')
            var lineChartOptions = jQuery.extend(true, {}, areaChartOptions)
            var lineChartData = jQuery.extend(true, {}, monthlyChart)
            lineChartData.datasets[0].fill = false;
            lineChartData.datasets[1].fill = false;
            lineChartOptions.datasetFill = false

            var lineChart = new Chart(lineChartCanvas, {
                type: 'line',
                data: lineChartData,
                options: lineChartOptions
            })
        }
    })
}

function yearlyChart() {
    $.ajax({
        type: 'get',
        url: '?type=yearly',
        success: function (data) {
            var areaChartData = {
                labels: data[1],
                datasets: [{
                        label: data[0][0],
                        backgroundColor: 'rgba(60,141,188,0.9)',
                        borderColor: 'rgba(60,141,188,0.8)',
                        pointRadius: false,
                        pointColor: '#3b8bba',
                        pointStrokeColor: 'rgba(60,141,188,1)',
                        pointHighlightFill: '#fff',
                        pointHighlightStroke: 'rgba(60,141,188,1)',
                        data: data[2]
                    },
                    {
                        label: data[0][1],
                        backgroundColor: 'rgba(210, 214, 222, 1)',
                        borderColor: 'rgba(210, 214, 222, 1)',
                        pointRadius: false,
                        pointColor: 'rgba(210, 214, 222, 1)',
                        pointStrokeColor: '#c1c7d1',
                        pointHighlightFill: '#fff',
                        pointHighlightStroke: 'rgba(220,220,220,1)',
                        data: data[3]
                    },
                ]
            }

            // This will get the first returned node in the jQuery collection.
            var barChartCanvas = $('#yearChart').get(0).getContext('2d')
            var barChartData = jQuery.extend(true, {}, areaChartData)
            var temp0 = areaChartData.datasets[0]
            var temp1 = areaChartData.datasets[1]
            barChartData.datasets[0] = temp1
            barChartData.datasets[1] = temp0

            var barChartOptions = {
                responsive: true,
                maintainAspectRatio: false,
                datasetFill: false
            }

            var barChart = new Chart(barChartCanvas, {
                type: 'bar',
                data: barChartData,
                options: barChartOptions
            })
        },
        error: function (data) {

        },
    })
}

$('#btn-montly-chart').click(monthlyChart());

$('#btn-yearly-chart').click(yearlyChart());
