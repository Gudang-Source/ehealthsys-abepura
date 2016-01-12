<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/amcharts/amcharts.js', CClientScript::POS_BEGIN); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/amcharts/pie.js', CClientScript::POS_BEGIN); ?>
<script>
	//========== PIE =========
	var chart_pie_pdk;
	var legend;

	var chartDataPiePdk = <?= json_encode($dataPieChartPdk) ?>;

	AmCharts.ready(function () {
		// PIE CHART
		chart_pie_pdk = new AmCharts.AmPieChart();
		chart_pie_pdk.dataProvider = chartDataPiePdk;
		chart_pie_pdk.titleField = "jenis";
		chart_pie_pdk.valueField = "jumlah";
		chart_pie_pdk.labelRadius = -30;
		chart_pie_pdk.labelText = "[[percents]]%";
		chart_pie_pdk.depth3D = 10;
		chart_pie_pdk.angle = 10;

		// LEGEND
		legend = new AmCharts.AmLegend();
		legend.align = "center";
		legend.markerType = "circle";
		chart_pie_pdk.balloonText = "[[title]]<br><span style='font-size:14px'><b>[[value]]</b> ([[percents]]%)</span>";
		chart_pie_pdk.addLegend(legend);

		// WRITE
		chart_pie_pdk.write("piePdk");
	});

	// changes label position (labelRadius)
	function setLabelPosition() {
		if (document.getElementById("rb1").checked) {
			chart_pie_pdk.labelRadius = 30;
			chart_pie_pdk.labelText = "[[title]]: [[value]]";
		} else {
			chart_pie_pdk.labelRadius = -30;
			chart_pie_pdk.labelText = "[[percents]]%";
		}
		chart_pie_pdk.validateNow();
	}


	// makes chart 2D/3D
	function set3D() {
		if (document.getElementById("rb3").checked) {
			chart_pie_pdk.depth3D = 10;
			chart_pie_pdk.angle = 10;
		} else {
			chart_pie_pdk.depth3D = 0;
			chart_pie_pdk.angle = 0;
		}
		chart_pie_pdk.validateNow();
	}

	// changes switch of the legend (x or v)
	function setSwitch() {
		if (document.getElementById("rb5").checked) {
			legend.switchType = "x";
		} else {
			legend.switchType = "v";
		}
		legend.validateNow();
	}
	//========== END PIE =========

</script>
<div class="white-container">
	<div id="piePdk" style="width: 100%; height: 400px;"></div>
	<table align="center" cellspacing="20">
		<tr>
			<td>
				<input type="radio" checked="true" name="group" id="rb1" onclick="setLabelPosition()">labels outside
				<input type="radio" name="group" id="rb2" onclick="setLabelPosition()">labels inside</td>
			<td>
				<input type="radio" name="group2" id="rb3" onclick="set3D()">3D
				<input type="radio" checked="true" name="group2" id="rb4" onclick="set3D()">2D</td>
			<td>Legend switch type:
				<input type="radio" checked="true" name="group3" id="rb5"
					   onclick="setSwitch()">x
				<input type="radio" name="group3" id="rb6" onclick="setSwitch()">v</td>
		</tr>
	</table>
</div>




