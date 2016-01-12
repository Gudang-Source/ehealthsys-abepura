<div class="row-fluid">
	<div class="span4">
		<?php echo $form->textFieldRow($model,'no_penyusutan',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>25,'readonly'=>true,'placeholder'=>'Otomatis')); ?>
	</div>
	<div class="span4">
		<div class="control-group ">
		<?php echo CHtml::label('Tanggal Penyusutan','tgl_penyusutan', array('class'=>'control-label')) ?>
			<div class="controls">
			<?php   
					$this->widget('MyDateTimePicker',array(
									'model'=>$model,
									'attribute'=>'tgl_penyusutan',
									'mode'=>'date',
									'options'=> array(
										'dateFormat'=>Params::DATE_FORMAT,
//										'maxDate' => 'd',
									),
									'htmlOptions'=>array('readonly'=>true,'class'=>'dtPicker3','onclick'=>"return $(this).focusNextInputField(event)"),
				)); ?> 
			</div>
		</div>
	</div>
	<div class="span4">
		<div class="control-group ">
		<?php echo CHtml::label('Nilai Residu','residu', array('class'=>'control-label')) ?>
			<div class="controls">
				<?php echo $form->textField($model,'residu',array('class'=>'span3 integer', 'onkeypress'=>"return $(this).focusNextInputField(event);",'style'=>'margin-top:-3px;')); ?>&nbsp;
				<?php echo CHtml::htmlButton('Hitung', array('class' => 'btn btn-primary', 'type'=>'button', 'onkeypress'=>'loadDetailPenyusutan()', 'onclick'=>'loadDetailPenyusutan()','style'=>'margin-top:-3px;')); ?>
			</div>
		</div>
	</div>
</div>