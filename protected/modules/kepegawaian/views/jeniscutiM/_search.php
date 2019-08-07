<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'id'=>'jeniscuti-m-search',
	'type'=>'horizontal',
)); ?>

	<?php echo $form->textFieldRow($model,'jeniscuti_id',array('class'=>'span3 numbers-only')); ?>

	<?php echo $form->textFieldRow($model,'jeniscuti_nama',array('class'=>'span3','maxlength'=>100)); ?>

	<?php echo $form->textFieldRow($model,'jeniscuti_namalainnya',array('class'=>'span3','maxlength'=>100)); ?>

	<?php echo $form->checkBoxRow($model,'jeniscuti_aktif'); ?>

	<div class="form-actions">
		<?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="icon-search icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit')); ?>
		<?php echo CHtml::htmlButton(Yii::t('mds','{icon} Reset',array('{icon}'=>'<i class="icon-search icon-white"></i>')),array('class'=>'btn btn-danger', 'type'=>'reset')); ?>
	</div>

<?php $this->endWidget(); ?>
