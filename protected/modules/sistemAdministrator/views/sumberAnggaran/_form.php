<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'agsumberanggaran-m-form',
	'enableAjaxValidation'=>false,
	'type'=>'horizontal',
	'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event);', 'onsubmit'=>'return requiredCheck(this);'),
	'focus'=>'#',
)); ?>

	<p class="help-block"><?php echo Yii::t('mds','Fields with <span class="required">*</span> are required.') ?></p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row-fluid">

		<div class = "span6">
			<?php echo $form->textFieldRow($model,'kodesumberanggaran',array('class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'maxlength'=>5)); ?>
			<?php echo $form->textFieldRow($model,'sumberanggarannama',array('class'=>'span3', 'onkeyup'=>"namaLain(this)", 'maxlength'=>200)); ?>
			<?php echo $form->textFieldRow($model,'sumberanggarannamalain',array('class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'maxlength'=>200)); ?>
			<?php echo $form->checkBoxRow($model,'sumberanggaran_aktif', array('onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
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
		<?php echo CHtml::link(Yii::t('mds','{icon} Pengaturan Sumber Anggaran',array('{icon}'=>'<i class="icon-folder-open icon-white"></i>')),$this->createUrl('admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success')); ?>
		<?php
			$content = $this->renderPartial($this->path_view.'tips/add1',array(),true);
			$this->widget('UserTips',array('type'=>'transaksi','content'=>$content));
		?>
		</div>
	</div>
<?php $this->endWidget(); ?>
<script>
function namaLain(nama){
    document.getElementById('SASumberanggaranM_sumberanggarannamalain').value = nama.value.toUpperCase();
}
</script>