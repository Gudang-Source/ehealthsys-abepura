<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'id'=>'sapemeriksaanlabalat-m-search',
	'type'=>'horizontal',
)); ?>

	<?php //echo $form->textFieldRow($model,'pemeriksaanlabalat_id',array('class'=>'span3')); ?>
	<?php echo $form->dropdownListRow($model,'alatmedis_id', CHtml::listData($model->AlatmedisItems, 'alatmedis_id', 'alatmedis_nama'),array('empty'=>'-- Pilih --','onkeypress'=>'return $(this).focusNextInputField(event)','class'=>'span3')); ?>

	<?php echo $form->textFieldRow($model,'pemeriksaanlabalat_kode',array('class'=>'span3','maxlength'=>50)); ?>

	<?php echo $form->textFieldRow($model,'pemeriksaanlabalat_nama',array('class'=>'span3','maxlength'=>200)); ?>

	<?php echo $form->textFieldRow($model,'pemeriksaanlabalat_namalain',array('class'=>'span3','maxlength'=>200)); ?>

	<?php echo $form->checkBoxRow($model,'pemeriksaanlabalat_aktif', array('checked'=>'pemeriksaanlabalat_aktif')); ?>

	<div class="form-actions">
		<?php echo CHtml::htmlButton(Yii::t('mds','{icon} Cari',array('{icon}'=>'<i class="icon-search icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit')); ?>
		<?php echo CHtml::htmlButton(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-search icon-white"></i>')),array('class'=>'btn btn-danger', 'type'=>'reset')); ?>
	</div>

<?php $this->endWidget(); ?>
