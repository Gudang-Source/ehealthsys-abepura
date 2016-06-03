<?php 
	echo '<p style="text-align:center;"><strong>RIWAYAT ANAMNESIS</strong></p>';
?>
<table width="100%">
	<tr>
		<td width="20%">
			<strong>Nama Pasien</strong>
		</td>
		<td width="30%">
			: <?php echo $modAnamnesa->nama_pasien; ?>
		</td>
		<td width="20%">
			<strong>Tanggal Anamnesis</strong>
		</td>
		<td width="30%">
			: <?php echo MyFormatter::formatDateTimeForUser($modAnamnesa->tglanamnesis);?>
		</td>
	</tr>
	<tr>
		<td width="20%">
			<strong>Jenis Kelamin</strong>
		</td>
		<td width="30%">
			: <?php echo $modAnamnesa->jeniskelamin; ?>
		</td>
		<td width="20%">
			<strong>Dokter Pemeriksa</strong>
		</td>
		<td width="30%">
			: <?php echo (!empty($modAnamnesa->gelardepan) ? $modAnamnesa->gelardepan : "") . " " . (!empty($modAnamnesa->nama_pegawai) ? $modAnamnesa->nama_pegawai : "") . " " . (!empty($modAnamnesa->gelarbelakang_nama) ? $modAnamnesa->gelarbelakang_nama : ""); ?>
		</td>
	</tr>
	<tr>
		<td width="20%">
			<strong>Umur</strong>
		</td>
		<td width="30%">
			: <?php echo $modAnamnesa->umur; ?>
		</td>
		<td width="20%">
			<strong>Nama Paramedis</strong>
		</td>
		<td width="30%">
			: <?php echo $modAnamnesa->nama_paramedis;?>
		</td>
	</tr>
	<tr>
		<td width="20%">
			<strong>Tanggal Pendaftaran</strong>
		</td>
		<td width="30%">
			: <?php echo MyFormatter::formatDateTimeForUser($modAnamnesa->tgl_pendaftaran); ?>
		</td>
		<td width="20%">
			<strong>Kelas Pelayanan</strong>
		</td>
		<td width="30%">
			: <?php echo $modAnamnesa->kelaspelayanan_nama;?>
		</td>
	</tr>
	<tr>
		<td width="20%">
			<strong>No Pendaftaran</strong>
		</td>
		<td width="30%">
			: <?php echo $modAnamnesa->no_pendaftaran; ?>
		</td>
		<td width="20%">
		</td>
		<td width="30%">
		</td>
	</tr>
