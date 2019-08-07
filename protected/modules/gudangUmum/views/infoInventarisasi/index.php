<div class="white-container">
<?php
Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('infoinvbarang-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>
<legend class="rim2">Informasi  Inventarisasi Barang</legend>
 <div class="block-tabel">
	<h6>Tabel <b>Inventarisasi Barang</b></h6>
		<?php $this->widget('bootstrap.widgets.BootAlert'); ?>
		<?php $this->widget('ext.bootstrap.widgets.BootGridView',array(
			'id'=>'infoinvbarang-grid',
			'dataProvider'=>$model->searchInformasi(),
			'template'=>"{summary}\n{items}\n{pager}",
			'itemsCssClass'=>'table table-striped table-bordered table-condensed',
			'columns'=>array(
				array(
					'header'=>'No.',
					'value' => '($this->grid->dataProvider->pagination) ? 
							($this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1)
							: ($row+1)',
					'type'=>'raw',
					'htmlOptions'=>array('style'=>'text-align:center;'),
					'headerHtmlOptions'=>array('style'=>'text-align:center;'),
				),
				array (
					'header'=>'Tanggal Inventarisasi',
					'name'=>'invbarang_tgl',
					'type'=>'raw',
					'value'=>'MyFormatter::formatDateTimeForUser($data->invbarang_tgl)',
					'headerHtmlOptions'=>array('style'=>'text-align:center;'),
				),
				array (
					'header'=>'No. Inventarisasi',
					'name'=>'invbarang_no',
					'type'=>'raw',
					'value'=>'$data->invbarang_no',
					'headerHtmlOptions'=>array('style'=>'text-align:center;'),
				),
				array (
					'header'=>'Tanggal Formulir',
					'type'=>'raw',
					'value'=>'MyFormatter::formatDateTimeForUser($data->forminvbarang_tgl)',
					'headerHtmlOptions'=>array('style'=>'text-align:center;'),
				),
				array (
					'header'=>'No. Formulir',
					'name'=>'forminvbarang_no',
					'type'=>'raw',
					'value'=>'$data->forminvbarang_no',
					'headerHtmlOptions'=>array('style'=>'text-align:center;'),
				),
//				array (
//					'header'=>'Jenis Inventarisasi',
//					'name'=>'invbarang_jenis',
//					'type'=>'raw',
//					'value'=>'$data->invbarang_jenis'
//				),
				array(
				  'header'=>'Total HPP (Rp)',
				  'type'=>'raw',
				  'value'=>'MyFormatter::formatNumberForPrint($data->invbarang_totalnetto)',
                                  'htmlOptions'=>array(
                                      'style'=>'text-align: right',
                                  ),
					'headerHtmlOptions'=>array('style'=>'text-align:center;'),
				),
				array(
					'header'=>'Detail Inventarisasi',
					'type'=>'raw',
					'value'=>'CHtml::Link("<i class=\"icon-form-formulir\"></i>","'.$this->getUrlPrint().'&invbarang_id=$data->invbarang_id&frame=true",
						array("class"=>"", 
							"target"=>"inventarisasi",
							"onclick"=>"$(\"#dialogInventarisasi\").dialog(\"open\");",
							"rel"=>"tooltip",
							"title"=>"Klik untuk melihat detail formulir",
						))',
					'htmlOptions'=>array('style'=>'text-align:center;'),
					'headerHtmlOptions'=>array('style'=>'text-align:center;'),
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
    'id' => 'dialogInventarisasi',
    'options' => array(
        'title' => 'Detail Inventarisasi Barang',
        'autoOpen' => false,
        'modal' => true,
        'width' => 750,
        'height' => 600,
        'resizable' => false,
    ),
));

echo '<iframe src="" name="inventarisasi" width="100%" height="500">
</iframe>';

$this->endWidget();
?>