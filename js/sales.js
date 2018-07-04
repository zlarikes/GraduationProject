$(function () {
    $('#container').highcharts({
        chart: {
            type: 'area',
            inverted: true
        },
        title: {
            text: '销售量'
        },
        subtitle: {
            style: {
                position: 'absolute',
                right: '0px',
                bottom: '10px'
            }
        },
        legend: {
            layout: 'vertical',
            align: 'right',
            verticalAlign: 'top',
            x: -150,
            y: 100,
            floating: true,
            borderWidth: 1,
            backgroundColor: '#FFFFFF'
        },
        xAxis: {
            categories: [
                'Monday',
                'Tuesday',
                'Wednesday',
                'Thursday',
                'Friday',
                'Saturday',
                'Sunday'
            ]
        },
        yAxis: {
            title: {
                text: '销售量'
            },
            labels: {
                formatter: function() {
                    return this.value;
                }
            },
            min: 0
        },
        plotOptions: {
            area: {
                fillOpacity: 0.5
            }
        },
        series: [{
            name: 'waiter',
            data: [3, 4, 3, 5, 4, 10, 12]
        }, {
            name: 'customer',
            data: [1, 3, 4, 3, 3, 5, 4]
        }]
    });
});	