<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'id'=>'kpkolomrating-m-search',
	'type'=>'horizontal',
)); ?>
	<?php echo $form->textFieldRow($model,'kolomrating_namalevel',array('class'=>'span3','maxlength'=>100)); ?>

	<?php echo $form->textFieldRow($model,'kolomrating_point',array('class'=>'span3 numbers-only')); ?>

	<div class="control-group">
		<?php echo CHtml::label('Score','Score', array('class'=>'control-label')) ?>
		<div class="controls">
			<?php echo $form->textField($model,'kolomrating_uraian',array('class'=>'span1 numbers-only')); ?> s/d 
			<?php echo $form->textField($model,'kolomrating_deskripsi',array('class'=>'span1 numbers-only')); ?>
		</div>
	</div>

	<div class="control-group">
		<?php echo CHtml::label('Status','indikatorperilaku_aktif', array('class'=>'control-label')) ?>
		<div class="controls">
			<?php echo $form->checkBox($model,'kolomrating_aktif'); ?>
		</div>
	</div>
	<div class="form-actions">
		<?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="icon-search icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit')); ?>
		<?php echo CHtml::htmlButton(Yii::t('mds','{icon} Reset',array('{icon}'=>'<i class="icon-search icon-white"></i>')),array('class'=>'btn btn-danger', 'type'=>'reset')); ?>
	</div>

<?php $this->endWidget(); ?>
