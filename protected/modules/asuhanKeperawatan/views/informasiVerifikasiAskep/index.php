<div class="white-container">
<?php
Yii::app()->clientScript->registerScript('search', "
$('#pengkajiankeperawatan-info-search').submit(function(){
	$('#informasiasuhankeperawatan-grid').addClass('animation-loading');
	$.fn.yiiGridView.update('informasiasuhankeperawatan-grid', {
			data: $(this).serialize()
	});
	return false;
});
");
?>
	<legend class="rim2">Informasi <b>Verifikasi Keperawatan</b></legend>
 <div class="block-tabel">
	<h6>Tabel <b>Verifikasi Keperawatan</b></h6>
		<?php $this->widget('bootstrap.widgets.BootAlert'); ?>
		<?php $this->widget('ext.bootstrap.widgets.BootGridView',array(
			'id'=>'informasiasuhankeperawatan-grid',
			'dataProvider'=>$model->searchInformasiVerif(),
			'template'=>"{summary}\n{items}\n{pager}",
			'itemsCssClass'=>'table table-striped table-bordered table-condensed',
			'columns'=>array(
				array(
					'header'=>'Tanggal Pendaftaran',
					'type'=>'raw',
					'value'=>'MyFormatter::formatDateTimeForUser($data->tgl_pendaftaran)',
				),
				array(
					'header'=>'No. Pendaftaran / Rekam Medik',
					'type'=>'raw',
					'value'=>'$data->no_pendaftaran." / ".$data->no_rekam_medik',
				),
				array(
					'header'=>'Nama Pasien',
					'type'=>'raw',
					'value'=>'$data->nama_pasien',
				),
				array(
					'header'=>'Ruangan',
					'type'=>'raw',
					'value'=>'$data->ruangan_nama',
				),
				array(
					'header'=>'Kelas Pelayanan',
					'type'=>'raw',
					'value'=>'$data->kelaspelayanan_nama',
				),
				array(
					'header'=>'No. Kamar / No. Bed',
					'type'=>'raw',
					'value'=>'$data->kamarruangan_nokamar." / ".$data->kamarruangan_nobed',
				),
				array(
					'header'=>'Tanggal Verifikasi',
					'type'=>'raw',
					'value'=>'MyFormatter::formatDateTimeForUser($data->verifikasiaskep_tgl)',
				),
				array(
					'header'=>'No. Verifikasi',
					'name'=>'verifikasiaskep_no',
					'type'=>'raw',
					'value'=>'$data->verifikasiaskep_no',
				),
				array(
					'header'=>'Petugas Verifikasi',
					'name'=>'petugasverifikasi_nama',
					'type'=>'raw',
					'value'=>'$data->petugasverifikasi_nama',
				),
				array(
					'header'=>'Mengetahui',
					'name'=>'mengetahui_nama',
					'type'=>'raw',
					'value'=>'$data->mengetahui_nama',
				),
				array(
					'header'=>'Keterangan',
					'name'=>'verifikasiaskep_ket',
					'type'=>'raw',
					'value'=>'$data->verifikasiaskep_ket',
				),
				array(
					'header'=>'Status',
					'name'=>'verifikasiaskep_status',
					'type'=>'raw',
					'value'=>'$data->verifikasiaskep_status',
				),
			),
			'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
		)); ?>
 </div>
<fieldset class="box search-form">
	<?php $this->renderPartial($this->path_view.'_search',array(
		'model'=>$model,'format'=>$format
	)); ?>
</fieldset><!-- search-form -->
