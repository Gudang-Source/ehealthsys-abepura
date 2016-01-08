<div class="row-fluid">
	<div class="span4">
		<div class="control-group">
			<?php echo $form->label($modPendaftaran,'no_pendaftaran',array('class'=>'control-label')); ?>
			<div class="controls">
				<?php echo CHtml::activeHiddenField($modPendaftaran, 'pendaftaran_id',array('class'=>'span3')); ?>
				<?php echo CHtml::activeHiddenField($modPasienAdmisi, 'pasienadmisi_id',array('class'=>'span3')); ?>
				<?php echo CHtml::activeHiddenField($modPasienPulang, 'pasienpulang_id',array('class'=>'span3')); ?>
				<?php echo CHtml::activeHiddenField($modPasien, 'pasien_id',array('class'=>'span3')); ?>
				<?php echo CHtml::activeTextField($modPendaftaran, 'no_pendaftaran',array('class'=>'span3')); ?>
			</div>
		</div>
		<div class="control-group">
			<?php echo $form->label($modPendaftaran,'tgl_pendaftaran',array('class'=>'control-label')); ?>
			<div class="controls">
				<?php echo CHtml::activeTextField($modPendaftaran, 'tgl_pendaftaran',array('class'=>'span3')); ?>
			</div>
		</div>
		<div class="control-group">
			<?php echo $form->label($modPasien,'no_rekam_medik',array('class'=>'control-label')); ?>
			<div class="controls">
				<?php echo CHtml::activeTextField($modPasien, 'no_rekam_medik',array('class'=>'span3')); ?>
			</div>
		</div>
		<div class="control-group">
			<?php echo $form->label($modPasien,'nama_pasien',array('class'=>'control-label')); ?>
			<div class="controls">
				<?php echo CHtml::activeTextField($modPasien, 'nama_pasien',array('class'=>'span3')); ?>
			</div>
		</div>
		<div class="control-group">
			<?php echo $form->label($modPasienAdmisi,'jeniskelamin',array('class'=>'control-label')); ?>
			<div class="controls">
				<?php echo CHtml::activeTextField($modPasien, 'jeniskelamin',array('class'=>'span3')); ?>
			</div>
		</div>
		<div class="control-group">
			<?php echo $form->label($modPasien,'tanggal_lahir',array('class'=>'control-label')); ?>
			<div class="controls">
				<?php echo CHtml::activeTextField($modPasien, 'tanggal_lahir',array('class'=>'span3')); ?>
			</div>
		</div>
	</div>
	<div class="span4">		
		<div class="control-group">
			<?php echo $form->label($modPendaftaran,'Instalasi',array('class'=>'control-label')); ?>
			<div class="controls">
				<?php echo CHtml::activeTextField($modPendaftaran, 'instalasi_nama',array('class'=>'span3')); ?>
			</div>
		</div>
		<div class="control-group">
			<?php echo $form->label($modPendaftaran,'Klinik / Ruangan',array('class'=>'control-label')); ?>
			<div class="controls">
				<?php echo CHtml::activeTextField($modPendaftaran, 'ruangan_nama',array('class'=>'span3')); ?>
			</div>
		</div>
		<div class="control-group">
			<?php echo $form->label($modPasienAdmisi,'Tanggal Rawat Inap',array('class'=>'control-label')); ?>
			<div class="controls">
				<?php echo CHtml::activeTextField($modPasienAdmisi, 'tgladmisi',array('class'=>'span3')); ?>
			</div>
		</div>
		<div class="control-group">
			<?php echo $form->label($modPasienAdmisi,'Ruangan',array('class'=>'control-label')); ?>
			<div class="controls">
				<?php echo CHtml::activeTextField($modPasienAdmisi, 'ruangan_nama',array('class'=>'span3')); ?>
			</div>
		</div>
		<div class="control-group">
			<?php echo $form->label($modPendaftaran,'Kelas Pelayanan',array('class'=>'control-label')); ?>
			<div class="controls">
				<?php echo CHtml::activeTextField($modPendaftaran, 'kelaspelayanan_nama',array('class'=>'span3')); ?>
			</div>
		</div>
		<div class="control-group">
			<?php echo CHtml::label('Kamar / No. Bed','',array('class'=>'control-label')); ?>
			<div class="controls">
				<?php echo CHtml::activeTextField($modPasienAdmisi, 'kamarruangan_nama',array('class'=>'span3')); ?>
			</div>
		</div>
	</div>
	<div class="span4">		
		<div class="control-group">
			<?php echo $form->label($modPasienAdmisi,'Tanggal Pulang',array('class'=>'control-label')); ?>
			<div class="controls">
				<?php echo CHtml::activeTextField($modPasienAdmisi, 'tglpulang',array('class'=>'span3')); ?>
			</div>
		</div>
		<div class="control-group">
			<?php echo $form->label($modPasienPulang,'Cara Keluar',array('class'=>'control-label')); ?>
			<div class="controls">
				<?php echo CHtml::activeTextField($modPasienPulang, 'carakeluar_nama',array('class'=>'span3')); ?>
			</div>
		</div>
		<div class="control-group">
			<?php echo $form->label($modPasienPulang,'Kondisi Keluar',array('class'=>'control-label')); ?>
			<div class="controls">
				<?php echo CHtml::activeTextField($modPasienPulang, 'kondisikeluar_nama',array('class'=>'span3')); ?>
			</div>
		</div>
		<div class="control-group">
			<?php echo $form->label($modPendaftaran,'keterangan',array('class'=>'control-label')); ?>
			<div class="controls">
				<?php echo CHtml::activeTextArea($modPendaftaran, 'keterangan',array('class'=>'span3')); ?>
			</div>
		</div>
	</div>
	<div class="span12">
		<?php $this->renderPartial($this->path_view_inacbg.'_tabelDiagnosa',array('modPasienMorbiditas'=>$modPasienMorbiditas)); ?>
	</div>
	<div class="span12">
		<div class="control-group">
			<?php echo CHtml::label("Total Biaya Pelayanan RS",'Total Biaya Pelayanan RS',array('class'=>'control-label')); ?>
			<div class="controls">
				<?php echo CHtml::activeTextField($model, 'totaltarif',array('class'=>'span3 integer')); ?>
				<?php 
				echo CHtml::htmlButton('<i class="icon-list icon-white"></i>',
						array('onclick'=>'lihatRincianPasien();return false;',
							  'class'=>'btn btn-mini btn-primary btn-katakunci',
							  'onkeypress'=>"lihatRincianPasien();return false;",
							  'rel'=>"tooltip",
							  'title'=>"Klik untuk melihat rincian tagihan",)); 
				?>
			</div>
		</div>
	</div>
</div>