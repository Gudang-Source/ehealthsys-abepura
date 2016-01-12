<div class="white-container">
<?php
Yii::app()->clientScript->registerScript('search', "
$('#penerimaanperalatanlinen-info-search').submit(function(){
	$('#informasipenerimaanperalatanlinen-grid').addClass('animation-loading');
	$.fn.yiiGridView.update('informasipenerimaanperalatanlinen-grid', {
			data: $(this).serialize()
	});
	return false;
});
");
?>
	<legend class="rim2">Informasi <b>Penerimaan Peralatan Linen Steril</b></legend>
 <div class="block-tabel">
	<h6>Tabel <b>Penerimaan Peralatan Linen Steril</b></h6>
		<?php $this->widget('bootstrap.widgets.BootAlert'); ?>
		<?php $this->widget('ext.bootstrap.widgets.BootGridView',array(
			'id'=>'informasipenerimaanperalatanlinen-grid',
			'dataProvider'=>$model->searchInformasi(),
			'template'=>"{summary}\n{items}\n{pager}",
			'itemsCssClass'=>'table table-striped table-bordered table-condensed',
			'columns'=>array(
				array(
					'header'=>'No. Penerimaan',
					'type'=>'raw',
					'value'=>'$data->terimaperlinensteril_no',
				),
				array(
					'header'=>'Tanggal Penerimaan',
					'type'=>'raw',
					'value'=>'MyFormatter::formatDateTimeForUser($data->terimaperlinensteril_tgl)',
				),
				array(
					'header'=>'Instalasi',
					'type'=>'raw',
					'value'=>'$data->ruangan->instalasi->instalasi_nama',
				),
				array(
					'header'=>'Ruangan',
					'type'=>'raw',
					'value'=>'$data->ruangan->ruangan_nama',
				),
				array(
					'header'=>'Keterangan',
					'type'=>'raw',
					'value'=>'$data->terimaperlinensteril_ket',
				),
				array(
					'header'=>'Pegawai Pengirim',
					'name'=>'pegawaimenerima_nama',
					'type'=>'raw',
					'value'=>'$data->pegawaiMenerima->NamaLengkap',
				),
				array(
					'header'=>'Lihat Detail',
					'type'=>'raw',
					'value'=>'CHtml::link("<i class=\'icon-form-lihat\'></i> ",  Yii::app()->controller->createUrl("/sterilisasi/informasiPenerimaanPeralatanLinenSteril/detail",array("terimaperlinensteril_id"=>$data->terimaperlinensteril_id)),array("target"=>"frameDetail","rel"=>"tooltip","title"=>"Klik untuk Detail Sterilisasi Linen Linen", "onclick"=>"window.parent.$(\'#dialogDetail\').dialog(\'open\')"));',    'htmlOptions'=>array('style'=>'text-align: center; width:40px')
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
        'title' => 'Detail Sterilisasi',
        'autoOpen' => false,
        'modal' => true,
        'width' => 750,
        'height' => 600,
        'resizable' => false,
    ),
));

echo '<iframe src="" name="frameDetail" width="100%" height="500">
</iframe>';

$this->endWidget();
?>