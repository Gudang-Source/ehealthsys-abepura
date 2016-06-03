<style>
    .barcode-label{
        margin-top:-20px;
        z-index: 1;
        text-align: center;
        letter-spacing: 10px;
    }
    td, th{
        font-size: 8pt !important;
        height: 24px;
        padding-left:10px;
    }
    body{
        width: 21.7cm;
    }
    .content td{
        height: 32px;
    }

	#imgtag
	{
		position: relative;
		min-width: 300px;
		min-height: 300px;
		float: none;
		border: 3px solid #FFF;
		cursor: crosshair;
		text-align: center;
	}


</style>
<?php // echo $this->renderPartial($this->path_view.'_headerPrint'); ?>
<table width="100%">
	<tr>
		<td width="20%">
			<strong>Nama Pasien</strong>
		</td>
		<td width="30%">
			: <?php echo $modPasien->nama_pasien; ?>
		</td>
		<td width="20%">
			<strong>Tanggal Pemeriksaan Fisik</strong>
		</td>
		<td width="30%">
			: <?php echo MyFormatter::formatDateTimeForUser($modPemeriksaanFisik->tglperiksafisik); ?>
		</td>
	</tr>
	<tr>
		<td width="20%">
			<strong>Jenis Kelamin</strong>
		</td>
		<td width="30%">
			: <?php echo $modPasien->jeniskelamin; ?>
		</td>
		<td width="20%">
			<strong>Dokter Pemeriksa</strong>
		</td>
		<td width="30%">
			: <?php echo (!empty($modPemeriksaanFisik->pegawai->gelardepan) ? $modPemeriksaanFisik->pegawai->gelardepan : "") . " " . (!empty($modPemeriksaanFisik->pegawai->nama_pegawai) ? $modPemeriksaanFisik->pegawai->nama_pegawai : "") . " " . (!empty($modPemeriksaanFisik->pegawai->gelarbelakang_nama) ? $modPemeriksaanFisik->pegawai->gelarbelakang_nama : ""); ?>
		</td>
	</tr>
	<tr>
		<td width="20%">
			<strong>Umur</strong>
		</td>
		<td width="30%">
			: <?php echo $modPendaftaran->umur; ?>
		</td>
		<td width="20%">
			<strong>Nama Paramedis</strong>
		</td>
		<td width="30%">
			: <?php echo $modPemeriksaanFisik->paramedis_nama; ?>
		</td>
	</tr>
	<tr>
		<td width="20%">
			<strong>Tanggal Pendaftaran</strong>
		</td>
		<td width="30%">
			: <?php echo MyFormatter::formatDateTimeForUser($modPendaftaran->tgl_pendaftaran); ?>
		</td>
		<td width="20%">
			<strong>Kelas Pelayanan</strong>
		</td>
		<td width="30%">
			: <?php echo $modPendaftaran->kelaspelayanan->kelaspelayanan_nama; ?>
		</td>
	</tr>
	<tr>
		<td width="20%">
			<strong>No Pendaftaran</strong>
		</td>
		<td width="30%">
			: <?php echo $modPendaftaran->no_pendaftaran; ?>
		</td>
		<td width="20%">
		</td>
		<td width="30%">
		</td>
	</tr>
