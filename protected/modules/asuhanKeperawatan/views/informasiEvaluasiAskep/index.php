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
	<legend class="rim2">Informasi <b>Evaluasi Keperawatan</b></legend>
 <div class="block-tabel">
	<h6>Tabel <b>Evaluasi Keperawatan</b></h6>
		<?php $this->widget('bootstrap.widgets.BootAlert'); ?>
		<?php $this->widget('ext.bootstrap.widgets.BootGridView',array(
			'id'=>'informasiasuhankeperawatan-grid',
			'dataProvider'=>$model->searchInformasiEval(),
			'template'=>"{summary}\n{items}\n{pager}",
			'itemsCssClass'=>'table table-striped table-bordered table-condensed',
			'columns'=>array(
				array(
					'header'=>'No. Evaluasi',
					'type'=>'raw',
					'value'=>'$data->no_evaluasi',
				),
				array(
					'header'=>'Tanggal Evaluasi',
					'type'=>'raw',
					'value'=>'MyFormatter::formatDateTimeForUser($data->evaluasiaskep_tgl)',
				),
				array(
					'header'=>'No. Pendaftaran',
					'name'=>'no_pendaftaran',
					'type'=>'raw',
					'value'=>'$data->no_pendaftaran',
				),
				array(
					'header'=>'Nama Pasien',
					'type'=>'raw',
					'value'=>'$data->nama_pasien',
				),
				array(
					'header'=>'Jenis Kelamin',
					'type'=>'raw',
					'value'=>'$data->ruangan_nama',
				),
				array(
					'header'=>'Nama Perawat',
					'type'=>'raw',
					'value'=>'$data->nama_pegawai',
				),
				array(
					'header'=>'Ruangan',
					'name'=>'ruangan_nama',
					'type'=>'raw',
					'value'=>'$data->ruangan_nama',
				),
				array(
					'header'=>'Kelas Pelayanan',
					'name'=>'umur',
					'type'=>'raw',
					'value'=>'$data->kelaspelayanan_nama',
				),
				array(
					'header'=>'Lihat Detail',
					'type'=>'raw',
					'value'=>'CHtml::link("<i class=\'icon-form-detail\'></i> ",  Yii::app()->controller->createUrl("/asuhanKeperawatan/InformasiEvaluasiAskep/Detail",array("evaluasiaskep_id"=>$data->evaluasiaskep_id)),array("target"=>"frameDetail","rel"=>"tooltip","title"=>"Klik untuk Detail Evaluasi Keperawatan", "onclick"=>"window.parent.$(\'#dialogDetail\').dialog(\'open\')"));','htmlOptions'=>array('style'=>'text-align: center; width:40px')
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
<?php
//========= Dialog untuk Melihat detail Pemakaian Barang =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogDetail',
    'options' => array(
        'title' => 'Detail Evaluasi Keperawatan',
        'autoOpen' => false,
        'modal' => true,
        'width' => 900,
        'height' => 600,
        'resizable' => false,
    ),
));

echo '<iframe src="" name="frameDetail" width="100%" height="500">
</iframe>';

$this->endWidget();
?>