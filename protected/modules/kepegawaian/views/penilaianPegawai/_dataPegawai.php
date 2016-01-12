<div class="span4">
	<div class="control-group">
		<?php echo CHtml::label('NIP','nomorindukpegawai',array('class'=>'control-label')) ?>
		<div class="controls">
				<?php

					$modul = ModulK::model()->findByAttributes(
						array('modul_key'=>$this->module->id)
					);
					$modul_id = (isset($modul['modul_id']) ? $modul['modul_id'] : '' );
					$this->widget('MyJuiAutoComplete',array(
							'name'=>'nomorindukpegawai',
							'value'=>$modPegawai->nomorindukpegawai,
							'sourceUrl'=> $this->createUrl('PegawairiwayatNip'),
							'options'=>array(
							   'showAnim'=>'fold',
							   'minLength' => 2,
							   'focus'=> 'js:function( event, ui ) {
									$("#KPPenilaianpegawaiT_pegawai_id").val( ui.item.value );
									$("#namapegawai").val( ui.item.nama_pegawai );
									return false;
								}',
							   'select'=>'js:function( event, ui ) {
									$("#KPPenilaianpegawaiT_pegawai_id").val( ui.item.value );
									setDataPegawai(ui.item.value);
									return false;
								}',

							),
							'htmlOptions'=>array('onkeypress'=>"return $(this).focusNextInputField(event)",'class'=>'span3 '),
							'tombolDialog'=>array('idDialog'=>'dialogPegawai','idTombol'=>'tombolPasienDialog'),
				)); ?>
		</div>
	</div>
	<div class="control-group">
		<?php echo CHtml::label('Nama pegawai','namapegawai',array('class'=>'control-label')) ?>
		<div class="controls">
				<?php echo $form->hiddenField($model,'pegawai_id',array('readonly'=>true)) ?>
				<?php

					$modul = ModulK::model()->findByAttributes(
						array('modul_key'=>$this->module->id)
					);
					$modul_id = (isset($modul['modul_id']) ? $modul['modul_id'] : '' );
					$this->widget('MyJuiAutoComplete',array(
							'name'=>'namapegawai',
							'value'=>$modPegawai->nama_pegawai,
							'sourceUrl'=> $this->createUrl('Pegawairiwayat'),
							'options'=>array(
							   'showAnim'=>'fold',
							   'minLength' => 2,
							   'focus'=> 'js:function( event, ui ) {
									$("#KPPenilaianpegawaiT_pegawai_id").val( ui.item.value );
									$("#namapegawai").val( ui.item.nama_pegawai );
									return false;
								}',
							   'select'=>'js:function( event, ui ) {
									$("#KPPenilaianpegawaiT_pegawai_id").val( ui.item.value );
									setDataPegawai(ui.item.value);
									return false;
								}',

							),
							'htmlOptions'=>array('onkeypress'=>"return $(this).focusNextInputField(event)",'class'=>'span3 '),
							'tombolDialog'=>array('idDialog'=>'dialogPegawai','idTombol'=>'tombolPasienDialog'),
				)); ?>
		</div>
	</div>
	<?php echo $form->textFieldRow($modPegawai,'tempatlahir_pegawai',array('readonly'=>true,'id'=>'tempatlahir_pegawai')); ?>
	<?php echo $form->textFieldRow($modPegawai, 'tgl_lahirpegawai',array('readonly'=>true,'id'=>'tgl_lahirpegawai')); ?>
</div>
<div class="span4">
	<?php echo $form->textFieldRow($modPegawai, 'jeniskelamin',array('readonly'=>true,'id'=>'jeniskelamin')); ?>
	<?php echo $form->textFieldRow($modPegawai,'statusperkawinan',array('readonly'=>true,'id'=>'statusperkawinan')); ?>
	<?php echo $form->textFieldRow($modPegawai,'jabatan_id',array('readonly'=>true,'id'=>'jabatan')); ?>
	<?php echo $form->textAreaRow($modPegawai,'alamat_pegawai',array('readonly'=>true,'id'=>'alamat_pegawai')); ?>
</div>
<div class="span4">
	<?php 
		if(file_exists(Params::pathPegawaiTumbsDirectory().'kecil_'.$modPegawai->photopegawai)){
			echo CHtml::image(Params::pathPegawaiTumbsDirectory().'kecil_'.$modPegawai->photopegawai, 'photo pasien', array('id'=>'photo_pasien','width'=>150));
		} else {
			echo CHtml::image(Params::urlPhotoPasienDirectory().'no_photo.jpeg', 'Photo tidak tersedia', array('id'=>'photo_pasien','width'=>150));
		}
	?> 
</div>