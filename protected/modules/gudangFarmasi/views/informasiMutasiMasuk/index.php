<?php
Yii::app()->clientScript->registerScript('search', "
$('#divSearch-form form').submit(function(){
        $('#mutasimasuk-m-grid').addClass('animation-loading');
	$.fn.yiiGridView.update('mutasimasuk-m-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>
<div class="white-container">
    <legend class="rim2">Informasi <b>Mutasi Masuk</b></legend>
    <div class="block-tabel">
        <h6>Tabel <b>Mutasi Masuk</b></h6>
        <?php $this->widget('ext.bootstrap.widgets.BootGridView',array(
                'id'=>'mutasimasuk-m-grid',
                'dataProvider'=>$model->searchInformasiMutasiMasuk(),
                'template'=>"{summary}\n{items}\n{pager}",
                'itemsCssClass'=>'table table-striped table-condensed',
                'columns'=>array(
                        array(
                            'name'=>'tglmutasioa',
                            'type'=>'raw',
                            'value'=>'MyFormatter::formatDateTimeForUser($data->tglmutasioa)',
                        ),
                        'nomutasioa',
                        'ruanganasalmutasi_nama',
                        'statuspesan',
                        array(
                            'name'=>'pegawaimutasi_id',
                            'type'=>'raw',
                            'value'=>'$data->PegawaiMutasiLengkap',
                        ),
                        array(
                            'name'=>'pegawaimengetahuimutasi_id',
                            'type'=>'raw',
                            'value'=>'$data->PegawaiMengetahuiLengkap',
                        ),
                        array(
                            'header'=>'Terima Mutasi',
                            'type'=>'raw',
                            'value'=>'(empty($data->terimamutasi_id) ? CHtml::Link("<i class=\"icon-form-terimamobat\"></i>","'.$this->createUrl("TerimaMutasi").'&mutasioaruangan_id=$data->mutasioaruangan_id",
                                    array("class"=>"", 
                                        "rel"=>"tooltip",
                                        "title"=>"Klik untuk menerima mutasi",
                                    )) : "SUDAH DITERIMA ".
                                                                        CHtml::Link("<i class=\"icon-form-detail\"></i>",Yii::app()->controller->createUrl("printTerimaMutasi",array("terimamutasi_id"=>$data->terimamutasi_id,"frame"=>true)),
                                                                                 array("class"=>"", 
                                                                                           "target"=>"terimamutasi",
                                                                                           "onclick"=>"$(\"#dialogTerimaMutasi\").dialog(\"open\");",
                                                                                           "rel"=>"tooltip",
                                                                                           "title"=>"Klik untuk melihat rincian terima mutasi",
                                                                                 ))
                                                                )',
                            'htmlOptions'=>array('style'=>'text-align:left;'),
                        ),
                        array(
                            'header'=>'Rincian',
                            'type'=>'raw',
                            'value'=>'CHtml::Link("<i class=\"icon-form-detail\"></i>",Yii::app()->controller->createUrl("print",array("mutasioaruangan_id"=>$data->mutasioaruangan_id,"frame"=>true)),
                                         array("class"=>"", 
                                               "target"=>"mutasimasuk",
                                               "onclick"=>"$(\"#dialogMutasi\").dialog(\"open\");",
                                               "rel"=>"tooltip",
                                               "title"=>"Klik untuk melihat rincian mutasi masuk",
                                         ))',
                            'htmlOptions'=>array('style'=>'text-align:left;'),
                        ),
                ),
                'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
        )); ?>
    </div>
    <?php echo $this->renderPartial($this->path_view.'search',array('model'=>$model,'format'=>$format,'instalasiAsals'=>$instalasiAsals,'ruanganAsals'=>$ruanganAsals)); ?>
    <?php 
    // ===========================Dialog Details=========================================
    $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
                        'id'=>'dialogTerimaMutasi',
                            // additional javascript options for the dialog plugin
                            'options'=>array(
                            'title'=>'Rincian Terima Mutasi',
                            'autoOpen'=>false,
                            'minWidth'=>900,
                            'minHeight'=>100,
                            'resizable'=>false,
                             ),
                        ));
    ?>
    <iframe src="" name="terimamutasi" width="100%" height="500">
    </iframe>
    <?php    
    $this->endWidget('zii.widgets.jui.CJuiDialog');
    $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
                        'id'=>'dialogMutasi',
                            // additional javascript options for the dialog plugin
                            'options'=>array(
                            'title'=>'Rincian Mutasi',
                            'autoOpen'=>false,
                            'minWidth'=>900,
                            'minHeight'=>100,
                            'resizable'=>false,
                             ),
                        ));
    ?>
    <iframe src="" name="mutasimasuk" width="100%" height="500">
    </iframe>
    <?php    
    $this->endWidget('zii.widgets.jui.CJuiDialog');
    //===============================Akhir Dialog Details================================
    ?>
</div>