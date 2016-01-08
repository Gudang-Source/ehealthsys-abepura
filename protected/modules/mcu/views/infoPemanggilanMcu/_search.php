<legend class="rim"><i class="icon-white icon-search"></i> Pencarian</legend>
<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'id'=>'infopemanggilanmcu-search',
	'type'=>'horizontal',
	'focus'=>'#'.CHtml::activeId($model,'nopeserta'),
)); ?>

<div class="row-fluid">
	<div class="span4">
		<div class="control-group ">
			<?php echo CHtml::label('Tanggal Rencana MCU','tglrenkontrol', array('class'=>'control-label')) ?>
			<div class="controls">
				<?php   
				$model->tgl_awal_kontrol = $format->formatDateTimeForUser(date("Y-m-d"));
						$this->widget('MyDateTimePicker',array(
										'model'=>$model,
										'attribute'=>'tgl_awal_kontrol',
										'mode'=>'date',
										'options'=> array(
											'dateFormat'=>Params::DATE_FORMAT,
											'maxDate' => 'd',
										),
										'htmlOptions'=>array('readonly'=>true,'class'=>'dtPicker3','onclick'=>"return $(this).focusNextInputField(event)"),
				)); 
						$model->tgl_awal_kontrol = $format->formatDateTimeForDb($model->tgl_awal_kontrol);
					?> 
			</div>
		</div>
		<div class="control-group ">
		<label class="control-label">
		   Sampai dengan
		</label>
			<div class="controls">
				<?php    
					$model->tgl_akhir_kontrol = $format->formatDateTimeForUser(date("Y-m-d"));
					$this->widget('MyDateTimePicker',array(
										'model'=>$model,
										'attribute'=>'tgl_akhir_kontrol',
										'mode'=>'date',
										'options'=> array(
											'dateFormat'=>Params::DATE_FORMAT,
											'maxDate' => 'd',
										),
										'htmlOptions'=>array('readonly'=>true,'class'=>'dtPicker3','onclick'=>"return $(this).focusNextInputField(event)"),
					)); 
					$model->tgl_akhir_kontrol = $format->formatDateTimeForDb($model->tgl_akhir_kontrol);
					?>
			</div>
		</div>
	</div>
        <div class="span4">
                <div class="control-group ">
			<?php echo CHtml::activeLabel($model,'nopeserta',array('class'=>'control-label')); ?>
			<div class="controls">
			   <?php echo $form->textField($model,'nopeserta',array('placeholder'=>'Ketik No. Peserta', 'class'=>'span3', 'maxlength'=>20,'onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
			</div>
		</div>
                <div class="control-group ">
			<?php echo CHtml::activeLabel($model,'no_rekam_medik',array('class'=>'control-label')); ?>
			<div class="controls">
			   <?php echo $form->textField($model,'no_rekam_medik',array('placeholder'=>'Ketik No. Rekam Medik', 'class'=>'span3', 'maxlength'=>20,'onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
			</div>
		</div>
        </div>
	<div class="span4">
		<div class="control-group ">
			<?php echo CHtml::activeLabel($model,'nama_pasien',array('class'=>'control-label')); ?>
			<div class="controls">
			   <?php echo $form->textField($model,'nama_pasien', array('placeholder'=>'Ketik Nama Pasien', 'class'=>'span3', 'maxlength'=>20,'onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
			</div>
		</div>
		<div class="control-group ">
			<?php echo CHtml::activeLabel($model,'status_hubungan',array('class'=>'control-label')); ?>
			<div class="controls">
			   <?php echo $form->dropDownList($model,'status_hubungan', LookupM::getItems('statuskeluargaasuransi') ,array('empty' => '-- Pilih --', 'class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
			</div>
		</div>
	</div>
</div>
<div class="form-actions">
	<?php echo CHtml::htmlButton(Yii::t('mds','{icon} Cari',array('{icon}'=>'<i class="icon-search icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit')); ?>
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
