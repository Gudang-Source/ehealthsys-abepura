<div class="white-container">
    <legend class="rim2">Informasi <b>Tarif Ambulans</b></legend>
    <?php
    Yii::app()->clientScript->registerScript('search', "
    $('.search-form form').submit(function(){
        $.fn.yiiGridView.update('tableTarif', {
            data: $(this).serialize()
        });
        return false;
    });
    "); 
    ?>
    <div class="block-tabel">
        <h6>Tabel <b>Tarif Ambulans</b></h6>
        <?php $this->widget('ext.bootstrap.widgets.HeaderGroupGridView',array(
            'id'=>'tableTarif',
            'dataProvider'=>$modTarif->search(),
            'template'=>"{summary}\n{items}\n{pager}",
            'mergeHeaders'=>array(
                array(
                    'name'=>'<center>Tujuan</center>',
                    'start'=>1, //indeks kolom 3
                    'end'=>5, //indeks kolom 4
                ),
            ),
            'itemsCssClass'=>'table table-striped table-condensed',
            'columns'=>array(
                    array(
                        'name'=>'tarifambulans_kode',
                        'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:left;'),
                    ),
                    array(
                        'name'=>'daftartindakan.daftartindakan_nama',
                        'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:left;'),
                    ),
                    array(
                        'name'=>'kepropinsi_nama',
                        'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:left;'),
                    ),
                    array(
                        'name'=>'kekabupaten_nama',
                        'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:lrft;'),
                    ),
                    array(
                        'name'=>'kekecamatan_nama',
                        'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:left;'),
                    ),
                    array(
                        'name'=>'kekelurahan_nama',
                        'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:left;'),
                    ),
                    array(
                        'name'=>'jmlkilometer',
                        'value'=>'number_format($data->jmlkilometer,0,",",".")',
                        'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:left;'),
                        'htmlOptions'=>array('style'=>'text-align:left;'),
                    ),
                    array(
                        'name'=>'tarifperkm',
                        'value'=>'number_format($data->tarifperkm,0,",",".")',
                        'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:left;'),
                        'htmlOptions'=>array('style'=>'text-align:left;'),
                    ),
                    array(
                        'name'=>'tarifambulans',
                        'value'=>'number_format($data->tarifambulans,0,",",".")',
                        'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:left'),
                        'htmlOptions'=>array('style'=>'text-align:left;'),
                    ),
            ),
            'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
        )); ?>
    </div>
    <fieldset class="box">
        <?php $this->renderPartial('_searchTarif',array('modTarif'=>$modTarif)) ?>
    </fieldset>
</div>