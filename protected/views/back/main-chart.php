<script src="<?php echo Yii::app()->request->baseUrl; ?>/jslib/highcharts.js" type="text/javascript" charset="utf-8"></script>

<script>
    var cjson = <?php echo urldecode($chartJson); ?>//;
    $(document).ready(function() {
        $('.chart_container').highcharts({
            credits:false,
            legend:false,
            chart: {
                type: 'line',
                backgroundColor:"#f3f3f3"
            },
            title: {
                text: cjson.title
            },
            xAxis: {
                categories: cjson.categories
            },
            yAxis: {
                title: {
                    text: '订单数量'
                },
                min:0,
                plotLines: [{
                    value: 0,
                    width: 1,
                    color: '#808080'
                }]
            },
            tooltip: {
                enabled: true,
                formatter: function() {
                    return '<b>'+ this.x +'</b><br/>'+
                        '订单总计' +': '+ this.y;
                }
            },
            plotOptions: {
                line: {
                    dataLabels: {
                        enabled: true
                    },
                    enableMouseTracking: true
                }
            },
            series: [{
                data: cjson.datas
            }]
        });
    });
</script>
<div class="cLine sender_line chart_container">
</div>
