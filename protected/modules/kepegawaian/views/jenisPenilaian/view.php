<?php
$this->breadcrumbs=array(
	'Kpjenispenilaian Ms'=>array('index'),
	$model->jenispenilaian_id,
);
?>
<fieldset class="box">
	<legend class="rim">Lihat Jenis Penilaian</legend>
	<?php $this->widget('bootstrap.widgets.BootAlert'); ?>
		<div class="row-fluid">
		<div class="span12">
		<?php $this->widget('ext.bootstrap.widgets.BootDetailView',array(
				'data'=>$model,
				'attributes'=>array(
					'jenispenilaian_id',
//				'jabatan_id',
				'jenispenilaian_nama',
				//'jenispenilaian_namalain',
				//'jenispenilaian_sifat',
				//'jenispenilaian_aktif',
				'jenispenilaian_namalain',
				'jenispenilaian_sifat',
				'jenispenilaian_aktif',
				),
		)); ?>
		</div>
	</div>
	<div class="row-fluid">
		<div class="form-actions">
		<?php echo CHtml::link(Yii::t('mds','{icon} Ubah',array('{icon}'=>'<i class="icon-pencil icon-white"></i>')),$this->createUrl('update',array('id'=>$model->jenispenilaian_id,'modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success')); ?>
		<?php echo CHtml::link(Yii::t('mds','{icon} Pengaturan Jenis Penilaian',array('{icon}'=>'<i class="icon-folder-open icon-white"></i>')),$this->createUrl('admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success')); ?>
		<?php $this->widget('UserTips',array('content'=>''));?>
		</div>
	</div>
</fieldset>
