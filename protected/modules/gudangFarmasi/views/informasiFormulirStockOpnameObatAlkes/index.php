<div class="white-container">
    <legend class="rim2">Informasi Formulir Stock <b>Opname Obat Alkes</b></legend>
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
    <div class="block-tabel">
        <h6>Tabel Formulir Stock <b>Opname Obat Alkes</b></h6>
        <?php $this->widget('ext.bootstrap.widgets.BootGridView',array(
            'id'=>'rencana-m-grid',
            'dataProvider'=>$model->searchInformasi(),
            'template'=>"{summary}\n{items}\n{pager}",
            'itemsCssClass'=>'table table-striped table-condensed',
            'columns'=>array(
                                    array (
                                    'name'=>'tglformulir',
                                    'type'=>'raw',
                                    'value'=>'MyFormatter::formatDateTimeForUser($data->tglformulir)'
                                    ),
                    'noformulir',
                    'totalvolume',
                    array(
                      'header'=>'Total Harga',
                      'type'=>'raw',
                      'value'=>'MyFormatter::formatUang($data->totalharga)',
                    ),
                    array(
                        'header'=>'Formulir',
                        'type'=>'raw',
                        'value'=>'CHtml::Link("<i class=\"icon-form-formulir\"></i>","'.$this->getUrlPrint().'&formuliropname_id=$data->formuliropname_id&frame=true",
                                     array("class"=>"", 
                                           "target"=>"formulir",
                                           "onclick"=>"$(\"#dialogFormulir\").dialog(\"open\");",
                                           "rel"=>"tooltip",
                                           "title"=>"Klik untuk melihat details formulir",
                                     ))',
                        'htmlOptions'=>array('style'=>'text-align:left;'),
                    ),
                    array(
                        'header'=>'Stock Opname',
                                            'type'=>'raw',
                        'value'=>'(!empty($data->stokopname_id) ? "Sudah Stock Opname" : "").CHtml::link("<icon class=\"icon-form-stockopname\">", "'.$this->getUrlStokOpname().'&formuliropname_id=$data->formuliropname_id", 
                                                    array("rel"=>"tooltip",
                                                    "title"=>"Klik untuk melakukan stock opname ".(!empty($data->stokopname_id) ? "lagi" : ""),))',
                        'htmlOptions'=>array('style'=>'text-align:left;'),
                    ),
            ),
            'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
        )); ?>
    </div>
    <?php echo $this->renderPartial($this->path_view.'search',array('model'=>$model,'format'=>$format)); ?>
    <?php 
    // ===========================Dialog Details=========================================
    $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
        'id'=>'dialogFormulir',
            // additional javascript options for the dialog plugin
            'options'=>array(
            'title'=>'Details Formulir Opname',
            'autoOpen'=>false,
            'minWidth'=>900,
            'minHeight'=>100,
            'resizable'=>false,
             ),
        ));
    ?>
    <iframe src="" name="formulir" width="100%" height="500">
    </iframe>
    <?php    
    $this->endWidget('zii.widgets.jui.CJuiDialog');
    //===============================Akhir Dialog Details================================
    ?>
</div>