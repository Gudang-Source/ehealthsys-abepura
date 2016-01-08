<div class="white-container">
<?php
Yii::app()->clientScript->registerScript('search', "
$('#penyimpananlinen-info-search').submit(function(){
	$('#informasipenyimpananlinen-grid').addClass('animation-loading');
	$.fn.yiiGridView.update('informasipenyimpananlinen-grid', {
			data: $(this).serialize()
	});
	return false;
});
");
?>
	<legend class="rim2">Informasi Penyimpanan <b>Linen</b></legend>
 <div class="block-tabel">
	<h6>Tabel <b>Penyimpanan Linen</b></h6>
		<?php $this->widget('bootstrap.widgets.BootAlert'); ?>
		<?php $this->widget('ext.bootstrap.widgets.BootGridView',array(
			'id'=>'informasipenyimpananlinen-grid',
			'dataProvider'=>$model->searchInformasi(),
			'template'=>"{summary}\n{items}\n{pager}",
			'itemsCssClass'=>'table table-striped table-bordered table-condensed',
			'columns'=>array(
				array(
					'header'=>'No. Penyimpanan',
					'type'=>'raw',
					'value'=>'$data->nopenyimpamanlinen',
				),
				array(
					'header'=>'Tanggal Penyimpanan',
					'type'=>'raw',
					'value'=>'MyFormatter::formatDateTimeForUser($data->tglpenyimpananlinen)',
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
					'name'=>'keterangan_penyimpanan',
					'type'=>'raw',
					'value'=>'$data->keterangan_penyimpanan',
				),
				array(
					'header'=>'Lihat Detail',
					'type'=>'raw',
					'value'=>'CHtml::link("<i class=\'icon-form-lihat\'></i> ",  Yii::app()->controller->createUrl("/laundry/informasiPenyimpananLinen/detail",array("id"=>$data->penyimpananlinen_id)),array("target"=>"frameDetail","rel"=>"tooltip","title"=>"Klik untuk Detail Penyimpanan Linen Linen", "onclick"=>"window.parent.$(\'#dialogDetail\').dialog(\'open\')"));',    'htmlOptions'=>array('style'=>'text-align: center; width:40px')
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
        'title' => 'Detail Penyimpanan Linen',
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