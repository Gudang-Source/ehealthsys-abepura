<div class="white-container">
    <legend class="rim2">Daftar Pasien <b>Rawat Darurat</b></legend>
    <?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form.js'); ?>

    <?php
     $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
     $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
     $modul  = $this->module->name; 
     $control = $this->id;
    Yii::app()->clientScript->registerScript('cari wew', "
    $('#daftarPasien-form').submit(function(){
            $.fn.yiiGridView.update('daftarPasien-grid', {
                    data: $(this).serialize()
            });
            return false;
    });
    ");
    ?>
    <?php $this->widget('bootstrap.widgets.BootAlert');	?>
    <div class="block-tabel">
        <h6>Tabel Pasien <b>Rawat Darurat</b></h6>
        <?php echo $this->renderPartial('_tablePasien', array('model'=>$model));  ?> 
        <?php $this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
            'id' => 'dialogRincian',
            'options' => array(
                'title' => 'Rincian Tagihan Pasien',
                'autoOpen' => false,
                'modal' => true,
                'width' => 900,
                'height' => 550,
                'resizable' => false,
            ),
        ));
        ?>
        <iframe name='frameRincian' width="100%" height="100%"></iframe>
        <?php $this->endWidget(); ?>
    </div>
    <?php 
    // Dialog untuk kirim dokumen RM =========================
    $this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
        'id' => 'dialogStatusDokumen',
        'options' => array(
            'title' => 'Pengiriman Dokumen Ke-Ruangan Lain',
            'autoOpen' => false,
            'modal' => true,
            'zIndex'=>1002,
            'width' => 1000,
            'height' => 400,
            'resizable' => true,
            'close'=>"js:function(){ $.fn.yiiGridView.update('daftarPasien-grid', {
                data: $('#daftarPasien-form').serialize()
            }); }",
        ),
    ));
    ?>
    <iframe name='frameStatusDokumen' width="100%" height="100%"></iframe>
    <?php $this->endWidget(); 
    // end ============== ?>
    <?php
    $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
            'action'=>Yii::app()->createUrl($this->route),
            'method'=>'get',
            'id'=>'daftarPasien-form',
            'type'=>'horizontal',
            'focus'=>'#'.CHtml::activeId($model,'no_pendaftaran'),
            'htmlOptions'=>array(),

    )); ?>
    <fieldset class="box">
        <legend class="rim"><i class="icon-white icon-search"></i> Pencarian</legend>
        <table width="100%" class="table-condensed">
            <tr>
                <td>
                    <div class="control-group ">
                        <label for="namaPasien" class="control-label">
                            <?php // echo CHtml::activecheckBox($model, 'ceklis', array('uncheckValue'=>0,'onClick'=>'cekTanggal()','rel'=>'tooltip' ,'data-original-title'=>'Cek untuk pencarian berdasarkan tanggal')); ?>
                            Tanggal Masuk 
                        </label>
                        <div class="controls">
                            <?php $model->tgl_awal = $format->formatDateTimeForUser($model->tgl_awal); ?>
                            <?php   $format = new MyFormatter;
                                    $this->widget('MyDateTimePicker',array(
                                                    'model'=>$model,
                                                    'attribute'=>'tgl_awal',
                                                    'mode'=>'date',
                                                    'options'=> array(
                                                        'dateFormat'=>Params::DATE_FORMAT,
                                                        'maxDate' => 'd',
                                                    ),
                                                    'htmlOptions'=>array('readonly'=>true,'class'=>'dtPicker3'),
                            ));  ?>
                        <?php $model->tgl_awal = $format->formatDateTimeForDb($model->tgl_awal); ?>
                        </div></div>
                                                    <div class="control-group ">
                        <label for="namaPasien" class="control-label">
                           Sampai dengan
                          </label>
                        <div class="controls">
                            <?php $model->tgl_akhir = $format->formatDateTimeForUser($model->tgl_akhir); ?>
                                <?php    $this->widget('MyDateTimePicker',array(
                                                    'model'=>$model,
                                                    'attribute'=>'tgl_akhir',
                                                    'mode'=>'date',
                                                    'options'=> array(
                                                        'dateFormat'=>Params::DATE_FORMAT,
                                                        'maxDate' => 'd',
                                                    ),
                                                    'htmlOptions'=>array('readonly'=>true,'class'=>'dtPicker3'),
                            )); ?>
                            <?php $model->tgl_akhir = $format->formatDateTimeForDb($model->tgl_akhir); ?>
                        </div>
                    </div> 
                         <?php 
                         $item = LookupM::getItems('statusperiksa');
                         unset($item['BATAL PERIKSA']);
                         echo $form->dropDownListRow($model,'statusperiksa', $item,array('empty'=>'-- Pilih --')); ?>

                </td>
                <td>
                     <?php echo $form->textFieldRow($model,'no_pendaftaran',array('class'=>'span3','onkeypress'=>"return $(this).focusNextInputField(event)", 'maxlength'=>50, 'placeholder'=>'Ketik no.pendaftaran')); ?>
                     <?php echo $form->textFieldRow($model,'nama_pasien',array('class'=>'span3','onkeypress'=>"return $(this).focusNextInputField(event)", 'maxlength'=>50, 'placeholder'=>'Ketik nama pasien')); ?>
                     <?php echo $form->textFieldRow($model,'nama_bin',array('class'=>'span3','onkeypress'=>"return $(this).focusNextInputField(event)", 'maxlength'=>50, 'placeholder'=>'Ketik alias/nama panggilan')); ?>
                     <?php echo $form->textFieldRow($model,'no_rekam_medik',array('class'=>'span3','onkeypress'=>"return $(this).focusNextInputField(event)", 'maxlength'=>50, 'placeholder'=>'Ketik no.rekam medik')); ?>
                </td>
                <td>
                    <?php echo $form->dropDownListRow($model, 'pegawai_id', 
                        CHtml::listData(DokterV::model()->findAllByAttributes(array(
                            'instalasi_id'=>Params::INSTALASI_ID_RD,
                            'pegawai_aktif'=>true,
                        ), array(
                            'order'=>'nama_pegawai asc'
                        )), 'pegawai_id', 'namaLengkap'), array('empty'=>'-- Pilih --', 'class'=>'span3')); 
                    ?>
                    <?php 
                    $carabayar = CarabayarM::model()->findAll(array(
                        'condition'=>'carabayar_aktif = true',
                        'order'=>'carabayar_nama ASC',
                    ));
                    foreach ($carabayar as $idx=>$item) {
                        $penjamins = PenjaminpasienM::model()->findByAttributes(array(
                            'carabayar_id'=>$item->carabayar_id,
                            'penjamin_aktif'=>true,
                       ),
                            array('order' => 'penjamin_nama ASC')    
                                );
                       if (empty($penjamins)) unset($carabayar[$idx]);
                    }
                    $penjamin = PenjaminpasienM::model()->findAll(array(
                        'condition'=>'penjamin_aktif = true',
                        'order'=>'penjamin_nama',
                    ));
                    echo $form->dropDownListRow($model,'carabayar_id', CHtml::listData($carabayar, 'carabayar_id', 'carabayar_nama'), array(
                        'empty'=>'-- Pilih --',
                        'class'=>'span3', 
                        'ajax' => array('type'=>'POST',
                            'url'=> $this->createUrl('/actionDynamic/getPenjaminPasien',array('encode'=>false,'namaModel'=>get_class($model))), 
                            'success'=>'function(data){$("#'.CHtml::activeId($model, "penjamin_id").'").html(data); }',
                        ),
                     ));
                    echo $form->dropDownListRow($model,'penjamin_id', CHtml::listData($penjamin, 'penjamin_id', 'penjamin_nama'), array('empty'=>'-- Pilih --', 'class'=>'span3'));
                    ?>
                </td>
            </tr>
        </table>

    <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),
                    array('class'=>'btn btn-primary', 'type'=>'submit','id'=>'btn_simpan',)); 
    echo CHtml::hiddenField('pendaftaran_id');
    echo CHtml::hiddenField('pasien_id');
    ?> 
    <?php echo CHtml::link(Yii::t('mds','{icon} Cancel',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
                            Yii::app()->createUrl($this->module->id.'/daftarPasien/index'), 
                            array('class'=>'btn btn-danger',
                                  'onclick'=>'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'));  ?>
     <?php  
    $content = $this->renderPartial('../tips/informasi',array(),true);
    $this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); 
    ?>

    <?php $this->endWidget();?>
    </fieldset>  

    <?php 
    // Dialog untuk ubah status periksa =========================
    $this->beginWidget('zii.widgets.jui.CJuiDialog', array( 
        'id'=>'dialogUbahStatus',
        'options'=>array(
            'title'=>'Ubah Status Pasien',
            'autoOpen'=>false,
            'modal'=>true,
            'minWidth'=>600,
            'minHeight'=>500,
            'resizable'=>false,
        ),
    ));

    echo '<div class="divForForm"></div>';
