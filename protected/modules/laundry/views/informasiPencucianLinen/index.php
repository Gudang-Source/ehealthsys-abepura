<div class="white-container">
<?php
Yii::app()->clientScript->registerScript('search', "
$('#pencucianlinen-info-search').submit(function(){
	$('#informasipencucianlinen-grid').addClass('animation-loading');
	$.fn.yiiGridView.update('informasipencucianlinen-grid', {
			data: $(this).serialize()
	});
	return false;
});
");
?>
	<legend class="rim2">Informasi Pencucian <b>Linen</b></legend>
 <div class="block-tabel">
	<h6>Tabel <b>Pencucian Linen</b></h6>
		<?php $this->widget('bootstrap.widgets.BootAlert'); ?>
		<?php $this->widget('ext.bootstrap.widgets.BootGridView',array(
			'id'=>'informasipencucianlinen-grid',
			'dataProvider'=>$model->searchInformasi(),
			'template'=>"{summary}\n{items}\n{pager}",
			'itemsCssClass'=>'table table-striped table-bordered table-condensed',
			'columns'=>array(
				array(
					'header'=>'No. Pencucian',
					'type'=>'raw',
					'value'=>'$data->nopencucianlinen',
				),
				array(
					'header'=>'Tanggal Pencucian',
					'type'=>'raw',
					'value'=>'MyFormatter::formatDateTimeForUser($data->tglpencucianlinen)',
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
					'name'=>'keterangan_perawatan',
					'type'=>'raw',
					'value'=>'$data->keterangan_pencucianlinen',
				),
				array(
					'header'=>'Lihat Detail',
					'type'=>'raw',
					'value'=>'CHtml::link("<i class=\'icon-form-lihat\'></i> ",  Yii::app()->controller->createUrl("/laundry/informasiPencucianLinen/detail",array("id"=>$data->pencucianlinen_id)),array("target"=>"frameDetail","rel"=>"tooltip","title"=>"Klik untuk Detail Pencucian Linen Linen", "onclick"=>"window.parent.$(\'#dialogDetail\').dialog(\'open\')"));',    'htmlOptions'=>array('style'=>'text-align: center; width:40px')
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
        'title' => 'Detail Pencucian Linen',
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