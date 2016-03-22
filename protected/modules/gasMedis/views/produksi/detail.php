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
    padding-left: 5px;
    padding-right: 5px;
    
}

.heads th + th, .heads td + td
{
    padding-left: 5px;
    padding-right: 5px;
    
}
.note {
    border: 1px solid black;
    padding: 3px;
}
</style>
<?php
$format = new MyFormatter;

if (isset($print)){
    if($print == 2)
    {
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="Produksi Gas Medis - '.date("Y/m/d").'.xls"');
        header('Cache-Control: max-age=0');     
    }
}
?>
<?php $this->renderPartial('application.views/headerReport/headerDefault',array('colspan'=>10)); ?>
<div style="font-weight: bold; text-align: center; width:100%;">
        Produksi Gas Medis
</div>
<table width="100%" style="margin:0px; margin-bottom: 10px;" cellpadding="0" cellspacing="0" class="heads">
    <tr>
        <td>No. Produksi</td>
        <td>:</td>
        <td width="100%"><?php echo $model->no_produksi; ?></td>
        <td>Petugas Gas Medis</td>
        <td>:</td>
        <td nowrap><?php echo (isset($model->petugasgasmedis_id) ? $model->petugas->nama_pegawai : ""); ?></td>
    </tr>
    <tr>
        <td nowrap>Tanggal Produksi</td>
        <td>:</td>
        <td><?php echo $format->formatDateTimeForUser($model->tgl_produksi); ?></td>
        <td nowrap>Pegawai Mengetahui</td>
        <td>:</td>
        <td nowrap><?php echo (isset($model->mengetahui_id) ? $model->mengetahui->nama_pegawai : ""); ?></td>
    </tr>
</table>

<table width="100%" style='margin-left:auto; margin-right:auto; margin-bottom: 5px;' class = "tabel">
    <thead class="border">
        <tr>
            <th>No.</th>
            <th nowrap>Mulai Produksi</th>
            <th nowrap>Selesai Produksi</th>
            <th>Gas Medis</th>
            <th>Kapasitas</th>
            <th>Qty</th>
        </tr>
    </thead>
    <?php 
    $total = 0;
    $subtotal = 0;
    foreach ($det as $i=>$detail){ 
    ?>
        <tr>
            <td style="text-align: right;"><?php echo ($i+1)."."; ?></td>
            <td style="text-align: right;" nowrap><?php echo $detail->waktu_awal; ?></td>
            <td style="text-align: right;" nowrap><?php echo $detail->waktu_selesai; ?></td>
            <td width="100%"><?php echo $detail->obatalkes->obatalkes_nama; ?></td>
            <td style="text-align: right;" nowrap><?php echo $detail->kapasitas." ".$detail->obatalkes->satuankekuatan; ?></td>
            <td style="text-align: right;" nowrap><?php echo $detail->qty_gasmedis.' '.$detail->satuankecil->satuankecil_nama; ?></td>
        </tr>
    <?php } ?>
</table>
<div class="note">
    <?php echo "<b>Keterangan :</b> <br/>".$model->keterangan; ?>
</div>
<?php
if (empty($print)){
    echo CHtml::link(Yii::t('mds', '{icon} Print', array('{icon}'=>'<i class="icon-print icon-white"></i>')), 'javascript:void(0);', array('class'=>'btn btn-info', 'onclick'=>"print(1)"))." ";
    echo CHtml::link(Yii::t('mds','{icon} Excel',array('{icon}'=>'<i class="icon-pdf icon-white"></i>')),'javascript:void(0);', array('class'=>'btn btn-info', 'onclick'=>"print(2)")); 
?>
    <script type='text/javascript'>
    /**
     * print
     */    
    function print(caraprint){
        var id = '<?php echo $model->produksigasmedis_id; ?>';
        window.open('<?php echo $this->createUrl('detail'); ?>&id='+id+'&print=' + caraprint,'printwin','left=100,top=100,width=1000,height=640');
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
                        <div>Mengetahui</div>
                        <div style="margin-top:60px;"><?php echo (!empty($model->mengetahui_id) ? $model->mengetahui->nama_pegawai : ""); ?></div>
                    </td>
                    <td width="35%" align="center">
                        <div><?php echo Yii::app()->user->getState("kecamatan_nama").", ".$format->formatDateTimeId(date('Y-m-d')); ?></div>
                        <div>Petugas</div>
                        <div style="margin-top:60px;"><?php echo (isset($model->petugasgasmedis_id) ? $model->petugas->nama_pegawai : ""); ?></div>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    </table>
<?php } ?>
