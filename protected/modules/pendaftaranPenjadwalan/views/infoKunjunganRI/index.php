<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form.js'); ?>

<?php

Yii::app()->clientScript->registerScript('search', "
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('PPInfoKunjungan-v', {
		data: $(this).serialize()
	});
	return false;
});
");
?>
<div class="white-container">
    <legend class="rim2">Informasi Pasien <b>Rawat Inap</b></legend>
    <div class="block-tabel">
        <h6>Tabel Pasien <b>Rawat Inap</b></h6>
        <div class="table-responsive">
            <?php
            ///$tglSkral = Yii::app()->dateFormatter->formatDateTime(/
            //                                        CDateTimeParser::parse($modPPInfoKunjunganRIV->tgl_awal, 'yyyy-MM-dd hh:mm:ss'));
            //echo $tglSkr=date('Y-m-d H:i:s').'fffffffffffff';
            //echo  $tanggalSaja=trim(substr($tglSkr,0,-8));
            $this->widget('ext.bootstrap.widgets.BootGridView',
                array(
                    'id'=>'PPInfoKunjungan-v',
                    'dataProvider'=>$modPPInfoKunjunganRIV->searchRI(),
                    'template'=>"{summary}\n{items}\n{pager}",
                    'itemsCssClass'=>'table table-striped table-bordered table-condensed',
                    'columns'=>array(
                        array(
                            'name'=>'tgl_pendaftaran',
                            'type'=>'raw',
                            'value'=>'MyFormatter::formatDateTimeForUser($data->tgl_pendaftaran)'
                        ),
            //            array(
            //                'header'=>'No. RM <br> No. Pendaftaran',
            //                'name'=>'no_pendaftaran',
            //                'type'=>'raw',
            //                'value'=>'(!empty($data->no_pendaftaran) ? CHtml::link("<i class=icon-print></i> ".$data->no_pendaftaran, "javascript:print(\'$data->pasienadmisi_id\');",array("rel"=>"tooltip","rel"=>"tooltip","title"=>"Klik Untuk Print Lembar Poli")) : "-") . "<br>" . CHtml::link("<i class=icon-pencil-brown></i> ".$data->no_rekam_medik, Yii::app()->createUrl("pendaftaranPenjadwalan/InfoKunjunganRJ/ubahPasien",array("id"=>"$data->pasien_id", "menu"=>"RI")),array("rel"=>"tooltip","rel"=>"tooltip","title"=>"Klik Untuk Edit Data Pasien"))',
            //                'htmlOptions'=>array('style'=>'text-align: left; width:120px')
            //            ),
                                    array(
                                            'header'=>'No. Rekam Medis / <br> No. Pendaftaran',
                                            'name'=>'no_pendaftaran',
                                            'type'=>'raw',
                                            'value'=>'
                                                            CHtml::link("<i class=\'icon-form-ubah\'></i> ".$data->no_rekam_medik, Yii::app()->createUrl("/pendaftaranPenjadwalan/InfoKunjunganRJ/ubahPasienAjax", array("pendaftaran_id"=>$data->pendaftaran_id)),
                                                            array("class"=>"",
                                                            "target"=>"frameEditPasien",
                                                            "rel"=>"tooltip",
                                                            "title"=>"Klik Untuk Mengubah Data Pasien",
                                                            "onclick"=>"$(\'#editPasien\').dialog(\'open\');return true;"))
                                                            ." <br> " .
                                                             (!empty($data->no_pendaftaran) ? 
                                                             CHtml::link("<i class=icon-form-print></i> ".$data->no_pendaftaran, "javascript:print(\'$data->pendaftaran_id\');",array("rel"=>"tooltip","rel"=>"tooltip","title"=>"Klik Untuk Print Lembar Poli")) : "-") 
                                                             ',
                                            'htmlOptions'=>array('style'=>'text-align: center; width:120px')
                                    ), 
                        array(
                            'header'=>'Nama Depan',
                            'type'=>'raw',
                            'value'=>'$data->namadepan'
                        ),
                        array(
                            'header'=>'Nama',
                            'type'=>'raw',
                            'value'=>'$data->NamaAlias'
                        ),
                        'alamat_pasien',
                        array(
                            'name'=>'Jenis Kelamin',
                            'type'=>'raw',
                            'value'=>'((!empty($data->jeniskelamin)&&($data->statusperiksa!=Params::STATUSPERIKSA_SUDAH_PULANG)) ? CHtml::link("<i class=icon-form-ubah></i> ".$data->jeniskelamin," ",array("onclick"=>"ubahJenisKelamin(\'$data->no_rekam_medik\');$(\'#editJenisKelamin\').dialog(\'open\');return false;", "rel"=>"tooltip","rel"=>"tooltip","title"=>"Klik Untuk Mengubah Data Jenis Kelamin Pasien")): $data->jeniskelamin)',
                            'htmlOptions'=>array('style'=>'text-align: left')
                        ),
                        array(
                           'header'=>'Status Masuk',
                           'type'=>'raw',
                           'value'=>'$data->statusmasuk',
                        ),
                        array(
                           'header'=>'Status Masuk',
                           'type'=>'raw',
                           'value'=>'$data->caramasuk_nama',
                        ),
                        array(
                            'header'=>'Status Konfirmasi',
                            'type'=>'raw',
                            'value'=>'($data->status_konfirmasi == "" ) ? "-" : $data->status_konfirmasi',
                        ),
                        array(
                            'header'=>'Perujuk',
                            'type'=>'raw',
                            'value'=>'$data->nama_perujuk',
                        ),
                        // array(
                        //     'header'=>'P3 / Asuransi',
                        //     'type'=>'raw',
                        //     'value'=>'$data->namapemilik_asuransi',
                        // ),
						array(
							'name'=>'CaraBayar/Penjamin',
							'type'=>'raw',
//							'value'=>'((!empty($data->CaraBayarPenjamin)&&($data->statusperiksa!=Params::STATUSPERIKSA_BATAL_PERIKSA)) ? 
//							 CHtml::Link("<i class=icon-pencil></i>$data->CaraBayarPenjamin",Yii::app()->createUrl("pendaftaranPenjadwalan/infoKunjunganRI/ubahCaraBayarRI",array("id"=>$data->pendaftaran_id,"frame"=>true)),
//									 array("class"=>"", 
//										   "target"=>"iframeUbahCaraBayar",
//										   "onclick"=>"$(\'#carabayardialog\').dialog(\'open\');",
//										   "rel"=>"tooltip",
//										   "title"=>"Klik Untuk Mengubah Cara Bayar & Penjamin pasien",
//							 )): $data->CaraBayarPenjamin)',
//							'htmlOptions'=>array(
//								'style'=>'text-align: left',
//								'class'=>'inap'
								'value'=>'((!empty($data->CaraBayarPenjamin)&&($data->statusperiksa!=Params::STATUSPERIKSA_BATAL_PERIKSA)) ? 
								 CHtml::Link("<i class=icon-form-ubah></i>$data->CaraBayarPenjamin",Yii::app()->createUrl("pendaftaranPenjadwalan/infoKunjunganRI/ubahCaraBayarRI",array("id"=>$data->pendaftaran_id,"frame"=>true)),
								array("class"=>"", 
									  "onclick"=>"$(\'#carabayardialog\').dialog(\'open\');loadFormCaraBayar(this);return false;",
									  "rel"=>"tooltip",
									  "title"=>"Klik Untuk Mengubah Cara Bayar & Penjamin pasien",
								)): $data->CaraBayarPenjamin)',
							'htmlOptions'=>array(
								 'style'=>'text-align: left',
								 'class'=>'inap'
								)
						 ),
						array(
							'name'=>'Nama Dokter',
							'type'=>'raw',
								'value'=>'((!empty($data->nama_pegawai)&&($data->statusperiksa!=Params::STATUSPERIKSA_BATAL_PERIKSA)) ? 
								 CHtml::Link("<i class=icon-form-ubah></i>$data->gelardepan $data->nama_pegawai $data->gelarbelakang_nama",Yii::app()->createUrl("pendaftaranPenjadwalan/infoKunjunganRI/ubahDokterPeriksaRI",array("id"=>$data->pendaftaran_id,"frame"=>true)),
								array("class"=>"", 
									  "onclick"=>"$(\'#editDokterPeriksa\').dialog(\'open\');loadFormDokterPeriksa(this);return false;",
									  "rel"=>"tooltip",
									  "title"=>"Klik Untuk Mengubah Data Dokter",
								)): $data->gelardepan)',
							'htmlOptions'=>array(
								 'style'=>'text-align: center',
								 'class'=>'inap'
								)
						 ),
//                        array(
//                           'name'=>'Nama Dokter',
//                           'type'=>'raw',
//                           'value'=>'"<div style=\'width:120px;\'>" . CHtml::link("<i class=icon-form-ubah></i> ". $data->gelardepan." ".$data->nama_pegawai." ".$data->gelarbelakang_nama," ",array("onclick"=>"ubahDokterPeriksa(\'$data->pendaftaran_id\');$(\'#editDokterPeriksa\').dialog(\'open\');return false;", "rel"=>"tooltip","rel"=>"tooltip","title"=>"Klik Untuk Mengubah Data Dokter Periksa")) . "</div>"',
//                           'htmlOptions'=>array(
//                                'style'=>'text-align:center;',
//                                'class'=>'inap'
//                           )
//                        ),
                        array(
                           'name'=>'Kelas Pelayanan',
                           'type'=>'raw',
                           'value'=>'"<div style=\'width:50px;\'>" . CHtml::link("<i class=icon-form-ubah></i>". $data->kelaspelayanan_nama," ",array("onclick"=>"ubahKelasPelayanan(\'$data->pendaftaran_id\');$(\'#editKelasPelayanan\').dialog(\'open\');return false;", "rel"=>"tooltip","rel"=>"tooltip","title"=>"Klik Untuk Mengubah Data Kelas Pelayanan")) . "</div>"',
                           'htmlOptions'=>array(
                                'style'=>'text-align:center;',
                                'class'=>'inap'
                           )
                        ),
                        array(
                            'header'=>'Ruangan Kamar',
                            'type'=>'raw',
                            'value'=>'"Kamar :".$data->kamarruangan_nokamar."<br>"."Bed :".$data->kamarruangan_nobed',
                        ),
                        array(
                            'name'=>'ruangan_nama',
                            'type'=>'raw',
                            'value'=>'(
                                (!empty($data->ruangan_nama)&&($data->statusperiksa!=Params::STATUSPERIKSA_BATAL_PERIKSA)) ? 
                                    CHtml::link(
                                        "<i class=icon-form-ubah></i> ".$data->ruangan_nama,
                                        " ",
                                        array(
                                            "onCLick"=>"gantiPoli(\'$data->pendaftaran_id\',\'$data->ruangan_id\',\'$data->instalasi_id\',\'$data->pasien_id\',\'$data->nama_pasien\',\'$data->pasienadmisi_id\');return false;",
                                            "rel"=>"tooltip",
                                            "title"=>"Klik Untuk Mengubah Ruangan Pasien"
                                        )
                                    ) : 
                                    $data->ruangan_nama
                                )',
                            'htmlOptions'=>array(
                                'style'=>'text-align: left',
                                'class'=>'inap'
                            )
                        ),
						array(
							'name'=>'keterangan_pendaftaran',
							'type'=>'raw',
							'value'=>'"<div style=\'width:100px;\'>" . CHtml::link("<i class=icon-form-ubah></i>". $data->keterangan_pendaftaran," ",array("onclick"=>"ubahKeterangan(\'$data->pendaftaran_id\');$(\'#editKeterangan\').dialog(\'open\');return false;", "rel"=>"tooltip","rel"=>"tooltip","title"=>"Klik Untuk Mengubah Keterangan Pendaftaran")) . "</div>"',
							'htmlOptions'=>array('style'=>'text-align: left')
						),
                        array(
                                'header'=>'Pemeriksaan Fisik & Anamnesa',
                                'type'=>'raw',
                                'value'=>'(CHtml::link("<i class=\'icon-form-periksa\'></i> ", Yii::app()->controller->createUrl("/pendaftaranPenjadwalan/pemeriksaanFisikAnamnesaRI",array("pendaftaran_id"=>$data->pendaftaran_id,"pasienadmisi_id"=>$data->pasienadmisi_id)),array("id"=>"$data->no_pendaftaran","rel"=>"tooltip","title"=>"Klik untuk Pemeriksaan Fisik & Anamnesa Pasien")))',
                                'htmlOptions'=>array('style'=>'text-align: left; width:40px'),
                            ),
                        array(
                           'header'=>'Verifikasi Diagnosa',
                           'type'=>'raw',
                           'value'=>''
                            .'(isset($data->Morbiditas->pasienmorbiditas_id) ? "<div class=\"inap\" style=\"background-color:#33FF00; text-align: left\">" : "<div style=\"background-color:#FF0000; text-align: center\">")'
                            .'.(CHtml::Link("<i class=icon-form-verifikasi></i>Verifikasi Diagnosa",Yii::app()->createUrl("'.Yii::app()->controller->module->id.'/verifikasiDiagnosa/index",array("id"=>$data->pendaftaran_id,"menu"=>"RI","frame"=>true)),
                                        array("class"=>"", 
                                              "target"=>"iframeVerifikasiDiagnosa",
                                              "onclick"=>"$(\"#dialogVerifikasiDiagnosa\").dialog(\"open\");",
                                              "rel"=>"tooltip",
                                              "title"=>"Klik Verifikasi Diagnosa",
                                )))."</div>"',  
                        ),
                        array(
                            'name'=>'statusperiksa',
                            'type'=>'raw',
                            'value'=>'$data->statusperiksa',
                            'htmlOptions'=>array(
                                'style'=>'text-align: left',
                                'class'=>'status'
                            )
                        ),
                    ),
                    'afterAjaxUpdate'=>'function(id, data){
                        jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});
                        disableLink();
                    }',
                )
            );
            ?>
        </div>
    </div>
    <fieldset class="search-form box" style="">
        <legend class="rim"><i class="icon-search icon-white"></i> Pencarian berdasarkan : </legend>
        <?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
                'action'=>Yii::app()->createUrl($this->route),
                'method'=>'get',
                'id'=>'formCari',
                'type'=>'horizontal',
                'focus'=>'#'.CHtml::activeId($modPPInfoKunjunganRIV,'no_rekam_medik'),
                'htmlOptions'=>array('enctype'=>'multipart/form-data','onKeyPress'=>'return disableKeyPress(event)'),

        )); ?>
        <table class="row-fluid">
            <tr>
                <td width='30%'>
                    <?php echo $form->labelEx($modPPInfoKunjunganRIV,'tgl_pendaftaran', array('class'=>'control-label')) ?>
                          <div class="controls">  
                            <?php $modPPInfoKunjunganRIV->tgl_awal=$format->formatDateTimeForUser($modPPInfoKunjunganRIV->tgl_awal); ?>
                            <?php $this->widget('MyDateTimePicker',array(
                                                 'model'=>$modPPInfoKunjunganRIV,
                                                 'attribute'=>'tgl_awal',
                                                 'mode'=>'date',
        //                                          'maxDate'=>'d',
                                                 'options'=> array(
                                                 'dateFormat'=>Params::DATE_FORMAT,
                                                ),
                                                 'htmlOptions'=>array('readonly'=>true,
                                                 'class'=>'dtPicker2',
                                                 'onkeypress'=>"return $(this).focusNextInputField(event)"),
                            )); ?>
                              <?php $modPPInfoKunjunganRIV->tgl_awal=$format->formatDateTimeForDb($modPPInfoKunjunganRIV->tgl_awal); ?>
                      </div> 
                            <?php echo CHtml::label(' Sampai Dengan',' Sampai Dengan', array('class'=>'control-label')) ?>
                            <div class="controls">  
                            <?php $modPPInfoKunjunganRIV->tgl_akhir=$format->formatDateTimeForUser($modPPInfoKunjunganRIV->tgl_akhir); ?>
                            <?php $this->widget('MyDateTimePicker',array(
                                                 'model'=>$modPPInfoKunjunganRIV,
                                                 'attribute'=>'tgl_akhir',
                                                 'mode'=>'date',
        //                                         'maxdate'=>'d',
                                                 'options'=> array(
                                                 'dateFormat'=>Params::DATE_FORMAT,
                                                ),
                                                 'htmlOptions'=>array('readonly'=>true,
                                                 'class'=>'dtPicker2',
                                                 'onkeypress'=>"return $(this).focusNextInputField(event)"),
                                            )); ?>
                            <?php $modPPInfoKunjunganRIV->tgl_akhir=$format->formatDateTimeForDb($modPPInfoKunjunganRIV->tgl_akhir); ?>
                           </div> 
                        <?php echo $form->textFieldRow($modPPInfoKunjunganRIV,'no_rekam_medik',array('placeholder'=>'Ketik No. Rekam Medik','class'=>'span3 numberOnly','onkeypress'=>"return $(this).focusNextInputField(event)", 'maxlength'=>50)); ?>
                        <?php echo $form->textFieldRow($modPPInfoKunjunganRIV,'nama_pasien',array('placeholder'=>'Ketik Nama Pasien','class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event)", 'maxlength'=>50)); ?>
                        <?php echo $form->textAreaRow($modPPInfoKunjunganRIV,'alamat_pasien',array('placeholder'=>'Ketik Alamat Pasien','class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event)", 'maxlength'=>50)); ?>          
                </td>
                <td>
                    <?php echo $form->dropDownListRow($modPPInfoKunjunganRIV,'status_konfirmasi',CustomFunction::getStatusKonfirmasi(),array('empty'=>'-- Pilih --','onkeypress'=>"return $(this).focusNextInputField(event)",)); ?>
                    <?php echo $form->dropDownListRow($modPPInfoKunjunganRIV,'carabayar_id', CHtml::listData($modPPInfoKunjunganRIV->getCaraBayarItems(), 'carabayar_id', 'carabayar_nama') ,array('empty'=>'-- Pilih --','onkeypress'=>"return $(this).focusNextInputField(event)",
                        'ajax' => array('type'=>'POST',
                            'url'=> $this->createUrl('GetPenjaminPasien',array('encode'=>false,'namaModel'=>'PPInfoKunjunganRIV')), 
                            'update'=>'#PPInfoKunjunganRIV_penjamin_id'  //selector to update
                        ),
                    )); ?>
                    <?php echo CHtml::label('Penjamin',' Penjamin', array('class'=>'control-label')) ?>&nbsp;&nbsp;
                    <?php echo $form->dropDownList($modPPInfoKunjunganRIV,'penjamin_id', CHtml::listData($modPPInfoKunjunganRIV->getPenjaminItems(), 'penjamin_id', 'penjamin_nama') ,array('empty'=>'-- Pilih --','onkeypress'=>"return $(this).focusNextInputField(event)",)); ?>
                </td>
                <td>
                    <?php echo $form->dropDownListRow($modPPInfoKunjunganRIV,'propinsi_id', CHtml::listData($modPPInfoKunjunganRIV->getPropinsiItems(), 'propinsi_id', 'propinsi_nama'), 
                        array('empty'=>'-- Pilih --',
                              'ajax'=>array('type'=>'POST',
                                            'url'=>$this->createUrl('SetDropdownKabupaten',array('encode'=>false,'model_nama'=>get_class($modPPInfoKunjunganRIV))),
                                            'update'=>'#PPInfoKunjunganRIV_kabupaten_id'),
                            'onkeypress'=>"return $(this).focusNextInputField(event)"
                            )); ?>
                    <?php echo $form->dropDownListRow($modPPInfoKunjunganRIV,'kabupaten_id',array(),
                        array('empty'=>'-- Pilih --',
                              'ajax'=>array('type'=>'POST',
                                            'url'=>$this->createUrl('SetDropdownKecamatan',array('encode'=>false,'model_nama'=>get_class($modPPInfoKunjunganRIV))),
                                            'update'=>'#PPInfoKunjunganRIV_kecamatan_id'),
                                            'onkeypress'=>"return $(this).focusNextInputField(event)"
                          )); ?>
                    <?php echo $form->dropDownListRow($modPPInfoKunjunganRIV,'kecamatan_id',array(),
                        array('empty'=>'-- Pilih --',
                              'ajax'=>array('type'=>'POST',
                                            'url'=>$this->createUrl('SetDropdownKelurahan',array('encode'=>false,'model_nama'=>get_class($modPPInfoKunjunganRIV))),
                                            'update'=>'#PPInfoKunjunganRIV_kelurahan_id'),
                                            'onkeypress'=>"return $(this).focusNextInputField(event)"
                            )); ?>    
                    <?php echo $form->dropDownListRow($modPPInfoKunjunganRIV,'kelurahan_id',array(),array('empty'=>'-- Pilih --','onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
                </td>
            </tr>
        </table>
        <div class="form-actions">
            <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),
                                                       array('class'=>'btn btn-primary', 'type'=>'submit','id'=>'btn_simpan'));
            ?>
            <?php echo CHtml::link(Yii::t('mds','{icon} Reset',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
                                        $this->createUrl($this->id.'/index'), 
                                        array('class'=>'btn btn-danger',
                                            'onclick'=>'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r) {if(r) window.location = "'.$this->createUrl('index').'";} ); return false;'));  ?>

            <?php 
                $content = $this->renderPartial('pendaftaranPenjadwalan.views.tips.informasi',array(),true);
                $this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); 
            ?>    
        </div>
    </fieldset>
    <?php $this->endWidget();
         $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
         $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
         $urlPrintLembarPoli = Yii::app()->createUrl($module.'pendaftaran/lembarPoliRI',array('pendaftaran_id'=>''));
    ?>

    <?php 
    $this->beginWidget('zii.widgets.jui.CJuiDialog', array( 
        'id'=>'dialogVerifikasiDiagnosa',
        'options'=>array(
            'title'=>'Verifikasi Diagnosa',
            'autoOpen'=>false,
            'modal'=>true,
            'zIndex'=>1002,
            'minWidth'=>1124,
            'minHeight'=>610,
            'resizable'=>true,
			'close'=>"js:function(){ $.fn.yiiGridView.update('PPInfoKunjungan-v', {
					data: $(this).serialize()
				}); }",
        ),
    ));
    ?>
    <iframe id="iframeVerifikasiDiagnosa"  name="iframeVerifikasiDiagnosa" width="100%" height="550" >
    </iframe>
    <?php $this->endWidget(); ?>
    <?php

    //========= Ganti Poli Dialog =============================
    $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
        'id'=>'ganti_poli',
        'options'=>array(
            'title'=>'Ganti Ruangan Pasien - <span id="titleNamaPasien"></span>',
            'autoOpen'=>false,
            'zIndex'=>1002,
            'minWidth'=>400,
            'modal'=>true,
        ),
    ));
    ?>
    <table>
        <tr>
            <td>Ruangan</td>
            <td>:</td>
            <td>
                <?php echo CHtml::dropDownList('ruangan_sebelumnya','', array(),array('disabled'=>true));?>
                <?php echo CHtml::hiddenField('ruangan_awal','',array('readonly'=>true));?>
            </td>
        </tr>
        <tr>
            <td>Alasan Perubahan <span class="required">*</span></td>
            <td>:</td>
            <td><?php echo CHtml::textArea('alasanperubahan','', array());?></td>
        </tr>
        <tr>
            <td>Menjadi Ruangan</td>
            <td>:</td>
            <td><?php echo CHtml::dropDownList('ruangan_id_ganti','ruangan_id_ganti', array(),array('empty'=>'--pilih--',));?></td>
        </tr>
    </table>
    <?php

    echo CHtml::hiddenField('pendaftaran_id');
    echo CHtml::hiddenField('pasien_id');
    echo CHtml::hiddenField('pasienadmisi_id');
    echo CHtml::hiddenField('instalasi_id');
    echo CHtml::htmlButton(Yii::t('mds','{icon} Ya',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),
                                                    array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'simpanRuanganBaru();'));
    echo '&nbsp;&nbsp;&nbsp;'.CHtml::htmlButton(Yii::t('mds','{icon} Batal',array('{icon}'=>'<i class="icon-ban-circle icon-white"></i>')),
                                                    array('class'=>'btn btn-danger', 'type'=>'button','onclick'=>'$(\'#ganti_poli\').dialog(\'close\');'));


    $this->endWidget('zii.widgets.jui.CJuiDialog');
