<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
    'action'=>Yii::app()->createUrl($this->route),
    'method'=>'get',
    'id'=>'search',
	'type'=>'horizontal',
)); ?>
<div class="row-fluid">
	<div class="span4">
		<div class="control-group ">
			<?php echo $form->labelEx($model, 'tglrekammedis', array('class' => 'control-label')) ?>
			<div class="controls">
				<?php
					$model->tgl_rekam_medik = MyFormatter::formatDateTimeForUser($model->tgl_rekam_medik);				
					$this->widget('MyDateTimePicker', array(
						'model' => $model,
						'attribute' => 'tgl_rekam_medik',
						'mode' => 'date',
						'options' => array(
							'dateFormat' => Params::DATE_FORMAT,
						),
						'htmlOptions' => array('readonly' => true, 'class' => 'dtPicker3'),
					));
					$model->tgl_rekam_medik = MyFormatter::formatDateTimeForDb($model->tgl_rekam_medik);				
				?>
			</div>
		</div>
		<div class="control-group ">
			<?php echo CHtml::label('Sampai dengan','', array('class' => 'control-label')) ?>
			<div class="controls">
				<?php
					$model->tgl_rekam_medik_akhir = MyFormatter::formatDateTimeForUser($model->tgl_rekam_medik_akhir);
					$this->widget('MyDateTimePicker', array(
						'model' => $model,
						'attribute' => 'tgl_rekam_medik_akhir',
						'mode' => 'date',
						'options' => array(
							'dateFormat' => Params::DATE_FORMAT,
						),
						'htmlOptions' => array('readonly' => true, 'class' => 'dtPicker3'),
					));
					$model->tgl_rekam_medik_akhir = MyFormatter::formatDateTimeForDb($model->tgl_rekam_medik_akhir);
				?>
			</div>
		</div>
		<?php echo $form->textFieldRow($model, 'no_rekam_medik', array('class' => 'span3', 'maxlength' => 10)); ?>
		<div class="control-group ">
			<?php echo CHtml::label('Sampai dengan','', array('class' => 'control-label')) ?>
			<div class='controls'>
				<?php echo $form->textField($model, 'no_rekam_medik_akhir', array('class' => 'span3', 'maxlength' => 10)); ?>
			</div>
		</div>
	</div>
	<div class="span4">
		<?php echo $form->textFieldRow($model, 'no_pendaftaran', array('class' => 'span3', 'maxlength' => 20)); ?>
		<?php echo $form->textFieldRow($model, 'nama_pasien', array('class' => 'span3', 'maxlength' => 50)); ?>
	</div>
	<div class="span4">		
		<?php
			echo $form->dropDownListRow($model, 'instalasi_id', CHtml::listData(InstalasiM::model()->findAll('instalasi_aktif = true'), 'instalasi_id', 'instalasi_nama'), array('empty' => '-- Pilih --', 'class' => 'span2', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50,'style'=>'width:200px;',
				'ajax' => array('type' => 'POST',
				'url' => $this->createUrl('SetDropdownRuangan', array('encode' => false, 'model_nama' => get_class($model))),
				'update' => '#' . CHtml::activeId($model, 'ruangan_id') . ''),));
		?>
		<?php echo $form->dropDownListRow($model, 'ruangan_id', CHtml::listData(RuanganM::model()->findAllByAttributes(array('instalasi_id' => $model->instalasi_id, 'ruangan_aktif' => true)), 'ruangan_id', 'ruangan_nama'), array('empty' => '-- Pilih --', 'class' => 'span2','style'=>'width:200px;', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
	</div>
</div>
<div class="form-actions">
	<?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="icon-search icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit')); ?>
</div>
<?php $this->endWidget(); ?>