<table width="100%">
        <tr>
            <td style="text-align:center;" align="center"><b>PENGKAJIAN KEPERAWATAN</b></td>
        </tr>
</table>
<div class="white-container">
	<div class="row-fluid">
		<table width="100%">
			<tr>
				<td ><p>No. Pengkajian :</p></td>
				<td ><p><?php echo isset($modPengkajian->no_pengkajian) ? $modPengkajian->no_pengkajian : "-"; ?></p></td>
				<td ><p>Tanggal Pengkajian :</p></td>
				<td ><p><?php echo isset($modPengkajian->pengkajianaskep_tgl) ? MyFormatter::FormatDateTimeForUser($modPengkajian->pengkajianaskep_tgl) : "-"; ?></p></td>
				<td ><p>Nama Perawat :</p></td>
				<td ><p><?php echo isset($modPengkajian->nama_pegawai) ? $modPengkajian->nama_pegawai : "-"; ?></p></td>
			</tr>
		</table>
	</div>
	<div class="row-fluid">
		<fieldset class="box">
			<legend class="rim">Data Pasien</legend>
			<table width="100%">
				<tr>
					<td ><p>No. Pendaftaran :</p></td>
					<td ><p><?php echo isset($modPengkajian->no_pendaftaran) ? $modPengkajian->no_pendaftaran : "-"; ?></p></td>
					<td ><p>Jenis Kelamin :</p></td>
					<td ><p><?php echo isset($modPengkajian->jeniskelamin) ? $modPengkajian->jeniskelamin : "-"; ?></p></td>
					<td ><p>Ruangan :</p></td>
					<td ><p><?php echo isset($modPengkajian->ruangan_nama) ? $modPengkajian->ruangan_nama : "-" ?></p></td>
				</tr>
				<tr>
					<td ><p>Tanggal Pendaftaran :</p></td>
					<td ><p><?php echo isset($modPengkajian->tgl_pendaftaran) ? MyFormatter::FormatDateTimeForUser($modPengkajian->tgl_pendaftaran) : "-"; ?></p></td>
					<td ><p>Pekerjaan :</p></td>
					<td ><p><?php echo isset($modPengkajian->pekerjaan_nama) ? $modPengkajian->pekerjaan_nama : "-"; ?></p></td>
					<td ><p>Kelas :</p></td>
					<td ><p><?php echo isset($modPengkajian->kelaspelayanan_nama) ? $modPengkajian->kelaspelayanan_nama : "-" ?></p></td>
				</tr>
				<tr>
					<td ><p>No. Rekam Medik:</p></td>
					<td ><p><?php echo isset($modPengkajian->no_rekam_medik) ? $modPengkajian->no_rekam_medik : "-"; ?></p></td>
					<td ><p>Pendidikan :</p></td>
					<td ><p><?php echo isset($modPengkajian->pendidikan_nama) ? $modPengkajian->pendidikan_nama : "-"; ?></p></td>
					<td ><p>No Kamar / No Bed :</p></td>
					<td ><p><?php echo isset($modPengkajian->kamarruangan_nokamar) ? $modPengkajian->kamarruangan_nokamar : "-" . ' / ' . isset($modPengkajian->kamarruangan_nobed) ? $modPengkajian->kamarruangan_nobed : "-" ?></p></td>
				</tr>
				<tr>
					<td ><p>Nama Pasien :</p></td>
					<td ><p><?php echo isset($modPengkajian->nama_pasien) ? $modPengkajian->nama_pasien : "-"; ?></p></td>
					<td ><p>Agama :</p></td>
					<td ><p><?php echo isset($modPengkajian->agama) ? $modPengkajian->agama : "-"; ?></p></td>
					<td ><p>Diagnosa Medik Masuk :</p></td>
					<td ><p><?php echo isset($modPengkajian->diagnosa_nama) ? $modPengkajian->diagnosa_nama : "-" ?></p></td>
				</tr>
				<tr>
					<td ><p>Umur :</p></td>
					<td ><p><?php echo isset($modPengkajian->umur) ? $modPengkajian->umur : "-"; ?></p></td>
					<td ><p>Alamat :</p></td>
					<td ><p><?php echo isset($modPengkajian->alamat_pasien) ? $modPengkajian->alamat_pasien : "-"; ?></p></td>
				</tr>
				<tr>
					<td ><p>Status Perkawinan :</p></td>
					<td ><p><?php echo isset($modPengkajian->statusperkawinan) ? $modPengkajian->statusperkawinan : "-"; ?></p></td>
				</tr>
			</table>
		</fieldset>
	</div>
	<div class="row-fluid">
		<fieldset class="box">
			<legend class="rim">Data Penanggung Jawab</legend>
			<table width="100%">
				<tr>
					<td ><p>Nama :</p></td>
					<td ><p><?php echo isset($modPengkajian->nama_pj) ? $modPengkajian->nama_pj : "-"; ?></p></td>
					<td ><p>Tanggal Lahir :</p></td>
					<td ><p><?php echo isset($modPengkajian->tgllahir_pj) ? MyFormatter::FormatDateTimeForUser($modPengkajian->tgllahir_pj) : "-"; ?></p></td>
					<td ><p>Hubungan Dengan Klien :</p></td>
					<td ><p><?php echo isset($modPengkajian->hubungankeluarga) ? $modPengkajian->hubungankeluarga : "-" ?></p></td>
				</tr>
				<tr>
					<td ><p>No Identitas :</p></td>
					<td ><p><?php echo isset($modPengkajian->no_identitas) ? $modPengkajian->no_identitas : "-"; ?></p></td>
					<td ><p>No Telepon :</p></td>
					<td ><p><?php echo isset($modPengkajian->no_teleponpj) ? $modPengkajian->no_teleponpj : "-"; ?></p></td>
					<td ><p>Alamat :</p></td>
					<td ><p><?php echo isset($modPengkajian->alamat_pj) ? $modPengkajian->alamat_pj : "-" ?></p></td>
				</tr>
				<tr>
					<td ><p>Jenis Kelamin:</p></td>
					<td ><p><?php echo isset($modPengkajian->jk) ? $modPengkajian->jk : "-"; ?></p></td>
					<td ><p>No Mobile :</p></td>
					<td ><p><?php echo isset($modPengkajian->no_mobilepj) ? $modPengkajian->no_mobilepj : "-"; ?></p></td>
				</tr>
			</table>
		</fieldset>
	</div>
	<div class="row-fluid">
		<fieldset class="box">
			<legend class="rim">Data Anamnesa</legend>
			<?php $this->renderPartial('_detailAnamnesis', array('modAnamnesa' => $modAnamnesa)); ?>
		</fieldset>
	</div>
	<div class="row-fluid">
		<fieldset class="box">
			<legend class="rim">Data Pemeriksaan Fisik</legend>
			<?php $this->renderPartial('_detailFisik', array('modPemeriksaanFisik' => $modPemeriksaanFisik,'modPemeriksaanGambar' => $modPemeriksaanGambar,
			'modGambarTubuh' => $modGambarTubuh,
			'modBagianTubuh' => $modBagianTubuh,)); ?>
		</fieldset>
	</div>
	
	<div class="row-fluid">
		<fieldset class="box">
			<legend class="rim">Data Penunjang</legend>
			<div class='block-tabel'>
				<?php
				$this->widget('ext.bootstrap.widgets.BootGridView', array(
					'id' => 'penunjang-grid',
					'enableSorting' => false,
					'template' => "{items}",
					'dataProvider' => $modPenunjang,
					'itemsCssClass' => 'table table-striped table-bordered table-condensed',
					'columns' => array(
						array(
							'header' => 'Tanggal',
							'name' => 'datapenunjang_tgl',
							'value' => 'isset($data->datapenunjang_tgl) ? MyFormatter::FormatDateTimeForUser($data->datapenunjang_tgl) : " - "',
						),
						array(
							'header' => 'Data Penunjang',
							'name' => 'datapenunjang_nama',
							'value' => '$data->datapenunjang_nama'
						)
					),
					'afterAjaxUpdate' => 'function(id, data){
                jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});
                $("table").find("input[type=text]").each(function(){
                    cekForm(this);
                })
                 $("table").find("select").each(function(){
                    cekForm(this);
                })
            }',
				));
				?>
			</div>
		</fieldset>
	</div>
