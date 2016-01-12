<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/amcharts/amcharts.js', CClientScript::POS_BEGIN); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/amcharts/serial.js', CClientScript::POS_BEGIN); ?>
<script>
    var chart_line;

    var chartDataStacked = <?= json_encode($dataBarLineChart) ?>;
    var models = <?= json_encode($model) ?>;

    AmCharts.ready(function () {
        // generate some random data first

        // SERIAL CHART
        chart_stacked = new AmCharts.AmSerialChart();

        chart_stacked.dataProvider = chartDataStacked;
        chart_stacked.categoryField = "periode";
		chart_stacked.plotAreaBorderAlpha = 0;
        chart_stacked.marginLeft = 0;
        chart_stacked.marginBottom = 0;
        chart_stacked.startDuration = 1;
        chart_stacked.dataDateFormat = "YYYY-MM-DD JJ:NN:SS";
      

        // AXES
        // category
        var categoryAxis = chart_stacked.categoryAxis;
		categoryAxis.startOnAxis = true;
        categoryAxis.axisColor = "#DADADA";
        categoryAxis.gridAlpha = 0.07;
        categoryAxis.parseDates = true; // as our data is date-based, we set parseDates to true
        if (models.jns_periode == "hari") {
            categoryAxis.minPeriod = "DD"; // our data is daily, so we set minPeriod to DD
        }
        if (models.jns_periode == "bulan") {
            categoryAxis.minPeriod = "MM"; // our data is daily, so we set minPeriod to DD
        }
        if (models.jns_periode == "tahun") {
            categoryAxis.minPeriod = "YYYY"; // our data is daily, so we set minPeriod to DD
        }
        categoryAxis.minorGridEnabled = true;
        categoryAxis.axisColor = "#DADADA";
        categoryAxis.twoLineMode = true;
        categoryAxis.dateFormats = [{
                period: 'fff',
                format: 'JJ:NN:SS'
            }, {
                period: 'ss',
                format: 'JJ:NN:SS'
            }, {
                period: 'mm',
                format: 'JJ:NN'
            }, {
                period: 'hh',
                format: 'JJ:NN'
            }, {
                period: 'DD',
                format: 'DD'
            }, {
                period: 'WW',
                format: 'DD'
            }, {
                period: 'MM',
                format: 'MMM'
            }, {
                period: 'YYYY',
                format: 'YYYY'
            }];

        // first value axis (on the left)
        var valueAxis1 = new AmCharts.ValueAxis();
        valueAxis1.stackType = "regular";
        valueAxis1.gridAlpha = 0;
        valueAxis1.position = "left";
        chart_stacked.addValueAxis(valueAxis1);

        // GRAPHS
        // first graph
        var graph1 = new AmCharts.AmGraph();
        graph1.valueAxis = valueAxis1; // we have to indicate which value axis should be used
        graph1.title = "Pegawai Mutasi";
        graph1.valueField = "jumlah";
        graph1.balloonText = "[[title]]:[[value]]";
        graph1.lineAlpha = 0;
        graph1.fillAlphas = 1;
        chart_stacked.addGraph(graph1);

        // CURSOR
        var chartCursor = new AmCharts.ChartCursor();
        chartCursor.cursorAlpha = 0;
        chartCursor.zoomable = false;
        chart_stacked.addChartCursor(chartCursor);

        // SCROLLBAR
        var chartScrollbar = new AmCharts.ChartScrollbar();
        chart_stacked.addChartScrollbar(chartScrollbar);

        // LEGEND
        var legend = new AmCharts.AmLegend();
		legend.marginLeft = 110;
        legend.align = "center";
        legend.equalWidths = false;
        legend.periodValueText = "Total: [[value.sum]]";
        legend.valueAlign = "left";
        legend.valueText = "[[value]] ([[percents]]%)";
        legend.valueWidth = 100;
        chart_stacked.addLegend(legend);

        // WRITE
        chart_stacked.write("chartdiv");
    });
</script>
<div class="panel panel-primary">
    <div class="panel-heading">
        <div class="panel-title">Grafik Mutasi Pegawai <?php echo !empty($model->thn_awal) ? $model->thn_awal:""; ?></div>
        <div class="panel-options">
            <a data-rel="collapse" href="#"><i class="entypo-down-open"></i></a>
        </div>
    </div>

    <div class="panel-body">
        <div id="chartdiv" style="width: 100%; height: 400px;"></div>
    </div>
</div>


