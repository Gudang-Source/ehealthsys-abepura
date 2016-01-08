<div class="white-container">
    <legend class="rim2">Informasi Komposisi <b>Bahan Makanan</b></legend>
    <?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form.js'); ?>
    <?php
        $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
        $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai

        Yii::app()->clientScript->registerScript('search', "
        $('#search').submit(function(){
                $.fn.yiiGridView.update('infokomposisibahanmakanan-grid', {
                        data: $(this).serialize()
                });
                return false;
        });
        ");
    ?>
    <div class="block-tabel">
        <h6>Tabel Komposisi <b>Bahan Makanan</b></h6>
        <?php 
        $this->widget('ext.bootstrap.widgets.HeaderGroupGridView',array(
            'id'=>'infokomposisibahanmakanan-grid',
            'dataProvider'=>$modKomposisiBahanMakanan->searchKomposisi(),
            'enableSorting'=>true,
            'template'=>"{summary}\n{items}\n{pager}",
            'itemsCssClass'=>'table table-striped table-condensed',
            'mergeHeaders'=>array(
                    array(
                        'name'=>'<center>Komposisi Makanan</center>',
                        'start'=>2, //indeks kolom 3
                        'end'=>12, //indeks kolom 4
                    ),
              ),
                'columns'=>array(
                    array(
                        'header' => 'No.',
                        'value' => '$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1',
                        'htmlOptions'=>array('style'=>'text-align:center'),
                        'headerHtmlOptions'=>array(
                            'style'=>'text-align:center',
                        ),
                    ),
                    array(
                      'header'=>'Bahan Makanan',
                      'type'=>'raw',
                      'value'=>'$data->namabahanmakanan',
                      'headerHtmlOptions'=>array(
                        'style'=>'text-align:center',
                      ),
                    ),
                    array(
                      'header'=>'Kalori <br> (Kal)',
                      'type'=>'raw',
                      'value'=>'$this->grid->owner->renderPartial("gizi.views.infoKomposisiBahanMakanan/_kalori",array("bahanmakanan_id"=>"$data->bahanmakanan_id"),true)',
                      'htmlOptions'=>array('style'=>'text-align:right;'),
                      'headerHtmlOptions'=>array(
                            'style'=>'text-align:center',
                        ),
                    ),
                    array(
                      'header'=>'Protein <br> (g)',
                      'type'=>'raw',
                      'value'=>'$this->grid->owner->renderPartial("gizi.views.infoKomposisiBahanMakanan/_protein",array("bahanmakanan_id"=>"$data->bahanmakanan_id"),true)',
                      'htmlOptions'=>array('style'=>'text-align:right;'),
                      'headerHtmlOptions'=>array(
                            'style'=>'text-align:center',
                        ),
                    ),
                    array(
                      'header'=>'Lemak <br> (g)',
                      'type'=>'raw',
                      'value'=>'$this->grid->owner->renderPartial("gizi.views.infoKomposisiBahanMakanan/_lemak",array("bahanmakanan_id"=>"$data->bahanmakanan_id"),true)',
                      'htmlOptions'=>array('style'=>'text-align:right;'),
                      'headerHtmlOptions'=>array(
                            'style'=>'text-align:center',
                        ),
                    ),
                    array(
                      'header'=>'Hidrat <br> Arang <br> (g)',
                      'type'=>'raw',
                      'value'=>'$this->grid->owner->renderPartial("gizi.views.infoKomposisiBahanMakanan/_hidratArang",array("bahanmakanan_id"=>"$data->bahanmakanan_id"),true)',
                      'htmlOptions'=>array('style'=>'text-align:right;'),
                      'headerHtmlOptions'=>array(
                            'style'=>'text-align:center',
                        ),
                    ),
                    array(
                      'header'=>'Ca <br> (mg)',
                      'type'=>'raw',
                      'value'=>'$this->grid->owner->renderPartial("gizi.views.infoKomposisiBahanMakanan/_ca",array("bahanmakanan_id"=>"$data->bahanmakanan_id"),true)',
                      'htmlOptions'=>array('style'=>'text-align:right;'),
                      'headerHtmlOptions'=>array(
                            'style'=>'text-align:center',
                        ),
                    ),
                    array(
                      'header'=>'P <br> (mg)',
                      'type'=>'raw',
                      'value'=>'$this->grid->owner->renderPartial("gizi.views.infoKomposisiBahanMakanan/_p",array("bahanmakanan_id"=>"$data->bahanmakanan_id"),true)',
                      'htmlOptions'=>array('style'=>'text-align:right;'),
                      'headerHtmlOptions'=>array(
                            'style'=>'text-align:center',
                        ),
                    ),
                    array(
                      'header'=>'Fe <br> (mg)',
                      'type'=>'raw',
                      'value'=>'$this->grid->owner->renderPartial("gizi.views.infoKomposisiBahanMakanan/_fe",array("bahanmakanan_id"=>"$data->bahanmakanan_id"),true)',
                      'htmlOptions'=>array('style'=>'text-align:right;'),
                      'headerHtmlOptions'=>array(
                            'style'=>'text-align:center',
                        ),
                    ),
                    array(
                      'header'=>'Vit. <br> A <br> (IU)',
                      'type'=>'raw',
                      'value'=>'$this->grid->owner->renderPartial("gizi.views.infoKomposisiBahanMakanan/_vitA",array("bahanmakanan_id"=>"$data->bahanmakanan_id"),true)',
                      'htmlOptions'=>array('style'=>'text-align:right;'),
                      'headerHtmlOptions'=>array(
                            'style'=>'text-align:center',
                        ),
                    ),
                    array(
                      'header'=>'Vit. <br> B1 <br> (mg)',
                      'type'=>'raw',
                      'value'=>'$this->grid->owner->renderPartial("gizi.views.infoKomposisiBahanMakanan/_vitB1",array("bahanmakanan_id"=>"$data->bahanmakanan_id"),true)',
                      'htmlOptions'=>array('style'=>'text-align:right;'),
                      'headerHtmlOptions'=>array(
                            'style'=>'text-align:center',
                        ),
                    ),
                    array(
                      'header'=>'Vit. <br> C <br> (mg)',
                      'type'=>'raw',
                      'value'=>'$this->grid->owner->renderPartial("gizi.views.infoKomposisiBahanMakanan/_vitC",array("bahanmakanan_id"=>"$data->bahanmakanan_id"),true)',
                      'htmlOptions'=>array('style'=>'text-align:right;'),
                      'headerHtmlOptions'=>array(
                            'style'=>'text-align:center',
                        ),
                    ),
                    array(
                      'header'=>'Air <br> (g)',
                      'type'=>'raw',
                      'value'=>'$this->grid->owner->renderPartial("gizi.views.infoKomposisiBahanMakanan/_air",array("bahanmakanan_id"=>"$data->bahanmakanan_id"),true)',
                      'htmlOptions'=>array('style'=>'text-align:right;'),
                      'headerHtmlOptions'=>array(
                            'style'=>'text-align:center',
                        ),
                    ),
                    array(
                      'header'=>'Bagian yang <br> dapat dimakan <br> (%)',
                      'type'=>'raw',
                      'value'=>'$this->grid->owner->renderPartial("gizi.views.infoKomposisiBahanMakanan/_bdd",array("bahanmakanan_id"=>"$data->bahanmakanan_id"),true)',
                      'htmlOptions'=>array('style'=>'text-align:right;'),
                      'headerHtmlOptions'=>array(
                            'style'=>'text-align:center',
                        ),
                    ),

                ),
                'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
            )); 
        ?>
    </div>  
    <?php
        $this->renderPartial('search',array('modKomposisiBahanMakanan'=>$modKomposisiBahanMakanan));
    ?>