</div>
<div class="form-actions">
		<?php
		
			echo "&nbsp;&nbsp;";
			//echo CHtml::htmlButton(Yii::t('mds', '{icon} PDF', array('{icon}' => '<i class="icon-book icon-white"></i>')), array('class' => 'btn btn-primary', 'type' => 'button', 'onclick' => 'print(\'PDF\')')) . "&nbsp&nbsp";
			//echo CHtml::htmlButton(Yii::t('mds', '{icon} Excel', array('{icon}' => '<i class="icon-pdf icon-white"></i>')), array('class' => 'btn btn-primary', 'type' => 'button', 'onclick' => 'print(\'EXCEL\')')) . "&nbsp&nbsp";
			echo CHtml::htmlButton(Yii::t('mds', '{icon} Cetak', array('{icon}' => '<i class="entypo-print"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'PRINT\')')) . "&nbsp&nbsp";
		?>
		<?php
		$controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
		$module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
		$urlPrint = Yii::app()->createAbsoluteUrl($module . '/' . $controller . '/printDetail');
		$url = Yii::app()->createAbsoluteUrl($module . '/' . $controller);

		$js = <<< JSCRIPT

function print(caraPrint)
{
    window.open("${urlPrint}/&pengkajianaskep_id="+$modPengkajian->pengkajianaskep_id+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
}
JSCRIPT;
		Yii::app()->clientScript->registerScript('print', $js, CClientScript::POS_HEAD);
		?>
    </div>