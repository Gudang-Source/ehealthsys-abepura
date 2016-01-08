<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/amcharts/amcharts.js', CClientScript::POS_BEGIN); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/amcharts/pie.js', CClientScript::POS_BEGIN); ?>
<script>
    //========== PIE =========
    var chart_pie_umur;
    var umurlegend;

    var chartDataPieUmur = <?= json_encode($dataPieChartUmur) ?>;
    AmCharts.ready(function () {
        // PIE CHART
        chart_pie_umur = new AmCharts.AmPieChart();
        chart_pie_umur.dataProvider = chartDataPieUmur;
        chart_pie_umur.titleField = "jenis";
        chart_pie_umur.valueField = "jumlah";
		chart_pie_umur.colors = ["#eb0000","#00ebeb","#003beb","#ebb000","#00eb3b"];
        chart_pie_umur.titles = [
            {
                "text": "Grafik Jumlah Pasien Berdasarkan Usia",
                "size": 15
            }
        ];
        
        // LEGEND
        umurlegend = new AmCharts.AmLegend();
        umurlegend.align = "center";
        umurlegend.markerType = "circle";
        chart_pie_umur.balloonText = "[[title]]<br><span style='font-size:14px'><b>[[value]]</b> ([[percents]]%)</span>";
        chart_pie_umur.addLegend(umurlegend);

        // WRITE
        chart_pie_umur.write("pieUmur");
    });

    //========== END PIE =========

</script>
<div class="white-container">
    <div id="pieUmur" style="width: 100%; height: 400px;"></div>
</div>




