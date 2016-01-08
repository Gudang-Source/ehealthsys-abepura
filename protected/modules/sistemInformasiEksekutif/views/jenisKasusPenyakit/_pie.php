<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/amcharts/amcharts.js', CClientScript::POS_BEGIN); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/amcharts/pie.js', CClientScript::POS_BEGIN); ?>
<script>
	//========== PIE =========
	var chart_pie;
	var legend;

	var chartDataPie = <?= json_encode($dataPieChart) ?>;

	AmCharts.ready(function () {
		// PIE CHART
		chart_pie = new AmCharts.AmPieChart();
		chart_pie.dataProvider = chartDataPie;
		chart_pie.titleField = "jenis";
		chart_pie.valueField = "jumlah";
		chart_pie.labelRadius = 30;
		chart_pie.labelText = "[[percents]]%";

		// LEGEND
		legend = new AmCharts.AmLegend();
		legend.position = "bottom";
		legend.maxColumns = 6;
		legend.markerType = "circle";
		chart_pie.balloonText = "[[title]]<br><span style='font-size:14px'><b>[[value]]</b> ([[percents]]%)</span>";
		chart_pie.addLegend(legend, "legendDiv");

		// WRITE
		chart_pie.write("pie");
	});

	// changes label position (labelRadius)
//	function setLabelPosition() {
//		if (document.getElementById("rb1").checked) {
//			chart_pie.labelRadius = 30;
//			chart_pie.labelText = "[[title]]: [[value]]";
//		} else {
//			chart_pie.labelRadius = -30;
//			chart_pie.labelText = "[[percents]]%";
//		}
//		chart_pie.validateNow();
//	}


	// makes chart 2D/3D
//	function set3D() {
//		if (document.getElementById("rb3").checked) {
//			chart_pie.depth3D = 10;
//			chart_pie.angle = 10;
//		} else {
//			chart_pie.depth3D = 0;
//			chart_pie.angle = 0;
//		}
//		chart_pie.validateNow();
//	}

	// changes switch of the legend (x or v)
//	function setSwitch() {
//		if (document.getElementById("rb5").checked) {
//			legend.switchType = "x";
//		} else {
//			legend.switchType = "v";
//		}
//		legend.validateNow();
//	}
	//========== END PIE =========

</script>
<div class="white-container">
	<div class="row">
		<div class="col-md-4">
			<div id="pie" style="width: 100%; height: 400px;"></div>
		</div>
		<div class="col-md-8">
			<div id="legendDiv" style="width: 100%; height: 400px;"></div>
		</div>
	</div>

<!--	<table align="center" cellspacing="20">
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
	</table>-->
</div>




