<div class="white-container">
    <legend class="rim2">Informasi <b>Pasien Rujukan</b></legend>
    <div class="block-tabel">
        <h6>Tabel <b>Pasien Rujukan</b></h6>
        <?php 
        $this->widget('bootstrap.widgets.BootAlert'); 
        $this->widget('ext.bootstrap.widgets.BootGridView',array(
            'id'=>'pasienpenunjangrujukan-m-grid',
            'dataProvider'=>$dataProvider,
            'template'=>"{summary}\n{items}\n{pager}",
            'itemsCssClass'=>'table table-striped table-condensed',
            'columns'=>array(
                    'tgl_pendaftaran',
                    'tgl_kirimpasien',
                    // 'ruangan_id',
                    array(
                        'header'=>' Instalasi<br/>Ruangan/Poliklinik Asal',
                        'value'=>'$data->InstalasiNamaRuanganNama',
                    ),
                    'no_pendaftaran',
                    'no_rekam_medik',
                    array(
                        'header'=>'Nama Pasien',
                        'value'=>'$data->NamaPasienNamaBin',
                    ),
                    array(
                        'header'=>'Nama Perujuk',
                        'value'=>'$data->nama_pegawai',
                    ),                
                    array(
                        'header'=>'Cara Bayar / Penjamin',
                        'value'=>'$data->CaraBayarPenjaminNama',
                    ),
                    array(
                        'header'=>'Kelas Pelayanan',
                        'type'=>'raw',
                        'value'=>'$data->kelaspelayanan_nama',
                    ),
                    'jeniskasuspenyakit_nama',
    //                'pendaftaran.umur',
                    'alamat_pasien',
    //                'pemeriksaanrad_nama',
    //                array(
    //                    'header'=>'Periksa',
    //                    'type'=>'raw',
    //                    'value'=>'CHtml::Link("<i class=\"icon-user\"></i>",Yii::app()->controller->createUrl("masukPenunjang/",array("idPasienKirimKeUnitLain"=>$data->pasienkirimkeunitlain_id,"pendaftaran_id"=>$data->pendaftaran_id)),
    //                                    array("class"=>"icon-user", 
    //                                          "id" => "selectPasien",
    //                                          "rel"=>"tooltip",
    //                                          "title"=>"Klik untuk periksa pasien",
    ////                                          "target"=>"blank",
    //                                    ))',
                //TEST BETA
                    array(
                        'header'=>'Periksa',
                        'type'=>'raw',
                        'value'=>'CHtml::Link("<i class=\"icon-form-periksa\"></i>",Yii::app()->controller->createUrl("pendaftaranRadiologiRujukanRS/index",array("pasienkirimkeunitlain_id"=>$data->pasienkirimkeunitlain_id)),
                                        array("class"=>"icon-form-periksa", 
                                              "id" => "selectPasien",
                                              "rel"=>"tooltip",
                                              "title"=>"Klik untuk periksa pasien",
    //                                          "target"=>"blank",
                                        ))',
                        'htmlOptions'=>array('style'=>'text-align:center;'),
                    ),
                    array(
                       'header'=>'Batal Periksa',
                       'type'=>'raw',
                       'value'=>'CHtml::link("<i class=\'icon-form-silang\'></i>", "javascript:batalperiksa($data->pendaftaran_id,$data->pasienkirimkeunitlain_id)",array("id"=>"$data->no_pendaftaran","rel"=>"tooltip","title"=>"Klik untuk membatalkan rujukan"))',
                       'htmlOptions'=>array('style'=>'text-align: center; width:40px'),
                    ),
            ),
            'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
        ));
        ?>
    </div>
    <?php $this->renderPartial('_formSearch',array());?>
<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( 
    'id'=>'dialogKonfirm',
    'options'=>array(
        'title'=>'',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>300,
        'resizable'=>false,
    ),
));
?>
<div class="divForForm"></div>
<?php $this->endWidget(); ?>
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
   function batalperiksa(pendaftaran_id,idKirimUnit)
   {
         myConfirm("Anda yakin akan membatalkan rujukan radiologi pasien ini?","Perhatian!",function(r) {
            if(r){
                $.post('<?php echo Yii::app()->createUrl(Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/' . 'batalRujuk')?>',{pendaftaran_id:pendaftaran_id,idKirimUnit:idKirimUnit},
                          function(data){
                              if(data.status == 'ok'){
                                if(data.smspasien==0){
                                  var params = [];
                                  params = {instalasi_id:<?php echo Yii::app()->user->getState("instalasi_id"); ?>, modul_id:<?php echo Yii::app()->session['modul_id']; ?>, judulnotifikasi:'GAGAL KIRIM SMS PASIEN', isinotifikasi:'Pasien '+data.nama_pasien+' tidak memiliki nomor mobile'}; // 16 
                                  insert_notifikasi(params);
                                }
                                 // window.location = "<?php echo Yii::app()->createUrl(Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/index&succes=2')?>";
                                 myAlert(data.keterangan);
//                                 $('#dialogKonfirm').dialog('open');
                                 $.fn.yiiGridView.update('pasienpenunjangrujukan-m-grid', {
                                   data: $('#search-penunjangrujukan-form').serialize()
                                 });
                                 return false;

                              }
                          },'json'
                      );
            }      
        });
   }

}
</script>
