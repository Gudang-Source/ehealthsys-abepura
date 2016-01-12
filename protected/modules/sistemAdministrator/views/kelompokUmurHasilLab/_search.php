<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'id'=>'lbkelkumurhasillab-m-search',
	'type'=>'horizontal',
)); ?>

	<?php //echo $form->textFieldRow($model,'kelkumurhasillab_id',array('class'=>'span3')); ?>
<div class="row-fluid">
	<div class="span4">
		<?php echo $form->textFieldRow($model,'kelkumurhasillabnama',array('class'=>'span3','maxlength'=>50)); ?>
		<?php echo $form->textFieldRow($model,'umurminlab',array('class'=>'span3 numbers-only')); ?>
	</div>
	<div class="span4">
		<?php echo $form->textFieldRow($model,'umurmakslab',array('class'=>'span3 numbers-only')); ?>
		<?php echo $form->textFieldRow($model,'satuankelumur',array('class'=>'span3','maxlength'=>20)); ?>
	</div>
	<div class="span4">
		<?php echo $form->textFieldRow($model,'kelkumurhasillab_urutan',array('class'=>'span1 numbers-only', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
		<?php echo $form->checkBoxRow($model,'kelkumurhasillab_aktif',array('checked'=>'checked')); ?>
	</div>
</div>
<div class="row-fluid">
	<div class="form-actions">
		<?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="icon-search icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit')); ?>
	</div>
</div>

<?php $this->endWidget(); ?>
