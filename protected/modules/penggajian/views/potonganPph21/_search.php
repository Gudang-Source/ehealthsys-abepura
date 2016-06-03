<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'id'=>'gjpotonganpph21-m-search',
	'type'=>'horizontal',
)); ?>


	<?php echo $form->textFieldRow($model,'penghasilandari',array('class'=>'span3')); ?>

	<?php echo $form->textFieldRow($model,'sampaidgn_thn',array('class'=>'span3')); ?>

	<?php echo $form->textFieldRow($model,'persentarifpenghsl',array('class'=>'span3')); ?>

	<div class="form-actions">
		<?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="icon-search icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit')); ?>
		<?php echo CHtml::htmlButton(Yii::t('mds','{icon} Reset',array('{icon}'=>'<i class="icon-search icon-white"></i>')),array('class'=>'btn btn-danger', 'type'=>'reset')); ?>
	</div>

<?php $this->endWidget(); ?>
