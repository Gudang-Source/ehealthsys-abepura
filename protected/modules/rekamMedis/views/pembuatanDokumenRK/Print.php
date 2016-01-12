<?php 
$table = 'ext.bootstrap.widgets.BootGridView';
$template = "{summary}\n{items}\n{pager}";
if (isset($caraPrint)){
	$template = "{items}";
	if($caraPrint=='EXCEL'){
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="'.$judul_print.'-'.date("Y/m/d").'.xls"');
		header('Cache-Control: max-age=0');   
		$table = 'ext.bootstrap.widgets.BootExcelGridView';
	}
}

echo $this->renderPartial('application.views.headerReport.headerDefault',array('judulLaporan'=>$judul_print, 'colspan'=>''));  
?>
<div>
	<legend class="rim2">Data Pasien</legend>
	<table width="100%" style="margin:0px;" cellpadding="0" cellspacing="0">
		<tr>
			<td>
				<table width="100%">
					<tr>
						<td width="11%" style="text-align:right;">No. Rekam Medik</td><td width="2%">:</td>
						<td width="37%">
							<?php echo CHtml::encode($modPasien->no_rekam_medik); ?>
						</td>
						<td width="11%" style="text-align:right;">Tgl. Rekam Medis</td><td width="2%">:</td>
						<td width="37%">
							<?php echo CHtml::encode(isset($modPasien->tgl_rekam_medik) ? MyFormatter::formatDateTimeForUser($modPasien->tgl_rekam_medik) : "-"); ?>
						</td>
					</tr>
					<tr>
						<td width="11%" style="text-align:right;">Nama Pasien</td><td width="2%">:</td>
						<td width="37%">
							<?php echo CHtml::encode($modPasien->nama_pasien); ?>
						</td>
						<td width="11%" style="text-align:right;">Jenis Kelamin</td><td width="2%">:</td>
						<td width="37%">
							<?php echo CHtml::encode(isset($modPasien->jeniskelamin) ? $modPasien->jeniskelamin : "-"); ?>
						</td>
					</tr>
					<tr>
						<td width="11%" style="text-align:right;">Tempat, Tgl. Lahir</td><td width="2%">:</td>
						<td width="37%">
							<?php echo CHtml::encode($modPasien->tempat_lahir). " / ". CHtml::encode(isset($modPasien->tanggal_lahir) ? MyFormatter::formatDateTimeForUser($modPasien->tanggal_lahir) : null); ?>
						</td>
						<td width="11%" style="text-align:right;">Alamat Pasien</td><td width="2%">:</td>
						<td width="37%">
							<?php echo CHtml::encode(isset($modPasien->alamat_pasien) ? $modPasien->alamat_pasien : "-"); ?>
						</td>
					</tr>
				</table>
			</td>
		</tr>
	</table><br/>
	<legend class="rim2">Data Pembuatan Dokumentasi Rekam Medis</legend>
	<table width="100%" style="margin:0px;" cellpadding="0" cellspacing="0">
		<tr>
			<td>
				<table width="100%">
					<tr>
						<td width="11%" style="text-align:right;">No. Dokumen RK</td><td width="2%">:</td>
						<td width="37%">
							<?php echo CHtml::encode($model->nodokumenrm); ?>
						</td>
						<td width="11%" style="text-align:right;">Warna Dokumen RK</td><td width="2%">:</td>
						<td width="37%">
							<?php echo CHtml::encode(isset($model->warnadokrm_id) ? $model->warnadok->warnadokrm_namawarna : "-"); ?>&nbsp;
							<div clas="warnadokrm" style="width:10px;height:10px;background-color:<?php echo "#". isset($model->warnadok->warnadokrm_kodewarna) ? $model->warnadok->warnadokrm_kodewarna : ""; ?>">
							
							</div>
						</td>
					</tr>
					<tr>
						<td width="11%" style="text-align:right;">Sub Rak</td><td width="2%">:</td>
						<td width="37%">
							<?php echo CHtml::encode(isset($model->subrak_id) ? $model->subrak->subrak_nama : "-"); ?>
						</td>
						<td width="11%" style="text-align:right;">Tgl. Masuk Rak</td><td width="2%">:</td>
						<td width="37%">
							<?php echo CHtml::encode(isset($model->tglmasukrak) ? MyFormatter::formatDateTimeForUser($model->tglmasukrak) : "-"); ?>
						</td>
					</tr>
					<tr>
						<td width="11%" style="text-align:right;">Lokasi Rak</td><td width="2%">:</td>
						<td width="37%">
							<?php echo CHtml::encode(isset($model->lokasirak_id) ? $model->lokasirak->lokasirak_nama : "-"); ?>
						</td>
						<td width="11%" style="text-align:right;">Tgl. Keluar Akhir</td><td width="2%">:</td>
						<td width="37%">
							<?php echo CHtml::encode(isset($model->tglkeluarakhir) ? MyFormatter::formatDateTimeForUser($model->tglkeluarakhir) : "-"); ?>
						</td>
					</tr>
					<tr>
						<td width="11%" style="text-align:right;">Nomor Tertier</td><td width="2%">:</td>
						<td width="37%">
							<?php echo CHtml::encode(isset($model->nomortertier) ? $model->nomortertier : "-"); ?>
						</td>
						<td width="11%" style="text-align:right;">Tgl. Masuk Akhir</td><td width="2%">:</td>
						<td width="37%">
							<?php echo CHtml::encode(isset($model->tglmasukakhir) ? MyFormatter::formatDateTimeForUser($model->tglmasukakhir) : "-"); ?>
						</td>
					</tr>
					<tr>
						<td width="11%" style="text-align:right;">Nomor Sekunder</td><td width="2%">:</td>
						<td width="37%">
							<?php echo CHtml::encode(isset($model->nomorsekunder) ? $model->nomorsekunder : "-"); ?>
						</td>
						<td width="11%" style="text-align:right;">Nomor Primer</td><td width="2%">:</td>
						<td width="37%">
							<?php echo CHtml::encode(isset($model->nomorprimer) ? $model->nomorprimer : "-"); ?>
						</td>
					</tr>
					<tr>
						<td width="11%" style="text-align:right;">Tgl. In Aktif</td><td width="2%">:</td>
						<td width="37%">
							<?php echo CHtml::encode(isset($model->tgl_in_aktif) ? MyFormatter::formatDateTimeForUser($model->tgl_in_aktif) : "-"); ?>
						</td>
						<td width="11%" style="text-align:right;">Tgl. Pemusnahan</td><td width="2%">:</td>
						<td width="37%">
							<?php echo CHtml::encode(isset($model->tglpemusnahan) ? MyFormatter::formatDateTimeForUser($model->tglpemusnahan) : "-"); ?>
						</td>
					</tr>
				</table>
			</td>
		</tr>
	</table>
</div>