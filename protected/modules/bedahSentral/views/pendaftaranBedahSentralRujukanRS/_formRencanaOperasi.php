<div class="control-group ">
	<?php echo CHtml::label('Tanggal <span class="required">*</span>','Tanggal',array('class'=>'control-label required')); ?>
	<div class="controls">
			<?php   
                                        $format = new MyFormatter;
                                        $modRencanaOperasi->tglrencanaoperasi = $format->formatDateTimeForUser($modRencanaOperasi->tglrencanaoperasi);
                                        
					$this->widget('MyDateTimePicker',array(
									'model'=>$modRencanaOperasi,
									'attribute'=>'tglrencanaoperasi',
									'mode'=>'datetime',
									'options'=> array(
										'dateFormat'=>Params::DATE_FORMAT,
                                                                            
									),
									'htmlOptions'=>array('readonly'=>true,'class'=>'dtPicker3', 'onkeypress'=>"return $(this).focusNextInputField(event)"),
			)); ?>
			<?php echo $form->error($modRencanaOperasi, 'tglrencanaoperasi'); ?>
	</div>
</div>
<?php // echo $form->textFieldRow($modRencanaOperasi,'norencanaoperasi',array('readonly'=>true)) ?>
<?php echo $form->dropDownListRow($modRencanaOperasi,'kamarruangan_id', CHtml::listData($modRencanaOperasi->getKamarKosongItems(), 'kamarruangan_id', 'KamarDanTempatTidur') , 
							   array('empty'=>'-- Pilih --',
											'onkeypress'=>"return $(this).focusNextInputField(event)",
											'class'=>'span3'
								   )); ?>
<div class="control-group">
	<?php echo CHtml::label('Operator <span class="required">*</span>','dokter',array('class'=>'control-label required')) ?>
	<div class="controls">
		<?php echo $form->dropDownList($modRencanaOperasi,'dokterpelaksana1_id', CHtml::listData($modRencanaOperasi->getDokterItems(Params::RUANGAN_ID_BEDAH), 'pegawai_id', 'namaLengkap') ,array('empty'=>'-- Pilih --','onkeypress'=>"return $(this).focusNextInputField(event)",'class'=>'span3')); ?>
		<?php echo $form->error($modRencanaOperasi, 'dokterpelaksana1_id'); ?>
	</div>
</div>
<div class="control-group">
	<?php echo CHtml::label('Asisten Operator','dokter',array('class'=>'control-label')) ?>
	<div class="controls">
		<?php echo $form->dropDownList($modRencanaOperasi,'dokterpelaksana2_id', CHtml::listData($modRencanaOperasi->getDokterParamedisItems(Params::RUANGAN_ID_BEDAH), 'pegawai_id', 'namaLengkap') ,array('empty'=>'-- Pilih --','onkeypress'=>"return $(this).focusNextInputField(event)",'class'=>'span3')); ?>
		<?php echo $form->error($modRencanaOperasi, 'dokterpelaksana2_id'); ?>
	</div>
</div>
<div class="control-group">
    <?php echo CHtml::label('Anastesi','dokteranastesi_id',array('class'=>'control-label')) ?>
    <div class="controls">
        <?php echo $form->dropDownList($modRencanaOperasi,'dokteranastesi_id', CHtml::listData($modRencanaOperasi->getDokterItems(Params::RUANGAN_ID_BEDAH), 'pegawai_id', 'namaLengkap') ,array('empty'=>'-- Pilih --','onkeypress'=>"return $(this).focusNextInputField(event)",'class'=>'span3')); ?>
        </div>
</div>
<div class="control-group">
    <?php echo CHtml::label('Penata Anastesi','paramedis_id',array('class'=>'control-label')) ?>
    <div class="controls">
        <?php echo $form->dropDownList($modRencanaOperasi,'paramedis_id', CHtml::listData($modRencanaOperasi->getParamedisItems(Params::RUANGAN_ID_BEDAH), 'pegawai_id', 'nama_pegawai') ,array('empty'=>'-- Pilih --','onkeypress'=>"return $(this).focusNextInputField(event)",'class'=>'span3')); ?>
        </div>
</div>
<div class="control-group">
    <?php echo CHtml::label('Perawat Anastesi','suster_id',array('class'=>'control-label')) ?>
    <div class="controls">
        <?php echo $form->dropDownList($modRencanaOperasi,'suster_id', CHtml::listData($modRencanaOperasi->getParamedisItems(Params::RUANGAN_ID_BEDAH), 'pegawai_id', 'nama_pegawai') ,array('empty'=>'-- Pilih --','onkeypress'=>"return $(this).focusNextInputField(event)",'class'=>'span3')); ?>
        </div>
</div>
<div class="control-group">
    <?php echo CHtml::label('Perawat Instrument','bidan_id',array('class'=>'control-label')) ?>
    <div class="controls">
        <?php echo $form->dropDownList($modRencanaOperasi,'bidan_id', CHtml::listData($modRencanaOperasi->getParamedisItems(Params::RUANGAN_ID_BEDAH), 'pegawai_id', 'nama_pegawai') ,array('empty'=>'-- Pilih --','onkeypress'=>"return $(this).focusNextInputField(event)",'class'=>'span3')); ?>
        </div>
</div>
<div class="control-group">
    <?php echo CHtml::label('Perawat Sirkuler','bidan_id',array('class'=>'control-label')) ?>
    <div class="controls">
        <?php echo $form->dropDownList($modRencanaOperasi,'perawatsirkuler_id', CHtml::listData($modRencanaOperasi->getParamedisItems(Params::RUANGAN_ID_BEDAH), 'pegawai_id', 'nama_pegawai') ,array('empty'=>'-- Pilih --','onkeypress'=>"return $(this).focusNextInputField(event)",'class'=>'span3')); ?>
        </div>
</div>

<?php echo $form->dropDownListRow($modRencanaOperasi,'statusoperasi', LookupM::getItems('statusoperasi'),  
								  array('empty'=>'-- Pilih --', 'onkeypress'=>"return $(this).focusNextInputField(event)",'class'=>'span3','disabled'=>true
										)); ?>   
<?php echo $form->textAreaRow($modRencanaOperasi,'keterangan_rencana',array('class'=>'span3')) ?>