<div class="white-container">
    <?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form.js'); ?>

    <?php
     $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
     $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai

    Yii::app()->clientScript->registerScript('cariwew', "
    $('#daftarPasien-form').submit(function(){
            $('#daftarpasien-v-grid').addClass('animation-loading');
            $.fn.yiiGridView.update('daftarpasien-v-grid', {
                    data: $(this).serialize()
            });
            return false;
    });
    ");
    ?>
    <legend class="rim2">Informasi Pasien <b>Bedah Sentral</b></legend>
    <div class="block-tabel">
        <h6>Tabel <b>Daftar Pasien <?php // echo CHtml::htmlButton(Yii::t('mds','{icon}',array('{icon}'=>'<i class="icon-volume-up icon-white"></i>')),array('title'=>'Klik untuk memanggil antrian terakhir','rel'=>'tooltip','class'=>'btn  btn-mini btn-primary', 'onclick'=>'ambilAntrianTerakhir();','style'=>'font-size:10px;')); ?></h6>
        <?php $this->widget('ext.bootstrap.widgets.BootGridView',array(
            'id'=>'daftarpasien-v-grid',
            'dataProvider'=>$modPasienMasukPenunjang->searchBS(),
            'template'=>"{summary}\n{items}\n{pager}",
            'itemsCssClass'=>'table table-striped table-condensed',
            'columns'=>array(
    //            array(
    //                    'name'=>'no_urutperiksa',
    //                    'type'=>'raw',
    //                    'header'=>'No. Antrian <br>/ Panggil Antrian',
    //                    'value'=>'$data->ruangan_singkatan."-".$data->no_urutperiksa."<br>".(($data->panggilantrian == TRUE) ? "Sudah Dipanggil" : CHtml::htmlButton(Yii::t("mds","{icon}",array("{icon}"=>"<i class=\'icon-volume-up icon-white\'></i>")),array("class"=>"btn btn-primary","onclick"=>"panggilAntrian(\"$data->pasienmasukpenunjang_id\"); setSuaraPanggilanSingle(\"$data->ruangan_singkatan\",\"$data->no_urutperiksa\",\"$data->ruangan_id\")","rel"=>"tooltip","title"=>"Klik untuk memanggil pasien ini")))'
    //                ),
                array(
                        'header'=>'Tgl. Masuk Penunjang<br/>No. Penunjang',
                        'name'=>'no_masukpenunjang',
                        'type'=>'raw',
                        'value'=>'MyFormatter::formatDateTimeForUser($data->tglmasukpenunjang)."<br/>".$data->no_masukpenunjang',
                    ),

                array(
                        'header'=>'Instalasi/<br/>Ruangan Asal',
                        'name'=>'ruanganasal_nama',
                        'type'=>'raw',
                        'value'=>function($data) {
                            //$pegawai = PegawaiM::model()->findByAttributes(array(
                            //    'nama_pegawai'=>$data->nama_dokterasal,
                            //));
                            return $data->instalasiasal_nama."/<br/>".$data->ruanganasal_nama; //."/<br/>".(empty($pegawai)?"-":$pegawai->namaLengkap);
                        },
                    ),

                array(
                'name'=>'tgl_pendaftaran',
                'header'=>'No. Pendaftaran',
                'type'=>'raw',
                'value'=>'$data->no_pendaftaran',
                'htmlOptions'=>array('width'=>'100px'),
                ),
                array(
                    'header'=>'No. RM',
                    'name'=> 'no_rekam_medik',
                ),
                array(
                    'header'=>'Nama Pasien',
                    'value'=>'$data->namadepan.$data->nama_pasien'
                ),
                array(
                    'header'=>'Umur',
                    'type'=>'raw',
                    'value'=>'$data->umur',
                ),
                'alamat_pasien',
                array(
                    'header'=>'Kasus Penyakit / <br> Kelas Pelayanan',
                    'type'=>'raw',
                    'value'=>'"$data->jeniskasuspenyakit_nama"."<br/>"."$data->kelaspelayanan_nama"',
                ),
    //            'jeniskasuspenyakit_nama',    

                array(
                'header'=>'Cara Bayar / Penjamin',
                'value'=>'$data->caraBayarPenjamin',
                ),

                array(
                        'header'=>'Dokter Pemeriksa',
                        'type'=>'raw',
        //                'value'=>'($data->statusperiksahasil == Params::STATUSPERIKSAHASIL_SEDANG) ? CHtml::link("<i class=\"icon-pencil-blue\"></i>". $data->getNamaLengkapDokter($data->pegawai_id),Yii::app()->controller->createUrl("/'.$module.'/'.$controller.'/ApprovePemeriksaan",array("pendaftaran_id"=>$data->pendaftaran_id,"pasienmasukpenunjang_id"=>$data->pasienmasukpenunjang_id)),array("rel"=>"tooltip","title"=>"Klik untuk menyetujui pemeriksaan", "onclick"=>"return confirm(\"Apakah Anda akan menyetujui pemeriksaan ini?\");")) : $data->getNamaLengkapDokter($data->pegawai_id)',
                        'value'=>function($data) {
                            $p = PegawaiM::model()->findByPk($data->pegawai_id);
                            return $p->namaLengkap;
                        }, //'$data->pegawai_id',
                    ),
                array(
                                    'header'=>'Rencana Operasi',
                                    'type'=>'raw',
                                    'value'=>'($data->getStatusOperasi($data->pasienmasukpenunjang_id)!="RENCANA") ?
                                            " - "
                                            :
                                            CHtml::Link("<i class=\"icon-form-roperasi\"></i>",Yii::app()->controller->createUrl("PendaftaranBedahSentralRujukanRS/index/",array("pasienmasukpenunjang_id"=>$data->pasienmasukpenunjang_id)),
                                                                    array("class"=>"icon-form-roperasi", 
                                                                              "id" => "selectPasien",
                                                                              "rel"=>"tooltip",
                                                                              "title"=>"Klik untuk ubah rencana operasi pasien",
                                                                    ))',                'htmlOptions'=>array('style'=>'text-align: center; width:40px')
                            ),
                 array(
                'header'=>'Operasi',
                'type'=>'raw',
                'value'=>'($data->getStatusOperasi($data->pasienmasukpenunjang_id)=="MULAI")? "<div class=\"inap\" style=\"background-color:#FFFF00; text-align: center\">".
                                                    CHtml::link("SEDANG OPERASI",Yii::app()->controller->createUrl("/bedahSentral/daftarPasien/selesaiOperasi",array("pasienmasukpenunjang_id"=>$data->pasienmasukpenunjang_id)),array("rel"=>"tooltip","title"=>"Klik Untuk Menyelesaikan Operasi","target"=>"frameSelesaiOperasi","onclick"=>"$(\'#selesaiOperasi\').dialog(\'open\');return true;")):
                                                            (($data->getStatusOperasi($data->pasienmasukpenunjang_id)=="SELESAI") ? "<div class=\"inap\" style=\"background-color:#33FF00; text-align: center\">SELESAI OPERASI" :
                                                            CHtml::link("<i class=icon-form-operasi></i>",Yii::app()->controller->createUrl("/'.$module.'/'.$controller.'/updateRencana",array("id"=>$data->pasienmasukpenunjang_id)),array("rel"=>"tooltip","title"=>"Klik Untuk Melakukan Operasi"))
                                                            )
                                                    ',
                'htmlOptions'=>array('style'=>'text-align: center; width:40px')
                ),
                array(
                   'header'=>'Batal Periksa',
                   'type'=>'raw',
                   'value'=>'CHtml::link("<i class=\'icon-form-silang\'></i>", "javascript:batalPeriksa($data->pasienmasukpenunjang_id)",array("id"=>"$data->no_pendaftaran","rel"=>"tooltip","title"=>"Klik untuk membatalkan Pemeriksaan"))',
                   'htmlOptions'=>array('style'=>'text-align: center; width:40px'),
                ),
            ),
            'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
        )); ?>
    </div>
    <?php
        //CHtml::link($text, $url, $htmlOptions)
        $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
        'action'=>Yii::app()->createUrl($this->route),
        'method'=>'get',
        'id'=>'daftarPasien-form',
        'type'=>'horizontal',
        'htmlOptions'=>array('enctype'=>'multipart/form-data','onKeyPress'=>'return disableKeyPress(event)'),

    )); ?>
    <fieldset class="box">
        <legend class="rim"><i class="icon-white icon-search"></i> Pencarian</legend>
        <table width="100%" class="table-condensed">
            <tr>
                <td width="33%">
                    <div class="control-group ">
                        <label for="namaPasien" class="control-label">
                            <?php // echo CHtml::activecheckBox($modPasienMasukPenunjang, 'ceklis', array('uncheckValue'=>0,'onClick'=>'cekTanggal()','rel'=>'tooltip' ,'data-original-title'=>'Cek untuk pencarian berdasarkan tanggal')); ?>
                            Tanggal Masuk 
                        </label>
                        <div class="controls">
                            <?php   $format = new MyFormatter;
                                    $modPasienMasukPenunjang->tgl_awal = $format->formatDateTimeForUser($modPasienMasukPenunjang->tgl_awal);
                                    $modPasienMasukPenunjang->tgl_akhir = $format->formatDateTimeForUser($modPasienMasukPenunjang->tgl_akhir);
                                    $this->widget('MyDateTimePicker',array(
                                                    'model'=>$modPasienMasukPenunjang,
                                                    'attribute'=>'tgl_awal',
                                                    'mode'=>'date',
                                                    'options'=> array(
                                                        'dateFormat'=>Params::DATE_FORMAT,
                                                        'maxDate' => 'd',
                                                    ),
                                                    'htmlOptions'=>array('readonly'=>true,'class'=>'dtPicker3'),
                            )); ?>

                        </div> 
                    </div>
                    <div class="control-group">
                         <?php echo CHtml::label(' Sampai Dengan',' s/d', array('class'=>'control-label')) ?>

                       <div class="controls"> 
                                <?php   
                                    $this->widget('MyDateTimePicker',array(
                                                    'model'=>$modPasienMasukPenunjang,
                                                    'attribute'=>'tgl_akhir',
                                                    'mode'=>'date',
                                                    'options'=> array(
                                                        'dateFormat'=>Params::DATE_FORMAT,
                                                        'maxDate' => 'd',
                                                    ),
                                                    'htmlOptions'=>array('readonly'=>true,'class'=>'dtPicker3'),
                            )); ?>
                        </div>
                    </div> 
                </td>
                <td width="33%">
                    <?php echo $form->textFieldRow($modPasienMasukPenunjang,'no_rekam_medik',array('placeholder'=>'Ketik No. Rekam Medik','class'=>'span3','onkeypress'=>"return $(this).focusNextInputField(event)", 'maxlength'=>50)); ?>
                    <?php echo $form->textFieldRow($modPasienMasukPenunjang,'no_pendaftaran',array('placeholder'=>'Ketik No. Pendaftaran', 'class'=>'span3','onkeypress'=>"return $(this).focusNextInputField(event)", 'maxlength'=>50)); ?>
                    <?php echo $form->textFieldRow($modPasienMasukPenunjang,'nama_pasien',array('placeholder'=>'Ketik Nama Pasien','class'=>'span3','onkeypress'=>"return $(this).focusNextInputField(event)", 'maxlength'=>50)); ?>
                </td>
                <td>
                    <?php 
                    
                    
                    
                    $carabayar = CarabayarM::model()->findAll(array(
                        'condition'=>'carabayar_aktif = true',
                        'order'=>'carabayar_nourut',
                    ));
                    $penjamin = PenjaminpasienM::model()->findAll(array(
                        'condition'=>'penjamin_aktif = true',
                        'order'=>'penjamin_nama',
                    ));
                    $dokter = DokterV::model()->findAll(array(
                        'condition'=>'pegawai_aktif = true and ruangan_id = '.Yii::app()->user->getState('ruangan_id'),
                        'order'=>'nama_pegawai',
                    ));
                    foreach ($carabayar as $idx=>$item) {
                        $penjamins = PenjaminpasienM::model()->findByAttributes(array(
                            'carabayar_id'=>$item->carabayar_id,
                            'penjamin_aktif'=>true,
                       ));
                       if (empty($penjamins)) unset($carabayar[$idx]);
                    }
                    
                    echo $form->dropDownListRow($modPasienMasukPenunjang,'ruanganasal_id', CHtml::listData(RuanganM::model()->findAllByAttributes(array(
                        'instalasi_id'=>array(2,3,4),
                        'ruangan_aktif'=>'true'
                    ), array(
                        'order'=>'instalasi_id, ruangan_nama',
                    )), 'ruangan_id', 'ruangan_nama'), array('empty'=>'-- Pilih --', 'class'=>'span3', 'maxlength'=>50));
                    
                    echo $form->dropDownListRow($modPasienMasukPenunjang,'pegawai_id', CHtml::listData($dokter, 'pegawai_id', 'namaLengkap'), array('empty'=>'-- Pilih --', 'class'=>'span3'));
                    
                    echo $form->dropDownListRow($modPasienMasukPenunjang,'carabayar_id', CHtml::listData($carabayar, 'carabayar_id', 'carabayar_nama'), array(
                        'empty'=>'-- Pilih --',
                        'class'=>'span3', 
                        'ajax' => array('type'=>'POST',
                            'url'=> $this->createUrl('/actionDynamic/getPenjaminPasien',array('encode'=>false,'namaModel'=>get_class($modPasienMasukPenunjang))), 
                            'success'=>'function(data){$("#'.CHtml::activeId($modPasienMasukPenunjang, "penjamin_id").'").html(data); }',
                        ),
                    ));
                    
                    echo $form->dropDownListRow($modPasienMasukPenunjang,'penjamin_id', CHtml::listData($penjamin, 'penjamin_id', 'penjamin_nama'), array('empty'=>'-- Pilih --', 'class'=>'span3', 'maxlength'=>50));
                    ?>
                </td>
                
            </tr>
        </table>
    <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),
                                                    array('class'=>'btn btn-primary', 'type'=>'submit','id'=>'btn_simpan'));
         ?>        
    <?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
                                Yii::app()->createUrl($this->module->id.'/'.Yii::app()->controller->id.'/'.Yii::app()->controller->action->id.''), 
                                array('class'=>'btn btn-danger',
                                      'onclick'=>'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'));  ?>

                            <?php 
    $content = $this->renderPartial('../tips/informasi',array(),true);
    $this->widget('UserTips',array('type'=>'transaksi','content'=>$content));  ?>	
    <iframe id="suarapanggilan" src="#" style="display: none;"></iframe>
    </fieldset>  
    <?php $this->endWidget();?>
