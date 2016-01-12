<?php
$this->breadcrumbs=array(
	'Salinen Ms'=>array('index'),
	$model->linen_id,
);
?>
<div class="white-container">
	<legend class="rim2">Lihat <b>Linen</b></legend>
	<?php $this->widget('bootstrap.widgets.BootAlert'); ?>
		<div class="row-fluid">
		<div class="span6">
		<?php $this->widget('ext.bootstrap.widgets.BootDetailView',array(
				'data'=>$model,
				'attributes'=>array(
					'linen_id',
				'jenislinen_id',
				'ruangan_id',
				'rakpenyimpanan_id',
				'bahanlinen_id',
				'barang_id',
				'kodelinen',
				'tglregisterlinen',
				'noregisterlinen',
				'namalinen',
				'namalainnya',
				'merklinen',
				//'beratlinen',
				//'warna',
				//'tahunbeli',
				//'gambarlinen',
				//'jmlcucilinen',
				//'create_time',
				//'update_time',
				//'create_loginpemakai_id',
				//'update_loginpemakai_id',
				//'create_ruangan',
				//'linen_aktif',
				),
		)); ?>
		</div>
		<div class="span6">
			<?php $this->widget('ext.bootstrap.widgets.BootDetailView',array(
				'data'=>$model,
				'attributes'=>array(
					//'linen_id',
				//'jenislinen_id',
				//'ruangan_id',
				//'rakpenyimpanan_id',
				//'bahanlinen_id',
				//'barang_id',
				//'kodelinen',
				//'tglregisterlinen',
				//'noregisterlinen',
				//'namalinen',
				//'namalainnya',
				//'merklinen',
				'beratlinen',
				'warna',
				'tahunbeli',
				'gambarlinen',
				'jmlcucilinen',
				'create_time',
				'update_time',
				'create_loginpemakai_id',
				'update_loginpemakai_id',
				'create_ruangan',
				'linen_aktif',
				),
		)); ?>
		</div>
	</div>
	<div class="row-fluid">
		<div class="form-actions">
		<?php echo CHtml::link(Yii::t('mds','{icon} Ubah',array('{icon}'=>'<i class="icon-pencil icon-white"></i>')),$this->createUrl('update',array('id'=>$model->linen_id,'modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success')); ?>
		<?php echo CHtml::link(Yii::t('mds','{icon} Pengaturan Linen',array('{icon}'=>'<i class="icon-folder-open icon-white"></i>')),$this->createUrl('admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success')); ?>
		<?php $this->widget('UserTips',array('content'=>''));?>
		</div>
	</div>
</div>
