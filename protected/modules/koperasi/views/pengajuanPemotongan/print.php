<?php
$format = new MyFormatter; 
?>
<style>
h1{
		font-size: 16px;
		font-weight: bold;
		margin-top: 0px;
		margin-bottom: 20px;
		text-align: center;
	}
	body, table{
		width: 900px;	
		font-size: 11px;
		margin-left: auto;
    	margin-right: auto;
	}
	thead{
		font-weight: bold;
	}
hr.symbol {
		margin-top:0px;
		border-top: 2px solid #333;
		border-bottom: 1px solid #333;
		height:2px;
}
.currency{
	text-align: right;
}
</style>

<table>
<tr>
<td>
<?php echo CHtml::image(Params::urlProfilGambar().$profil->path_valuesimage1, '', array('width'=>50)); ?>
</td>
<td><h1>DAFTAR PENGAJUAN PEMOTONGAN<br/>
<?php echo $profil->nama_profil;?><br/>
BULAN : <?php echo strtoupper($format->getMonthId(date('m')))." ".date('Y');?></h1>
</td>
</tr>
</table>
<hr class="symbol" />

<table>
<tr>
<td width="100px">No Surat Pengajuan</td>
<td>: <?php echo $model[0]->nopengajuan;?></td>
</tr>
<tr>
<td>Tgl Pengajuan</td>
<td>: <?php echo MyFormatter::formatDateTimeId($model[0]->tglpengajuanpemb);?></td>
</tr>
</table>

<br>
<table border="1" width="100%">
<thead>
<tr>
<td rowspan="">
NO
</td>
<td rowspan="">NO. REKENING</td>
<td rowspan="">NAMA ANGGOTA</td>
<td rowspan="">UNIT</td>
<td rowspan="">GOLONGAN</td>
<td>SIMPANAN WAJIB</td>
<td>SIMPANAN SUKARELA</td>
<td>ANGSURAN POKOK</td>
<td>JASA ANGSURAN</td>
<td>BARANG KOPERASI</td>
<td rowspan="">JUMLAH PENGAJUAN</td>
</tr>
</thead>
<tbody>
	<?php 
		$i=0; $jum=0; 
		foreach ($model as $item){
			$i++;
			//$jum=($item->simpananwajib + $item->simpanansukarela + $item->jmlpokok_angsuran + $item->jmljasa_angsuran);
		echo '<tr>
				<td>'.$i.'</td>
			   <td>'.$item->norekening.'</td>
			   <td>'.$item->nama_pegawai.'</td>
			   <td>'.$item->namaunit.'</td>
			   <td>'.$item->golonganpegawai_nama.'</td>
			   <td class="currency">'.number_format($item->simpananwajib,0,",",".").'</td>
			   <td class="currency">'.number_format($item->simpanansukarela,0,",",".").'</td>
			   <td class="currency">'.number_format($item->jmlpokok_angsuran,0,",",".").'</td>
			   <td class="currency">'.number_format($item->jmljasa_angsuran,0,",",".").'</td>
			   <td></td>
			 	<td class="currency">'.number_format($item->jmlpengajuan_pengangsuran,0,",",".").'</td>
			   </tr>';
	
	}?>
	<tr>
	<td></td>
	<td colspan="4" style="text-align:center"><b>Jumlah Dipindahkan</b></td>
	<?php $totSimpWajib = 0;
			$totSimpSukarela = 0;
			$totAngsPokok = 0;
			$totJasaAngsuran = 0;
				 foreach ($model as $item){
			$totSimpWajib+=($item->simpananwajib);	
			$totSimpSukarela+=($item->simpanansukarela);	
			$totAngsPokok+=($item->jmlpokok_angsuran);	
			$totJasaAngsuran+=($item->jmljasa_angsuran);	
	}
	echo '<td class="currency">'.number_format($totSimpWajib,0,",",".").'</td>
			<td class="currency">'.number_format($totSimpSukarela,0,",",".").'</td>	
			<td class="currency">'.number_format($totAngsPokok,0,",",".").'</td>	
			<td class="currency">'.number_format($totJasaAngsuran,0,",",".").'</td>';	
	?>
	<td></td>
	<td class="currency">
	<?php
		$jum=0; 		
	 	foreach ($model as $item){
		$jum+=$item->jmlpengajuan_pengangsuran;	
	}
	echo number_format($jum,0,",",".");	
	?>
	</td>
	</tr>
</tbody>
</table>

<br/>
<div>
<?php echo $profil->kota_kab_profil; ?>, <?php echo MyFormatter::formatDateTimeId(date("d m Y"));?>
</div>

<?php
	foreach ($model as $item){
	$mengetahui = PegawaiM::model()->findByPK($item->diperiksaoleh_id_pengpemb); 
	$disetujui = PegawaiM::model()->findByPK($item->disetujuioleh_id_pengpemb);
	$dibuat = PegawaiM::model()->findByPK($item->dibuatoleh_id_pengpemb);
	}
?>
<table width="100%">
<tr>
	<td width="40%">Mengetahui,</td>
	<td style="padding-left:50px;">Disetujui,</td>
	<td style="text-align:right">Dibuat Oleh</td>
</tr>
<tr>
	<td><br/>( <b><?php echo $mengetahui->gelardepan." ".$mengetahui->nama_pegawai; ?></b> )</td>
	<td><br/>( <b><?php echo $disetujui->gelardepan." ".$disetujui->nama_pegawai; ?></b> )</td>
	<td style="text-align:right;padding-right:5px"><br/>( <b><?php echo $dibuat->gelardepan." ".$dibuat->nama_pegawai; ?></b> )</td>
</tr>
</table>