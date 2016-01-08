<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'id'=>'kpjenisdiklat-m-search',
	'type'=>'horizontal',
)); ?>

	<?php echo $form->textFieldRow($model,'jenisdiklat_nama',array('class'=>'span3','maxlength'=>50)); ?>

	<?php echo $form->textFieldRow($model,'jenisdiklat_namalainnya',array('class'=>'span3','maxlength'=>50)); ?>

	<?php echo $form->checkBoxRow($model,'jenisdiklat_aktif',array('checked'=>true)); ?>

	<div class="form-actions">
		<?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="icon-search icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit')); ?>
		<?php echo CHtml::htmlButton(Yii::t('mds','{icon} Reset',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')),array('class'=>'btn btn-danger', 'type'=>'reset')); ?>
	</div>

<?php $this->endWidget(); ?>
