<div class="white-container">
<?php
Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('infoformulirinvbarang-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>
<legend class="rim2">Informasi Formulir Inventarisasi Barang</legend>
 <div class="block-tabel">
	<h6>Tabel <b>Formulir Inventarisasi Barang</b></h6>
		<?php $this->widget('bootstrap.widgets.BootAlert'); ?>
		<?php $this->widget('ext.bootstrap.widgets.BootGridView',array(
			'id'=>'infoformulirinvbarang-grid',
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
				),
				array (
					'name'=>'forminvbarang_tgl',
					'type'=>'raw',
					'value'=>'MyFormatter::formatDateTimeForUser($data->forminvbarang_tgl)'
				),
				'forminvbarang_no',
				'forminvbarang_totalvolume',
				array(
				  'header'=>'Total Harga',
				  'type'=>'raw',
				  'value'=>'MyFormatter::formatUang($data->forminvbarang_totalharga)',
				),
				array(
					'header'=>'Detail Formulir',
					'type'=>'raw',
					'value'=>'CHtml::Link("<i class=\"icon-form-formulir\"></i>","'.$this->getUrlPrint().'&formulirinvbarang_id=$data->formulirinvbarang_id&frame=true",
						array("class"=>"", 
							"target"=>"formulir",
							"onclick"=>"$(\"#dialogFormulir\").dialog(\"open\");",
							"rel"=>"tooltip",
							"title"=>"Klik untuk melihat detail formulir",
						))',
					'htmlOptions'=>array('style'=>'text-align:left;'),
				),	
				array(
					'header'=>'Inventarisasi Barang',
					'type'=>'raw',
					'value'=>'(!empty($data->invbarang_id) ? "Sudah Inventarisasi Barang" : "").CHtml::link("<icon class=\"icon-invenmesin\">", "'.$this->getUrlInventarisasi().'&formulirinvbarang_id=$data->formulirinvbarang_id", 
						array("rel"=>"tooltip",
						"title"=>"Klik untuk melakukan inventarisasi barang ".(!empty($data->invbarang_id) ? "lagi" : ""),))',
					'htmlOptions'=>array('style'=>'text-align:left;'),
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
    'id' => 'dialogFormulir',
    'options' => array(
        'title' => 'Detail Formulir Inventarisasi Barang',
        'autoOpen' => false,
        'modal' => true,
        'width' => 750,
        'height' => 600,
        'resizable' => false,
    ),
));

echo '<iframe src="" name="formulir" width="100%" height="500">
</iframe>';

$this->endWidget();
?>