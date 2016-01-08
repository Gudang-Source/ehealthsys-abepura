<legend class="rim"><i class="icon-white icon-search"></i> Pencarian</legend>
<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'id'=>'penerimaanlinen-info-search',
	'type'=>'horizontal',
	'focus'=>'#'.CHtml::activeId($modPengirimanlinen,'nopengirimanlinen'),
)); ?>
<div class="row-fluid">
	<div class="span4">
		<div class="control-group ">
			<?php echo CHtml::label('Tanggal Pengiriman','tglpengirimanlinen', array('class'=>'control-label')) ?>
			<div class="controls">
				<?php   
				$modPengirimanlinen->tgl_awal = $format->formatDateTimeForUser($modPengirimanlinen->tgl_awal);
						$this->widget('MyDateTimePicker',array(
										'model'=>$modPengirimanlinen,
										'attribute'=>'tgl_awal',
										'mode'=>'date',
										'options'=> array(
											'dateFormat'=>Params::DATE_FORMAT,
											'maxDate' => 'd',
										),
										'htmlOptions'=>array('readonly'=>true,'class'=>'dtPicker3','onclick'=>"return $(this).focusNextInputField(event)"),
				)); 
						$modPengirimanlinen->tgl_awal = $format->formatDateTimeForDb($modPengirimanlinen->tgl_awal);
					?> 
			</div>
		</div>
	</div>
	<div class="span4">
		<div class="control-group ">
		<label class="control-label">
		   Sampai dengan
		</label>
			<div class="controls">
				<?php    
					$modPengirimanlinen->tgl_akhir = $format->formatDateTimeForUser($modPengirimanlinen->tgl_akhir);
					$this->widget('MyDateTimePicker',array(
										'model'=>$modPengirimanlinen,
										'attribute'=>'tgl_akhir',
										'mode'=>'date',
										'options'=> array(
											'dateFormat'=>Params::DATE_FORMAT,
											'maxDate' => 'd',
										),
										'htmlOptions'=>array('readonly'=>true,'class'=>'dtPicker3','onclick'=>"return $(this).focusNextInputField(event)"),
					)); 
					$modPengirimanlinen->tgl_akhir = $format->formatDateTimeForDb($modPengirimanlinen->tgl_akhir);
					?>
			</div>
		</div>
	</div>
	<div class="span4">
		<div class="control-group ">
			<?php echo CHtml::activeLabel($modPengirimanlinen,'nopengirimanlinen',array('class'=>'control-label')); ?>
			<div class="controls">
			   <?php echo $form->textField($modPengirimanlinen,'nopengirimanlinen',array('placeholder'=>'Ketik No. Pengiriman', 'class'=>'span3', 'maxlength'=>20,'onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
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
