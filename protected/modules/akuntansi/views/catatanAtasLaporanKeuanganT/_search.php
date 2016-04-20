<div class="row-fluid">
	<div class="span4">
		<div class="control-group ">
		<?php echo CHtml::label('Periode Akuntansi','rekperiod_id', array('class'=>'control-label')) ?>
			<div class="controls">
			<?php echo $form->dropDownList($model,'rekperiod_id',CHtml::listData(RekperiodM::model()->findAllByAttributes(array('isclosing'=>false)),'rekperiod_id','deskripsi'),array('class'=>'span3','onkeypress'=>'return $(this).focusNextInputField(event)')); ?>
			</div>
		</div>
	</div>
	<div class="span4">
		<div class="control-group ">
		<?php echo CHtml::label('No. CALK','calk_no', array('class'=>'control-label')) ?>
			<div class="controls">
			<?php echo $form->textField($model,'calk_no',array('class'=>'span3','onkeypress'=>'return $(this).focusNextInputField(event)', 'maxlength'=>25)); ?>
			</div>
		</div>
	</div>
	<div class="span4">
		<div class="control-group ">
		<?php echo CHtml::label('Tanggal CALK','calk_tgl', array('class'=>'control-label')) ?>
			<div class="controls">
			<?php   
					$this->widget('MyDateTimePicker',array(
									'model'=>$model,
									'attribute'=>'calk_tgl',
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
</div>	
