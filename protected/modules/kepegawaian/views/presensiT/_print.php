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
if(!$model){
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
            <td>No. Finger Print</td>
            <td>:</td>
            <td><?php echo $modPegawai->nofingerprint; ?></td>
            
            <td>NIP</td>
            <td>:</td>
            <td><?php echo $modPegawai->nomorindukpegawai; ?></td>
        </tr>
        <tr>
            <td>Nama Pegawai</td>
            <td>:</td>
            <td><?php echo $modPegawai->NamaLengkap; ?></td>
            
            <td>Jabatan</td>
            <td>:</td>
            <td><?php echo isset($modPegawai->jabatan->jabatan_nama) ? $modPegawai->jabatan->jabatan_nama : ""; ?></td>
        </tr>
        <tr>
            <td>Tempat Lahir</td>
            <td>:</td>
            <td><?php echo $modPegawai->tempatlahir_pegawai; ?></td>
            
            <td>Tanggal Lahir</td>
            <td>:</td>
            <td><?php echo $format->formatDateTimeForUser($modPegawai->tgl_lahirpegawai); ?></td>
        </tr>
    </table><br/>
    <table width="100%" style='margin-left:auto; margin-right:auto;'>
        <thead class="border">            
            <th style="text-align: center;">Tanggal Presensi</th>
            <th style="text-align: center;">Status Kehadiran</th>
            <th style="text-align: center;">Jam Kerja Masuk</th>
            <th style="text-align: center;">Jam Kerja Keluar</th>
            <th style="text-align: center;">Terlambat Menit</th>
            <th style="text-align: center;">Pulang Awal Menit</th>
            <th style="text-align: center;">Keterangan</th>  
        </thead>
        <tr>
            <td align="center"><?php echo MyFormatter::formatDateTimeForUser($model->tglpresensi); ?></td>
            <td align="center"><?php echo $model->statuskehadiran->statuskehadiran_nama."-".$model->statusscan->statusscan_nama; ?></td>
            <td align="center"><?php echo $model->jamkerjamasuk; ?></td>
            <td align="center"><?php echo $model->jamkerjapulang; ?></td>
            <td align="center"><?php echo $model->terlambat_mnt; ?></td>
            <td align="center"><?php echo $model->pulangawal_mnt; ?></td>
            <td align="center"><?php echo $model->keterangan; ?></td>
        </tr>
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
    function print(caraPrint){
        presensi_id = '<?php echo isset($model->presensi_id) ? $model->presensi_id : ''; ?>';
        window.open('<?php echo $this->createUrl('print'); ?>&presensi_id='+presensi_id+'&caraPrint='+caraPrint,'printwin','left=100,top=100,width=1000,height=640');
    }
    </script>
<?php
}else{ ?>
    <table width="100%" style="margin-top:20px;">
    <tr>
        <td></td>
        <td></td>
        <td width="30%" align="center" align="top">
            <div><?php echo Yii::app()->user->getState("kabupaten_nama").", ".MyFormatter::formatDateTimeId(date('Y-m-d')); ?></div>
            <div>Operator</div>
            <div style="margin-top:60px;"><?php echo Yii::app()->user->getState('nama_pegawai'); ?></div>
        </td>
    </tr>
    </table>
<?php } ?>
