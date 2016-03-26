<div class="row-fluid">
	<div class="span6">
		<?php echo $form->textFieldRow($model,'tglrenanggaranpen',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'readonly'=>true)); ?>
		<?php echo $form->textFieldRow($model,'noren_penerimaan',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'readonly'=>true)); ?>
	</div>
	<div class="span6">
		<div class="control-group ">
			<?php echo $form->labelEx($model,'Periode Anggaran', array('class'=>'control-label')) ?>
				<div class="controls">
					<?php echo $form->dropDownList($model, 'konfiganggaran_id', CHtml::listData(KonfiganggaranK::model()->findAll("isclosing_anggaran = TRUE ORDER BY deskripsiperiode ASC"), 'konfiganggaran_id', 'deskripsiperiode'), array('empty'=>'--Pilih--','class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);",'onchange'=>'validasiDigit();'));//AGRencanggaranpengT::model()->getTglPeriode() ?>
					<?php echo CHtml::hiddenField('konfiganggaran_id','',array('class'=>'span2 integer','style'=>'width:90px;','readonly'=>true))?>
				</div>
		</div>
		<div class="control-group ">
			<?php echo $form->labelEx($model,'Sumber Anggaran', array('class'=>'control-label')) ?>
				<div class="controls">
					<?php echo $form->dropDownList($model, 'sumberanggaran_id', CHtml::listData(AGSumberanggaranM::model()->findAllByAttributes(array('sumberanggaran_aktif'=>true),array('order'=>'sumberanggarannama')), 'sumberanggaran_id', 'sumberanggarannama'), array('empty'=>'--Pilih--','class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
				</div>
		</div>
	</div>
</div>