<style>	
	@page {
		size: A5 landscape;
	}
	body , table{
		width: 210mm;
		font-size: 11px;
   		margin-left: auto;
    	margin-right: auto;
	}
	
	h1{
		font-size: 16px;
		margin-top: 0px;
	}
	.header{
		text-align: center;
		padding-right: 100px;
	}
	hr.symbol {
		margin-top:0px;
		border-top: 2px solid #333;
		border-bottom: 1px solid #333;
		height:2px;
	}	
	
	.tabel td , th{
		border:1px solid black;
	}
	
	.judul-print {
		text-align: center;
	}
	
	.tab-list hr {
		padding: 0px;
		margin: 0px;
		border-style: dotted;
		border-color: black;
	}
	
	.tab-list td {
	}
	
	.signature td {
		text-align: center;
	}
</style>
<?php 
$penyetuju = PegawaiM::model()->findByPk($penangguhan->pen_disetujuioleh);
?>
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
<h1 class="judul-print"><u>SURAT PERMINTAAN PENANGGUHAN</u></h1>
Bahwa nama <?php echo $anggota->nama_pegawai; ?> No. Anggota <?php echo $anggota->nokeanggotaan; ?> pada bulan 
<?php echo strtoupper(MyFormatter::getMonthId(date('m'), strtotime($penangguhan->tglpermpenangguhan)))." ".date('Y', strtotime($penangguhan->tglpermpenangguhan)); ?>
 tidak dapat membayar <?php echo $penangguhan->jnspenangguhan; ?>
<table class="tab-list">
	<tr>
		<td width="150">Kesanggupan</td>
		<td width="150">: <?php echo MyFormatter::formatNumberForPrint($penangguhan->kesanggupanbayar); ?></td>
		<td>Persetujuan Ketua</td>
	</tr> 
	<tr>
		<td width="150">Besar Angsuran</td>
		<td width="150">: <?php echo MyFormatter::formatNumberForPrint($penangguhan->jumlahpinjaman); ?></td>
		<td><hr /></td>
	</tr>
	<tr>
		<td width="150">Tgl Pinjaman</td>
		<td width="150">: <?php echo MyFormatter::formatDateTimeId($pinjaman->tglpinjaman); ?></td>
		<td><hr /></td>
	</tr>
	<tr>
		<td width="150">Sisa Pinjaman</td>
		<td width="150">: <?php echo MyFormatter::formatNumberForPrint($penangguhan->sisapinjaman); ?></td>
		<td><hr /></td>
	</tr>
	<tr>
		<td width="150">Lain Lain</td>
		<td width="150"><hr /></td>
		<td><hr /></td>
	</tr>
</table>
<br/><br/>
<table class="signature">
	<tr>
		<td nowrap>Yang Mengajukan<br/><br/><br/><br/><br/><?php echo $anggota->nama_pegawai; ?></td>
		<td width="100%"></td>
		<td nowrap>Yang Menyetujui<br/><br/><br/><br/><br/><?php echo $penyetuju->nama_pegawai; ?></td>
	</tr>
</table>
