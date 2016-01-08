<legend class="rim"><i class="icon-white icon-search"></i> Pencarian</legend>
<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'id'=>'penerimaanlinen-info-search',
	'type'=>'horizontal',
	'focus'=>'#'.CHtml::activeId($modPenerimaanlinen,'nopenerimaanlinen'),
)); ?>
<div class="row-fluid">
	<div class="span4">
		<div class="control-group ">
			<?php echo CHtml::label('Tanggal Penerimaan','tglpenerimaanlinen', array('class'=>'control-label')) ?>
			<div class="controls">
				<?php   
				$modPenerimaanlinen->tgl_awal = $format->formatDateTimeForUser($modPenerimaanlinen->tgl_awal);
						$this->widget('MyDateTimePicker',array(
										'model'=>$modPenerimaanlinen,
										'attribute'=>'tgl_awal',
										'mode'=>'date',
										'options'=> array(
											'dateFormat'=>Params::DATE_FORMAT,
											'maxDate' => 'd',
										),
										'htmlOptions'=>array('readonly'=>true,'class'=>'dtPicker3','onclick'=>"return $(this).focusNextInputField(event)"),
				)); 
						$modPenerimaanlinen->tgl_awal = $format->formatDateTimeForDb($modPenerimaanlinen->tgl_awal);
					?> 
			</div>
		</div>
		<div class="control-group ">
		<label class="control-label">
		   Sampai dengan
		</label>
			<div class="controls">
				<?php    
					$modPenerimaanlinen->tgl_akhir = $format->formatDateTimeForUser($modPenerimaanlinen->tgl_akhir);
					$this->widget('MyDateTimePicker',array(
										'model'=>$modPenerimaanlinen,
										'attribute'=>'tgl_akhir',
										'mode'=>'date',
										'options'=> array(
											'dateFormat'=>Params::DATE_FORMAT,
											'maxDate' => 'd',
										),
										'htmlOptions'=>array('readonly'=>true,'class'=>'dtPicker3','onclick'=>"return $(this).focusNextInputField(event)"),
					)); 
					$modPenerimaanlinen->tgl_akhir = $format->formatDateTimeForDb($modPenerimaanlinen->tgl_akhir);
					?>
			</div>
		</div>
	</div>
	<div class="span4">
		<div class="control-group ">
			<?php echo CHtml::label('Instalasi','Instalasi', array('class'=>'control-label')) ?>
			<div class="controls">
			<?php echo $form->dropDownList($modPenerimaanlinen,'instalasi_id', CHtml::listData(InstalasiM::model()->findAll(),'instalasi_id','instalasi_nama'),
					array('class'=>'span3','empty'=>'-- Pilih --', 'onkeyup'=>"return $(this).focusNextInputField(event)", 
							'ajax'=>array('type'=>'POST',
										'url'=>$this->createUrl('SetDropdownRuangan',array('encode'=>false,'model_nama'=>get_class($modPenerimaanlinen))),
										'update'=>"#".CHtml::activeId($modPenerimaanlinen, 'ruangan_id'),
							)));?>
			</div>
		</div>
		<div class="control-group ">
			<?php echo CHtml::label('Ruangan','Ruangan', array('class'=>'control-label inline')) ?>
			<div class="controls">
				<?php echo $form->dropDownList($modPenerimaanlinen,'ruangan_id',CHtml::listData(RuanganM::model()->findAll(),'ruangan_id','ruangan_nama'),array('class'=>'span3','empty'=>'-- Pilih --','onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
			</div>
		</div>
	</div>
	<div class="span4">
		<div class="control-group ">
			<?php echo CHtml::activeLabel($modPenerimaanlinen,'nopenerimaanlinen',array('class'=>'control-label')); ?>
			<div class="controls">
			   <?php echo $form->textField($modPenerimaanlinen,'nopenerimaanlinen',array('placeholder'=>'Ketik No. Penerimaan', 'class'=>'span3', 'maxlength'=>20,'onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
			</div>
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
