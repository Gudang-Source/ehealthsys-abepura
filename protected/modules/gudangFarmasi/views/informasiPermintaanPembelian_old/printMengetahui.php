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
$modProfilRs = ProfilrumahsakitM::model()->findByPk(Params::DEFAULT_PROFIL_RUMAH_SAKIT);
echo $this->renderPartial('application.views.headerReport.headerAnggaran',array('judulLaporan'=>$judulLaporan, 'deskripsi'=>$deskripsi, 'colspan'=>10));
?>
<br>
<table width="74%" style="margin:0px;" cellpadding="0" cellspacing="0">
        <tr>
            <td  width="20%">No. PO</td>
            <td>:</td>
            <td><?php echo $model->nopermintaan; ?></td>
        </tr>
        <tr>
            <td>Lampiran</td>
            <td>:</td>
            <td></td>
        </tr>
        <tr>
            <td>Perihal</td>
            <td>:</td>
            <td>Pesanan Obat / Alat Kesehatan habis pakai rutin</td>
        </tr>
        <tr>
            <td>No. Rek</td>
            <td>:</td>
            <td></td>
        </tr>
        <tr>
            <td>No. Perencanaan</td>
            <td>:</td>
            <td><?php echo !empty($model->rencanakebfarmasi_id)?$model->rencanakebfarmasi->noperencnaan:' - '; ?></td>
        </tr>
    </table><br/><br>
    &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Kepada Yth. <?php echo $model->supplier->supplier_nama; ?><br>
    &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Di  <?php echo $model->supplier->supplier_alamat; ?><br>
    Dengan hormat,<br>
    Dengan ini kami mohon pada saudara untuk dapat menyediakan obat dan alat kesehatan <?php echo $modProfilRs->nama_rumahsakit; ?>
    <br><br>
    <table width="100%" style='margin-left:auto; margin-right:auto;' >
        <thead class="border">
            <th style="text-align: center;">No.</th>
            <th style="text-align: center;">Asal Barang</th>
            <th style="text-align: center;">Kategori / Nama Obat</th>
            <th style="text-align: center;">Jumlah Kemasan (Satuan) </th>
            <th style="text-align: center;">Jumlah Pembelian</th>
            <th style="text-align: center;">Harga Netto</th>
<!--            <th style="text-align: center;">Stok Akhir</th>
            <th style="text-align: center;">PPN</th>
            <th style="text-align: center;">PPH</th>
            <th style="text-align: center;">Diskon (%)</th>
            <th style="text-align: center;">Diskon Total (Rp.)</th>
            <th style="text-align: center;">Minimal Stok</th>-->
            <th style="text-align: center;">Sub Total</th>
        </thead>
        <?php 
        $total = 0;
        $subtotal = 0;
        foreach ($modDetails as $i=>$modObat){ 
        ?>
            <tr class="border">
                <td><?php echo ($i+1)."."; ?></td>
                <td><?php echo $modObat->sumberdana->sumberdana_nama; ?></td>
                <td><?php echo (!empty($modObat->obatalkes->obatalkes_kategori) ? $modObat->obatalkes->obatalkes_kategori."/ " : "") ."". $modObat->obatalkes->obatalkes_nama; ?></td>
                <td><?php echo number_format($modObat->kemasanbesar); ?></td>
                <td><?php echo number_format($modObat->jmlpermintaan); ?></td>
                <td><?php echo $format->formatUang($modObat->harganettoper); ?></td>
<!--                <td><?php // echo number_format($modObat->stokakhir); ?></td>
                <td><?php // echo $modObat->persenppn; ?></td>
                <td><?php // echo $modObat->persenpph; ?></td>
                <td><?php // echo $modObat->persendiscount; ?></td>
                <td><?php // echo $format->formatUang($modObat->jmldiscount); ?></td>
                <td><?php // echo number_format($modObat->minimalstok); ?></td>-->
                <td><?php 
                    $subtotal = ($modObat->harganettoper * $modObat->jmlpermintaan);
                    $total += $subtotal;
                    echo $format->formatUang($subtotal); ?>
                </td>
            </tr>
        <?php } ?>
        <tr>
            <td colspan="10" style="text-align: center;"><i>( <?php echo $format->kataterbilang($total) ?> rupiah )</i></td>
            <td colspan="2" align="center"><strong>Total</strong></td>
            <td   class="border"><?php echo $format->formatUang($total); ?></td>
        </tr>
    </table><br>
    Demikian Surat Pesanan ini kami buat untuk dapat dipergunakan seperlunya,<br>
    Atas perhatian dan kerja sama yang baik kami ucapkan terima kasih.<br><br>
<table class="table">
	<tr>
		<th style="width:50%; text-align:center; padding-bottom: 50px;" colspan="2">
		<?php 
		if(isset($model->tglmengetahui)){ ?>
			Mengetahui,
			<br><br><br><br><br><br>
			( <?php echo $model->pegawaimengetahui->NamaLengkap;?> )
		<?php } ?>			
		</th>
		<th style="width:50%; text-align:center; padding-bottom: 50px;" colspan="2">
			Menyetujui,
			<br><br><br><br><br><br>
			( <?php echo $model->pegawaimenyetujui->NamaLengkap;?> )
		</th>
	</tr>
</table>