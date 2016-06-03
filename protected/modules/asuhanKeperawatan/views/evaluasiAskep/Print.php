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
			<td width="10%">Nama</td>
			<td width="40%">: <?php echo (isset($modPasien->nama_pasien) ? $modPasien->nama_pasien : " - "); ?></td>
			<td width="10%">No. RM</td>
			<td width="40%">: <?php echo isset($modPasien->no_rekam_medik) ? $modPasien->no_rekam_medik : " - "; ?></td>
		</tr>
		<tr>
			<td width="10%">Umur</td>
			<td width="40%">: <?php echo (isset($modPasien->umur) ? $modPasien->umur : " - "); ?></td>
			<td width="10%">Kamar / Kelas</td>
			<td width="40%">: <?php echo (isset($modPasien->kamarruangan_nokamar) ? $modPasien->kamarruangan_nokamar : " - ") . ' / ' . (isset($modPasien->kelaspelayanan_nama) ? $modPasien->kelaspelayanan_nama : " - ") ; ?></td>
		</tr>
		<tr>
			<td width="10%">Diagnosa Medis</td>
			<td width="40%">: <?php echo (isset($modPasien->diagnosa_nama) ? $modPasien->diagnosa_nama : " - "); ?></td>
			<td width="10%">Tgl Masuk RS</td>
			<td width="40%">: <?php echo isset($modPasien->tgl_pendaftaran) ? MyFormatter::formatDateTimeForUser($modPasien->tgl_pendaftaran) : " - "; ?></td>
		</tr>
		<tr>
			<td width="10%">Dokter</td>
			<td width="40%">: <?php echo (isset($modPasien->nama_pegawai) ? $modPasien->nama_pegawai : " - "); ?></td>
		</tr>
	</table>
	<br>
	<table width="100%" class="table table-striped table-bordered table-condensed">
		<tr>
			<th>Tanggal / Jam</th>
			<th>Evaluasi</th>
			<th>Paraf / Nama Perawat</th>
		</tr>
		<?php
		$modDetail = ASEvaluasiaskepdetT::model()->findAllByAttributes(array('evaluasiaskep_id'=>$model->evaluasiaskep_id));

		if (count($modDetail)) {
			foreach ($modDetail as $i => $detail) {
				?>
				<tr>
					<td>
						<?php echo MyFormatter::formatDateTimeForUser($model->evaluasiaskep_tgl); ?>
					</td>
					<td>
						<?php echo "<strong>Subjektif:</strong>"; ?>
						<?php echo "<br>"; ?>
						<?php echo $detail->evaluasiaskepdet_subjektif; ?>
						<br>
						<br>
						<?php echo "<strong>Objektif:</strong>"; ?>
						<?php echo "<br>"; ?>
						<?php echo $detail->evaluasiaskepdet_objektif; ?>
						<br>
						<br>
						<?php echo "<strong>Assessment:</strong>"; ?>
						<?php echo "<br>"; ?>
						<?php echo $detail->evaluasiaskepdet_assessment; ?>
						<br>
						<br>
						<?php echo "<strong>Planning:</strong>"; ?>
						<?php echo "<br>"; ?>
						<?php echo $detail->evaluasiaskepdet_planning; ?>
						<br>
						<br>
						<?php echo "<strong>Hasil:</strong>"; ?>
						<?php echo "<br>"; ?>
						<?php echo $detail->evaluasiaskepdet_hasil; ?>
					</td>
					<td>
						
					</td>						
				</tr>
				<?php
			}
		} else {
			?>
			<tr>
				<td colspan="5">Data Tidak Ditemukan</td>
			</tr>
		<?php } ?>
	</table>
</div>