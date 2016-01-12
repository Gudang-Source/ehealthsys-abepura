<?php
$this->breadcrumbs=array(
	'Sapemeriksaanlabalat Ms'=>array('index'),
	$model->pemeriksaanlabalat_id,
);
?>
<!--<div class="white-container">-->
	<!--<legend class="rim2">Lihat <b>Master Alat Laboratorium</b></legend>-->
	<?php $this->widget('bootstrap.widgets.BootAlert'); ?>
		<div class="row-fluid">
		<div class="span6">
		<?php $this->widget('ext.bootstrap.widgets.BootDetailView',array(
				'data'=>$model,
				'attributes'=>array(
					'pemeriksaanlabalat_id',
				array(
				'header'=>'Alat Medis',
				'name'=>'alatmedis_id',
				'value'=>'$data->alatmedis->alatmedis_nama',
				'filter'=>CHtml::listData($model->AlatmedisItems, 'alatmedis_id', 'alatmedis_nama'),
				),
				'pemeriksaanlabalat_kode',
				'pemeriksaanlabalat_nama',
				'pemeriksaanlabalat_namalain',
				'pemeriksaanlabalat_aktif',
				//'create_time',
				//'update_time',
				//'create_loginpemakai_id',
				//'update_loginpemakai_id',
				//'createruangan',
				),
		)); ?>
		</div>
		<div class="span6">
			<?php $this->widget('ext.bootstrap.widgets.BootDetailView',array(
				'data'=>$model,
				'attributes'=>array(
					//'pemeriksaanlabalat_id',
				//'alatmedis_id',
				//'pemeriksaanlabalat_kode',
				//'pemeriksaanlabalat_nama',
				//'pemeriksaanlabalat_namalain',
				//'pemeriksaanlabalat_aktif',
				'create_time',
				'update_time',
				'create_loginpemakai_id',
				'update_loginpemakai_id',
				'createruangan',
				),
		)); ?>
		</div>
	</div>
	<div class="row-fluid">
		<div class="form-actions">
		<?php echo CHtml::link(Yii::t('mds','{icon} Ubah',array('{icon}'=>'<i class="icon-pencil icon-white"></i>')),$this->createUrl('update',array('id'=>$model->pemeriksaanlabalat_id,'modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success')); ?>
		<?php echo CHtml::link(Yii::t('mds','{icon} Pengaturan Master Alat Laboratorium',array('{icon}'=>'<i class="icon-folder-open icon-white"></i>')),$this->createUrl('admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success')); ?>
		<?php $this->widget('UserTips',array('content'=>''));?>
		</div>
	</div>
<!--</div>-->
