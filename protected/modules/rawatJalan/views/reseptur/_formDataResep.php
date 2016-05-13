<?php echo CHtml::hiddenField('url',$this->createUrl('',array('pendaftaran_id'=>$modPendaftaran->pendaftaran_id)),array('readonly'=>TRUE));?>
<?php echo CHtml::hiddenField('berubah','',array('readonly'=>TRUE));?> 

<div class="span6">
	<div class="control-group ">
		<?php $modReseptur->tglreseptur = Yii::app()->dateFormatter->formatDateTime(CDateTimeParser::parse($modReseptur->tglreseptur, 'yyyy-MM-dd hh:mm:ss','medium',null)); ?>
		<?php echo $form->labelEx($modReseptur,'tglreseptur', array('class'=>'control-label')) ?>
		<div class="controls">
			<?php   
					$this->widget('MyDateTimePicker',array(
									'model'=>$modReseptur,
									'attribute'=>'tglreseptur',
									'mode'=>'datetime',
									'options'=> array(
										'dateFormat'=>Params::DATE_FORMAT,
										'maxDate' => 'd',
										'yearRange'=> "-60:+0",
									),
									'htmlOptions'=>array('readonly'=>true,'class'=>'dtPicker3 realtime', 'onkeypress'=>"return $(this).focusNextInputField(event)"
									),
			)); ?>
			<?php echo $form->error($modReseptur, 'tglreseptur'); ?>
		</div>
	</div>
	<div class="control-group">
		<?php echo $form->labelEx($modReseptur,'noresep', array('class'=>'control-label')) ?>
		<div class="controls">
			<?php echo $form->textField($modReseptur,'noresep',array('readonly'=>true, 'style'=>'width:170px;', )); ?><br>
		</div>
	</div>
	<div class="control-group">
		<?php echo CHtml::label('Jenis Resep','Jenis Resep', array('class'=>'control-label')) ?>
		<div class="controls">
			<?php
			echo CHtml::dropDownList('jenisresep','',
				array(0=>'Non Racikan',1=>'Racikan'),
				array('key'=>'jenisresep', 'class'=>'span3','onchange'=>'formjenisresep(this.value); setDropDownRke();')
			);
			?><br>
		</div>
	</div>
</div>
 <div class="span6">
	<?php echo $form->dropDownListRow($modReseptur,'pegawai_id',CHtml::listData($modReseptur->getDokterItems(), 'pegawai_id', 'NamaLengkap'),array('onkeypress'=>"return $(this).focusNextInputField(event)"));?>
	<?php echo $form->dropDownListRow($modReseptur,'ruangan_id',CHtml::listData($modReseptur->ApotekRawatJalan, 'ruangan_id', 'ruangan_nama'),array('onkeypress'=>"return $(this).focusNextInputField(event)",'options'=>array('Params::RUANGAN_ID_APOTEK_1'=>'selected'),'onchange'=>'setOaByRuangTujuan(this)'));?>
	<div class="control-group ">
		<label class="control-label" for="iter">Iter</label>
		<div class="controls">
			<?php echo CHtml::textField('iter', '0', array('readonly'=>false,'onkeypress'=>"return $(this).focusNextInputField(event)",'class'=>'inputFormTabel span1  numbers-only')) ?>
		</div>
	</div>
</div>