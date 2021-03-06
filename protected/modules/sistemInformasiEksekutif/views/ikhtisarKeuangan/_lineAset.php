<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/amcharts/amcharts.js', CClientScript::POS_BEGIN); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/amcharts/serial.js', CClientScript::POS_BEGIN); ?>
<?php
if ($model->jns_periode == "bulan") {
    $awal = $model->bln_awal;
    $akhir = $model->bln_akhir;
} elseif ($model->jns_periode == "tahun") {
    $awal = $model->thn_awal;
    $akhir = $model->thn_akhir;
} else {
    $awal = $model->tgl_awal;
    $akhir = $model->tgl_akhir;
}

?>
<script>
    //========== BAR ========

    var chart_line_aset;

    var chartDataAset = <?= json_encode($dataChartAset) ?>;
    var models = <?= json_encode($model) ?>;

    AmCharts.ready(function () {
        // generate some random data first

        // SERIAL CHART
        chart_line_aset = new AmCharts.AmSerialChart();

        chart_line_aset.dataProvider = chartDataAset;
        chart_line_aset.categoryField = "periode";
        chart_line_aset.dataDateFormat = "YYYY-MM-DD JJ:NN:SS";
        // listen for "dataUpdated" event (fired when chart is inited) and call zoomChart method when it happens
        chart_line_aset.addListener("dataUpdated", zoomChartAset);
        chart_line_aset.numberFormatter = {
                    precision:0,decimalSeparator:",",thousandsSeparator:"."
                  };

        // AXES
        // category
        var categoryAxis = chart_line_aset.categoryAxis;
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
        valueAxis1.axisColor = "#FF6600";
        valueAxis1.axisThickness = 2;
        valueAxis1.gridAlpha = 0;
        chart_line_aset.addValueAxis(valueAxis1);

        // GRAPHS
        // first graph
        var graph1 = new AmCharts.AmGraph();
        graph1.useNegativeColorIfDown = true;
        graph1.baloonText = "[[category]]<br><b>value: [[value]]</b>";
        graph1.bullet = "round";
        graph1.bulletBorderAlpha = 1;
        graph1.bulletBorderColor = "#FFFFFF";
        graph1.hideBulletCOunt = 50;
        graph1.lineThickness = 2;
        graph1.lineColor - "#FDD400";
        graph1.negativeLineColor = "#67b7dc";
        graph1.valueField = "jumlah";
        chart_line_aset.addGraph(graph1);

        // CURSOR
        var chartCursor = new AmCharts.ChartCursor();
        chartCursor.cursorAlpha = 0.1;
        chartCursor.fullWidth = true;
        chart_line_aset.addChartCursor(chartCursor);

        // SCROLLBAR
        var chartScrollbar = new AmCharts.ChartScrollbar();
        chart_line_aset.addChartScrollbar(chartScrollbar);

        // WRITE
        chart_line_aset.write("aset");
    });


    // this method is called when chart is first inited as we listen for "dataUpdated" event
    function zoomChartAset() {
        // different zoom methods can be used - zoomToIndexes, zoomToDates, zoomToCategoryValues
        chart_line_aset.zoomToIndexes(0, 30);
    }
</script>
<div class="panel panel-primary">
    <div class="panel-heading">
        <div class="panel-title">Grafik Aset (dalam Juta Rupiah)</div>
        <div class="panel-options">
            <a data-rel="collapse" href="#"><i class="entypo-down-open"></i></a>
        </div>
    </div>

    <div class="panel-body">
        <div id="aset" style="width: 100%; height: 400px;"></div>
    </div>
</div>




