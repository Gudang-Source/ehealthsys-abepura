<table width="100%">
        <tr>
            <td style="text-align:center;" align="center"><b>EVALUASI KEPERAWATAN</b></td>
        </tr>
</table>
<div class="white-container">
	<div class="row-fluid">
		<table width="100%">
			<tr>
				<td ><p>No. Evaluasi :</p></td>
				<td ><p><?php echo isset($model->no_evaluasi) ? $model->no_evaluasi : "-"; ?></p></td>
				<td ><p>Tanggal Evaluasi :</p></td>
				<td ><p><?php echo isset($model->evaluasiaskep_tgl) ? MyFormatter::FormatDateTimeForUser($model->evaluasiaskep_tgl) : "-"; ?></p></td>
				<td ><p>Nama Perawat :</p></td>
				<td ><p><?php echo isset($model->nama_pegawai) ? $model->nama_pegawai : "-"; ?></p></td>
			</tr>
		</table>
	</div>
	<div class="row-fluid">
		<fieldset class="box">
			<legend class="rim">Data Implementasi</legend>
			<table width="100%">
				<tr>
					<td ><p>No. Implementasi :</p></td>
					<td ><p><?php echo isset($modImpl->no_implementasi) ? $modImpl->no_implementasi : "-"; ?></p></td>
					<td ><p>Tanggal Implementasi :</p></td>
					<td ><p><?php echo isset($modImpl->implementasiaskep_tgl) ? MyFormatter::FormatDateTimeForUser($modImpl->implementasiaskep_tgl) : "-"; ?></p></td>
					<td ><p>Nama Perawat :</p></td>
					<td ><p><?php echo isset($modImpl->nama_pegawai) ? $modImpl->nama_pegawai : "-"; ?></p></td>
				</tr>
			</table>
		</fieldset>
	</div>
	<div class="row-fluid">
		<fieldset class="box">
			<legend class="rim">Identitas Pasien</legend>
			<table width="100%">
				<tr>
					<td ><p>No. Pendaftaran :</p></td>
					<td ><p><?php echo isset($modPasien->no_pendaftaran) ? $modPasien->no_pendaftaran : "-"; ?></p></td>
					<td ><p>Nama Pasien :</p></td>
					<td ><p><?php echo isset($modPasien->nama_pasien) ? $modPasien->nama_pasien : "-"; ?></p></td>
					<td ><p>Ruangan :</p></td>
					<td ><p><?php echo isset($modPasien->ruangan_nama) ? $modPasien->ruangan_nama : "-" ?></p></td>
				</tr>
				<tr>
					<td ><p>Tanggal Pendaftaran :</p></td>
					<td ><p><?php echo isset($modPasien->tgl_pendaftaran) ? MyFormatter::formatDateTimeForUser($modPasien->tgl_pendaftaran) : "-"; ?></p></td>
					<td ><p>Umur :</p></td>
					<td ><p><?php echo isset($modPasien->umur) ? $modPasien->umur : "-"; ?></p></td>
					<td ><p>Kelas :</p></td>
					<td ><p><?php echo isset($modPasien->kelaspelayanan_nama) ? $modPasien->kelaspelayanan_nama : "-" ?></p></td>
				</tr>
				<tr>
					<td ><p>No Rekam Medik:</p></td>
					<td ><p><?php echo isset($modPasien->no_rekam_medik) ? $modPasien->no_rekam_medik : "-"; ?></p></td>
					<td ><p>Diagnosa Medik Masuk :</p></td>
					<td ><p><?php echo isset($modPasien->diagnosa_nama) ? $modPasien->diagnosa_nama : "-"; ?></p></td>
					<td ><p>No Kamar / No Bed :</p></td>
					<td ><p><?php echo (isset($modPasien->kamarruangan_nokamar) ? $modPasien->kamarruangan_nokamar : "-") . ' / ' . (isset($modPasien->kamarruangan_nobed) ? $modPasien->kamarruangan_nobed : "-"); ?></p></td>
				</tr>
			</table>
		</fieldset>
	</div>
	<div class="row-fluid">
		<fieldset class="box">
			<legend class="rim">Evaluasi Keperawatan</legend>
			<div class='block-tabel'>
				<?php
				$this->widget('ext.bootstrap.widgets.BootGridView', array(
					'id' => 'evaluasi-grid',
					'enableSorting' => false,
					'template' => "{items}",
					'dataProvider' => $modDetail,
					'itemsCssClass' => 'table table-striped table-bordered table-condensed',
					'columns' => array(
						array(
							'header' => 'Diagnosa Keperawatan',
							'name' => 'diagnosakep_nama',
							'value' => '$data->diagnosakep->diagnosakep_nama'
						),
						array(
							'header' => 'Subjektif',
							'name' => 'evaluasiaskepdet_subjektif',
							'value' => '$data->evaluasiaskepdet_subjektif'
						),
						array(
							'header' => 'Objektif',
							'name' => 'evaluasiaskepdet_objektif',
							'value' => '$data->evaluasiaskepdet_objektif'
						),
						array(
							'header' => 'Assessment',
							'name' => 'evaluasiaskepdet_assessment',
							'value' => '$data->evaluasiaskepdet_assessment'
						),
						array(
							'header' => 'Planning',
							'name' => 'evaluasiaskepdet_planning',
							'value' => '$data->evaluasiaskepdet_planning'
						),
						array(
							'header' => 'Hasil',
							'name' => 'evaluasiaskepdet_hasil',
							'value' => '$data->evaluasiaskepdet_hasil'
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
			echo CHtml::htmlButton(Yii::t('mds', '{icon} PDF', array('{icon}' => '<i class="icon-book icon-white"></i>')), array('class' => 'btn btn-primary', 'type' => 'button', 'onclick' => 'print(\'PDF\')')) . "&nbsp&nbsp";
			echo CHtml::htmlButton(Yii::t('mds', '{icon} Excel', array('{icon}' => '<i class="icon-pdf icon-white"></i>')), array('class' => 'btn btn-primary', 'type' => 'button', 'onclick' => 'print(\'EXCEL\')')) . "&nbsp&nbsp";
			echo CHtml::htmlButton(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="icon-print icon-white"></i>')), array('class' => 'btn btn-primary', 'type' => 'button', 'onclick' => 'print(\'PRINT\')')) . "&nbsp&nbsp";
		?>
		<?php
		$controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
		$module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
		$urlPrint = Yii::app()->createAbsoluteUrl($module . '/' . $controller . '/printDetail');
		$url = Yii::app()->createAbsoluteUrl($module . '/' . $controller);

		$js = <<< JSCRIPT

function print(caraPrint)
{
    window.open("${urlPrint}/&evaluasiaskep_id="+$model->evaluasiaskep_id+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
}
JSCRIPT;
		Yii::app()->clientScript->registerScript('print', $js, CClientScript::POS_HEAD);
		?>
    </div>