<div class="white-container">
    <legend class="rim2">Informasi <b>Daftar Pasien</b></legend>
    <div class="block-tabel">
        <h6>Tabel <b>Daftar Pasien</b> <?php echo CHtml::htmlButton(Yii::t('mds','{icon}',array('{icon}'=>'<i class="icon-volume-up icon-white"></i>')),array('title'=>'Klik untuk memanggil antrian terakhir','rel'=>'tooltip','class'=>'btn  btn-mini btn-primary', 'onclick'=>'ambilAntrianTerakhir();','style'=>'font-size:10px;')); ?></h6>
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
        ?>
        <?php $this->widget('bootstrap.widgets.BootAlert'); ?>   
        <?php $this->widget('ext.bootstrap.widgets.BootGridView',array(
            'id'=>'daftarpasien-v-grid',
            'dataProvider'=>$modPasienMasukPenunjang->searchRAD(),
                    'template'=>"{summary}\n{items}\n{pager}",
                    'itemsCssClass'=>'table table-striped table-condensed',
            'columns'=>array(
                            array(
                                    'name'=>'no_urutperiksa',
                                    'type'=>'raw',
                                    'header'=>'No. Antrian <br>/ Panggil Antrian',
                                    'value'=>'$data->ruangan_singkatan."-".$data->no_urutperiksa."<br>".CHtml::htmlButton(Yii::t("mds","{icon}",array("{icon}"=>"<i class=\'icon-volume-up icon-white\'></i>")),array("class"=>"btn btn-primary","onclick"=>"panggilAntrian(\"$data->pasienmasukpenunjang_id\"); setSuaraPanggilanSingle(\"$data->ruangan_singkatan\",\"$data->no_urutperiksa\",\"$data->ruangan_id\")","rel"=>"tooltip","title"=>"Klik untuk memanggil pasien ini"))'
                            ),
    //            'tgl_pendaftaran', menggunakan tgl masuk penunjang agar urutan pendaftaran sesuai jika dari RI,RJ,RD
                            array(
                                    'header'=>'Tgl. Pendaftaran<br/>No Pendaftaran',
                                    'name'=>'tgl_pendaftaran',
                                    'type'=>'raw',
                                    'value'=>'CHtml::link("<i class=\"icon-form-ubah\"></i><br/>".$data->tgl_pendaftaran."/<br/>".$data->no_pendaftaran,Yii::app()->controller->createUrl("pemeriksaanPasienRadiologi/index",array("pasienmasukpenunjang_id"=>$data->pasienmasukpenunjang_id)),array("rel"=>"tooltip","title"=>"Klik untuk mengubah pemeriksaan"))'
                            ),
                            array(
                                    'header'=>'Tgl. Penunjang<br/>No. Penunjang',
                                    'name'=>'tglmasukpenunjang',
                                    'type'=>'raw',
                                    'value'=>'$data->tglmasukpenunjang."/<br/>".$data->no_masukpenunjang'
                            ),
                            array(
                                'header'=>'Ruangan<br/>Dokter Asal',
                                'name'=>'ruanganasal_nama',
                                'type'=>'raw',
                                'value'=>function($data) {
                                    $pegawai = PegawaiM::model()->findByAttributes(array(
                                        'nama_pegawai'=>$data->nama_dokterasal,
                                    ));
                                    return $data->ruanganasal_nama."/<br/>".(empty($pegawai)?"-":$pegawai->namaLengkap);
                                },
                            ),
                            'nama_perujuk',
                            array(
                                'name'=>'no_rekam_medik',
                                'type'=>'raw',
                                'header'=>'No. RM',
                                'value'=>'$data->no_rekam_medik',
                            ),
                            // 'ruanganasal_id',
                            
    //            array(
    //                'name'=>'no_pendaftaran',
    //                'header'=>'No. Pendaftaran',
    //                'type'=>'raw',
    //                'value'=>'CHtml::link("<i class=\"icon-pencil-blue\"></i>$data->no_pendaftaran",Yii::app()->controller->createUrl("/'.$module.'/inputPemeriksaan/update",array("pendaftaran_id"=>$data->pendaftaran_id,"pasienmasukpenunjang_id"=>$data->pasienmasukpenunjang_id)),array("rel"=>"tooltip","title"=>"Klik untuk mengubah pemeriksaan"))',
    //                'htmlOptions'=>array('width'=>'100px'),
    //            ),
                            //TEST BETA
                /*
                            array(
                                    'name'=>'no_pendaftaran',
                                    'header'=>'No. Pendaftaran',
                                    'type'=>'raw',
                                    'value'=>'CHtml::link("<i class=\"icon-form-ubah\"></i>$data->no_pendaftaran",Yii::app()->controller->createUrl("pemeriksaanPasienRadiologi/index",array("pasienmasukpenunjang_id"=>$data->pasienmasukpenunjang_id)),array("rel"=>"tooltip","title"=>"Klik untuk mengubah pemeriksaan"))',
                                    'htmlOptions'=>array('width'=>'100px'),
                            ),
                 * 
                 */
                            //'no_rekam_medik',
                            array(
                                    'header'=>'Nama Pasien',
                                    'type'=>'raw',
                                    'value'=> '((substr($data->no_rekam_medik,0,-6)) == "LB" || (substr($data->no_rekam_medik,0,-6)) == "RO" ? CHtml::link("<i class=\"icon-pencil-blue\"></i><br/>".$data->namadepan.$data->nama_pasien.\' / \'.$data->nama_bin, Yii::app()->createUrl("'.Yii::app()->controller->module->id.'/'.Yii::app()->controller->id.'/ubahPasien",array("id"=>"$data->pasien_id","modul_id"=>"'.Yii::app()->session['modul_id'].'")), array("rel"=>"tooltip","title"=>"Klik untuk mengubah data pasien")) : $data->namadepan.$data->nama_pasien )',
                            ),
    //            array(
    //                'header'=>'Kasus Penyakit / <br> Kelas Pelayanan',
    //                'type'=>'raw',
    //                'value'=>'"$data->jeniskasuspenyakit_nama"."<br/>"."$data->kelaspelayanan_nama"',
    //            ),
    //            'jeniskasuspenyakit_nama',
                            array(
                                    'header'=>'Jenis Kelamin/<br/>Umur',
                                    'type'=>'raw',
                                    'value'=>'$data->jeniskelamin."/<br/>".$data->umur',
                            ),
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
                                    'header'=>'Masukkan Hasil',
                                    'name'=>'masukanHasil',
                                    'type'=>'raw',
                                    'value'=>'CHtml::link("<i class=icon-form-input></i>",Yii::app()->controller->createUrl("/'.$module.'/'.$controller.'/hasilPemeriksaan",array("pendaftaran_id"=>$data->pendaftaran_id,"pasien_id"=>$data->pasien_id,"pasienmasukpenunjang_id"=>$data->pasienmasukpenunjang_id)),array("rel"=>"tooltip","title"=>"Klik untuk memasukkan hasil"))',    
                                    'htmlOptions'=>array('style'=>'text-align: center; width:40px')
                            ),
                             array(
                                    'name'=>'lihatHasil',
                                    'type'=>'raw',
                                    'value'=>'CHtml::link("<i class=icon-form-lihat></i>",Yii::app()->controller->createUrl("lihatHasil/HasilPeriksa",array("pendaftaran_id"=>$data->pendaftaran_id,"pasien_id"=>$data->pasien_id,"pasienmasukpenunjang_id"=>$data->pasienmasukpenunjang_id)),
                                                            array("rel"=>"tooltip",
                                                                      "title"=>"Klik untuk melihat hasil",
                                                                      "target"=>"iframeLihatHasil",
                                                                      "onclick"=>"$(\"#dialogLihatHasil\").dialog(\"open\");",
                                                            ))',    
                                    'htmlOptions'=>array('style'=>'text-align: center; width:40px')
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
		<br>  </div>
    <?php 
    // Dialog untuk Lihat Hasil =========================
    $this->beginWidget('zii.widgets.jui.CJuiDialog', array( 
            'id'=>'dialogLihatHasil',
            'options'=>array(
                    'title'=>'Hasil Pemeriksaan Radiologi',
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
                    'htmlOptions'=>array(),

    )); ?>

    <fieldset class="box">
        <legend class="rim"><i class="icon-white icon-search"></i> Pencarian</legend>
        <table width="100%" class="table-condensed">
			<tr> <br>
                        <td>
                            <div class="control-group">
                          <?php echo CHtml::label('Tanggal Pendaftaran','tglPendaftaran', array('class'=>'control-label')) ?>
                                  <div class="controls">  
									 
                                         <?php 
                                         $modPasienMasukPenunjang->tgl_awal = MyFormatter::formatDateTimeForUser($modPasienMasukPenunjang->tgl_awal);
                                $modPasienMasukPenunjang->tgl_akhir = MyFormatter::formatDateTimeForUser($modPasienMasukPenunjang->tgl_akhir);
                                         $this->widget('MyDateTimePicker',array(
                                                                                 'model'=>$modPasienMasukPenunjang,
                                                                                 'attribute'=>'tgl_awal',
                                                                                 'mode'=>'datetime',
//                                          'maxDate'=>'d',
                                                                                 'options'=> array(
                                                                                 'dateFormat'=>Params::DATE_FORMAT,
                                                                                ),
                                                                                 'htmlOptions'=>array('readonly'=>true,
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
                                                                                 'mode'=>'datetime',
//                                         'maxdate'=>'d',
                                                                                 'options'=> array(
                                                                                 'dateFormat'=>Params::DATE_FORMAT,
                                                                                ),
                                                                                 'htmlOptions'=>array('readonly'=>true,
                                                                                 'onkeypress'=>"return $(this).focusNextInputField(event)"),
											)); ?>
                                   </div> 
                            </div>
                                 <?php echo $form->textFieldRow($modPasienMasukPenunjang,'no_rekam_medik',array('autofocus'=>true, 'class'=>'span3','onkeypress'=>"return $(this).focusNextInputField(event)", 'maxlength'=>50, 'placeholder'=>'Ketik no. rekam medik')); ?>

                        </td>
                        <td>
                                <?php echo $form->textFieldRow($modPasienMasukPenunjang,'no_pendaftaran',array('class'=>'span3','onkeypress'=>"return $(this).focusNextInputField(event)", 'maxlength'=>50, 'placeholder'=>'Ketik no. pendaftaran')); ?>
                                <?php echo $form->textFieldRow($modPasienMasukPenunjang,'nama_pasien',array('class'=>'span3','onkeypress'=>"return $(this).focusNextInputField(event)", 'maxlength'=>50, 'placeholder'=>'Ketik nama pasien')); ?>
                                <?php // echo $form->textFieldRow($modPasienMasukPenunjang,'nama_bin',array('class'=>'span3','onkeypress'=>"return $(this).focusNextInputField(event)", 'maxlength'=>50, 'placeholder'=>'Alias')); ?>
                                <?php 
                                $carabayar = CarabayarM::model()->findAll(array(
                                    'condition'=>'carabayar_aktif = true',
                                    'order'=>'carabayar_nourut',
                                ));
                                foreach ($carabayar as $idx=>$item) {
                                    $penjamins = PenjaminpasienM::model()->findByAttributes(array(
                                        'carabayar_id'=>$item->carabayar_id,
                                        'penjamin_aktif'=>true,
                                   ));
                                   if (empty($penjamins)) unset($carabayar[$idx]);
                                }
                                $penjamin = PenjaminpasienM::model()->findAll(array(
                                    'condition'=>'penjamin_aktif = true',
                                    'order'=>'penjamin_nama',
                                ));
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

					</br></tr>
        </table>
        <div class="form-actions">
                <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="icon-search icon-white"></i>')),
                                        array('class'=>'btn btn-primary', 'type'=>'submit','onKeypress'=>'return formSubmit(this,event)')); ?>
                <?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
                                                        Yii::app()->createUrl($this->module->id.'/'.Yii::app()->controller->id.'/'.Yii::app()->controller->action->id.''), 
                                                        array('class'=>'btn btn-danger',
                                                                  'onclick'=>'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'));  ?>
                <?php $content = $this->renderPartial('../tips/informasi',array(),true);
                                        $this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); ?>
        </div>
    </fieldset>  
    <?php $this->endWidget();?>
    <iframe id="suarapanggilan" src="#" style="display: none;"></iframe>
</div>
<script type="text/javascript">
{
function batalperiksa(pendaftaran_id, penunjang_id)
{
	myConfirm("Anda yakin akan membatalkan pemeriksaan radiologi pasien ini?","Perhatian!",function(r) {
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
                                        window.location = "<?php echo Yii::app()->createUrl('laboratorium/daftarPasien/index&status=1')?>";
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
			socket.emit('send',{conversationID:'antrian',panggil:3,antrian_id:pasienmasukpenunjang_id});
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

}
</script>