//========= end Ganti Ruangan Dialog =========================

//Yii::app()->clientScript->registerScript('jsPendaftaran',$js, CClientScript::POS_HEAD);
// ===========================Dialog Batal Periksa=================
        $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
                            'id'=>'confirm',
                                // additional javascript options for the dialog plugin
                                'options'=>array(
                                'title'=>'',
                                'autoOpen'=>false,
                                'show'=>'blind',
                                'hide'=>'explode',
                                'zIndex'=>1002,
                                'minWidth'=>500,
                                'minHeight'=>100,
                                'resizable'=>false,
                                'modal'=>true,    
                                 ),
                            ));
                            echo '<center>Apakah Anda Yakin Akan Membatalkan Pemeriksaan Pasien Ini?<br><br>' ;  
                            echo CHtml::htmlButton(Yii::t('mds','{icon} Ya',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),
                                                array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'ubahPeriksa();'));
                            echo '&nbsp;&nbsp;&nbsp;'.CHtml::htmlButton(Yii::t('mds','{icon} Batal',array('{icon}'=>'<i class="icon-ban-circle icon-white"></i>')),
                                                array('class'=>'btn btn-danger', 'type'=>'button','onclick'=>'$(\'#confirm\').dialog(\'close\');'));
                            echo CHtml::hiddenField('pendaftaran_id', '');
                            echo CHtml::hiddenField('statusperiksa', '');
