<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'sashift-m-form',
	'enableAjaxValidation'=>false,
	'type'=>'horizontal',
	'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event);', 'onsubmit'=>'return requiredCheck(this);'),
	'focus'=>'#',
)); ?>
<p class="help-block"><?php echo Yii::t('mds','Fields with <span class="required">*</span> are required.') ?></p>

<?php echo $form->errorSummary($model); ?>

<div class="row-fluid">
	<div class="span4">
		<?php echo $form->textFieldRow($model,'shift_nama',array('class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'maxlength'=>50)); ?>

		<?php echo $form->textFieldRow($model,'shift_kode',array('class'=>'span3','onkeyup'=>"return $(this).focusNextInputField(event);", 'maxlength'=>1)); ?>

		<?php echo $form->textFieldRow($model,'shift_namalainnya',array('class'=>'span3','onkeyup'=>"return $(this).focusNextInputField(event);",'maxlength'=>50)); ?>
	</div>
	<div class="span4">
		<div class="control-group">
			<?php echo CHtml::label('Dari Jam','',array('class'=>'control-label')) ?>
			<div class="controls">
				<?php
				$this->widget('MyDateTimePicker', array(
					'model' => $model,
					'attribute' => 'shift_jamawal',
					'mode' => 'time',
					'options' => array(
						'dateFormat' => Params::TIME_FORMAT,
						//'maxDate' => 'd',
					),
					'htmlOptions' => array('readonly' => true,
						'onkeypress' => "return $(this).focusNextInputField(event)"),
				));
				?>
			</div>
		</div>
		<div class="control-group">
			<?php echo CHtml::label('Sampai Dengan','',array('class'=>'control-label')) ?>
			<div class="controls">
				<?php
				$this->widget('MyDateTimePicker', array(
					'model' => $model,
					'attribute' => 'shift_jamakhir',
					'mode' => 'time',
					'options' => array(
						'dateFormat' => Params::TIME_FORMAT,
						//'maxDate' => 'd',
					),
					'htmlOptions' => array('readonly' => true,
						'onkeypress' => "return $(this).focusNextInputField(event)"),
				));
				?>
			</div>
		</div>
	</div>
	<div class="span4">
	<?php echo $form->textFieldRow($model,'shift_urutan',array('class'=>'span1 integer', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>

	<?php echo $form->checkBoxRow($model,'shift_aktif'); ?>
	</div>
</div>
<div class="row-fluid">
	<div class="form-actions">
		<?php echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit', 'onKeypress'=>'return formSubmit(this,event)')); ?>
		<?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
				$this->createUrl('create'), 
				array('class'=>'btn btn-danger',
					  'onclick'=>'return refreshForm(this);')); ?>
		<?php echo CHtml::link(Yii::t('mds','{icon} Pengaturan Shift',array('{icon}'=>'<i class="icon-folder-open icon-white"></i>')),$this->createUrl('admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success')); ?>
		<?php 
                    $content = $this->renderPartial($this->path_tips.'tipsaddedit2f',array(),true);
                    $this->widget('UserTips',array('type'=>'transaksi','content'=>$content));                 
                ?>
		</div>
</div>
<?php $this->endWidget(); ?>
