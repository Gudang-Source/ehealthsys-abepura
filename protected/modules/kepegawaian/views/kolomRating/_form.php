<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'kpkolomrating-m-form',
	'enableAjaxValidation'=>false,
	'type'=>'horizontal',
	'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event);', 'onsubmit'=>'return requiredCheck(this);'),
	'focus'=>'#',
)); ?>

	<p class="help-block"><?php echo Yii::t('mds','Fields with <span class="required">*</span> are required.') ?></p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row-fluid">

		<div class = "span6">
			<?php echo $form->textFieldRow($model,'kolomrating_namalevel',array('class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'maxlength'=>100)); ?>
			<?php echo $form->textFieldRow($model,'kolomrating_point',array('class'=>'span3 numbers-only', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
			<div class="control-group">
				<?php echo CHtml::label('Score','Score', array('class'=>'control-label')) ?>
				<div class="controls">
					<?php echo $form->textField($model,'kolomrating_nilaiawal',array('class'=>'span1 numbers-only')); ?> s/d 
					<?php echo $form->textField($model,'kolomrating_nilaiakhir',array('class'=>'span1 numbers-only')); ?>
				</div>
			</div>
                        <?php echo $form->textFieldRow($model,'kolomrating_uraian',array('class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'maxlength'=>100)); ?>
			<?php echo $form->textAreaRow($model,'kolomrating_deskripsi',array('class'=>'span3 numbers-only', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
			<div class="control-group">
				<?php echo CHtml::label('Status','indikatorperilaku_aktif', array('class'=>'control-label')) ?>
				<div class="controls">
					<?php echo $form->checkBox($model,'kolomrating_aktif'); ?>
				</div>
			</div>
		</div>
		<div class = "span6">
		</div>
	</div>
	<div class="row-fluid">
	<div class="form-actions">
		<?php echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit', 'onKeypress'=>'return formSubmit(this,event)')); ?>
		<?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
				$this->createUrl('create'), 
				array('class'=>'btn btn-danger',
					  'onclick'=>'return refreshForm(this);')); ?>
		<?php echo CHtml::link(Yii::t('mds','{icon} Pengaturan Kolom Rating',array('{icon}'=>'<i class="icon-folder-open icon-white"></i>')),$this->createUrl('admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success')); ?>
		<?php $this->widget('UserTips',array('content'=>''));?>
		</div>
	</div>
<?php $this->endWidget(); ?>
