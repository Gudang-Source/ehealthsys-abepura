<?php
Yii::app()->clientScript->registerScript('search', "
$('#info-pemusnahanoa-search').submit(function(){
	$.fn.yiiGridView.update('info-pemusnahanoa-m-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>
<div class="white-container">
    <legend class="rim2">Informasi Pemusnahan <b>Obat dan Alkes</b></legend>
    <div class="block-tabel">
        <h6>Tabel Pemusnahan <b>Obat dan Alkes</b></h6>
        <?php $this->widget('ext.bootstrap.widgets.BootGridView',array(
            'id'=>'info-pemusnahanoa-m-grid',
            'dataProvider'=>$model->searchInformasi(),
            'template'=>"{summary}\n{items}\n{pager}",
            'itemsCssClass'=>'table table-striped table-condensed',
            'columns'=>array(
                    array(
                        'name'=>'tglpemusnahan',
                        'type'=>'raw',
                        'value'=>'MyFormatter::formatDateTimeForUser($data->tglpemusnahan)',
                    ),
                    array(
                        'name'=>'nopemusnahan',
                        'type'=>'raw',
                        'value'=>'$data->nopemusnahan',
                    ),
                    array(
                        'name'=>'instalasi_nama',
                        'type'=>'raw',
                        'value'=>'$data->instalasi_nama',
                    ),
                    array(
                        'name'=>'ruangan_nama',
                        'type'=>'raw',
                        'value'=>'$data->ruangan_nama',
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
                        'name'=>'keterangan',
                        'type'=>'raw',
                        'value'=>'$data->keterangan',
                    ),
                    array(
                            'header'=>'Rincian',
                            'type'=>'raw',
                            'htmlOptions'=>array('style'=>'text-align:center;'),
                            'value'=>'CHtml::Link("<i class=\"icon-form-detail\"></i>",Yii::app()->controller->createUrl("InformasiPemusnahanOA/print",array("pemusnahanobatalkes_id"=>$data->pemusnahanobatalkes_id,"frame"=>true)),
                                     array("class"=>"", 
                                           "target"=>"rencana",
                                           "onclick"=>"$(\"#dialogPemusnahan\").dialog(\"open\");",
                                           "rel"=>"tooltip",
                                           "title"=>"Klik untuk melihat detail Pemusnahan Obat dan Alkes",
                                     ))',
                    ),

            ),
            'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
        )); ?>
    </div>
    <?php echo $this->renderPartial('search',array('model'=>$model,'format'=>$format,'instalasiTujuan'=>$instalasiTujuan,'ruanganAsal'=>$ruanganAsal)); ?>
</div>
<?php 
// ===========================Dialog Details=========================================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
                    'id'=>'dialogPemusnahan',
                        // additional javascript options for the dialog plugin
                        'options'=>array(
                        'title'=>'Detail Pemusnahan Obat dan Alkes',
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