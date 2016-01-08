<div class="white-container">
    <legend class="rim2">Informasi Pembayaran <b>Jasa Dokter</b></legend>
    <div class="block-tabel">
        <h6>Tabel Pembayaran <b>Jasa Dokter</b></h6>
        <?php
        $this->breadcrumbs=array(
                'Informasi Pembayaran Jasa Dokter',
        );

        Yii::app()->clientScript->registerScript('search', "
        $('.search-button').click(function(){
                $('.search-form').toggle();
                return false;
        });
        $('.search-form form').submit(function(){
                $.fn.yiiGridView.update('gjpembayaranjasa-t-grid', {
                        data: $(this).serialize()
                });
                return false;
        });
        ");

        $this->widget('bootstrap.widgets.BootAlert'); ?>

        <?php //echo CHtml::link(Yii::t('mds','{icon} Advanced Search',array('{icon}'=>'<i class="icon-search"></i>')),'#',array('class'=>'search-button btn')); ?>
        <!-- search-form -->

        <?php $this->widget('ext.bootstrap.widgets.BootGridView',array(
            'id'=>'gjpembayaranjasa-t-grid',
            'dataProvider'=>$model->searchInformasi(),
            //'filter'=>$model,
            'template'=>"{summary}\n{items}\n{pager}",
            'itemsCssClass'=>'table table-striped table-condensed',
            'columns'=>array(
                    'nobayarjasa',
                    'tglbayarjasa',
                    array(
                        'header'=>'Dokter RS / Perujuk',
                        'type'=>'raw',
                        'value'=>'empty($data->rujukandari_id) ? $data->pegawai->NamaLengkap : $data->rujukandari->namaperujuk',
                    ),
                    'periodejasa',
                    'sampaidgn',
                    array(
                        'name'=>'tandabuktikeluar_id',
                        'type'=>'raw',
                        'value'=>'empty($data->tandabuktikeluar_id) ? "<center>-</center>" : $data->tandabuktikeluar->nokaskeluar',
                    ),
                    array(
                        'name'=>'totaltarif',
                        'type'=>'raw',
                        'value'=>'MyFormatter::formatUang($data->totaltarif)',
                    ),
                    array(
                        'name'=>'totaljasa',
                        'type'=>'raw',
                        'value'=>'MyFormatter::formatUang($data->totaljasa)',
                    ),
                    array(
                        'name'=>'totalbayarjasa',
                        'type'=>'raw',
                        'value'=>'MyFormatter::formatUang($data->totalbayarjasa)',
                    ),
                    array(
                        'name'=>'totalsisajasa',
                        'type'=>'raw',
                        'value'=>'MyFormatter::formatUang($data->totalsisajasa)',
                    ),
                    array(
                        'header'=>'Detail',
                        'type'=>'raw',
                        'value'=>'CHtml::Link("<i class=\"icon-form-detail\"></i>",Yii::app()->controller->createUrl(Yii::app()->controller->id."/lihatDetail",array("id"=>$data->pembayaranjasa_id)),
                                        array("class"=>"", 
                                              "target"=>"iframeDetail",
                                              "onclick"=>"$(\"#dialogDetail\").dialog(\"open\");",
                                              "rel"=>"tooltip",
                                              "title"=>"Klik untuk melihat Rincian Transaksi",
                                        ))',          
                        'htmlOptions'=>array('style'=>'text-align: center; width:40px')
                    ),
            ),
            'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
        )); ?>
    </div>
    <fieldset class="box">
        <legend class="rim"><i class="icon-white icon-search"></i> Pencarian</legend>
        <div class="search-form">
            <?php $this->renderPartial($this->path_view. '_search',array(
                    'model'=>$model,
            )); ?>
        </div>
    </fieldset>
</div>
<?php 
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( 
    'id'=>'dialogDetail',
    'options'=>array(
        'title'=>'Rincian Pembayaran Jasa Dokter',
        'autoOpen'=>false,
        'modal'=>true,
        'minWidth'=>840,
        'minHeight'=>400,
        'resizable'=>true,
    ),
));
?>
<iframe src="" name="iframeDetail" width="100%" height="550" >
</iframe>
<?php
$this->endWidget();
?>
