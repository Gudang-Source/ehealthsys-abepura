<?php echo $this->renderPartial('_headerPrint'); ?>
<br>
<center><b><?php echo $judul_print ?></b></center>
<br><br>

<table width="100%">
	<tr>
		<td width="15%"><strong>No. Simulasi Anggaran</strong></td>
		<td width="35%">: &nbsp <?php echo $model[0]->nosimulasianggaran; ?></td>
		<td></td>
		<td></td>
	</tr>
	<tr>
		<td><strong>Periode Anggaran</strong></td>
		<td>: &nbsp <?php echo $model[0]->konfiganggaran->deskripsiperiode; ?></td>
		<td></td>
		<td></td>
	</tr>
	<tr>
		<td><strong>Unit Kerja</strong></td>
		<td width="35%">: &nbsp <?php echo $model[0]->unitkerja->namaunitkerja; ?></td>
		<td></td>
		<td></td>
	</tr>
	<tr>
		<td width="15%"><strong>Tanggal Simulasi Anggaran</strong></td>
		<td width="35%">: &nbsp <?php echo MyFormatter::formatDateTimeId($model[0]->tglsimulasianggaran); ?></td>
		<td></td>
		<td></td>
	</tr>
</table>
<br>
<table width="100%" border="1">
	<thead>
		<tr>
			<th>No.</th>
			<th>Program Kerja</th>
			<th>Nilai Anggaran (Rp.)</th>
			<th>Kenaikan (%)</th>
			<th>Kenaikan (Rp.)</th>
			<th>Total Nilai Anggaran (Rp.)</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach($model as $i => $val){ ?>
		<tr>
			<td style="width:50px;">
				<?php echo $i+1; ?>
			</td>
			<td>
				<?php echo (!empty($val->subkegiatanprogram->subkegiatanprogram_kode) ? $val->subkegiatanprogram->subkegiatanprogram_kode.' - ' : "") ?>
				<?php echo (!empty($val->subkegiatanprogram->subkegiatanprogram_nama) ? $val->subkegiatanprogram->subkegiatanprogram_nama : "") ?>
			</td>
			<td style="width:150px; text-align: right;">
				<?php echo (!empty($val->nilai_anggaran) ? MyFormatter::formatNumberForPrint($val->nilai_anggaran) : "") ?>
			</td>
			<td style="width:100px; text-align: right;">
				<?php echo (!empty($val->kenaikan_persen) ? MyFormatter::formatNumberForPrint($val->kenaikan_persen) : "") ?>
			</td>
			 <td style="width:100px; text-align: right;">
				 <?php echo (!empty($val->kenaikan_rupiah) ? MyFormatter::formatNumberForPrint($val->kenaikan_rupiah) : "") ?>
			</td>
			<td style="width:100px; text-align: right;">
				<?php echo (!empty($val->total_nilaianggaran) ? MyFormatter::formatNumberForPrint($val->total_nilaianggaran) : "") ?>
			</td>
		</tr>
		<?php } ?>
	</tbody>
</table>