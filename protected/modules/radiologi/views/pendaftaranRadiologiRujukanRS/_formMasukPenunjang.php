<?php echo $form->hiddenField($modPasienMasukPenunjang, 'pasienmasukpenunjang_id', array('readonly'=>true,'class'=>'span3')); ?>
<?php echo $form->hiddenField($modPasienMasukPenunjang, 'pasienkirimkeunitlain_id', array('readonly'=>true,'class'=>'span3')); ?>
<?php echo $form->hiddenField($modPasienMasukPenunjang, 'ruangan_id', array('readonly'=>true,'class'=>'span3')); ?>

<?php echo $form->dropDownListRow($modPasienMasukPenunjang,'jeniskasuspenyakit_id', CHtml::listData(ROPendaftaranT::model()->getJenisKasusPenyakitItems($modPasienMasukPenunjang->ruangan_id), 'jeniskasuspenyakit_id', 'jeniskasuspenyakit_nama') ,array('empty'=>'-- Pilih --','onkeyup'=>"return $(this).focusNextInputField(event)",'class'=>'span4')); ?>
<?php // echo $form->dropDownListRow($modPasienMasukPenunjang,'kelaspelayanan_id', CHtml::listData(ROPendaftaranT::model()->getKelasPelayananItems($modPasienMasukPenunjang->ruangan_id), 'kelaspelayanan_id', 'kelaspelayanan_nama') ,array('onchange'=>'setChecklistPemeriksaanRad();setTindakanPemeriksaanReset();','empty'=>'-- Pilih --','onkeyup'=>"return $(this).focusNextInputField(event)",'class'=>'span3')); ?>
<?php echo $form->hiddenField($modPasienMasukPenunjang,'kelaspelayanan_id'); ?>
<div class="control-group">
    <?php echo $form->labelEx($modPasienMasukPenunjang,'pegawai_id',array('class'=>'control-label')); ?>
    <div class="controls">
        <?php echo $form->dropDownList($modPasienMasukPenunjang,'pegawai_id', CHtml::listData(ROPendaftaranT::model()->getDokterItems($modPasienMasukPenunjang->ruangan_id), 'pegawai_id', 'namaLengkap') ,array('empty'=>'-- Pilih --','onkeyup'=>"return $(this).focusNextInputField(event)", 'class'=>'span4')); ?>
    </div>
</div>
<div class="control-group">
	<?php echo CHtml::label('Radiografer','perawat_id',array('class'=>'control-label')); ?>
	<div class="controls">
		<?php echo $form->dropDownList($modPasienMasukPenunjang,'perawat_id', CHtml::listData(ROPegawaiM::model()->getTenagaRads($modPasienMasukPenunjang->ruangan_id), 'pegawai_id', 'nama_pegawai') ,array('empty'=>'-- Pilih --','onkeyup'=>"return $(this).focusNextInputField(event)", 'class'=>'span4')); ?>
	</div>
</div>
<div class="control-group">
	<?php echo CHtml::label('Tanggal Pemeriksaan','tgl_tindakan', array('class'=>'control-label')) ?>
	<div class="controls">
		<?php 
		$modTindakan->tgl_tindakan = MyFormatter::formatDateTimeForUser($modTindakan->tgl_tindakan);
		$this->widget('MyDateTimePicker',array(
							'name'=>'tgl_tindakan_semua',
						   'mode'=>'datetime',
						   'options'=> array(
						   'dateFormat'=>Params::DATE_FORMAT,
						),
						   'htmlOptions'=>array('readonly'=>true,'class'=>'span3 realtime',
						   'onkeypress'=>"return $(this).focusNextInputField(event)"),
		)); 
		?>
	</div> 
</div> 