</table>
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
			<strong>Jml Rokok / Hari</strong>
		</td>
		<td width="30%">
			<?php echo $modAnamnesa->jmlrokok_btg_hr; ?>
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
			<strong>Status Psikologis</strong>
		</td>
		<td width="30%">
			<?php echo $modAnamnesa->statuspsikologis; ?>
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
			<strong>Status Mental</strong>
		</td>
		<td width="30%">
			<?php echo $modAnamnesa->statusmental; ?>
		</td>
	</tr>
	<tr>
		<td width="20%">
			<strong>Pernah Dirawat</strong>
		</td>
		<td width="30%">
			<?php echo $modAnamnesa->pernahdirawat; ?>
		</td>
		<td width="20%">
			<strong>Masalah Yang Dialami Pasien Sebelumnya</strong>
		</td>
		<td width="30%">
			<?php echo $modAnamnesa->masalahsebelumnya; ?>
		</td>
	</tr>
	<tr>
		<td width="20%">
			<strong>Dimana</strong>
		</td>
		<td width="30%">
			<?php echo $modAnamnesa->dirawatdimana; ?>
		</td>
		<td width="20%">
			<strong>Perilaku Kekerasan Yang Dialami Pasien Sebelumnya</strong>
		</td>
		<td width="30%">
			<?php echo $modAnamnesa->prilakukekerasansebelumnya; ?>
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
			<strong>Penurunan BB Yang Tidak Diinginkan</strong>
		</td>
		<td width="30%">
			<?php echo $modAnamnesa->penurunanbb_3bln; ?>
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
			<strong>Asupan Berkurang</strong>
		</td>
		<td width="30%">
			<?php echo $modAnamnesa->asupanberkurang; ?>
		</td>
	</tr>
	<tr>
		<td width="20%">
			<strong>Riwayat Penyakit Keluarga Dari</strong>
		</td>
		<td width="30%">
			<?php echo $modAnamnesa->riwpenyakitkeldari; ?>
		</td>
		<td width="20%">
			<strong>Aktifitas dan Mobilisasi</strong>
		</td>
		<td width="30%">
			<?php echo $modAnamnesa->aktifitas_mobilisasi; ?>
		</td>
	</tr>
	<tr>
		<td width="20%">
			<strong>Penyakit Mayor</strong>
		</td>
		<td width="30%">
			<?php echo $modAnamnesa->penyakitmayor; ?>
		</td>
		<td width="20%">
			<strong>Sebutkan Bantuan</strong>
		</td>
		<td width="30%">
			<?php echo $modAnamnesa->sebutkan_bantuan; ?>
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
			<strong>Resiko Cedera / Jatuh</strong>
		</td>
		<td width="30%">
			<?php echo $modAnamnesa->resikocedera; ?>
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
			<strong>Gelang Resiko Jatuh Terpasang</strong>
		</td>
		<td width="30%">
			<?php echo ($modAnamnesa->isgelangresiko == 1) ? "Ya" : "Tidak" ; ?>
		</td>
	</tr>
	<tr>
		<td width="20%">
			<strong>Reaksi Alergi Obat</strong>
		</td>
		<td width="30%">
			<?php echo $modAnamnesa->reaksialergiobat; ?>
		</td>
		<td width="20%">
			<strong>Tanda Segitiga Warna Kuning Terpasang</strong>
		</td>
		<td width="30%">
			<?php echo $modAnamnesa->tandasegitigaterpasang ; ?>
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
			<strong>Penafsiran / Skrining Nyeri</strong>
		</td>
		<td width="30%">
			<?php echo $modAnamnesa->skriningnyeri ; ?>
		</td>
	</tr>
	<tr>
		<td width="20%">
			<strong>Reaksi Alergi Makanan</strong>
		</td>
		<td width="30%">
			<?php echo $modAnamnesa->reaksialergimakanan; ?>
		</td>
		<td width="20%">
			<strong>Skala Nyeri</strong>
		</td>
		<td width="30%">
			<?php echo $modAnamnesa->skalanyeri ; ?>
		</td>
	</tr>
	<tr>
		<td width="20%">
			<strong>Riwayat Alergi Lainnya</strong>
		</td>
		<td width="30%">
			<?php echo $modAnamnesa->riwayatalergilainnya; ?>
		</td>
		<td width="20%">
			<strong>Karakteristik Nyeri</strong>
		</td>
		<td width="30%">
			<?php echo $modAnamnesa->karakteristiknyeri ; ?>
		</td>
	</tr>
	<tr>
		<td width="20%">
			<strong>Reaksi Alergi Lainnya</strong>
		</td>
		<td width="30%">
			<?php echo $modAnamnesa->reaksialergilainnya; ?>
		</td>
		<td width="20%">
			<strong>Lokasi Nyeri</strong>
		</td>
		<td width="30%">
			<?php echo $modAnamnesa->lokasinyeri ; ?>
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
			<strong>Nyeri Terasa</strong>
		</td>
		<td width="30%">
			<?php echo $modAnamnesa->nyeriterasa ; ?>
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
			<strong>Nyeri Hilang Bila</strong>
		</td>
		<td width="30%">
			<?php echo $modAnamnesa->nyerihilangbila ; ?>
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
			<strong>Hubungan Pasien Dengan Anggota Keluarga</strong>
		</td>
		<td width="30%">
			<?php echo ($modAnamnesa->hubungankeluarga == 1) ? "Ya" : "Tidak" ; ?>
		</td>
	</tr>
	<tr>
		<td width="20%">
			<strong>Gelang Tanda Alergi Dipasang</strong>
		</td>
		<td width="30%">
			<?php echo $modAnamnesa->gelangtandaalergi; ?>
		</td>
		<td width="20%">
			<strong>Tempat Tinggal</strong>
		</td>
		<td width="30%">
			<?php echo $modAnamnesa->tempattinggal; ?>
		</td>
	</tr>
	<tr>
		<td width="20%">
			<strong>Status Merokok</strong>
		</td>
		<td width="30%">
			<?php echo ($modAnamnesa->statusmerokok == 1) ? "Ya" : "Tidak" ; ?>
		</td>
		<td width="20%">
			<strong>Keterangan Anamnesis</strong>
		</td>
		<td width="30%">
			<?php echo $modAnamnesa->keterangananamesa; ?>
		</td>
	</tr>
</table>