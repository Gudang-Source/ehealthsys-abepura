<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'id'=>'kptunjangan-m-search',
	'type'=>'horizontal',
)); ?>
	<?php echo $form->dropdownListRow($model, 'pangkat_id', CHtml::listData(PangkatM::model()->findAll('pangkat_aktif = true'),'pangkat_id','pangkat_nama'),array('empty'=>'-- Pilih --','onkeypress'=>'return $(this).focusNextInputField(event)','class'=>'span3')); ?>
	<?php echo $form->dropdownListRow($model, 'jabatan_id', CHtml::listData(JabatanM::model()->findAll('jabatan_aktif = true'),'jabatan_id','jabatan_nama'),array('empty'=>'-- Pilih --','onkeypress'=>'return $(this).focusNextInputField(event)','class'=>'span3')); ?>
	<?php echo $form->dropdownListRow($model, 'komponengaji_id', CHtml::listData(KomponengajiM::model()->findAll('komponengaji_aktif = true'),'komponengaji_id','komponengaji_nama'),array('empty'=>'-- Pilih --','onkeypress'=>'return $(this).focusNextInputField(event)','class'=>'span3')); ?>
	<?php echo $form->textFieldRow($model,'nominaltunjangan',array('class'=>'span3')); ?>
	<?php echo $form->checkBoxRow($model,'tunjangan_aktif'); ?>

	<div class="form-actions">
		<?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="icon-search icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit')); ?>
		<?php echo CHtml::htmlButton(Yii::t('mds','{icon} Reset',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')),array('class'=>'btn btn-danger', 'type'=>'reset')); ?>
	</div>

<?php $this->endWidget(); ?>
