<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'id'=>'sabahansterilisasi-m-search',
	'type'=>'horizontal',
)); ?>
<div class="row-fluid">
	<div class="span4">
	<?php //echo $form->textFieldRow($model,'bahansterilisasi_id',array('class'=>'span3')); ?>

	<?php echo $form->textFieldRow($model,'bahansterilisasi_nama',array('class'=>'span3','maxlength'=>100)); ?>

	<?php echo $form->textFieldRow($model,'bahansterilisasi_namalain',array('class'=>'span3','maxlength'=>100)); ?>

	<?php echo $form->textFieldRow($model,'bahansterilisasi_jumlah',array('class'=>'span3')); ?>
	</div>
	<div class="span4">
	<?php echo $form->dropdownListRow($model,'bahansterilisasi_satuan', LookupM::getItems('satuanbarang'),array('empty'=>'-- Pilih --','onkeypress'=>'return $(this).focusNextInputField(event)','class'=>'span3')); ?>

	<?php echo $form->textFieldRow($model,'bahansterilisasi_warna',array('class'=>'span3','maxlength'=>50)); ?>

	<?php echo $form->textFieldRow($model,'bahansterilisasi_maksuhu',array('class'=>'span3')); ?>

	<?php echo $form->checkBoxRow($model,'bahansterilisasi_aktif', array('checked'=>'bahansterilisasi_aktif')); ?>
	</div>
</div>
	<div class="form-actions">
		<?php echo CHtml::htmlButton(Yii::t('mds','{icon} Cari',array('{icon}'=>'<i class="icon-search icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit')); ?>
		<?php echo CHtml::htmlButton(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-search icon-white"></i>')),array('class'=>'btn btn-danger', 'type'=>'reset')); ?>
	</div>

<?php $this->endWidget(); ?>
