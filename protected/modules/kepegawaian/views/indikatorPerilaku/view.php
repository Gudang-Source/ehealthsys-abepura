<?php
$this->breadcrumbs=array(
	'Kpindikatorperilaku Ms'=>array('index'),
	$model->indikatorperilaku_id,
);
?>
<fieldset class="box">
	<legend class="rim">Lihat Indikator Perilaku</legend>
	<?php $this->widget('bootstrap.widgets.BootAlert'); ?>
		<div class="row-fluid">
		<div class="span6">
		<?php $this->widget('ext.bootstrap.widgets.BootDetailView',array(
				'data'=>$model,
				'attributes'=>array(
				'indikatorperilaku_id',
					array(
						'header'=>'Jabatan',
						'name'=>'jabatan_id',
						'value'=>(isset($model->jabatan->jabatan_nama) ? $model->jabatan->jabatan_nama : "-"),
					),
					array(
						'header'=>'Jenis Penilaian',
						'name'=>'jenispenilaian_id',
						'value'=>(isset($model->jenispenilaian->jenispenilaian_nama) ? $model->jenispenilaian->jenispenilaian_nama : "-"),
					),
					array(
						'header'=>'Kompetensi',
						'name'=>'kompetensi_id',
						'value'=>(isset($model->kompetensi->kompetensi_nama) ? $model->kompetensi->kompetensi_nama : "-"),
					),
				),
		)); ?>
		</div>
		<div class="span6">
			<?php $this->widget('ext.bootstrap.widgets.BootDetailView',array(
				'data'=>$model,
				'attributes'=>array(
				'indikatorperilaku_nama',
				'indikatorperilaku_namalain',
					array(
						'name'=>'indikatorperilaku_aktif',
						'value'=>($model->indikatorperilaku_aktif == 1) ? "Aktif" : "Tidak Aktif",
						'filter'=>array(1=>'Aktif',0=>'Tidak Aktif'),
						'htmlOptions'=>array('style'=>'text-align:left;'),
					),
				),
		)); ?>
		</div>
	</div>
	<div class="row-fluid">
		<div class="form-actions">
		<?php echo CHtml::link(Yii::t('mds','{icon} Ubah',array('{icon}'=>'<i class="icon-pencil icon-white"></i>')),$this->createUrl('update',array('id'=>$model->indikatorperilaku_id,'modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success')); ?>
		<?php echo CHtml::link(Yii::t('mds','{icon} Pengaturan Indikator Perilaku',array('{icon}'=>'<i class="icon-folder-open icon-white"></i>')),$this->createUrl('admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success')); ?>
		<?php $this->widget('UserTips',array('content'=>''));?>
		</div>
	</div>
</fieldset>
