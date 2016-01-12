<div class="row-fluid">
	<div class="span4">
		<div class="control-group ">
			<?php echo $form->labelEx($model, 'tglpeminjamanrm', array('class' => 'control-label')) ?>
			<div class="controls">
				<?php
				$model->tglpeminjamanrm = isset($model->tglpeminjamanrm) ? date('d/m/Y H:i:s',strtotime($model->tglpeminjamanrm)) : date('d/m/Y H:i:s');
				$this->widget('MyDateTimePicker', array(
					'model' => $model,
					'attribute' => 'tglpeminjamanrm',
					'mode' => 'datetime',
					'options' => array(
						'dateFormat' => Params::DATE_FORMAT,
					),
					'htmlOptions' => array('readonly' => false, 'placeholder'=>'00:00:0000 00:00:00','class' => 'dtPicker3 datetimemask','onkeypress'=>'return $(this).focusNextInputField(event)',),
				));
				?>
			</div>
		</div>
		<div class="control-group ">
			<?php echo $form->labelEx($model, 'tglakandikembalikan', array('class' => 'control-label')) ?>
			<div class="controls">
				<?php
				$model->tglakandikembalikan = isset($model->tglakandikembalikan) ? date('d/m/Y H:i:s',strtotime($model->tglakandikembalikan)) : date('d/m/Y H:i:s');
				$this->widget('MyDateTimePicker', array(
					'model' => $model,
					'attribute' => 'tglakandikembalikan',
					'mode' => 'datetime',
					'options' => array(
						'dateFormat' => Params::DATE_FORMAT,
					),
					'htmlOptions' => array('readonly' => false, 'placeholder'=>'00:00:0000 00:00:00','class' => 'dtPicker3 datetimemask','onkeypress'=>'return $(this).focusNextInputField(event)',),
				));
				?>
			</div>
		</div>
		<div class="control-group ">
			<?php echo CHtml::activeLabel($model, 'namapeminjam', array('class' => 'control-label')); ?>
			<div class="controls">
				<?php
				$this->widget('MyJuiAutoComplete', array(
					'model' => $model,
					'attribute' => 'namapeminjam',
					'value' => '',
					'sourceUrl' => $this->createUrl('GetNamaPeminjam'),
					'options' => array(
						'showAnim' => 'fold',
						'minLength' => 2,
						'focus' => 'js:function( event, ui ) {
								$(this).val(ui.item.namapeminjam);
								return false;
							}',
						'select' => 'js:function( event, ui ) {
								$("#'.CHtml::activeId($model, 'namapeminjam') . '").val(ui.item.nama_pegawai);
								return false; }',
					),
					'htmlOptions'=>array(
						'onkeypress'=>'return $(this).focusNextInputField(event)',
						'disabled'=>($model->isNewRecord)?'':'disabled', 
					),
					'tombolDialog'=>array('idDialog'=>'dialogNamaPeminjam'),
				));
				?>
			</div>
		</div>
	</div>
	<div class="span4">
		<?php
			echo $form->dropDownListRow($model, 'instalasi_id', CHtml::listData(InstalasiM::model()->findAll('instalasi_aktif = true'), 'instalasi_id', 'instalasi_nama'), array('empty' => '-- Pilih --', 'class' => 'span2', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50,'style'=>'width:200px;',
				'ajax' => array('type' => 'POST',
					'url' => $this->createUrl('SetDropdownRuangan', array('encode' => false, 'model_nama' => get_class($model))),
					'update' => '#' . CHtml::activeId($model, 'ruangan_id') . ''),));
		?>
		<?php echo $form->dropDownListRow($model, 'ruangan_id', CHtml::listData(RuanganM::model()->findAllByAttributes(array('instalasi_id' => $model->instalasi_id, 'ruangan_aktif' => true)), 'ruangan_id', 'ruangan_nama'), array('empty' => '-- Pilih --', 'class' => 'span2','style'=>'width:200px;', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
		<?php echo $form->textFieldRow($model,'untukkepentingan',array('disabled'=>($model->isNewRecord)?'':'disabled', 'class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>50, 'placeholder'=>'Alasan peminjaman', 'autofocus'=>true)); ?>
	</div>
	<div class="span4">
		<?php echo $form->textAreaRow($model,'keteranganpeminjaman',array('disabled'=>($model->isNewRecord)?'':'disabled', 'rows'=>4, 'cols'=>7, 'class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'placeholder'=>'Ket. peminjaman berkas')); ?>
	</div>
</div>