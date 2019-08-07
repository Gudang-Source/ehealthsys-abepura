<p>Status Sosial</p>
<p>Hubungan pasien dengan anggota keluarga: <?php echo ($modAnamnesa->hubungankeluarga == 1) ? "Baik" : "Tidak Baik"; ?></p>
<p>Tempat tinggal: <?php echo (isset($modAnamnesa->tempattinggal) ? $modAnamnesa->tempattinggal : "-"); ?></p>
<p>Kerabat dekat yang bisa dihubungi: 
	<?php
	echo 'Nama: ' . (isset($modPenanggungJawab->nama_pj) ? $modPenanggungJawab->nama_pj : "-") .
	' Hubungan: ' . (isset($modPenanggungJawab->hubungankeluarga) ? $modPenanggungJawab->hubungankeluarga : "-") .
	' Telp: ' . (isset($modPenanggungJawab->nomobile_pj) ? $modPenanggungJawab->nomobile_pj : "-")
	;
	?>
</p>
<br>
<br>
<strong>PEMERIKSAAN FISIK</strong>
<table width="100%">
	<tr>
		<td width="25%">
			TD : <?php echo (isset($modPeriksaFisik->tekanandarah) ? $modPeriksaFisik->tekanandarah : "-"); ?> mmHg
		</td>
		<td width="25%">
			Nadi : <?php echo (isset($modPeriksaFisik->detaknadi) ? $modPeriksaFisik->detaknadi : "-"); ?> x/menit
		</td>
		<td width="25%">
			Pernafasan : <?php echo (isset($modPeriksaFisik->pernapasan) ? $modPeriksaFisik->pernapasan : "-"); ?> x/menit
		</td>
		<td width="25%">
			Suhu : <?php echo (isset($modPeriksaFisik->suhutubuh) ? $modPeriksaFisik->suhutubuh : "-"); ?>
		</td>
	</tr>
</table>
<br>
<strong>Gastrointestinal</strong>
<p>
	Keluhan: 
	<?php
	if ($modPeriksaFisik->adakelgastrointestinal == 1) {
		echo "Ya, sebutkan" . (isset($modPeriksaFisik->gastrointestinal_sebutkan) ? $modPeriksaFisik->gastrointestinal_sebutkan : "-");
	} else {
		echo "Tidak";
	}
	?>
</p>
<p>
	Pembatasan Makanan, sebutkan <?php echo (isset($modPeriksaFisik->batasmakanan_sebutkan) ? $modPeriksaFisik->batasmakanan_sebutkan : "-"); ?>
</p>
<p>
	Gigi Palsu: 
	<?php
	if ($modPeriksaFisik->gigipalsu == 1) {
		echo "Ya, " . (isset($modPeriksaFisik->gigipalsu_bagian) ? $modPeriksaFisik->gigipalsu_bagian : "-");
	} else {
		echo "Tidak";
	}
	?>
</p>
<p>
	Mual: <?php echo ($modPeriksaFisik->mual == 1) ? "Ya" : "Tidak"; ?>
</p>
<p>
	Muntah: <?php echo ($modPeriksaFisik->muntah == 1) ? "Ya" : "Tidak"; ?>
</p>
<br>
<strong>Neurosensori :</strong>
<p>
	Pendengaran: 
	<?php
	if ($modPeriksaFisik->pendengaran == 1) {
		echo "Normal";
	} else {
		echo "Tidak Normal, sebutkan" . (isset($modPeriksaFisik->pendengaran_sebutkan) ? $modPeriksaFisik->pendengaran_sebutkan : "-");
	}
	?>
</p>
<p>
	Penglihatan: 
	<?php
	if ($modPeriksaFisik->penglihatan == 1) {
		echo "Normal";
	} else {
		echo "Tidak Normal, sebutkan" . (isset($modPeriksaFisik->penglihatan_sebutkan) ? $modPeriksaFisik->penglihatan_sebutkan : "-");
	}
	?>
