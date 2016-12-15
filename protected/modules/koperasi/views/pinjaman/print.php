<style>
		h1{
		font-size: 16px;
		margin-top: 0px;
	}
	body, table{
		width: 900px;	
		font-size: 11px;
   	margin-left: auto;
    	margin-right: auto;
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
.tab-padless td {
	padding: 0px;
}
#detail-angsuran td {
	padding: 2px;
}
.tab-tr-center td, .center {
	text-align: center;
}
.unders {
	text-decoration: underline;
}
ol {
	padding-left: 20px;
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
<div class="center unders">SURAT PERJANJIAN PINJAMAN</div>
<div class="center">No : <?php echo $pinjaman->no_pinjaman; ?></div>
<br>
Yang bertandatangan dibawah ni :<br/>
<table class="tab-padless">
	<tr>
		<td width="10%">Nama</td>
		<td>: <?php echo $permintaan->nama_pegawai; ?></td>
	</tr>
	<tr>
		<td>No Anggota</td>
		<td>: <?php echo $permintaan->nokeanggotaan; ?></td>
	</tr>
	<tr>
		<td>Alamat</td>
		<td>: <?php echo $permintaan->alamat_pegawai; ?></td>
	</tr>
</table>
<p>Dengan ini saya mengaku telah menerima pinjaman dari Unit Simpan Pinjam yang telah diberi kuasa oleh KPRI RSUD Karawang Sebesar Rp 
<?php echo number_format($pinjaman->jml_pinjaman, 0, ',', '.'); ?> (<?php echo MyFormatter::formatNumberTerbilang($pinjaman->jml_pinjaman, 3); ?> Rupiah).</p>
<ol type='A' class="ol-master">
	<li>Jumlah pinjaman tersebut telah saya terima semuanya dengan perjanjian Sebagai berikut : <br/>
	<br><table width="100%" id="detail-angsuran" border="1">
		<tr>
			<td style="text-align:center;width:10px">Angsuran Ke</td>
			<td style="text-align:center;width:'25%'">Tanggal Angsuran</td>
			<td style="text-align:center;width:'25%'">Pokok Angsuran</td>
			<td style="text-align:center;width:'25%'">Jasa Angsuran</td>
			<td style="text-align:center;width:'25%'">Jumlah Angsuran</td>
		</tr>
		<?php foreach ($angsuran as $item) : ?>
		<tr>
			<td style="text-align:center"><?php echo $item->angsuran_ke; ?></td>
			<td><?php echo MyFormatter::formatDateTimeId(date('d m Y', strtotime($item->tglangsuran))); ?></td>
			<td style="text-align:right">Rp. <?php echo number_format($item->jmlpokok_angsuran, 0, ',', '.'); ?></td>
			<td style="text-align:right">Rp. <?php echo number_format($item->jmljasa_angsuran, 0, ',', '.'); ?></td>
			<td style="text-align:right">Rp. <?php echo number_format(($item->jmlpokok_angsuran + $item->jmljasa_angsuran), 0, ',', '.'); ?></td>
		</tr>
		<?php endforeach; ?>
		
<?php 
$konfig = KonfigurasikoperasiK::model()->find(array('condition'=>'isberlaku = true'), array('order'=>'kofigurasikoperasi_id asc'));
$pimpinan = PegawaiM::model()->findByPk($konfig->pimpiankoperasi_id);
$bendahara = PegawaiM::model()->findByPk($konfig->bendahara_id);

if (empty($bendahara)) $bendahara = new PegawaiM;
?>
	</table><br>
	</li>
	<li>
	Sebagai jaminan atas pinjaman tersebut saya sertakan :
	<ol>
		<li>Uang Simpanan saya termasuk jasanya kepada unit Simpan Pinjam</li>
		<li>Jaminan Berupa : <?php echo $pinjaman->jaminan_berupa; ?></li>
	</ol>
	</li>
	<li>Setiap Pinjaman dikenakan biaya provisi <?php echo $konfig->persenbiayaprovisasi?>% dari jumlah pinjaman.</li>
</ol>
<?php 
$konfig = KonfigurasikoperasiK::model()->find(array('condition'=>'isberlaku = true'), array('order'=>'kofigurasikoperasi_id asc'));
$pimpinan = PegawaiM::model()->findByPk($konfig->pimpiankoperasi_id);
$bendahara = PegawaiM::model()->findByPk($konfig->bendahara_id);

if (empty($bendahara)) $bendahara = new PegawaiM;
?>
<table class="tab-padless" width="100%">
	<tr>
		<td colspan="2"></td>
		<td style="text-align:right"><?php echo $profil->kota_kab_profil.", ".MyFormatter::formatDateTimeId(date('d m Y')); ?></td>
	</tr>
	<tr class="tab-tr-center">
		<td nowrap>Pemohon,<br><br><br><br><br>(<?php echo $permintaan->nama_pegawai; ?>)</td>
		<td style="padding-left:150px;width:'70%'">Bendahara,<br><br><br><br><br>(<?php echo $bendahara->nama_pegawai; ?>)</td>
		<td style="text-align:right"><span style="padding-right:45px;">Ketua,</span><br><br><br><br><br>(<?php echo $pimpinan->nama_pegawai; ?>)</td>
	</tr>
</table>


