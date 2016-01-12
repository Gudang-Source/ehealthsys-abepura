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
            <td>No. Sterilisasi</td>
            <td>:</td>
            <td><?php echo $modSterilisasi->sterilisasi_no; ?></td>
        </tr>
        <tr>
            <td>Tanggal Sterilisasi</td>
            <td>:</td>
            <td><?php echo isset($modSterilisasi->sterilisasi_tgl) ? MyFormatter::formatDateTimeForUser($modSterilisasi->sterilisasi_tgl) : ""; ?></td>
        </tr>
        <tr>
            <td>Pegawai Sterilisasi</td>
            <td>:</td>
            <td><?php echo (isset($modSterilisasi->pegsterilisasi->NamaLengkap) ? $modSterilisasi->pegsterilisasi->NamaLengkap : ""); ?></td>
        </tr>
        <tr>
            <td>Keterangan</td>
            <td>:</td>
            <td><?php echo $modSterilisasi->sterilisasi_ket; ?></td>
        </tr>
    </table><br/>
    <table class="items table table-striped table-bordered table-condensed" id="table-detailpemesanan">
        <thead>
            <tr>
				<th>No.</th>
				<th>Ruangan Asal</th>
				<th>No. Penerimaan</th>
				<th>Nama Peralatan dan Linen</th>
				<th>Jumlah</th>
				<th>Keterangan</th>
				<th>Jenis Sterilisasi</th>
				<th>Alat Sterilisasi</th>
				<th>Bahan yang Digunakan</th>
				<th>Kemasan yang Digunakan</th>
				<th>Waktu Kadaluarsa</th>
			</tr>
        </thead>
        <tbody>
            <?php
            if(count($modSterilisasiDetail) > 0){
                foreach($modSterilisasiDetail AS $i=>$modDetail){ ?>
            <tr>
                <td><?php echo $i+1; ?></td>
				<td><?php echo (!empty($modDetail->penerimaansterilisasi->ruangan_id) ? $modDetail->penerimaansterilisasi->ruangan->ruangan_nama : ""); ?></td>
                <td><?php echo (!empty($modDetail->penerimaansterilisasi->penerimaansterilisasi_no) ? $modDetail->penerimaansterilisasi->penerimaansterilisasi_no : ""); ?></td>
                <td><?php echo (!empty($modDetail->barang_id) ? $modDetail->barang->barang_nama : ""); ?></td>
                <td><?php echo (!empty($modDetail->sterilisasidetail_jml) ? $modDetail->sterilisasidetail_jml : 0); ?></td>
                <td><?php echo (!empty($modDetail->steriliesasidetail_ket) ? $modDetail->steriliesasidetail_ket : 0); ?></td>
                <td><?php echo (!empty($modDetail->jenissterilisasi_id) ? $modDetail->jenissterilisasi->jenissterilisasi_nama : 0); ?></td>
                <td><?php echo (!empty($modDetail->alatmedis_id) ? $modDetail->alatmedis->alatmedis_nama : 0); ?></td>
                <td>
					<ol type="1">
					<?php 
						$modSterilisasiBahan = STSterilisasibahanT::model()->findAllByAttributes(array('sterilisasidetail_id'=>$modDetail->sterilisasidetail_id));
						if(count($modSterilisasiBahan) > 0){
							foreach($modSterilisasiBahan as $a=>$bahan){ ?>
						<li><?php echo $bahan->bahansterilisasi->bahansterilisasi_nama; ?></li>
					<?php } ?>
					<?php } ?>
						</ol>
				</td>
                <td><?php echo $modDetail->kemasanygdigunakan; ?></td>
                <td><?php echo isset($modDetail->waktukadaluarsa) ? MyFormatter::formatDateTimeForUser($modDetail->waktukadaluarsa) : ""; ?></td>
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
            <div style="margin-top:50px;"></div><?php echo (isset($modSterilisasi->pegsterilisasi->NamaLengkap) ? $modSterilisasi->pegsterilisasi->NamaLengkap : ""); ?>
		</td>
        <td width="50%" align="center">
            <?php echo Yii::app()->user->getState('kabupaten_nama'); ?>, <?php echo $format->formatDateTimeForUser(date('Y-m-d')); ?><br>
            Pegawai Mengetahui,
            <div style="margin-top:50px;"></div><?php echo (isset($modSterilisasi->pegmengetahui->NamaLengkap) ? $modSterilisasi->pegmengetahui->NamaLengkap : Yii::app()->user->getState('nama_pegawai')); ?>
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
        sterilisasi_id = '<?php echo isset($modSterilisasi->sterilisasi_id) ? $modSterilisasi->sterilisasi_id : ''; ?>';
        window.open('<?php echo $this->createUrl('print'); ?>&sterilisasi_id='+sterilisasi_id+'&caraprint='+caraprint,'printwin','left=100,top=100,width=1000,height=640');
    }
    </script>
<?php
}?>