<?php 
if($caraPrint=='EXCEL')
    {
        header('Content-Type: application/vnd.ms-excel');
          header('Content-Disposition: attachment;filename="'.$judulLaporan.'-'.date("Y/m/d").'.xls"');
          header('Cache-Control: max-age=0');     
    }
    echo $this->renderPartial('application.views.headerReport.headerDefault',array('judulLaporan'=>$judulLaporan));  
?>
<br><br>
<table width="100%" border="0">
	<tr>
		<td colspan="4" style="border-bottom: #000 solid 2px"><td>
	</tr>
	<tr>
		<td width="15%"><strong>NIP</strong></td>
		<td width="35%">: &nbsp; <?php echo $modelpegawai->nomorindukpegawai; ?></td>
		<td width="15%"><strong>No. Rekening</strong></td>
		<td width="35%">: &nbsp; <?php echo $modelpegawai->no_rekening; ?> / <?php echo $modelpegawai->bank_no_rekening; ?></td>
	</tr>
	<tr>
		<td width="15%"><strong>Nama Pegawai</strong></td>
		<td width="35%">: &nbsp; <?php echo $modelpegawai->nama_pegawai; ?></td>
		<td width="15%"><strong>Npwp</strong></td>
		<td width="35%">: &nbsp; <?php echo $modelpegawai->npwp; ?></td>
	</tr>
	<tr>
		<td width="15%"><strong>Tempat Lahir</strong></td>
		<td width="35%">: &nbsp; <?php echo $modelpegawai->tempatlahir_pegawai; ?></td>
		<td width="15%"><strong>No Telepon</strong></td>
		<td width="35%">: &nbsp; <?php echo $modelpegawai->notelp_pegawai; ?> / <?php echo $modelpegawai->nomobile_pegawai; ?></td>
	</tr>
	<tr>
		<td width="15%"><strong>Tanggal Lahir</strong></td>
		<td width="35%">: &nbsp; <?php echo MyFormatter::formatDateTimeId($modelpegawai->tgl_lahirpegawai); ?></td>
		<td width="15%"><strong>Agama</strong></td>
		<td width="35%">: &nbsp; <?php echo $modelpegawai->agama; ?></td>
	</tr>
	<tr>
		<td width="15%"><strong>Jabatan</strong></td>
		<td width="35%">: &nbsp; <?php echo isset($modelpegawai->jabatan_id)?$modelpegawai->jabatan->jabatan_nama:'-'; ?></td>
		<td width="15%"><strong>Alamat</strong></td>
		<td width="35%">: &nbsp; <?php echo $modelpegawai->alamat_pegawai; ?></td>
	</tr>
	<tr>
		<td colspan="4" style="border-bottom: #000 solid 2px"><td>
	</tr>
</table>
<br><br>
<table width="100%" border="0">
	<tr>
		<td width="15%"></td>
		<td width="10%"><strong>Total Terima</strong></td>
		<td width="25%">: &nbsp; <?php echo 'Rp'.  number_format($model->totalterima,0,"","."); ?></td>
		<td width="10%"><strong>Tanggal Penggajian</strong></td>
		<td width="25%">: &nbsp; <?php echo MyFormatter::formatDateTimeId($model->tglpenggajian); ?></td>
		
		<td width="15%"></td>
	</tr>
	<tr>
		<td width="15%"></td>
		<td width="10%"><strong>Total Potongan</strong></td>
                <td width="25%">: &nbsp; <?php echo 'Rp'.  number_format($model->totalpotongan,0,"","."); ?></td>
		<td width="10%"><strong>No. Penggajian</strong></td>
		<td width="25%">: &nbsp; <?php echo $model->nopenggajian; ?></td>
		<td width="15%"></td>
	</tr>
	<tr>
		<td width="15%"></td>
		<td width="10%"><strong>Total Pajak</strong></td>
		<td width="25%">: &nbsp; <?php echo 'Rp'.  number_format($model->totalpajak,0,"","."); ?></td>
		<td width="10%"><strong>Keterangan</strong></td>
		<td width="25%">: &nbsp; <?php echo $model->keterangan; ?></td>
		<td width="15%"></td>
	</tr>
	<tr>
		<td width="15%"></td>
		<td width="10%"><strong>Penerimaan Bersih</strong></td>
		<td width="25%">: &nbsp; <?php echo 'Rp'.  number_format($model->penerimaanbersih,0,"","."); ?></td>
		<td width="10%"><strong></strong></td>
		<td width="25%"></td>
		<td width="15%"></td>
	</tr>
</table>
<br><br>
<table width="100%" border="1">
    <tr>
		<td colspan="4" style="border-bottom: #000 solid 2px"><td>
	</tr>
</table>
<br><br>
<table style="width:100%;">
    <tr>
        <td width="50%" style="text-align: center;">Mengetahui,</td>
        <td width="50%" style="text-align: center;">Menyetujui,</td>
    </tr>
    <tr><td>&nbsp;</td><td></td></tr>
    <tr><td>&nbsp;</td><td></td></tr>
    <tr><td>&nbsp;</td><td></td></tr>
	<tr>
        <td width="50%" style="text-align: center;"><b>(<?php echo $model->mengetahui; ?>)</b></td>
        <td width="50%" style="text-align: center;"><b>(<?php echo $model->menyetujui; ?>)</b></td>
    </tr>
</table>