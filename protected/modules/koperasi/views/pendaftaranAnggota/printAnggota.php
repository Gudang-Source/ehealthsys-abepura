<style>

@media page {
	size: A4;
}
	h1{
		font-size: 16px;
		margin-top: 0px;
		margin-bottom: 20px;
	}

hr.symbol {
		margin-top:0;
		border-top: double #333;
}
body {
	border: 1px dashed black;
	width: 210mm;
	height: 297mm;
	padding: 10mm;
	font-family: serif;
}

.tab-data td {
	padding: 2px;
}

.main-data {
	padding: 5px;
	border: 1px solid black;
	margin-bottom: 10px;
	font-weight: bold;
	font-size: 18px;	
}

@media print {
	body {
		border: none;
	}
}

</style>
<table>
<tr>
<td>
<?php //echo CHtml::image(Params::urlProfilGambar().$profil->logo_rumahsakit, '', array('width'=>50)); ?>
</td>
<td><h1><center>
	<b>KOPERASI PEGAWAI REPUBLIK INDONESIA<br>
	<?php echo $profil->nama_rumahsakit; ?></b><br>
	<?php //echo $profil->badanhukum; ?>
</center></h1>

</td>
</tr>
</table>
<hr class="symbol" />
<div class="main-data">DATA ANGGOTA</div>
<table width="100%" class="tab-data">
	<tr>
		<td width="25%">Nama Anggota</td>
		<td>:</td>
		<td><?php echo strtoupper($anggota->nama_pegawai); ?></td>
	</tr>
	<tr>
		<td>No Anggota</td>
		<td>:</td>
		<td width="100%"><?php echo $anggota->nokeanggotaan; ?></td>
		<td rowspan="10" nowrap style="width:40mm; text-align:right; vertical-align: top;"><img src="<?php echo Params::urlPegawaiGambar().$anggota->photopegawai; ?>" style="width: 30mm; height:40mm;" /></td>
	</tr>
	<tr>
		<td>Tgl Keanggotaan</td>
		<td>:</td>
		<td><?php echo MyFormatter::formatDateTimeId($anggota->tglkeanggotaaan); ?></td>
	</tr>
	<tr>
		<td>NIP</td>
		<td>:</td>
		<td><?php echo strtoupper($anggota->nomorindukpegawai); ?></td>
	</tr>
	<tr>
		<td nowrap>Tempat / Tgl Lahir</td>
		<td>:</td>
		<td><?php echo strtoupper($anggota->tempatlahir_pegawai).", ".MyFormatter::formatDateTimeId($anggota->tgl_lahirpegawai); ?></td>
	</tr>
	<tr>
		<td>Jenis Kelamin</td>
		<td>:</td>
		<td><?php echo strtoupper($anggota->jeniskelamin); ?></td>
	</tr>
	<!--<tr>
		<td>Alamat</td>
		<td>:</td>
		<td><?php echo strtoupper($anggota->alamat_pegawai); ?></td>
	</tr>-->
	<tr>
		<td>Agama</td>
		<td>:</td>
		<td width="100%"><?php echo $anggota->agama; ?></td>
	</tr>
	<tr>
		<td>Status Perkawinan</td>
		<td>:</td>
		<td><?php echo $anggota->statusperkawinan; ?></td>
	</tr>
	<!--<tr>
		<td>Pangkat</td>
		<td>:</td>
		<td><?php echo $anggota->pangkat_nama; ?></td>
	</tr>
	<tr>
		<td>Jabatan</td>
		<td>:</td>
		<td><?php echo $anggota->jabatan_nama; ?></td>
	</tr>-->
	<tr>
		<td>Unit</td>
		<td>:</td>
		<td><?php //echo $anggota->namaunit; ?></td>
	</tr>
	<tr>
		<td>Golongan</td>
		<td>:</td>
		<td><?php echo $anggota->NamaGolongan; ?></td>
	</tr>
</table>