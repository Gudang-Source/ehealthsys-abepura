<div class="white-container">
    <legend class="rim2">Informasi <b>Pemulasaran Jenazah</b></legend>
    <?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form.js'); ?>
    <?php
        $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
        $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai

       Yii::app()->clientScript->registerScript('cari wew', "
       $('#daftarPasien-form').submit(function(){
               $.fn.yiiGridView.update('daftarPasien-grid', {
                       data: $(this).serialize()
               });
               return false;
       });
       ");
    ?>
    <div class="block-tabel">
        <h6>Tabel <b>Pemulasaran Jenazah</b></h6>
        <?php
        $this->widget('ext.bootstrap.widgets.BootGridView', array(
            'id'=>'daftarPasien-grid',
            'dataProvider'=>$model->search(),
    //        'filter'=>$model,
            'template'=>"{summary}\n{items}\n{pager}",
            'itemsCssClass'=>'table table-striped table-condensed',
            'columns'=>array(
                        'tgl_pendaftaran',
                        'no_pendaftaran',
                        'no_rekam_medik',
                        array(
                            'header'=>'Nama Pasien / Alias',
                            'value'=>'$data->namaPasienNamaBin'
                        ),
                        'caramasuk_nama',
                        'instalasiasal_nama',
                        'alamat_pasien',
                        'carabayar_nama',
                        'penjamin_nama',
                        array(
                            'header'=>'Tindakan & Pelayanan',
                            'type'=>'raw',
                            'htmlOptions'=>array('style'=>'text-align:left;'),
                            'value'=>'CHtml::Link("<i class=\"icon-form-tindakan\"></i>",Yii::app()->controller->createUrl("TindakanPelayanan/Index",array("pendaftaran_id"=>$data->pendaftaran_id,"instalasi_id"=>Params::INSTALASI_ID_RD)),
                                        array("class"=>"", 
                                              "target"=>"",
                                              "rel"=>"tooltip",
                                              "title"=>"Klik untuk Tindakan & Pelayanan",
                                        ))'
                        ),
                        array(
                            'header'=>'Ambil Jenazah',
                            'type'=>'raw',
                            'htmlOptions'=>array('style'=>'text-align:left;'),
                            'value'=>'(PJAmbiljenazahT::getStatusJenazah($data->pasien_id) > 0)? "Jenazah sudah diambil" : CHtml::Link("<i class=\"icon-form-ambiljenazah\"></i>",Yii::app()->controller->createUrl("AmbilJenazah/Index",array("pendaftaran_id"=>$data->pendaftaran_id,"idInstalasi"=>Params::INSTALASI_ID_RD)),
                                        array("class"=>"", 
                                              "target"=>"",
                                              "rel"=>"tooltip",
                                              "title"=>"Klik untuk Ambil Jenazah",
                                        ))'
                        ),
                        array(
                            'header'=>'Pemakaian Mobil Jenazah',
                            'type'=>'raw',
                            'htmlOptions'=>array('style'=>'text-align:left;'),
                            'value'=>'CHtml::Link("<i class=\"icon-form-pakaiambulans\"></i>",Yii::app()->controller->createUrl("PemakaianMobil/index",array("pendaftaran_id"=>$data->pendaftaran_id,"idInstalasi"=>Params::INSTALASI_ID_RD)),
                                        array("class"=>"", 
                                              "target"=>"",
                                              "rel"=>"tooltip",
                                              "title"=>"Klik untuk Memakai Mobil Jenazah",
                                        ))'
                        ),
                        array(
                            'header'=>'Surat Ket. Meninggal',
                            'type'=>'raw',
                            'htmlOptions'=>array('style'=>'text-align:left;'),
                            'value'=>'CHtml::Link("<i class=\"icon-form-skm\"></i>",Yii::app()->controller->createUrl("suratKeterangan/SuratKematian",array("pendaftaran_id"=>$data->pendaftaran_id,"idInstalasi"=>Params::INSTALASI_ID_RD)),
                                        array("class"=>"", 
                                              "target"=>"iframeCetakSurat",
                                              "onclick"=>"$(\"#dialogCetakSurat\").dialog(\"open\");",
                                              "rel"=>"tooltip",
                                              "title"=>"Klik untuk membuat Surat Keterangan Kematian",
                                        ))'
                        ),

                ),
            'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
        ));
        ?>
    </div>
    <?php $this->renderPartial('_searchDaftarPasien',array('model'=>$model,'format'=>$format)); ?>
</div>
<?php 
// Dialog untuk masuk kamar jenazah =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( 
    'id'=>'dialogCetakSurat',
    'options'=>array(
        'title'=>'Print Surat Keterangan',
        'autoOpen'=>false,
        'modal'=>true,
        'minWidth'=>950,
        'minHeight'=>450,
        'resizable'=>true,
    ),
));
?>

<iframe src="" name="iframeCetakSurat" width="100%" height="500">
</iframe>

<?php
$this->endWidget();
//========= end masuk kamar jenazah =============================
?>

<script>
document.getElementById('PJPasienmasukpenunjangV_tgl_awal_date').setAttribute("style","display:none;");
document.getElementById('PJPasienmasukpenunjangV_tgl_akhir_date').setAttribute("style","display:none;");
function cekTanggal(){
    var checklist = $('#PJPasienmasukpenunjangV_ceklis');
    var pilih = checklist.attr('checked');
    if(pilih){
        document.getElementById('PJPasienmasukpenunjangV_tgl_awal_date').setAttribute("style","display:block;");
        document.getElementById('PJPasienmasukpenunjangV_tgl_akhir_date').setAttribute("style","display:block;");
    }else{
        document.getElementById('PJPasienmasukpenunjangV_tgl_awal_date').setAttribute("style","display:none;");
        document.getElementById('PJPasienmasukpenunjangV_tgl_akhir_date').setAttribute("style","display:none;");
    }
}            
</script>