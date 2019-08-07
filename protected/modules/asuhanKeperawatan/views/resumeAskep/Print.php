<style>
	.spasi1 {
		margin: 0px 0px 0px 10px;
	}

	.spasi2 {
		padding: 0px 0px 0px 20px;
	}
</style>
<div class="white-container">
	<?php
	if ($caraPrint == 'EXCEL') {
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="' . $judulLaporan . '-' . date("Y/m/d") . '.xls"');
		header('Cache-Control: max-age=0');
	}
	echo $this->renderPartial('application.views.headerReport.headerDefault', array('judulLaporan' => $judulLaporan, 'colspan' => 7));
	$no_urut = 1;
	$class = '';
	if (isset($_GET['frame'])) {
		$class = "table table-striped";
	}
	?>
    <table width="100%" class="spasi1">
		<tr>
			<td width="20%">Nama</td>
			<td width="30%">: <?php echo (isset($modPasien->nama_pasien) ? $modPasien->nama_pasien : " - "); ?></td>
			<td width="20%">No. Rekam Medis</td>
			<td width="30%">: <?php echo isset($modPasien->no_rekam_medik) ? $modPasien->no_rekam_medik : " - "; ?></td>
		</tr>
		<tr>
			<td width="20%">Umur</td>
			<td width="30%">: <?php echo (isset($modPasien->umur) ? $modPasien->umur : " - ") . ' / ' . (isset($modPasien->jeniskelamin) ? $modPasien->jeniskelamin : " - "); ?></td>
			<td width="20%">Ruang / Kelas</td>
			<td width="30%">: <?php echo isset($modPasien->ruangan_nama) ? $modPasien->ruangan_nama : " - " . ' / ' . (isset($modPasien->kelaspelayanan_nama) ? $modPasien->kelaspelayanan_nama : " - " ); ?></td>
		</tr>
		<tr>
			<td width="20%">Diagnosa Medis</td>
			<td width="30%">: <?php echo isset($modDiagnosa->diagnosa_nama) ? $modDiagnosa->diagnosa_nama : " - "; ?></td>
			<td width="20%">Tgl Masuk RS</td>
			<td width="30%">: <?php echo (isset($modPasien->tgl_pendaftaran) ? MyFormatter::formatDateTimeForUser($modPasien->tgl_pendaftaran) : " - "); ?></td>

		</tr>
		<tr>
			<td width="20%">Dokter</td>
			<td width="30%">: <?php echo (isset($modPasien->nama_pegawai) ? $modPasien->nama_pegawai : " - "); ?></td>
			<td width="20%">Tgl. keluar RS</td>
			<td width="30%">: <?php echo isset($modPasien->tglpulang) ? MyFormatter::formatDateTimeForUser($modPasien->tglpulang) : " - "; ?></td>
		</tr>
	</table>
	<hr>
	<br>
	<br>
	<?php echo '<strong>1. Kondisi pasien saat masuk RS</strong>'; ?>
	<table width="100%" class="spasi1">
		<tr>
			<td width="5%">
				a. 
			</td>
			<td width="95%">
				Keluhan : <?php echo $model->keluhanutamamasuk; ?>
			</td>
		</tr>
		<tr>
			<td width="5%">
				b. 
			</td>
			<td width="95%">
				Keadaan Umum
			</td>
		</tr>
		<tr>
			<td width="5%">

			</td>
			<td width="95%">
				Kesadaran : <?php echo $model->keadaanumummasuk . ' GCS:E ' . $model->gcs_eye . ' M ' . $model->gcs_motorik . ' V ' . $model->gcs_verbal . ' = ' . $model->gcs_hasil; ?>
			</td>
		</tr>
		<tr>
			<td width="5%">

			</td>
			<td width="95%">
				Tanda Vital : TD <?php echo $model->tekanandarahmasuk . ' N ' . $model->detaknadimasuk . ' S ' . $model->suhutubuhmasuk . ' R ' . $model->pernapasanmasuk; ?>
			</td>
		</tr>
	</table>
	<br>
	<br>
	<?php echo '<strong>2. Kondisi pasien saat dirawat</strong>'; ?>
	<table width="100%" class="spasi1">
		<tr>
			<td width="5%">
				a. 
			</td>
			<td width="95%">
				Diagnosa Keperawatan
			</td>
		</tr>
		<tr>
			<td width="5%">

			</td>
			<td width="95%">
				<?php echo $model->diagnosakeperawatan; ?>
			</td>
		</tr>
		<tr>
			<td width="5%">
				b. 
			</td>
			<td width="95%">
				Tindakan Keperawatan
			</td>
		</tr>
		<tr>
			<td width="5%">

			</td>
			<td width="95%">
				<?php echo $model->tindakankeperawatan; ?>
			</td>
		</tr>
	</table>
	<br>
	<br>
	<?php echo '<strong>3. Kondisi pasien saat keluar RS</strong>'; ?>
	<table width="100%">
		<tr>
			<td width="5%">
				a. 
			</td>
			<td width="95%">
				Keluhan Pasien : <?php echo $model->keluhanakhir; ?>
			</td>
		</tr>
		<tr>
			<td width="5%">
				b. 
			</td>
			<td width="95%">
				Keadaan Umum : 
			</td>
		</tr>
		<tr>
			<td width="5%">

			</td>
			<td width="95%">
				<?php echo $model->keadaanumumakhir; ?>
			</td>
		</tr>
		<tr>
			<td width="5%">

			</td>
			<td width="95%">
				Tanda Vital : TD <?php echo $model->tekanandarahakhir . ' N ' . $model->detaknadiakhir . ' S ' . $model->suhutubuhakhir . ' R ' . $model->pernapasanakhir; ?>
			</td>
		</tr>
	</table>
	<table class="table">
		<tr>
			<th style="width:50%; text-align:center; padding-bottom: 50px;"></th>
			<th style="width:50%; text-align:center; padding-top: 50px;" colspan="2"><?php echo $modProfile->kabupaten->kabupaten_nama . ' , ' . MyFormatter::formatDateTimeForUser(date("Y-m-d")); ?></th>
		</tr>
		<tr>
			<th style="width:50%; text-align:center; padding-bottom: 50px;">

			</th>
			<th style="width:50%; text-align:center; padding-bottom: 50px;">
				Perawatan / Bidan
				<br><br><br><br><br><br>
				( <?php echo $model->namaperawat; ?> )
			</th>
		</tr>
	</table>