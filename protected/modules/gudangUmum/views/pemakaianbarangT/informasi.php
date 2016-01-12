<legend class="rim2">Informasi Pemakaian Barang</legend>
<?php

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('gupemakaianbarang-t-grid', {
		data: $(this).serialize()
	});
	return false;
});
");

$format = new CustomFormat();
$this->widget('bootstrap.widgets.BootAlert'); ?>

<?php $this->widget('ext.bootstrap.widgets.BootGridView',array(
	'id'=>'gupemakaianbarang-t-grid',
	'dataProvider'=>$model->searchInformasi(),
    'template'=>"{pager}{summary}\n{items}",
    'itemsCssClass'=>'table table-striped table-bordered table-condensed',
	'columns'=>array(
        'nopemakaianbrg',
        array(
          	'header'=>'Tgl Pemakaian Barang',
          	'type'=>'raw',
          	'value'=>'$data->tglpemakaianbrg',
        ),
        'untukkeperluan',
		'ruangan.ruangan_nama',
		array(
            'header'=>'Detail',
            'type'=>'raw',
            'value'=>'CHtml::link("<i class=\'icon-list-alt\'></i> ",  Yii::app()->controller->createUrl("/gudangUmum/pemakaianbarangT/detail",array("id"=>$data->pemakaianbarang_id)),array("target"=>"frameDetail","rel"=>"tooltip","title"=>"Klik untuk Detail Pemakaian Barang", "onclick"=>"window.parent.$(\'#dialogDetail\').dialog(\'open\')"));',    'htmlOptions'=>array('style'=>'text-align: center; width:40px')
        ),
	),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
)); ?>

<div class="search-form">
<?php $this->renderPartial($this->path_view.'_search',array(
	'model'=>$model,
)); ?>
</div>

<?php 

$js = <<< JSCRIPT
function print(caraPrint)
{
    window.open("${urlPrint}/"+$('#gupemakaianbarang-t-search').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
}
JSCRIPT;
Yii::app()->clientScript->registerScript('print',$js,CClientScript::POS_HEAD);                        
?>

<?php
//========= Dialog untuk Melihat detail Pemakaian Barang =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogDetail',
    'options' => array(
        'title' => 'Detail Pemakaian Barang',
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