//                            echo '14 April 2012 Belum Berjalan Karena Untuk <br> 
//                                Pengecekannya Harus Kasir Dulu N tabel yang diperlukan ataw 
//                                view yang diperlukan belum ada';
    $this->endWidget('zii.widgets.jui.CJuiDialog');
//===============================Akhir Dialog Batal Periksa=====================

   
    
//======================================================JAVA SCRIPT===================================================                          
$controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
$module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
$url=  Yii::app()->createAbsoluteUrl($module.'/'.$controller);
//$urlPrintLembarPoli = Yii::app()->createUrl('pendaftaranPenjadwalan/pendaftaran/lembarPoliRI',array('pasienadmisi_id'=>''));
$urlPrintLembarPoli = Yii::app()->createUrl('pendaftaranPenjadwalan/pendaftaranRawatInap/printStatusRI',array('pendaftaran_id'=>''));
$urlListDokterRuangan = $this->createUrl('listDokterRuangan');
$urlGetRuangan=$this->createUrl('GetRuanganPasien'); 
$simpanRuanganBaru=$this->createUrl('SaveRuanganBaru'); 
$statusPeriksaBatalPeriksa=Params::STATUSPERIKSA_BATAL_PERIKSA;

$js = <<< JSCRIPT
//====================================Awal Ubah Cara Bayar============================================================

   
//=====================================Akhir Ubah Cara Bayar============================================================    

