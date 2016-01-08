<?php
Yii::app()->clientScript->registerScript('search', "
$('#divSearch-form form').submit(function(){
        $('#pemesananobatalkeskeluar-m-grid').addClass('animation-loading');
	$.fn.yiiGridView.update('pemesananobatalkeskeluar-m-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>
<div class="white-container">
    <legend class="rim2">Informasi Pemesanan <b>Obat Alkes Keluar</b></legend>
    <div class="block-tabel">
        <h6>Tabel Pemesanan <b>Obat Alkes Keluar</b></h6>
        <?php $this->widget('ext.bootstrap.widgets.BootGridView',array(
                'id'=>'pemesananobatalkeskeluar-m-grid',
                'dataProvider'=>$model->searchInformasiPemesananKeluar(),
                'template'=>"{summary}\n{items}\n{pager}",
                'itemsCssClass'=>'table table-striped table-condensed',
                'columns'=>array(
                        array(
                            'name'=>'tglpemesanan',
                            'type'=>'raw',
                            'value'=>'MyFormatter::formatDateTimeForUser($data->tglpemesanan)',
                        ),
                        'nopemesanan',
                        'ruanganpemesan_nama',
                        'ruangantujuan_nama',
                        'statuspesan',
                        array(
                            'name'=>'pegawaipemesan_id',
                            'type'=>'raw',
                            'value'=>'$data->PegawaiPemesanLengkap',
                        ),
                        array(
                            'name'=>'pegawaimengetahui_id',
                            'type'=>'raw',
                            'value'=>'$data->PegawaiMengetahuiLengkap',
                        ),
                        array(
                            'header'=>'Mutasi',
                            'type'=>'raw',
        //                    'value'=>'$data->terimamutasi_id',
                            'value'=>'(!empty($data->mutasioaruangan_id) ? "SUDAH DIMUTASI" : !empty($data->terimamutasi_id) ? "SUDAH DITERIMA" : "BELUM DIMUTASI")',
                        ),
                        array(
                            'header'=>'Rincian',
                            'type'=>'raw',
                            'value'=>'CHtml::Link("<i class=\"icon-form-detail\"></i>","'.$this->getUrlPrint().'&pesanobatalkes_id=$data->pesanobatalkes_id&frame=true",
                                         array("class"=>"", 
                                               "target"=>"pemesanankeluar",
                                               "onclick"=>"$(\"#dialogPemesananKeluar\").dialog(\"open\");",
                                               "rel"=>"tooltip",
                                               "title"=>"Klik untuk melihat rincian pemesanan obat alkes keluar",
                                         ))',
                            'htmlOptions'=>array('style'=>'text-align:left;'),
                        ),
                ),
                'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
        )); ?>
    </div>
    <?php echo $this->renderPartial($this->path_view.'search',array('model'=>$model,'format'=>$format,'instalasiPemesanans'=>$instalasiPemesanans,'ruanganPemesanans'=>$ruanganPemesanans)); ?>

    <?php 
    // ===========================Dialog Details=========================================
    $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
                        'id'=>'dialogPemesananKeluar',
                            // additional javascript options for the dialog plugin
                            'options'=>array(
                            'title'=>'Rincian Pemesanan Obat Alkes Keluar',
                            'autoOpen'=>false,
                            'minWidth'=>900,
                            'minHeight'=>100,
                            'resizable'=>false,
                             ),
                        ));
    ?>
    <iframe src="" name="pemesanankeluar" width="100%" height="500">
    </iframe>
    <?php    
    $this->endWidget('zii.widgets.jui.CJuiDialog');
    //===============================Akhir Dialog Details================================
    ?>
</div>