<?php
$this->breadcrumbs=array(
	'Sakelrekening Ms'=>array('index'),
	$model->kelrekening_id,
);
?>
<div class="white-container">
	<legend class="rim2">Lihat <b>SAKelrekeningM</b></legend>
	<?php $this->widget('bootstrap.widgets.BootAlert'); ?>
		<div class="row-fluid">
		<div class="span6">
		<?php $this->widget('ext.bootstrap.widgets.BootDetailView',array(
				'data'=>$model,
				'attributes'=>array(
					'kelrekening_id',
				'koderekeningkel',
				//'namakelrekening',
				//'kelrekening_aktif',
				),
		)); ?>
		</div>
		<div class="span6">
			<?php $this->widget('ext.bootstrap.widgets.BootDetailView',array(
				'data'=>$model,
				'attributes'=>array(
					//'kelrekening_id',
				//'koderekeningkel',
				'namakelrekening',
				'kelrekening_aktif',
				),
		)); ?>
		</div>
	</div>
	<div class="row-fluid">
		<div class="form-actions">
		<?php echo CHtml::link(Yii::t('mds','{icon} Ubah',array('{icon}'=>'<i class="icon-pencil icon-white"></i>')),$this->createUrl('update',array('id'=>$model->kelrekening_id,'modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success')); ?>
		<?php echo CHtml::link(Yii::t('mds','{icon} Pengaturan Kelompok Rekening',array('{icon}'=>'<i class="icon-folder-open icon-white"></i>')),$this->createUrl('admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success')); ?>
		<?php                     
                    $this->widget('UserTips',array('type'=>'view'));                  
                ?>
		</div>
	</div>
</div>
