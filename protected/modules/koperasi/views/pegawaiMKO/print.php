<style>
	h1 {
		font-size: 16px;
		margin-top: 0px;
	}
	.header{
		text-align: center;	
		padding-right: 100px;
	}
	body, table{
		font-size: 11px;
   	margin-left: auto;
    	margin-right: auto;
	}
	.list {
		margin-top: 10px;
		margin-bottom: 10px;
	}
	.list td {
		padding: 0px;
	}
	.unlist {
		margin-top: 0px !important;
	}
	hr {
		border-color: black;
		border-style: dashed;
	}
	hr.notes {
		border-style: dotted;
	}
	.grid-al {
		vertical-align: top;
	}
		hr.symbol {
		margin-top:0px;
		border-top: 2px solid #333;
		border-bottom: 1px solid #333;
		height:2px;
	}
</style>
<?php echo $this->renderPartial('application.views.headerReport.headerDefaultSurat'); ?>
<h1 style="text-align:center">SURAT PERMOHONAN KEANGGOTAAN</h1>

<div>Saya yang bertanda tangan dibawah ini :</div>

<table class="list">
	<tr><td>Nama</td><td>: <?php echo $pegawai->nama_pegawai; ?>. Umur : <?php echo Params::getUmur($pegawai->tgl_lahirpegawai); ?> Tahun</td></tr>
	<tr><td>Status Pegawai</td><td>: Pegawai / Calon Pegawai / Magang /</td></tr>
	<tr><td>Pangkat / Golongan</td><td>: 
	<?php 
		$pangkat = PangkatM::model()->findByPk($pegawai->pangkat_id);
		$golongan = GolonganpegawaiM::model()->findByPk($pegawai->golonganpegawai_id);
		echo (empty($pangkat)?'-':$pangkat->pangkat_nama)." / ".(empty($golongan)?'-':$golongan->golonganpegawai_nama);
	?>
	</td></tr>
	<tr><td>Alamat Rumah</td><td>: <?php echo $pegawai->alamat_pegawai; ?></td></tr>
</table>

<p>
Setelah saya mengetahui sepintas/mendapat penjelasan mengenai Anggaran Dasar dan Anggaran Rumah Tangga Koperasi Pegawai RSUD Karawang,
maka saya mengajukan permohonan menjadi anggota Koperasi Pegawai RSUD Karawang ini dan saya sanggup untuk melunasi Simpanan Pokok dan Simpanan Wajib yang telah
ditentukan dan ketentuan - ketentuan lain bagi anggota yang telah tercantum dalam Anggaran Dasar dan Anggaran Rumah Tangga Koperasi ini.
</p>
<br/>

<div style="text-align:right; padding-right:10px"><?php echo Yii::app()->user->getState('kecamatan_nama').', '. MyFormatter::formatDateTimeId(date('j m Y')); ?></div>
<table>
<tr>
	<td width="100%"></td>
	<td style="text-align:center" nowrap>Pemohon<br/><br/><br/><br/><br/>( <?php echo $pegawai->nama_pegawai; ?> )</td>
</tr>
</table>
<hr/>
<div>Catatan Pengurus :</div>
<hr class="notes"/>
<hr class="notes"/>
<hr class="notes"/>
<hr class="notes"/>
<div><?php ?></div>
<div style="text-align:right; padding-right:10px"><?php echo Yii::app()->user->getState('kecamatan_nama').', '. MyFormatter::formatDateTimeId(date('j m Y')); ?></div>
<table>
<tr>
	<td width="100%"></td>
	<td style="text-align:center" nowrap>Tertanda<br/><br/><br/><br/></td>
</tr>
<tr>
	<td></td><td nowrap><?php 
	$pengurus = PegawaiM::model()->findByPk($konfig->penguruskoperasi_id);
	$nama_pegawai = empty($pengurus)?"":$pengurus->namaLengkap;
	$jabaran = empty($pengurus)?"":(empty($pengurus->jabatan_id)?"":$pengurus->jabatan->jabatan_nama);
	
	echo "Nama : ".$nama_pegawai.'<br>'.
	"Jabatan : ".$jabaran.'<br>'
	 ?></td>
</tr>
</table>
<hr/>

<h1 style="text-align:center; border-bottom: 1px solid black">KOPERASI PEGAWAI <?php echo Yii::app()->user->getState("nama_rumahsakit"); ?></h1>

<table>
	<tr>
		<td class="grid-al">
			<table class="list unlist">
				<tr><td>Nomor</td><td style="padding-left:5px">: ..................</td></tr>
				<tr><td>Perihal</td><td style="padding-left:5px">: Permohonan menjadi anggota Koperasi</td></tr>
				<tr><td>A/n Sdr</td><td style="padding-left:5px">: <?php echo $pegawai->nama_pegawai; ?></td></tr>
			</table>
			<p>
			Menjawab surat permohonan menjadi anggota Koperasi Pegawai RSUD Karawang yang Saudara tulis tertanggal........................
			maka Pengurus Koperasi dapat menyetujui / menolak sementara.
			
			Untuk penjelasan selanjutnya Saudara dapat menghubungi saudara sekertaris Ketua / Wakilnya di kantor Koperasi Pegawai RSUD Karawang.
			</p>
		</td>
		<td class="grid-al">
			<div style="text-align:right; padding-right:10px"><?php echo Yii::app()->user->getState('kecamatan_nama').',........................'?></div>
			<table>
			<tr>
				<td width="100%"></td>
				<td style="text-align:center" nowrap>Tertanda<br/><br/><br/><br/></td>
			</tr>
			<tr>
				<td></td><td nowrap><?php 
				$pengurus = PegawaiM::model()->findByPk($konfig->pimpinankoperasi_id);
				$nama_pegawai = empty($pengurus)?"":$pengurus->namaLengkap;
				$jabaran = empty($pengurus)?"":(empty($pengurus->jabatan_id)?"":$pengurus->jabatan->jabatan_nama);
				//$pengurus = PegawaiM::model()->findByPk($anggota->disetujuioleh);
				echo "Nama : ".$nama_pegawai.'<br>'.
				"Jabatan : ".$jabaran.'<br>'
				 ?></td>
			</tr>
			</table>			
		</td>
	</tr>
</table>

<script>
print();
</script>
