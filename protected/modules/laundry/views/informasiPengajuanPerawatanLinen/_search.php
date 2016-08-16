<legend class="rim"><i class="icon-white icon-search"></i> Pencarian</legend>
<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'id'=>'pengajuanlinen-info-search',
	'type'=>'horizontal',
	'focus'=>'#'.CHtml::activeId($model,'pengperawatanlinen_no'),
)); ?>
<div class="row-fluid">
	<div class="span4">
		<div class="control-group ">
			<?php echo CHtml::label('Tanggal Pengajuan','tglpengperawatanlinen', array('class'=>'control-label')) ?>
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
		<label class="control-label">
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
			<?php echo CHtml::activeLabel($model,'pengperawatanlinen_no',array('class'=>'control-label')); ?>
			<div class="controls">
			   <?php echo $form->textField($model,'pengperawatanlinen_no',array('placeholder'=>'Ketik No. Pengajuan', 'class'=>'span3 angkahuruf-only', 'maxlength'=>20,'onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
			</div>
		</div>
	</div>
	<div class="span4">
		<div class="control-group ">
			<?php echo CHtml::label('Instalasi','Instalasi', array('class'=>'control-label')) ?>
			<div class="controls">
			<?php echo $form->dropDownList($model,'instalasi_id', CHtml::listData(InstalasiM::model()->findAll("instalasi_aktif = TRUE ORDER BY instalasi_nama ASC"),'instalasi_id','instalasi_nama'),
					array('class'=>'span3','empty'=>'-- Pilih --', 'onkeyup'=>"return $(this).focusNextInputField(event)", 
							'onchange'=>'setPegawai();'
                                                        ,'ajax'=>array('type'=>'POST',
										'url'=>$this->createUrl('SetDropdownRuangan',array('encode'=>false,'model_nama'=>get_class($model))),
										'update'=>"#".CHtml::activeId($model, 'ruanganpengirim_id'),
							)));?>
			</div>
		</div>
		<div class="control-group ">
			<?php echo CHtml::label('Ruangan','Ruangan', array('class'=>'control-label inline')) ?>
			<div class="controls">
				<?php echo $form->dropDownList($model,'ruanganpengirim_id',CHtml::listData(RuanganM::model()->findAll("ruangan_aktif = TRUE ORDER BY ruangan_nama ASC"),'ruangan_id','ruangan_nama'),array('class'=>'span3','empty'=>'-- Pilih --','onkeyup'=>"return $(this).focusNextInputField(event);",
                                     'ajax'=>array('type'=>'POST',
                                                                'url'=>$this->createUrl('/ActionDynamic/GetPegawaiRuangan/',array('encode'=>false,'namaModel'=>get_class($model))),
                                                                'update'=>"#".CHtml::activeId($model, 'mengajukan_id'),
							)));?>
			</div>
		</div>
                 <div class="control-group ">
			<?php echo CHtml::Label('Pegawai Mengajukan','pegawaimengetahui',array('class'=>'control-label')); ?>
			<div class="controls">
			   <?php echo $form->dropDownList($model,'mengajukan_id', Chtml::ListData(PegawairuanganV::model()->findAll("pegawai_aktif = TRUE  ORDER BY nama_pegawai ASC"),'pegawai_id','namaLengkap'),array('empty'=>'-- Pilih --','onkeypress'=>"return $(this).focusNextInputField(event)",'class'=>'span3')); ?>
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
<script>
function setPegawai()
{
    $("#<?php echo CHtml::activeId($model,"mengajukan_id");?>").find('option').remove().end().append('<option value="">-- Pilih --</option>').val('');
}
</script>