</table>
<br><br>
<table width="100%" border="1" class="content">
    <tr>
        <td align="center" valign="middle" colspan="4" style="font-weight:bold"><strong>PERIKSA FISIK</strong></td>
    </tr>
    <tr>
        <td width="30%">Tekanan Darah</td>
        <td width="20%"><?php echo (isset($modPemeriksaanFisik->tekanandarah) ? $modPemeriksaanFisik->tekanandarah : " - ") . ' /MmHg'; ?></td>
        <td width="30%">Mean Arterial Pressure</td>
        <td width="20%"><?php echo isset($modPemeriksaanFisik->meanarteripressure) ? $modPemeriksaanFisik->meanarteripressure : " - "; ?></td>
    </tr>
    <tr>
        <td width="30%">Detak Nadi</td>
        <td width="20%"><?php echo (isset($modPemeriksaanFisik->detaknadi) ? $modPemeriksaanFisik->detaknadi : " - ") . ' /Menit'; ?></td>
		<td width="30%">Denyut Jantung</td>
        <td width="20%"><?php echo (isset($modPemeriksaanFisik->denyutjantung) ? $modPemeriksaanFisik->denyutjantung : " - "); ?></td>
    </tr>
    <tr>
        <td width="30%">Pernapasan</td>
        <td width="20%"><?php echo (isset($modPemeriksaanFisik->pernapasan) ? $modPemeriksaanFisik->pernapasan : " - ") . ' /Menit'; ?></td>
		<td width="30%">Suhu Tubuh</td>
        <td width="20%"><?php echo (isset($modPemeriksaanFisik->suhutubuh) ? $modPemeriksaanFisik->suhutubuh : " - ") . ' &deg; Celcius'; ?></td>
    </tr>
    <tr>
    </tr>
    <tr>
        <td width="30%">Tinggi badan / Berat badan</td>
        <td width="20%"><?php echo (isset($modPemeriksaanFisik->tinggibadan_cm) ? $modPemeriksaanFisik->tinggibadan_cm : " - ") . ' Cm / ' . (isset($modPemeriksaanFisik->beratbadan_kg) ? $modPemeriksaanFisik->beratbadan_kg : " - ") . ' Kg'; ?></td>
		<td width="30%">Index Masa Tubuh</td>
        <td width="20%"><?php echo (isset($modPemeriksaanFisik->indexmassatubuh) ? $modPemeriksaanFisik->indexmassatubuh : " - "); ?></td>
    </tr>
    <tr>

    </tr>
    <tr>
        <td width="30%">Kelainan Pada Bagian Tubuh</td>
        <td width="20%"><?php echo isset($modPemeriksaanFisik->kelainanpadabagtubuh) ? $modPemeriksaanFisik->kelainanpadabagtubuh : " - "; ?></td>
		<td width="30%">Inspeksi</td>
        <td width="20%"><?php echo isset($modPemeriksaanFisik->inspeksi) ? $modPemeriksaanFisik->inspeksi : " - "; ?></td>
    </tr>
    <tr>
        <td width="30%">Palpasi</td>
        <td width="20%"><?php echo isset($modPemeriksaanFisik->palpasi) ? $modPemeriksaanFisik->palpasi : " - "; ?></td>
		<td width="30%">Perkusi</td>
        <td width="20%"><?php echo isset($modPemeriksaanFisik->perkusi) ? $modPemeriksaanFisik->perkusi : " - "; ?></td>
    </tr>
    <tr>
    </tr>
    <tr>
        <td width="30%">Auskultasi</td>
        <td width="20%"><?php echo isset($modPemeriksaanFisik->auskultasi) ? $modPemeriksaanFisik->auskultasi : " - "; ?></td>
		<td width="30%"></td>
        <td width="20%"></td>
    </tr>
</table>
<br>
<table width="100%" class="content" border="0">
	<tr>
		<td width="70%">
			<div align="center" id="imgtag">
				<img id="myImgId" src="<?php echo Params::urlPhotoAnatomiTubuh() . $modGambarTubuh->FileNameGambar; ?>" class="taggd"/> 
				<div id="tagbox"></div>
			</div>
		</td>
		<td width="30%" style="vertical-align:top;">
			<table border="1" width="100%" >
				<tr>
					<td colspan="3"><center><strong>Glasgow Coma Scale</strong></center></td>
	</tr>
	<tr>
		<td><strong>GCS Eye</strong></td>
		<td><?php echo!empty($modPemeriksaanFisik->gcs_eye) ? $modPemeriksaanFisik->metodegcseye->metodegcs_nama : ' - '; ?></td>
	</tr>
	<tr>
		<td><strong>GCS Verbal</strong></td>
		<td><?php echo!empty($modPemeriksaanFisik->gcs_verbal) ? $modPemeriksaanFisik->metodegcsverbal->metodegcs_nama : ' - '; ?></td>
	</tr>
	<tr>
		<td><strong>GCS Motorik</strong></td>
		<td><?php echo!empty($modPemeriksaanFisik->gcs_motorik) ? $modPemeriksaanFisik->metodegcsmotorik->metodegcs_nama : ' - '; ?></td>
	</tr>
	<tr>
		<td><strong> Nilai GCS</strong></td>
		<td><?php echo!empty($modPemeriksaanFisik->namaGCS) ? $modPemeriksaanFisik->namaGCS : ' - '; ?></td>
	</tr>
</table>
<br><br>
<table border="1" width="100%" >
	<tr>
		<td colspan="3"><center><strong>Anatomi Tubuh</strong></center></td>
