<legend class="rim"><i class="icon-white icon-search"></i> Pencarian</legend>
<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'id'=>'jadwalpegawai-info-search',
	'type'=>'horizontal',
)); ?>
<div class="row-fluid">
	<div class="span4">
		<div class="control-group ">
			<?php echo CHtml::label('Tanggal Jadwal','tglbuatjadwal', array('class'=>'control-label')) ?>
			<div class="controls">
				<?php   
				$model->tgl_awal = $format->formatDateTimeForUser($model->tgl_awal);
						$this->widget('MyDateTimePicker',array(
										'model'=>$model,
										'attribute'=>'tgl_awal',
										'mode'=>'date',
										'options'=> array(
											'dateFormat'=>Params::DATE_FORMAT,
											'maxDate' => 'd',
										),
										'htmlOptions'=>array('readonly'=>true,'class'=>'dtPicker3','onclick'=>"return $(this).focusNextInputField(event)"),
				)); 
						$model->tgl_awal = $format->formatDateTimeForDb($model->tgl_awal);
					?> 
			</div>
		</div>
		<div class="control-group ">
		<label for="namaPasien" class="control-label">
		   Sampai dengan
		</label>
			<div class="controls">
				<?php    
					$model->tgl_akhir = $format->formatDateTimeForUser($model->tgl_akhir);
					$this->widget('MyDateTimePicker',array(
										'model'=>$model,
										'attribute'=>'tgl_akhir',
										'mode'=>'date',
										'options'=> array(
											'dateFormat'=>Params::DATE_FORMAT,
											'maxDate' => 'd',
										),
										'htmlOptions'=>array('readonly'=>true,'class'=>'dtPicker3','onclick'=>"return $(this).focusNextInputField(event)"),
					)); 
					$model->tgl_akhir = $format->formatDateTimeForDb($model->tgl_akhir);
					?>
			</div>
		</div>
		<div class="control-group ">
			<?php echo CHtml::activeLabel($model,'nama_pegawai',array('class'=>'control-label')); ?>
			<div class="controls">
			   <?php echo $form->textField($model,'nama_pegawai',array('class'=>'span3', 'maxlength'=>20,'onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
			</div>
		</div>		
	</div>
	<div class="span4">
		<div class="control-group ">
			<?php echo CHtml::activeLabel($model,'instalasi_id',array('class'=>'control-label')); ?>
			<div class="controls">
			   <?php echo $form->dropDownList($model,'instalasi_id', CHtml::listData(InstalasiM::model()->findAll('instalasi_aktif = true order by instalasi_nama'), 'instalasi_id', 'instalasi_nama'),array('empty'=>'-- Pilih --','class'=>'span3', 'maxlength'=>20,'onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
			</div>
		</div>
		<div class="control-group ">
			<?php echo CHtml::activeLabel($model,'ruangan_id',array('class'=>'control-label')); ?>
			<div class="controls">
			   <?php echo $form->dropDownList($model,'ruangan_id', CHtml::listData(RuanganM::model()->findAll('ruangan_aktif = true order by ruangan_nama'), 'ruangan_id', 'ruangan_nama'),array('empty'=>'-- Pilih --','class'=>'span3', 'maxlength'=>20,'onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
			</div>
		</div>
		<div class="control-group ">
			<?php echo CHtml::activeLabel($model,'shift_id',array('class'=>'control-label')); ?>
			<div class="controls">
			   <?php echo $form->dropDownList($model,'shift_id', CHtml::listData(ShiftM::model()->findAll('shift_aktif = true order by shift_nama'), 'shift_id', 'shift_nama'),array('empty'=>'-- Pilih --','class'=>'span3', 'maxlength'=>20,'onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
			</div>
		</div>		
	</div>
	<div class="control-group ">
		<?php echo CHtml::activeLabel($model,'kelompokpegawai_id',array('class'=>'control-label')); ?>
		<div class="controls">
		   <?php echo $form->dropDownList($model,'kelompokpegawai_id', CHtml::listData(KelompokpegawaiM::model()->findAll('kelompokpegawai_aktif = true order by kelompokpegawai_nama'), 'kelompokpegawai_id', 'kelompokpegawai_nama'),array('empty'=>'-- Pilih --','class'=>'span3', 'maxlength'=>20,'onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
		</div>
	</div>
</div>
<div class="form-actions">
	<?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="icon-search icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit')); ?>
	<?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
						$this->createUrl($this->id.'/index'), 
						array('class'=>'btn btn-danger',
							  'onclick'=>'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;')); ?>
	<?php  
		$content = $this->renderPartial($this->path_view.'tips.informasi',array(),true);
		$this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); 
	?>  
</div>

<?php $this->endWidget(); ?>
