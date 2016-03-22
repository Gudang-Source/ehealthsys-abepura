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
        <td nowrap><?php echo (isset($model->petugas->nama_pegawai) ? $model->petugas->nama_pegawai : ""); ?></td>
    </tr>
    <tr>
        <td nowrap>Tanggal Produksi</td>
        <td>:</td>
        <td><?php echo $format->formatDateTimeForUser($model->tgl_produksi); ?></td>
        <td nowrap>Pegawai Mengetahui</td>
        <td>:</td>
        <td nowrap><?php echo (isset($model->mengetahui->nama_pegawai) ? $model->mengetahui->nama_pegawai : ""); ?></td>
    </tr>
</table>

<table width="100%" style='margin-left:auto; margin-right:auto; margin-bottom: 20px;' class = "tabel">
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
<?php /*
<?php $this->renderPartial($this->path_view.'_headerPrint',array('colspan'=>10)); ?>
    <div align="center" width="100%">
        <b><?php echo $judul_print ?></b>
    </div>
    <table width="74%" style="margin:0px;" cellpadding="0" cellspacing="0">
        <tr>
            <td>No. Mutasi</td>
            <td>:</td>
            <td><?php echo $model->nomutasioa; ?></td>
        </tr>
        <tr>
            <td>Tanggal Mutasi</td>
            <td>:</td>
            <td><?php echo $format->formatDateTimeForUser($model->tglmutasioa); ?></td>
        </tr>
        <tr>
            <td>Ruangan Asal</td>
            <td>:</td>
            <td><?php echo (isset($model->ruanganasal->ruangan_nama) ? $model->ruanganasal->ruangan_nama : "-"); ?></td>
        </tr>
        <tr>
            <td>Ruangan Tujuan</td>
            <td>:</td>
            <td><?php echo (isset($model->ruangantujuan->ruangan_nama) ? $model->ruangantujuan->ruangan_nama : ""); ?></td>
        </tr>
        <tr>
            <td>Pegawai Mengetahui</td>
            <td>:</td>
            <td><?php echo (isset($model->pegawaimengetahui->NamaLengkap) ? $model->pegawaimengetahui->NamaLengkap : ""); ?></td>
        </tr>
        <tr>
            <td>Status Mutasi</td>
            <td>:</td>
            <td><?php echo ((!empty($model->terimamutasi_id) ? "SUDAH DITERIMA" : "BELUM DITERIMA")); ?></td>
        </tr>
    </table><br/>
    <table width="100%" style='margin-left:auto; margin-right:auto;' class = "tabel">
        <thead class="border">
            <tr>
                <th>No.</th>
                <th>Asal Barang</th>
                <th>Kategori / Nama Obat</th>
                <th>Tanggal Kadaluarsa </th>
                <!--<th>Satuan Kecil </th>-->
                <?php
                   $periksa = MutasioaruanganT::model()->findByAttributes(array('mutasioaruangan_id'=>$model->mutasioaruangan_id));                
                   
                   if ($periksa->pesanobatalkes_id == ''):
                       echo "";
                   else:
                       echo "<th>Jumlah Pesan</th>";
                   endif;
                ?> 
                <!--<th>Jumlah Pesan</th>-->
                <th>Jumlah Mutasi</th>
                <!--<th>HPP</th>-->
                <!--<th>Harga Jual</th>-->
                <!--<th>Sub Total Netto</th>-->
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
                <?php
                if ($periksa->pesanobatalkes_id == ''):
                       echo "";
                   else:
                       echo "<td style = 'text-align:right;'> ".$detail->jmlpesan." ".$detail->satuankecil->satuankecil_nama."</th>";;
                   endif;
                ?>
               <!-- <td><?php //echo $detail->jmlpesan.' '.$detail->satuankecil->satuankecil_nama; ?></td>-->
                <td><?php echo $detail->jmlmutasi.' '.$detail->satuankecil->satuankecil_nama; ?></td>
                <!--<td class='uang'><?php // echo $format->formatUang($detail->harganetto); ?></td>-->
                <!--<td><?php // echo $format->formatUang($detail->hargajualsatuan); ?></td>-->
                <!--<td class="uang"><?php 
//                    $subtotal = ($detail->harganetto * $detail->jmlmutasi);
//                    $total += $subtotal;
//                    echo $format->formatUang($subtotal); ?>
                </td>-->
            </tr>
        <?php } ?>
<!--        <tr class='border'>
            <td colspan="7" align="right"><strong>Total</strong></td>
            <td class="uang"><?php // echo $format->formatUang($total); ?></td>
        </tr>-->
    </table>

      * 
      */ ?>