//======================================Awal batal Periksa==============================================================

function dialogConfirm(pendaftaran_id,statusperiksa)
   {
        $('#confirm #pendaftaran_id').val(pendaftaran_id);
        $('#confirm #statusperiksa').val(statusperiksa);
        $('#confirm').dialog('open');
        
   } 
function ubahPeriksa()
    {
      var url =$('#url').val();
      var statusperiksa=$('#confirm #statusperiksa').val();
      var pendaftaran_id=$('#confirm #pendaftaran_id').val(); 
      if(statusperiksa=='${statusPeriksaBatalPeriksa}')
        {
            myAlert('PasienSudah Dibatalkan');
        }
      else
        {
             $.post("${url}/ubahPeriksa", {pendaftaran_id: pendaftaran_id,statusperiksa:statusperiksa},
                function(data){
                     myAlert(data.message);
                },"json");
            
        }
   
    }   
//=======================================Akhir Batal Periksa=============================================================   

//=======================================Awal Print Lembar Poli==========================================================

function print(pendaftaran_id)
{
   window.open('${urlPrintLembarPoli}'+pendaftaran_id,'printwin','left=100,top=100,width=400,height=400');    
}
//========================================Akhir Print Lembar Poli========================================================

//========================================Awal Ganti Ruangan==================================================================

