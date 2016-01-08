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
        width:1%;
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
$format = new MyFormatter;
if (!isset($_GET['frame'])){
    echo $this->renderPartial('application.views.headerReport.headerAnggaran',array('judulLaporan'=>$judulLaporan, 'deskripsi'=>$deskripsi, 'colspan'=>10));
}
?>
<table width="100%" style='margin-left:auto; margin-right:auto;'>
        <thead class="border">
            <th style="text-align: center;">No.</th>
            <th style="text-align: center;">Kode Program</th>
            <th style="text-align: center;">Kode Sub Program</th>
            <th style="text-align: center;">Kode Kegiatan</th>
            <th style="text-align: center;">Kode Sub Kegiatan</th>
            <th style="text-align: center;">Program Kerja</th>
            <th style="text-align: center;">Bulan</th>
            <th style="text-align: center;">Nilai</th>
            <th style="text-align: center;">Sumber Anggaran</th>
            <th style="text-align: center;">Nilai Alokasi</th>  
        </thead>
        <?php 
        $total_nilairencana = 0;
        $total_nilaialokasi = 0;
        foreach ($model as $i=>$data){ 
			$total_nilairencana += $data->nilairencana;
			$total_nilaialokasi += $data->nilaiygdialokasikan;
			$modProgramKerja = AGInformasialokasianggaranV::model()->findByAttributes(array('apprrencanggaran_id'=>$data->apprrencanggaran_id));
        ?>
            <tr>
                <td align="center"><?php echo ($i+1); ?></td>
                <td align="center"><?php echo $modProgramKerja->programkerja_kode; ?></td>
                <td align="center"><?php echo $modProgramKerja->subprogramkerja_kode; ?></td>
                <td align="center"><?php echo $modProgramKerja->kegiatanprogram_kode; ?></td>
                <td align="center"><?php echo $modProgramKerja->subkegiatanprogram_kode; ?></td>
                <td align="center"><?php echo $modProgramKerja->subkegiatanprogram_nama; ?></td>
                <td align="center"><?php echo (!empty($modProgramKerja->tglapprrencanggaran) ? $format->formatMonthForUser($modProgramKerja->tglapprrencanggaran) : ""); ?></td>
                <td align="right"><?php echo number_format($data->nilairencana); ?></td>
                <td align="center"><?php echo $data->sumberanggaran->sumberanggarannama; ?></td>
				<td align="right"><?php echo number_format($data->nilaiygdialokasikan); ?></td>
            </tr>
        <?php } ?>
        <tfoot class="border">
            <tr>
                <td colspan="7" align="right"><strong>Total</strong></td>
                <td align="right"><?php echo $format->formatUang($total_nilairencana); ?></td>
				<td></td>
				<td align="right"><?php echo $format->formatUang($total_nilaialokasi); ?></td>
            </tr>
        </tfoot>
    </table>
<br/>
	
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
		var alokasianggaran_id = '<?php echo isset($_GET['alokasianggaran_id']) ? $_GET['alokasianggaran_id'] : null; ?>';
		window.open('<?php echo $this->createUrl('print'); ?>&alokasianggaran_id='+no_alokasi+'&caraPrint='+caraPrint,'printwin','left=100,top=100,width=1000,height=640');
    }
    </script>
<?php
}else{ ?>
    <table class="table">
		<tr>
			<th style="width:50%; text-align:center; padding-bottom: 50px;" colspan="4">
				Mengetahui,
				<br><br><br><br><br><br>
				( <?php echo (isset($model[0]->mengetahui->NamaLengkap) ? $model[0]->mengetahui->NamaLengkap : "");?> )		
			</th>
			<th style="width:50%; text-align:center; padding-bottom: 50px;" colspan="4">
				Menyetujui,
				<br><br><br><br><br><br>
				( <?php echo (isset($model[0]->menyetujui->NamaLengkap) ? $model[0]->menyetujui->NamaLengkap : "");?> )
			</th>
		</tr>
	</table>
<?php } ?>
