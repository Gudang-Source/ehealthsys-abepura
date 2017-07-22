<?php
if (isset($caraPrint)){
    if($caraPrint=='EXCEL')
    {
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'.$judul_print.'-'.date("Y/m/d").'.xls"');
        header('Cache-Control: max-age=0');     
    }
}
?>
<?php
$format = new MyFormatter;
if (!isset($_GET['frame'])){
    echo $this->renderPartial($this->path_view.'_headerPrint'); 
}
?>

<?php
if (!isset($res['metadata']) || $res['metadata']['code'] != 200) :
	echo "Peserta BPJS tidak ditemukan";
	Yii::app()->end();
else :
	
	$peserta = $res['response']['peserta'];
	$peserta['tglLahir'] = empty($peserta['tglLahir'])?"-":MyFormatter::formatDateTimeForUser($peserta['tglLahir']);
	$peserta['tglCetakKartu'] = empty($peserta['tglCetakKartu'])?"-":MyFormatter::formatDateTimeForUser($peserta['tglCetakKartu']);
	$peserta['tglTAT'] = empty($peserta['tglTAT'])?"-":MyFormatter::formatDateTimeForUser($peserta['tglTAT']);
	$peserta['tglTMT'] = empty($peserta['tglTMT'])?"-":MyFormatter::formatDateTimeForUser($peserta['tglTMT']);
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
		
		<td style="font-weight: bold;">Status Peserta</td>
		<td style="font-weight: bold;text-align:center;">:</td>
		<td id="keterangan"><?php echo $peserta['statusPeserta']['keterangan']; ?></td>
	</tr>
	<tr>
		<td style="font-weight: bold;">Nama Peserta</td>
		<td style="font-weight: bold;text-align:center;">:</td>
		<td id="nama"><?php echo $peserta['nama']; ?></td>
		
		<td style="font-weight: bold;">Tanggal Cetak Kartu</td>
		<td style="font-weight: bold;text-align:center;">:</td>
		<td id="tglCetakKartu"><?php echo $peserta['tglCetakKartu']; ?></td>
	</tr>
	<tr>
		<td style="font-weight: bold;">Tanggal Lahir</td>
		<td style="font-weight: bold;text-align:center;">:</td>
		<td id="tglLahir"><?php echo $peserta['tglLahir']; ?></td>
		
		<td style="font-weight: bold;">Tanggal TAT</td>
		<td style="font-weight: bold;text-align:center;">:</td>
		<td id="tglTAT"><?php echo $peserta['tglTAT']; ?></td>
	</tr>
	<tr>
		<td style="font-weight: bold;">NIK</td>
		<td style="font-weight: bold;text-align:center;">:</td>
		<td id="nik"><?php echo $peserta['nik']; ?></td>
		
		<td style="font-weight: bold;">Tanggal TMT</td>
		<td style="font-weight: bold;text-align:center;">:</td>
		<td id="tglTMT"><?php echo $peserta['tglTMT']; ?></td>
	</tr>
	<tr>
		<td style="font-weight: bold;">Jenis Kelamin</td>
		<td style="font-weight: bold;text-align:center;">:</td>
		<td id="sex"><?php echo $peserta['sex']; ?></td>
		
		<td style="font-weight: bold;">Nomor Rekam Medik</td>
		<td style="font-weight: bold;text-align:center;">:</td>
		<td id="noMr"><?php echo $peserta['noMr']; ?></td>
	</tr>
	<tr>
		<td style="font-weight: bold;">Kode Provider</td>
		<td style="font-weight: bold;text-align:center;">:</td>
		<td id="kdProvider"><?php echo $peserta['provUmum']['kdProvider']; ?></td>
		
		<td style="font-weight: bold;">Umur Sekarang</td>
		<td style="font-weight: bold;text-align:center;">:</td>
		<td id="umurSekarang"><?php echo $peserta['umur']['umurSekarang']; ?></td>
	</tr>
	<tr>
		<td style="font-weight: bold;">Provider</td>
		<td style="font-weight: bold;text-align:center;">:</td>
		<td id="nmProvider"><?php echo $peserta['provUmum']['nmProvider']; ?></td>
		
		<td style="font-weight: bold;">Umur Saat Pelayanan</td>
		<td style="font-weight: bold;text-align:center;">:</td>
		<td id="umurSaatPelayanan"><?php echo $peserta['umur']['umurSaatPelayanan']; ?></td>
	</tr>
	<tr>
		<td style="font-weight: bold;">Kode Cabang</td>
		<td style="font-weight: bold;text-align:center;">:</td>
		<td id="kdCabang"><?php echo $peserta['provUmum']['kdCabang']; ?></td>
		
		<td></td>
		<td></td>
		<td></td>
	</tr>
	<tr>
		<td style="font-weight: bold;">Nama Cabang</td>
		<td style="font-weight: bold;text-align:center;">:</td>
		<td id="nmCabang"><?php echo $peserta['provUmum']['nmCabang']; ?></td>
		
		<td></td>
		<td></td>
		<td></td>
	</tr>
	<tr>
		<td style="font-weight: bold;">Kode Kelas Tanggungan</td>
		<td style="font-weight: bold;text-align:center;">:</td>
		<td id="kdKelas"><?php echo $peserta['kelasTanggungan']['kdKelas']; ?></td>
		
		<td></td>
		<td></td>
		<td></td>
	</tr>
	<tr>
		<td style="font-weight: bold;">Kelas Tanggungan</td>
		<td style="font-weight: bold;text-align:center;">:</td>
		<td id="nmKelas"><?php echo $peserta['kelasTanggungan']['nmKelas']; ?>	</td>
		
		<td></td>
		<td></td>
		<td></td>
	</tr>
	<tr>
		<td style="font-weight: bold;">Kode Jenis Peserta</td>
		<td style="font-weight: bold;text-align:center;">:</td>
		<td id="kdJenisPeserta"><?php echo $peserta['jenisPeserta']['kdJenisPeserta']; ?></td>
		
		<td></td>
		<td></td>
		<td></td>
	</tr>
	<tr>
		<td style="font-weight: bold;">Jenis Peserta</td>
		<td style="font-weight: bold;text-align:center;">:</td>
		<td id="nmJenisPeserta"><?php echo $peserta['jenisPeserta']['nmJenisPeserta']; ?></td>
		
		<td></td>
		<td></td>
		<td></td>
	</tr>
</table>
<?php endif; ?>