$this->endWidget();
//========= end pasienpulang_t dialog =============================

// Dialog untuk Batal Rawat Inap =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( 
    'id'=>'dialogBatalRawatInap',
    'options'=>array(
        'title'=>'Pembatalan Rawat Inap/ Pulang Pasien Rawat Darurat',
        'autoOpen'=>false,
        'modal'=>true,
       'minWidth'=>800,
        'minHeight'=>400,
        'resizable'=>false,
		'close'=>"js:function(){ $.fn.yiiGridView.update('daftarpasien-v-grid', {
                        data: $('#caripasien-form').serialize()
                    }); }",
    ),
));
?>
<iframe src="" name="iframeBatalRawatInap" width="100%" height="400">
</iframe>
<?php

    $this->endWidget();
    //========= end ubah status periksa dialog =============================
    ?>


    <?php 
    // Dialog untuk pasienpulang_t =========================
    $this->beginWidget('zii.widgets.jui.CJuiDialog', array( 
        'id'=>'dialogPasienPulang',
        'options'=>array(
            'title'=>'Tindak Lanjut Pasien Rawat Darurat',
            'autoOpen'=>false,
            'modal'=>true,
            'minWidth'=>800,
            'minHeight'=>600,
            'resizable'=>false,
        ),
    ));?>
    <iframe src="" name="iframePasienPulang" width="100%" height="900">
    </iframe>
    <?php

    $this->endWidget();
    //========= end pasienpulang_t dialog =============================

    // Dialog untuk Batal Rawat Inap =========================
    /*
    $this->beginWidget('zii.widgets.jui.CJuiDialog', array( 
        'id'=>'dialogBatalRawatInap',
        'options'=>array(
            'title'=>'Pembatalan Rawat Inap/ Pulang Pasien Rawat Darurat',
            'autoOpen'=>false,
            'modal'=>true,
            'width'=>800,
            'resizable'=>false,
                    'close'=>"js:function(){ $.fn.yiiGridView.update('daftarPasien-grid', {
                            data: $('#daftarPasien-form').serialize()
                        }); }",
        ),
    ));
    ?>
    <iframe src="" name="iframeBatalRawatInap" width="100%" height="900">
    </iframe>
    <?php

    $this->endWidget(); */
    //========= end ubah status periksa dialog =============================
    ?>


    <?php
    $this->beginWidget('zii.widgets.jui.CJuiDialog', array( 
        'id'=>'loginDialog',
        'options'=>array(
            'title'=>'Login',
            'autoOpen'=>false,
            'modal'=>true,
            'width'=>400,
            'height'=>250,
            'resizable'=>false,
        ),
    ));?>
    <div class="alert alert-block alert-error" id="alertDiv" style="display : none;">
        Kesalahan dalam Pengisian Usename atau Password
    </div>
    <?php echo CHtml::beginForm('', 'POST', array('class'=>'form-horizontal','id'=>'formLogin')); ?>
        <div class="control-group ">
            <?php echo CHtml::label('Login Pemakai','username', array('class'=>'control-label')) ?>
            <div class="controls">
                <?php echo CHtml::textField('username', '', array()); ?>
            </div>
        </div>

        <div class="control-group ">
            <?php echo CHtml::label('Password','password', array('class'=>'control-label')) ?>
            <div class="controls">
                <?php echo CHtml::passwordField('password', '', array()); ?>
            </div>
        </div>

        <div class="form-actions">
            <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Login',array('{icon}'=>'<i class="icon-lock icon-white"></i>')),
                                array('class'=>'btn btn-primary', 'type'=>'submit', 'onclick'=>'cekLogin();return false;')); ?>
             <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')),
                                array('class'=>'btn btn-danger', 'type'=>'button', 'onclick'=>'batal();return false;')); ?>
        </div> 
    <?php echo CHtml::endForm(); ?>
    <?php $this->endWidget();?>


    <!--dialog untuk menampilkan alaasan pembatalan pasien rawat inap-->
    <?php
    $this->beginWidget('zii.widgets.jui.CJuiDialog', array( 
        'id'=>'dialogAlasan',
        'options'=>array(
            'title'=>'Data Pasien',
            'autoOpen'=>false,
            'modal'=>true,
            'width'=>1000,
            'height'=>900,
            'resizable'=>false,
        ),
    ));
    ?>
    <div id="divFormDataPasien"></div>


    <?php echo CHtml::beginForm('', 'POST', array('class'=>'form-horizontal','id'=>'formAlasan')); ?>
    <table>
        <tr>
            <td><?php echo CHtml::label('Alasan','Alasan', array('class'=>'')) ?></td>
            <td>
                <?php echo CHtml::textArea('Alasan', '', array()); ?>
                <?php echo CHtml::hiddenField('idOtoritas', '', array('readonly'=>TRUE)); ?>
                <?php echo CHtml::hiddenField('namaOtoritas', '', array('readonly'=>TRUE)); ?>
                <?php echo CHtml::hiddenField('idPasienPulang', '', array('readonly'=>TRUE)); ?>
                <?php echo CHtml::hiddenField('pendaftaran_id', '', array('readonly'=>TRUE)); ?>

            </td>
        </tr>
    </table>

        <div class="form-actions">
            <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-lock icon-white"></i>')),
                                array('class'=>'btn btn-primary', 'type'=>'submit', 'onclick'=>'simpanAlasan();return false;')); ?>
            <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')),
                                array('class'=>'btn btn-danger', 'type'=>'button', 'onclick'=>'batal();return false;')); ?>    </div> 
    <?php echo CHtml::endForm(); ?>
    <?php $this->endWidget();?>
    <!--akhir dari dialog alasan pasien dibatalkan rewat inap-->

    <?php
    $this->beginWidget('zii.widgets.jui.CJuiDialog', array( 
        'id'=>'konfirmasiDialog',
        'options'=>array(
            'title'=>'Konfirmasi',
            'autoOpen'=>false,
            'modal'=>true,
            'width'=>400,
            'height'=>190,
            'resizable'=>false,
        ),
    ));?>
    <div align="center">
        User Tidak Memiliki Akses Untuk Proses Ini,<br/>
        Yakin Akan Melakukan Ke Proses Selanjutnya ?
    </div>
    <div class="form-actions" align="center">
            <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Yes',array('{icon}'=>'<i class="icon-lock icon-white"></i>')),
                                array('class'=>'btn btn-primary', 'type'=>'button', 'onclick'=>"$('#loginDialog').dialog('open');$('#konfirmasiDialog').dialog('close');")); ?>
            <?php echo CHtml::htmlButton(Yii::t('mds','{icon} No',array('{icon}'=>'<i class="icon-ban-circle icon-white"></i>')),
                                array('class'=>'btn btn-danger', 'type'=>'button', 'onclick'=>"$('#konfirmasiDialog').dialog('close');")); ?>    </div> 

    <?php $this->endWidget();?>

    <?php
    $this->beginWidget('zii.widgets.jui.CJuiDialog', array( 
        'id'=>'konfirmasiAdmisi',
        'options'=>array(
            'title'=>'Konfirmasi',
            'autoOpen'=>false,
            'modal'=>true,
            'width'=>420,
            'height'=>200,
            'resizable'=>false,
        ),
    ));?>
    <div align="center">
        Pasien sudah di rawat di ruangan <div id="ruanganPasien"></div>
        Anda tidak bisa melakukan pembatalan disini,<br/>
        Silahkan hubungi petugas Rawat Inap yang bersangkutan ?
    </div>
    <div id=""></div>
    <div class="form-actions" align="center">
           <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Yes',array('{icon}'=>'<i class="icon-lock icon-white"></i>')),
                                array('class'=>'btn btn-primary', 'type'=>'button', 'onclick'=>"$('#konfirmasiAdmisi').dialog('close');")); ?>  </div> 

    <?php $this->endWidget();?>
    <?php 
    // Dialog untuk tindak lanjut pasien ke RI=========================
    $this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
        'id' => 'dialogTindakLanjut',
        'options' => array(
            'title' => 'Tindak Lanjut Rawat Inap',
            'autoOpen' => false,
            'modal' => true,
            'width' => 950,
            'height' => 550,
            'resizable' => true,
                    'close'=>"js:function(){ $.fn.yiiGridView.update('daftarPasien-grid', {
                            data: $('#daftarPasien-form').serialize()
                        }); }",
        ),
    ));
    ?>
    <iframe name='frameTindakLanjut' width="100%" height="100%"></iframe>
    <?php $this->endWidget(); ?>
