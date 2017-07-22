<?php
if (isset($caraPrint)){
    if($caraPrint=='EXCEL')
    {
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'.$judul_print.'-'.date("Y/m/d").'.xls"');
        header('Cache-Control: max-age=0');     
    }
}

if (!isset($res['metadata']) || $res['metadata']['code'] != 200) :
	echo "Peserta FKTL tidak ditemukan";
	Yii::app()->end();
else :
	$item = $res['response']['item'];
	$peserta = $item['peserta'];
	$diagnosa = empty($item['diagnosa'])?array('kdDiag'=>'-', 'nmDiag'=>'-'):$item['diagnosa'];
	$poli = empty($item['poliRujukan'])?array('kdPoli'=>'-', 'nmPoli'=>'-'):$item['poliRujukan'];


?>
<?php
$format = new MyFormatter;
if (!isset($_GET['frame'])){
    echo $this->renderPartial($this->path_view.'_headerPrint'); 
}
?>
<table width="100%" style="margin:0px;" cellpadding="0" cellspacing="0">
	<tr>
		<td align="center" valign="middle" colspan="3">
			<b><?php echo $judul_print ?></b>
		</td>
	</tr>
</table><br/>
<table width="100%" style="margin:0px;" cellpadding="0" cellspacing="0" class="table table-bordered table-striped" id="data-peserta">
	<tr>
		<td style="font-weight: bold;">Nomor Kartu Peserta</td>
		<td style="font-weight: bold;text-align:center;">:</td>
		<td id="noKartu"><?php echo $peserta['noKartu']; ?></td>
		
		<td style="font-weight: bold;">Keluhan</td>
		<td style="font-weight: bold;text-align:center;">:</td>
		<td id="keluhan"><?php echo $item['keluhan']; ?></td>
	</tr>
	<tr>
		<td style="font-weight: bold;">Nama Peserta</td>
		<td style="font-weight: bold;text-align:center;">:</td>
		<td id="nama"><?php echo $peserta['nama']; ?></td>
		
		<td style="font-weight: bold;">Diagnosa</td>
		<td style="font-weight: bold;text-align:center;">:</td>
		<td id="nmDiag"><?php echo $diagnosa['kdDiag']." - ".$diagnosa['nmDiag']; ?></td>
	</tr>
	<tr>
		<td style="font-weight: bold;">Tanggal Lahir</td>
		<td style="font-weight: bold;text-align:center;">:</td>
		<td id="tglLahir"><?php echo $peserta['tglLahir']; ?></td>
		
		<td style="font-weight: bold;">Pemeriksaan Fisik</td>
		<td style="font-weight: bold;text-align:center;">:</td>
		<td id="pemFisikLain"><?php echo $item['pemFisikLain']; ?></td>
	</tr>
	<tr>
		<td style="font-weight: bold;">Tanggal Kunjungan</td>
		<td style="font-weight: bold;text-align:center;">:</td>
		<td id="tglKunjungan"><?php echo $item['tglKunjungan']; ?>	</td>
		
		<td style="font-weight: bold;">Catatan</td>
		<td style="font-weight: bold;text-align:center;">:</td>
		<td id="catatan"><?php echo $item['catatan']; ?></td>
	</tr>
	<tr>
		<td style="font-weight: bold;">No. Kunjungan</td>
		<td style="font-weight: bold;text-align:center;">:</td>
		<td id="noKunjungan"><?php echo $item['noKunjungan']; ?></td>
		
		<td></td>
		<td></td>
		<td></td>
	</tr>
	<tr>
		<td style="font-weight: bold;">Kode Poli</td>
		<td style="font-weight: bold;text-align:center;">:</td>
		<td id="kdPoli"><?php echo $poli['kdPoli']; ?></td>
		
		<td style="font-weight: bold;">Nama Poli</td>
		<td style="font-weight: bold;text-align:center;">:</td>
		<td id="nmPoli"><?php echo $poli['nmPoli']; ?></td>
	</tr>
</table>
<?php endif; ?>