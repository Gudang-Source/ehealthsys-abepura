<div class="white-container">
    <legend class="rim2">Informasi <b>Pasien Rujukan</b></legend>
    <div class="block-tabel">
        <h6>Tabel <b>Pasien Rujukan</b></h6>
        <?php 
        $this->widget('ext.bootstrap.widgets.BootGridView',array(
            'id'=>'pasienpenunjangrujukan-m-grid',
            'dataProvider'=>$dataProvider,
            'template'=>"{summary}\n{items}\n{pager}",
            'itemsCssClass'=>'table table-striped table-condensed',
            'columns'=>array(
                    'tgl_pendaftaran',
                    'tgl_kirimpasien',
                    array(
                        'header'=>'Instalasi / Ruangan Asal',
                        'value'=>'$data->InstalasiNamaRuanganNama',
                    ),
                    'no_pendaftaran',
                    'no_rekam_medik',
                    array(
                        'header'=>'Nama Pasien',
                        'value'=>'$data->NamaPasienNamaBin',
                    ),
                    array(
                        'header'=>'Cara Bayar / Penjamin',
                        'value'=>'$data->CaraBayarPenjaminNama',
                    ),
                    array(
                        'header'=>'Kasus Penyakit / <br> Kelas Pelayanan',
                        'type'=>'raw',
                        'value'=>'"$data->jeniskasuspenyakit_nama"."<br/>"."$data->kelaspelayanan_nama"',
                    ),
    //                'jeniskasuspenyakit_nama',
    //                'umur',
                    'alamat_pasien',
    //                'pemeriksaanrad_nama',
                    array(
                        'header'=>'Rencana Operasi',
                        'type'=>'raw',
    //                    'value'=>'CHtml::Link("<i class=\"icon-user\"></i>",Yii::app()->controller->createUrl("rujukanPenunjang/masukPenunjang/",array("idPasienKirimKeUnitLain"=>$data->pasienkirimkeunitlain_id,"pendaftaran_id"=>$data->pendaftaran_id)),
                        'value'=>'CHtml::Link("<i class=\"icon-form-roperasi\"></i>",Yii::app()->controller->createUrl("PendaftaranBedahSentralRujukanRS/index/",array("pasienkirimkeunitlain_id"=>$data->pasienkirimkeunitlain_id)),
                                        array("class"=>"icon-form-roperasi", 
                                              "id" => "selectPasien",
                                              "rel"=>"tooltip",
                                              "title"=>"Klik untuk rencana operasi pasien",
                                        ))',                'htmlOptions'=>array('style'=>'text-align: left; width:40px')
                    ),
                    array(
                       'header'=>'Batal Rujukan',
                       'type'=>'raw',
                       'value'=>'CHtml::link("<i class=\'icon-form-silang\'></i>", "javascript:batalRujuk($data->pendaftaran_id,$data->pasienkirimkeunitlain_id)",array("id"=>"$data->no_pendaftaran","rel"=>"tooltip","title"=>"Klik untuk membatalkan rujukan"))',
                       'htmlOptions'=>array('style'=>'text-align: left; width:40px'),
                    ),
            ),
            'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
        ));
        ?>
    </div>
    <fieldset class="box">
        <?php
            $this->renderPartial('_formSearch',array()); 
        ?>
    </fieldset>
</div>
<script type="text/javascript">
document.getElementById('tgl_awal_date').setAttribute("style","display:none;");
document.getElementById('tgl_akhir_date').setAttribute("style","display:none;");
function cekTanggal(){

    var checklist = $('#cbTglMasuk');
    var pilih = checklist.attr('checked');
    if(pilih){
        document.getElementById('tgl_awal_date').setAttribute("style","display:block;");
        document.getElementById('tgl_akhir_date').setAttribute("style","display:block;");
    }else{
        document.getElementById('tgl_awal_date').setAttribute("style","display:none;");
        document.getElementById('tgl_akhir_date').setAttribute("style","display:none;");
    }
}    
{
   function batalRujuk(pendaftaran_id,idKirimUnit)
   {
        myConfirm("Apakah anda yakin akan membatalkan rujukan bedah sentral pasien ini ?","Perhatian!",function(r) {
            if(r){
                $.post('<?php echo Yii::app()->createUrl(Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/' . 'BatalRujuk')?>',{pendaftaran_id:pendaftaran_id,idKirimUnit:idKirimUnit},
                          function(data){
                              if(data.status == 'ok'){
                                 window.location = "<?php echo Yii::app()->createUrl(Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/index&succes=2')?>";
                                 $('#dialogKonfirm div.divForForm').html(data.keterangan);
                                 $('#dialogKonfirm').dialog('open');
                              }
                          },'json'
                      );
            }
        });
   }

}
</script>
<?php 
// Dialog untuk masukkamar_t =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( 
    'id'=>'dialogKonfirm',
    'options'=>array(
        'title'=>'',
        'autoOpen'=>false,
        'modal'=>true,
        'minWidth'=>500,
        'minHeight'=>200,
        'resizable'=>false,
    ),
));

echo '<div class="divForForm"></div>';


$this->endWidget();
//========= end masukkamar_t dialog =============================
?>