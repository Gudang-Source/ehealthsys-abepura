<legend class="rim"><i class="icon-white icon-search"></i> Pencarian</legend>
<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'id'=>'mapenyusutanaset-info-search',
	'type'=>'horizontal',
	'focus'=>'#'.CHtml::activeId($model,'no_penyusutan'),
)); ?>
<div class="row-fluid">
	<div class="span6">
		<div class="control-group ">
			<?php echo CHtml::label('Tanggal Re-evaluasi','reevaluasiaset_tgl', array('class'=>'control-label')) ?>
			<div class="controls">
				<?php   
				$model->reevaluasiaset_tgl = $format->formatDateTimeForUser($model->reevaluasiaset_tgl);
						$this->widget('MyDateTimePicker',array(
										'model'=>$model,
										'attribute'=>'reevaluasiaset_tgl',
										'mode'=>'date',
										'options'=> array(
											'dateFormat'=>Params::DATE_FORMAT,
											'maxDate' => 'd',
										),
										'htmlOptions'=>array('readonly'=>true,'class'=>'dtPicker3','onclick'=>"return $(this).focusNextInputField(event)"),
				)); 
						$model->reevaluasiaset_tgl = $format->formatDateTimeForDb($model->reevaluasiaset_tgl);
					?> 
			</div>
		</div>
	</div>
	<div class="span6">	
		<div class="control-group ">
			<?php echo CHtml::activeLabel($model,'reevaluasiaset_no',array('class'=>'control-label')); ?>
			<div class="controls">
			   <?php echo $form->textField($model,'reevaluasiaset_no',array('placeholder'=>'Ketik No. Re-evaluasi Aset', 'class'=>'span3', 'maxlength'=>20,'onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
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
		$content = $this->renderPartial('/tips/informasi',array(),true);
		$this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); 
	?>  
</div>

<?php $this->endWidget(); ?>
