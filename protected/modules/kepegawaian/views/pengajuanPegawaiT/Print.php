<?php 
$table = 'ext.bootstrap.widgets.BootGridView';
$template = "{summary}\n{items}\n{pager}";
if (isset($caraPrint)){
    if($caraPrint=='EXCEL')
    {
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'.$judulLaporan.'-'.date("Y/m/d").'.xls"');
        header('Cache-Control: max-age=0');   
        $table = 'ext.bootstrap.widgets.BootExcelGridView';
    }
    $template = "{items}";
}

?>
<?php
if(!$model){
    echo "Data tidak ditemukan"; exit;
}
$format = new MyFormatter;
if (!isset($_GET['frame'])){
    echo $this->renderPartial('_headerPrint'); 
}
?>
<table width="100%">
    <tr>
        <td> <?php echo "Tanggal Pengajuan : ".$model->tglpengajuan; ?></td>
        
        <td rowspan="2" widt="40%"> <?php echo "Keterangan : ".$model->keterangan; ?></td>
    </tr>   
    <tr>
        <td><?php echo "No. Pengajuan : ".$model->nopengajuan; ?></td>
    </tr>
</table>
<br><br>
<table class="items table table-striped table-bordered table-condensed">
    <thead>
            <tr>
                <th>No. Urut</th>
                <th>Jabatan/ Pekerjaan</th>
                <th>Jumlah Orang</th>
                <th>Untuk Keperluan</th>
                <th>Keterangan</th>
            </tr>
        </thead>
    <?php
    foreach($modPengpegdets as $i=>$modDetailPengcal) {
//        $id_occupation = $modDetailPengcal->occupation_id;
//        $occopation = OccupationM::model()->findByPk($id_occupation);
    ?>

        <tr>
            <td><?php echo $modDetailPengcal->nourut;?></td>
            <td>-<?php //echo $occopation->occupation_nama;?>
            </td>
            <td><?php echo $modDetailPengcal->jmlorang;?></td>
            <td><?php echo $modDetailPengcal->untukkeperluan; ?></td>
            <td><?php echo $modDetailPengcal->keterangan; ?></td>

        </tr>

    <?php }  ?>
</table>
<br><br>
<table width='100%'>
	<tr>
		<td></td>
		<td></td>
		<td align='center'><?php echo Yii::app()->user->getState('kabupaten_nama').", ".$format->formatDateTimeId(date('Y-m-d')); ?></td>
	</tr>
	<tr>		
		<td  align='center'>Mengajukan</td>
		<td></td>
		<td align='center'>Mengetahui</td>
	</tr>
	<tr height='100px'>		
		<td align='center'><?php echo Yii::app()->user->getState('nama_pegawai'); ?></td>
		<td></td>
		<td align='center'><?php echo (isset($model->mengajukan_id) ? $model->mengajukan->NamaLengkap : Yii::app()->user->getState('nama_pegawai')); ?></td>
	</tr>
</table>  