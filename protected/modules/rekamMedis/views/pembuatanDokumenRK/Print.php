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
<div style="margin-top: 20px;">
	<h5 style="text-align: center;">Data Pasien</h5>
        <table width="100%" style="margin:0px;" cellpadding="0" cellspacing="0">
            <tr>
                    <td width="20%">No. Rekam Medik</td><td>:</td>
                    <td width="30%">
                            <?php echo CHtml::encode($modPasien->no_rekam_medik); ?>
                    </td>
                    <td width="20%">Tgl. Rekam Medis</td><td>:</td>
                    <td width="30%" >
                            <?php echo CHtml::encode(isset($modPasien->tgl_rekam_medik) ? MyFormatter::formatDateTimeForUser($modPasien->tgl_rekam_medik) : "-"); ?>
                    </td>
            </tr>
            <tr>
                    <td>Nama Pasien</td><td>:</td>
                    <td>
                            <?php echo CHtml::encode($modPasien->nama_pasien); ?>
                    </td>
                    <td>Jenis Kelamin</td><td>:</td>
                    <td>
                            <?php echo CHtml::encode(isset($modPasien->jeniskelamin) ? $modPasien->jeniskelamin : "-"); ?>
                    </td>
            </tr>
            <tr>
                    <td>Tempat, Tgl. Lahir</td><td>:</td>
                    <td>
                            <?php echo CHtml::encode($modPasien->tempat_lahir). " / ". CHtml::encode(isset($modPasien->tanggal_lahir) ? MyFormatter::formatDateTimeForUser($modPasien->tanggal_lahir) : null); ?>
                    </td>
                    <td>Alamat</td><td>:</td>
                    <td>
                            <?php echo CHtml::encode(isset($modPasien->alamat_pasien) ? $modPasien->alamat_pasien : "-"); ?>
                    </td>
            </tr>
        </table><hr/>
	<h5 style="text-align: center">Data Pembuatan Dokumentasi Rekam Medis</h5>
	<table width="100%" style="margin:0px;" cellpadding="0" cellspacing="0">
		<tr>
                        <td width="20%">No. Dokumen</td><td>:</td>
                        <td width="30%">
                                <?php echo CHtml::encode($model->nodokumenrm); ?>
                        </td>
                        <td width="20%">Tgl. Masuk Rak</td><td>:</td>
                        <td width="30%">
                                <?php echo CHtml::encode(isset($model->tglmasukrak) ? MyFormatter::formatDateTimeForUser($model->tglmasukrak) : "-"); ?>
                        </td>
                </tr>
                <tr>
                        <td>Warna Dokumen RK</td><td>:</td>
                        <td>
                                <?php echo CHtml::encode(isset($model->warnadokrm_id) ? $model->warnadok->warnadokrm_namawarna : "-"); ?>&nbsp;
                                <div hidden class="warnadokrm" style="width:10px;height:10px;background-color:<?php echo "#". isset($model->warnadok->warnadokrm_kodewarna) ? $model->warnadok->warnadokrm_kodewarna : ""; ?>">

                                </div>
                        </td>
                        <td>Tgl. Keluar Akhir</td><td>:</td>
                        <td>
                                <?php echo CHtml::encode(isset($model->tglkeluarakhir) ? MyFormatter::formatDateTimeForUser($model->tglkeluarakhir) : "-"); ?>
                        </td>
                </tr>
                <tr>
                        <td>Lokasi Rak</td><td>:</td>
                        <td>
                                <?php echo CHtml::encode(isset($model->lokasirak_id) ? $model->lokasirak->lokasirak_nama : "-"); ?>
                        </td>
                        <td>Tgl. Masuk Akhir</td><td>:</td>
                        <td>
                                <?php echo CHtml::encode(isset($model->tglmasukakhir) ? MyFormatter::formatDateTimeForUser($model->tglmasukakhir) : "-"); ?>
                        </td>
                </tr>
                <tr>
                        <td>Sub Rak</td><td>:</td>
                        <td>
                                <?php echo CHtml::encode(isset($model->subrak_id) ? $model->subrak->subrak_nama : "-"); ?>
                        </td>
                        <td>Tgl. Pemusnahan</td><td>:</td>
                        <td>
                                <?php echo CHtml::encode(isset($model->tglpemusnahan) ? MyFormatter::formatDateTimeForUser($model->tglpemusnahan) : "-"); ?>
                        </td>
                </tr>
                <tr>
                        <td>Nomor Tertier</td><td>:</td>
                        <td>
                                <?php echo CHtml::encode(isset($model->nomortertier) ? $model->nomortertier : "-"); ?>
                        </td>
                </tr>
                <tr>
                        <td>Nomor Sekunder</td><td>:</td>
                        <td>
                                <?php echo CHtml::encode(isset($model->nomorsekunder) ? $model->nomorsekunder : "-"); ?>
                        </td>
                </tr>
                <tr>
                        <td>Nomor Primer</td><td>:</td>
                        <td>
                                <?php echo CHtml::encode(isset($model->nomorprimer) ? $model->nomorprimer : "-"); ?>
                        </td>
                </tr>
	</table>
</div>