</div>
<script type="text/javascript">
//document.getElementById('BSMasukPenunjangV_tgl_awal_date').setAttribute("style","display:none;");
//document.getElementById('BSMasukPenunjangV_tgl_akhir_date').setAttribute("style","display:none;");
function cekTanggal(){

    var checklist = $('#BSMasukPenunjangV_ceklis');
    var pilih = checklist.attr('checked');
    if(pilih){
        document.getElementById('BSMasukPenunjangV_tgl_awal_date').setAttribute("style","display:block;");
        document.getElementById('BSMasukPenunjangV_tgl_akhir_date').setAttribute("style","display:block;");
    }else{
        document.getElementById('BSMasukPenunjangV_tgl_awal_date').setAttribute("style","display:none;");
        document.getElementById('BSMasukPenunjangV_tgl_akhir_date').setAttribute("style","display:none;");
    }
}    
function batalPeriksa(idPenunjang){
    myConfirm("Apakah anda yakin akan membatalkan pemeriksaan Operasi Bedah pasien ini?","Perhatian!",function(r) {
        if(r){
            $.post('<?php echo Yii::app()->createUrl(Yii::app()->controller->module->id . '/' . Yii::app()->controller->id.'/BatalPeriksa')?>',{idPenunjang:idPenunjang},
                      function(data){
                          if(data.status == 'ok' && data.pesan != 'exist'){
                                window.location = "<?php echo Yii::app()->createUrl(Yii::app()->controller->module->id . '/' . Yii::app()->controller->id.'/index&succes=2')?>";
                          }else{
                              if(data.pesan == 'exist' && data.status == 'ok')
                              {
                                if(data.smspasien==0){
                                    var params = [];
                                    params = {instalasi_id:<?php echo Yii::app()->user->getState("instalasi_id"); ?>, modul_id:<?php echo Yii::app()->session['modul_id']; ?>, judulnotifikasi:'GAGAL KIRIM SMS PASIEN', isinotifikasi:'Pasien '+data.nama_pasien+' tidak memiliki nomor mobile'}; // 16 
                                    insert_notifikasi(params);
                                }
                                 $('#dialogKonfirm div.divForForm').html(data.keterangan);
                                 $('#dialogKonfirm').dialog('open');
                                 $('#daftarpasien-v-grid').addClass('animation-loading');
                                 $.fn.yiiGridView.update('daftarpasien-v-grid', {
                                         data: $(this).serialize()
                                 });
                              }
                          }
                      },'json'
                  );

        }
    });
}

