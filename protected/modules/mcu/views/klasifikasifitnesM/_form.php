<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'mcklasifikasifitnes-m-form',
	'enableAjaxValidation'=>false,
	'type'=>'horizontal',
	'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event);', 'onsubmit'=>'return requiredCheck(this);'),
	'focus'=>'#MCKlasifikasifitnesM_age_elev',
)); ?>

	<p class="help-block"><?php echo Yii::t('mds','Fields with <span class="required">*</span> are required.') ?></p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row-fluid">

		<div class = "span4">
			<?php echo $form->textFieldRow($model,'age_elev',array('class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'maxlength'=>50)); ?>
			<?php echo $form->textFieldRow($model,'lama_menit',array('class'=>'span3 integer', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
			<?php echo $form->textFieldRow($model,'workload_kph',array('class'=>'span3 integer', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
			<?php echo $form->textFieldRow($model,'estimasirate',array('class'=>'span3 integer', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
			<?php echo $form->textFieldRow($model,'max_intake',array('class'=>'span3 integer', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
		</div>
		<div class = "span4">
			<?php echo $form->textFieldRow($model,'umur_min',array('class'=>'span3 integer', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
			<?php echo $form->textFieldRow($model,'umur_maks',array('class'=>'span3 integer', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
			<?php echo $form->textFieldRow($model,'mets',array('class'=>'span3 integer', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
			<?php echo $form->textFieldRow($model,'klasifikasifitnes',array('class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'maxlength'=>50)); ?>
			<?php echo $form->textFieldRow($model,'functional_class',array('class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'maxlength'=>5)); ?>
			<?php echo $form->dropDownListRow($model, 'jeniskelamin', LookupM::getItems('jeniskelamin'), array('onkeyup'=>"return $(this).focusNextInputField(event)", 'class'=>'span3')); ?>
		</div>
		<div class = "span4">
			<?php echo $form->textFieldRow($model,'walking_kmhr',array('class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'maxlength'=>50)); ?>
			<?php echo $form->textFieldRow($model,'jogging_kmhr',array('class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'maxlength'=>50)); ?>
			<?php echo $form->textFieldRow($model,'bicycling_kmhr',array('class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'maxlength'=>50)); ?>
			<?php echo $form->textAreaRow($model,'other_sports',array('rows'=>4, 'cols'=>50, 'class'=>'span4', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
		</div>
	</div>
	<div class="row-fluid">
	<div class="form-actions">
		<?php echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit', 'onKeypress'=>'return formSubmit(this,event)')); ?>
		<?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
				$this->createUrl('create'), 
				array('class'=>'btn btn-danger',
					  'onclick'=>'return refreshForm(this);')); ?>
		<?php echo CHtml::link(Yii::t('mds','{icon} Pengaturan Klasifikasi Fitnes',array('{icon}'=>'<i class="icon-folder-open icon-white"></i>')),$this->createUrl('admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success')); ?>
		<?php
			$content = $this->renderPartial('../tips/add',array(),true);
			$this->widget('UserTips',array('type'=>'transaksi','content'=>$content));
		?>
		</div>
	</div>
<?php $this->endWidget(); ?>
