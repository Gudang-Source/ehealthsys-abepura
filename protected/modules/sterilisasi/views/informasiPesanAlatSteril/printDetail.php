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
?>
<table class="table">
	<thead>
		<tr>
			<th>No.</th>
			<th>No. Pemesanan</th>
			<th>Nama Peralatan dan Linen</th>
			<th>Jumlah</th>
			<th>Keterangan</th>
		</tr>
	</thead>
	<tbody>
		<?php 
			$total_jumlah = 0;
			$disabled = false;
			foreach ($modDetails as $i => $detail) {?>
				<tr>
						<td><?php echo $i+1; echo ". "; ?></td>
						<td><?php echo $detail->pesan->pesanperlinensteril_no; ?></td>
						<td><?php echo isset($detail->linen_id) ? $detail->linen->namalinen : $detail->barang->barang_nama ; ?></td>
						<td><?php echo $detail->pesanperlinensterildet_jml; ?></td>
						<td><?php echo $detail->pesanperlinensterildet_ket; ?></td>
						<?php $total_jumlah += $detail->pesanperlinensterildet_jml;?>
				</tr>
				<?php } ?>
	</tbody>
		<tfoot>
			<tr>
				<td colspan="3" style="text-align:right;">Total</td>
				<td>
					<?php echo $total_jumlah; ?>
				</td>
			</tr>
		</tfoot>
</table>

<table class="table">
	<tr>
		<th style="width:50%; text-align:center; padding-bottom: 50px;" colspan="4">
			Mengetahui,
			<br><br><br><br><br><br>
			( <?php echo isset($model->pegmengetahui_id) ? $model->pegawaiMengetahui->nama_pegawai : "-";?> )		
		</th>
		<th style="width:50%; text-align:center; padding-bottom: 50px;" colspan="4">
			Memesan,
			<br><br><br><br><br><br>
			( <?php echo $model->pegawaiMemesan->nama_pegawai;?> )
		</th>
	</tr>
</table>