function gantiPoli(pendaftaran_id,ruangan_id,instalasi_id,pasien_id,namaPasien,pasienadmisi_id)
    {
        $('#titleNamaPasien').html(namaPasien);
           $.post("${urlGetRuangan}", { pendaftaran_id: pendaftaran_id, ruangan_id: ruangan_id,instalasi_id:instalasi_id,pasien_id:pasien_id},
           function(data){
            $('#ganti_poli').dialog('open');
            $('#ganti_poli #ruangan_awal').val(ruangan_id);
            $('#ganti_poli #ruangan_sebelumnya').html(data.dropDown);
            $('#ganti_poli #ruangan_id_ganti').html(data.dropDown);
            $('#ganti_poli #pendaftaran_id').val(pendaftaran_id);
            $('#ganti_poli #pasien_id').val(pasien_id);
            $('#ganti_poli #pasienadmisi_id').val(pasienadmisi_id);
            $('#ganti_poli #instalasi_id').val(instalasi_id);
        }, "json");
    }
    
 function simpanRuanganBaru()
    {
        if($('#ganti_poli #alasanperubahan').val()==''){
           myAlert('Alasan Perubahan tidak boleh kosong!');
           $('#ganti_poli #alasanperubahan').addClass('error');
           return false;
        }
        $('#ganti_poli').dialog('close');
        var pendaftaran_id= $('#ganti_poli #pendaftaran_id').val();
        var pasien_id= $('#ganti_poli #pasien_id').val();
        var pasienadmisi_id= $('#ganti_poli #pasienadmisi_id').val();
        var ruangan_id= $('#ganti_poli #ruangan_id_ganti').val();
        var ruangan_awal= $('#ganti_poli #ruangan_awal').val();
        var alasan = $('#ganti_poli #alasanperubahan').val();
        $.post("${simpanRuanganBaru}", { pendaftaran_id: pendaftaran_id, ruangan_id: ruangan_id, ruangan_awal: ruangan_awal, alasan:alasan, pasien_id:pasien_id,pasienadmisi_id:pasienadmisi_id},
            function(data){
                if(data.status=='Gagal'){
                    myAlert(data.status);
                }else if(data.status =='OK'){
                    myAlert("Data berhasil diubah");
                }else{
                    myAlert(data.status);
                }
                $.fn.yiiGridView.update('PPInfoKunjungan-v', {
                            data: $('#formCari').serialize()
                });
            }, "json");
    }