function ambilAntrianTerakhir(){
    $.ajax({
        type:'POST',
        url:'<?php echo $this->createUrl('getAntrianTerakhir'); ?>',
        dataType: "json",
        success:function(data){
            if(data.pesan == ""){
                panggilAntrian(data.pasienmasukpenunjang_id);
                setSuaraPanggilanSingle(data.ruangan_singkatan,data.no_urutperiksa,data.ruangan_id);
            }else{
                myAlert(data.pesan);
            }
        },
        error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
    });
} 

/**
 * memanggil antrian ke poliklinik
 * @param {type} pendaftaran_id
 * @returns {undefined} */
function panggilAntrian(pasienmasukpenunjang_id){
    $.ajax({
        type:'POST',
        url:'<?php echo $this->createUrl('Panggil'); ?>',
        data: {pasienmasukpenunjang_id:pasienmasukpenunjang_id},
        dataType: "json",
        success:function(data){
            if(data.pesan !== ""){
                myAlert(data.pesan);
            }
            <?php if(Yii::app()->user->getState('is_nodejsaktif')){ ?>
            socket.emit('send',{conversationID:'antrian',panggil:1,antrian_id:pasienmasukpenunjang_id});
            <?php } ?>
            $.fn.yiiGridView.update('daftarpasien-v-grid');
        },
        error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
    });
}



/**
 * suara panggilan per ruangan
 * @param {type} param
 * copy dari: antrian.views.tampilAntrianKePoliklinik._jsFunctions
 */
function setSuaraPanggilanSingle(kodeantrian, noantrian, ruangan_id){
    $("#suarapanggilan").attr("src","<?php echo $this->createUrl('/antrian/tampilAntrianKePenunjang/suaraPanggilanSingle'); ?>&kodeantrian="+kodeantrian+"&noantrian="+noantrian+"&ruangan_id="+ruangan_id);
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
<?php
    //=============================== Ganti Data Pasien Dialog =======================================
    $this->beginWidget('zii.widgets.jui.CJuiDialog',
        array(
            'id'=>'selesaiOperasi',
            'options'=>array(
                'title'=>'Selesai Operasi Pasien' ,
                'autoOpen'=>false,
                'width' => 480,
				'height' => 320,
                'resizable' => true,
            ),
        )
    );
  
//    echo CHtml::hiddenField('temp_norekammedik','',array('readonly'=>true));
    echo '<iframe name="frameSelesaiOperasi" width="100%" height="100%"></iframe>';
    $this->endWidget('zii.widgets.jui.CJuiDialog');
?>