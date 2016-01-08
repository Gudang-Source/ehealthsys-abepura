<div class="white-container">
    <legend class="rim2">Informasi Stock <b>Opname Obat Alkes</b></legend>
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
        <h6>Tabel Stock <b>Opname Obat Alkes</b></h6>
        <?php $this->widget('ext.bootstrap.widgets.BootGridView',array(
                'id'=>'rencana-m-grid',
                'dataProvider'=>$model->searchInformasi(),
                'template'=>"{summary}\n{items}\n{pager}",
                'itemsCssClass'=>'table table-striped table-condensed',
                'columns'=>array(
                        array(
                          'header'=>'Tanggal Stock Opname',
                          'type'=>'raw',
                          'value'=>'MyFormatter::formatDateTimeForUser($data->tglstokopname)',
                        ),
                        'nostokopname',
                        array(
                          'header'=>'Tanggal Formulir Opname',
                          'type'=>'raw',
                          'value'=>'MyFormatter::formatDateTimeForUser($data->tglformulir)',
                        ),
                        'noformulir',
                        'jenisstokopname',
                        'keterangan_opname',
                        array(
                          'header'=>'Mengetahui',
                          'type'=>'raw',
                          'value'=>'$data->Mengetahui',
                        ),
                        array(
                          'header'=>'Petugas 1',
                          'type'=>'raw',
                          'value'=>'$data->Petugas1',
                        ),
                        array(
                          'header'=>'Petugas 2',
                          'type'=>'raw',
                          'value'=>'$data->Petugas2',
                        ),
                        array(
                          'header'=>'Total HPP',
                          'type'=>'raw',
                          'value'=>'MyFormatter::formatUang($data->totalnetto)',
                        ),
                        array(
                            'header'=>'Detail',
                            'type'=>'raw',
                            'value'=>'CHtml::Link("<i class=\"icon-form-detail\"></i>","'.$this->getUrlPrint().'&stokopname_id=$data->stokopname_id&frame=true",
                                         array("class"=>"", 
                                               "target"=>"stokopname",
                                               "onclick"=>"$(\"#dialogStokOpname\").dialog(\"open\");",
                                               "rel"=>"tooltip",
                                               "title"=>"Klik untuk melihat details stock opname",
                                         ))',
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
        'id'=>'dialogStokOpname',
            // additional javascript options for the dialog plugin
            'options'=>array(
            'title'=>'Details Stock Opname',
            'autoOpen'=>false,
            'minWidth'=>900,
            'minHeight'=>100,
            'resizable'=>false,
             ),
        ));
    ?>
    <iframe src="" name="stokopname" width="100%" height="500">
    </iframe>
    <?php    
    $this->endWidget('zii.widgets.jui.CJuiDialog');
    //===============================Akhir Dialog Details================================

    ?>
</div>