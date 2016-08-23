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
    <legend class="rim2">Informasi Penerimaan <b>Obat dan Alkes Dari Supplier</b></legend>
    <div class="block-tabel">
        <h6>Tabel Penerimaan <b>Obat dan Alkes Dari Supplier</b></h6>
        <?php $this->widget('ext.bootstrap.widgets.BootGridView',array(
            'id'=>'rencana-m-grid',
            'dataProvider'=>$model->searchInformasi(),
            'template'=>"{summary}\n{items}\n{pager}",
            'itemsCssClass'=>'table table-striped table-condensed',
            'columns'=>array(
                    array(
                        'name'=>'tglterima',
                        'type'=>'raw',
                        'value'=>'MyFormatter::formatDateTimeForUser(date("Y-m-d",strtotime($data->tglterima)))',
                    ),
                    'noterima',
                    array(
                        'name'=>'gudangpenerima_id',
                        'type'=>'raw',
                        'value'=>'$data->gudangpenerima_nama',
                    ),
                    array(
                        'name'=>'supplier_id',
                        'type'=>'raw',
                        'value'=>'$data->supplier_nama',
                    ),
                    array(
                        'name'=>'pegawaimengetahui_id',
                        'type'=>'raw',
                        'value'=>'$data->PegawaimengetahuiLengkap',
                    ),
                    array(
                        'name'=>'pegawaimenyetujui_id',
                        'type'=>'raw',
                        'value'=>'$data->PegawaimenyetujuiLengkap',
                    ),
                    array(
                        'name'=>'statuspenerimaan',
                        'type'=>'raw',
                        'value'=>'$data->statuspenerimaan',
                    ),
                    array(
                        'header'=>'Jumlah Penerimaan',
                        'type'=>'raw',
                        'value'=>'number_format($data->JmlTerima,0,"",".")',
                        'htmlOptions'=>array('style'=>'text-align:right')
                    ),
                    array(
                        'header'=>'Faktur Pembelian',
                        'type'=>'raw',
                        'htmlOptions'=>array('style'=>'text-align:center;'),
                        'value'=>'(empty($data->fakturpembelian_id) ? CHtml::Link("<i class=\"icon-form-fakturbeli\"></i>","'.$this->createUrl("FakturPembelian/Index").'&penerimaanbarang_id=$data->penerimaanbarang_id&fakturpembelian_id=$data->fakturpembelian_id",
                                array("class"=>"", 
                                    "rel"=>"tooltip",
                                    "title"=>"Klik Mendaftarkan Ke Faktur Pembelian",
                                )) : "Sudah Difaktur")',
                    ),
                    array(
                        'header'=>'Rincian',
                        'type'=>'raw',
                        'htmlOptions'=>array('style'=>'text-align:center;'),
                        'value'=>'CHtml::Link("<i class=\"icon-form-detail\"></i>",Yii::app()->controller->createUrl("PenerimaanBarang/print",array("penerimaanbarang_id"=>$data->penerimaanbarang_id,"frame"=>true)),
                                     array("class"=>"", 
                                           "target"=>"rencana",
                                           "onclick"=>"$(\"#dialogPenerimaan\").dialog(\"open\");",
                                           "rel"=>"tooltip",
                                           "title"=>"Klik untuk melihat details Penerimaan Barang",
                                     ))',
                    ),
                    array(
                        'header'=>'Retur',
                        'type'=>'raw',
                        'htmlOptions'=>array('style'=>'text-align:center;'),
                        'value'=>'empty($data->fakturpembelian_id)?"Faktur<br/>Belum Ada":CHtml::Link("<i class=\"icon-form-retur\"></i>","'.$this->createUrl("PenerimaanBarang/returPembelianOA").'&penerimaanbarang_id=$data->penerimaanbarang_id",
                                     array("class"=>"", 
                                           "rel"=>"tooltip",
                                           "title"=>"Klik untuk membuat retur pembelian",
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
                        'title'=>'Detail Penerimaan',
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