<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form.js'); ?>

<?php
 $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
 $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
 $modul  = $this->module->name; 
 $control = $this->id;
Yii::app()->clientScript->registerScript('cari wew', "
$('#daftarPasien-form').submit(function(){
	$.fn.yiiGridView.update('daftarpasien-v-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>
<div class="white-container">
    <legend class="rim2">Informasi <b>Daftar Pasien</b></legend>
    <?php 
        if(isset($_GET['status'])){
            if($_GET['status'] > 0){ // Jika berhasil disimpan
                Yii::app()->user->setFlash('success',"Data rehabilitasi medis berhasil disimpan !");
            }
        }
    ?>
     <?php $this->widget('bootstrap.widgets.BootAlert'); ?> 
    <div class="block-tabel">
        <h6>Tabel <b>Daftar Pasien</b> <?php //echo CHtml::htmlButton(Yii::t('mds','{icon}',array('{icon}'=>'<i class="icon-volume-up icon-white"></i>')),array('title'=>'Klik untuk memanggil antrian terakhir','rel'=>'tooltip','class'=>'btn  btn-mini btn-primary', 'onclick'=>'ambilAntrianTerakhir();','style'=>'font-size:10px;')); ?></h6>
        <?php $this->widget('ext.bootstrap.widgets.BootGridView',array(
            'id'=>'daftarpasien-v-grid',
            'dataProvider'=>$modPasienMasukPenunjang->searchRM(),
            'template'=>"{summary}\n{items}\n{pager}",
            'itemsCssClass'=>'table table-striped table-condensed',
            'columns'=>array(
                /*
                array(
                    'name'=>'no_urutperiksa',
                    'type'=>'raw',
                    'header'=>'No. Antrian <br>/ Panggil Antrian',
                    'value'=>'$data->ruangan_singkatan."-".$data->no_urutperiksa."<br>".CHtml::htmlButton(Yii::t("mds","{icon}",array("{icon}"=>"<i class=\'icon-volume-up icon-white\'></i>")),array("class"=>"btn btn-primary","onclick"=>"panggilAntrian(\"$data->pasienmasukpenunjang_id\"); setSuaraPanggilanSingle(\"$data->ruangan_singkatan\",\"$data->no_urutperiksa\",\"$data->ruangan_id\")","rel"=>"tooltip","title"=>"Klik untuk memanggil pasien ini"))'
                ), */
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
                'value'=>'CHtml::link("<i class=\"icon-form-ubah\"></i><br/>".$data->no_pendaftaran,Yii::app()->controller->createUrl("pemeriksaanRehabilitasiMedis/index",array("pasienmasukpenunjang_id"=>$data->pasienmasukpenunjang_id)),array("rel"=>"tooltip","title"=>"Klik untuk mengubah pemeriksaan"))',
                'htmlOptions'=>array('width'=>'100px'),
                ),
                // 'tglmasukpenunjang', 

                

    //            'no_pendaftaran',
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
                //'umur',
                'alamat_pasien', 
                array(
                    'header'=>'Cara Bayar / Penjamin',
                    'value'=>'$data->caraBayarPenjamin',
                ),
                array(
                        'header'=>'Dokter Pemeriksa',
                        'type'=>'raw',
        //                'value'=>'($data->statusperiksahasil == Params::STATUSPERIKSAHASIL_SEDANG) ? CHtml::link("<i class=\"icon-pencil-blue\"></i>". $data->getNamaLengkapDokter($data->pegawai_id),Yii::app()->controller->createUrl("/'.$module.'/'.$controller.'/ApprovePemeriksaan",array("pendaftaran_id"=>$data->pendaftaran_id,"pasienmasukpenunjang_id"=>$data->pasienmasukpenunjang_id)),array("rel"=>"tooltip","title"=>"Klik untuk menyetujui pemeriksaan", "onclick"=>"return confirm(\"Apakah Anda akan menyetujui pemeriksaan ini?\");")) : $data->getNamaLengkapDokter($data->pegawai_id)',
                        'value'=>'$data->getNamaLengkapDokter($data->pegawai_id)',
                    ),
                array(
                    'header'=>'Kasus Penyakit',
                    'type'=>'raw',
                    'value'=>'$data->jeniskasuspenyakit_nama',
                ),
                
                                array(
                    'header'=>'Status Periksa',
                    'type'=>'raw',
                    'value'=> function($data){
                            $p = RMPasienmasukpenunjangT::model()->findByPk($data->pasienmasukpenunjang_id);
                            $pasienkirimkeunitlain_id = empty($p->pasienkirimkeunitlain_id)?'':$p->pasienkirimkeunitlain_id;
                            if (empty($p->pasienkirimkeunitlain_id)){
                                echo $data->getStatusRM($data->statusperiksa,$data->pendaftaran_id,$pasienkirimkeunitlain_id, $data);                                
                            }else{
                                echo $data->getStatus($data->statusperiksa,$data->pendaftaran_id, $data);                                
                            }
                    }
                ),
                //'nama_pegawai',
    //            'kelaspelayanan_nama',

                array(
                    'name'=>'Pemeriksaan Anamnesa',
                    'type'=>'raw',
                    'value'=>'CHtml::link("<i class=\'icon-form-periksa\'></i> ", Yii::app()->controller->createUrl("/rehabMedis/anamnesaTRM",array("pendaftaran_id"=>$data->pendaftaran_id)),array("id"=>"$data->no_pendaftaran","rel"=>"tooltip","title"=>"Klik untuk Pemeriksaan Pasien"))',
                    'htmlOptions'=>array('style'=>'text-align: center; width:40px'),
                ),
                array(
                    'header'=>'Buat Jadwal',
                    'type'=>'raw',
                    'value'=>'CHtml::link("<i class=icon-form-buatjadwal></i>",Yii::app()->controller->createUrl("/'.$module.'/'.$controller.'/buatJadwal",array("id"=>$data->pasienmasukpenunjang_id)),array("rel"=>"tooltip","title"=>"Klik Untuk Membuat Jadwal Rehab Medis"))',    
                    'htmlOptions'=>array('style'=>'text-align: center; width:40px')
                ),

                array(
                    'name'=>'masukanHasil',
                    'type'=>'raw',
                    'value'=>'CHtml::link("<i class=icon-form-input></i>",Yii::app()->controller->createUrl("/'.$module.'/'.$controller.'/hasilPemeriksaan",array("pendaftaran_id"=>$data->pendaftaran_id,"pasien_id"=>$data->pasien_id,"pasienmasukpenunjang_id"=>$data->pasienmasukpenunjang_id)),array("rel"=>"tooltip","title"=>"Klik Untuk Memasukkan hasil"))',    
                    'htmlOptions'=>array('style'=>'text-align: center; width:40px')
                ),
                array(
                    'header'=>'Lihat Hasil',
                    'type'=>'raw',
                    'value'=>'CHtml::link("<icon class=\'icon-form-lihat\'></idcon>", Yii::app()->createUrl("'.$modul.'/'.$controller.'/lihatHasil", array("id"=>$data->pendaftaran_id)), array("target"=>"frameLihatHasil", "onclick"=>"$(\'#dialogLihatHasil\').dialog(\'open\');"))','htmlOptions'=>array('style'=>'text-align: center; width:40px')
                    ),  
                array(
                    'header'=>'Rincian Tagihan',
                    'type'=>'raw',
                    'value'=>'CHtml::link("<icon class=\'icon-form-detailtagihan\'></idcon>", Yii::app()->createUrl("'.$modul.'/'.$controller.'/rincian", array("id"=>$data->pendaftaran_id)), array("target"=>"frameRincian", "onclick"=>"$(\'#dialogRincian\').dialog(\'open\');"))','htmlOptions'=>array('style'=>'text-align: center; width:40px')
                ),  
                array(
                   'header'=>'Batal Periksa',
                   'type'=>'raw',
                   'value'=>'CHtml::link("<i class=\'icon-form-silang\'></i>", "javascript:batalperiksa(".$data->pendaftaran_id.", ".$data->pasienmasukpenunjang_id.")",array("id"=>"$data->no_pendaftaran","rel"=>"tooltip","title"=>"Klik untuk membatalkan pemeriksaan"))',
                   'htmlOptions'=>array('style'=>'text-align: center; width:40px'),
                ),
            ),
                
            'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
        )); ?>
    </div>
    <iframe id="suarapanggilan" src="#" style="display: none;"></iframe>
    <?php $this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
        'id' => 'dialogLihatHasil',
        'options' => array(
            'title' => 'Detail Hasil Pemeriksaan',
            'autoOpen' => false,
            'modal' => true,
            'width' => 900,
            'height' => 550,
            'resizable' => false,
        ),
    ));
    ?>
    <iframe name='frameLihatHasil' width="100%" height="100%"></iframe>
    <?php $this->endWidget(); ?>
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
     <?php 
    // Dialog untuk ubah status periksa =========================
    $this->beginWidget('zii.widgets.jui.CJuiDialog', array( 
        'id'=>'dialogUbahStatus',
        'options'=>array(
            'title'=>'Ubah Status Pasien',
            'autoOpen'=>false,
            'modal'=>true,
            'zIndex'=>1002,
            'minWidth'=>600,
            'minHeight'=>500,
            'resizable'=>false,

        ),
    ));

    echo '<div class="divForForm"></div>';


    $this->endWidget();
    //========= end ubah status periksa dialog =============================
    ?>
     <?php 
    // Dialog untuk ubah status periksa =========================
    $this->beginWidget('zii.widgets.jui.CJuiDialog', array( 
        'id'=>'dialogUbahStatusPasien',
        'options'=>array(
            'title'=>'Ubah Status Pasien',
            'autoOpen'=>false,
            'modal'=>true,
            'zIndex'=>1002,
            'minWidth'=>600,
            'minHeight'=>500,
            'resizable'=>false,
        ),
    ));

    echo '<div class="divForForm"></div>';


    $this->endWidget();
    //========= end ubah status periksa dialog =============================
    ?>

    <?php
     //CHtml::link($text, $url, $htmlOptions)
    $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
            'action'=>Yii::app()->createUrl($this->route),
            'method'=>'get',
            'id'=>'daftarPasien-form',
            'type'=>'horizontal',
            'focus'=>'#'.CHtml::activeId($modPasienMasukPenunjang,'no_pendaftaran'),
            'htmlOptions'=>array('enctype'=>'multipart/form-data'),
    )); ?>
    <fieldset class="box">
        <legend class="rim"><i class="icon-white icon-search"></i> Pencarian</legend>
        <table width="100%" class="table-condensed">
            <tr>
                <td width="30%">
                    <div class="control-group ">
                        <label for="namaPasien" class="control-label">
                            <?php // echo CHtml::activecheckBox($modPasienMasukPenunjang, 'ceklis', array('uncheckValue'=>0,'rel'=>'tooltip', 'onClick'=>'cekTanggal()','data-original-title'=>'Cek untuk pencarian berdasarkan tanggal')); ?>
                            Tanggal Masuk 
                        </label>
                        <div class="controls">
                            <?php   $format = new MyFormatter;
                                    $this->widget('MyDateTimePicker',array(
                                                    'model'=>$modPasienMasukPenunjang,
                                                    'attribute'=>'tgl_awal',
                                                    'mode'=>'date',
                                                    'options'=> array(
                                                        'dateFormat'=>Params::DATE_FORMAT,
                                                        'maxDate' => 'd',
                                                    ),
                                                    'htmlOptions'=>array('readonly'=>true,'class'=>'dtPicker3'),
                            )); 
                                   ?>

                       </div> 
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
                <td width="35%">
                    <?php echo $form->textFieldRow($modPasienMasukPenunjang,'no_rekam_medik',array('placeholder'=>'Ketik No. Rekam Medik','class'=>'span3 numbers-only','onkeypress'=>"return $(this).focusNextInputField(event)", 'maxlength'=>6)); ?>
                    <?php echo $form->textFieldRow($modPasienMasukPenunjang,'no_pendaftaran',array('placeholder'=>'Ketik No. Pendaftaran', 'class'=>'span3 angkahuruf-only','onkeypress'=>"return $(this).focusNextInputField(event)", 'maxlength'=>50)); ?>
                    <?php echo $form->textFieldRow($modPasienMasukPenunjang,'nama_pasien',array('placeholder'=>'Ketik Nama Pasien','class'=>'span3 hurufs-only','onkeypress'=>"return $(this).focusNextInputField(event)", 'maxlength'=>50)); ?>
                    <?php // echo $form->textFieldRow($modPasienMasukPenunjang,'nama_bin',array('placeholder'=>'Ketik Nama Panggilan','class'=>'span3','onkeypress'=>"return $(this).focusNextInputField(event)", 'maxlength'=>50)); ?>
                </td>
                <td width="35%">
                    
                    <?php 
                    
                    
                    
                    $carabayar = CarabayarM::model()->findAll(array(
                        'condition'=>'carabayar_aktif = true',
                        'order'=>'carabayar_nama',
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
                    
                     <?php 
                        $mods = LookupM::getItems('statusperiksa');
                        unset($mods['BATAL PERIKSA']);
                        echo $form->dropDownListRow($modPasienMasukPenunjang,'statusperiksa', $mods, array('empty'=>'-- Pilih --','class'=>'span3')); ?>
                </td>
            </tr>
        </table>
        <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="entypo-search"></i>')),
            array('class'=>'btn btn-primary', 'type'=>'submit','id'=>'btn_simpan'));
        ?>
        <?php echo CHtml::link(Yii::t('mds', '{icon} Reset', array('{icon}'=>'<i class="entypo-arrows-ccw"></i>')), $this->createUrl('daftarPasien/index'), array('class'=>'btn btn-danger')); ?>
        <?php 
        $content = $this->renderPartial('../tips/informasiDaftarPasien',array(),true);
        $this->widget('UserTips',array('type'=>'transaksi','content'=>$content));  ?>	
    </fieldset>  
    <?php $this->endWidget();?>
</div>
<script type="text/javascript">
    function batalperiksa(pendaftaran_id, penunjang_id)
    {
            myConfirm("Anda yakin akan membatalkan pemeriksaan rehabilitasi medis pasien ini?","Perhatian!",function(r) {
                    if(r){
                            $.post('<?php echo Yii::app()->createUrl(Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/' . 'batalPemeriksaan')?>',{pendaftaran_id:pendaftaran_id, idPenunjang: penunjang_id},
                                function(data){
                                    if(data.status == 'ok'){
                                        /*
                                        if(data.smspasien==0){
                                          var params = [];
                                          params = {instalasi_id:<?php echo Yii::app()->user->getState("instalasi_id"); ?>, modul_id:<?php echo Yii::app()->session['modul_id']; ?>, judulnotifikasi:'GAGAL KIRIM SMS PASIEN', isinotifikasi:'Pasien '+data.nama_pasien+' tidak memiliki nomor mobile'}; // 16 
                                          insert_notifikasi(params);
                                        }
                                        */
                                        if (data.pesan == 'exist') {
                                            myAlert(data.keterangan);
                                        } else {
                                            window.location = "<?php echo Yii::app()->createUrl('rehabMedis/DaftarPasien&modul_id='.Yii::app()->user->modul_id.'&status=1')?>";
                                        }
                                    }else{
                                        if(data.status == 'exist')
                                        {
                                            myAlert('Pasien telah melakukan pemeriksaan');
                                        }

                                    }
                                },'json'
                            );
                    }
            });
    }
    //document.getElementById('RMMasukPenunjangV_tgl_awal_date').setAttribute("style","display:none;");
    //document.getElementById('RMMasukPenunjangV_tgl_akhir_date').setAttribute("style","display:none;");
    function cekTanggal(){
        
        var checklist = $('#RMMasukPenunjangV_ceklis');
        var pilih = checklist.attr('checked');
        // var tgl_masuk = $(document)
        if(pilih){
            // document.getElementById('RMMasukPenunjangV_tgl_awal').disabled = false;
            // document.getElementById('RMMasukPenunjangV_tgl_akhir').disabled = false;
            document.getElementById('RMMasukPenunjangV_tgl_awal_date').setAttribute("style","display:block;");
            document.getElementById('RMMasukPenunjangV_tgl_akhir_date').setAttribute("style","display:block;");
        }else{
            // document.getElementById('RMMasukPenunjangV_tgl_awal').disabled = true;
            // document.getElementById('RMMasukPenunjangV_tgl_akhir').disabled = true;
            document.getElementById('RMMasukPenunjangV_tgl_awal_date').setAttribute("style","display:none;");
            document.getElementById('RMMasukPenunjangV_tgl_akhir_date').setAttribute("style","display:none;");
        }
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



function setStatus(obj,status,pendaftaran_id, pasienkirimkeunitlain_id){
    var status = status;
    var pendaftaran_id = pendaftaran_id;
    var pasienkirimkeunitlain_id = pasienkirimkeunitlain_id;
    
    myConfirm(' Apakah Anda Yakin Ingin Merubah Status Periksa Pasien? ', 'Perhatian!', function(r){
        if(r){
            $.post('<?php echo $this->createUrl('UbahStatusPeriksaPasien');?>', {status:status ,pendaftaran_id:pendaftaran_id, pasienkirimkeunitlain_id:pasienkirimkeunitlain_id}, function(data){
                if(data.status == 'proses_form'){
					$('#dialogUbahStatusPasien div.divForForm').html(data.div);
					$.fn.yiiGridView.update('daftarpasien-v-grid');
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
            if(data.smspasien==0){
                var params = [];
                params = {instalasi_id:<?php echo Yii::app()->user->getState("instalasi_id"); ?>, modul_id:<?php echo Yii::app()->session['modul_id']; ?>, judulnotifikasi:'GAGAL KIRIM SMS PASIEN', isinotifikasi:'Pasien '+data.nama_pasien+' tidak memiliki nomor mobile'}; // 16 
                insert_notifikasi(params);
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