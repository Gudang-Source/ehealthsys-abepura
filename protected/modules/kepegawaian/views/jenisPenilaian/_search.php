<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'id'=>'kpjenispenilaian-m-search',
	'type'=>'horizontal',
)); ?>

	<?php //echo $form->textFieldRow($model,'jenispenilaian_id',array('class'=>'span3')); ?>

	<?php // echo $form->textFieldRow($model,'jabatan_id',array('class'=>'span3')); ?>

	<?php echo $form->textFieldRow($model,'jenispenilaian_nama',array('class'=>'span3','maxlength'=>100)); ?>

	<?php echo $form->textFieldRow($model,'jenispenilaian_namalain',array('class'=>'span3','maxlength'=>100)); ?>

	<?php // echo $form->textFieldRow($model,'jenispenilaian_sifat',array('class'=>'span3','maxlength'=>25)); ?>

	<?php echo $form->dropDownListRow($model, 'jenispenilaian_sifat', LookupM::getItems('sifatjenispenilaian'), array('empty' => '-- Pilih --', 'class' => 'span3', 'maxlength' => 50,'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
	
	<div class="control-group">
		<?php echo CHtml::label('Status','lookup_name', array('class'=>'control-label')) ?>
		<div class="controls">
			<?php echo $form->checkBox($model,'jenispenilaian_aktif'); ?>
		</div>
	</div>
	<div class="form-actions">
		<?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="icon-search icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit')); ?>
		<?php echo CHtml::htmlButton(Yii::t('mds','{icon} Reset',array('{icon}'=>'<i class="icon-search icon-white"></i>')),array('class'=>'btn btn-danger', 'type'=>'reset')); ?>
	</div>

<?php $this->endWidget(); ?>
