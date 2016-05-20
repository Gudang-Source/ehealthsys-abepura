<style>
.tabel
{
 border:1px solid #000;
}
thead th 
{
    background: #fff;    
    border-bottom:1px solid #000;
    color: #000;
}
    
body{
    font-size:8pt;
}
td.uang{
    text-align:right;
}
th{
    text-align:center;
}
.border{
    border:1px solid;
}

.tabel th + th, .tabel td + td
{
    border-left: 1px solid #000;
    
}
</style>
<?php
if (isset($caraprint)){
    if($caraprint=='EXCEL')
    {
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'.$judul_print.'-'.date("Y/m/d").'.xls"');
        header('Cache-Control: max-age=0');     
    }
}
?> 
<?php $this->renderPartial($this->path_view.'_headerPrint',array('colspan'=>10)); ?>
    <div align="center" width="100%">
        <b><?php echo $judul_print ?></b>
    </div>
    <table width="74%" style="margin:0px;" cellpadding="0" cellspacing="0">
        <tr>
            <td>No. Terima Mutasi</td>
            <td>:</td>
            <td><?php echo $model->noterimamutasi; ?></td>
        </tr>
        <tr>
            <td>Tanggal Terima Mutasi</td>
            <td>:</td>
            <td><?php echo $format->formatDateTimeForUser($model->tglterima); ?></td>
        </tr>
        <tr>
            <td>Ruangan Asal</td>
            <td>:</td>
            <td><?php echo (isset($model->ruanganasal->ruangan_nama) ? $model->ruanganasal->ruangan_nama : "-"); ?></td>
        </tr>
        <tr>
            <td>Ruangan Penerima</td>
            <td>:</td>
            <td><?php echo (isset($model->ruanganpenerima->ruangan_nama) ? $model->ruanganpenerima->ruangan_nama : ""); ?></td>
        </tr>
        <tr>
            <td>Pegawai Mengetahui</td>
            <td>:</td>
            <td><?php echo (isset($model->pegawaimengetahui->NamaLengkap) ? $model->pegawaimengetahui->NamaLengkap : ""); ?></td>
        </tr>
    </table><br/>
    <table width="100%" style='margin-left:auto; margin-right:auto;' class = 'tabel'>
        <thead class="border">
            <tr>
                <th>No.</th>
                <th>Asal Barang</th>
                <th>Kategori / Nama Obat</th>
                <th>Tanggal Kadaluarsa </th>
                <!--<th>Satuan Kecil </th>-->
                <th>Jumlah Mutasi</th>
                <th>Jumlah Terima</th>
                <th>HPP</th>
                <!--<th>Harga Jual</th>-->
                <th>Sub Total Netto</th>
            </tr>
        </thead>
        <?php 
        $total = 0;
        $subtotal = 0;
        foreach ($modDetails as $i=>$detail){ 
        ?>
            <tr>
                <td><?php echo ($i+1)."."; ?></td>
                <td><?php echo $detail->sumberdana->sumberdana_nama; ?></td>
                <td><?php echo (!empty($detail->obatalkes->obatalkes_kategori) ? $detail->obatalkes->obatalkes_kategori."/ " : "") ."". $detail->obatalkes->obatalkes_nama; ?></td>
                <td><?php echo $format->formatDateTimeForUser($detail->tglkadaluarsa); ?></td>
                <!--<td><?php //echo $detail->satuankecil->satuankecil_nama; ?></td>-->
                <td><?php echo $detail->jmlmutasi.' '.$detail->satuankecil->satuankecil_nama; ?></td>
                <td><?php echo $detail->jmlterima.' '.$detail->satuankecil->satuankecil_nama; ?></td>
                <td class='uang'><?php echo "Rp".number_format($detail->harganettoterima,0,'','.'); ?></td>
                <!--<td><?php // echo $format->formatUang($detail->hargajualterima); ?></td>-->
                <td class="uang"><?php 
                    $subtotal = ($detail->harganettoterima * $detail->jmlterima);
                    $total += $subtotal;
                    echo "Rp".number_format($subtotal,0,'','.'); ?>
                </td>
            </tr>
        <?php } ?>
        <tr class='border'>
            <td colspan="7" style="text-align:right"><strong>Total</strong></td>
            <td class="uang"><?php echo "Rp".number_format($total,0,'','.'); ?></td>
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
    function print(caraprint){
        var terimamutasi_id = '<?php echo $model->terimamutasi_id; ?>';
        window.open('<?php echo $this->createUrl('printTerimaMutasi'); ?>&terimamutasi_id='+terimamutasi_id+'&caraprint='+caraprint,'printwin','left=100,top=100,width=1000,height=640');
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
                        <div style="margin-top:60px;"><?php echo (isset($model->pegawaimengetahui->NamaLengkap) ? $model->pegawaimengetahui->NamaLengkap : ""); ?></div>
                    </td>
                    <td width="35%" align="center">
                        <div><?php echo Yii::app()->user->getState("kabupaten_nama").", ".$format->formatDateTimeId(date('Y-m-d')); ?></div>
                        <div>Pegawai Penerima</div>
                        <div style="margin-top:60px;"><?php echo (isset($model->pegawaipenerima->NamaLengkap) ? $model->pegawaipenerima->NamaLengkap : ""); ?></div>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    </table>
<?php } ?>
