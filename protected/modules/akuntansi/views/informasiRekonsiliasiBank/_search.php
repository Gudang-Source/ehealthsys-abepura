<legend class="rim"><i class="icon-white icon-search"></i> Pencarian</legend>
<?php
$form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'id'=>'rekonsiliasibank-info-search',
	'type'=>'horizontal',
	'focus'=>'#'.CHtml::activeId($model,'rekonsiliasibank_no'),

)); ?>
<div class="row-fluid">
	<div class="span4">
		<div class="control-group ">
			<?php echo CHtml::label('Tanggal Rekonsiliasi Bank','rekonsiliasibank_tgl', array('class'=>'control-label')) ?>
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
			<?php echo CHtml::label('Sampai Dengan','',array('class'=>'control-label')); ?>
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
	</div>
	<div class="span4">
		<div class="control-group ">
			<?php echo CHtml::activeLabel($model,'rekonsiliasibank_no',array('class'=>'control-label')); ?>
			<div class="controls">
			   <?php echo $form->textField($model,'rekonsiliasibank_no',array('placeholder'=>'Ketik No. Rekonsiliasi Bank', 'class'=>'span3 angkahuruf-only', 'maxlength'=>20,'onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
			</div>
		</div>
	</div>
	<div class="span4">
		<div class="control-group">
			<?php echo CHtml::label('Jenis Rekonsiliasi Bank', 'jenisrekonsiliasibank_id', array('class'=>'control-label')) ?>
			<div class="controls">
				<?php echo $form->dropDownList($model,'jenisrekonsiliasibank_id',CHtml::listData(AKJenisrekonsiliasibankM::model()->findAll("jenisrekonsiliasibank_aktif = TRUE ORDER BY jenisrekonsiliasibank_nama ASC"),'jenisrekonsiliasibank_id','jenisrekonsiliasibank_nama'),array('class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);",'empty'=>'--Pilih--')); ?>           
			</div>
		</div>	
            
                <div class="control-group">
			<?php echo CHtml::label('Bank', 'bank_id', array('class'=>'control-label')) ?>
			<div class="controls">
				<?php echo $form->dropDownList($model,'bank_id',CHtml::listData(AKBankM::model()->findAll("bank_aktif = TRUE ORDER BY namabank ASC"),'bank_id','namabank'),array('class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);",'empty'=>'--Pilih--')); ?>           
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
