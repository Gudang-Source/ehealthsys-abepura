<?php
if (isset($caraPrint)){
    if($caraPrint=='EXCEL')
        {
             header('Content-Type: application/vnd.ms-excel');
              header('Content-Disposition: attachment;filename="'.$judulLaporan.'-'.date("Y/m/d").'.xls"');
              header('Cache-Control: max-age=0');     
        }
    echo $this->renderPartial('application.views.headerReport.headerDefault',array('judulLaporan'=>$judulLaporan));     
}
?>
<style>
    .barcode-label{
        margin-top:-20px;
        z-index: 1;
        text-align: center;
        letter-spacing: 10px;
    }
    td, th{
        font-size: 8pt !important;
        height: 24px;
        padding-left:10px;
    }
    body{
        width: 14.7cm;
    }
    .content td{
        height: 48px;
    }
</style>
<table width="60%" border="1">
    <tr>
        <td style="width:15%">Nama Pasien / No. RM</td>
        <td style="width:15%">: <?php echo $modPasien->nama_pasien; ?> / <?php echo $modPasien->no_rekam_medik; ?></td>
        <td style="width:15%">No. Pendaftaran</td>
        <td style="width:15%">: <?php echo $modPendaftaran->no_pendaftaran; ?></td>
    </tr>
</table>
<table width="100%" border="1" class="content">
<?php 
if (COUNT($modKesimpulanSaran)>0){
foreach ($modKesimpulanSaran as $i => $loop){
?>
    <tr>
        <td>&nbsp;</td>
        <td align="center" valign="middle" colspan="6" style="font-weight:bold">
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            KESIMPULAN DAN SARAN</td>
    </tr>
    <tr>
        <td style="width:20%">Nama Dokter</td>
        <td style="width:25%">: <?php echo (isset($modPendaftaran->pegawai_id) ? $modPendaftaran->pegawai->NamaLengkap :"-"); ?></td>
        <td style="width:20%">Tanggal Kesimpulan dan Saran</td>
        <td style="width:30%">: <?php echo (isset($loop->tgl_kesimpulanmcu) ? MyFormatter::formatDateTimeForUser($loop->tgl_kesimpulanmcu) :"-"); ?></td>
    </tr>
    <tr>
        <td style="width:20%">Kesimpulan 1</td>
        <td style="width:30%">: <?php echo isset($loop->kesimpulan1_desc)?$loop->kesimpulan1_desc:" - "; ?></td>
        <td style="width:15%">Saran 1</td>
        <td style="width:35%">: <?php echo ($loop->saran1_status == true)?$loop->saran1_desc:" - "; ?></td>
    </tr>
    <tr>
        <td style="width:15%">Kesimpulan 2</td>
        <td style="width:30%">: <?php echo isset($loop->kesimpulan2_desc)?$loop->kesimpulan2_desc:" - "; ?></td>
        <td style="width:15%">Saran 2</td>
        <td style="width:35%">: <?php echo ($loop->saran2_status == true)?$loop->saran2_desc:" - "; ?></td>
    </tr>
    <tr>
        <td style="width:15%">Kesimpulan 3</td>
        <td style="width:30%">: <?php echo isset($loop->kesimpulan3_desc)?$loop->kesimpulan3_desc:" - "; ?></td>
        <td style="width:15%">Saran 3</td>
        <td style="width:35%">: <?php echo ($loop->saran3_status == true)?$loop->saran3_desc:" - "; ?></td>
    </tr>
    <tr>
        <td style="width:15%">Kesimpulan Perorang</td>
        <td style="width:30%">: <?php echo isset($loop->kesimpulanperorang)?$loop->kesimpulanperorang:" - "; ?></td>
        <td style="width:15%">Saran Perorang</td>
        <td style="width:35%">: <?php echo isset($loop->saranperorang)?$loop->saranperorang:" - "; ?></td>
    </tr>
    <tr>
        <td style="width:15%">Nama Pemeriksa</td>
        <td style="width:30%">: <?php echo isset($loop->nama_pemeriksa_kes)?$loop->nama_pemeriksa_kes:" - "; ?></td>
        <td style="width:15%"></td>
        <td style="width:35%"></td>
    </tr>
    <tr><td colspan="6"><hr></td></tr>
<?php }
}else{
?>
    <tr>
        <td colspan="6">* Tidak ada Kesimpulan dan Saran</td>
    </tr> 
<?php } ?>
</table> 