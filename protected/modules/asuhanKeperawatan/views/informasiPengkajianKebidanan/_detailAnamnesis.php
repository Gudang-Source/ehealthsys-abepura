<?php
echo '<p style="text-align:center;"><strong>RIWAYAT ANAMNESIS</strong></p>';
?>
<br>
<table width="100%" class="table table-striped table-bordered table-condensed">
	<tr>
		<td width="20%">
			<strong>Keluhan Utama</strong>
		</td>
		<td width="30%">
			<?php echo $modAnamnesa->keluhanutama; ?>
		</td>
		<td width="20%">
			<strong>Dismenorche</strong>
		</td>
		<td width="30%">
			<?php echo ($modAnamnesa->dismenorche == 1) ? "Ya" : "Tidak"; ?>
		</td>
	</tr>
	<tr>
		<td width="20%">
			<strong>Keluhan Tambahan</strong>
		</td>
		<td width="30%">
			<?php echo $modAnamnesa->keluhantambahan; ?>
		</td>
		<td width="20%">
			<strong>HPHT</strong>
		</td>
		<td width="30%">
			<?php echo $modAnamnesa->hpht; ?>
		</td>
	</tr>
	<tr>
		<td width="20%">
			<strong>Riwayat Perjalanan Penyakit Pasien</strong>
		</td>
		<td width="30%">
			<?php echo $modAnamnesa->riwayatpenyakitterdahulu; ?>
		</td>
		<td width="20%">
			<strong>Taksiran Persalinan</strong>
		</td>
		<td width="30%">
			<?php echo $modAnamnesa->taksiranpersalinan; ?>
		</td>
	</tr>
	<tr>
		<td width="20%">
			<strong>Lama Sakit</strong>
		</td>
		<td width="30%">
			<?php echo $modAnamnesa->lamasakit; ?>
		</td>
		<td width="20%">
			<strong>Keluhan Saat Hamil</strong>
		</td>
		<td width="30%">
			<?php echo $modAnamnesa->keluhansaathamil; ?>
		</td>
	</tr>
	<tr>
		<td width="20%">
			<strong>Riwayat Penyakit Terdahulu</strong>
		</td>
		<td width="30%">
			<?php echo $modAnamnesa->riwayatpenyakitterdahulu; ?>
		</td>
		<td width="20%">
			<strong>ANC</strong>
		</td>
		<td width="30%">
			<?php echo $modAnamnesa->anc; ?>
		</td>
	</tr>
	<tr>
		<td width="20%">
			<strong>Riwayat Penyakit Keluarga</strong>
		</td>
		<td width="30%">
			<?php echo $modAnamnesa->riwayatpenyakitkeluarga; ?>
		</td>
		<td width="20%">
			<strong>Riwayat Keluarga Berencana</strong>
		</td>
		<td width="30%">
			<?php echo $modAnamnesa->riwayatkb; ?>
		</td>
	</tr>
	<tr>
		<td width="20%">
			<strong>Riwayat Alergi Obat</strong>
		</td>
		<td width="30%">
			<?php echo $modAnamnesa->riwayatalergiobat; ?>
		</td>
		<td width="20%">
			<strong>Frekuensi Makan</strong>
		</td>
		<td width="30%">
			<?php echo $modAnamnesa->frekmakan_hari; ?>
		</td>
	</tr>
	<tr>
		<td width="20%">
			<strong>Pengobatan Yang Sudah Dilakukan</strong>
		</td>
		<td width="30%">
			<?php echo $modAnamnesa->pengobatanygsudahdilakukan; ?>
		</td>
		<td width="20%">
			<strong>Makanan Yang Dipantang</strong>
		</td>
		<td width="30%">
			<?php echo $modAnamnesa->makananyangdipantang; ?>
		</td>
	</tr>
	<tr>
		<td width="20%">
			<strong>Riwayat Alergi Makanan</strong>
		</td>
		<td width="30%">
			<?php echo $modAnamnesa->riwayatmakanan; ?>
		</td>
		<td width="20%">
			<strong>Lama Tidur</strong>
		</td>
		<td width="30%">
			<?php echo $modAnamnesa->lamatidur_jam_hari; ?>
		</td>
	</tr>
	<tr>
		<td width="20%">
			<strong>Riwayat Kelahiran</strong>
		</td>
		<td width="30%">
			<?php echo $modAnamnesa->riwayatkelahiran; ?>
		</td>
		<td width="20%">
			<strong>Masalah Tidur</strong>
		</td>
		<td width="30%">
			<?php echo ($modAnamnesa->masalah == 1) ? "Ya" : "Tidak"; ?>
		</td>
	</tr>
	<tr>
		<td width="20%">
			<strong>Riwayat Imunisasi</strong>
		</td>
		<td width="30%">
			<?php echo $modAnamnesa->riwayatimunisasi; ?>
		</td>
		<td width="20%">
			<strong>Kegiatan / Aktifitas</strong>
		</td>
		<td width="30%">
			<?php echo ($modAnamnesa->kegiatan_aktivitas == 1) ? "Ya" : "Tidak"; ?>
		</td>
	</tr>
	<tr>
		<td width="20%">
			<strong>Status Merokok</strong>
		</td>
		<td width="30%">
			<?php echo ($modAnamnesa->statusmerokok == 1) ? "Ya" : "Tidak"; ?>
		</td>
		<td width="20%">
			<strong>Olahraga</strong>
		</td>
		<td width="30%">
			<?php echo ($modAnamnesa->olahraga == 1) ? "Ya" : "Tidak"; ?>
		</td>
	</tr>
	<tr>
		<td width="20%">
			<strong>Jml Rokok/Hari</strong>
		</td>
		<td width="30%">
			<?php echo $modAnamnesa->jmlrokok_btg_hr; ?>
		</td>
		<td width="20%">
			<strong>Ketergantungan Obat</strong>
		</td>
		<td width="30%">
			<?php echo ($modAnamnesa->ketergantunganobat == 1) ? "Ya" : "Tidak"; ?>
		</td>
	</tr>
	<tr>
		<td width="20%">
			<strong>Haid Pertama/Menarche Umur</strong>
		</td>
		<td width="30%">
			<?php echo $modAnamnesa->menarcheumur_thn; ?>
		</td>
		<td width="20%">
			<strong>Minuman Keras</strong>
		</td>
		<td width="30%">
			<?php echo ($modAnamnesa->minumankeras == 1) ? "Ya" : "Tidak"; ?>
		</td>
	</tr>
	<tr>
		<td width="20%">
			<strong>Siklus Menstruasi/Hari</strong>
		</td>
		<td width="30%">
			<?php echo $modAnamnesa->siklusmenstruasi_hari; ?>
		</td>
		<td width="20%">
			<strong>Keterangan Anamnesis</strong>
		</td>
		<td width="30%">
			<?php echo $modAnamnesa->keterangananamesa; ?>
		</td>
	</tr>
	<tr>
		<td width="20%">
			<strong>Siklus Menstruasi Teratur</strong>
		</td>
		<td width="30%">
			<?php echo ($modAnamnesa->siklusmenstruasiteratur == 1) ? "Ya" : "Tidak"; ?>
		</td>
		<td width="20%">
		</td>
		<td width="30%">
		</td>
	</tr>
