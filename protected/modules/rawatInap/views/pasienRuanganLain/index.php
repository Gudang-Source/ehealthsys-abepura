<div class="white-container">
    <legend class="rim2">Informasi <b>Pasien Pindahan</b></legend>
    <?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form.js'); ?>

    <?php
     $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
     $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai

    Yii::app()->clientScript->registerScript('cari wew', "
    $('#daftarPasien-form').submit(function(){
            $('#daftarPasien-grid').addClass('animation-loading');
            $.fn.yiiGridView.update('daftarPasien-grid', {
                    data: $(this).serialize()
            });
            return false;
    });
    ");
    ?>
    <div class="block-tabel">
        <h6>Tabel <b>Pasien Pindahan</b></h6>
        <?php
            $this->widget('ext.bootstrap.widgets.BootGridView', array(
                'id'=>'daftarPasien-grid',
                'dataProvider'=>$model->searchPasienPindahan(),
        //                'filter'=>$model,
                        'template'=>"{summary}\n{items}\n{pager}",

                        'itemsCssClass'=>'table table-striped table-condensed',
                'columns'=>array(
                            array(
                                'header' => 'Tanggal Pendaftaran/ No Pendaftaran',
                                'value' => 'MyFormatter::formatDateTimeForUser($data->tgl_pendaftaran)."/ ".$data->no_pendaftaran'
                            ),
                            array(
                               'header'=>'Tanggal Masuk',                               
                               'type'=>'raw',
                                'value'=>'MyFormatter::formatDateTimeForUser($data->tglpindahkamar)'
                            ),                            
                            array(
                                'header'=>'No Rekam Medik',
                                'type'=>'raw',
                                'value'=>'$data->no_rekam_medik',
                            ),
                            array(
                                'header'=>'Nama Pasien',
                                'value'=>'$data->namadepan." ".$data->nama_pasien'
                            ),
                            array(
                                'header'=>'Jenis Kelamin/ Umur',                                
                                'value'=>'$data->jeniskelamin."/ ".$data->umur',
                            ),     
                            array(
                                'header'=>'Jenis Kasus Penyakit',                                
                                'type'=>'raw',
                                'value'=>'$data->jeniskasuspenyakit_nama',
                            ),
                            array(
                                'header'=>'Cara Bayar / Penjamin',
                                'value'=>'$data->caraBayarPenjamin',
                            ),
                            array(
                               'header'=>'Dokter PJP',
                                'type'=>'raw',
                                'value'=>'$data->nama_pegawai',
                                'value'=>'$data->gelardepan." ".$data->nama_pegawai." ".$data->gelarbelakang_nama',
                            ),
                            
                            array(
                                'header'=>'Kelas Pelayanan',                                
                                'type'=>'raw',
                                'value'=>'$data->kelaspelayanan_nama',
                            ),
                            
                            array(
                                'header'=>'Ruangan Asal',
                                'name'=>'ruanganasal_nama',
                                'type'=>'raw',
                                'value'=>'$data->ruanganasal_nama',
                            ),
                            array(
                                'header'=>'Kamar Ruangan',
                                'type'=>'raw',
                                'value'=> function($data){
                                    $mkamar = MasukkamarT::model()->find(" pindahkamar_id = ".$data->pindahkamar_id);
                                    
                                    if(count($mkamar) > 0){
                                        if (!empty($mkamar->kamarruangan_id)){
                                            return $mkamar->kamarruangan->kamarruangan_nokamar." - ".$mkamar->kamarruangan->kamarruangan_nobed;
                                        }else{
                                            return '-';
                                        }
                                    }
                                }//'$data->kamarruangan_nokamar." - ".$data->kamarruangan_nobed'
                            ),
                            /*array(
                               'header'=>'Masuk Kamar / Batal',
                               'type'=>'raw',
                               'value'=>'isset($data->masukkamar_id) ? ( isset($data->cekTindakanDanObat()->ada) ? CHtml::link("Sedang Diperiksa", "#",array("title"=>"Silahkan batalkan dulu ".$data->cekTindakanDanObat()->msg."!")) : CHtml::link("<i class=icon-form-silang></i>","#",array("rel"=>"tooltip","title"=>"Klik Untuk Batal Pindah Kamar","onclick"=>"{batalPindahKamar($data->pindahkamar_id,$data->masukkamar_id);}"))) : CHtml::link("<i class=icon-home></i>","#",array("rel"=>"tooltip","title"=>"Klik Untuk Memasukan Pasien Ke kamar","onclick"=>"{buatSessionMasukKamar($data->kelaspelayanan_id,$data->pendaftaran_id); addMasukKamar(); $(\'#dialogMasukKamar\').dialog(\'open\');}"))',    
                            ),*/

                    ),
                'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
            ));


        ?>
    </div>
    <?php echo $this->renderPartial('_formPencarian', array('model'=>$model,'format'=>$format)); ?>
    <?php 
    // Dialog untuk masukkamar_t =========================
    $this->beginWidget('zii.widgets.jui.CJuiDialog', array( 
        'id'=>'dialogMasukKamar',
        'options'=>array(
            'title'=>'Masuk Kamar Rawat Inap',
            'autoOpen'=>false,
            'modal'=>true,
            'minWidth'=>800,
            'minHeight'=>200,
            'resizable'=>false,
        ),
    ));

    echo '<div class="divForForm"></div>';


    $this->endWidget();
    //========= end masukkamar_t dialog =============================
    ?>
</div>
<script>
function addMasukKamar()
{
    
    <?php 
            echo CHtml::ajax(array(
            'url'=>Yii::app()->createUrl('rawatInap/pasienRuanganLain/insertMasukKamar'),
            'data'=> "js:$(this).serialize()",
            'type'=>'post',
            'dataType'=>'json',
            'success'=>"function(data)
            {
                if (data.status == 'create_form')
                {
                    $('#dialogMasukKamar div.divForForm').html(data.div);
                    $('#dialogMasukKamar div.divForForm form').submit(addMasukKamar);
                    
                    jQuery('.dtPicker3').datetimepicker(jQuery.extend({showMonthAfterYear:false}, 
                    jQuery.datepicker.regional['id'], {'dateFormat':'dd M yy','minDate'  : 'd','timeText':'Waktu','hourText':'Jam',
                         'minuteText':'Menit','secondText':'Detik','showSecond':true,'timeOnlyTitle':'Pilih   Waktu','timeFormat':'hh:mm:ss','changeYear':true,'changeMonth':true,'showAnim':'fold'}));
                    
                    jQuery('#MasukkamarT_jammasukkamar').timepicker(jQuery.extend({showMonthAfterYear:false}, 
                    jQuery.datepicker.regional['id'], {'dateFormat':'dd M yy',
                   'timeText':'Waktu','hourText':'Jam','minuteText':'Menit','secondText':'Detik','showSecond':true,'timeOnlyTitle':'Pilih Waktu','timeFormat':'hh:mm:ss','changeYear':true,'changeMonth':true,'showAnim':'fold'}));
                    
                }
                else
                {
                    $('#dialogMasukKamar div.divForForm').html(data.div);
                    $.fn.yiiGridView.update('daftarPasien-grid');
                    setTimeout(\"$('#dialogMasukKamar').dialog('close') \",1000);
                }
 
            } ",
    ))
?>;
    return false; 
}
</script>

<?php
$urlSessionMasukKamar = Yii::app()->createUrl('rawatInap/pasienRuanganLain/buatSessionMasukKamar ');
$jscript = <<< JS
function buatSessionMasukKamar(kelaspelayanan_id, pendaftaran_id)
{
    $.post("${urlSessionMasukKamar}", { kelaspelayanan_id: kelaspelayanan_id,pendaftaran_id: pendaftaran_id },
        function(data){
            'sukses';
    }, "json");
}
JS;
Yii::app()->clientScript->registerScript('jsMasukKamar',$jscript, CClientScript::POS_BEGIN);
?>
<?php
$url = Yii::app()->createUrl('rawatInap/pasienRuanganLain/batalPindahKamar');
$mds = Yii::t('mds','Anda yakin akan membatalkan pindah kamar?');
$jscript = <<< JS
function batalPindahKamar(idPindahKamar,idMasukKamar)
{
    if(confirm("${mds}"))
    {
        $.post("${url}", { idPindahKamar: idPindahKamar, idMasukKamar: idMasukKamar },
            function(data){
                if(data.status == 'true')
                {
                    $('#dialogSuksesBatalPindah').dialog('open');
                    $.fn.yiiGridView.update('daftarPasien-grid');
                    $('#dialogBatalPindah div.divForForm').html(data.div);
                    setTimeout("$('#dialogSuksesBatalPindah').dialog('close') ",1000);
                }
                else
                {
                    $('#dialogGagalBatalPindah').dialog('open');
                    $.fn.yiiGridView.update('daftarPasien-grid');
                    $('#dialogBatalPindah div.divForForm').html(data.div);
                    setTimeout("$('#dialogSuksesBatalPindah').dialog('close') ",1000);
                }
        }, "json");
    }
}
JS;
Yii::app()->clientScript->registerScript('jsBatalPindah',$jscript, CClientScript::POS_BEGIN);
?>
