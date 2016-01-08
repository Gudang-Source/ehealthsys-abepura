<style>
	.panel-heading{
		background: none repeat scroll 0 0 #428bca !important;
		color : #eee !important;
	}
</style>
<div class="row-fluid" style="overflow:hidden;">
	<div class="row">
		<?php $this->renderPartial('_kolom',array('dataKolom'=>$dataKolom)); ?>
	</div>
	<div class="row">
		<div class="col-md-8">
		<?php 
		$this->renderPartial('_charts',array('dataKolom'=>$dataKolom,
												'dataAreaChart'=>$dataAreaChart,
												'dataLineChart'=>$dataLineChart,
												'dataDonutChart'=>$dataDonutChart,
		)); 
		?>
		</div>
		<div class="col-md-4">
		<?php $this->renderPartial('_chartPie',array('dataPieChart'=>$dataPieChart)); ?>
		</div>
	</div>
	<div class="row">
		<div class="col-md-6">
			<?php $this->renderPartial('_chartBar',array('dataBarChart'=>$dataBarChart)); ?>
		</div>
		<div class="col-md-6">
			<?php $this->renderPartial('_table',array('dataTable'=>$dataTable)); ?>
		</div>
	</div>
	<div class="row">
		<div class="col-md-3">
			<?php  
				$this->renderPartial($this->path_view.'_todolist',array(
					'modTodolist'=>$modTodolist,
					'dataProviderTodolist'=>$dataProviderTodolist,
				)); 
			?>
		</div>
	    <?php $map = Yii::app()->user->getState('mapdashboard');
		if ($map == true) { ?>
		    <div class="col-md-9">
			<?php $this->renderPartial('_map',array('dataMap'=>$dataMap,'latitude'=>$latitude,'longitude'=>$longitude)); ?>
		    </div>
	    <?php } ?>
	</div>
</div>
