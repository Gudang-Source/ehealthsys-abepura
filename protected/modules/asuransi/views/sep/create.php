<?php
$this->breadcrumbs=array(
	'Assep Ts'=>array('index'),
	'Create',
);
?>
<div class="white-container">
	<legend class="rim2">Tambah Surat Eligibilitas Peserta <b>(SEP)</b></legend>
	<?php $this->widget('bootstrap.widgets.BootAlert'); ?>

	<?php echo $this->renderPartial('_form', array('model'=>$model,'modRujukanBpjs'=>$modRujukanBpjs,'modAsuransiPasien'=>$modAsuransiPasien,'modAsuransiPasienBpjs'=>$modAsuransiPasienBpjs)); ?>
	<?php echo $this->renderPartial('_jsFunctions',array('model'=>$model,'modRujukanBpjs'=>$modRujukanBpjs,'modAsuransiPasien'=>$modAsuransiPasien,'modAsuransiPasienBpjs'=>$modAsuransiPasienBpjs)); ?>
</div>