<div class="white-container">
    <legend class="rim2">Informasi <b>Pemesanan Ambulans</b></legend>
    <?php
        Yii::app()->clientScript->registerScript('search', "
        $('.search-form form').submit(function(){
            $.fn.yiiGridView.update('pesanambulans-t-grid', {
                data: $(this).serialize()
            });
            return false;
        });
        "); 
    ?>
    <div class="block-tabel">
        <h6>Tabel <b>Pemesanan Ambulans</b></h6>
        <?php $this->widget('ext.bootstrap.widgets.BootGridView',array(
        'id'=>'pesanambulans-t-grid',
        'dataProvider'=>$model->searchPemesanan(),

            'template'=>"{summary}\n{items}\n{pager}",
            'itemsCssClass'=>'table table-striped table-condensed',
            'columns'=>array(
                'pesanambulans_no',
                'pasien_norekammedis',
                'pasien_nama',
                'tempattujuan',
                'alamattujuan',
                            array(
                            'name'=>'tglpemakaianambulans',
                            'type'=>'raw',
                            'value'=>'MyFormatter::formatDateTimeForUser($data->tglpemakaianambulans)',
                            ),
                'untukkeperluan',
                'ruangan_nama',
                'pemesan_nama',
                array(
                    'header'=>'Pemakaian Ambulans',
                    'type'=>'raw',
                    'value'=>'(empty($data->pemakaianambulans_id)) ? (isset($data->pendaftaran_id)? 
                    CHtml::Link("<i class=\"icon-form-pakaiambulans\"></i>",
                    Yii::app()->controller->createUrl("PemakaianAmbulanPasienRS/index",array("pemesanan_id"=>$data->pesanambulans_t,"pendaftaran_id"=>$data->pendaftaran_id,
                    "modul_id"=>Yii::app()->session["modul_id"])),array("class"=>"btn-small","rel"=>"tooltip","title"=>"Klik untuk Pemakaian Ambulans")): 
                    CHtml::Link("<i class=\"icon-form-pakaiambulans\"></i>",
                    Yii::app()->controller->createUrl("PemakaianAmbulanPasienLuar/index",array("pemesanan_id"=>$data->pesanambulans_t,
                    "modul_id"=>Yii::app()->session["modul_id"])),array("class"=>"btn-small","rel"=>"tooltip","title"=>"Klik untuk Pemakaian Ambulans"))
                    ) : ""',
                    'htmlOptions'=>array('style'=>'text-align:center;')
                )
        ),
            'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
        )); ?>
    </div>
    <fieldset class="box">
        <?php $this->renderPartial('_searchPemesanan',array('model'=>$model,'format'=>$format)) ?>
    </fieldset>
</div>