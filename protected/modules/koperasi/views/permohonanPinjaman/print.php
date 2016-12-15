<style>
	body , td , p {
		font-size: 12px;
	}
	.judul {
		text-align: center;
		font-weight: bold;
		text-decoration: underline;
	}
	p {
		text-align: justify;
	}
	.tab-title {
		text-align: center;
		padding: 10px;
	}
	.evtab > tbody > tr > td {
		border: 1px solid black;
		padding: 2px;
	}
	.evtab > tbody > tr > td > table td {
		padding: 2px;
	}
	.evtitle {
		text-align: center;
	}
	h1{
		font-size: 16px;
		margin-top: 0px;
		margin-bottom: 20px;
	}
	.header{
		text-align: center;	
	}
	hr.symbol {
		margin-top:0px;
		border-top: 2px solid #333;
		border-bottom: 1px solid #333;
		height:2px;
	}	
	.data-pegawai td {
		padding: 2px;
	}
	#btn-print {
		margin: 10px;
	}
</style>


<table width="100%">
<tr>
<td>
<?php echo CHtml::image(Params::urlProfilGambar().$profil->path_valuesimage1, '', array('width'=>50)); ?>
</td>
<td class="header"><h1>
	<b>KOPERASI PEGAWAI REPUBLIK INDONESIA<br>
	<?php echo $profil->nama_profil; ?></b><br>
	<?php echo $profil->badanhukum; ?>
</h1>
</td>
</tr>
</table>
<hr class="symbol" />
Kepada :<br/>
<table>
	<tr>
		<td style="vertical-align:top">Yth.</td>
		<td>Manajer USP<br/><?php echo $profil->nama_profil; ?><br/>Di Tempat</td>
	</tr>
</table>

<div class="judul">PERIHAL PERMOHONAN PINJAMAN <?php echo $permintaan->jenispinjaman_permohonan; ?></div>

Dengan hormat,<br/><br/>

Yang bertandatangan dibawah ini :<br/><br/>

<table class="data-pegawai">
	<tr>
		<td>Nomor Anggota</td>
		<td>: <?php echo $anggota->nokeanggotaan; ?></td>
	</tr>
	<tr>
		<td>Nama</td>
		<td>: <?php echo $pegawai->nama_pegawai; ?></td>
	</tr>
	<tr>
		<td>Pangkat/Golongan/NIP</td>
		<td>: <?php 
                
                echo empty($pegawai->pangkat_id)?"-":$pegawai->pangkat->pangkat_nama;
                echo " / ";
                echo empty($pegawai->golonganpegawai_id)?"-":$pegawai->golonganpegawai->golonganpegawai_nama;
                echo " / ";
                echo $pegawai->nomorindukpegawai; 
                ?></td>
	</tr>
	<tr>
		<td>Tanggal Lahir/Umur</td>
		<td>: <?php echo MyFormatter::formatDateTimeId($pegawai->tgl_lahirpegawai)." - ".Params::getUmur($pegawai->tgl_lahirpegawai)." Tahun"; ?></td>
	</tr>
	<tr>
		<td>Alamat</td>
		<td>: <?php echo $pegawai->alamat_pegawai; ?></td>
	</tr>
	
</table><br/>

<p>Dengan ini mengajukan permohonan untuk mendapat pinjaman uang dari <?php echo $profil->nama_profil; ?> sebesar Rp <?php echo number_format($permintaan->jmlpinjaman, 0, ',', '.'); ?> 
yang akan dipergunakan untuk <?php echo $permintaan->untukkeperluan; ?>. Saya bersedia membayar / melunasi Cicilan Pokok Pinjaman beserta jasa dan kewajiban-kewajiban 
lainnya, serta akan patuh pada peraturan dan persyaratan yang disetujui oleh <?php echo $profil->nama_profil; ?> sehubungan dengan permohonan pinjaman ini. Terima Kasih</p>

