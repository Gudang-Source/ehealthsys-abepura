<?php
Yii::app()->clientScript->registerScript('search', "
$('#divSearch-form form').submit(function(){
	$.fn.yiiGridView.update('rencana-m-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>
<div class="white-container">
    <legend class="rim2">Informasi <b>Faktur Pembelian</b></legend>
    <div class="block-tabel">
        <h6>Tabel <b>Faktur Pembelian</b></h6>
        <?php $this->widget('ext.bootstrap.widgets.BootGridView',array(
            'id'=>'rencana-m-grid',
            'dataProvider'=>$model->searchInformasi(),
            'template'=>"{summary}\n{items}\n{pager}",
            'itemsCssClass'=>'table table-striped table-condensed',
            'columns'=>array(
                    array(
                        'name'=>'tglfaktur',
                        'type'=>'raw',
                        'value'=>'MyFormatter::formatDateTimeForUser($data->tglfaktur)',
                    ),
                    'nofaktur',
                    array(
                        'name'=>'tgljatuhtempo',
                        'type'=>'raw',
                        'value'=>'MyFormatter::formatDateTimeForUser($data->tgljatuhtempo)',
                    ),
                    array(
                        'name'=>'tglsuratjalan',
                        'type'=>'raw',
                        'value'=>'MyFormatter::formatDateTimeForUser($data->tglsuratjalan)',
                    ),
                    'nosuratjalan',
                    array(
                        'name'=>'supplier_nama',
                        'type'=>'raw',
                        'value'=>'$data->supplier_nama',
                    ),
                    array(
                        'name'=>'statuspenerimaan',
                        'type'=>'raw',
                        'value'=>'$data->statuspenerimaan',
                    ),
                    array(
                        'name'=>'ruangan_nama',
                        'type'=>'raw',
                        'value'=>'$data->ruangan_nama',
                    ),
                    array(
                        'header'=>'Rincian',
                        'type'=>'raw',
                        'htmlOptions'=>array('style'=>'text-align:left;'),
                        'value'=>'CHtml::Link("<i class=\"icon-form-detail\"></i>",Yii::app()->controller->createUrl("FakturPembelian/print",array("fakturpembelian_id"=>$data->fakturpembelian_id,"frame"=>true)),
                                     array("class"=>"", 
                                           "target"=>"rencana",
                                           "onclick"=>"$(\"#dialogPenerimaan\").dialog(\"open\");",
                                           "rel"=>"tooltip",
                                           "title"=>"Klik untuk melihat details Penerimaan Barang",
                                     ))',
                    ),
            ),
            'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
        )); ?>
    </div>
    <?php echo $this->renderPartial('search',array('model'=>$model,'format'=>$format)); ?>
</div>
<?php 
// ===========================Dialog Details=========================================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
                    'id'=>'dialogPenerimaan',
                        // additional javascript options for the dialog plugin
                        'options'=>array(
                        'title'=>'Details Penerimaan',
                        'autoOpen'=>false,
                        'minWidth'=>900,
                        'minHeight'=>100,
                        'resizable'=>false,
                         ),
                    ));
?>
<iframe src="" name="rencana" width="100%" height="500">
</iframe>
<?php    
$this->endWidget('zii.widgets.jui.CJuiDialog');
//===============================Akhir Dialog Details================================

?>