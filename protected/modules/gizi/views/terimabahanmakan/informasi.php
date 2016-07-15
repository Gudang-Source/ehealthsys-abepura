<div class="white-container">
    <legend class="rim2">Informasi Penerimaan <b>Bahan Makanan</b></legend>
    <?php 
    Yii::app()->clientScript->registerScript('search', "
    $('.search-button').click(function(){
            $('.search-form').toggle();
            return false;
    });
    $('.search-form form').submit(function(){
            $.fn.yiiGridView.update('gzterimabahanmakan-grid', {
                    data: $(this).serialize()
            });
            return false;
    });
    ");
    ?>
    <div class="block-tabel">
        <h6>Tabel Penerimaan <b>Bahan Makanan</b></h6>
        <?php $this->widget('ext.bootstrap.widgets.HeaderGroupGridView',array(
            'id'=>'gzterimabahanmakan-grid',
            'dataProvider'=>$model->searchInformasi(),
    //	'filter'=>$model,
            'template'=>"{summary}\n{items}\n{pager}",
            'mergeHeaders'=>array(
                array(
                    'name'=>'<center>Surat Jalan</center>',
                    'start'=>2, //indeks kolom 3
                    'end'=>3, //indeks kolom 4
                ),
                array(
                    'name'=>'<center>Faktur</center>',
                    'start'=>4, //indeks kolom 3
                    'end'=>5, //indeks kolom 4
                ),
            ),
            'itemsCssClass'=>'table table-striped table-condensed',
            'columns'=>array(

                    array(
                        'name'=>'nopenerimaanbahan',
                        'headerHtmlOptions'=>array('style'=>'vertical-align:middle;'),
                    ),
                    array(
                        'name'=>'tglterimabahan',
                        'headerHtmlOptions'=>array('style'=>'vertical-align:middle;'),
                    ),
                    array(
                        'header'=>'No.',
                        'headerHtmlOptions'=>array('style'=>'vertical-align:middle;'),
                        'value'=>'$data->nosuratjalan'
                    ),
                    array(
                        'header'=>'Tanggal',
                        'headerHtmlOptions'=>array('style'=>'vertical-align:middle;'),
                        'value'=>'$data->tglsurjalan'
                    ),
                    array(
                        'header'=>'No.',
                        'headerHtmlOptions'=>array('style'=>'vertical-align:middle;'),
                        'value'=>'$data->nofaktur'
                    ),
                    array(
                        'header'=>'Tanggal',
                        'headerHtmlOptions'=>array('style'=>'vertical-align:middle;'),
                        'value'=>'$data->tglfaktur'
                    ),
                    array(
                        'name'=>'totaldiscount',
                        'headerHtmlOptions'=>array('style'=>'vertical-align:middle;'),
                        'value'=>'MyFormatter::formatNumberForPrint($data->totaldiscount)',
                        'htmlOptions'=>array(
                            'style'=>'text-align: right',
                        ),
                    ),
                    array(
                        'name'=>'totalharganetto',
                        'value'=>'"Rp".MyFormatter::formatNumberForPrint($data->totalharganetto)',
                        'htmlOptions'=>array(
                            'style'=>'text-align: right',
                        ),
                        'headerHtmlOptions'=>array('style'=>'vertical-align:middle;'),
                    ),
                    array(
                        'name'=>'biayapengiriman',
                        'value'=>'"Rp".MyFormatter::formatNumberForPrint($data->biayapengiriman)',
                        'htmlOptions'=>array(
                            'style'=>'text-align: right',
                        )
                    ),
                    array(
                        'name'=>'biayatransportasi',
                        'value'=>'"Rp".MyFormatter::formatNumberForPrint($data->biayatransportasi)',
                        'htmlOptions'=>array(
                            'style'=>'text-align: right',
                        )
                    ),
                    array(
                        'name'=>'biayapajak',
                        'value'=>'"Rp".MyFormatter::formatNumberForPrint($data->biayapajak)',
                        'htmlOptions'=>array(
                            'style'=>'text-align: right',
                        )
                    ),
                    array(
                        'name'=>'keterangan_terima_bahan',
                        'headerHtmlOptions'=>array('style'=>'vertical-align:middle;'),
                    ),
                    array(
                        'name'=>'pengajuanbahanmkn.nopengajuan',
                        'headerHtmlOptions'=>array('style'=>'vertical-align:middle;'),
                    ),


                    array(
                        'header'=>'Rincian',
                        'type'=>'raw',
                        'value'=>'CHtml::link("<i class=\'icon-form-detail\'></i> ",  Yii::app()->controller->createUrl("/gizi/Terimabahanmakan/detailPenerimaan",array("id"=>$data->terimabahanmakan_id)),array("id"=>"$data->terimabahanmakan_id","target"=>"frameDetail","rel"=>"tooltip","title"=>"Klik untuk Detail Penerimaan Barang", "onclick"=>"window.parent.$(\'#dialogDetail\').dialog(\'open\')"));',
                        'headerHtmlOptions'=>array('style'=>'vertical-align:middle;'),
                    ),
                    /*





                    'create_time',
                    'update_time',
                    'create_loginpemakai_id',
                    'update_loginpemakai_id',
                    'create_ruangan',

    //		'ruangan_id',
    //		'supplier_id',	
    /*        	'create_time',
                    'update_time',
                    'create_loginpemakai_id',
                    'update_loginpemakai_id',
                    */

            ),
            'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
        )); ?>
    </div>
    <fieldset class="box search-form">
        <?php $this->renderPartial('_search',array(
                'model'=>$model,
        )); ?>
    </fieldset><!-- search-form -->
</div>
<?php 
$js = <<< JSCRIPT
function openDialog(id){
    $('#dialogDetail').dialog('open');
}
JSCRIPT;
Yii::app()->clientScript->registerScript('head',$js,CClientScript::POS_HEAD);                        
?>

<?php
//========= Dialog untuk Melihat detail Pengajuan Bahan Makanan =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogDetail',
    'options' => array(
        'title' => 'Detail Penerimaan Bahan Makanan',
        'autoOpen' => false,
        'modal' => true,
        'zIndex'=>1002,
        'width' => 750,
        'height' => 600,
        'resizable' => false,
    ),
));

echo '<iframe src="" name="frameDetail" width="100%" height="500">
</iframe>';

$this->endWidget();
?>