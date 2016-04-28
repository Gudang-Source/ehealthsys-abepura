<?php
$this->breadcrumbs=array(
	'Saloket Ms'=>array('index'),
	$model->loket_id,
);
?>
<div class="white-container">
	<legend class="rim2">Lihat <b>Loket</b></legend>
	<?php $this->widget('bootstrap.widgets.BootAlert'); ?>
		<div class="row-fluid">
		<div class="span6">
		<?php $this->widget('ext.bootstrap.widgets.BootDetailView',array(
				'data'=>$model,
				'attributes'=>array(
					'loket_id',
				'loket_nama',
				'loket_namalain',
				'loket_fungsi',
				'loket_singkatan',
				'loket_nourut',
				'loket_formatnomor',
				//'loket_maksantrian',
				//'loket_aktif',
				//'carabayar_id',
				//'filesuara',
				//'ispendaftaran',
				//'iskasir',
				),
		)); ?>
		</div>
		<div class="span6">
			<?php $this->widget('ext.bootstrap.widgets.BootDetailView',array(
				'data'=>$model,
				'attributes'=>array(
					//'loket_id',
				//'loket_nama',
				//'loket_namalain',
				//'loket_fungsi',
				//'loket_singkatan',
				//'loket_nourut',
				//'loket_formatnomor',
				'loket_maksantrian',
				'loket_aktif',
				'carabayar_id',
				'filesuara',
				'ispendaftaran',
				'iskasir',
				),
		)); ?>
		</div>
	</div>
	<div class="row-fluid">
		<div class="form-actions">
		<?php echo CHtml::link(Yii::t('mds','{icon} Ubah',array('{icon}'=>'<i class="icon-pencil icon-white"></i>')),$this->createUrl('update',array('id'=>$model->loket_id,'modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success')); ?>
		<?php echo CHtml::link(Yii::t('mds','{icon} Pengaturan Loket',array('{icon}'=>'<i class="icon-folder-open icon-white"></i>')),$this->createUrl('admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success')); ?>
		<?php $this->widget('UserTips',array('type'=>'view'));?>
		</div>
	</div>
</div>