</div>
<script type="text/javascript">
    
function batal(){
    $('#loginDialog').dialog('close');
    $('#loginDialog #username').val('');
    $('#loginDialog #password').val('');
    $('#alertDiv').hide(); 
    $('#pasien_id').val('');
    $('#pendaftaran_id').val('');
     
    $('#dialogAlasan').dialog('close');
    $('#dialogAlasan #idOtoritas').val('');
    $('#dialogAlasan #namaOtoritas').val('');
    $('#dialogAlasan #idPasienPulang').val('');
    $('#dialogAlasan #pendaftaran_id').val('');
    
    $.fn.yiiGridView.update('daftarPasien-grid', {
        data: $('#daftarPasienPulang-form').serialize()
    });
}    
function cekHakAkses(pendaftaran_id)
{
//       $('#dialogAlasan #idPasienPulang').val(idPasienPulang);
//       $('#dialogAlasan #pendaftaran_id').val(pendaftaran_id);
//       $('#pasien_id').val(pasien_id);
//       $('#pendaftaran_id').val(pendaftaran_id);
       
//    $('#konfirmasiDialog').dialog('open');

    $.post('<?php echo Yii::app()->createUrl('rawatDarurat/ActionAjax/CekHakAkses');?>', 
    {pendaftaran_id:pendaftaran_id, idUser:'<?php echo Yii::app()->user->id; ?>',useName:'<?php echo Yii::app()->user->name; ?>'}, function(data){
//        console.log(data);
     var cekAdmisi = data.pendaftaran.pasienadmisi_id;
    
     if(cekAdmisi){
         $('#konfirmasiAdmisi').dialog('open');
          $('#konfirmasiAdmisi #ruanganPasien').html(data.ruanganPasien);
     }else{
        $('#konfirmasiDialog').dialog('open');
        if(data.cekAkses==true){
            $('#dialogAlasan').dialog('open');
            $('#dialogAlasan #idOtoritas').val(data.userid);
            $('#dialogAlasan #namaOtoritas').val(data.username);
        } else {
            $('#konfirmasiDialog').dialog('open');
        }
     }
       $('#dialogAlasan #idPasienPulang').val(data.pendaftaran.pasienpulang_id);
       $('#dialogAlasan #pendaftaran_id').val(data.pendaftaran.pendaftaran_id);
       $('#pasien_id').val(data.pendaftaran.pasien_id);
       $('#pendaftaran_id').val(data.pendaftaran.pendaftaran_id);
    }, 'json');
}

