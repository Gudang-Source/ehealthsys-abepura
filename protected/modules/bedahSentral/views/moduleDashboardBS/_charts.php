<style>
	.panel-heading{
		background: none repeat scroll 0 0 #428bca !important;
		color : #eee !important;
	}
</style>
    
<div class="panel panel-primary" id="charts_env">

	<div class="panel-heading">
		<div class="panel-title">Operasi Bulan Ini</div>

		<div class="panel-options">
			<ul class="nav nav-tabs">
				<li class=""><a href="#area-chart" data-toggle="tab">Area Chart</a></li>
				<li class="active"><a href="#line-chart" data-toggle="tab">Line Charts</a></li>
				<li class=""><a href="#pie-chart" data-toggle="tab">Donut Chart</a></li>
			</ul>
		</div>
	</div>

	<div class="panel-body">

		<div class="tab-content">

			<div class="tab-pane" id="area-chart">                          
				<div id="area-chart-1" class="morrischart" style="height: 300px"></div>
			</div>

			<div class="tab-pane active" id="line-chart">
				<div id="line-chart-1" class="morrischart" style="height: 300px"></div>
			</div>

			<div class="tab-pane" id="pie-chart">
				<div id="donut-chart-1" class="morrischart" style="height: 300px;"></div>
			</div>

		</div>

	</div>

	<table class="table table-bordered table-responsive">

		<thead>
			<tr>
				<th width="50%" class="col-padding-1">
					<div class="pull-left">
						<div class="h4 no-margin">Jumlah Pasien Kunjungan Baru</div>
						<small><?php echo $dataKolom[5]; ?></small>
					</div>
				</th>
				<th width="50%" class="col-padding-1">
					<div class="pull-left">
						<div class="h4 no-margin">Jumlah Pasien Kunjungan Lama</div>
						<small><?php echo $dataKolom[6]; ?></small>
					</div>
				</th>
			</tr>
		</thead>

	</table>
</div>  

<script type="text/javascript">
$(document).ready(function($) 
{
	// Area Chart
	var area_chart_1 = $("#area-chart-1");
    area_chart_1.parent().show();
	Morris.Area({
		element: 'area-chart-1',
        data: [
			<?php 
			if(count($dataAreaChart) > 0){
				foreach ($dataAreaChart as $i => $chart) { ?>
					{ "x": "<?php echo date("d",strtotime($chart['selesaioperasi'])); ?>", "y": <?php echo $chart['jumlah']; ?> },
				<?php } 
			}
			?>
		],
		xkey: 'x',
		ykeys: ['y'],
		labels: ['Jumlah'],
		parseTime: false,
		lineColors: [getRandomColor()]
	});
	area_chart_1.parent().attr('style', '');
    
     
    // Line Charts
	Morris.Line({
		element: 'line-chart-1',
		data: [
			<?php 
			if(count($dataLineChart) > 0){
				foreach ($dataLineChart as $i => $chart) { ?>
					{ x: "<?php echo date("d",strtotime($chart['selesaioperasi'])); ?>", 
						y_1: <?php echo isset($chart['jumlah_1']) ? $chart['jumlah_1'] : 0; ?> , 
						y_2: <?php echo isset($chart['jumlah_2']) ? $chart['jumlah_2'] : 0; ?> , 
						y_3: <?php echo isset($chart['jumlah_3']) ? $chart['jumlah_3'] : 0; ?> , 
						y_4: <?php echo isset($chart['jumlah_4']) ? $chart['jumlah_3'] : 0; ?> , 
						y_5: <?php echo isset($chart['jumlah_5']) ? $chart['jumlah_3'] : 0; ?> , 
						y_6: <?php echo isset($chart['jumlah_6']) ? $chart['jumlah_3'] : 0; ?> , 
						y_7: <?php echo isset($chart['jumlah_7']) ? $chart['jumlah_3'] : 0; ?> , 
						y_8: <?php echo isset($chart['jumlah_8']) ? $chart['jumlah_3'] : 0; ?> , 
						y_9: <?php echo isset($chart['jumlah_9']) ? $chart['jumlah_3'] : 0; ?> ,
					},
				<?php }
			}
			?>
			
		],
		xkey: 'x',
		ykeys: ['y_1','y_2','y_3','y_4','y_5','y_6','y_7','y_8','y_9'],
		labels: ['Bedah Umum dan Mata', 'Bedah Orthopedia', 'Bedah Mulut','Bedah Urologi','ODS Bedah Umum','ODS Bedah Orthopedi','ODS Bedah THT','Operasi Obgyn','Bedah Tht'],
		parseTime: false,
		lineColors: [getRandomColor(),getRandomColor(),getRandomColor(),getRandomColor(),getRandomColor(),getRandomColor(),getRandomColor(),getRandomColor(),getRandomColor()],
	});
 
 
 

    // Donut Chart
    var donut_chart_1 = $("#donut-chart-1");
    donut_chart_1.parent().show();
    var donut_chart = Morris.Donut({
        element: 'donut-chart-1',
        data: [
        <?php 
		if(count($dataDonutChart) > 0){
			foreach ($dataDonutChart as $i => $chart) { ?>
				{label: "<?php echo $chart['instalasiasal_nama']; ?>", value: <?php echo $chart['jumlah']; ?>},
			<?php }
		}?>
        ],
        colors: [
        <?php foreach ($dataDonutChart as $i => $chart) { ?>
        getRandomColor(),
        <?php } ?>
        ]
    });
    
    donut_chart_1.parent().attr('style', '');
    
});

function getRandomColor() {
    var flat_colors = [
    '#16a085','#27ae60',
    '#2980b9','#8e44ad',
    '#2c3e50','#f39c12',
    '#d35400','#c0392b',
    '#bdc3c7','#7f8c8d',
    '#1abc9c','#2ecc71',
    '#3498db','#9b59b6',
    '#34495e','#f1c40f',
    '#e67e22','#e74c3c',];
    var index = Math.floor((Math.random() * 10)); 
    var color = flat_colors[index];
    return color;
}

</script>