</tr>
<?php if (count($modPemeriksaanGambar) > 0) { ?>
	<tr>
		<td><center><strong>No.</strong></center></td>
	<td><strong>Bagian Tubuh</strong></td>
	<td><strong>Keterangan</strong></td>
	</tr>
	<?php foreach ($modPemeriksaanGambar as $i => $v) { ?>
		<tr>
			<td><center><?= $i + 1; ?></center></td>
		<td><?= $v->bagiantubuh->namabagtubuh; ?></td>
		<td><?= $v->keterangan_periksa_gbr; ?></td>
		</tr>
	<?php } ?>
<?php } ?>
</table>
</td>
</tr>
</table>
<br><br><br>			
<table width="100%" border="1" >
	<tr>
        <td align="center" valign="middle" colspan="2" style="font-weight:bold"><strong>Jalan Nafas</strong></td>
        <td align="center" valign="middle" colspan="2" style="font-weight:bold"><strong>Pernafasan</strong></td>
    </tr>
	<tr>
		<td width="30%">Paten</td>
		<td width="20%"><?php echo ($modPemeriksaanFisik->jn_paten) ? '<strong>&#8730</strong>' : ' - '; ?></td>
		<td width="30%">Simetri</td>
		<td width="20%"><?php echo ($modPemeriksaanFisik->pgd_simetri) ? '<strong>&#8730</strong>' : ' - '; ?></td>
	</tr>
	<tr>
		<td width="30%">Obstruktif Partial</td>
		<td width="20%"><?php echo ($modPemeriksaanFisik->jn_obstruktifpartial) ? '<strong>&#8730</strong>' : ' - '; ?></td>
		<td width="30%">Asimetri</td>
		<td width="20%"><?php echo ($modPemeriksaanFisik->pgd_asimetri) ? '<strong>&#8730</strong>' : ' - '; ?></td>
	</tr>
	<tr>
		<td width="30%">Obstruktif Total</td>
		<td width="20%"><?php echo ($modPemeriksaanFisik->jn_obstruktifnormal) ? '<strong>&#8730</strong>' : ' - '; ?></td>
		<td width="30%">Normal</td>
		<td width="20%"><?php echo ($modPemeriksaanFisik->pgp_normal) ? '<strong>&#8730</strong>' : ' - '; ?></td>
	</tr>
	<tr>
		<td width="30%">Stridor</td>
		<td width="20%"><?php echo ($modPemeriksaanFisik->jn_stridor) ? '<strong>&#8730</strong>' : ' - '; ?></td>
		<td width="30%">Kussmaul</td>
		<td width="20%"><?php echo ($modPemeriksaanFisik->pgp_kussmaul) ? '<strong>&#8730</strong>' : ' - '; ?></td>
	</tr>
	<tr>
		<td width="30%">Gargling</td>
		<td width="20%"><?php echo ($modPemeriksaanFisik->jn_gargling) ? '<strong>&#8730</strong>' : ' - '; ?></td>
		<td width="30%">Takipena</td>
		<td width="20%"><?php echo ($modPemeriksaanFisik->pgp_takipnea) ? '<strong>&#8730</strong>' : ' - '; ?></td>
	</tr>
	<tr>
		<td width="30%"></td>
		<td width="20%"></td>
		<td width="30%">Retraktif</td>
		<td width="20%"><?php echo ($modPemeriksaanFisik->pgp_retraktif) ? '<strong>&#8730</strong>' : ' - '; ?></td>
	</tr>
	<tr>
		<td width="30%"></td>
		<td width="20%"></td>
		<td width="30%">Dangkal</td>
		<td width="20%"><?php echo ($modPemeriksaanFisik->pgp_dangkal) ? '<strong>&#8730</strong>' : ' - '; ?></td>
	</tr>