<table>
<tr>
	<td width="100%"></td>
	<td nowrap style="text-align:center">Pemohon<br><br><br><br>( <?php echo $pegawai->nama_pegawai; ?> )</td>
</tr>
</table>
<br/><br/>
<div class="evtitle">EVALUASI PERMOHONAN PINJAMAN</div>
<table width="100%" class="evtab">
	<tr><td class="tab-title">DATA NASABAH</td></tr>
	<tr><td>
	<table>
		<tr>
			<td>Nama</td>
			<td>: <?php echo $pegawai->nama_pegawai; ?></td>
		</tr>
		<tr>
			<td>Jumlah Permohonan</td>
			<td>: Rp <?php echo number_format($permintaan->jmlpinjaman, 0, ',', '.'); ?> </td>
		</tr>
		<tr>
			<td>Tanggal Permohonan</td>
			<td>: <?php echo MyFormatter::formatDateTimeId(date('Y-m-d', strtotime($permintaan->tglpermohonanpinjaman))); ?></td>
		</tr>
	</table>
	</td></tr>
	<tr><td class="tab-title">EVALUASI</td></tr>
	<tr><td>
		Sumber / kemampuan pengembalian pinjaman
	<table>
		<tr>
			<td>Jaminan</td>
			<td>: Gaji</td>
			<td>: Rp <?php echo number_format($permintaan->jmlgaji, 0, ',', '.'); ?> </td>
		</tr>
		<tr>
			<td></td>
			<td>: Insentif</td>
			<td>: Rp <?php echo number_format($permintaan->jmlinsentif, 0, ',', '.'); ?> </td>
		</tr>
		<tr>
			<td></td>
			<td>: Jmlh Simpanan</td>
			<td>: Rp <?php echo number_format($permintaan->jmlsimpanan, 0, ',', '.'); ?> </td>
		</tr>
	</table>
	</td></tr>
	<tr><td class="tab-title">KESIMPULAN</td></tr>
	<tr><td>Kesimpulan Analis : <?php 
	
	$permintaanv = InformasipermohonanpinjamanV::model()->findByAttributes(array('permohonanpinjaman_id'=>$permintaan->permohonanpinjaman_id));
	if (empty($permintaanv->approval_id)) echo "Disetujui/Tidak Disetujui";
	else echo ($permintaanv->status_disetujui == false)?"Tidak Disetujui":"Disetujui";
	
	?></td></tr>
	<tr><td>
	<table>
		<tr>
			<td width="100%">
				<table>
					<tr>
						<td>NB :</td>
						<td colspan="2">Ybs masih mempunyai tunggakan</td>
					</tr>
					<tr>
						<td></td>
						<td>Pinjaman</td>
						<td>: Rp <?php echo number_format($permintaan->jmltunggakanuangpinj, 0, ',', '.'); ?></td>
					</tr>
					<tr>
						<td></td>
						<td>Barang</td>
						<td>: Rp <?php echo number_format($permintaan->jmltunggakanbrgpinj, 0, ',', '.'); ?></td>
					</tr>
					<tr>
						<td></td>
						<td>Batas Plafon</td>
						<td>: Rp <?php echo number_format($permintaan->batasplafon, 0, ',', '.'); ?></td>
					</tr>
				</table>
			</td>
			<td nowrap style="text-align: center">
				Petugas<br><br><br><br>( <?php 
					/*$petugas = PegawaiM::model()->findByPk($permintaan->petugas_id);
					if (!empty($petugas)) echo $petugas->nama_pegawai;				
				*/ echo Yii::app()->user->name; ?> )
			</td>
		</tr>
	</table>
	</td></tr>
</table>
<?php if ($btnPrint && empty($permintaan->approval_id)) {
	echo CHtml::link('Print Permohonan', '#', array('id'=>'btn-print', 'class'=>'btn btn-success', 'onclick'=>'$("#btn-print").hide(); window.print(); $("#btn-print").show();'));
} ?>