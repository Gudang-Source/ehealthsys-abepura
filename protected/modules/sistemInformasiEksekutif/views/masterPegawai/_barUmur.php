<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/amcharts/amcharts.js', CClientScript::POS_BEGIN); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/amcharts/serial.js', CClientScript::POS_BEGIN); ?>
<script>
    //========== BAR ========

    var chart_bar;
    var chartDataBar = <?= json_encode($dataBarChartUmur) ?>;
    AmCharts.ready(function () {
        // SERIAL CHART
        chart_bar = new AmCharts.AmSerialChart();
        chart_bar.dataProvider = chartDataBar;
        chart_bar.rotate = true;
        chart_bar.categoryField = "jenis";
        chart_bar.startDuration = 1;
        chart_bar.plotAreaBorderColor = "#DADADA";
        chart_bar.plotAreaBorderAlpha = 1;
		chart_bar.titles = [
            {
                "text": "Grafik Jumlah Pegawai Berdasarkan Kelompok Umur",
                "size": 15
            }
        ];
        // this single line makes the chart a bar chart
//                chart_bar.rotate = true;

        // AXES
        // Category
        var categoryAxis = chart_bar.categoryAxis;
        categoryAxis.gridPosition = "start";
        categoryAxis.gridAlpha = 0.1;
        categoryAxis.axisAlpha = 0;
        // Value
        var valueAxis = new AmCharts.ValueAxis();
        valueAxis.axisAlpha = 0;
        valueAxis.gridAlpha = 0.1;
        valueAxis.ignoreAxisWidth = true;
        valueAxis.labelFunction
                = function (value) {
                    return Math.abs(value);
                };
        chart_bar.addValueAxis(valueAxis);
        // GRAPHS
        // first graph
        var graph1 = new AmCharts.AmGraph();
        graph1.type = "column";
        graph1.clustered = false;
        graph1.title = "Laki - laki";
        graph1.valueField = "jumlah_l";
        graph1.balloonText = "[[title]]:[[value]]";
        graph1.lineAlpha = 0;
        graph1.fillColors = "#ADD981";
        graph1.fillAlphas = 1;
        graph1.labelFunction = function (item) {
            return Math.abs(item.values.value);
        };
        graph1.balloonFunction = function (item) {
            return item.category + ": " + Math.abs(item.values.value);
        };
        chart_bar.addGraph(graph1);
        // second graph
        var graph2 = new AmCharts.AmGraph();
        graph2.type = "column";
        graph2.clustered = false;
        graph2.title = "Perempuan";
        graph2.valueField = "jumlah_p";
        graph2.balloonText = "[[title]]:[[value]]";
        graph2.lineAlpha = 0;
        graph2.fillColors = "#81acd9";
        graph2.fillAlphas = 1;
        graph2.labelFunction = function (item) {
            return Math.abs(item.values.value);
        };
        graph2.balloonFunction = function (item) {
            return item.category + ": " + Math.abs(item.values.value);
        };
		var legend = new AmCharts.AmLegend();
        chart_bar.addLegend(legend);
		
        chart_bar.addGraph(graph2);
        chart_bar.creditsPosition = "top-right";
        // WRITE
        chart_bar.write("barUmur");
    });



</script>
<div class="white-container">
    <div id="barUmur" style="width:100%; height:400px;"></div>
</div>



