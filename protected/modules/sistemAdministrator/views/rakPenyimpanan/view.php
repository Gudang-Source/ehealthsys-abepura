<?php
$this->breadcrumbs=array(
	'Sarakpenyimpanan Ms'=>array('index'),
	$model->rakpenyimpanan_id,
);
?>
<fieldset class="box">
	<legend class="rim">Lihat Rak Penyimpanan</legend>
	<?php $this->widget('bootstrap.widgets.BootAlert'); ?>
		<div class="row-fluid">
		<div class="span6">
		<?php $this->widget('ext.bootstrap.widgets.BootDetailView',array(
				'data'=>$model,
				'attributes'=>array(
					'rakpenyimpanan_id',
				array(
					'name'=>'lokasipenyimpanan_id',
					'value'=>$model->lokasipenyimpanan->lokasipenyimpanan_nama,	
				),	
				'rakpenyimpanan_label',
				'rakpenyimpanan_kode',
				//'rakpenyimpanan_nama',
				//'rakpenyimpanan_namalain',
				//'rakpenyimpanan_aktif',
				),
		)); ?>
		</div>
		<div class="span6">
			<?php $this->widget('ext.bootstrap.widgets.BootDetailView',array(
				'data'=>$model,
				'attributes'=>array(
					//'rakpenyimpanan_id',
				//'lokasipenyimpanan_id',
				//'rakpenyimpanan_label',
				//'rakpenyimpanan_kode',
				'rakpenyimpanan_nama',
				'rakpenyimpanan_namalain',
				'rakpenyimpanan_aktif',
				),
		)); ?>
		</div>
	</div>
	<div class="row-fluid">
		<div class="form-actions">
		<?php echo CHtml::link(Yii::t('mds','{icon} Ubah',array('{icon}'=>'<i class="icon-pencil icon-white"></i>')),$this->createUrl('update',array('id'=>$model->rakpenyimpanan_id,'modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success')); ?>
		<?php echo CHtml::link(Yii::t('mds','{icon} Pengaturan Rak Penyimpanan',array('{icon}'=>'<i class="icon-folder-open icon-white"></i>')),$this->createUrl('admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success')); ?>
		<?php $this->widget('UserTips',array('type'=>'view'));?>
		</div>
	</div>
</fieldset>