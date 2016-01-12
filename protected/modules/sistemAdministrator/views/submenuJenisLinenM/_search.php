<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'id'=>'sajenislinen-m-search',
	'type'=>'horizontal',
)); ?>

	<?php //echo $form->textFieldRow($model,'jenislinen_id',array('class'=>'span3')); ?>
<div class="row-fluid">
<div class="span4">
	<?php echo $form->textFieldRow($model,'jenislinen_no',array('class'=>'span3 integer','maxlength'=>50)); ?>

	<?php echo $form->textFieldRow($model,'jenislinen_nama',array('class'=>'span3','maxlength'=>200)); ?>
	<div class="control-group ">
			<?php echo $form->labelEx($model,'tgldiedarkan', array('class'=>'control-label')) ?>
			<div class="controls">
				<?php
					$this->widget('MyDateTimePicker', array(
						'model' => $model,
						'attribute' => 'tgldiedarkan',
						'mode' => 'date', 
						'options' => array(
						'dateFormat' => Params::DATE_FORMAT,
						),
						'htmlOptions' => array('readonly' => true, 'class' => "span2",
						'onkeypress' => "return $(this).focusNextInputField(event)"),
					));
				?>
			</div>
    </div>
</div>
<div class="span4">
	<?php echo $form->textFieldRow($model,'ukuranitem',array('class'=>'span3','maxlength'=>30)); ?>

	<?php echo $form->textFieldRow($model,'beratitem',array('class'=>'span3')); ?>

	<?php echo $form->textFieldRow($model,'qtyitem',array('class'=>'span3')); ?>
</div>
<div class="span4">
	<?php echo $form->textFieldRow($model,'warnalinen',array('class'=>'span3','maxlength'=>50)); ?>

	<?php echo $form->checkBoxRow($model,'isberwarna'); ?>
</div>
</div>
<div class="row-fluid">
	<div class="form-actions">
		<?php echo CHtml::htmlButton(Yii::t('mds','{icon} Cari',array('{icon}'=>'<i class="icon-search icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit')); ?>
		<?php echo CHtml::htmlButton(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-search icon-white"></i>')),array('class'=>'btn btn-danger', 'type'=>'reset')); ?>
	</div>
</div>
<?php $this->endWidget(); ?>