//========================================Akhir Ganti Ruangan=========================================================

JSCRIPT;
Yii::app()->clientScript->registerScript('javascript',$js,CClientScript::POS_HEAD);                        

$js = <<< JS
$('.numberOnly').keyup(function() {
var d = $(this).attr('numeric');
var value = $(this).val();
var orignalValue = value;
value = value.replace(/[0-9]*/g, "");
var msg = "Only Integer Values allowed.";

if (d == 'decimal') {
value = value.replace(/\./, "");
msg = "Only Numeric Values allowed.";
}

if (value != '') {
orignalValue = orignalValue.replace(/([^0-9].*)/g, "")
$(this).val(orignalValue);
}
});
JS;
Yii::app()->clientScript->registerScript('numberOnly',$js,CClientScript::POS_READY);
?>
<?php
    //=============================== Ganti Data Pasien Dialog =======================================
    $this->beginWidget('zii.widgets.jui.CJuiDialog',
        array(
            'id'=>'editPasien',
            'options'=>array(
                'title'=>'Ganti Data Pasien' ,
                'autoOpen'=>false,
                'zIndex'=>1002,
                'width' => 1280,
                'height' => 560,
                'resizable' => true,
            ),
        )
    );
  
    echo CHtml::hiddenField('temp_norekammedik','',array('readonly'=>true));
    echo '<iframe name="frameEditPasien" width="100%" height="100%"></iframe>';
    $this->endWidget('zii.widgets.jui.CJuiDialog');
