<style>
    .table {
        box-shadow: none;
        border: 1px solid black;
        border-collapse: collapse;
    }
    
    .table th, .table td {
        border: 1px solid black;
    }
</style>


<?php 
if($caraPrint=='EXCEL')
{
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="'.$judulLaporan.'-'.date("Y/m/d").'.xls"');
    header('Cache-Control: max-age=0');     
}
echo $this->renderPartial('application.views.headerReport.headerDefault',array('judulLaporan'=>$judulLaporan, 'colspan'=>10)); 


 $style = 'margin-left:auto; margin-right:auto;';
    if (isset($caraPrint)){
        if ($caraPrint == "EXCEL")
            $style = "cellpadding='10',cellspasing='6', width='100%'";
//            $td = "width='100%'";
    } else{
        $style = "style='margin-left:auto; margin-right:auto;'";
//        $td ='';
    }
    // var_dump($modReseptur->attributes); die;
?>

<table width="100%" <?php echo $style; ?>>
    <tr>
        <td>No. Rekam Medik</td><td>:</td><td><?php echo CHtml::encode($modPendaftaran->pasien->no_rekam_medik); ?></td>
        <td>No. Pendaftaran</td><td>:</td><td><?php echo CHtml::encode($modPendaftaran->no_pendaftaran); ?></td>
    </tr>
    <tr>
        <td>Nama Pasien</td><td>:</td><td><?php echo CHtml::encode($modPendaftaran->pasien->namadepan.$modPendaftaran->pasien->nama_pasien); ?></td>
        <td>Tgl. Pendaftaran</td><td>:</td><td><?php echo CHtml::encode(MyFormatter::formatDateTimeForUser($modPendaftaran->tgl_pendaftaran)); ?></td>
    </tr>
    <tr>
        <td>Jenis Kelamin</td><td>:</td><td><?php echo CHtml::encode($modPendaftaran->pasien->jeniskelamin); ?></td>
        <td>No. Reseptur</td><td>:</td><td><?php echo CHtml::encode($modReseptur->noresep); ?></td>
    </tr>
    <tr>
        <td>Umur</td><td>:</td><td><?php echo CHtml::encode($modPendaftaran->umur); ?></td>
        <td>Tgl. Reseptur</td><td>:</td><td><?php echo CHtml::encode(MyFormatter::formatDateTimeForUser($modReseptur->tglreseptur)); ?></td>
    </tr>
    <tr>
        <td>Cara Bayar / Penjamin</td><td>:</td><td><?php echo CHtml::encode($modPendaftaran->carabayar->carabayar_nama); ?> / <?php echo CHtml::encode($modPendaftaran->penjamin->penjamin_nama); ?></td>
        <td>Dokter</td><td>:</td><td><?php echo CHtml::encode($modPendaftaran->pegawai->namaLengkap); ?></td>
    </tr>
       
</table>
<br/>
<table id="tblDaftarResep" class="table" border="2">
    <thead>
        <tr>
            <th>Nama Obat</th>
            <!--th>Satuan</th-->
            <th>Estimasi Harga Satuan</th>
            <th>Jumlah</th>
            <th>Sub Total</th>
<!--            <th>&nbsp;</th>-->
        </tr>
    </thead>
    
    <?php //echo print_r($modReseptur); 
//    exit(); ?>
    <?php // foreach ($modReseptur as $i => $reseptur) { ?>
    <?php //   $details = ResepturdetailT::model()->findAllByAttributes(array('reseptur_id'=>$reseptur->reseptur_id));
        foreach ($modDetailResep as $detail) { ?>
    <tr>
        <td><?php echo $detail->obatalkes->obatalkes_nama ?></td>
        <!--td><?php //echo $detail->satuankecil->satuankecil_nama ?></td-->
        <td style="text-align: right"><?php echo MyFormatter::formatNumberForPrint($detail->hargasatuan_reseptur) ?></td>
        <td style="text-align: right"><?php echo $detail->qty_reseptur." ".$detail->satuankecil->satuankecil_nama ?></td>
        <td style="text-align: right"><?php echo MyFormatter::formatNumberForPrint($detail->qty_reseptur * $detail->hargasatuan_reseptur) ?></td>
    </tr>
    <?php } ?>
</table>
<br/>
<table align="RIGHT">
    <tr>
        <td>
<div align="CENTER">
     Dokter Pemeriksa
    <br/><br/><br/><br/>
   ( <?php echo CHtml::encode($modPendaftaran->pegawai->namaLengkap); ?> )
</div>
        </td>
        
    </tr>
</table>
<table align="LEFT">
    <tr>
        <td>
<div align="CENTER">
</div>
        </td>
        
    </tr>
    
</table>