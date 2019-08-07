<style>
	h1{
		font-size: 16px;
		margin-top: 0px;
		margin-bottom: 20px;
	}
	body {
		width: 210mm;	
		font-size: 12px;
	}
	table td {
		font-size: 12px;
	}
hr.symbol {
		margin-top:0px;
		border-top: 2px solid #333;
		border-bottom: 1px solid #333;
		height:2px;
}
	.header-text {
		font-size: 16px;
		text-align: center;
	}
	.detail td {
		padding: 2px;
	}
	.sign td {
		text-align: center;
	}
	#btn-print {
		margin: 10px;
	}
</style>
<?php 
$approval = ApprovalT::model()->findByPk($model->approval_id);
$permintaan = PermohonanpinjamanT::model()->findByPk($model->permohonanpinjaman_id);
?>
<table width="100%">
	<tr>
		<td width="70">
			<?php echo CHtml::image(Params::urlProfilGambar().$profil->path_valuesimage1, '', array('width'=>70)); ?>
		</td>
		<td class="header-text">
			<b>KOPERASI PEGAWAI REPUBLIK INDONESIA<br>
			<?php echo $profil->nama_profil; ?></b><br>
			<?php echo $profil->badanhukum; ?>
		</td>
	</tr>
</table>

<hr class="symbol">
<p>Kepada Yth,<br>
<?php echo $model->gelardepan." ".$model->nama_pegawai;?></p>

<p>Perihal : Persetujuan Kredit Saudara</p>

<p>Dengan Hormat,<br>
Menunjuk pada Surat Permohonan Pinjaman No <?php echo $model->nopermohonan?> tanggal <?php echo MyFormatter::formatDateTimeId(date("d m Y"))?>
<?php /* Sebesar <?php echo 'Rp.'.$model->jmlsimpanan.',-' ?> */ ?>, maka dengan ini kami beritahukan bahwa <?php echo $profil->nama_profil; ?> 
telah menyetujui permohonan pinjaman Saudara dengan ketentuan
sebagai berikut :
</p>

<table class="detail">
	<tr>
		<td>1. Besar pinjaman</td>	
		<td style="text-align:left">: <?php echo 'Rp. '.MyFormatter::formatNumberForPrint($model->jmlpinjaman).',-' ?></td>	
	</tr>
	<tr>
		<td >2. Jangka waktu pinjaman</td>	
		<td>: <?php echo $model->jangkawaktu_pinj_bln; ?> Bln</td>	
	</tr>
	<tr>
		<td>3. Besar jasa</td>	
		<td>: Rp. <?php echo MyFormatter::formatNumberForPrint($model->jmlpinjaman * ($model->jasapinjaman_bln/100)); ?>,-</td>	
	</tr>
	<tr>
		<td>4. Sistem / cara cicilan</td>	
		<td>: <?php echo empty($approval)?"":$approval->cara_bayar; ?></td>	
	</tr>
	<tr>
		<td>5. Jaminan</td>	
		<td>: <?php  ?></td>	
	</tr>
</table>
<br>
<p>
	Sebagai tanda persetujuan Saudara, harap tembusan surat ini ditanda tangani dan dikembalikan pada kami.
</p>
<br>
<p style="text-align:right; padding-right:10px">
	Disetujui Tanggal, <?php echo MyFormatter::formatDateTimeId(date("d m Y"));?><br>
	<?php echo $profil->nama_profil; ?>
</p>

<?php 
$konfig = KonfigurasikoperasiK::model()->find(array('condition'=>'isberlaku = true'), array('order'=>'kofigurasikoperasi_id asc'));
$pimpinan = PegawaiM::model()->findByPk($konfig->pimpiankoperasi_id);
$bendahara = PegawaiM::model()->findByPk($konfig->bendahara_id);
$bendahara_rs = PegawaiM::model()->findByPk($konfig->bendahara_rs_id);
$pinjaman = PinjamanT::model()->findByAttributes(array('permohonanpinjaman_id'=>$model->permohonanpinjaman_id));


if (empty($bendahara)) $bendahara = new PegawaiM;
?>

<table width="100%" class="sign">
<tr>
	<td width="25%" nowrap>Pemohon<br><br><br><br><br><br>( <?php echo $model->nama_pegawai; ?> )</td>
	<td width="25%" nowrap>Bendahara Gaji<br><br><br><br><br><br>( <?php echo $bendahara_rs->nama_pegawai; ?> )</td>
	<td width="25%" nowrap>Bendahara<br><br><br><br><br><br>( <?php echo $bendahara->nama_pegawai; ?> )</td>
	<td width="25%" nowrap>Ketua,<br><br><br><br><br><br>( <?php echo $pimpinan->nama_pegawai; ?> )</td>
</tr>
</table>
<?php if ($btnPrint && empty($pinjaman)) {
	echo CHtml::link('Print Persetujuan', '#', array('id'=>'btn-print', 'class'=>'btn btn-success', 'onclick'=>'$("#btn-print").hide(); window.print(); $("#btn-print").show();'));
} ?>