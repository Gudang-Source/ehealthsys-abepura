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
            <td>No. Pemeliharaan Aset</td>
            <td>:</td>
            <td><?php echo $modPemeliharaan->pemeliharaanaset_no; ?></td>
        </tr>
        <tr>
            <td>Tanggal Pemeliharaan</td>
            <td>:</td>
            <td><?php echo isset($modPemeliharaan->pemeliharaanaset_tgl) ? MyFormatter::formatDateTimeForUser($modPemeliharaan->pemeliharaanaset_tgl) : ""; ?></td>
        </tr>
        <tr>
            <td>Pegawai Mengetahui</td>
            <td>:</td>
            <td><?php echo (isset($modPemeliharaan->pegmengetahui_id) ? $modPemeliharaan->pegmengetahui->nama_pegawai : ""); ?></td>
        </tr>
        <tr>
            <td>Petugas 1</td>
            <td>:</td>
            <td><?php echo (isset($modPemeliharaan->pegpetugas1_id) ? $modPemeliharaan->pegpetugas1->nama_pegawai : ""); ?></td>
        </tr>
		<tr>
            <td>Petugas 2</td>
            <td>:</td>
            <td><?php echo (isset($modPemeliharaan->pegpetugas2_id) ? $modPemeliharaan->pegpetugas2->nama_pegawai : ""); ?></td>
        </tr>		
        <tr>
            <td>Keterangan</td>
            <td>:</td>
            <td><?php echo $modPemeliharaan->pemeliharaanaset_ket; ?></td>
        </tr>
    </table><br/>
    <table class="items table table-striped table-bordered table-condensed" id="table-detailpemesanan">
        <thead>
            <tr>
				<th>No.</th>
				<th>Kode Aset</th>
				<th>Nama Aset</th>
				<th>Waktu Pengecekan</th>
				<th>Kondisi Aset</th>
				<th>Keterangan</th>				
			</tr>
        </thead>
        <tbody>
            <?php
            if(count($modPemeliharaanasetDetail) > 0){
                foreach($modPemeliharaanasetDetail AS $i=>$modDetail){ ?>
            <tr>
                <td><?php echo $i+1; ?></td>
                <td><?php echo (!empty($modDetail->barang_id) ? $modDetail->barang->barang_kode : ""); ?></td>
                <td><?php echo (!empty($modDetail->barang_id) ? $modDetail->barang->barang_nama : ""); ?></td>
                <td><?php echo (!empty($modDetail->pemeliharaanasetdet_tgl) ? MyFormatter::formatDateTimeForUser($modDetail->pemeliharaanasetdet_tgl) : ""); ?></td>
                <td><?php echo (!empty($modDetail->kondisiaset) ? $modDetail->kondisiasset->lookup_name : ""); ?></td>
                <td><?php echo (!empty($modDetail->keteranganaset) ? $modDetail->keteranganaset : ""); ?></td>                
            </tr>
            <?php    }
            }
            ?>
        </tbody>
    </table>	
</fieldset>
<table width="100%" style="margin-top:20px;">
    <tr>
        <td width="33%" align="center" valign="bottom">
			Petugas 1,			
            <div style="margin-top:50px;"></div><?php echo (isset($modPemeliharaan->pegmengetahui_id) ? $modPemeliharaan->pegmengetahui->namaLengkap : ""); ?>
		</td>	
        <td width="33%" align="center" valign="bottom">
            Petugas 2,
            <div style="margin-top:50px;"></div><?php echo (isset($modPemeliharaan->pegtugas2_id) ? $modPemeliharaan->pegtugas2->namaLengkap : Yii::app()->user->getState('nama_pegawai')); ?>
        </td>
		<td width="34%" align="center">
            <?php echo Yii::app()->user->getState('kabupaten_nama'); ?>, <?php echo $format->formatDateTimeForUser(date('Y-m-d')); ?><br>
            Pegawai Menyetujui,
            <div style="margin-top:50px;"></div><?php echo (isset($modPemeliharaan->pegtugas1_id) ? $modPemeliharaan->pegtugas1->namaLengkap : Yii::app()->user->getState('nama_pegawai')); ?>
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
        pemeliharaanaset_id = '<?php echo isset($modPemeliharaan->pemeliharaanaset_id) ? $modPemeliharaan->pemeliharaanaset_id : ''; ?>';
        window.open('<?php echo $this->createUrl('print'); ?>&pemeliharaanaset_id='+pemeliharaanaset_id+'&caraprint='+caraprint,'printwin','left=100,top=100,width=1000,height=640');
    }
    </script>
<?php
}?>