<legend class="rim"><i class="icon-white icon-search"></i> Pencarian</legend>
<?php
$form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'id'=>'pengirimanlinen-info-search',
	'type'=>'horizontal',
	'focus'=>'#'.CHtml::activeId($model,'nopengirimanlinen'),

)); ?>
<div class="row-fluid">
	<div class="span4">
		<div class="control-group ">
			<?php echo CHtml::label('Tanggal Perawatan','tglpengirimanlinen', array('class'=>'control-label')) ?>
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
                <div class="control-group ">
			<?php echo CHtml::activeLabel($model,'nopengirimanlinen',array('class'=>'control-label')); ?>
			<div class="controls">
			   <?php echo $form->textField($model,'nopengirimanlinen',array('placeholder'=>'Ketik No. Perawatan', 'class'=>'span3 angkahuruf-only', 'maxlength'=>20,'onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
			</div>
		</div>
	</div>
	<div class="span4">
		
		<div class="control-group">
			<?php echo CHtml::label('Instalasi', 'instalasi_id', array('class'=>'control-label')) ?>
			<div class="controls">
				<?php echo $form->dropDownList($model,'instalasi_id', CHtml::listData(LAInstalasiM::getInstalasiItems(),'instalasi_id','instalasi_nama'), 
						array('class'=>'span3','empty'=>'-- Pilih --', 'onkeyup'=>"return $(this).focusNextInputField(event)", 
								'ajax'=>array('type'=>'POST',
											'url'=>$this->createUrl('SetDropdownRuangan',array('encode'=>false,'model_nama'=>get_class($model))),
											'update'=>"#".CHtml::activeId($model, 'ruangantujuan_id'),
								)));?>
			</div>
		</div>
                <div class="control-group">
			<?php echo CHtml::label('Ruangan', 'ruangantujuan_id', array('class'=>'control-label')) ?>
			<div class="controls">
				<?php echo $form->dropDownList($model,'ruangantujuan_id',CHtml::listData(LARuanganM::getRuanganByInstalasi($model->instalasi_id),'ruangan_id','ruangan_nama'),array('class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);",'empty'=>'--Pilih--')); ?>           
			</div>
		</div>	
                <div class="control-group">
			<?php echo CHtml::label('Pegawai Pengirim', 'pegpengirim', array('class'=>'control-label')) ?>
			<div class="controls">
				<?php echo $form->dropDownList($model,'pegpengirim_id',CHtml::listData(PegawairuanganV::model()->findAll("pegawai_aktif = TRUE AND ruangan_id = '".Yii::app()->user->getState('ruangan_id')."' ORDER BY nama_pegawai ASC "),'pegawai_id','namaLengkap'),array('class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);",'empty'=>'-- Pilih --')); ?>           
			</div>
		</div>	
	</div>
	<div class="span4">
		
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
