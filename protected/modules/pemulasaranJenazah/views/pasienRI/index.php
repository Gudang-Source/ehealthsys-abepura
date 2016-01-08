<div class='white-container'>
    <legend class="rim2">Infromasi Pasien <b>Rawat Inap</b></legend>
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
    <div class='block-tabel'>
        <h6>Tabel Pasien <b>Rawat Inap</b></h6>
        <?php
        $this->widget('ext.bootstrap.widgets.BootGridView', array(
            'id'=>'daftarPasien-grid',
            'dataProvider'=>$model->searchRILagi(),
    //                'filter'=>$model,
                    'template'=>"{summary}\n{items}\n{pager}",

                    'itemsCssClass'=>'table table-striped table-condensed',
            'columns'=>array(
                        array(
                           'header'=>'Tanggal Admisi / Masuk Kamar',
                            'type'=>'raw',
                            'value'=>'$data->tglAdmisiMasukKamar'
                        ),
    //                    'ruangan_nama',
                        array(
                           'name'=>'caramasuk_nama',
                            'type'=>'raw',
                            'value'=>'$data->caramasuk_nama',
                        ),
                        array(
                           'header'=>'No. RM / No. Pendaftaran',
                            'type'=>'raw',
                            'value'=>'$data->noRmNoPend',
                        ),
                        array(
                            'header'=>'Nama Pasien / Alias',
                            'value'=>'$data->namaPasienNamaBin'
                        ),
                        array(
                            'name'=>'jeniskelamin',
                            'value'=>'$data->jeniskelamin',
                        ),
                        array(
                            'name'=>'umur',
                            'value'=>'$data->umur',
                        ),
                        array(
                           'name'=>'Dokter',
                            'type'=>'raw',
                            'value'=>'$data->nama_pegawai',
                        ),
                        array(
                            'header'=>'Cara Bayar / Penjamin',
                            'value'=>'$data->caraBayarPenjamin',
                        ),
                        array(
                           'name'=>'kelaspelayanan_nama',
                            'type'=>'raw',
                            'value'=>'$data->kelaspelayanan_nama',
                        ),
                        array(
                           'name'=>'jeniskasuspenyakit_nama',
                            'type'=>'raw',
                            'value'=>'$data->jeniskasuspenyakit_nama',
                        ),
                        array(
                           'name'=>'kamarruangan_nokamar',
                            'type'=>'raw',
                            'htmlOptions'=>array('style'=>'text-align:left;'),
                            'value'=>'(!empty($data->kamarruangan_nokamar) ? $data->kamarruangan_nokamar : "-")',    
                        ),

                        array(
                            'header'=>'Masuk Kamar Jenazah',
                            'type'=>'raw',
                            'htmlOptions'=>array('style'=>'text-align:left;'),
                            'value'=>'CHtml::Link("<i class=\"icon-form-mkjenazah\"></i>",Yii::app()->controller->createUrl("masukPenunjangJenazah/index",array("pendaftaran_id"=>$data->pendaftaran_id,"idInstalasi"=>Params::INSTALASI_ID_RI)),
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
    <?php echo $this->renderPartial('_searchPasienRI', array('model'=>$model,'format'=>$format)); ?>
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
document.getElementById('PJPasienrawatinapV_tgl_awal_date').setAttribute("style","display:none;");
document.getElementById('PJPasienrawatinapV_tgl_akhir_date').setAttribute("style","display:none;");
function cekTanggal(){
    var checklist = $('#PJPasienrawatinapV_ceklis');
    var pilih = checklist.attr('checked');
    if(pilih){
        document.getElementById('PJPasienrawatinapV_tgl_awal_date').setAttribute("style","display:block;");
        document.getElementById('PJPasienrawatinapV_tgl_akhir_date').setAttribute("style","display:block;");
    }else{
        document.getElementById('PJPasienrawatinapV_tgl_awal_date').setAttribute("style","display:none;");
        document.getElementById('PJPasienrawatinapV_tgl_akhir_date').setAttribute("style","display:none;");
    }
}            
</script>
