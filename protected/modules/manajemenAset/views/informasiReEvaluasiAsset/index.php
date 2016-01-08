<div class="white-container">
<?php
$this->breadcrumbs=array(
	'ReevaluasiAset Ts'=>array('index'),
	'Manage',
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('informasireevaluasiaset-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>
    <legend class="rim2">Informasi <b>Re-evaluasi Aset</b></legend>
 <div class="block-tabel">
	<h6>Tabel <b>Re-evaluasi Aset</b></h6>
		<?php $this->widget('bootstrap.widgets.BootAlert'); ?>
		<?php $this->widget('ext.bootstrap.widgets.BootGridView',array(
			'id'=>'informasireevaluasiaset-grid',
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
					'htmlOptions'=>array('style'=>'text-align:right;'),
				),
				array(
					'header'=>'Tanggal Re-evaluasi',
					'type'=>'raw',
					'value'=>'MyFormatter::formatDateTimeForUser($data->reevaluasiaset_tgl)',
				),
				array(
					'header'=>'No. Re-evaluasi',
					'type'=>'raw',
					'value'=>'$data->reevaluasiaset_no',
				),
				array(
					'header'=>'Total Selisih Re-evaluasi',
					'type'=>'raw',
					'value'=>'MyFormatter::formatUang($data->reevaluasiaset_totalselisih)',
				),
				array(
					'header'=>'Rincian',
					'type'=>'raw',
					'value'=>'CHtml::link("<i class=\'icon-form-lihat\'></i> ",  Yii::app()->createUrl("'.Yii::app()->controller->module->id.'/'.Yii::app()->controller->id.'/detail",array("id"=>$data->reevaluasiaset_id)),array("target"=>"frameDetail","rel"=>"tooltip","title"=>"Klik untuk Detail Re-evaluasi Aset", "onclick"=>"window.parent.$(\'#dialogDetail\').dialog(\'open\')"));',
					'htmlOptions'=>array('style'=>'text-align: center; width:40px')
				),
			),
			'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
		)); ?>
 </div>
<fieldset class="box search-form">
	<?php $this->renderPartial('_search',array(
		'model'=>$model,'format'=>$format
	)); ?>
</fieldset><!-- search-form -->

<?php
//========= Dialog untuk Melihat detail Pemakaian Barang =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogDetail',
    'options' => array(
        'title' => 'Detail Re-evaluasi Aset',
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