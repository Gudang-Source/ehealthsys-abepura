<div class="view">

		<b><?php echo CHtml::encode($data->getAttributeLabel('pegawai_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->pegawai_id),array('view','id'=>$data->pegawai_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('golonganpegawai_id')); ?>:</b>
	<?php echo CHtml::encode($data->golonganpegawai_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('pangkat_id')); ?>:</b>
	<?php echo CHtml::encode($data->pangkat_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('jabatan_id')); ?>:</b>
	<?php echo CHtml::encode($data->jabatan_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('kelurahan_id')); ?>:</b>
	<?php echo CHtml::encode($data->kelurahan_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('nomorindukpegawai')); ?>:</b>
	<?php echo CHtml::encode($data->nomorindukpegawai); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('no_kartupegawainegerisipil')); ?>:</b>
	<?php echo CHtml::encode($data->no_kartupegawainegerisipil); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('jenisidentitas')); ?>:</b>
	<?php echo CHtml::encode($data->jenisidentitas); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('noidentitas')); ?>:</b>
	<?php echo CHtml::encode($data->noidentitas); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('gelardepan')); ?>:</b>
	<?php echo CHtml::encode($data->gelardepan); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('nama_pegawai')); ?>:</b>
	<?php echo CHtml::encode($data->nama_pegawai); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('nama_keluarga')); ?>:</b>
	<?php echo CHtml::encode($data->nama_keluarga); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('gelarbelakang')); ?>:</b>
	<?php echo CHtml::encode($data->gelarbelakang); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('tempatlahir_pegawai')); ?>:</b>
	<?php echo CHtml::encode($data->tempatlahir_pegawai); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('tgl_lahirpegawai')); ?>:</b>
	<?php echo CHtml::encode($data->tgl_lahirpegawai); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('jeniskelamin')); ?>:</b>
	<?php echo CHtml::encode($data->jeniskelamin); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('statusperkawinan')); ?>:</b>
	<?php echo CHtml::encode($data->statusperkawinan); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('alamat_pegawai')); ?>:</b>
	<?php echo CHtml::encode($data->alamat_pegawai); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('agama')); ?>:</b>
	<?php echo CHtml::encode($data->agama); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('golongandarah')); ?>:</b>
	<?php echo CHtml::encode($data->golongandarah); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('rhesus')); ?>:</b>
	<?php echo CHtml::encode($data->rhesus); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('alamatemail')); ?>:</b>
	<?php echo CHtml::encode($data->alamatemail); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('notelp_pegawai')); ?>:</b>
	<?php echo CHtml::encode($data->notelp_pegawai); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('nomobile_pegawai')); ?>:</b>
	<?php echo CHtml::encode($data->nomobile_pegawai); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('warganegara_pegawai')); ?>:</b>
	<?php echo CHtml::encode($data->warganegara_pegawai); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('jeniswaktukerja')); ?>:</b>
	<?php echo CHtml::encode($data->jeniswaktukerja); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('kategoripegawai')); ?>:</b>
	<?php echo CHtml::encode($data->kategoripegawai); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('photopegawai')); ?>:</b>
	<?php echo CHtml::encode($data->photopegawai); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('norekening')); ?>:</b>
	<?php echo CHtml::encode($data->norekening); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('banknorekening')); ?>:</b>
	<?php echo CHtml::encode($data->banknorekening); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('npwp')); ?>:</b>
	<?php echo CHtml::encode($data->npwp); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('tglmulaibekerja')); ?>:</b>
	<?php echo CHtml::encode($data->tglmulaibekerja); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('tglberhenti')); ?>:</b>
	<?php echo CHtml::encode($data->tglberhenti); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('gajipokok')); ?>:</b>
	<?php echo CHtml::encode($data->gajipokok); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('insentifpegawai')); ?>:</b>
	<?php echo CHtml::encode($data->insentifpegawai); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('peg_create_time')); ?>:</b>
	<?php echo CHtml::encode($data->peg_create_time); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('peg_update_time')); ?>:</b>
	<?php echo CHtml::encode($data->peg_update_time); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('peg_create_login')); ?>:</b>
	<?php echo CHtml::encode($data->peg_create_login); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('peg_update_login')); ?>:</b>
	<?php echo CHtml::encode($data->peg_update_login); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('pegawai_aktif')); ?>:</b>
	<?php echo CHtml::encode($data->pegawai_aktif); ?>
	<br />

	*/ ?>

</div>