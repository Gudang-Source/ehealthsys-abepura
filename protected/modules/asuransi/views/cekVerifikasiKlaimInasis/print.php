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
$format = new MyFormatter;
if (!isset($_GET['frame'])){
    echo $this->renderPartial($this->path_view.'_headerPrint'); 
}
?>
<table width="100%" style="margin:0px;" cellpadding="0" cellspacing="0">
	<tr>
		<td align="center" valign="middle" colspan="3">
			<b><?php echo $judul_print ?></b>
		</td>
	</tr>
</table><br/>
<table width="100%" style="margin:0px;" cellpadding="0" cellspacing="0" class="table table-bordered table-striped" id="tabel-verifikasi">
	<tr>
		<td style="font-weight: bold;">Tanggal Verifikasi Masuk</td>
		<td style="font-weight: bold;text-align:center;">:</td>
		<td><?php echo isset($model->verifikasiinasis_tglmasuk) ? MyFormatter::formatDateTimeForUser($model->verifikasiinasis_tglmasuk) : ""; ?></td>
		
		<td style="font-weight: bold;">Jenis Pelayanan</td>
		<td style="font-weight: bold;text-align:center;">:</td>
		<td><?php echo isset($model->verifikasiinasis_jnspelayanan) ? $model->verifikasiinasis_jnspelayanan : ""; ?></td>
	</tr>
	<tr>
		<td style="font-weight: bold;">Tanggal Verifikasi Keluar</td>
		<td style="font-weight: bold;text-align:center;">:</td>
		<td><?php echo isset($model->verifikasiinasis_tglmasuk) ? MyFormatter::formatDateTimeForUser($model->verifikasiinasis_tglkeluar) : ""; ?></td>
		
		<td style="font-weight: bold;">Kelas Pelayanan</td>
		<td style="font-weight: bold;text-align:center;">:</td>
		<td><?php echo isset($model->verifikasiinasis_kelaspelayanan) ? $model->verifikasiinasis_kelaspelayanan : ""; ?></td>
	</tr>
	<tr>
		<td style="font-weight: bold;"></td>
		<td style="font-weight: bold;text-align:center;"></td>
		<td></td>
		
		<td style="font-weight: bold;">Status</td>
		<td style="font-weight: bold;text-align:center;">:</td>
		<td><?php echo isset($model->verifikasiinasis_status) ? $model->verifikasiinasis_status : ""; ?></td>
	</tr>
</table>
<table width="100%" style="margin:0px;" cellpadding="0" cellspacing="0" class="table table-bordered table-striped" id="tabel-verifikasi-klaim">
	<thead>
		<tr>
			<th>No.</th>
			<th>Tanggal Masuk (SEP)</th>
			<th>Tanggal Pulang</th>
			<th>Jenis Pelayanan</th>
			<th>Kelas Pelayanan</th>
			<th>Status</th>
			<th>No. RM</th>
			<th>No. Peserta</th>
			<th>Nama Pasien</th>
			<th>No. SEP</th>
			<th>Kode INA-CBG</th>
			<th>Nama INA-CBG</th>
			<th>Total Tagihan</th>
			<th>Total Gruper</th>
			<th>Tagihan Pelayanan RS</th>
			<th>Top Up</th>
		</tr>
	</thead>
	<tbody>
		<?php
			if(count($modVerifikasiKlaim) > 0){
				foreach($modVerifikasiKlaim as $i=>$data){
		?>
		<tr>
			<td><?php echo ($i+1); ?></td>
			<td><?php echo isset($data->verifikasi_tglsep) ? MyFormatter::formatDateTimeForUser($data->verifikasi_tglsep) : ""; ?></td>
			<td><?php echo isset($data->verifikasi_tglpulang) ? MyFormatter::formatDateTimeForUser($data->verifikasi_tglpulang) : ""; ?></td>
			<td><?php echo $data->verifikasi_jnspelayanan; ?></td>
			<td><?php echo $data->verifikasi_kelasrawat; ?></td>
			<td><?php echo isset($data->verifikasiinasis->verifikasiinasis_status) ? $data->verifikasiinasis->verifikasiinasis_status : ""; ?></td>
			<td><?php echo $data->verifikasi_nomr; ?></td>
			<td><?php echo $data->verifikasi_nokartu; ?></td>
			<td><?php echo $data->verifikasi_nama; ?></td>
			<td><?php echo $data->verifikasi_nosep; ?></td>
			<td><?php echo $data->verifikasi_kdinacbg; ?></td>
			<td><?php echo $data->verifikasi_nminacbg; ?></td>
			<td><?php echo $data->verifikasi_bytagihan; ?></td>
			<td><?php echo $data->verifikasi_bytarifgruper; ?></td>
			<td><?php echo $data->verifikasi_bytarifrs; ?></td>
			<td><?php echo $data->verifikasi_bytopup; ?></td>
		</tr>
			<?php } ?>
		<?php }else{ ?>
		<tr>
			<td colspan="16">Data tidak ditemukan.</td>
		</tr>
		<?php } ?>
	</tbody>
</table>