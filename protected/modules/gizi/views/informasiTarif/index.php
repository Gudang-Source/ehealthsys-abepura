<div class="white-container">
    <legend class="rim2">Infomasi <b>Tarif Gizi</b></legend>
    <div class="block-tabel">
        <h6>Tabel <b>Tarif Gizi</b></h6> 		
        <?php 
        $this->widget('ext.bootstrap.widgets.BootGridView',array(
            'id'=>'daftarTindakan-grid',
            'dataProvider'=>$modTarifTindakanRuanganV->searchInformasi(),
            'template'=>"{summary}\n{items}\n{pager}",
            'itemsCssClass'=>'table table-striped table-condensed',
            'columns'=>array(
                    'kelompoktindakan_nama',
                    'kategoritindakan_nama',
                    'daftartindakan_nama',
                    'kelaspelayanan_nama',

                     array(
                        'name'=>'tarifTotal',
                        'value'=>'$this->grid->getOwner()->renderPartial(\'_tarifTotal\',array(\'kelaspelayanan_id\'=>$data->kelaspelayanan_id,\'daftartindakan_id\'=>$data->daftartindakan_id),true)',
                     ),
                    'persencyto_tind',
                    'persendiskon_tind',
                    array(
                                'name'=>'Komponen Tarif',
                                'type'=>'raw',
                                'value'=>'CHtml::link("<i class=\'icon-form-komtarif\'></i> ",Yii::app()->controller->createUrl("'.Yii::app()->controller->id.'/detailsTarif",array("kelaspelayanan_id"=>$data->kelaspelayanan_id,"daftartindakan_id"=>$data->daftartindakan_id, "kategoritindakan_id"=>$data->kategoritindakan_id)) ,array("title"=>"Klik Untuk Melihat Detail Tarif","target"=>"iframe", "onclick"=>"$(\"#dialogDetailsTarif\").dialog(\"open\");", "rel"=>"tooltip"))','htmlOptions'=>array('style'=>'text-align: left; width:40px'),
                    ),

            ),
            'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
        )); 
        ?>
    </div>
    <fieldset class="box">
        <?php
            $this->renderPartial('_search',array('modTarifTindakanRuanganV'=>$modTarifTindakanRuanganV));
        ?>
    </fieldset>
<?php
    // ===========================Dialog Details Tarif=========================================
    $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
                        'id'=>'dialogDetailsTarif',
                            // additional javascript options for the dialog plugin
                            'options'=>array(
                            'title'=>'Komponen Tarif',
                            'autoOpen'=>false,
                            'width'=>250,
                            'height'=>300,
                            'resizable'=>false,
                            'scroll'=>false    
                             ),
                    ));
?>
<iframe src="" name="iframe" width="100%" height="100%">
</iframe>
<?php    
    $this->endWidget('zii.widgets.jui.CJuiDialog');
//===============================Akhir Dialog Details Tarif================================
?>