<div class="row-fluid">
	<div class="span4">
		<div class="control-group ">
			<?php echo $form->labelEx($model,'tglretur', array('class'=>'control-label required')) ?>
			<div class="controls">  
			 <?php $this->widget('MyDateTimePicker',array(
									'model'=>$model,
									'attribute'=>'tglretur',
									'mode'=>'datetime',
									'options'=> array(
										'maxDate'=>'d',
										'dateFormat'=>Params::DATE_FORMAT,
								),
									'htmlOptions'=>array('readonly'=>true,
									'onkeyup'=>"return $(this).focusNextInputField(event)",
									'class'=>'span2 realtime'),
							)); ?>
			</div> 
		</div>
		<?php echo $form->textAreaRow($model,'alasanretur',array('class'=>'span3 required','readonly'=>false, 'onkeyup'=>"return $(this).focusNextInputField(event)")); ?>
		</div>
	<div class="span4">
		<?php echo $form->textFieldRow($model,'noreturresep',array('class'=>'span3','readonly'=>true,'onkeyup'=>"return $(this).focusNextInputField(event)")); ?>
		<?php echo $form->textAreaRow($model,'keteranganretur',array('class'=>'span3','readonly'=>false, 'onkeyup'=>"return $(this).focusNextInputField(event)")); ?>
	</div>
	<div class="span4">
		<?php echo $form->dropDownListRow($model,'pegretur_id', CHtml::listData(PegawairuanganV::model()->findAllByAttributes(array('ruangan_id'=>Yii::app()->user->getState('ruangan_id')), array('order'=>'nama_pegawai')), 'pegawai_id', 'nama_pegawai'),array('empty'=>'-- Pilih --','class'=>'span3 required','readonly'=>false, 'onkeyup'=>"return $(this).focusNextInputField(event)")); ?>
		<?php echo $form->dropDownListRow($model,'mengetahui_id', CHtml::listData(PegawairuanganV::model()->findAllByAttributes(array('ruangan_id'=>Yii::app()->user->getState('ruangan_id')), array('order'=>'nama_pegawai')), 'pegawai_id', 'nama_pegawai'),array('empty'=>'-- Pilih --','class'=>'span3','readonly'=>false, 'onkeyup'=>"return $(this).focusNextInputField(event)")); ?>
	</div>
</div>