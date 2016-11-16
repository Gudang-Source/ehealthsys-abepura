<legend class="rim"><i class="icon-white icon-search"></i> Pencarian</legend>
<?php
$form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'id'=>'pengkajiankeperawatan-info-search',
	'type'=>'horizontal',
	'focus'=>'#'.CHtml::activeId($model,'no_pendaftaran'),

)); ?>
<div class="row-fluid">
	<div class="span4">
		<div class="control-group ">
			<?php echo CHtml::label('Tanggal Rencana','pengkajianaskep_tgl', array('class'=>'control-label')) ?>
			<div class="controls">
				<?php   
				$model->tgl_awal = $format->formatDateTimeForUser(date('Y-m-d',strtotime($model->tgl_awal)));
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
					$model->tgl_akhir = $format->formatDateTimeForUser(date('Y-m-d',strtotime($model->tgl_akhir)));
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
			<?php echo CHtml::activeLabel($model,'no_rencana',array('class'=>'control-label')); ?>
			<div class="controls">
			   <?php echo $form->textField($model,'no_rencana',array('placeholder'=>'Ketik No. Rencana', 'class'=>'span3 angkahuruf-only', 'maxlength'=>20,'onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
			</div>
		</div>
            		
	</div>
	<div class="span4">
		<div class="control-group ">
			<?php echo CHtml::activeLabel($model,'no_pendaftaran',array('class'=>'control-label')); ?>
			<div class="controls">
			   <?php echo $form->textField($model,'no_pendaftaran',array('placeholder'=>'Ketik No. Pendaftaran', 'class'=>'span3 angkahuruf-only', 'maxlength'=>20,'onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
			</div>
		</div>
            
                <div class="control-group ">
			<?php echo CHtml::activeLabel($model,'nama_pasien',array('class'=>'control-label')); ?>
			<div class="controls">
			   <?php echo $form->textField($model,'nama_pasien',array('placeholder'=>'Ketik No. Rencana', 'class'=>'span3 hurufs-only', 'maxlength'=>20,'onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
			</div>
		</div>
                <?php /*
		<div class="control-group">
			<?php echo CHtml::label('Ruangan', 'ruangan_id', array('class'=>'control-label')) ?>
			<div class="controls">
				<?php echo $form->dropDownList($model,'ruangan_id',CHtml::listData(ASRuanganM::getRuanganByInstalasi($model->instalasi_id),'ruangan_id','ruangan_nama'),array('class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);",'empty'=>'--Pilih--')); ?>           
			</div>
		</div>	
                 * *
                 */ ?>	
	</div>
	<div class="span4">
		<div class="control-group ">
			<?php echo CHtml::activeLabel($model,'nama_pegawai',array('class'=>'control-label')); ?>
			<div class="controls">
			   <?php echo $form->textField($model,'nama_pegawai',array('placeholder'=>'Ketik Nama Pegawai', 'class'=>'span3 hurufs-only', 'maxlength'=>20,'onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
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
                $tips = array(
                    '0' => 'tanggal',
                    '1' => 'detail',
                    '2' => 'cari',
                    '3' => 'ulang2',                    
                    '4' => 'print',
                );
		$content = $this->renderPartial('sistemAdministrator.views.tips.detailTips',array('tips'=>$tips),true);		
		$this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); 
	?>  
</div>

<?php $this->endWidget(); ?>
