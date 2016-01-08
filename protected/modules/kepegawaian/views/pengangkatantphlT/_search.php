<legend class="rim"><i class="icon-search icon-white"></i> Pencarian</legend>

<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'id'=>'kppengangkatantphl-t-form',
	'type'=>'horizontal',
	'focus'=>'#'.CHtml::activeId($model,'nomorindukpegawai'),
)); ?>

<div class="row-fluid">
	<div class="span4">
		<?php
			$format = new MyFormatter();
			$model->tgl_awal = $format->formatDateTimeForUser($model->tgl_awal);
			$model->tgl_akhir = $format->formatDateTimeForUser($model->tgl_akhir);
		?>
		<div class="control-group ">
			<?php echo CHtml::label('TMT','', array('class'=>'control-label')) ?>
			<div class="controls">
				 <?php 
					$model->tgl_awal = isset($model->tgl_awal) ? MyFormatter::formatDateTimeForUser($model->tgl_awal) : null;
					$this->widget('MyDateTimePicker',array(
											'model'=>$model,
											'attribute'=>'tgl_awal',
											'mode'=>'date',
											'options'=> array(
												'dateFormat'=>Params::DATE_FORMAT,
											),
											'htmlOptions'=>array('readonly'=>true,
																  'onkeypress'=>"return $(this).focusNextInputField(event)",
																  'class'=>'dtPicker3',
												),
					)); ?> 
			</div>
		</div>
		<div class="control-group ">
			<label class='control-label'>Sampai Dengan</label>
			<div class="controls">
				<?php 
				$model->tgl_akhir = isset($model->tgl_akhir) ? MyFormatter::formatDateTimeForUser($model->tgl_akhir) : null;
				$this->widget('MyDateTimePicker',array(
											'model'=>$model,
											'attribute'=>'tgl_akhir',
											'mode'=>'date',
											'options'=> array(
												'dateFormat'=>Params::DATE_FORMAT,
											),
											'htmlOptions'=>array('readonly'=>true,
																  'onkeypress'=>"return $(this).focusNextInputField(event)",
																  'class'=>'dtPicker3',
												),
					)); ?> 
			</div>
		</div>
	</div>
	<div class="span4">
		<?php echo $form->textFieldRow($model,'nomorindukpegawai',array('class'=>'span3', 'maxlength'=>20)); ?>
		<?php echo $form->textFieldRow($model,'nama_pegawai',array('class'=>'span3', 'maxlength'=>10)); ?>
	</div>
	<div class="span4">
		<?php echo $form->textFieldRow($model,'pengangkatantphl_nosk',array('class'=>'span3','maxlength'=>50)); ?>
	</div>
</div>
<div class="form-actions">
		<?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="icon-search icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit')); ?>
		<?php echo CHtml::link(Yii::t('mds', '{icon} Reset', array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), $this->createUrl('PengangkatantphlT/Informasi'), array('class'=>'btn btn-danger')); ?>
		<?php
			$content = $this->renderPartial('../tips/informasi_pengangkatanTphl',array(),true);
			$this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); 
		?>

</div>
<?php $this->endWidget(); ?>
