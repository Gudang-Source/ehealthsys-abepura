<div class="white-container">
    <legend class="rim2">Informasi Pemesanan <b>Obat Alkes Masuk</b></legend>
    <?php
    Yii::app()->clientScript->registerScript('search', "
    $('#divSearch-form form').submit(function(){
            $.fn.yiiGridView.update('pemesananobatalkesmasuk-m-grid', {
                    data: $(this).serialize()
            });
            return false;
    });
    ");
    ?>
    <div class="block-tabel">
        <h6>Tabel Pemesanan <b>Obat Alkes Masuk</b></h6>
        <?php $this->widget('ext.bootstrap.widgets.BootGridView',array(
            'id'=>'pemesananobatalkesmasuk-m-grid',
            'dataProvider'=>$model->searchInformasiPemesananMasuk(),
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
                        'header'=>'Keterangan Pemesanan',
                        'name'=>'keterangan_pesan',
                    ),
                    array(
                        'header'=>'Mutasi',
                        'type'=>'raw',
                        'htmlOptions'=>array('style'=>'text-align: left;'),
                        'value'=>'(!empty($data->mutasioaruangan_id) ? "SUDAH DIMUTASI" : (empty($data->terimamutasi_id) ? CHtml::Link("<i class=\"icon-form-mutasi\"></i>","'.$this->getUrlMutasi().'&pesanobatalkes_id=$data->pesanobatalkes_id",
                                array("class"=>"", 
                                    "rel"=>"tooltip",
                                    "title"=>"Klik untuk mutasi obat alkes",
                                )) : "SUDAH DITERIMA"))',
                    ),
                    array(
                        'header'=>'Rincian',
                        'type'=>'raw',
                        'htmlOptions'=>array('style'=>'text-align: left;'),
                        'value'=>'CHtml::Link("<i class=\"icon-form-detail\"></i>","'.$this->getUrlPrint().'&pesanobatalkes_id=$data->pesanobatalkes_id&frame=true",
                                     array("class"=>"", 
                                           "target"=>"pemesananmasuk",
                                           "onclick"=>"$(\"#dialogPemesananMasuk\").dialog(\"open\");",
                                           "rel"=>"tooltip",
                                           "title"=>"Klik untuk melihat rincian pemesanan obat alkes masuk",
                                     ))',
                    ),
            ),
            'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
        )); ?>
    </div>
    <?php echo $this->renderPartial($this->path_view.'search',array('model'=>$model,'format'=>$format,'instalasiPemesanans'=>$instalasiPemesanans,'ruanganPemesanans'=>$ruanganPemesanans)); ?>
    <?php 
    // ===========================Dialog Details=========================================
    $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
                        'id'=>'dialogPemesananMasuk',
                            // additional javascript options for the dialog plugin
                            'options'=>array(
                            'title'=>'Rincian Pemesanan Obat Alkes Masuk',
                            'autoOpen'=>false,
                            'minWidth'=>900,
                            'minHeight'=>100,
                            'resizable'=>false,
                             ),
                        ));
    ?>
    <iframe src="" name="pemesananmasuk" width="100%" height="500">
    </iframe>
    <?php    
    $this->endWidget('zii.widgets.jui.CJuiDialog');
    //===============================Akhir Dialog Details================================
    ?>
</div>