</p>
<br>
<strong>Eliminasi :</strong>
<p>
	Defekasi: 
	<?php
	if ($modPeriksaFisik->defekasi == 1) {
		echo "Normal";
	} else {
		echo "Tidak Normal, sebutkan" . (isset($modPeriksaFisik->defekasi_sebutkan) ? $modPeriksaFisik->defekasi_sebutkan : "-");
	}
	?>
</p>
<p>
	Miksi: 
	<?php
	if ($modPeriksaFisik->miksi == 1) {
		echo "Normal";
	} else {
		echo "Tidak Normal, sebutkan" . (isset($modPeriksaFisik->miksi_sebutkan) ? $modPeriksaFisik->miksi_sebutkan : "-");
	}
	?>
</p>
<br>
<strong>Obstetri dan Ginekologi :</strong>
<table width="100%">
	<tr>
		<td width="25%">
			Hamil: <?php echo ($modPeriksaFisik->hamil == 1) ? "Ya" : "Tidak"; ?>
		</td>
		<td width="25%">
			HPHT : <?php echo (isset($modPeriksaFisik->hpht) ? $modPeriksaFisik->hpht : "-"); ?>
		</td>
		<td width="50%">
			Keluhan menstruasi : <?php echo (isset($modPeriksaFisik->keluhanmenstruasi) ? $modPeriksaFisik->keluhanmenstruasi : "-"); ?>
		</td>
	</tr>
</table>
<br>
<strong>Kulit dan Kelamin</strong>
<p>
	Keadaan Kulit: 
	<?php
	if ($modPeriksaFisik->kulit_normal == 1) {
		echo "Normal";
	} else {
		echo "Tidak Normal, sebutkan ";
		echo
		(($modPeriksaFisik->kulit_jaundice == 1) ? "Jaundice, " : "") .
		(($modPeriksaFisik->kulit_cyanosis == 1) ? "Cyanosis, " : "") .
		(($modPeriksaFisik->kulit_pucat == 1) ? "Pucat, " : "") .
		(($modPeriksaFisik->kulit_berkeringat == 1) ? "Berkeringat, " : "")
		;
	}
	?>
</p>
<table width="100%">
	<tr>
		<td width="25%">
			Skor Norton : <?php echo (isset($modPeriksaFisik->skornorton) ? $modPeriksaFisik->skornorton : "-"); ?> / 20
		</td>
		<td width="25%">
			Resiko Dekubitus: <?php echo ($modPeriksaFisik->resikodekubitus == 1) ? "Ya" : "Tidak"; ?>
		</td>
		<td width="50%">
			Terdapat Luka: <?php echo ($modPeriksaFisik->terdapatluka == 1) ? "Ya" : "Tidak"; ?>
		</td>
	</tr>
</table>
<br>
<p>Lokasi Luka: <?php echo (isset($modPeriksaFisik->lokasiluka) ? $modPeriksaFisik->lokasiluka : "-"); ?></p>
<br>
<strong>KEBUTUHAN EDUKASI :</strong>
<p>
	a. Terdapat hambatan dalam pembelajaran : <?php echo ($modPeriksaFisik->hambatanpembelajaran == 1) ? "Ya" : "Tidak"; ?>
</p>
<p>
	b. Jika ya, sebutkan hambatannya : <br> 
	<?php echo (isset($modPeriksaFisik->hambatanpembelajaran) ? $modPeriksaFisik->hambatanpembelajaran : "-" ); ?>
</p>
<p>
	c. Dibutuhkan penerjemah : <?php echo ($modPeriksaFisik->butuhpenerjemah == 1) ? "Ya" : "Tidak"; ?>
</p>
<p>
	d. Kebutuhan pembelajaran pasien : <br> 
	<?php echo (isset($modPeriksaFisik->kebutuhanpembelajaran) ? $modPeriksaFisik->kebutuhanpembelajaran : "-" ); ?>
</p>