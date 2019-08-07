<?php
$this->breadcrumbs=array(
	'Konfigkoperasi Ks'=>array('index'),
	$model->konfigkoperasi_id,
);
?>
<div class="white-container">
	<legend class="rim2">Lihat <b>KonfigkoperasiK</b></legend>
	<?php $this->widget('bootstrap.widgets.BootAlert'); ?>
		<div class="row-fluid">
		<div class="span6">
		<?php $this->widget('ext.bootstrap.widgets.BootDetailView',array(
				'data'=>$model,
				'attributes'=>array(
					'konfigkoperasi_id',
				'persjasasimpanan',
				'persjasapinjaman',
				'persdanapengurus',
				'persdanakaryawan',
				'persdanapendidikan',
				'persdanasosial',
				'persdanacadangan',
				'persbiayaprovisasi',
				'persjasadeposito',
				//'pimpinankoperasi_id',
				//'penguruskoperasi_id',
				//'bendaharakoperasi_id',
				//'bendaharars_id',
				//'status_aktif',
				//'create_time',
				//'update_time',
				//'create_loginpemakai_id',
				//'update_loginpemakai_id',
				//'create_ruangan',
				),
		)); ?>
		</div>
		<div class="span6">
			<?php $this->widget('ext.bootstrap.widgets.BootDetailView',array(
				'data'=>$model,
				'attributes'=>array(
					//'konfigkoperasi_id',
				//'persjasasimpanan',
				//'persjasapinjaman',
				//'persdanapengurus',
				//'persdanakaryawan',
				//'persdanapendidikan',
				//'persdanasosial',
				//'persdanacadangan',
				//'persbiayaprovisasi',
				//'persjasadeposito',
				'pimpinankoperasi_id',
				'penguruskoperasi_id',
				'bendaharakoperasi_id',
				'bendaharars_id',
				'status_aktif',
				'create_time',
				'update_time',
				'create_loginpemakai_id',
				'update_loginpemakai_id',
				'create_ruangan',
				),
		)); ?>
		</div>
	</div>
	<div class="row-fluid">
		<div class="form-actions">
		<?php echo CHtml::link(Yii::t('mds','{icon} Ubah',array('{icon}'=>'<i class="icon-pencil icon-white"></i>')),$this->createUrl('update',array('id'=>$model->konfigkoperasi_id,'modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success')); ?>
		<?php echo CHtml::link(Yii::t('mds','{icon} Pengaturan KonfigkoperasiK',array('{icon}'=>'<i class="icon-folder-open icon-white"></i>')),$this->createUrl('admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success')); ?>
		<?php $this->widget('UserTips',array('content'=>''));?>
		</div>
	</div>
</div>
