<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'potonganpph21-m-form',
	'enableAjaxValidation'=>false,
	'type'=>'horizontal',
	'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event);', 'onsubmit'=>'return requiredCheck(this);'),
	'focus'=>'#',
)); ?>

	<p class="help-block"><?php echo Yii::t('mds','Fields with <span class="required">*</span> are required.') ?></p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row-fluid">

		<div class = "span4">
			<?php echo $form->textFieldRow($model,'penghasilandari',array('class'=>'span3 numbers-only', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'style'=>'text-align: right')); ?>
			<?php echo $form->textFieldRow($model,'sampaidgn_thn',array('class'=>'span3 numbers-only', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'style'=>'text-align: right')); ?>
			<?php echo $form->textFieldRow($model,'persentarifpenghsl',array('class'=>'span3 numbers-only', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'style'=>'text-align: right')); ?>
		</div>
		<div class = "span4">
		</div>
		<div class="span4">
				
		</div>
	</div>
	<div class="row-fluid">
	<div class="form-actions">
		<?php echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit', 'onKeypress'=>'return formSubmit(this,event)')); ?>
		<?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
				$this->createUrl('create'), 
				array('class'=>'btn btn-danger',
					  'onclick'=>'return refreshForm(this);')); ?>
		<?php echo CHtml::link(Yii::t('mds','{icon} Pengaturan Potongan PPH 21',array('{icon}'=>'<i class="icon-folder-open icon-white"></i>')),$this->createUrl('admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success')); ?>
		<?php $this->widget('UserTips',array('content'=>''));?>
		</div>
	</div>
<?php $this->endWidget(); ?>
