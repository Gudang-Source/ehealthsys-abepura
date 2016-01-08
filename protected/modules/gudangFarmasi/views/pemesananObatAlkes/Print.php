<?php 
$table = 'ext.bootstrap.widgets.BootGridView';
$template = "{pager}{summary}\n{items}";
if (isset($caraprint)){
    $template = "{items}";
}
if($caraprint == 'EXCEL')
{
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="'.$judul_print.'-'.date("Y/m/d").'.xls"');
    header('Cache-Control: max-age=0');   
    $table = 'ext.bootstrap.widgets.BootExcelGridView';
}
echo $this->renderPartial('application.views.headerReport.headerDefault',array('judulLaporan'=>$judul_print, 'colspan'=>''));      

?>
<fieldset>
    <table width="74%" style="margin:0px;" cellpadding="0" cellspacing="0">
        <tr>
            <td>No. Pemesanan</td>
            <td>:</td>
            <td><?php echo $model->nopemesanan; ?></td>
        </tr>
        <tr>
            <td>Tanggal Pemesanan</td>
            <td>:</td>
            <td><?php echo $model->tglpemesanan; ?></td>
        </tr>
        <tr>
            <td>Tanggal Pesanan Minta Dikirim</td>
            <td>:</td>
            <td><?php echo $model->tglpemesanan; ?></td>
        </tr>
        <tr>
            <td>Ruang Pemesan</td>
            <td>:</td>
            <td><?php echo $model->ruanganpemesan->ruangan_nama; ?></td>
        </tr>
        <tr>
            <td>Ruang Tujuan</td>
            <td>:</td>
            <td><?php echo $model->ruangantujuan->ruangan_nama; ?></td>
        </tr>
<!--        <tr>
            <td>Pegawai Mengetahui</td>
            <td>:</td>
            <td><?php // echo (isset($model->pegawaimengetahui->NamaLengkap) ? $model->pegawaimengetahui->NamaLengkap : ""); ?></td>
        </tr>
        <tr>
            <td>Pegawai Menyetujui</td>
            <td>:</td>
            <td><?php // echo (isset($model->pegawaipemesan->NamaLengkap) ? $model->pegawaipemesan->NamaLengkap : ""); ?></td>
        </tr>-->
        <tr>
            <td>Status Pesan</td>
            <td>:</td>
            <td><?php echo $model->statuspesan; ?></td>
        </tr>
        <tr>
            <td>Keterangan Pesan</td>
            <td>:</td>
            <td><?php echo $model->keterangan_pesan; ?></td>
        </tr>
    </table><br/>
    <table class="items table table-striped table-bordered table-condensed" id="table-detailpemesanan">
        <thead>
            <tr>
                <th>No.</th>
                <th>Asal Barang</th>
                <th>Nama Obat</th>
                <th>Satuan Kecil </th>
                <th>Jumlah</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if(count($modDetails) > 0){
                foreach($modDetails AS $i=>$modDetail){ ?>
            <tr>
                <td><?php echo $i+1; ?></td>
                <td><?php echo (!empty($modDetail->sumberdana_id) ? $modDetail->sumberdana->sumberdana_nama : ""); ?></td>
                <td><?php echo (!empty($modDetail->obatalkes_id) ? $modDetail->obatalkes->obatalkes_nama : ""); ?></td>
                <td><?php echo (!empty($modDetail->satuankecil_id) ? $modDetail->obatalkes->satuankecil->satuankecil_nama : ""); ?></td>
                <td><?php echo $modDetail->jmlpesan; ?></td>
            </tr>
            <?php    }
            }
            ?>
        </tbody>
    </table>
</fieldset>
<table width="80%" style="margin-top:20px;">
    <tr>
        <td width="50%" align="center">
			Pegawai Menyetujui,
            <div style="margin-top:50px;"></div><?php echo (isset($model->pegawaipemesan->NamaLengkap) ? $model->pegawaipemesan->NamaLengkap : ""); ?>
		</td>
        <td width="50%" align="center">
            <?php echo Yii::app()->user->getState('kabupaten_nama'); ?>, <?php echo $format->formatDateTimeForUser(date('Y-m-d')); ?><?php // echo Yii::app()->dateFormatter->formatDateTime(CDateTimeParser::parse(date('Y-m-d H:i:s'), 'yyyy-mm-dd hh:mm:ss')); ?><br>
            Pegawai Mengetahui,
            <div style="margin-top:50px;"></div><?php echo (isset($model->pegawaimengetahui->NamaLengkap) ? $model->pegawaimengetahui->NamaLengkap : ""); ?>
        </td>
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
        pesanobatalkes_id = '<?php echo isset($model->pesanobatalkes_id) ? $model->pesanobatalkes_id : ''; ?>';
        window.open('<?php echo $this->createUrl('print'); ?>&pesanobatalkes_id='+pesanobatalkes_id+'&caraprint='+caraprint,'printwin','left=100,top=100,width=1000,height=640');
    }
    </script>
<?php
}?>