?>

<?php
    //=============================== Ganti Data Jenis Kelamin Dialog =======================================
    $this->beginWidget('zii.widgets.jui.CJuiDialog',
        array(
            'id'=>'editJenisKelamin',
            'options'=>array(
                'title'=>'Ganti Data Jenis Kelamin',
                'autoOpen'=>false,
                'zIndex'=>1002,
                'minWidth'=>500,
                'modal'=>true,
            ),
        )
    );
    echo CHtml::hiddenField('temp_norekammedik','',array('readonly'=>true));
    echo '<div class="divForFormEditJenisKelamin"></div>';
    $this->endWidget('zii.widgets.jui.CJuiDialog');
?>

<?php
    //=============================== Ganti Data Kelas Pelayanan Dialog =======================================
    $this->beginWidget('zii.widgets.jui.CJuiDialog',
        array(
            'id'=>'editKelasPelayanan',
            'options'=>array(
                'title'=>'Ganti Kelas Pelayanan',
                'autoOpen'=>false,
                'zIndex'=>1002,
                'minWidth'=>500,
                'modal'=>true,
            ),
        )
    );
    echo CHtml::hiddenField('temp_idPendaftaranKP','',array('readonly'=>true));
    echo '<div class="divForFormEditKelasPelayanan"></div>';
    $this->endWidget('zii.widgets.jui.CJuiDialog');
?>

<?php
//========================================= Cara Bayar dialog =============================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id'=>'carabayardialog',
    'options'=>array(
        'title'=>'Ganti Cara Bayar dan Penjamin - <span id="titleNamaPasienCaraBayar"></span>',
        'autoOpen'=>false,
        'zIndex'=>1002,
        'minWidth'=>640,
        'modal'=>true,
        'resizable'=>false,
		'close'=>"js:function(){ $.fn.yiiGridView.update('PPInfoKunjungan-v', { }); }",
        //'hide'=>explode,
    ),
));
echo '<iframe id="iframeUbahCaraBayar"  name="iframeUbahCaraBayar" width="100%" height="550" >
</iframe>';

$this->endWidget('zii.widgets.jui.CJuiDialog');
//========================================================= end cara bayar dialog =========
    $this->beginWidget('zii.widgets.jui.CJuiDialog',
        array(
            'id'=>'editDokterPeriksa',
            'options'=>array(
                'title'=>'Ganti Dokter Periksa',
                'autoOpen'=>false,
				'zIndex'=>1002,
				'minWidth'=>500,
				'modal'=>true,
				'resizable'=>false,
				'close'=>"js:function(){ $.fn.yiiGridView.update('PPInfoKunjungan-v', { }); }",
            ),
        )
    );
//    echo CHtml::hiddenField('temp_idPendaftaranDP','',array('readonly'=>true));
//    echo '<div class="divForFormEditDokterPeriksa"></div>';
	echo '<iframe id="iframeDokterPeriksa"  name="iframeDokterPeriksa" width="100%" height="360" >
		</iframe>';
    $this->endWidget('zii.widgets.jui.CJuiDialog');
?>

	<?php
    //=============================== Ganti Data Keterangan pendaftaran =======================================
    $this->beginWidget('zii.widgets.jui.CJuiDialog',
        array(
            'id'=>'editKeterangan',
            'options'=>array(
                'title'=>'Ubah keterangan Pendaftaran',
                'autoOpen'=>false,
                'minWidth'=>500,
                'modal'=>true,
            ),
        )
    );
    echo CHtml::hiddenField('temp_idPendaftaranKet','',array('readonly'=>true));
    echo '<div class="divForFormEditKeterangan"></div>';
    $this->endWidget('zii.widgets.jui.CJuiDialog');
?>

