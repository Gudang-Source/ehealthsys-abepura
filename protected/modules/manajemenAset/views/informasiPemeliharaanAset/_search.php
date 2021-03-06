<legend class="rim"><i class="icon-white icon-search"></i> Pencarian</legend>
<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'id'=>'pemeliharaanaset-info-search',
	'type'=>'horizontal',
	'focus'=>'#'.CHtml::activeId($model,'pemeliharaanaset_no'),
)); ?>
<div class="row-fluid">
	<div class="span4">
		<div class="control-group ">
			<?php echo CHtml::label('Tanggal Pemeliharaan','pemeliharaanaset_tgl', array('class'=>'control-label')) ?>
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
						//$model->tgl_awal = $format->formatDateTimeForDb($model->tgl_awal);
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
					//$model->tgl_akhir = $format->formatDateTimeForDb($model->tgl_akhir);
					?>
			</div>
		</div>
		<div class="control-group ">
			<?php echo CHtml::activeLabel($model,'pemeliharaanaset_no',array('class'=>'control-label')); ?>
			<div class="controls">
			   <?php echo $form->textField($model,'pemeliharaanaset_no',array('placeholder'=>'Ketik No. Pemeliharaan Aset', 'class'=>'span3', 'maxlength'=>20,'onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
			</div>
		</div>
	</div>
	<div class="span4">
		<div class="control-group ">
			<div class="controls">
				<?php echo $form->textAreaRow($model,'pemeliharaanaset_ket',array('rows'=>4, 'cols'=>200, 'class'=>'span4', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
			   <?php // echo $form->dropDownList($model,'instalasi_id', CHtml::listData(InstalasiM::model()->findAll('instalasi_aktif = true order by instalasi_nama'), 'instalasi_id', 'instalasi_nama'),array('empty'=>'-- Pilih --','class'=>'span3', 'maxlength'=>20,'onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
			</div>
		</div>
	</div>
        <div class="span4">
		<div class="control-group ">
                    <?php echo Chtml::label('Pegawai Mengetahui','pegawaimengetahui_id',array('class'=>'control-label')) ?>
			<div class="controls">
				<?php echo $form->dropDownList($model,'pegawaimengetahui_id', CHtml::listData(PegawairuanganV::model()->findAll("pegawai_aktif = TRUE AND ruangan_id = '".Yii::app()->user->getState('ruangan_id')."' ORDER BY nama_pegawai ASC"), 'pegawai_id', 'namaLengkap'),array('empty'=>'-- Pilih --', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
			   <?php // echo $form->dropDownList($model,'instalasi_id', CHtml::listData(InstalasiM::model()->findAll('instalasi_aktif = true order by instalasi_nama'), 'instalasi_id', 'instalasi_nama'),array('empty'=>'-- Pilih --','class'=>'span3', 'maxlength'=>20,'onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
			</div>
		</div>
	</div>
</div>
<div class="form-actions">
	<?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="icon-search icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit')); ?>
	<?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
						$this->createUrl($this->id.'/index'), 
						array('class'=>'btn btn-danger',
							  'onclick'=>'myConfirm("Apakah Anda yakin ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;')); ?>
	<?php  
		$content = $this->renderPartial('../tips/informasi',array(),true);
		$this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); 
	?>  
</div>

<?php $this->endWidget(); ?>