<?php // echo $form->dropDownListRow($modTandabukti, 'dengankartu', LookupM::getItems('dengankartu'), array('required' => true,'onchange' => 'enableInputKartu()', 'empty' => '-- Pilih --', 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 50));  ?>
<div class="control-group">
	<?php echo CHtml::activeLabel($modTandabukti, 'dengankartu', array('class' => 'control-label', 'required' => true)); ?>
	<div class="controls">
		<?php echo $form->dropDownList($modTandabukti,'dengankartu',LookupM::getItems('dengankartu'),array('required' => true, 'empty'=>'--pilih--','class'=>'span3')); ?>
	</div>
</div>
<div class="control-group">
<?php echo CHtml::activeLabel($modTandabukti, 'bank_id', array('class' => 'control-label', 'required' => true)); ?>
	<div class="controls">
	<?php
	$modBank = BankM::getItems($modTandabukti->bank_id);
	echo $form->dropDownList($modTandabukti, 'bank_id', ((count($modBank) > 0) ? CHtml::listData($modBank, 'bank_id', 'namabank') : array()), array('required' => true, 'class' => 'span3', 'empty' => '-- Pilih --', 'onchange' => 'setNamaBank();', 'onkeyup' => "return $(this).focusNextInputField(event);"));
	?>
	</div>
</div>
<div class="control-group">
<?php echo CHtml::activeLabel($modTandabukti, 'bankkartu', array('class' => 'control-label', 'required' => true)); ?>
	<div class="controls">
	<?php echo $form->textField($modTandabukti, 'bankkartu', array('required' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
	</div>
</div>
<div class="control-group">
<?php echo CHtml::activeLabel($modTandabukti, 'nokartu', array('class' => 'control-label', 'required' => true)); ?>
	<div class="controls">
	<?php echo $form->textField($modTandabukti, 'nokartu', array('required' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
	</div>
</div>
<div class="control-group">
<?php echo CHtml::activeLabel($modTandabukti, 'nostrukkartu', array('class' => 'control-label', 'required' => true)); ?>
	<div class="controls">
	<?php echo $form->textField($modTandabukti, 'nostrukkartu', array('required' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
	</div>
</div>