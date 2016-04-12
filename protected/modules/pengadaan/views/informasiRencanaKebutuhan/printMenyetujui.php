<style>
    .table td, .table th {
        border: 1px solid black;
    }
    .table {
        box-shadow: none;
    }
</style>
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
echo "No. Rencana : <b>".$model->noperencnaan."</b>";
?>
<table class="table">
	<thead>
		<tr style="border:1px solid;">
			<th>No.</th>
			<th>Asal Barang</th>
			<th>Kategori / Nama Obat</th>
			<th>Jumlah Kemasan (Satuan)</th>
			<th>Jumlah Permintaan</th>
			<th>Harga Netto</th>
			<th>Stok Akhir</th>
			<th>Minimal Stok</th>
			<th>Sub Total</th>
		</tr>
	</thead>
	<tbody>
		<?php 
		$total = 0;
        $subtotal = 0;
		foreach($modDetails as $i => $modDetail){
                    $oa = ObatalkesM::model()->findByPk($modDetail->obatalkes_id);
                    $sat = !empty($modDetail->satuankecil_id)?$modDetail->satuankecil->satuankecil_nama:$modDetail->satuanbesar->satuanbesar_nama;
                    $kecil = $oa->satuankecil->satuankecil_nama;
		?>
		<tr>
			<td style="font-weight: normal;"><?php echo $i+1; echo ". "; ?></td>
			<td style="font-weight: normal;"><?php echo $modDetail->sumberdana->sumberdana_nama; ?></td>
			<td style="font-weight: normal;"><?php echo (!empty($modDetail->obatalkes->obatalkes_kategori) ? $modDetail->obatalkes->obatalkes_kategori."/ " : "") ."". $modDetail->obatalkes->obatalkes_nama; ?></td>
			<td style="font-weight: normal; text-align: right;"><?php echo $modDetail->kemasanbesar." ".$kecil; ?></td>
			<td style="font-weight: normal; text-align: right;"><?php echo $modDetail->jmlpermintaan." ".$sat; ?></td>
			<td style="font-weight: normal; text-align: right;"><?php echo $format->formatUang($modDetail->harganettorenc); ?></td>
			<td style="font-weight: normal; text-align: right;"><?php echo $modDetail->stokakhir." ".$kecil; ?></td>
			<td style="font-weight: normal; text-align: right;"><?php echo $modDetail->minimalstok." ".$kecil; ?></td>
			<td style="font-weight: normal; text-align: right;">
				<?php 
                                if (!empty($modDetail->satuankecil_id)) {
                                    $subtotal = $modDetail->harganettorenc * $modDetail->jmlpermintaan;
                                } else {
                                    $subtotal = $modDetail->harganettorenc * $modDetail->jmlpermintaan * $modDetail->kemasanbesar;
                                }
				//$subtotal = ($modDetail->harganettorenc * $modDetail->jmlpermintaan);
				$total += $subtotal;
				echo $format->formatUang($subtotal); ?>
			</td>
		</tr>
		<?php } ?>
		
			<tr style="border:1px solid;">
				<td colspan="8" style="text-align:right;font-weight: normal; font-style: italic;">Total Anggaran</td>
				<td style="font-weight: normal; font-style: italic; text-align: right;">
					<?php echo "Rp. ".$format->formatNumberForPrint($total) ?>
				</td>
			</tr>
	</tbody>
</table>
<table width="100%">
	<tr>
		<th style="width:50%; text-align:center; padding-bottom: 50px;" colspan="2">&nbsp;</th>
		<th style="width:50%; text-align:center; padding-bottom: 50px;">
		<?php 
		if(isset($model->tglmenyetujui)){ ?>
			Menyetujui,
			<br><br><br><br><br><br>
			( <?php echo $model->PegawaimenyetujuiLengkap;?> )
		<?php } ?>
		</th>
	</tr>
</table>
