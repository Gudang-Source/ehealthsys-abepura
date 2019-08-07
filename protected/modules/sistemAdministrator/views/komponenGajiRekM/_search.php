<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
	'action' => Yii::app()->createUrl($this->route),
	'method' => 'get',
	'id' => 'sakompgajirek-m-search',
	'type' => 'horizontal',
		));
?>

<div class="row-fluid">
	<div class="span4">
		<div class='control-group'>
			<?php echo CHtml::label('Komponen Gaji', 'komponen_gaji', array('class' => 'control-label')); ?>
			<div class="controls">
				<?php echo $form->textField($model, 'komponen_gaji', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
			</div>
		</div>
		<div class='control-group'>
			<?php echo CHtml::label('Rekening', 'rekening', array('class' => 'control-label')); ?>
			<div class="controls">
				<?php echo $form->textField($model, 'rekening', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
			</div>
		</div>
	</div>
	<div class="span4">
		<div class="control-group">
			<?php echo $form->labelEx($model, 'debitkredit', array('class' => 'control-label')); ?>
			<div class="controls">
				<?php echo $form->dropDownList($model, 'debitkredit', array("D" => "Debit", "K" => "Kredit"), array('class' => 'span3', 'prompt' => '--Pilih--')); ?>
			</div>
		</div>
		<div class="control-group">
			<div class="controls checkbox-column">
				<?php echo $form->checkBox($model, 'ispenggajian', array('onclick' => 'setUntukTransaksi();')) . CHtml::activeLabel($model, 'ispenggajian'); ?>
				<br>
				<br>
				<?php echo $form->checkBox($model, 'ispembayarangaji', array('onclick' => 'setUntukTransaksi();')) . CHtml::activeLabel($model, 'ispembayarangaji'); ?>				
				
			</div>
		</div>
	</div>
</div>

<div class="form-actions">
	<?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="icon-search icon-white"></i>')), array('class' => 'btn btn-primary', 'type' => 'submit')); ?>
	<?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="icon-refresh icon-white"></i>')), array('class' => 'btn btn-danger', 'type' => 'reset')); ?>
</div>

<?php $this->endWidget(); ?>
<script type="text/javascript">
function setUntukTransaksi(){
	var ispenggajian = $('#<?php echo CHtml::activeId($model,'ispenggajian'); ?>');
	var ispembayarangaji = $('#<?php echo CHtml::activeId($model,'ispembayarangaji'); ?>');
	
	if (ispenggajian.is(':checked')) {
		ispembayarangaji.attr('disabled',true);
		ispenggajian.removeAttr('disabled',true);
		ispenggajian.val(1);
		ispembayarangaji.val(0);
		$('#ispenggajian').removeAttr('style','display:none;');
	} else if(ispembayarangaji.is(':checked')){
		ispenggajian.attr('disabled',true);
		ispembayarangaji.removeAttr('disabled',true);
		ispenggajian.val(0);
		ispembayarangaji.val(1);
		$('#ispembayarangaji').removeAttr('style','display:none;');
	}else{
		ispenggajian.removeAttr('disabled',true);
		ispembayarangaji.removeAttr('disabled',true);
		$('#ispembayarangaji').attr('style','display:none;');
		$('#ispenggajian').attr('style','display:none;');
		ispenggajian.val(0);
		ispembayarangaji.val(0);
	}
}	
</script>
