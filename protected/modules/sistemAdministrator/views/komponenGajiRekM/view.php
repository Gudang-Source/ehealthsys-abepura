<?php
$this->breadcrumbs = array(
	'Sakompgajirek Ms' => array('index'),
	$model->komponengajirek_id,
);
?>
<div class="white-container">
	<legend class="rim2">Lihat <b>Rekening Komponen Gaji</b></legend>
	<?php $this->widget('bootstrap.widgets.BootAlert'); ?>
	<div class="row-fluid">
			<?php
			$this->widget('ext.bootstrap.widgets.BootDetailView', array(
				'data' => $model,
				'attributes' => array(
					'komponengajirek_id',
					array(
						'label' => 'Komponen Gaji',
						'type' => 'raw',
						'value' => isset($model->komponengaji->komponengaji_nama) ? $model->komponengaji->komponengaji_nama : "Tidak diset",
					),
					array(
						'label' => 'Rekening',
						'type' => 'raw',
						'value' => isset($model->rekening5->nmrekening5) ? $model->rekening5->nmrekening5 : "Tidak diset",
					),
					array(
						'label' => 'Jenis',
						'type' => 'raw',
						'value' => ($model->ispenggajian == 1)? "Penggajian" : (($model->ispembayarangaji == 1)?"Pembayaran Gaji":" - "),
					),
					array(
						'label' => 'Debit / Kredit',
						'type' => 'raw',
						'value' => ($model->debitkredit == "D") ? "Debit" : "Kredit",
					),
				),
			));
			?>

	</div>
	<div class="row-fluid">
		<div class="form-actions">
			<?php echo CHtml::link(Yii::t('mds', '{icon} Ubah', array('{icon}' => '<i class="icon-pencil icon-white"></i>')), $this->createUrl('update', array('id' => $model->komponengajirek_id, 'modul_id' => Yii::app()->session['modul_id'])), array('class' => 'btn btn-success')); ?>
			<?php echo CHtml::link(Yii::t('mds', '{icon} Pengaturan Rekening Komponen Gaji', array('{icon}' => '<i class="icon-folder-open icon-white"></i>')), $this->createUrl('admin', array('modul_id' => Yii::app()->session['modul_id'])), array('class' => 'btn btn-success')); ?>
		</div>
	</div>
</div>
