<div class="search-form">
<?php
	$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
		'action' => Yii::app()->createUrl($this->route),
		'method' => 'get',
		'id' => 'pencarianpendaftaran-form',
		'type' => 'horizontal',
		'htmlOptions' => array(
		'enctype' => 'multipart/form-data', 'onKeyPress' => 'return disableKeyPress(event)'),
	));
?>
<div class="row-fluid">
    <div class = "span4">
		<div class="control-group ">
			<?php echo CHtml::label('Tgl. Pendaftaran', '', array('class' => 'control-label')) ?>
			<div class="controls">
				<?php   
					$modPendaftaran->tgl_awal = $format->formatDateTimeForUser($modPendaftaran->tgl_awal);
					$this->widget('MyDateTimePicker',array(
						'model'=>$modPendaftaran,
						'attribute'=>'tgl_awal',
						'mode'=>'date',
						'options'=> array(
							'dateFormat'=>Params::DATE_FORMAT,
							'maxDate'=>'d',
						),
						'htmlOptions'=>array('class'=>'dtPicker2','onkeyup'=>"return $(this).focusNextInputField(event)"
						),
					));
					$modPendaftaran->tgl_awal = $format->formatDateTimeForDb($modPendaftaran->tgl_awal);;
				?>
			</div>
		</div>
		<div class="control-group ">
			<?php echo CHtml::label('Sampai dengan', '', array('class' => 'control-label')) ?>
			<div class="controls">
				<?php   
					$modPendaftaran->tgl_akhir = $format->formatDateTimeForUser($modPendaftaran->tgl_akhir);
					$this->widget('MyDateTimePicker',array(
						'model'=>$modPendaftaran,
						'attribute'=>'tgl_akhir',
						'mode'=>'date',
						'options'=> array(
							'dateFormat'=>Params::DATE_FORMAT,
							'maxDate'=>'d',
						),
						'htmlOptions'=>array('class'=>'dtPicker2','onkeyup'=>"return $(this).focusNextInputField(event)"
						),
					));
					$modPendaftaran->tgl_akhir = $format->formatDateTimeForDb($modPendaftaran->tgl_akhir);;
				?>
			</div>
		</div>
		<div class="control-group">
		<?php echo CHtml::label('No. Pendaftaran', 'no_pendaftaran', array('class' => 'control-label')) ?>
		
		<div class="controls">
		<?php echo $form->textField($modPendaftaran,'no_pendaftaran', array('id'=>'ARPendaftaranT_no_pendaftaran','class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>25)); ?>
		</div>
		</div>
	</div>
	<div class="span4">
			<div class="control-group">
				<?php echo CHtml::label('Cara Bayar	<span class="required">*</span>', 'cara bayar',array('class'=>'control-label')); ?>
				<div class="controls">
						<?php 
							echo CHtml::activeDropDownList($modPendaftaran,'carabayar_id', CHtml::listData($modPendaftaran->getCaraBayarItems(), 'carabayar_id', 'carabayar_nama') ,
										array('style'=>'width:120px;','empty'=>'-- Pilih --','onkeypress'=>"return $(this).focusNextInputField(event)",
												'ajax' => array('type'=>'POST',
													'url'=> $this->createUrl('GetPenjaminPasien',array('encode'=>false,'namaModel'=>'ARPendaftaranT')), 
												'update'=>'#ARPendaftaranT_penjamin_id'  //selector to update
										),
							)); 
						?>
				</div>
			</div>
			<div class="control-group">
				<?php echo CHtml::label('Penjamin <span class="required">*</span>', 'penjamin',array('class'=>'control-label')); ?>
				<div class="controls">
						<?php 
							echo CHtml::activeDropDownList($modPendaftaran,'penjamin_id', CHtml::listData($modPendaftaran->getPenjaminItems($modPendaftaran->carabayar_id), 
									'penjamin_id', 'penjamin_nama') ,array('style'=>'width:120px;','empty'=>'-- Pilih --',
												'onkeypress'=>"return $(this).focusNextInputField(event)",)); 
						?> 
				</div>
			</div>
	</div>
</div>
<div class="form-actions">
	<?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="icon-search icon-white"></i>')), array('class' => 'btn btn-primary', 'type' => 'submit', 'onKeyPress'=>'ajaxGetList()', 'onClick' => 'ajaxGetList()')); ?>
    <span>&nbsp;</span>
<?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="icon-refresh icon-white"></i>')), array('class' => 'btn btn-danger', 'type' => 'reset', 'onClick' => 'onReset()')); ?>
</div>
<?php $this->endWidget(); ?>
</div>


