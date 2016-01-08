<div class="white-container">
    <legend class="rim2">Informasi <b>Pasien Meninggal</b></legend>
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
        <h6>Tabel <b>Pasien Meninggal</b></h6>
        <?php
        $this->widget('ext.bootstrap.widgets.BootGridView', array(
            'id'=>'daftarPasien-grid',
            'dataProvider'=>$model->searchPasien(),
    //        'filter'=>$model,
            'template'=>"{summary}\n{items}\n{pager}",
            'itemsCssClass'=>'table table-striped table-condensed',
            'columns'=>array(
                                            array(
                                            'name'=>'tgl_pendaftaran',
                                            'type'=>'raw',
                                            'value'=>'MyFormatter::formatDateTimeForUser($data->tgl_pendaftaran)',
                                            ),
                        'no_pendaftaran',
                        'no_rekam_medik',
                        array(
                            'header'=>'Nama Pasien / Panggilan',
                            'value'=>'$data->namaPasienNamaBin'
                        ),
                        array(
                            'header'=>'Cara Masuk',
                            'value'=>'$data->caramasuk_nama'
                        ),
                        array(
                            'header'=>'Instalasi',
                            'value'=>'$data->instalasi_nama'
                        ),
                        'alamat_pasien',
                        array(
                            'header'=>'Cara Bayar',
                            'value'=>'$data->carabayar_nama'
                        ),
                        array(
                            'header'=>'Penjamin',
                            'value'=>'$data->penjamin_nama'
                        ),
                        array(
                            'header'=>'Kondisi Pulang',
                            'value'=>'$data->kondisipulang'
                        ),
                        array(
                            'header'=>'Masuk Kamar Jenazah',
                            'type'=>'raw',
                            'htmlOptions'=>array('style'=>'text-align:left;'),
                            'value'=>'($data->pasienmasukpenunjang_id!=null)?"Sudah Masuk":CHtml::Link("<i class=\"icon-form-mkjenazah\"></i>",Yii::app()->controller->createUrl("masukKamarJenazah/index",array("pendaftaran_id"=>$data->pendaftaran_id,"instalasi_id"=>Params::INSTALASI_ID_RD)),
                                        array("class"=>"", 
                                              "target"=>"iframeMasukKamar",
                                              "onclick"=>"$(\"#dialogMasukKamar\").dialog(\"open\");",
                                              "rel"=>"tooltip",
                                              "title"=>"Klik untuk masuk kamar",
                                        ))'
                        )

                ),
            'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
        ));
        ?>
    </div>
    <?php $this->renderPartial('_searchPasienMeninggal',array('model'=>$model,'format'=>$format)); ?>
</div>
<?php 
// Dialog untuk masuk kamar jenazah =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( 
    'id'=>'dialogMasukKamar',
    'options'=>array(
        'title'=>'Masuk Kamar Jenazah',
        'autoOpen'=>false,
        'modal'=>true,
        'minWidth'=>950,
        'minHeight'=>450,
        'resizable'=>true,
    ),
));
?>

<iframe src="" name="iframeMasukKamar" width="100%" height="450">
</iframe>

<?php
$this->endWidget();
//========= end masuk kamar jenazah =============================
?>
<script>
document.getElementById('PJDaftarpasienmeninggalV_tgl_awal_date').setAttribute("style","display:none;");
document.getElementById('PJDaftarpasienmeninggalV_tgl_akhir_date').setAttribute("style","display:none;");
function cekTanggal(){
    var checklist = $('#PJDaftarpasienmeninggalV_ceklis');
    var pilih = checklist.attr('checked');
    if(pilih){
        document.getElementById('PJDaftarpasienmeninggalV_tgl_awal_date').setAttribute("style","display:block;");
        document.getElementById('PJDaftarpasienmeninggalV_tgl_akhir_date').setAttribute("style","display:block;");
    }else{
        document.getElementById('PJDaftarpasienmeninggalV_tgl_awal_date').setAttribute("style","display:none;");
        document.getElementById('PJDaftarpasienmeninggalV_tgl_akhir_date').setAttribute("style","display:none;");
    }
}            
</script>
