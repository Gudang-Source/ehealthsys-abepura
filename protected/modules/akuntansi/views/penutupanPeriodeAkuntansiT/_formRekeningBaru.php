<div class="row-fluid">
	<div class="span4">
		<div class="control-group ">
			<?php echo CHtml::label('Periode Awal','perideawal', array('class'=>'control-label')) ?>
			<div class="controls">
				<?php    
					$modRekPeriod->perideawal = $format->formatDateTimeForUser(date("Y-m-d"));
					$this->widget('MyDateTimePicker',array(
										'model'=>$modRekPeriod,
										'attribute'=>'perideawal',
										'mode'=>'date',
										'options'=> array(
											'dateFormat'=>Params::DATE_FORMAT,
//											'maxDate' => 'd',
										),
										'htmlOptions'=>array('readonly'=>true,'class'=>'dtPicker3','onclick'=>"return $(this).focusNextInputField(event)"),
					)); 
					$modRekPeriod->perideawal = $format->formatDateTimeForDb($modRekPeriod->perideawal);
					?>
			</div>
		</div>
	</div>
	<div class="span4">
		<div class="control-group ">
			<?php echo CHtml::label('Sampai dengan','sampaidgn', array('class'=>'control-label')) ?>
			<div class="controls">
				<?php    
					$modRekPeriod->sampaidgn = $format->formatDateTimeForUser(date("Y-m-d"));
					$this->widget('MyDateTimePicker',array(
										'model'=>$modRekPeriod,
										'attribute'=>'sampaidgn',
										'mode'=>'date',
										'options'=> array(
											'dateFormat'=>Params::DATE_FORMAT,
//											'maxDate' => 'd',
										),
										'htmlOptions'=>array('readonly'=>true,'class'=>'dtPicker3','onclick'=>"return $(this).focusNextInputField(event)"),
					)); 
					$modRekPeriod->sampaidgn = $format->formatDateTimeForDb($modRekPeriod->sampaidgn);
					?>
			</div>
		</div>
	</div>
	<div class="span4">
		<?php echo $form->textAreaRow($modRekPeriod,'deskripsi',array('rows'=>4, 'cols'=>200, 'class'=>'span4', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
	</div>
</div>