</table>
<br>
<table width="100%" border="1" >
	<tr>
		<td align="center" valign="middle" colspan="4" style="font-weight:bold"><strong>Sirkulasi</strong></td>
    </tr>
	<tr>
		<td width="30%">Nadi Carotis</td>
		<td width="20%"><?php echo ($modPemeriksaanFisik->sirkulasi_nadicarotis) ? $modPemeriksaanFisik->sirkulasi_nadicarotis . ' x/menit' : ' - '; ?></td>
		<td width="30%"> Kulit Cyanosis</td>
		<td width="20%"><?php echo ($modPemeriksaanFisik->kulit_cyanosis) ? '<strong>&#8730</strong>' : ' - '; ?></td>
	</tr>
	<tr>
		<td width="30%">Nadi Radialis</td>
		<td width="20%"><?php echo ($modPemeriksaanFisik->sirkulasi_nadiradialis) ? $modPemeriksaanFisik->sirkulasi_nadiradialis . ' x/menit' : ' - '; ?></td>
		<td width="30%"> Kulit Pucat</td>
		<td width="20%"><?php echo ($modPemeriksaanFisik->kulit_pucat) ? '<strong>&#8730</strong>' : ' - '; ?></td>
	</tr>
	<tr>
		<td width="30%">CFR</td>
		<td width="20%">
			<?php echo ($modPemeriksaanFisik->cfr_kecil_2) ? '<strong>&#8730</strong>' : ' - '; ?> <= 2 &nbsp; &nbsp;
			<?php echo ($modPemeriksaanFisik->cfr_besar_2) ? '<strong>&#8730</strong>' : ' - '; ?> >= 2
		</td>
		<td width="30%"> Kulit Berkeringat</td>
		<td width="20%"><?php echo ($modPemeriksaanFisik->kulit_berkeringat) ? '<strong>&#8730</strong>' : ' - '; ?></td>
	</tr>
	<tr>
		<td width="30%">Kulit Normal</td>
		<td width="20%"><?php echo ($modPemeriksaanFisik->kulit_normal) ? '<strong>&#8730</strong>' : ' - '; ?></td>
		<td width="30%"> Akral</td>
		<td width="20%"><?php echo ($modPemeriksaanFisik->akral) ? $modPemeriksaanFisik->akral : ' - '; ?></td>
	</tr>
	<tr>
		<td width="30%">Kulit Jaundice</td>
		<td width="20%"><?php echo ($modPemeriksaanFisik->kulit_jaundice) ? '<strong>&#8730</strong>' : ' - '; ?></td>
		<td width="30%"></td>
		<td width="20%"></td>
	</tr>
</table>
<br>
<table width="100%" border="1">
	<tr>
		<td width="20%">
			<strong>Gastrointestinal</strong>
		</td>
		<td width="30%">
			
		</td>
		<td width="20%">
			<strong>Neurosensori</strong>
		</td>
		<td width="30%">
			
		</td>
	</tr>
	<tr>
		<td width="20%">
			Keluhan
		</td>
		<td width="30%">
			<?php echo $modPemeriksaanFisik->gastrointestinal_sebutkan ;?>
		</td>
		<td width="20%">
			Pendengaran Tidak Normal
		</td>
		<td width="30%">
			<?php echo ($modPemeriksaanFisik->pendengaran == 1) ? "Ya" : "Tidak" ;?>
		</td>
	</tr>
	<tr>
		<td width="20%">
			Pembatasan Makanan
		</td>
		<td width="30%">
			<?php echo ($modPemeriksaanFisik->pembatasanmakanan == 1) ? "Ya" : "Tidak" ;?>
		</td>
		<td width="20%">
			Penglihatan Tidak Normal
		</td>
		<td width="30%">
			<?php echo ($modPemeriksaanFisik->penglihatan == 1) ? "Ya" : "Tidak" ;?>
		</td>
	</tr>
	<tr>
		<td width="20%">
			Gigi Palsu
		</td>
		<td width="30%">
			<?php echo ($modPemeriksaanFisik->gigipalsu == 1) ? "Ya" : "Tidak" ;?>
		</td>
		<td width="20%">
			<strong>Eliminasi</strong>
		</td>
		<td width="30%">
			
		</td>
	</tr>
	<tr>
		<td width="20%">
			Mual
		</td>
		<td width="30%">
			<?php echo ($modPemeriksaanFisik->mual == 1) ? "Ya" : "Tidak" ;?>
		</td>
		<td width="20%">
			Defekasi Tidak Normal
		</td>
		<td width="30%">
			<?php echo ($modPemeriksaanFisik->defekasi == 1) ? "Ya" : "Tidak" ;?>
		</td>
	</tr>
	<tr>
		<td width="20%">
			Muntah
		</td>
		<td width="30%">
			<?php echo ($modPemeriksaanFisik->muntah == 1) ? "Ya" : "Tidak" ;?>
		</td>
		<td width="20%">
			Miksi Tidak Normal
		</td>
		<td width="30%">
			<?php echo ($modPemeriksaanFisik->miksi == 1) ? "Ya" : "Tidak" ;?>
		</td>
	</tr>
	<tr>
		<td width="20%">
			<strong>Obstetri dan Ginekologi</strong>
		</td>
		<td width="30%">
		</td>
		<td width="20%">
			<strong>Kulit dan Kelamin</strong>
		</td>
		<td width="30%">
		</td>
	</tr>
	<tr>
		<td width="20%">
			Hamil
		</td>
		<td width="30%">
			<?php echo ($modPemeriksaanFisik->hamil == 1) ? "Ya" : "Tidak" ;?>
		</td>
		<td width="20%">
			Skor Norton
		</td>
		<td width="30%">
			<?php echo $modPemeriksaanFisik->skornorton ;?>
		</td>
	</tr>
	<tr>
		<td width="20%">
			HPHT
		</td>
		<td width="30%">
			<?php echo $modPemeriksaanFisik->hpht ;?>
		</td>
		<td width="20%">
			Resiko Dekubitus
		</td>
		<td width="30%">
			<?php echo ($modPemeriksaanFisik->resikodekubitus == 1) ? "Ya" : "Tidak" ;?>
		</td>
	</tr>
	<tr>
		<td width="20%">
			Keluhan Menstruasi
		</td>
		<td width="30%">
			<?php echo $modPemeriksaanFisik->keluhanmenstruasi ;?>
		</td>
		<td width="20%">
			Terdapat Luka
		</td>
		<td width="30%">
			<?php echo ($modPemeriksaanFisik->terdapatluka == 1) ? "Ya" : "Tidak" ;?>
		</td>
	</tr>
	<tr>
		<td width="20%">
		</td>
		<td width="30%">
		</td>
		<td width="20%">
			Lokasi Luka
		</td>
		<td width="30%">
			<?php echo $modPemeriksaanFisik->lokasiluka ;?>
		</td>
	</tr>
