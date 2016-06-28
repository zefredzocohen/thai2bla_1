<!DOCTYPE HTML>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<title>Biểu đồ</title>
       <script src="http://code.highcharts.com/highcharts.js"></script>
        <script src="http://code.highcharts.com/modules/exporting.js"></script>
        <style type="text/css">
                body{
                    margin-top: 30px;
                }
                .border{
                    width: 100%;
                    border: 1px solid #787878;
                     padding: 10px;
                     margin-top: 10px;
                }
*, *:before, *:after {
    -moz-box-sizing: border-box;
    -webkit-box-sizing: border-box; 

}
       
.container {
    padding-right: 15px;
    padding-left: 15px;
    margin-right: auto;
    margin-left: auto
}
.container:before, .container:after {
    display: table;
    content: " "
}
.container:after {
    clear: both
}
.container:before, .container:after {
    display: table;
    content: " "
}
.container:after {
    clear: both
}
.row {
    /*margin-right: -15px;
    margin-left: -15px*/
    margin:0;
}
.row:before, .row:after {
    display: table;
    content: " "
}
.row:after {
    clear: both
}
.row:before, .row:after {
    display: table;
    content: " "
}
.row:after {
    clear: both
}
.col-xs-1, .col-sm-1, .col-md-1, .col-lg-1, .col-xs-2, .col-sm-2, .col-md-2, .col-lg-2, .col-xs-3, .col-sm-3, .col-md-3, .col-lg-3, .col-xs-4, .col-sm-4, .col-md-4, .col-lg-4, .col-xs-5, .col-sm-5, .col-md-5, .col-lg-5, .col-xs-6, .col-sm-6, .col-md-6, .col-lg-6, .col-xs-7, .col-sm-7, .col-md-7, .col-lg-7, .col-xs-8, .col-sm-8, .col-md-8, .col-lg-8, .col-xs-9, .col-sm-9, .col-md-9, .col-lg-9, .col-xs-10, .col-sm-10, .col-md-10, .col-lg-10, .col-xs-11, .col-sm-11, .col-md-11, .col-lg-11, .col-xs-12, .col-sm-12, .col-md-12, .col-lg-12 {
    position: relative;
    min-height: 1px;
    padding-right: 15px;
    padding-left: 15px
}
.col-xs-1, .col-xs-2, .col-xs-3, .col-xs-4, .col-xs-5, .col-xs-6, .col-xs-7, .col-xs-8, .col-xs-9, .col-xs-10, .col-xs-11 {
    float: left
}
.col-xs-12 {
    width: 100%
}
.col-xs-11 {
    width: 91.66666666666666%
}
.col-xs-10 {
    width: 83.33333333333334%
}
.col-xs-9 {
    width: 75%
}
.col-xs-8 {
    width: 66.66666666666666%
}
.col-xs-7 {
    width: 58.333333333333336%
}
.col-xs-6 {
    width: 50%
}
.col-xs-5 {
    width: 41.66666666666667%
}
.col-xs-4 {
    width: 33.33333333333333%
}
.col-xs-3 {
    width: 25%
}
.col-xs-2 {
    width: 16.666666666666664%
}
.col-xs-1 {
    width: 8.333333333333332%
}
.col-xs-pull-12 {
    right: 100%
}
.col-xs-pull-11 {
    right: 91.66666666666666%
}
.col-xs-pull-10 {
    right: 83.33333333333334%
}
.col-xs-pull-9 {
    right: 75%
}
.col-xs-pull-8 {
    right: 66.66666666666666%
}
.col-xs-pull-7 {
    right: 58.333333333333336%
}
.col-xs-pull-6 {
    right: 50%
}
.col-xs-pull-5 {
    right: 41.66666666666667%
}
.col-xs-pull-4 {
    right: 33.33333333333333%
}
.col-xs-pull-3 {
    right: 25%
}
.col-xs-pull-2 {
    right: 16.666666666666664%
}
.col-xs-pull-1 {
    right: 8.333333333333332%
}
.col-xs-push-12 {
    left: 100%
}
.col-xs-push-11 {
    left: 91.66666666666666%
}
.col-xs-push-10 {
    left: 83.33333333333334%
}
.col-xs-push-9 {
    left: 75%
}
.col-xs-push-8 {
    left: 66.66666666666666%
}
.col-xs-push-7 {
    left: 58.333333333333336%
}
.col-xs-push-6 {
    left: 50%
}
.col-xs-push-5 {
    left: 41.66666666666667%
}
.col-xs-push-4 {
    left: 33.33333333333333%
}
.col-xs-push-3 {
    left: 25%
}
.col-xs-push-2 {
    left: 16.666666666666664%
}
.col-xs-push-1 {
    left: 8.333333333333332%
}
.col-xs-offset-12 {
    margin-left: 100%
}
.col-xs-offset-11 {
    margin-left: 91.66666666666666%
}
.col-xs-offset-10 {
    margin-left: 83.33333333333334%
}
.col-xs-offset-9 {
    margin-left: 75%
}
.col-xs-offset-8 {
    margin-left: 66.66666666666666%
}
.col-xs-offset-7 {
    margin-left: 58.333333333333336%
}
.col-xs-offset-6 {
    margin-left: 50%
}
.col-xs-offset-5 {
    margin-left: 41.66666666666667%
}
.col-xs-offset-4 {
    margin-left: 33.33333333333333%
}
.col-xs-offset-3 {
    margin-left: 25%
}
.col-xs-offset-2 {
    margin-left: 16.666666666666664%
}
.col-xs-offset-1 {
    margin-left: 8.333333333333332%
}
@media(min-width:768px) {
.container {
    width: 750px
}
.col-sm-1, .col-sm-2, .col-sm-3, .col-sm-4, .col-sm-5, .col-sm-6, .col-sm-7, .col-sm-8, .col-sm-9, .col-sm-10, .col-sm-11 {
    float: left
}
.col-sm-12 {
    width: 100%
}
.col-sm-11 {
    width: 91.66666666666666%
}
.col-sm-10 {
    width: 83.33333333333334%
}
.col-sm-9 {
    width: 75%
}
.col-sm-8 {
    width: 66.66666666666666%
}
.col-sm-7 {
    width: 58.333333333333336%
}
.col-sm-6 {
    width: 50%
}
.col-sm-5 {
    width: 41.66666666666667%
}
.col-sm-4 {
    width: 33.33333333333333%
}
.col-sm-3 {
    width: 25%
}
.col-sm-2 {
    width: 16.666666666666664%
}
.col-sm-1 {
    width: 8.333333333333332%
}
.col-sm-pull-12 {
    right: 100%
}
.col-sm-pull-11 {
    right: 91.66666666666666%
}
.col-sm-pull-10 {
    right: 83.33333333333334%
}
.col-sm-pull-9 {
    right: 75%
}
.col-sm-pull-8 {
    right: 66.66666666666666%
}
.col-sm-pull-7 {
    right: 58.333333333333336%
}
.col-sm-pull-6 {
    right: 50%
}
.col-sm-pull-5 {
    right: 41.66666666666667%
}
.col-sm-pull-4 {
    right: 33.33333333333333%
}
.col-sm-pull-3 {
    right: 25%
}
.col-sm-pull-2 {
    right: 16.666666666666664%
}
.col-sm-pull-1 {
    right: 8.333333333333332%
}
.col-sm-push-12 {
    left: 100%
}
.col-sm-push-11 {
    left: 91.66666666666666%
}
.col-sm-push-10 {
    left: 83.33333333333334%
}
.col-sm-push-9 {
    left: 75%
}
.col-sm-push-8 {
    left: 66.66666666666666%
}
.col-sm-push-7 {
    left: 58.333333333333336%
}
.col-sm-push-6 {
    left: 50%
}
.col-sm-push-5 {
    left: 41.66666666666667%
}
.col-sm-push-4 {
    left: 33.33333333333333%
}
.col-sm-push-3 {
    left: 25%
}
.col-sm-push-2 {
    left: 16.666666666666664%
}
.col-sm-push-1 {
    left: 8.333333333333332%
}
.col-sm-offset-12 {
    margin-left: 100%
}
.col-sm-offset-11 {
    margin-left: 91.66666666666666%
}
.col-sm-offset-10 {
    margin-left: 83.33333333333334%
}
.col-sm-offset-9 {
    margin-left: 75%
}
.col-sm-offset-8 {
    margin-left: 66.66666666666666%
}
.col-sm-offset-7 {
    margin-left: 58.333333333333336%
}
.col-sm-offset-6 {
    margin-left: 50%
}
.col-sm-offset-5 {
    margin-left: 41.66666666666667%
}
.col-sm-offset-4 {
    margin-left: 33.33333333333333%
}
.col-sm-offset-3 {
    margin-left: 25%
}
.col-sm-offset-2 {
    margin-left: 16.666666666666664%
}
.col-sm-offset-1 {
    margin-left: 8.333333333333332%
}
}
@media(min-width:992px) {
.container {
    width: 970px
}
.col-md-1, .col-md-2, .col-md-3, .col-md-4, .col-md-5, .col-md-6, .col-md-7, .col-md-8, .col-md-9, .col-md-10, .col-md-11 {
    float: left
}
.col-md-12 {
    width: 100%
}
.col-md-11 {
    width: 91.66666666666666%
}
.col-md-10 {
    width: 83.33333333333334%
}
.col-md-9 {
    width: 75%
}
.col-md-8 {
    width: 66.66666666666666%
}
.col-md-7 {
    width: 58.333333333333336%
}
.col-md-6 {
    width: 50%
}
.col-md-5 {
    width: 41.66666666666667%
}
.col-md-4 {
    width: 33.33333333333333%
}
.col-md-3 {
    width: 25%
}
.col-md-2 {
    width: 16.666666666666664%
}
.col-md-1 {
    width: 8.333333333333332%
}
.col-md-pull-12 {
    right: 100%
}
.col-md-pull-11 {
    right: 91.66666666666666%
}
.col-md-pull-10 {
    right: 83.33333333333334%
}
.col-md-pull-9 {
    right: 75%
}
.col-md-pull-8 {
    right: 66.66666666666666%
}
.col-md-pull-7 {
    right: 58.333333333333336%
}
.col-md-pull-6 {
    right: 50%
}
.col-md-pull-5 {
    right: 41.66666666666667%
}
.col-md-pull-4 {
    right: 33.33333333333333%
}
.col-md-pull-3 {
    right: 25%
}
.col-md-pull-2 {
    right: 16.666666666666664%
}
.col-md-pull-1 {
    right: 8.333333333333332%
}
.col-md-push-12 {
    left: 100%
}
.col-md-push-11 {
    left: 91.66666666666666%
}
.col-md-push-10 {
    left: 83.33333333333334%
}
.col-md-push-9 {
    left: 75%
}
.col-md-push-8 {
    left: 66.66666666666666%
}
.col-md-push-7 {
    left: 58.333333333333336%
}
.col-md-push-6 {
    left: 50%
}
.col-md-push-5 {
    left: 41.66666666666667%
}
.col-md-push-4 {
    left: 33.33333333333333%
}
.col-md-push-3 {
    left: 25%
}
.col-md-push-2 {
    left: 16.666666666666664%
}
.col-md-push-1 {
    left: 8.333333333333332%
}
.col-md-offset-12 {
    margin-left: 100%
}
.col-md-offset-11 {
    margin-left: 91.66666666666666%
}
.col-md-offset-10 {
    margin-left: 83.33333333333334%
}
.col-md-offset-9 {
    margin-left: 75%
}
.col-md-offset-8 {
    margin-left: 66.66666666666666%
}
.col-md-offset-7 {
    margin-left: 58.333333333333336%
}
.col-md-offset-6 {
    margin-left: 50%
}
.col-md-offset-5 {
    margin-left: 41.66666666666667%
}
.col-md-offset-4 {
    margin-left: 33.33333333333333%
}
.col-md-offset-3 {
    margin-left: 25%
}
.col-md-offset-2 {
    margin-left: 16.666666666666664%
}
.col-md-offset-1 {
    margin-left: 8.333333333333332%
}
}
@media(min-width:1200px) {
.container {
    width: 1170px
}
.col-lg-1, .col-lg-2, .col-lg-3, .col-lg-4, .col-lg-5, .col-lg-6, .col-lg-7, .col-lg-8, .col-lg-9, .col-lg-10, .col-lg-11 {
    float: left
}
.col-lg-12 {
    width: 100%
}
.col-lg-11 {
    width: 91.66666666666666%
}
.col-lg-10 {
    width: 83.33333333333334%
}
.col-lg-9 {
    width: 75%
}
.col-lg-8 {
    width: 66.66666666666666%
}
.col-lg-7 {
    width: 58.333333333333336%
}
.col-lg-6 {
    width: 50%
}
.col-lg-5 {
    width: 41.66666666666667%
}
.col-lg-4 {
    width: 33.33333333333333%
}
.col-lg-3 {
    width: 25%
}
.col-lg-2 {
    width: 16.666666666666664%
}
.col-lg-1 {
    width: 8.333333333333332%
}
.col-lg-pull-12 {
    right: 100%
}
.col-lg-pull-11 {
    right: 91.66666666666666%
}
.col-lg-pull-10 {
    right: 83.33333333333334%
}
.col-lg-pull-9 {
    right: 75%
}
.col-lg-pull-8 {
    right: 66.66666666666666%
}
.col-lg-pull-7 {
    right: 58.333333333333336%
}
.col-lg-pull-6 {
    right: 50%
}
.col-lg-pull-5 {
    right: 41.66666666666667%
}
.col-lg-pull-4 {
    right: 33.33333333333333%
}
.col-lg-pull-3 {
    right: 25%
}
.col-lg-pull-2 {
    right: 16.666666666666664%
}
.col-lg-pull-1 {
    right: 8.333333333333332%
}
.col-lg-push-12 {
    left: 100%
}
.col-lg-push-11 {
    left: 91.66666666666666%
}
.col-lg-push-10 {
    left: 83.33333333333334%
}
.col-lg-push-9 {
    left: 75%
}
.col-lg-push-8 {
    left: 66.66666666666666%
}
.col-lg-push-7 {
    left: 58.333333333333336%
}
.col-lg-push-6 {
    left: 50%
}
.col-lg-push-5 {
    left: 41.66666666666667%
}
.col-lg-push-4 {
    left: 33.33333333333333%
}
.col-lg-push-3 {
    left: 25%
}
.col-lg-push-2 {
    left: 16.666666666666664%
}
.col-lg-push-1 {
    left: 8.333333333333332%
}
.col-lg-offset-12 {
    margin-left: 100%
}
.col-lg-offset-11 {
    margin-left: 91.66666666666666%
}
.col-lg-offset-10 {
    margin-left: 83.33333333333334%
}
.col-lg-offset-9 {
    margin-left: 75%
}
.col-lg-offset-8 {
    margin-left: 66.66666666666666%
}
.col-lg-offset-7 {
    margin-left: 58.333333333333336%
}
.col-lg-offset-6 {
    margin-left: 50%
}
.col-lg-offset-5 {
    margin-left: 41.66666666666667%
}
.col-lg-offset-4 {
    margin-left: 33.33333333333333%
}
.col-lg-offset-3 {
    margin-left: 25%
}
.col-lg-offset-2 {
    margin-left: 16.666666666666664%
}
.col-lg-offset-1 {
    margin-left: 8.333333333333332%
}
        </style>
<script type="text/javascript">

$(function () {
    $(document).ready(function() {
        Highcharts.setOptions({
            global: {
                useUTC: false
            }
        });
    
        var chart;
        $('#chart1').highcharts({
            chart: {
                type: 'spline',
                animation: Highcharts.svg, // don't animate in old IE
                marginRight: 10,
                events: {
                    load: function() {
    
                        // set up the updating of the chart each second
                        var series = this.series[0];
                        setInterval(function() {
                            var x = (new Date()).getTime(), // current time
                                y = Math.random();
                            series.addPoint([x, y], true, true);
                        }, 1000);
                    }
                }
            },
            title: {
                text: 'Doanh số bán hành theo giờ'
            },
            xAxis: {
                type: 'datetime',
                tickPixelInterval: 150
            },
            yAxis: {
                title: {
                    text: 'Giá trị'
                },
                plotLines: [{
                    value: 0,
                    width: 1,
                    color: '#808080'
                }]
            },
            tooltip: {
                formatter: function() {
                        return '<b>'+ this.series.name +'</b><br/>'+
                        Highcharts.dateFormat('%Y-%m-%d %H:%M:%S', this.x) +'<br/>'+
                        Highcharts.numberFormat(this.y, 2);
                }
            },
            legend: {
                enabled: false
            },
            exporting: {
                enabled: false
            },
            series: [{
                name: 'Random data',
                data: (function() {
                    // generate an array of random data
                    var data = [],
                        time = (new Date()).getTime(),
                        i;
    
                    for (i = -19; i <= 0; i++) {
                        data.push({
                            x: time + i * 1000,
                            y: Math.random()
                        });
                    }
                    return data;
                })()
            }]
        });
    });
/*END Chart1*/
   $('#chart2').highcharts({
            chart: {
                type: 'spline'
            },
            title: {
                text: 'Dòng tiền theo năm'
            },
            // subtitle: {
            //     text: 'Irregular time data in Highcharts JS'
            // },
            xAxis: {
                type: 'datetime',
                dateTimeLabelFormats: { // don't display the dummy year
                    month: '%e. %b',
                    year: '%b'
                }
            },
            yAxis: {
                title: {
                    text: 'Dòng tiền theo năm'
                },
                min: 0
            },
            tooltip: {
                formatter: function() {
                        return '<b>'+ this.series.name +'</b><br/>'+
                        Highcharts.dateFormat('%e. %b', this.x) +': '+ this.y +' m';
                }
            },
            
            series: [{
                name: 'Năm 2007-2008',
                // Define the data points. All series have a dummy year
                // of 1970/71 in order to be compared on the same x axis. Note
                // that in JavaScript, months start at 0 for January, 1 for February etc.
                data: [
                    [Date.UTC(1970,  9, 27), 0   ],
                    [Date.UTC(1970, 10, 10), 0.6 ],
                    [Date.UTC(1970, 10, 18), 0.7 ],
                    [Date.UTC(1970, 11,  2), 0.8 ],
                    [Date.UTC(1970, 11,  9), 0.6 ],
                    [Date.UTC(1970, 11, 16), 0.6 ],
                    [Date.UTC(1970, 11, 28), 0.67],
                    [Date.UTC(1971,  0,  1), 0.81],
                    [Date.UTC(1971,  0,  8), 0.78],
                    [Date.UTC(1971,  0, 12), 0.98],
                    [Date.UTC(1971,  0, 27), 1.84],
                    [Date.UTC(1971,  1, 10), 1.80],
                    [Date.UTC(1971,  1, 18), 1.80],
                    [Date.UTC(1971,  1, 24), 1.92],
                    [Date.UTC(1971,  2,  4), 2.49],
                    [Date.UTC(1971,  2, 11), 2.79],
                    [Date.UTC(1971,  2, 15), 2.73],
                    [Date.UTC(1971,  2, 25), 2.61],
                    [Date.UTC(1971,  3,  2), 2.76],
                    [Date.UTC(1971,  3,  6), 2.82],
                    [Date.UTC(1971,  3, 13), 2.8 ],
                    [Date.UTC(1971,  4,  3), 2.1 ],
                    [Date.UTC(1971,  4, 26), 1.1 ],
                    [Date.UTC(1971,  5,  9), 0.25],
                    [Date.UTC(1971,  5, 12), 0   ]
                ]
            }, {
                name: 'Năm 2008-2009',
                data: [
                    [Date.UTC(1970,  9, 18), 0   ],
                    [Date.UTC(1970,  9, 26), 0.2 ],
                    [Date.UTC(1970, 11,  1), 0.47],
                    [Date.UTC(1970, 11, 11), 0.55],
                    [Date.UTC(1970, 11, 25), 1.38],
                    [Date.UTC(1971,  0,  8), 1.38],
                    [Date.UTC(1971,  0, 15), 1.38],
                    [Date.UTC(1971,  1,  1), 1.38],
                    [Date.UTC(1971,  1,  8), 1.48],
                    [Date.UTC(1971,  1, 21), 1.5 ],
                    [Date.UTC(1971,  2, 12), 1.89],
                    [Date.UTC(1971,  2, 25), 2.0 ],
                    [Date.UTC(1971,  3,  4), 1.94],
                    [Date.UTC(1971,  3,  9), 1.91],
                    [Date.UTC(1971,  3, 13), 1.75],
                    [Date.UTC(1971,  3, 19), 1.6 ],
                    [Date.UTC(1971,  4, 25), 0.6 ],
                    [Date.UTC(1971,  4, 31), 0.35],
                    [Date.UTC(1971,  5,  7), 0   ]
                ]
            }, {
                name: 'Năm 2009-2010',
                data: [
                    [Date.UTC(1970,  9,  9), 0   ],
                    [Date.UTC(1970,  9, 14), 0.15],
                    [Date.UTC(1970, 10, 28), 0.35],
                    [Date.UTC(1970, 11, 12), 0.46],
                    [Date.UTC(1971,  0,  1), 0.59],
                    [Date.UTC(1971,  0, 24), 0.58],
                    [Date.UTC(1971,  1,  1), 0.62],
                    [Date.UTC(1971,  1,  7), 0.65],
                    [Date.UTC(1971,  1, 23), 0.77],
                    [Date.UTC(1971,  2,  8), 0.77],
                    [Date.UTC(1971,  2, 14), 0.79],
                    [Date.UTC(1971,  2, 24), 0.86],
                    [Date.UTC(1971,  3,  4), 0.8 ],
                    [Date.UTC(1971,  3, 18), 0.94],
                    [Date.UTC(1971,  3, 24), 0.9 ],
                    [Date.UTC(1971,  4, 16), 0.39],
                    [Date.UTC(1971,  4, 21), 0   ]
                ]
            }]
        });
/*end 2*/
    $('#chart3').highcharts({
            chart: {
                zoomType: 'xy'
            },
            title: {
                text: 'Tỷ lệ biến đổi nhân sự'
            },
           /* // subtitle: {
            //     text: 'Source: WorldClimate.com'
            // },*/
            xAxis: [{
                categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun',
                    'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']
            }],
            yAxis: [{ // Primary yAxis
                labels: {
                    format: '{value}°C',
                    style: {
                        color: '#89A54E'
                    }
                },
                title: {
                    text: 'Nhiệt độ',
                    style: {
                        color: '#89A54E'
                    }
                }
            }, { // Secondary yAxis
                title: {
                    text: 'Lượng mưa',
                    style: {
                        color: '#4572A7'
                    }
                },
                labels: {
                    format: '{value} mm',
                    style: {
                        color: '#4572A7'
                    }
                },
                opposite: true
            }],
            tooltip: {
                shared: true
            },
            legend: {
                layout: 'vertical',
                align: 'left',
                x: 120,
                verticalAlign: 'top',
                y: 100,
                floating: true,
                backgroundColor: '#FFFFFF'
            },
            series: [{
                name: 'Lượng mưa',
                color: '#4572A7',
                type: 'column',
                yAxis: 1,
                data: [49.9, 71.5, 106.4, 129.2, 144.0, 176.0, 135.6, 148.5, 216.4, 194.1, 95.6, 54.4],
                tooltip: {
                    valueSuffix: ' mm'
                }
    
            }, {
                name: 'Nhiệt độ',
                color: '#89A54E',
                type: 'spline',
                data: [7.0, 6.9, 9.5, 14.5, 18.2, 21.5, 25.2, 26.5, 23.3, 18.3, 13.9, 9.6],
                tooltip: {
                    valueSuffix: '°C'
                }
            }]
        });
/*end chart3*/
     // Radialize the colors
        Highcharts.getOptions().colors = Highcharts.map(Highcharts.getOptions().colors, function(color) {
            return {
                radialGradient: { cx: 0.5, cy: 0.3, r: 0.7 },
                stops: [
                    [0, color],
                    [1, Highcharts.Color(color).brighten(-0.3).get('rgb')] // darken
                ]
            };
        });
        
        // Build the chart
        $('#chart4').highcharts({
            chart: {
                plotBackgroundColor: null,
                plotBorderWidth: null,
                plotShadow: false
            },
            title: {
                text: 'Tỷ lệ trình độ'
            },
            tooltip: {
                pointFormat: '{series.name}: <b>{point.percentage:.2f}%</b>'
            },
            plotOptions: {
                pie: {
                    allowPointSelect: true,
                    cursor: 'pointer',
                    dataLabels: {
                        enabled: true,
                        color: '#000000',
                        connectorColor: '#000000',
                        formatter: function() {
                            return '<b>'+ this.point.name +'</b>: '+ this.percentage +' %';
                        }
                    }
                }
            },
            series: [{
                type: 'pie',
                name: 'Trình độ học vấn',
                data: [
                    ['12/12',   45.0],
                    ['CĐ - ĐH',       26.8],
                    {
                        name: 'Học vấn',
                        y: 12.8,
                        sliced: true,
                        selected: true
                    },
                    ['Đại học',    8.5],
                    
                    ['Others',   0.7]
                ]
            }]
        });

});
</script>
	</head>
	<body>
    <div class="container">
        <div class="col-md-6">
             <div class="border">
                 <div id="chart1" style="min-width: 320px; height: 320px; margin: 0 auto"></div>
             </div>
        </div>
        <div class="col-md-6">
             <div class="border">
                 <div id="chart2" style="min-width: 320px; height: 320px; margin: 0 auto"></div>
             </div>
        </div>
        <div class="col-md-6">
              <div class="border">
                 <div id="chart3" style="min-width: 320px; height: 320px; margin: 0 auto"></div>
             </div>
        </div>
        <div class=" col-md-6">
               <div class="border">
                 <div id="chart4" style="min-width: 320px; height: 320px; margin: 0 auto"></div>
             </div>
        </div>
</div>

