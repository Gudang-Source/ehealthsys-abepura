<div class="row-fluid">
	<div class="span4"> 
		<div class="control-group">
			<?php echo $form->labelEx($model,'tglpermohonanpertukaran',array('class'=>'control-label')); ?>
			<div class="controls">
				<?php   
					$model->tglpermohonanpertukaran = (!empty($model->tglpermohonanpertukaran) ? date("d/m/Y",strtotime($model->tglpermohonanpertukaran)) : null);
					$this->widget('MyDateTimePicker',array(
											'model'=>$model,
											'attribute'=>'tglpermohonanpertukaran',
											'mode'=>'date',
											'options'=> array(
												'showOn' => false,
												'maxDate' => 'd',
												'yearRange'=> "-150:+0",
											),
											'htmlOptions'=>array('placeholder'=>'00/00/0000','class'=>'dtPicker2 datemask','onkeyup'=>"return $(this).focusNextInputField(event)"
											),
				)); ?>
				<?php echo $form->error($model, 'tglpermohonanpertukaran'); ?>
			</div>
		</div>
		<?php echo $form->textFieldRow($model,'no_permohonanpertukaran',array('readonly'=>true,'class'=>'span3')); ?>
	</div>
	<div class="span4">
	</div>
	<div class="span4">
	</div>
</div>