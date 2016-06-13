<?php 
if($caraPrint=='EXCEL')
{
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="'.$judulLaporan.'-'.date("Y/m/d").'.xls"');
    header('Cache-Control: max-age=0');     
}
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
if (!isset($_GET['frame'])){
    echo $this->renderPartial($this->path_view.'_headerPrint'); 
}
?>
<table width="74%" style="margin:0px;" cellpadding="0" cellspacing="0">
    <tr>
        <td align="center" valig="middle" colspan="3">
            <b><?php echo $judulLaporan ?></b>
        </td>
    </tr>
    <tr>
        <td>No. Stock Opname</td>
        <td>:</td>
        <td><?php echo $model->nostokopname; ?></td>

        <td>Total Harga</td>
        <td>:</td>
        <td><?php echo $format->formatNumberForPrint($model->totalharga); ?></td>
    </tr>
    <tr>
        <td>Tanggal Stock Opname</td>
        <td>:</td>
        <td><?php echo $format->formatDateTimeForUser($model->tglstokopname); ?></td>

        <td>Total HPP</td>
        <td>:</td>
        <td><?php echo $format->formatNumberForPrint($model->totalnetto); ?></td>
    </tr>
    <?php if(isset($model->formuliropname_id)){ ?>
    <tr>
        <td>No. Formulir Opname</td>
        <td>:</td>
        <td><?php echo $model->formuliropname->noformulir; ?></td>

        <td>Total Volume</td>
        <td>:</td>
        <td><?php echo $format->formatNumberForPrint($model->formuliropname->totalvolume); ?></td>
    </tr>
    <tr>
        <td>Tanggal Formulir Opname</td>
        <td>:</td>
        <td><?php echo $format->formatDateTimeForUser($model->formuliropname->tglformulir); ?></td>

        <td>Total Harga</td>
        <td>:</td>
        <td><?php echo $format->formatNumberForPrint($model->totalharga); ?></td>
    </tr>
    <?php } ?>
    </table><br/>
<table class="table table-bordered table-condensed middle-center">
    <thead>
        <tr>
            <th>No.</th>
            <th>Jenis Obat Alkes</th>
            <th>Kategori</th>
            <th>Golongan</th>
            <th>Kode</th>
            <th>Nama Obat</th>
            <th>HPP (Rp)</th>
            <th>Harga Jual (Rp)</th>
            <th>Stok Sistem</th>
            <th>Stok Fisik</th>
            <th>Selisih</th>    
            <th>Tgl Periksa</th>
            <th>Kondisi Barang</th>
        </tr>
    </thead>
    <tbody>
        <?php
            foreach($modDetails as $i=>$obat){
        ?>
        <tr>
            <td><?php echo ($i+1); ?></td>
            <td><?php echo (isset($obat->obatalkes->jenisobatalkes->jenisobatalkes_nama) ? $obat->obatalkes->jenisobatalkes->jenisobatalkes_nama : ""); ?></td>
            <td><?php echo $obat->obatalkes->obatalkes_kategori; ?></td>
            <td><?php echo $obat->obatalkes->obatalkes_golongan; ?></td>
            <td><?php echo $obat->obatalkes->obatalkes_kode; ?></td>
            <td><?php echo $obat->obatalkes->obatalkes_nama; ?></td>
            <td style="text-align:right;"><?php echo $format->formatNumberForPrint($obat->harganetto); ?></td>
            <td style="text-align:right;"><?php echo $format->formatNumberForPrint($obat->hargasatuan); ?></td>
            <td style="text-align:right;"><?php echo $obat->volume_sistem." ".$obat->obatalkes->satuankecil->satuankecil_nama; ?></td>
            <td style="text-align:right;"><?php echo $obat->volume_fisik." ".$obat->obatalkes->satuankecil->satuankecil_nama; ?></td>
            <td style="text-align:right;"><?php echo $obat->jmlselisihstok." ".$obat->obatalkes->satuankecil->satuankecil_nama; ?></td>
            <td style="text-align:center;"><?php echo $format->formatDateTimeId($obat->tglperiksafisik); ?></td>
            <td><?php echo $obat->kondisibarang ?></td>
        </tr>
        <?php } ?>
    </tbody>
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
        stokopname_id = '<?php echo isset($model->stokopname_id) ? $model->stokopname_id : ''; ?>';
        window.open('<?php echo $this->createUrl('print'); ?>&stokopname_id='+stokopname_id+'&caraPrint='+caraPrint,'printwin','left=100,top=100,width=640,height=480');
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
                    <div>Petugas 2</div>
                    <div style="margin-top:60px;"><?php echo ($model->petugas2_id)?PegawaiM::model()->findByPk($model->petugas2_id)->NamaLengkap:""; ?></div>
                </td>
                <td width="35%" align="center">
                    <div>Petugas 1</div>
                    <div style="margin-top:60px;"><?php echo ($model->petugas1_id)?PegawaiM::model()->findByPk($model->petugas1_id)->NamaLengkap:""; ?></div>
                </td>
                <td width="35%" align="center">
                    <div><?php echo Yii::app()->user->getState("kabupaten_nama").", ".MyFormatter::formatDateTimeId(date('Y-m-d')); ?></div>
                    <div>Mengetahui</div>
                    <div style="margin-top:60px;"><?php echo ($model->mengetahui_id)?PegawaiM::model()->findByPk($model->mengetahui_id)->NamaLengkap:""; ?></div>
                </td>
            </tr>
        </table>
    </td>
</tr>
</table>
<?php } 