<div class="white-container">
<?php
Yii::app()->clientScript->registerScript('search', "
$('#pengirimanlinen-info-search').submit(function(){
	$('#informasipengirimanlinen-grid').addClass('animation-loading');
	$.fn.yiiGridView.update('informasipengirimanlinen-grid', {
			data: $(this).serialize()
	});
	return false;
});
");
?>
	<legend class="rim2">Informasi Pengiriman <b>Linen</b></legend>
 <div class="block-tabel">
	<h6>Tabel <b>Pengiriman Linen</b></h6>
		<?php $this->widget('bootstrap.widgets.BootAlert'); ?>
		<?php $this->widget('ext.bootstrap.widgets.BootGridView',array(
			'id'=>'informasipengirimanlinen-grid',
			'dataProvider'=>$model->searchInformasi(),
			'template'=>"{summary}\n{items}\n{pager}",
			'itemsCssClass'=>'table table-striped table-bordered table-condensed',
			'columns'=>array(
                                array(
					'header'=>'Tanggal Pengiriman',
					'type'=>'raw',
					'value'=>'MyFormatter::formatDateTimeForUser($data->tglpengirimanlinen)',
				),
				array(
					'header'=>'No. Pengiriman',
					'type'=>'raw',
					'value'=>'$data->nopengirimanlinen',
				),				
				array(
					'header'=>'Instalasi <br> / Ruangan Tujuan',
					'type'=>'raw',
					'value'=>'$data->ruangan->instalasi->instalasi_nama." <br> / ".$data->ruangan->ruangan_nama',
				),	
                                array(
                                    'header' => 'Pegawai Pengirim',
                                    'value' => '$data->pegpengirim->namaLengkap',
                                ),
				array(
					'name'=>'keterangan_pengiriman',
					'type'=>'raw',
					'value'=>'$data->keterangan_pengiriman',
				),
				array(
					'header'=>'Lihat Detail',
					'type'=>'raw',
					'value'=>'CHtml::link("<i class=\'icon-form-lihat\'></i> ",  Yii::app()->controller->createUrl("/laundry/informasiPengirimanLinen/detail",array("id"=>$data->pengirimanlinen_id)),array("target"=>"frameDetail","rel"=>"tooltip","title"=>"Klik untuk Detail Pengiriman Linen Linen", "onclick"=>"window.parent.$(\'#dialogDetail\').dialog(\'open\')"));',    'htmlOptions'=>array('style'=>'text-align: center; width:40px')
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
        'title' => 'Detail Pengiriman Linen',
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