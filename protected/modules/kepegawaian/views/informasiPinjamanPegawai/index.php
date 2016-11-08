
<div class="white-container">
    <legend class="rim2">Informasi <b>Pinjaman Pegawai</b></legend>
    <?php
    $this->breadcrumbs=array(
            'Kppenggajianpeg Ts'=>array('index'),
            'Manage',
    );
    Yii::app()->clientScript->registerScript('search', "
    $('.search-button').click(function(){
            $('.search-form').toggle();
            return false;
    });
    $('#search').submit(function(){
            $.fn.yiiGridView.update('kppenggajianpeg-t-grid', {
                    data: $(this).serialize()
            });
            return false;
    });
    ");

    $this->widget('bootstrap.widgets.BootAlert'); ?>
    <div class="block-tabel">
        <h6>Tabel <b>Pinjaman Pegawai</b></h6>
        <?php $this->widget('ext.bootstrap.widgets.BootGridView',array(
            'id'=>'kppenggajianpeg-t-grid',
            'dataProvider'=>$model->searchTabel(),
            'template'=>"{summary}\n{items}\n{pager}",
            'itemsCssClass'=>'table table-striped table-condensed',
            'columns'=>array( 
                    array(
                            'header'=>'NIP',
                            'name'=>'nomorindukpegawai',
                            'value'=>'$data->nomorindukpegawai',
                    ),
                    array(
                            'header'=>'Nama Pegawai',
                            'name'=>'nama_pegawai',
                            'value'=>'$data->gelardepan." ".$data->nama_pegawai',
                    ),
                    'nopinjam',
                    array(
                            'name'=>'tglpinjampeg',
                            'value'=>'MyFormatter::formatDateTimeForUser(date("Y-m-d", strtotime($data->tglpinjampeg)))',
                    ),
                    array(
                            'name'=>'tgljatuhtempo',
                            'value'=>'MyFormatter::formatDateTimeForUser(date("Y-m-d", strtotime($data->tglpinjampeg)))',
                    ),
                    array(
                            'header'=>'Rincian Pinjaman',
                            'type'=>'raw',
                            'value'=>'CHtml::link("<i class=\'icon-form-detail\'></i>",Yii::app()->createUrl(\'kepegawaian/informasiPinjamanPegawai/detailPinjaman&pinjamanpeg_id=\'.$data->pinjamanpeg_id),array("rel"=>"tooltip","title"=>"Klik untuk Detail Pinjaman","target"=>"iframe", "onclick"=>"$(\"#dialogDetailsPinjaman\").dialog(\"open\");", ))',
                            'htmlOptions'=>array('style'=>'text-align: left; width:60px'),
                            ),
            ),
            'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
        )); ?>
    </div>
    <fieldset class="box">
        <?php $this->renderPartial('_search',array('model'=>$model)); ?>
    </fieldset>
</div>
<?php
// ===========================Dialog Details Penggajian=========================================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
                    'id'=>'dialogDetailsPinjaman',
                        // additional javascript options for the dialog plugin
                        'options'=>array(
                        'title'=>'Rincian Pinjaman Pegawai',
                        'autoOpen'=>false,
                        'width'=>1000,
                        'height'=>500,
                        'resizable'=>true,
                        'scroll'=>false    
                         ),
                    ));
?>
<iframe src="" name="iframe" width="100%" height="100%">
</iframe>
<?php    
$this->endWidget('zii.widgets.jui.CJuiDialog');
//===============================Akhir Dialog Details Penggajian================================
?>