<div class="row-fluid">
	<div class="span4">
		<?php echo $form->hiddenField($model,'pasien_id',array('class'=>'span3', 'readonly'=>true, 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
		<?php echo $form->hiddenField($model,'pendaftaran_id',array('class'=>'span3', 'readonly'=>true,'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
		<?php echo $form->hiddenField($model,'dokrekammedis_id',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
		<?php echo $form->hiddenField($model,'pengirimanrm_id',array('class'=>'span3', 'readonly'=>true,'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
		<?php echo CHtml::hiddenField('ruangan_id','',array('class'=>'span3', 'readonly'=>true,'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
		<div class="control-group ">
			<?php echo CHtml::label(" No Rekam Medik <font style='color:red'>*</font> ", 'no_rekam_medik', array('class' => 'control-label')); ?>
			<div class="controls">
				<?php
				$this->widget('MyJuiAutoComplete', array(
					'model' => $model,
					'attribute' => 'no_rekam_medik',
					'value' => '',
					'sourceUrl' => $this->createUrl('PasienLamauntukPeminjaman'),
					'options' => array(
						'showAnim' => 'fold',
						'minLength' => 2,
						'focus' => 'js:function( event, ui ) {
								$(this).val(ui.item.label);
								return true;
							}',
						'select' => 'js:function( event, ui ) {
							$(this).val(ui.item.label);
							$("#'.CHtml::activeId($model,'jenis_kelamin').'").val(ui.item.jeniskelamin);
							$("#'.CHtml::activeId($model,'nama_pasien').'").val(ui.item.nama_pasien);
							$("#'.CHtml::activeId($model,'tanggal_lahir').'").val(ui.item.tanggal_lahir);
							$("#'.CHtml::activeId($model,'dokrekammedis_id').'").val(ui.item.dokrekammedis_id);
							$("#'.CHtml::activeId($model,'pasien_id').'").val(ui.item.pasien_id);
							$("#'.CHtml::activeId($model,'pendaftaran_id').'").val(ui.item.pendaftaran_id);
							$("#'.CHtml::activeId($model,'lokasirak_nama').'").val(ui.item.lokasirak_nama);
							$("#'.CHtml::activeId($model,'subrak_nama').'").val(ui.item.subrak_nama);
							$("#'.CHtml::activeId($model,'warnadokrm_namawarna').'").val(ui.item.warnadokrm_namawarna);
							$("#ruangan_id").val(ui.item.ruangan_id);
							setUmur(ui.item.tanggal_lahir);
							return true;
						}',
					),
					'htmlOptions'=>array(
						'onkeypress'=>'return $(this).focusNextInputField(event)',
						'disabled'=>($model->isNewRecord)?'':'disabled', 
                                                'class' => 'required numbers-only',
                                                'maxlength' => 6
					),
					'tombolDialog'=>array('idDialog'=>'dialogRekamMedik'),

				));
				?>
			</div>
		</div>
		<?php echo $form->textFieldRow($model, 'nama_pasien',array('class'=>'span3', 'readonly'=>true, 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>100)); ?>
	</div>
	<div class="span4">
		<?php echo $form->textFieldRow($model, 'jenis_kelamin',array('class'=>'span3', 'readonly'=>true, 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>100)); ?>
		<?php echo $form->textFieldRow($model, 'tanggal_lahir',array('class'=>'span3', 'readonly'=>true, 'onblur'=>'setUmur(this.value);', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>100)); ?>
		<?php echo $form->textFieldRow($model, 'umur',array('class'=>'span3', 'readonly'=>true, 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>100)); ?>
	</div>
	<div class="span4">
		<div class="control-group">
			<?php echo CHtml::label('Lokasi Rak','',array('class'=>'control-label')); ?>
			<div class="controls">
				<?php echo $form->textField($model, 'lokasirak_nama',array('class'=>'span3', 'readonly'=>true, 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>100)); ?>
			</div>
		</div>
		<div class="control-group">
			<?php echo CHtml::label('Sub Rak','',array('class'=>'control-label')); ?>
			<div class="controls">
				<?php echo $form->textField($model, 'subrak_nama',array('class'=>'span3', 'readonly'=>true, 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>100)); ?>
			</div>
		</div>
		<div class="control-group">
			<?php echo CHtml::label('Warna Dok. RM','',array('class'=>'control-label')); ?>
			<div class="controls">
				<?php echo $form->textField($model, 'warnadokrm_namawarna',array('class'=>'span3', 'readonly'=>true, 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>100)); ?>
			</div>
		</div>
	</div>
</div>