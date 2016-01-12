<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'gfatc-m-form',
	'enableAjaxValidation'=>false,
	'type'=>'horizontal',
	'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event);', 'onsubmit'=>'return requiredCheck(this);'),
	'focus'=>'#',
)); ?>

	<p class="help-block"><?php echo Yii::t('mds','Fields with <span class="required">*</span> are required.') ?></p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row-fluid">
		<div class = "span6">
			<?php echo CHtml::activeHiddenField($model,'lookup_type',array('class'=>'span3','maxlength'=>10,'value'=>'routeofadmatc')); ?>
			<div class="control-group">
				<?php echo CHtml::label('Route of Adm ATC <span class="required">*</span>','lookup_name', array('class'=>'control-label required')) ?>
				<div class="controls">
					<?php echo $form->textField($model,'lookup_name',array('class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'maxlength'=>100)); ?>
				</div>
			</div>
			<div class="control-group">
				<?php echo CHtml::label('Route of Adm ATC Lainnya<span class="required">*</span>','lookup_value', array('class'=>'control-label required')) ?>
				<div class="controls">
					<?php echo $form->textField($model,'lookup_value',array('class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'maxlength'=>100)); ?>
				</div>
			</div>
			<div class="control-group">
				<?php echo CHtml::label('Urutan <span class="required">*</span>','lookup_urutan', array('class'=>'control-label required')) ?>
				<div class="controls">
					<?php echo $form->textField($model,'lookup_urutan',array('class'=>'span1', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'maxlength'=>100)); ?>
				</div>
			</div>
			<div class="control-group">
				<?php echo CHtml::label('Route of Adm ATC Aktif','lookup_aktif', array('class'=>'control-label')) ?>
				<div class="controls">
					<?php echo $form->checkBox($model,'lookup_aktif', array('onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
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
		<?php echo CHtml::link(Yii::t('mds','{icon} Pengaturan Route of Adm Atc',array('{icon}'=>'<i class="icon-folder-open icon-white"></i>')),$this->createUrl('admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success')); ?>
		<?php $this->widget('UserTips',array('content'=>''));?>
		</div>
	</div>
<?php $this->endWidget(); ?>