<script type="text/javascript">
    function disableLink()
    {
        var status = null;
        $("#PPInfoKunjungan-v tbody").find('tr > td[class="inap"]').each(
            function()
            {
                status = $(this).parent().find('td[class="status"]');
                var xxx = $(this).find('a');
                if(status.text() == 'SUDAH PULANG')
                {
                   $(this).text($.trim(xxx.text()));
                   $(this).find('a').remove();
                }
            }
        );
    }
    disableLink();
    
    
    function ubahCaraBayar(namaPasien, id=null)
    {   
        $('#titleNamaPasienCaraBayar').html(namaPasien);
        jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('pendaftaranPenjadwalan/infoKunjunganRI/ubahCaraBayarRI')?>',
                     'data': $(this).serialize() + '&id='+id,
                     'type':'post',
                     'dataType':'json',
                     'success':function(data) {
                                if (data.status == 'create_form') {
                                    $('#carabayardialog div.divForFormUbahCaraBayar').html(data.div);
                                    $('#carabayardialog div.divForFormUbahCaraBayar form').submit(ubahCaraBayar);
                                } else {
                                    $('#carabayardialog div.divForFormUbahCaraBayar').html(data.div);
                                    $.fn.yiiGridView.update('PPInfoKunjungan-v', {
                                            data: $(this).serialize()
                                    });
                                    setTimeout("$('#carabayardialog').dialog('close') ",500);
                                }
                     } ,
                     'cache':false});
        return false; 
    }
    
    function listCaraBayar(idCaraBayar){
        $('#carabayardialog #tempCaraBayarId').val(idCaraBayar);
        return false;
    }

    function setIdPendaftaran(pendaftaran_id,noPendaftaran)
    {
        $('#carabayardialog #tempPendaftaranId').val(pendaftaran_id);
        $('#carabayardialog #tempNoPendaftaran').val(noPendaftaran);
    }
    
    function ubahJenisKelamin(norm)
    {
        $('#temp_norekammedik').val(norm);
        jQuery.ajax({'url':'<?php echo $this->createUrl('ubahJenisKelamin')?>',
            'data':$(this).serialize(),
            'type':'post',
            'dataType':'json',
            'success':function(data){
                if (data.status == 'create_form') {
                    $('#editJenisKelamin div.divForFormEditJenisKelamin').html(data.div);
                    $('#editJenisKelamin div.divForFormEditJenisKelamin form').submit(ubahJenisKelamin);
                }else{
                    $('#editJenisKelamin div.divForFormEditJenisKelamin').html(data.div);
                    $.fn.yiiGridView.update('PPInfoKunjungan-v', {
                            data: $(this).serialize()
                    });
                    setTimeout("$('#editJenisKelamin').dialog('close') ",500);
                }
            },
            'cache':false
        });
        return false; 
    }
    
    function ubahKelasPelayanan(pendaftaran_id)
    {
        $('#temp_idPendaftaranKP').val(pendaftaran_id);
        jQuery.ajax({'url':'<?php echo $this->createUrl('ubahKelasPelayananRI')?>',
            'data':$(this).serialize(),
            'type':'post',
            'dataType':'json',
            'success':function(data){
                if (data.status == 'create_form') {
                    $('#editKelasPelayanan div.divForFormEditKelasPelayanan').html(data.div);
                    $('#editKelasPelayanan div.divForFormEditKelasPelayanan form').submit(ubahKelasPelayanan);
                }else{
                    $('#editKelasPelayanan div.divForFormEditKelasPelayanan').html(data.div);
                    $.fn.yiiGridView.update('PPInfoKunjungan-v', {
                            data: $(this).serialize()
                    });
                    setTimeout("$('#editKelasPelayanan').dialog('close') ",500);
                }
            },
            'cache':false
        });
        return false; 
    }
    
    function ubahDokterPeriksa(pendaftaran_id)
    {
        $('#temp_idPendaftaranDP').val(pendaftaran_id);
        jQuery.ajax({'url':'<?php echo $this->createUrl('ubahDokterPeriksaRI')?>',
            'data':$(this).serialize(),
            'type':'post',
            'dataType':'json',
            'success':function(data){
                if (data.status == 'create_form') {
                    $('#editDokterPeriksa div.divForFormEditDokterPeriksa').html(data.div);
                    $('#editDokterPeriksa div.divForFormEditDokterPeriksa form').submit(ubahDokterPeriksa);
                }else{
                    $('#editDokterPeriksa div.divForFormEditDokterPeriksa').html(data.div);
                    $.fn.yiiGridView.update('PPInfoKunjungan-v', {
                            data: $(this).serialize()
                    });
                    setTimeout("$('#editDokterPeriksa').dialog('close') ",500);
                }
            },
            'cache':false
        });
        return false; 
    }
	
function loadFormCaraBayar(obj){
	var url = $(obj).attr('href');
	$('#iframeUbahCaraBayar').attr('src', url);
}
function loadFormDokterPeriksa(obj){
	var url = $(obj).attr('href');
	$('#iframeDokterPeriksa').attr('src', url);
}

function ubahKeterangan(pendaftaran_id)
{
    $('#temp_idPendaftaranKet').val(pendaftaran_id);
    jQuery.ajax({'url':'<?php echo $this->createUrl('ubahKeteranganPendaftaran')?>',
        'data':$(this).serialize(),
        'type':'post',
        'dataType':'json',
        'success':function(data){
            if (data.status == 'create_form') {
                $('#editKeterangan div.divForFormEditKeterangan').html(data.div);
                $('#editKeterangan div.divForFormEditKeterangan form').submit(ubahKeterangan);
            }else{
                $('#editKeterangan div.divForFormEditKeterangan').html(data.div);
                $.fn.yiiGridView.update('PPInfoKunjungan-v', {
                        data: $(this).serialize()
                });
                setTimeout("$('#editKeterangan').dialog('close') ",500);
            }
        },
        'cache':false
    });
    return false; 
}
    
</script>
<!-- UNTUK PERUBAHAN JENIS KASUS PENYAKIT DI UBAH POLI -->
<?php
$js = <<< JSCRIPT

function getKasusPenyakit(){
    ruangan_id = $('#ruangan_id_ganti').val();
    pendaftaran_id = $('#pendaftaran_id').val();
    pasien_id = $('#pasien_id').val();
    instalasi_id = $('#instalasi_id').val();
    jeniskasuspenyakit_id = '';  
        
   $.post("${urlGetRuangan}", { pendaftaran_id: pendaftaran_id, ruangan_id: ruangan_id, instalasi_id:instalasi_id, pasien_id:pasien_id,
   jeniskasuspenyakit_id:jeniskasuspenyakit_id},
   function(data){
            $('#ganti_poli').dialog('open');            
            $('#ganti_poli #ruangan_id_ganti').html(data.dropDown);
//            $('#ganti_poli #jeniskasuspenyakit_id_ganti').html(data.jenisKasusPenyakit);
    }, "json");
}
    
JSCRIPT;
Yii::app()->clientScript->registerScript('getKasusPenyakit',$js,CClientScript::POS_HEAD);
?>
<!-- UNTUK PERUBAHAN JENIS KASUS PENYAKIT DI UBAH POLI -->
</div>