</table>
<?php
echo '<p><strong>RIWAYAT PERKAWINAN</strong></p>';
?>
<table width="100%">
	<tr>
		<td width="20%">
			Status Perkawinan
		</td>
		<td width="40%">
			<?php echo $modAnamnesa->statusperkawinan; ?>
		</td>
		<td width="40%">
			<?php echo $modAnamnesa->jmlperkawinan_kali . ' Kali'; ?>
		</td>
	</tr>
</table>
<div class="block-tabel">
	<?php $this->widget('bootstrap.widgets.BootAlert'); ?>
	<?php
	$this->widget('ext.bootstrap.widgets.BootGridView', array(
		'id' => 'informasiasuhankeperawatan-grid',
		'dataProvider' => $modPerkawinan,
		'template' => "{summary}\n{items}\n{pager}",
		'itemsCssClass' => 'table table-striped table-bordered table-condensed',
		'columns' => array(
			array(
				'header' => 'Perkawinan Ke-',
				'type' => 'raw',
				'value' => '$data->perkawinan_ke',
			),
			array(
				'header' => 'Tanggal Perkawinan',
				'type' => 'raw',
				'value' => 'MyFormatter::formatDateTimeForUser($data->tglperkawanan)',
			),
			array(
				'header' => 'Lamanya (Tahun)',
				'name' => 'lamaperkawinan_thn',
				'type' => 'raw',
				'value' => '$data->lamaperkawinan_thn',
			),
			array(
				'header' => 'Tgl. Lahir Suami',
				'type' => 'raw',
				'value' => 'MyFormatter::formatDateTimeForUser($data->tgllahir_suami)',
			),
			array(
				'header' => 'Umur Suami (Tahun)',
				'type' => 'raw',
				'value' => '$data->umursuami_thn',
			),
			array(
				'header' => 'Anak (Orang)',
				'type' => 'raw',
				'value' => '$data->jmlanak_org',
			),
		),
		'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
	));
	?>
</div>
<?php
echo '<p><strong>RIWAYAT KEHAMILAN, PERSALINAN, NIFAS DAN LAKTASI YANG LALU</strong></p>';
?>
<div class="block-tabel">
	<?php $this->widget('bootstrap.widgets.BootAlert'); ?>
	<?php
	$this->widget('ext.bootstrap.widgets.HeaderGroupGridView', array(
		'id' => 'informasiasuhankeperawatan-grid',
		'dataProvider' => $modPersalinan,
		'mergeHeaders' => array(
			array(
				'name' => '<center>Anak</center>',
				'start' => 6,
				'end' => 7,
			),
		),
		'template' => "{summary}\n{items}\n{pager}",
		'itemsCssClass' => 'table table-striped table-bordered table-condensed',
		'columns' => array(
			array(
				'header' => 'Tgl/Bln/Th Partus',
				'type' => 'raw',
				'value' => 'MyFormatter::formatDateTimeForUser($data->tglpartus)',
			),
			array(
				'header' => 'Tempat Partus',
				'type' => 'raw',
				'value' => '$data->tempatpartus',
			),
			array(
				'header' => 'Umur Hamil',
				'name' => 'umurhamil_bln',
				'type' => 'raw',
				'value' => '$data->umurhamil_bln',
			),
			array(
				'header' => 'Jenis Persalinan',
				'type' => 'raw',
				'value' => '$data->jenispersalinan',
			),
			array(
				'header' => 'Penolong Persalinan',
				'type' => 'raw',
				'value' => '$data->penolongpersalinan',
			),
			array(
				'header' => 'Penyulit',
				'type' => 'raw',
				'value' => '$data->penyulit',
			),
			array(
				'header' => 'BB',
				'type' => 'raw',
				'value' => '$data->bbanak_gram',
			),
			array(
				'header' => 'PB',
				'type' => 'raw',
				'value' => '$data->pbanak_cm',
			),
			array(
				'header' => 'Pemberian Asi',
				'type' => 'raw',
				'value' => '$data->pemberianasi',
			),
			array(
				'header' => 'Keadaan Anak Sekarang',
				'type' => 'raw',
				'value' => '$data->keadaananakskrg',
			),
		),
		'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
	));
	?>
</div>