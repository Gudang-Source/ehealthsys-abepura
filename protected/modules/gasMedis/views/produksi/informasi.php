<?php
Yii::app()->clientScript->registerScript('search', "
$('#divSearch-form form').submit(function(){
        $('#informasi-grid').addClass('animation-loading');
	$.fn.yiiGridView.update('informasi-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<div class="white-container">
    <legend class="rim2">Informasi Produksi <b>Gas Medis</b></legend>
    <div class="block-tabel">
        <h6>Tabel Informasi <b>Gas Medis</b></h6>
            <?php $this->widget('ext.bootstrap.widgets.BootGridView',array(
                'id'=>'informasi-grid',
                'dataProvider'=>$model->searchInformasi(),
                'template'=>"{summary}\n{items}\n{pager}",
                'itemsCssClass'=>'table table-striped table-condensed',
                'columns'=>array(
                    array(
                        'name'=>'tgl_produksi',
                        'value'=>'MyFormatter::formatDateTimeForUser($data->tgl_produksi)',
                    ),
                    'no_produksi',
                    array(
                        'header'=>'Petugas Gas Medis',
                        'name'=>'petugas.nama_pegawai',
                    ),
                    array(
                        'header'=>'Mengetahui',
                        'name'=>'mengetahui.nama_pegawai',
                    ),
                    array(
                        'header'=>'Detail',
                        'type'=>'raw',
                        'value'=>function($data) {
                            return CHtml::link(
                                    '<i class="icon-form-detail"></i>', 
                                    $this->createUrl('detail', array('id'=>$data->produksigasmedis_id)),
                                    array(
                                        'rel'=>'tooltip',
                                        'title'=>'Klik untuk melihat detail Produksi Gas Medis',
                                        'target'=>'detail',
                                        'onclick'=>'$("#dialogProduksi").dialog("open");',
                                    ));
                        },
                        'htmlOptions'=>array(
                            'style'=>'text-align: center !important;',
                        )
                    ),
                ),
            'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
            )); ?>
    </div>
    <?php echo $this->renderPartial('subInformasi/_search', array('model'=>$model, 'format'=>new MyFormatter), true); ?>
</div>

<?php $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
                        'id'=>'dialogProduksi',
                            // additional javascript options for the dialog plugin
                            'options'=>array(
                            'title'=>'Rincian Produksi Gas Medis',
                            'autoOpen'=>false,
                            'minWidth'=>900,
                            'minHeight'=>100,
                            'resizable'=>false,
                             ),
                        ));
?>
    <iframe src="" name="detail" width="100%" height="500">
    </iframe>
<?php $this->endWidget('zii.widgets.jui.CJuiDialog'); ?>