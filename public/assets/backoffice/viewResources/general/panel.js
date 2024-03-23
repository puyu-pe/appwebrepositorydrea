$(function () {
    'use strict';
    var salesChartCanvas = $('#salesChart').get(0).getContext('2d');
    var salesChart = new Chart(salesChartCanvas);
    var salesChartData = {
        labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
        datasets: [{
            label: 'Electronics',
            fillColor: 'rgb(210, 214, 222)',
            strokeColor: 'rgb(210, 214, 222)',
            pointColor: 'rgb(210, 214, 222)',
            pointStrokeColor: '#c1c7d1',
            pointHighlightFill: '#fff',
            pointHighlightStroke: 'rgb(220,220,220)',
            data: [65, 59, 80, 81, 56, 55, 40]
        }, {
            label: 'Digital Goods',
            fillColor: 'rgba(60,141,188,0.9)',
            strokeColor: 'rgba(60,141,188,0.8)',
            pointColor: '#3b8bba',
            pointStrokeColor: 'rgba(60,141,188,1)',
            pointHighlightFill: '#fff',
            pointHighlightStroke: 'rgba(60,141,188,1)',
            data: [28, 48, 40, 19, 86, 27, 90]
        }]
    };
    var salesChartOptions = {
        showScale: true,
        scaleShowGridLines: false,
        scaleGridLineColor: 'rgba(0,0,0,.05)',
        scaleGridLineWidth: 1,
        scaleShowHorizontalLines: true,
        scaleShowVerticalLines: true,
        bezierCurve: true,
        bezierCurveTension: 0.3,
        pointDot: false,
        pointDotRadius: 4,
        pointDotStrokeWidth: 1,
        pointHitDetectionRadius: 20,
        datasetStroke: true,
        datasetStrokeWidth: 2,
        datasetFill: true,
        legendTemplate: '<ul class=\'<%=name.toLowerCase()%>-legend\'><% for (var i=0; i<datasets.length; i++){%><li><span style=\'background-color:<%=datasets[i].lineColor%>\'></span><%=datasets[i].label%></li><%}%></ul>',
        maintainAspectRatio: true,
        responsive: true
    };
    salesChart.Line(salesChartData, salesChartOptions);

    getTotals();

    getTopMostViewed();

    generateSubjectChart();
});

function getTotals() {
    $.ajax({
        url: BASE_URL + '/panel/totals',
        type: 'GET',
        dataType: 'json',
        success: function (data) {
            console.log(data);
            $("#total_exam").html(data.total_exam + " Evaluaciones");
            $("#total_exam_public").html(data.total_exam_public + " Evaluaciones");
            $("#total_exam_hidden").html(data.total_exam_hidden + " Evaluaciones");
        },
        error: function (xhr, status, error) {
            console.error(xhr.responseText);
        }
    });
}

function getTopMostViewed() {
    $.ajax({
        url: BASE_URL + '/panel/topMostViewed',
        type: 'GET',
        dataType: 'json',
        success: function (data) {
            console.log(data);

        },
        error: function (xhr, status, error) {
            console.error(xhr.responseText);
        }
    });
}

function generateSubjectChart() {
    $.ajax({
        url: BASE_URL + '/panel/totalsBySubject',
        type: 'GET',
        dataType: 'json',
        success: function (pieData) {
            console.log(pieData);
            var pieChartCanvas = $('#pieChart').get(0).getContext('2d');
            var pieChart = new Chart(pieChartCanvas);
            var pieOptions = {
                legend: {
                    display: true,
                    position: 'bottom',
                    labels: {
                        fontColor: '#333',
                        boxWidth: 20
                    }
                },
                segmentShowStroke: true,
                segmentStrokeColor: '#fff',
                segmentStrokeWidth: 1,
                percentageInnerCutout: 50,
                animationSteps: 100,
                animationEasing: 'easeOutBounce',
                animateRotate: true,
                animateScale: false,
                responsive: true,
                maintainAspectRatio: false,
                tooltipTemplate: '<%=label%> <%=value %>',
                tooltips: {
                    callbacks: {
                        label: function (tooltipItem, data) {
                            var dataset = data.datasets[tooltipItem.datasetIndex];
                            var total = dataset.data.reduce(function (previousValue, currentValue, currentIndex, array) {
                                return previousValue + currentValue;
                            });
                            var currentValue = dataset.data[tooltipItem.index];
                            var percentage = Math.round((currentValue / total) * 100);
                            return data.labels[tooltipItem.index] + ': ' + currentValue + ' (' + percentage + '%)';
                        }
                    }
                }
            };
            pieChart.Doughnut(pieData, pieOptions);

            completeLabels(pieData);
        },
        error: function (xhr, status, error) {
            console.error(xhr.responseText);
        }
    });
}

function completeLabels(data) {
    var legendContainer = $('.chart-legend');
    legendContainer.empty();

    data.forEach(function (item) {
        var listItem = $('<li>').html('<i class="fa fa-circle-o" style="color:' + item.color + '"></i> ' + item.label + ' (' + item.value + ')');
        legendContainer.append(listItem);
    });
}
