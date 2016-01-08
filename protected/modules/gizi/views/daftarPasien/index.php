<div class="white-container">
    <legend class="rim2">Informasi Daftar <b>Pasien Gizi</b></legend>
    <?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form.js'); ?>
    <?php
     $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
     $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai

    Yii::app()->clientScript->registerScript('cari cari', "
    $('#daftarPasien-form').submit(function(){
            $.fn.yiiGridView.update('daftarpasien-v-grid', {
                    data: $(this).serialize()
            });
            return false;
    });
    ");
    if(!empty($_GET['succes'])){?>
    <div class="alert alert-block alert-success">
        <a class="close" data-dismiss="alert">×</a>
            <?php if($_GET['succes']==2){ ?> Pemeriksaan Pasien berhasil di batalkan<?php } if($_GET['succes']==1){?>Pasein Berhasil Di Rujuk<?php }?>
    </div>
    <?php } ?>
    <div class="block-tabel">
        <h6>Tabel <b>Pasien Gizi</b></h6>
        <?php $this->widget('bootstrap.widgets.BootAlert');
        $this->widget('ext.bootstrap.widgets.BootGridView',array(
            'id'=>'daftarpasien-v-grid',
            'dataProvider'=>$modPasienMasukPenunjang->searchKonsulGizi(),
            'template'=>"{summary}\n{items}\n{pager}",
            'itemsCssClass'=>'table table-striped table-condensed',
            'columns'=>array(
                array(
                    'name'=>'no_urutperiksa',
                    'type'=>'raw',
                    'header'=>'No. Antrian <br>/ Panggil Antrian',
                    'value'=>'$data->ruangan_singkatan."-".$data->no_urutperiksa."<br>".((($data->panggilantrian) || "'.date('Y-m-d',strtotime($modPasienMasukPenunjang->tglmasukpenunjang)).'" != "'.date('Y-m-d').'") ? "Sudah Dipanggil" : CHtml::htmlButton(Yii::t("mds","{icon}",array("{icon}"=>"<i class=\'icon-volume-up icon-white\'></i>")),array("class"=>"btn btn-primary","onclick"=>"panggilAntrian(\"$data->pasienmasukpenunjang_id\"); setSuaraPanggilanSingle(\"$data->ruangan_singkatan\",\"$data->no_urutperiksa\",\"$data->ruangan_id\")","rel"=>"tooltip","title"=>"Klik untuk memanggil pasien ini")))'
                ),
                'tgl_pendaftaran',
                'tglmasukpenunjang',
                'ruanganasal_nama',
                'no_pendaftaran',
                'no_rekam_medik',
                array(
                    'header'=>'Nama Pasien',
                    'type'=>'raw',
                    'value'=>'$data->nama_pasien',
                ),
                array(
                    'header'=>'Alias',
                    'name'=>'nama_bin',
                    'type'=>'raw',
                    'value'=>'$data->nama_bin',
                ),
               'jeniskasuspenyakit_nama',
               'umur',
               array(
                    'header'=>'Jenis Kelamin',
                    'type'=>'raw',
                    'value'=>'$data->jeniskelamin',
               ),
               'alamat_pasien',

               array(
                    'name'=>'CaraBayarPenjamin',
                    'type'=>'raw',
                    'value'=>'$data->caraBayarPenjamin',    
                    'htmlOptions'=>array('style'=>'text-align: center; width:40px')
               ),
               array(
                    'header'=>'Status Periksa',
                    'type'=>'raw',
                    'value'=>'$data->statusperiksa',
               ),
               array(
                    'header'=>'Konsultasi Gizi',
                    'type'=>'raw',
                    'value'=>'CHtml::link("<i class=\"icon-form-konsulgizi\"></i>",Yii::app()->controller->createUrl("/gizi/pemeriksaanGizi",array("pendaftaran_id"=>$data->pendaftaran_id,"pasien_id"=>$data->pasien_id,"pasienadmisi_id"=>"")), array("rel"=>"tooltip","title"=>"Klik untuk Rencana Pemeriksaan"))', 'htmlOptions'=>array('style'=>'text-align: center; width:40px')
               ),
        ),
            'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
        )); ?>
    </div>
    <?php 
    // Dialog untuk Lihat Hasil =========================
    $this->beginWidget('zii.widgets.jui.CJuiDialog', array( 
        'id'=>'dialogLihatHasil',
        'options'=>array(
            'title'=>'Pemeriksaan Gizi',
            'autoOpen'=>false,
            'modal'=>true,
            'minWidth'=>950,
            'minHeight'=>450,
            'resizable'=>true,
        ),
    ));
    ?>

    <iframe src="" name="iframeLihatHasil" width="100%" height="500">
    </iframe>

    <?php
    $this->endWidget();
    //========= end Lihat Hasil =============================
    ?>
    
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
			<div class="row-fluid">
				<div class="span4">
					<div class="control-group">
						<?php echo $form->labelEx($modPasienMasukPenunjang,'tglmasukpenunjang', array('class'=>'control-label')) ?>
                        <div class="controls">  

                         <?php
                         $modPasienMasukPenunjang->tgl_awal = MyFormatter::formatDateTimeForUser($modPasienMasukPenunjang->tgl_awal);
                         $modPasienMasukPenunjang->tgl_akhir = MyFormatter::formatDateTimeForUser($modPasienMasukPenunjang->tgl_akhir);
                         $this->widget('MyDateTimePicker',array(
                                             'model'=>$modPasienMasukPenunjang,
                                             'attribute'=>'tgl_awal',
                                             'mode'=>'date',
    //                                          'maxDate'=>'d',
                                             'options'=> array(
                                             'dateFormat'=>Params::DATE_FORMAT,
                                            ),
                                             'htmlOptions'=>array('readonly'=>true,'class'=>'span3',
                                             'onkeypress'=>"return $(this).focusNextInputField(event)"),
                                        )); ?>

                        </div> 
					</div>
					<div class="control-group">
						<?php echo CHtml::label(' Sampai Dengan',' s/d', array('class'=>'control-label')) ?>
                        <div class="controls">  
                        <?php $this->widget('MyDateTimePicker',array(
                                             'model'=>$modPasienMasukPenunjang,
                                             'attribute'=>'tgl_akhir',
                                             'mode'=>'date',
    //                                         'maxdate'=>'d',
                                             'options'=> array(
                                             'dateFormat'=>Params::DATE_FORMAT,
                                            ),
                                             'htmlOptions'=>array('readonly'=>true,'class'=>'span3',
                                             'onkeypress'=>"return $(this).focusNextInputField(event)"),
                                        )); ?>
                        </div>
					</div>
				</div>
				<div class="span4">
					<?php echo $form->textFieldRow($modPasienMasukPenunjang,'no_rekam_medik',array('class'=>'span3','onkeypress'=>"return $(this).focusNextInputField(event)", 'maxlength'=>50, 'autofocus'=>true, 'placeholder'=>'Ketik no. rekam medik')); ?>
					<?php echo $form->textFieldRow($modPasienMasukPenunjang,'no_pendaftaran',array('class'=>'span3','onkeypress'=>"return $(this).focusNextInputField(event)", 'maxlength'=>50, 'placeholder'=>'Ketik no. pendaftaran')); ?>
				</div>
				<div class="span4">
					<?php echo $form->textFieldRow($modPasienMasukPenunjang,'nama_pasien',array('class'=>'span3','onkeypress'=>"return $(this).focusNextInputField(event)", 'maxlength'=>50, 'placeholder'=>'Ketik nama pasien')); ?>
					<?php echo $form->textFieldRow($modPasienMasukPenunjang,'nama_bin',array('class'=>'span3','onkeypress'=>"return $(this).focusNextInputField(event)", 'maxlength'=>50, 'placeholder'=>'Alias' )); ?>
				</div>
			</div>
        <div class="form-actions">
    <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),
                                                    array('class'=>'btn btn-primary', 'type'=>'submit','id'=>'btn_simpan'));
                                                                 ?>
                                                                           <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Reset',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')),array('class'=>'btn btn-danger', 'type'=>'reset')); ?>
      <?php 
    $content = $this->renderPartial('../tips/informasi',array(),true);
    $this->widget('UserTips',array('type'=>'transaksi','content'=>$content));  ?>

        </div>
    </fieldset>  
    <?php $this->endWidget();?>
</div>
<iframe id="suarapanggilan" src="#" style="display: none;"></iframe>
<script type="text/javascript">

function batalperiksa(idpendaftaran)
{
   myConfirm('anda yakin akan membatalkan pemeriksaan gizi pasien ini?','Perhatian!',
    function(r){
        if(r){
           $.post('<?php echo $this->createUrl('BatalPeriksaPasienLuar')?>',{idpendaftaran:idpendaftaran},
                 function(data){
                     if(data.status=='success'){                     
                         window.location = "<?php echo $this->createUrl('index&succes=2')?>";
                     }
                 },'json'
             );
        }
    });
//    if(alasan==''){
//        myAlert('Anda Belum Mengisi Alasan Pembatalan');
//    }else{
//        $.post('<?php //echo Yii::app()->createUrl('rawatInap/pasienRawatInap/BatalRawatInap');?>', $('#formAlasan').serialize(), function(data){
////            if(data.error != '')
////                myAlert(data.error);
////            $('#'+data.cssError).addClass('error');
//            if(data.status=='success'){
//                batal();
//                myAlert('Data Berhasil Disimpan');
//                location.reload();
//            }else{
//                myAlert(data.status);
//            }
//        }, 'json');
//   }     
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