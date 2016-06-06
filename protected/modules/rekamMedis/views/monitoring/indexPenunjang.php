<div class="white-container">
    <legend class="rim2">Monitoring <b>Penunjang</b></legend>
<?php
$this->breadcrumbs=array(
	'Monitoringpenunjang Vs'=>array('index'),
	'Manage',
);

//$this->menu=array(
//	array('label'=>'List MonitoringpenunjangV', 'url'=>array('index')),
//	array('label'=>'Create MonitoringpenunjangV', 'url'=>array('create')),
//);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('#monitoring-search-form').submit(function(){
	$.fn.yiiGridView.update('monitoring-v-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>
 <div class="block-tabel">    
    <?php $this->renderPartial('_tablePenunjang',array('model'=>$model)); ?>
 </div>    
 <fieldset class="box">   
    <?php $this->renderPartial('_searchPenunjang',array('model'=>$model)); ?>
 </fieldset>    
</div>
<script type="text/javascript">
  setInterval(   // fungsi untuk menjalankan suatu fungsi berdasarkan waktu
    function(){
        $.fn.yiiGridView.update('monitoring-v-grid', {   // fungsi untuk me-update data pada Cgridview yang memiliki id=category_grid
        data: $(this).serialize()
    });
     return false;
 }, 
 <?php echo (Yii::app()->user->getState('monitoringrefresh')).'000'; ?>  // fungsi di eksekusi setiap waktu yang ditentukan di database
);
</script>