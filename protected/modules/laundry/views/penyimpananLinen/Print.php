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
            <td>No. Penyimpanan</td>
            <td>:</td>
            <td><?php echo $modPenyimpananLinen->nopenyimpamanlinen; ?></td>
        </tr>
        <tr>
            <td>Tanggal Penyimpanan</td>
            <td>:</td>
            <td><?php echo isset($modPenyimpananLinen->tglpenyimpananlinen) ? MyFormatter::formatDateTimeForUser($modPenyimpananLinen->tglpenyimpananlinen) : ""; ?></td>
        </tr>
        <tr>
            <td>Pegawai Mengetahui</td>
            <td>:</td>
            <td><?php echo (isset($modPenyimpananLinen->pegmengetahui->NamaLengkap) ? $modPenyimpananLinen->pegmengetahui->NamaLengkap : ""); ?></td>
        </tr>
        <tr>
            <td>Keterangan</td>
            <td>:</td>
            <td><?php echo $modPenyimpananLinen->keterangan_penyimpanan; ?></td>
        </tr>
    </table><br/>
    <table class="items table table-striped table-bordered table-condensed" id="table-detailpemesanan">
        <thead>
            <tr>
                <th>No.</th>
                <th>Lokasi Penyimpanan</th>
                <th>Sub Rak</th>
                <th>No. Pencucian</th>
                <th>Kode Linen</th>
                <th>Nama Linen</th>
                <th>Keterangan</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if(count($modPenyimpananLinenDetail) > 0){
                foreach($modPenyimpananLinenDetail AS $i=>$modDetail){ ?>
            <tr>
                <td><?php echo $i+1; ?></td>
                <td><?php echo (!empty($modDetail->lokasipenyimpanan_id) ? $modDetail->lokasipenyimpanan->lokasipenyimpanan_nama : ""); ?></td>
                <td><?php echo (!empty($modDetail->rakpenyimpanan_id) ? $modDetail->rakpenyimpanan->rakpenyimpanan_id : ""); ?></td>
                <td><?php echo (!empty($modDetail->pencucianlinen_id) ? $modDetail->pencucianlinen->nopencucianlinen : ""); ?></td>
                <td><?php echo (!empty($modDetail->linen_id) ? $modDetail->linen->kodelinen : ""); ?></td>
                <td><?php echo (!empty($modDetail->linen_id) ? $modDetail->linen->namalinen : ""); ?></td>
                <td><?php echo $modDetail->keterangan_penyimpaanlinen; ?></td>
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
            <div style="margin-top:50px;"></div><?php echo (isset($modPenyimpananLinen->petugas->NamaLengkap) ? $modPenyimpananLinen->petugas->NamaLengkap : Yii::app()->user->getState('nama_pegawai')); ?>
		</td>
        <td width="50%" align="center">
            <?php echo Yii::app()->user->getState('kabupaten_nama'); ?>, <?php echo $format->formatDateTimeForUser(date('Y-m-d')); ?><br>
            Pegawai Mengetahui,
            <div style="margin-top:50px;"></div><?php echo (isset($modPenyimpananLinen->pegmengetahui->NamaLengkap) ? $modPenyimpananLinen->pegmengetahui->NamaLengkap : ""); ?>
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
        penyimpananlinen_id = '<?php echo isset($modPenyimpananLinen->penyimpananlinen_id) ? $modPenyimpananLinen->penyimpananlinen_id : ''; ?>';
        window.open('<?php echo $this->createUrl('print'); ?>&penyimpananlinen_id='+penyimpananlinen_id+'&caraprint='+caraprint,'printwin','left=100,top=100,width=1000,height=640');
    }
    </script>
<?php
}?>