</table>
<br>
<table width="100%" border="1">
	<tr>
		<td width="50%">
			<strong>Kebutuhan Edukasi</strong>
		</td>
		<td width="50%">
			
		</td>
	</tr>
	<tr>
		<td width="50%">
			Hambatan Dalam Pembelajaran
		</td>
		<td width="50%">
			<?php echo ($modPemeriksaanFisik->hambatanpembelajaran) ? "Ya" : "Tidak";?>
		</td>
	</tr>
	<tr>
		<td width="50%">
			Dibutuhkan Penerjemah
		</td>
		<td width="50%">
			<?php echo ($modPemeriksaanFisik->butuhpenerjemah) ? "Ya" : "Tidak";?>
		</td>
	</tr>
	<tr>
		<td width="50%">
			Kebutuhan Pembelajaran
		</td>
		<td width="50%">
			<?php echo $modPemeriksaanFisik->kebutuhanpembelajaran;?>
		</td>
	</tr>
</table>
<script>
	function titikSesudahSimpan(titikX, titikY, urutan) {
		var titikX = titikX - 85;
		var titikY = titikY - 17;
		var nomor = urutan + 1;
		var color = '#000000';
		var size = '5px';
		$("#imgtag").append(
				$('<div><strong>' + nomor + '</strong></div>')
				.css('position', 'absolute')
				.css('top', titikY + 'px')
				.css('left', titikX + 'px')
				.css('width', size)
				.css('height', size)
				.css('background-color', color)
				.css('cursor', 'pointer')
				.css('display', 'block')
				.css('padding', '10px')
				.css('-webkit-border-radius', '50%')
				.css('-moz-border-radius', '50%')
				.css('border-radius', '50%')
				.css('vertical-align', 'middle')
				.css('color', '#FFF')
				);
	}

	function loadTitikSesudahSimpan() {
<?php
if (!empty($modPemeriksaanGambar)) {
	foreach ($modPemeriksaanGambar as $i => $v) {
		?>
				titikSesudahSimpan(<?= $v->kordinat_tubuh_x; ?>, <?= $v->kordinat_tubuh_y . ',' . $i; ?>);
	<?php
	}
}
?>
	}
	$(document).ready(function () {
		loadTitikSesudahSimpan();
	});
</script>
