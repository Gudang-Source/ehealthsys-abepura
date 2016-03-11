<div class="white-container">
	<legend class="rim2">Lihat <b>Jenis Tindakan Rehabilitasi Medis</b></legend>
<?php
$this->widget('bootstrap.widgets.BootAlert'); ?>

<?php $this->widget('ext.bootstrap.widgets.BootDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'jenistindakanrm_id',
		'jenistindakanrm_nama',
		'jenistindakanrm_namalainnya',
		'jenistindakanrm_aktif',
	),
)); ?>

<?php 
echo CHtml::link(Yii::t('mds', '{icon} Pengaturan Jenis Tindakan Rehabilitasi Medis', array('{icon}'=>'<i class="icon-file icon-white"></i>')), $this->createUrl(Yii::app()->controller->id.'/admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success'))."&nbsp";
$this->widget('UserTips',array('type'=>'view'));?>
</div>