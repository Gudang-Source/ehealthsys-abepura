
<?php
$this->breadcrumbs=array(
	'Kppengangkatanpns Ts'=>array('index'),
	'Create',
);
 ?>


<div class="white-container">
    <legend class="rim2">Pengangkatan <b>PNS</b></legend>
    <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
    
    <?php echo $this->renderPartial('_form', array('model'=>$model, 'modPegawai'=>$modPegawai, 'modUsulan'=>$modUsulan, 'modPers'=>$modPers, 'modRealisasi'=>$modRealisasi)); ?>
</div>