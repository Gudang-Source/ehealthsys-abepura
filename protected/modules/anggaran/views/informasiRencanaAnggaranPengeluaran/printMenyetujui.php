<?php 
$table = 'ext.bootstrap.widgets.BootGridView';
$template = "{summary}\n{items}\n{pager}";
if (isset($caraPrint)){
	$template = "{items}";
	if($caraPrint=='EXCEL'){
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="'.$judulLaporan.'-'.date("Y/m/d").'.xls"');
		header('Cache-Control: max-age=0');   
		$table = 'ext.bootstrap.widgets.BootExcelGridView';
	}
}

echo $this->renderPartial('application.views.headerReport.headerAnggaran',array('judulLaporan'=>$judulLaporan, 'deskripsi'=>$deskripsi, 'colspan'=>10));
 
echo "NO &nbsp;: <b>".$model->rencanggaranpeng_no."</b>";
echo "<br>Unit : <b>".$model->unitkerja->namaunitkerja."</b>";
?>
<table class="table">
	<thead>
		<tr style="border:1px solid;">
			<th>No.</th>
			<th>Kode Program</th>
			<th>Kode Sub Program</th>
			<th>Kode Kegiatan</th>
			<th>Kode Sub Kegiatan</th>
			<th>Program Kerja</th>
			<th>Bulan</th>
			<th>Nilai</th>
		</tr>
	</thead>
	<tbody>
		<?php 
		$kerangkaloop = count($modPrograms['programkerja_kode']);
		for($i = 0; $i < $kerangkaloop; ++$i) {
		?>
		<tr>
				<td style="font-weight: normal;"><?php echo $i+1; echo ". "; ?></td>
				<td style="font-weight: normal;"><?php echo $modPrograms['programkerja_kode'][$i]; ?></td>
				<td style="font-weight: normal;"><?php echo $modPrograms['subprogramkerja_kode'][$i]; ?></td>
				<td style="font-weight: normal;"><?php echo $modPrograms['kegiatanprogram_kode'][$i]; ?></td>
				<td style="font-weight: normal;"><?php echo $modPrograms['subkegiatanprogram_kode'][$i]; ?></td>
				<td style="font-weight: normal;"><?php echo $modPrograms['subkegiatanprogram_nama'][$i]; ?></td>
				<td style="font-weight: normal;"><?php echo $detail['tglrencanapengdet'][$i]; ?></td>
				<td style="font-weight: normal;"><?php echo $format->formatNumberForUser($detail['nilairencpengeluaran'][$i]); ?></td>
		</tr>
		<?php } ?>
			<tr style="border:1px solid;">
				<td colspan="7" style="text-align:right;font-weight: normal; font-style: italic;">Total Anggaran</td>
				<td style="font-weight: normal; font-style: italic;">
					<?php echo $format->formatNumberForUser($model->total_nilairencpeng) ?>
				</td>
			</tr>
	</tbody>
</table>
<table class="table">
	<tr>
		<th style="width:50%; text-align:center; padding-bottom: 50px;" colspan="6">&nbsp;</th>
		<th style="width:50%; text-align:center; padding-bottom: 50px;">
		<?php 
		if(isset($model->tglmenyetujui)){ ?>
			Menyetujui,
			<br><br><br><br><br><br>
			( <?php echo $model->menyetujui->nama_pegawai;?> )
		<?php } ?>
		</th>
	</tr>
</table>
