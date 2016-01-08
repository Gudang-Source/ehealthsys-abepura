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
            <td>No. Pencucian</td>
            <td>:</td>
            <td><?php echo $modPencucianLinen->nopencucianlinen; ?></td>
        </tr>
        <tr>
            <td>Tanggal Perawatan</td>
            <td>:</td>
            <td><?php echo isset($modPencucianLinen->tglpencucianlinen) ? MyFormatter::formatDateTimeForUser($modPencucianLinen->tglpencucianlinen) : ""; ?></td>
        </tr>
        <tr>
            <td>Pegawai Mengetahui</td>
            <td>:</td>
            <td><?php echo (isset($modPencucianLinen->pegpenerima->NamaLengkap) ? $modPencucianLinen->pegpenerima->NamaLengkap : ""); ?></td>
        </tr>
        <tr>
            <td>Keterangan</td>
            <td>:</td>
            <td><?php echo $modPencucianLinen->keterangan_pencucianlinen; ?></td>
        </tr>
    </table><br/>
    <table class="items table table-striped table-bordered table-condensed" id="table-detailpemesanan">
        <thead>
            <tr>
                <th>No.</th>
                <th>Ruangan Asal</th>
                <th>No. Penerimaan</th>
                <th>Kode Linen</th>
                <th>Nama Linen</th>
                <th>Keterangan</th>
                <th>Status Perawatan</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if(count($modPencucianLinenDetail) > 0){
                foreach($modPencucianLinenDetail AS $i=>$modDetail){ ?>
            <tr>
                <td><?php echo $i+1; ?></td>
                <td><?php echo (!empty($modDetail->ruangan_id) ? $modDetail->ruangan_nama : ""); ?></td>
                <td><?php echo (!empty($modDetail->penerimaanlinen_id) ? $modDetail->nopenerimaanlinen : ""); ?></td>
                <td><?php echo (!empty($modDetail->kodelinen) ? $modDetail->kodelinen : ""); ?></td>
                <td><?php echo (!empty($modDetail->namalinen) ? $modDetail->namalinen : ""); ?></td>
                <td><?php echo $modDetail->keteranganperawatan; ?></td>
                <td><?php echo $modDetail->statusperawatanlinen; ?></td>
            </tr>
            <?php    }
            }
            ?>
        </tbody>
    </table>
	<span>Data Bahan Perawatan</span>
	<table class="items table table-striped table-bordered table-condensed" id="table-detailpemesanan">
        <thead>
            <tr>
                <th>No.</th>
                <th>Nama Bahan</th>
                <th>Jumlah Bahan</th>
                <th>Satuan</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if(count($modPencucianBahan) > 0){
                foreach($modPencucianBahan AS $i=>$modBahan){ ?>
            <tr>
                <td><?php echo $i+1; ?></td>
                <td><?php echo (!empty($modBahan->bahanperawatan_id) ? $modBahan->bahanperawatan->bahanperawatan_nama : ""); ?></td>
                <td><?php echo (!empty($modBahan->jmlpemakai) ? $modBahan->jmlpemakai : ""); ?></td>
                <td><?php echo (!empty($modBahan->satuanpemakaian) ? $modBahan->satuanpemakaian : ""); ?></td>
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
            <div style="margin-top:50px;"></div><?php echo (isset($modPencucianLinen->pegpenerima->NamaLengkap) ? $modPencucianLinen->pegpenerima->NamaLengkap : ""); ?>
		</td>
        <td width="50%" align="center">
            <?php echo Yii::app()->user->getState('kabupaten_nama'); ?>, <?php echo $format->formatDateTimeForUser(date('Y-m-d')); ?><br>
            Pegawai Mengetahui,
            <div style="margin-top:50px;"></div><?php echo (isset($modPencucianLinen->petugas->NamaLengkap) ? $modPencucianLinen->petugas->NamaLengkap : Yii::app()->user->getState('nama_pegawai')); ?>
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
        pencucianlinen_id = '<?php echo isset($modPencucianLinen->pencucianlinen_id) ? $modPencucianLinen->pencucianlinen_id : ''; ?>';
        window.open('<?php echo $this->createUrl('print'); ?>&pencucianlinen_id='+pencucianlinen_id+'&caraprint='+caraprint,'printwin','left=100,top=100,width=1000,height=640');
    }
    </script>
<?php
}?>