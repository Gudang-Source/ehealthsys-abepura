<tr>
	<td style="text-align: center;">
		<div class="control-group">
		<?php echo CHtml::activeHiddenField($modBerlaku, '[0]kelompokjabatan',array('readonly'=>true));?>		
		<?php 
			echo CHtml::activeDropDownList($modBerlaku, '[0]kelompokjabatan', LookupM::getItems('kelompokjabatan'), array('empty' => '-- Pilih --'))
		?>
		</div>
	</td>
	<td style="text-align: center;">
		<div class="control-group">
		<?php echo CHtml::activeHiddenField($modBerlaku, '[0]shiftberlaku_id',array('readonly'=>true));?>		
		<?php 
			$this->widget('MyDateTimePicker',array(
				'model'=>$modBerlaku,
				'attribute'=>'[0]shiftberlaku_jmasuk_mulai',
				'mode'=>'time',
				'options'=> array(
					'dateFormat'=>Params::DATE_FORMAT,
				),
				'htmlOptions'=>array(	'readonly'=>true,
										'onkeypress'=>"return $(this).focusNextInputField(event)",
										'class'=>'required',
										'style' => 'width:70px;'
				 ),
			));
		?>
		</div>
	</td>
	<td style="text-align: center;">		
		<div class="control-group">
		<?php 
			$this->widget('MyDateTimePicker',array(
				'model'=>$modBerlaku,
				'attribute'=>'[0]shiftberlaku_jmasuk',
				'mode'=>'time',
				'options'=> array(
					'dateFormat'=>Params::DATE_FORMAT,
				),
				'htmlOptions'=>array('readonly'=>true,
									  'onkeypress'=>"return $(this).focusNextInputField(event)",
									  'class'=>'required',
									  'style' => 'width:70px;'
				 ),
			));
		?>
		</div>
	</td>
     <td style="text-align: center;">		
		 <div class="control-group">
		<?php 
			$this->widget('MyDateTimePicker',array(
				'model'=>$modBerlaku,
				'attribute'=>'[0]shiftberlaku_jmasuk_akhir',
				'mode'=>'time',
				'options'=> array(
					'dateFormat'=>Params::DATE_FORMAT,
				),
				'htmlOptions'=>array('readonly'=>true,
									  'onkeypress'=>"return $(this).focusNextInputField(event)",
									  'class'=>'required',
									  'style' => 'width:70px;'
				 ),
			));
		?>
		 </div>
	</td>
	<td style="text-align: center;">		
		<div class="control-group">
		<?php 
			$this->widget('MyDateTimePicker',array(
				'model'=>$modBerlaku,
				'attribute'=>'[0]shiftberlaku_jpulang_mulai',
				'mode'=>'time',
				'options'=> array(
					'dateFormat'=>Params::DATE_FORMAT,
				),
				'htmlOptions'=>array('readonly'=>true,
									  'onkeypress'=>"return $(this).focusNextInputField(event)",
									  'class'=>'required',
									  'style' => 'width:70px;'
				 ),
			));
		?>
		</div>
	</td>
	<td style="text-align: center;">	
		<div class="control-group">
		<?php 
			$this->widget('MyDateTimePicker',array(
				'model'=>$modBerlaku,
				'attribute'=>'[0]shiftberlaku_jpulang',
				'mode'=>'time',
				'options'=> array(
					'dateFormat'=>Params::DATE_FORMAT,
				),
				'htmlOptions'=>array('readonly'=>true,
									  'onkeypress'=>"return $(this).focusNextInputField(event)",
									  'class'=>'required',
									  'style' => 'width:70px;'
				 ),
			));
		?>
		</div>
	</td>
	<td style="text-align: center;">		
		<div class="control-group">
		<?php 
			$this->widget('MyDateTimePicker',array(
				'model'=>$modBerlaku,
				'attribute'=>'[0]shiftberlaku_jpulang_akhir',
				'mode'=>'time',
				'options'=> array(
					'dateFormat'=>Params::DATE_FORMAT,
				),
				'htmlOptions'=>array('readonly'=>true,
									  'onkeypress'=>"return $(this).focusNextInputField(event)",
									  'class'=>'required',
									  'style' => 'width:70px;'
				 ),
			));
		?>
		</div>
	</td>
	<td style="text-align: center;">		
		<div class="control-group">
		
		<?php 
			$this->widget('MyDateTimePicker',array(
				'model'=>$modBerlaku,
				'attribute'=>'[0]shiftberlaku_tgl',
				'mode'=>'date',				
				'options'=> array(				
					'changeYear'=>true,
					'changeMonth'=>true,					
					'maxDate'=>'d',		
					'dateFormat'=>Params::DATE_FORMAT,
				),
				
				'htmlOptions'=>array('readonly'=>true,
									  'onkeypress'=>"return $(this).focusNextInputField(event)",
									  'class'=>'required',
									  'style' => 'width:70px;'
				 ),
			));
		?>
		</div>
	</td>
	<td style="text-align: center;" class="rowbutton">
		<?php echo CHtml::link('<i class="icon-plus-sign icon-white"></i>', '#', array('class'=>'btn btn-primary','onclick'=>'tambahLookup()')); ?>
		<?php echo CHtml::link('<i class="icon-minus-sign icon-white"></i>', '#', array('class'=>'btn btn-danger','onclick'=>'hapusLookup(this)')); ?>
	</td>
</tr>

