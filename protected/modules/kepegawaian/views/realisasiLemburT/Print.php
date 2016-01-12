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
echo CHtml::css('.control-label{
        float:left; 
        text-align: right; 
        width:50%;
        color:black;
        padding-right:10px;
        font-size:8pt;
    }
    body{
        font-size:8pt;
    }
    td .uang{
        text-align:right;
    }
    .border{
        border:1px solid;
    }
');
?>  
<?php
if(!$modRealisasiLemburDetail){
    echo "Data tidak ditemukan"; exit;
}
$format = new MyFormatter;
if (!isset($_GET['frame'])){
    echo $this->renderPartial('_headerPrint'); 
}
?>
<table width="74%" style="margin:0px;" cellpadding="0" cellspacing="0">
    <tr>
        <td align="center" valig="middle" colspan="3">
            <b><?php echo $judul_print ?></b>
        </td>
    </tr>
    <tr>
        <td>No. Realisasi</td>
        <td>:</td>
        <td><?php echo $modRealisasiLembur->norealisasi; ?></td>
    </tr>
    <tr>
        <td>Tanggal Realisasi</td>
        <td>:</td>
        <td><?php echo $format->formatDateTimeForUser($modRealisasiLembur->tglrealisasi); ?></td>
    </tr>
    <?php if(!empty($modRealisasiLembur->rencanalembur_id)){ ?>
    <tr>
        <td>No. Rencana</td>
        <td>:</td>
        <td><?php echo $modRealisasiLembur->rencanalembur->norencana; ?></td>
    </tr>
    <tr>
        <td>Tanggal Rencana</td>
        <td>:</td>
        <td><?php echo $format->formatDateTimeForUser($modRealisasiLembur->rencanalembur->tglrencana); ?></td>
    </tr>
    <?php } ?>
    <tr>
        <td>Pegawai Mengetahui</td>
        <td>:</td>
        <td><?php echo (isset($modRealisasiLembur->pegawaimengetahui->NamaLengkap) ? $modRealisasiLembur->pegawaimengetahui->NamaLengkap : ""); ?></td>
    </tr>
    <tr>
        <td>Pegawai Menyetujui</td>
        <td>:</td>
        <td><?php echo (isset($modRealisasiLembur->pegawaimenyetujui->NamaLengkap) ? $modRealisasiLembur->pegawaimenyetujui->NamaLengkap : ""); ?></td>
    </tr>
    <tr>
        <td>Keterangan</td>
        <td>:</td>
        <td><?php echo $modRealisasiLembur->keterangan; ?></td>
    </tr>
</table><br/>
<table width="100%" style='margin-left:auto; margin-right:auto;'>
    <thead class="border">
        <tr>
            <th style="text-align: center;">No.</th>
            <th style="text-align: center;">No. Induk Pegawai</th>
            <th style="text-align: center;">Nama Pegawai</th>
            <th style="text-align: center;">Jam Mulai</th>
            <th style="text-align: center;">Jam Selesai</th>
            <th style="text-align: center;">Alasan Lembur</th>
        </tr>
    </thead>
    <?php 
    $total = 0;
    $subtotal = 0;
    foreach ($modRealisasiLemburDetail as $i=>$detail){ 
        if($detail->tglmulai != null){
            $detail->jamMulai = date('H:i',strtotime($detail->tglmulai));
        }
        if($detail->tglselesai != null){
            $detail->jamSelesai = date('H:i',strtotime($detail->tglselesai));
        }
    ?>
        <tr>
            <td><?php echo ($i+1)."."; ?></td>
            <td><?php echo $detail->pegawai->nomorindukpegawai; ?></td>
            <td><?php echo $detail->pegawai->nama_pegawai; ?></td>
            <td><?php echo $detail->jamMulai; ?></td>
            <td><?php echo $detail->jamSelesai; ?></td>
            <td><?php echo $detail->alasanlembur; ?></td>
        </tr>
    <?php } ?>
</table>
<?php
if (isset($_GET['frame'])){
    echo CHtml::link(Yii::t('mds', '{icon} Print', array('{icon}'=>'<i class="icon-print icon-white"></i>')), 'javascript:void(0);', array('class'=>'btn btn-info', 'onclick'=>"print('PRINT')"));
    echo CHtml::link(Yii::t('mds','{icon} Excel',array('{icon}'=>'<i class="icon-pdf icon-white"></i>')),'javascript:void(0);', array('class'=>'btn btn-info', 'onclick'=>"print('EXCEL')")); 
?>
    <script type='text/javascript'>
    /**
     * print
     */    
    function print(caraPrint)
    {
        var no_rencana = '<?php echo isset($_GET['no_rencana']) ? $_GET['no_rencana'] : null; ?>';
        window.open('<?php echo $this->createUrl('print'); ?>&no_rencana='+no_rencana+'&caraPrint='+caraPrint,'printwin','left=100,top=100,width=640,height=480');
    }
    </script>
<?php
}else{ ?>
    <table width="100%" style="margin-top:20px;">
    <tr>
        <td width="100%" align="left" align="top">
            <table width="100%">
                <tr>
                    <td width="35%" align="center">
                        <div>Pegawai Mengetahui</div>
                        <div style="margin-top:60px;"><br/><br/><br/><?php echo isset($modRealisasiLembur->pegawaimengetahui->NamaLengkap) ? $modRealisasiLembur->pegawaimengetahui->NamaLengkap : "" ?></div>
                    </td>
                    <td width="35%" align="center">
                        <div><?php echo Yii::app()->user->getState("kabupaten_nama").", ".MyFormatter::formatDateTimeId(date('Y-m-d')); ?></div>
                        <div>Pegawai Menyetujui</div>
                        <div style="margin-top:60px;"><br/><br/><br/><?php echo isset($modRealisasiLembur->pegawaimenyetujui->NamaLengkap) ? $modRealisasiLembur->pegawaimenyetujui->NamaLengkap : "" ?></div>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    </table>
<?php } ?>