function cekLogin()
{
    pasien_id = $('#pasien_id').val();    
    pendaftaran_id = $('#pendaftaran_id').val();    
    $.post('<?php echo Yii::app()->createUrl('ActionAjax/CekLoginPembatalRawatInap');?>', $('#formLogin').serialize(), function(data){
        if(data.error != '')
        $('#'+data.cssError).addClass('error');
        if(data.status=='success'){
              $.post('<?php echo Yii::app()->createUrl('rawatDarurat/ActionAjax/dataPasien');?>', {pasien_id:pasien_id ,pendaftaran_id:pendaftaran_id}, function(dataPasien){
                  
              $('#divFormDataPasien').html(dataPasien.form);

             }, 'json');
                 
            $('#dialogAlasan').dialog('open');
            $('#dialogAlasan #idOtoritas').val(data.userid);
            $('#dialogAlasan #namaOtoritas').val(data.username);
            $('#loginDialog').dialog('close');
        }else{
    $('#alertDiv').show(); 
        }
    }, 'json');
}

function simpanAlasan()
{
    alasan =$('#dialogAlasan #Alasan').val();
    if(alasan==''){
        myAlert('Anda Belum Mengisi Alasan Pembatalan');
    }else{
        $.post('<?php echo Yii::app()->createUrl('rawatDarurat/daftarPasien/BatalRawatInap');?>', $('#formAlasan').serialize(), function(data){
//            if(data.error != '')
//                myAlert(data.error);
//            $('#'+data.cssError).addClass('error');
            if(data.status=='success'){
                batal();
                myAlert('Data Berhasil Disimpan');
            }else{
                myAlert(data.status);
            }
        }, 'json');
   }     
}

