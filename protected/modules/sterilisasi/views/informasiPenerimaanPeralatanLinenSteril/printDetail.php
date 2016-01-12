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
<fieldset>
    <table class="items table table-striped table-condensed">
        <tr>
            <td>No. penerimaan</td>
            <td>:</td>
            <td><?php echo isset($model->terimaperlinensteril_no) ? $model->terimaperlinensteril_no : ""; ?></td>
        </tr>
        <tr>
            <td>Tanggal penerimaan</td>
            <td>:</td>
            <td><?php echo isset($model->terimaperlinensteril_tgl) ? MyFormatter::formatDateTimeForUser($model->terimaperlinensteril_tgl) : ""; ?></td>
        </tr>
        <tr>
            <td>Pegawai penerimaan</td>
            <td>:</td>
            <td><?php echo (isset($model->pegawaiMenerima->NamaLengkap) ? $model->pegawaiMenerima->NamaLengkap : ""); ?></td>
        </tr>
        <tr>
            <td>Keterangan</td>
            <td>:</td>
            <td><?php echo isset($model->terimaperlinensteril_ket) ? $model->terimaperlinensteril_ket : ""; ?></td>
        </tr>
    </table><br/>
    <table class="items table table-striped table-condensed" id="table-detailpemesanan">
        <thead>
            <tr>
                <th>No.</th>
                <th>Ruangan Asal</th>
                <th>Nama Peralatan</th>
                <th>Jumlah</th>
                <th>Keterangan</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if(count($modDetails) > 0){
                foreach($modDetails AS $i=>$detail){ ?>
            <tr>
                <td><?php echo $i+1; ?></td>
                <td><?php echo (!empty($detail->penerimaansterilisasi->ruangan_id) ? $detail->penerimaansterilisasi->ruangan->ruangan_nama : ""); ?></td>
                <td><?php echo (!empty($detail->barang->barang_id) ? $detail->barang->barang_id : ""); ?></td>
                <td><?php echo (!empty($detail->terimaperlinensterildet_jml) ? $detail->terimaperlinensterildet_jml : ""); ?></td>
                <td><?php echo (!empty($detail->terimaperlinensterildet_ket) ? $detail->terimaperlinensterildet_ket : ""); ?></td>
            </tr>
            <?php    }
            }
            ?>
        </tbody>
    </table>
</fieldset>

<table class="table">
	<tr>
		<th style="width:50%; text-align:center; padding-bottom: 50px;" colspan="4">
			Pegawai Mengetahui,
			<br><br><br><br><br><br>
			( <?php echo isset($model->pegmengetahui_id) ? $model->pegawaiMengetahui->NamaLengkap : "-";?> )		
		</th>
		<th style="width:50%; text-align:center; padding-bottom: 50px;" colspan="4">
			Pegawai Menerima,
			<br><br><br><br><br><br>
			( <?php echo $model->pegawaiMenerima->NamaLengkap;?> )
		</th>
	</tr>
</table>