function cekStatus(status){
    var status = status;
    myAlert("Pasien "+status+" Tidak bisa melanjutkan pemeriksaan atau tindak lanjut");
}


</script>

<script>
function addPasienPulang(pendaftaran_id,pasien_id)
{
    $('#pendaftaran_id').val(pendaftaran_id);
    $('#pasien_id').val(pasien_id);
    
    <?php 
            echo CHtml::ajax(array(
            'url'=>Yii::app()->createUrl('ActionAjaxRIRD/addPasienPulang'),
            'data'=> "js:$(this).serialize()",
            'type'=>'post',
            'dataType'=>'json',
            'success'=>"function(data)
            {
                if (data.status == 'create_form')
                {
                    $('#dialogPasienPulang div.divForForm').html(data.div);
                    $('#dialogPasienPulang div.divForForm form').submit(addPasienPulang);
                    
                    jQuery('.dtPicker2-5').datetimepicker(jQuery.extend({showMonthAfterYear:false}, 
                    jQuery.datepicker.regional['id'], {'dateFormat':'dd M yy','maxDate'  : 'd','timeText':'Waktu','hourText':'Jam',
                         'minuteText':'Menit','secondText':'Detik','showSecond':true,'timeOnlyTitle':'Pilih   Waktu','timeFormat':'hh:mm:ss','changeYear':true,'changeMonth':true,'showAnim':'fold'}));
                    
                    
                }
                else
                {
                    $('#dialogPasienPulang div.divForForm').html(data.div);
                    $.fn.yiiGridView.update('daftarPasien-grid');
                    setTimeout(\"$('#dialogPasienPulang').dialog('close') \",1000);
                }
 
            } ",
    ))
?>;
    return false; 
}

</script>

<script>
        function ubahStatusPeriksa()
{
    <?php 
            echo CHtml::ajax(array(
            'url'=>Yii::app()->createUrl('ActionAjaxRIRD/ubahStatusPeriksaRD'),
            'data'=> "js:$(this).serialize()",
            'type'=>'post',
            'dataType'=>'json',
            'success'=>"function(data)
            {
                if (data.status == 'create_form')
                {
                    $('#dialogUbahStatus div.divForForm').html(data.div);
                    $('#dialogUbahStatus div.divForForm form').submit(ubahStatusPeriksa);
                    
                    jQuery('.dtPicker3').datetimepicker(jQuery.extend({showMonthAfterYear:false}, 
                    jQuery.datepicker.regional['id'], {'dateFormat':'dd M yy','maxDate'  : 'd','timeText':'Waktu','hourText':'Jam',
                         'minuteText':'Menit','secondText':'Detik','showSecond':true,'timeOnlyTitle':'Pilih   Waktu','timeFormat':'hh:mm:ss','changeYear':true,'changeMonth':true,'showAnim':'fold'}));
                    
                }
                else
                {
                    $('#dialogUbahStatus div.divForForm').html(data.div);
                    $.fn.yiiGridView.update('daftarPasien-grid');
                    setTimeout(\"$('#dialogUbahStatus').dialog('close') \",1000);
                }
 
            } ",
    ))
?>;
    return false; 
}
    
    
    
    
</script>
<script type="text/javascript">
// document.getElementById('RDInfoKunjunganRDV_tgl_awal_date').setAttribute("style","display:none;");
// document.getElementById('RDInfoKunjunganRDV_tgl_akhir_date').setAttribute("style","display:none;");
function cekTanggal(){

    var checklist = $('#RDInfoKunjunganRDV_ceklis');
    var pilih = checklist.attr('checked');
    if(pilih){
        document.getElementById('RDInfoKunjunganRDV_tgl_awal_date').setAttribute("style","display:block;");
        document.getElementById('RDInfoKunjunganRDV_tgl_akhir_date').setAttribute("style","display:block;");
    }else{
        document.getElementById('RDInfoKunjunganRDV_tgl_awal_date').setAttribute("style","display:none;");
        document.getElementById('RDInfoKunjunganRDV_tgl_akhir_date').setAttribute("style","display:none;");
    }
}
$('document').ready(function(){
    $('#daftarPasien-grid button').each(function(){
        $('#orange').removeAttr('class');
        $('#red').removeAttr('class');
        $('#green').removeAttr('class');
        $('#blue').removeAttr('class');

        $('#orange').attr('class','btn btn-danger-blue');
        $('#red').attr('class','btn btn-danger-red');
        $('#green').attr('class','btn btn-danger');
        $('#blue').attr('class','btn btn-danger-yellow');
    });

});
function setStatus(obj,status,idpendaftaran){
    var status = status;
    var idpendaftaran = idpendaftaran;
    myConfirm("Yakin Akan Merubah Status Periksa Pasien?","Perhatian!",function(r) {
        if (r){
    //            myAlert(status);
    //            myAlert(idpendaftaran);
              $.post('<?php echo Yii::app()->createUrl('ActionAjaxRIRD/UbahStatusPeriksaPasien');?>', {status:status ,idpendaftaran:idpendaftaran}, function(data){
                if(data.status == 'proses_form'){

                        $('#dialogUbahStatusPasien div.divForForm').html(data.div);
                        $.fn.yiiGridView.update('daftarPasien-grid');
                        setTimeout("$('#dialogUbahStatus').dialog('close')",1000);
                }else{
                    $('#alertDiv').show(); 
                }
            }, 'json');
        }else{
            preventDefault();
        }
    });
}
function ubahDokterPeriksa(pendaftaran_id)
{
    $('#temp_idPendaftaranDP').val(pendaftaran_id);
    jQuery.ajax({'url':'<?php echo $this->createUrl('ubahDokterPeriksa')?>',
        'data':$(this).serialize(),
        'type':'post',
        'dataType':'json',
        'success':function(data){
            if (data.status == 'create_form') {
                $('#editDokterPeriksa div.divForFormEditDokterPeriksa').html(data.div);
                $('#editDokterPeriksa div.divForFormEditDokterPeriksa form').submit(ubahDokterPeriksa);
            }else{
                $('#editDokterPeriksa div.divForFormEditDokterPeriksa').html(data.div);
                $.fn.yiiGridView.update('daftarPasien-grid', {
                        data: $('form').serialize()
                });
                setTimeout("$('#editDokterPeriksa').dialog('close') ",500);
            }
        },
        'cache':false
    });
    return false; 
}
</script>
<?php
$urlSession = Yii::app()->createUrl('ActionAjaxRIRD/buatSessionPendaftaranPasien');
$urlSessionUbahStatus = Yii::app()->createUrl('ActionAjaxRIRD/buatSessionUbahStatus ');
$jscript = <<< JS
function buatSession(pendaftaran_id,pasien_id)
{
    $.post("${urlSession}", { pendaftaran_id: pendaftaran_id,pasien_id: pasien_id },
        function(data){
            'sukses';
    }, "json");
}

function buatSessionUbahStatus(pendaftaran_id)
{
    myConfirm("Yakin Akan Merubah Status Periksa Pasien?","Perhatian!",function(r) {
        if (r){
            $.post("${urlSessionUbahStatus}", {pendaftaran_id: pendaftaran_id },
                function(data){
                    'sukses';
            }, "json");
        }
        else{
            preventDefault();
        }
    });
}
JS;
Yii::app()->clientScript->registerScript('jsPendaftaran',$jscript, CClientScript::POS_BEGIN);
?>

<?php
    //======================= Edit Dokter Periksa ======================= 
    $this->beginWidget('zii.widgets.jui.CJuiDialog',
        array(
            'id'=>'editDokterPeriksa',
            'options'=>array(
                'title'=>'Ganti Dokter Periksa',
                'autoOpen'=>false,
                'minWidth'=>500,
                'modal'=>true,
            ),
        )
    );
    echo CHtml::hiddenField('temp_idPendaftaranDP','',array('readonly'=>true));
    echo '<div class="divForFormEditDokterPeriksa"></div>';
    $this->endWidget('zii.widgets.jui.CJuiDialog');
?>

<?php 
// Dialog untuk Melihat riwayat alergi obat pasien =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogAlergiObat',
    'options' => array(
        'title' => 'Riwayat Alergi Obat Pasien',
        'autoOpen' => false,
        'modal' => true,
        'width' => 950,
        'height' => 550,
        'resizable' => true,
		'close'=>"js:function(){ $.fn.yiiGridView.update('daftarPasien-grid', {
                        data: $('#daftarPasien-form').serialize()
                    }); }",
    ),
));
?>
<iframe name='frameAlergiObat' width="100%" height="100%"></iframe>
<?php $this->endWidget(); ?>

<script>
ubahSummaryEnd = function(obj) {
    var grid_id = $(obj).parent().parent().attr("id");
    //console.log(grid_id);
    console.log($('#RDInfoKunjunganRDV_items, #daftarPasien-form :input').serialize());
    $.fn.yiiGridView.update(grid_id, {
            data : $('#RDInfoKunjunganRDV_items, #daftarPasien-form :input').serialize()
    });
    return false;
} 
</script>