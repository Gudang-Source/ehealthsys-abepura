<div class="white-container">
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
    <?php 
      $ruangan_id = Yii::app()->user->getState('ruangan_id');
      $link = explode("/", $_GET['r']);
      if($link[0]=='rekamMedis'){
        $anamnesa_link = 'pemeriksaanFisikAnamnesaRK';
      }else{
        $anamnesa_link = 'pemeriksaanFisikAnamnesa';
      }
    ?>
    
    <legend class="rim2">Infomasi Pasien <b>Rawat Darurat</b></legend>
    <div class="block-tabel">
        <h6>Tabel Pasien <b>Rawat Darurat</b></h6>
        <div class="table-responsive" style="overflow-x: scroll;">
        <?php $this->widget('ext.bootstrap.widgets.BootGridView',array(
                'id'=>'PPInfoKunjungan-v',
                'dataProvider'=>$modInfoKunjunganRDV->searchRD(),
        //        'filter'=>$modInfoKunjunganRDV,
                'template'=>"{summary}\n{items}\n{pager}",
                'itemsCssClass'=>'table table-striped table-bordered table-condensed',
                'columns'=>array(
                        array(
                            'header'=>'Tanggal Pendaftaran',
                            'type'=>'raw',
                            'value'=>'MyFormatter::formatDateTimeForUser($data->tgl_pendaftaran)',
                        ),
        //                array(
        //                    'header'=>'No. Rekam Medis / <br> No. Pendaftaran',
        //                    'name'=>'no_pendaftaran',
        //                    'type'=>'raw',
        //                    'value'=>'(!empty($data->no_pendaftaran) ? CHtml::link("<i class=icon-print></i> ".$data->no_pendaftaran, "javascript:print(\'$data->pendaftaran_id\');",array("rel"=>"tooltip","rel"=>"tooltip","title"=>"Klik Untuk Print Lembar Poli")) : "-") . "<br>" . CHtml::link("<i class=icon-pencil-brown></i> ".$data->no_rekam_medik, Yii::app()->createUrl("pendaftaranPenjadwalan/InfoKunjunganRJ/ubahPasien",array("id"=>"$data->pasien_id", "menu"=>"RD")),array("rel"=>"tooltip","rel"=>"tooltip","title"=>"Klik Untuk Edit Data Pasien"))',
        //                    'htmlOptions'=>array('style'=>'text-align: left; width:120px')
        //                ),
                                        array(
                            'header'=>'No Pendaftaran',
                            'name'=>'no_pendaftaran',
                            'type'=>'raw',
                            'value'=>'
                                (!empty($data->no_pendaftaran) ? 
                                CHtml::link("<i class=icon-form-print></i><br/>".$data->no_pendaftaran, "javascript:print(\'$data->pendaftaran_id\');",array("rel"=>"tooltip","rel"=>"tooltip","title"=>"Klik Untuk Print Lembar Poli")) : "-") 
                                ',
                            'htmlOptions'=>array('style'=>'text-align: center;')
                        ),
                        array(
                            'header'=>'No Rekam Medik',
                            'name'=>'no_rekam_medik',
                            'type'=>'raw',
                            'htmlOptions'=>array('style'=>'text-align: center;'),
                            'value'=>'CHtml::link("<i class=\'icon-form-ubah\'></i><br/>".$data->no_rekam_medik, Yii::app()->createUrl("/pendaftaranPenjadwalan/InfoKunjunganRJ/ubahPasienAjax", array("pendaftaran_id"=>$data->pendaftaran_id)),
                                                                array("class"=>"",
                                                                "target"=>"frameEditPasien",
                                                                "rel"=>"tooltip",
                                                                "title"=>"Klik Untuk Mengubah Data Pasien",
                                                                "onclick"=>"$(\'#editPasien\').dialog(\'open\');return true;"))'
                        ), /*
                       array(
                           'header'=>'Nama Depan',
                           'type'=>'raw',
                           'value'=>'$data->namadepan',
                       ), */
                       array(
                           'header'=>'Nama Pasien',
                           'type'=>'raw',
                           'value'=>'$data->namadepan.$data->nama_pasien',
                       ),                        
                        array(
                           'header'=>'Jenis Kelamin',
                           'type'=>'raw',
                           'value'=>'((!empty($data->jeniskelamin)&&($data->statusperiksa!=Params::STATUSPERIKSA_SUDAH_PULANG)) ? CHtml::link("<i class=icon-form-ubah></i> ".$data->jeniskelamin," ",array("onclick"=>"ubahJenisKelamin(\'$data->no_rekam_medik\');$(\'#editJenisKelamin\').dialog(\'open\');return false;", "rel"=>"tooltip","rel"=>"tooltip","title"=>"Klik Untuk Mengubah Data Jenis Kelamin Pasien")): $data->jeniskelamin)',
                           'htmlOptions'=>array('style'=>'text-align: left')
                        ),
                        array(
                            'header' => 'Alamat',
                            'value' => '$data->alamat_pasien',
                        ),
                        //'alamat_pasien',
                        array(
                           'header'=>'Jenis Kasus Penyakit',
                           'type'=>'raw',
                           'value'=>'CHtml::link("<i class=icon-form-ubah></i> ".$data->jeniskasuspenyakit_nama," ",array("onclick"=>"ubahKelompokPenyakit(\'$data->pendaftaran_id\');$(\'#editKelPenyakit\').dialog(\'open\');return false;", "rel"=>"tooltip","rel"=>"tooltip","title"=>"Klik Untuk Mengubah Data Kelompok Penyakit"))',
                           'htmlOptions'=>array(
                                'style'=>'text-align: left',
                               'class'=>'gawat'
                           )
                        ),
                        array(
                           'header'=>'Cara Masuk',
                           'type'=>'raw',
                           'value'=>'$data->statusmasuk',
                        ),
                         array(
                            'header'=>'Perujuk',
                            'type'=>'raw',
                            'value'=>function($data) {
                                $p = PendaftaranT::model()->findByPk($data->pendaftaran_id);
                                $r = RujukanT::model()->findByPk($p->rujukan_id);
                                return $data->asalrujukan_nama."/<br/>".(empty($r)?"-":$r->rujukandari->namaperujuk);
                            },
                        ),
                        
                       
                        // array(
                        //     'header'=>'P3 / Asuransi',
                        //     'type'=>'raw',
                        //     'value'=>'$data->namapemilik_asuransi',
                        // ),
                        array(
                        'header'=>'Cara Bayar/<br>Penjamin',
                        'type'=>'raw',
                        'value'=>'((!empty($data->CaraBayarPenjamin)&&($data->statusperiksa!=Params::STATUSPERIKSA_BATAL_PERIKSA)) ? 
                          CHtml::Link("<i class=icon-form-ubah></i>$data->CaraBayarPenjamin",Yii::app()->createUrl("pendaftaranPenjadwalan/infoKunjunganRJ/ubahCaraBayar",array("id"=>$data->pendaftaran_id,"menu"=>"RJ","frame"=>true)),
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
                            'header'=>'Status Konfirmasi',
                            'type'=>'raw',
                            'value'=>'($data->status_konfirmasi == "" ) ? "-" : $data->status_konfirmasi',
                        ),                
                        // array(
                        //     'name'=>'CaraBayar/Penjamin',
                        //     'type'=>'raw',
                        //     'value'=>'((!empty($data->CaraBayarPenjamin)&&($data->statusperiksa!=Params::STATUSPERIKSA_BATAL_PERIKSA)) ? CHtml::link("<i class=icon-pencil-brown></i> ".$data->CaraBayarPenjamin," ",array("onclick"=>"ubahCaraBayar(\'$data->nama_pasien\');listCaraBayar(\'$data->carabayar_id\');setIdPendaftaran(\'$data->pendaftaran_id\',\'$data->no_pendaftaran\');$(\'#carabayardialog\').dialog(\'open\');return false;",
                        //                                                                                                                      "rel"=>"tooltip","rel"=>"tooltip","title"=>"Klik Untuk Mengubah Cara Bayar & Penjamin pasien")) : Params::STATUSPERIKSA_BATAL_PERIKSA) ',
                        //     'htmlOptions'=>array(
                        //         'style'=>'text-align: left',
                        //         'class'=>'gawat'
                        //     )
                        // ),                         
                        array(
                            'header'=>'Dokter',
                            'type'=>'raw',
                            'value'=>'"<div style=\'width:120px;\'>" . CHtml::link("<i class=icon-form-ubah></i> ". $data->gelardepan." ".$data->nama_pegawai." ".$data->gelarbelakang_nama," ",array("onclick"=>"ubahDokterPeriksa(\'$data->pendaftaran_id\');$(\'#editDokterPeriksa\').dialog(\'open\');return false;", "rel"=>"tooltip","rel"=>"tooltip","title"=>"Klik Untuk Mengubah Data Dokter Periksa")) . "</div>"',
                            'htmlOptions'=>array(
                                'style'=>'text-align:center;',
                                'class'=>'gawat'
                            )  
                        ), /*
                        array(
                            'name'=>'Kelas Pelayanan',
                            'type'=>'raw',
                            'value'=>'"<div style=\'width:50px;\'>" . CHtml::link("<i class=icon-form-ubah></i>". $data->kelaspelayanan_nama," ",array("onclick"=>"ubahKelasPelayanan(\'$data->pendaftaran_id\');$(\'#editKelasPelayanan\').dialog(\'open\');return false;", "rel"=>"tooltip","rel"=>"tooltip","title"=>"Klik Untuk Mengubah Data Kelas Pelayanan")) . "</div>"',
                            'htmlOptions'=>array(
                                'style'=>'text-align:center;',
                                'class'=>'gawat'
                            )
                        ), */
                        array(
                           'header'=>'Ruangan',
                           'name'=>'ruangan_nama',
                           'type'=>'raw',
                           //'value'=>'((!empty($data->ruangan_nama)&&($data->statusperiksa==Params::STATUSPERIKSA_ANTRIAN)) ? "<div style=\'width:100px;\'>" . CHtml::link("<i class=icon-form-ubah></i> ".$data->ruangan_nama,"javascript:gantiPoli(\'$data->pendaftaran_id\',\'$data->ruangan_id\',\'$data->instalasi_id\',\'$data->pasien_id\',\"$data->nama_pasien\",\'$data->jeniskasuspenyakit_id\',\'$data->pegawai_id\',\'$data->kelaspelayanan_id\');",array("rel"=>"tooltip","rel"=>"tooltip","title"=>"Klik Untuk Mengubah Poliklinik")) . "</div>" : $data->ruangan_nama) ',
                            'value' => '((!empty($data->ruangan_nama)&&($data->statusperiksa==Params::STATUSPERIKSA_ANTRIAN)) ? $data->ruangan_nama : $data->ruangan_nama) ',
                           'htmlOptions'=>array('style'=>'text-align: left')
                        ),
						array(
							'name'=>'keterangan_pendaftaran',
							'type'=>'raw',
							'value'=>'"<div style=\'width:100px;\'>" . CHtml::link("<i class=icon-form-ubah></i>". $data->keterangan_pendaftaran," ",array("onclick"=>"ubahKeterangan(\'$data->pendaftaran_id\');$(\'#editKeterangan\').dialog(\'open\');return false;", "rel"=>"tooltip","rel"=>"tooltip","title"=>"Klik Untuk Mengubah Keterangan Pendaftaran")) . "</div>"',
							'htmlOptions'=>array('style'=>'text-align: left')
						), /*
                        array(
                       'header'=>'Verifikasi Diagnosa',
                       'type'=>'raw',
                       'value'=>''
                        .'(isset($data->Morbiditas->pasienmorbiditas_id) ? "<div class=\"inap\" style=\"background-color:#33FF00; text-align: left\">" : "<div style=\"background-color:#FF0000; text-align: left\">")'
                        .'.(CHtml::Link("<i class=icon-form-verifikasi></i>Verifikasi Diagnosa",Yii::app()->createUrl("'.Yii::app()->controller->module->id.'/verifikasiDiagnosa/index",array("id"=>$data->pendaftaran_id,"menu"=>"RD","frame"=>true)),
                                    array("class"=>"", 
                                          "target"=>"iframeVerifikasiDiagnosa",
                                          "onclick"=>"$(\"#dialogVerifikasiDiagnosa\").dialog(\"open\");",
                                          "rel"=>"tooltip",
                                          "title"=>"Klik Verifikasi Diagnosa",
                            )))."</div>"',  
                        ),
                        array(
                           'header'=>'Pemeriksaan Fisik <br/> & Anamnesa',
                           'type'=>'raw',
                           'value'=>'CHtml::Link("<i class=\"icon-form-periksa\"></i>",Yii::app()->createUrl("'.Yii::app()->controller->module->id.'/'.$anamnesa_link.'/indexAnamnesa",array("pendaftaran_id"=>$data->pendaftaran_id)),
                                    array("class"=>"", 
                                          "rel"=>"tooltip",
                                          "title"=>"Klik Pemeriksaan Fisik & Anamnesa",
                            ))',       
                           'htmlOptions'=>array(
                                'style'=>'text-align: left',
                           ),
                        ), */
                        //  array(
                        //    'header'=>'Pemeriksaan Fisik <br/> & Anamnesa',
                        //    'type'=>'raw',
                        //    'value'=>'CHtml::Link("<i class=\"icon-list-alt\"></i>",Yii::app()->createUrl("'.Yii::app()->controller->module->id.'/'.$anamnesa_link.'/indexAnamnesa",array("pendaftaran_id"=>$data->pendaftaran_id,"frame"=>true)),
                        //                 array("class"=>"", 
                        //                       "target"=>"iframePemeriksaanFisik",
                        //                       "onclick"=>"$(\"#dialogFisikAnamnesa\").dialog(\"open\");",
                        //                       "rel"=>"tooltip",
                        //                       "title"=>"Klik Pemeriksaan Fisik & Anamnesa",
                        //                 ))',          
                        //    'htmlOptions'=>array('style'=>'text-align: left; width:40px'),
                        // ),  
                        array(
                            'header'=>'Status Periksa',
                            'type'=>'raw',
    //                     'value'=>'$data->statusperiksa.CHtml::link("<i class=icon-pencil></i>","",array("href"=>"","rel"=>"tooltip","title"=>"Klik Untuk Mengubah Status Periksa","onclick"=>"{buatSessionUbahStatus($data->pendaftaran_id);}return false;"))',
                            'value'=>function($data) {
                                $t = TindakanpelayananT::model()->findByAttributes(array(
                                    'pendaftaran_id'=>$data->pendaftaran_id,
                                ), array(
                                    'condition'=>'tindakansudahbayar_id is not null',
                                ));
                                if (!empty($t)) return $data->statusperiksa;
                                return ((!empty($data->statusperiksa)&& ($data->statusperiksa==Params::STATUSPERIKSA_ANTRIAN)) ? CHtml::link("<i class=icon-form-silang></i> ".$data->statusperiksa, "javascript:dialogBatalPeriksa('$data->pendaftaran_id','$data->statusperiksa','$data->nama_pasien');",array("rel"=>"tooltip","rel"=>"tooltip","title"=>"Klik Membatalkan Pemeriksaan")) : $data->statusperiksa);
                            },//'',
                            'htmlOptions'=>array(
                                    'style'=>'text-align: center',
                                    'class'=>'status'
                                    )
                            ),
        //                array(
        //					'name'=>'statusperiksa',
        //					'type'=>'raw',
        //					'value'=>'$data->statusperiksa',
        //					'htmlOptions'=>array(
        //						'style'=>'text-align: left',
        //						'class'=>'status'
        //					)
        //				),
                        array(
                            'header'=>'Petugas Loket',
                            'type'=>'raw',
                            'name' => 'create_loginpemakai_id',
                            'value'=>function($data) {
                                $lp = LoginpemakaiK::model()->findByPk($data->create_loginpemakai_id);
                                return isset($lp->pegawai_id)?$lp->pegawai->namaLengkap:'-';
                            }
                        )
                   ),
                'afterAjaxUpdate'=>'function(id, data){
                    jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});
                        disableLink();
                }',
        )); ?>

        </div>
    </div>
    <div class="search-form" style="">
    <fieldset class="box">
        <legend class="rim"><i class="icon-search icon-white"></i> Pencarian berdasarkan : </legend>
		<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
				'action'=>Yii::app()->createUrl($this->route),
				'method'=>'get',
				'id'=>'formCari',
				'type'=>'horizontal',
				'focus'=>'#'.CHtml::activeId($modInfoKunjunganRDV,'no_rekam_medik'),
				'htmlOptions'=>array('enctype'=>'multipart/form-data','onKeyPress'=>'return disableKeyPress(event)'),

		)); ?>
        <table width="100%">
            <tr>
                <td width="30%">
                    <div class="control-group">
                        <?php echo $form->labelEx($modInfoKunjunganRDV,'tgl_pendaftaran', array('class'=>'control-label')) ?>
                        <div class="controls">  
                            <?php $modInfoKunjunganRDV->tgl_awal=$format->formatDateTimeForUser($modInfoKunjunganRDV->tgl_awal); ?>
                            <?php $this->widget('MyDateTimePicker',array(
                                             'model'=>$modInfoKunjunganRDV,
                                             'attribute'=>'tgl_awal',
                                             'mode'=>'date',
                                             'options'=> array(
                                                'maxDate'=>'d',
                                                'dateFormat'=>Params::DATE_FORMAT,
                                            ),
                                             'htmlOptions'=>array('readonly'=>true,
                                             'class'=>'dtPicker2',
                                             'onkeypress'=>"return $(this).focusNextInputField(event)"),
                                            )); ?>
                            <?php $modInfoKunjunganRDV->tgl_awal=$format->formatDateTimeForDb($modInfoKunjunganRDV->tgl_awal); ?>
                        </div>
                    </div>
                    <div class="control-group">
                        <?php echo CHtml::label(' Sampai Dengan',' Sampai Dengan', array('class'=>'control-label')) ?>
                        <div class="controls">  
                            <?php $modInfoKunjunganRDV->tgl_akhir=$format->formatDateTimeForUser($modInfoKunjunganRDV->tgl_akhir); ?>
                            <?php $this->widget('MyDateTimePicker',array(
                                             'model'=>$modInfoKunjunganRDV,
                                             'attribute'=>'tgl_akhir',
                                             'mode'=>'date',
                                             'options'=> array(
                                                'maxdate'=>'d',
                                                'dateFormat'=>Params::DATE_FORMAT,
                                            ),
                                             'htmlOptions'=>array('readonly'=>true,
                                             'class'=>'dtPicker2',
                                             'onkeypress'=>"return $(this).focusNextInputField(event)"),
                                        )); ?>
                            <?php $modInfoKunjunganRDV->tgl_akhir=$format->formatDateTimeForDb($modInfoKunjunganRDV->tgl_akhir); ?>
                        </div>
                    </div>
                     <?php echo $form->textFieldRow($modInfoKunjunganRDV,'no_rekam_medik',array('placeholder'=>'Ketik No. Rekam Medik','class'=>'span3 numbers-only','onkeypress'=>"return $(this).focusNextInputField(event)", 'maxlength'=>6)); ?>
                     <?php echo $form->textFieldRow($modInfoKunjunganRDV,'nama_pasien',array('placeholder'=>'Ketik Nama Pasien','class'=>'span3 hurufs-only', 'onkeypress'=>"return $(this).focusNextInputField(event)", 'maxlength'=>50)); ?>
                    <?php echo $form->textAreaRow($modInfoKunjunganRDV,'alamat_pasien',array('placeholder'=>'Ketik Alamat Pasien','class'=>'span3 custom-only', 'onkeypress'=>"return $(this).focusNextInputField(event)", 'maxlength'=>50)); ?>
                </td>
                <td>
                    
                    <?php echo $form->dropDownListRow($modInfoKunjunganRDV,'status_konfirmasi',CustomFunction::getStatusKonfirmasi(),array('empty'=>'-- Pilih --','onkeypress'=>"return $(this).focusNextInputField(event)",)); ?>
                     <?php echo $form->dropDownListRow($modInfoKunjunganRDV,'carabayar_id', CHtml::listData($modInfoKunjunganRDV->getCaraBayarItems(), 'carabayar_id', 'carabayar_nama') ,array('empty'=>'-- Pilih --','onkeypress'=>"return $(this).focusNextInputField(event)",
                            'ajax' => array('type'=>'POST',
                                'url'=> $this->createUrl('GetPenjaminPasien',array('encode'=>false,'namaModel'=>'PPInfoKunjunganRDV')), 
                                'update'=>'#PPInfoKunjunganRDV_penjamin_id'  //selector to update
                            ),
                    )); ?>                                
                    <div class="control-group">
                        <?php echo CHtml::label('Penjamin',' Penjamin', array('class'=>'control-label')) ?>
                        <div class="controls">
                            <?php echo $form->dropDownList($modInfoKunjunganRDV,'penjamin_id', CHtml::listData($modInfoKunjunganRDV->getPenjaminItems(), 'penjamin_id', 'penjamin_nama') ,array('empty'=>'-- Pilih --','onkeypress'=>"return $(this).focusNextInputField(event)",)); ?>
                        </div>
                    </div>
                    
                        <?php echo $form->dropDownListRow($modInfoKunjunganRDV,'asalrujukan_id', CHtml::listData(
                        AsalrujukanM::model()->findAll(array(
                            'condition'=>'asalrujukan_aktif = true',
                            'order'=>'asalrujukan_nama'
                        )), 'asalrujukan_id', 'asalrujukan_nama'), array(
                            'empty'=>'-- Pilih --',
                            'ajax'=>array('type'=>'POST',
                                'url'=>Yii::app()->createUrl('pendaftaranPenjadwalan/pendaftaranRawatJalan/GetRujukanDari',array('encode'=>false,'namaModel'=>get_class($modInfoKunjunganRDV))),
                                'update'=>'#'.CHtml::activeId($modInfoKunjunganRDV, 'rujukandari_id'),
                            )
                        )); ?>
                        <?php echo $form->dropDownListRow($modInfoKunjunganRDV,'rujukandari_id', array(), array('empty'=>'-- Pilih --')); ?>
                    
                </td>
                <td>
                      
                    <?php echo $form->dropDownListRow($modInfoKunjunganRDV, 'pegawai_id', 
                        CHtml::listData(DokterV::model()->findAllByAttributes(array(
                            'instalasi_id'=>Params::INSTALASI_ID_RD,
                        ), array(
                            'order'=>'nama_pegawai asc'
                        )), 'pegawai_id', 'namaLengkap'), array('empty'=>'-- Pilih --')); ?>
                     <?php echo $form->dropDownListRow($modInfoKunjunganRDV, 'statusperiksa', 
                        Params::statusPeriksa(), array('empty'=>'-- Pilih --')); ?>
                  
                    <?php echo $form->dropDownListRow($model,'create_loginpemakai_id',  CHtml::listData($model->getPegawaiRuanganItems(),'loginpemakai_id','pegawai.nama_pegawai'),array('empty'=>'-- Pilih --','class'=>'span3','onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
                        <?php /* echo $form->dropDownListRow($modInfoKunjunganRDV,'propinsi_id', CHtml::listData($modInfoKunjunganRDV->getPropinsiItems(), 'propinsi_id', 'propinsi_nama'), 
                                         array('empty'=>'-- Pilih --',
                                               'ajax'=>array('type'=>'POST',
                                                             'url'=>$this->createUrl('SetDropdownKabupaten',array('encode'=>false,'model_nama'=>get_class($model))),
                                                             'update'=>'#PPInfoKunjunganRDV_kabupaten_id'),
                                             'onkeypress'=>"return $(this).focusNextInputField(event)"
                                             )); ?>
                    <?php echo $form->dropDownListRow($modInfoKunjunganRDV,'kabupaten_id',array(),
                                         array('empty'=>'-- Pilih --',
                                               'ajax'=>array('type'=>'POST',
                                                             'url'=>$this->createUrl('SetDropdownKecamatan',array('encode'=>false,'model_nama'=>get_class($model))),
                                                             'update'=>'#PPInfoKunjunganRDV_kecamatan_id'),
                                                             'onkeypress'=>"return $(this).focusNextInputField(event)"
                                           )); ?>
                    <?php echo $form->dropDownListRow($modInfoKunjunganRDV,'kecamatan_id',array(),
                                          array('empty'=>'-- Pilih --',
                                                'ajax'=>array('type'=>'POST',
                                                              'url'=>$this->createUrl('SetDropdownKelurahan',array('encode'=>false,'model_nama'=>get_class($model))),
                                                              'update'=>'#PPInfoKunjunganRDV_kelurahan_id'),
                                                              'onkeypress'=>"return $(this).focusNextInputField(event)"
                                              )); ?>
                    <?php echo $form->dropDownListRow($modInfoKunjunganRDV,'kelurahan_id',array(),array('empty'=>'-- Pilih --','onkeypress'=>"return $(this).focusNextInputField(event)")); 
                     */ ?>
                </td>
            </tr>
        </table>
        <div class="form-actions">
            <?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="icon-search icon-white"></i>')), array('class' => 'btn btn-primary', 'type' => 'submit')); ?>
            <?php echo CHtml::link(Yii::t('mds','{icon} Reset',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
                                        $this->createUrl($this->id.'/index'), 
                                        array('class'=>'btn btn-danger',
                                            'onclick'=>'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r) {if(r) window.location = "'.$this->createUrl('index').'";} ); return false;'));  ?>

            <?php 
            $content = $this->renderPartial('pendaftaranPenjadwalan.views.tips.informasiPasienRD',array(),true);
            $this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); ?>	

        </div>
    </fieldset>
    </div>
    <?php $this->endWidget(); ?>
    <?php 
    $this->beginWidget('zii.widgets.jui.CJuiDialog', array( 
        'id'=>'dialogFisikAnamnesa',
        'options'=>array(
            'title'=>'PemeriksaanFisik&Anamnesa',
            'autoOpen'=>false,
            'modal'=>true,
            'zIndex'=>1002,
            'minWidth'=>1024,
            'minHeight'=>610,
            'resizable'=>true,
        ),
    ));
    ?>
    <iframe src="" id="iframePemeriksaanFisik" name="iframePemeriksaanFisik" width="100%" height="550" >
    </iframe>
    <?php $this->endWidget(); ?>
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
    <iframe id="iframeVerifikasiDiagnosa" name="iframeVerifikasiDiagnosa" width="100%" height="550" >
    </iframe>
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

    // ===========================Dialog Batal Periksa=========================================
    $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
                        'id'=>'DialogBatalperiksa',
                            // additional javascript options for the dialog plugin
                            'options'=>array(
                            'title'=>'Batal Periksa - <span id="titleNamaPasienBatal"></span>',
                            'autoOpen'=>false,
                            //'show'=>'blind',
                            //'hide'=>'explode',
                            'zIndex'=>1002,
                            'minWidth'=>500,
                            'minHeight'=>100,
                            'resizable'=>false,
                            'modal'=>true,    
                             ),
                        ));
    $this->renderPartial($this->path_view.'_formBatalPeriksaDialog');                    

    $this->endWidget('zii.widgets.jui.CJuiDialog');
    //===============================Akhir Dialog Batal Periksa================================
    //
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
	<div id="form-ubahruangan">
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
            <td>Jenis Kasus Penyakit</td>
            <td>:</td>
            <td>
                <?php echo CHtml::dropDownList('jeniskasuspenyakit_sebelumnya','', array(),array('disabled'=>true));?>
                <?php echo CHtml::hiddenField('jeniskasuspenyakit_awal','',array('readonly'=>true));?>
            </td>
        </tr>
        <tr>
            <td>Dokter</td>
            <td>:</td>
            <td>
                <?php echo CHtml::dropDownList('pegawai_sebelumnya','', array(),array('disabled'=>true));?>
                <?php echo CHtml::hiddenField('pegawai_awal','',array('readonly'=>true));?>
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
            <td><?php echo CHtml::dropDownList('ruangan_id_ganti','ruangan_id_ganti', array(),
                    array('empty'=>'--pilih--','onChange'=>'getKasusPenyakit();listKarcis(this.value)'));?></td>
        </tr>
        <tr>
            <td>Menjadi Jenis Kasus Penyakit</td>
            <td>:</td>
            <td><?php echo CHtml::dropDownList('jeniskasuspenyakit_id_ganti','jeniskasuspenyakit_id_ganti', array(),
                    array('empty'=>'--pilih--' ));?></td>
        </tr>
         <tr>
            <td>Menjadi Dokter</td>
            <td>:</td>
            <td><?php echo CHtml::dropDownList('pegawai_id_ganti','pegawai_id_ganti', array(),
                    array('empty'=>'--pilih--' ));?></td>
        </tr>
        <tr>
            <td  colspan="3">  
                <fieldset id="fieldsetKarcis" class="">
                    <?php echo CHtml::checkBox('is_ubahkarcis', $model->adaKarcis, 
                            array('onkeypress'=>"return $(this).focusNextInputField(event)",'onclick'=>'setValue();')) ?>
                    Ubah Karcis
                <?php echo $this->renderPartial($this->path_view.'_formKarcis', 
                                    array('model'=>$model)); ?>
                </fieldset>
            </td>
        </tr>
    </table>
    <?php

    echo CHtml::hiddenField('pendaftaran_id');
    echo CHtml::hiddenField('pasien_id');
    echo CHtml::hiddenField('instalasi_id');
    echo CHtml::hiddenField('pegawai_id');
    echo CHtml::hiddenField('kelaspelayanan_id');
    echo CHtml::htmlButton(Yii::t('mds','{icon} Ya',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),
                                                    array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'simpanUbahRuangan();'));
    echo '&nbsp;&nbsp;&nbsp;'.CHtml::htmlButton(Yii::t('mds','{icon} Batal',array('{icon}'=>'<i class="icon-ban-circle icon-white"></i>')),
                                                    array('class'=>'btn btn-danger', 'type'=>'button','onclick'=>'$(\'#ganti_poli\').dialog(\'close\');'));

	?>
	</div>
    <?php $this->endWidget('zii.widgets.jui.CJuiDialog');
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
        'close'=>'js:function() {$.fn.yiiGridView.update("PPInfoKunjungan-v")}'
        //'hide'=>explode,
    ),
));
echo '<iframe id="iframeUbahCaraBayar"  name="iframeUbahCaraBayar" width="100%" height="550" >
</iframe>';

$this->endWidget('zii.widgets.jui.CJuiDialog');
//========================================================= end cara bayar dialog =========


//======================================================JAVA SCRIPT===================================================                          
$controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
$module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
$url=  Yii::app()->createAbsoluteUrl($module.'/'.$controller);
//$urlPrintLembarPoli = Yii::app()->createUrl('pendaftaranPenjadwalan/Pendaftaran/lembarPoliRD',array('pendaftaran_id'=>''));
$urlPrintLembarPoli = Yii::app()->createUrl('pendaftaranPenjadwalan/pendaftaranRawatDarurat/printStatusRD',array('pendaftaran_id'=>''));
$urlPrintKartuPasien = Yii::app()->createUrl($module.'/Pendaftaran/kartuPasien',array('pendaftaran_id'=>''));
$urlListDokterRuangan = $this->createUrl('listDokterRuangan');
$urlGetRuangan=$this->createUrl('GetRuanganPasienRD'); 
$urlListKarcis =Yii::app()->createUrl($module.'/InfoKunjunganRD/listKarcis');
$statusPeriksaBatalPeriksa=Params::STATUSPERIKSA_BATAL_PERIKSA;
$karcis = Yii::app()->user->getState('karcisbarulama');
$karcis = ($karcis) ? true : 0;
$js = <<< JSCRIPT
//====================================Awal Ubah Cara Bayar============================================================
//function ubahCaraBayar(pendaftaran_id,carabayar_id,penjamin_id)
//   {
//        $('#ubahCaraBayar_id').val(carabayar_id);
//        $('#ubahPenjamin_id').val(penjamin_id);
//        $('#ubahPendaftaranId').val(pendaftaran_id);
//        $.post("${url}/ajaxGetPenjamin", {carabayar_id: carabayar_id, penjamin_id : penjamin_id},
//                function(data){
//                   $('#ubahPenjamin_id').html(data.penjamin);
//                },"json");
//        
//        $('#carabayardialog').dialog('open');   
//   }

function simpanCaraBayar()
   {
        carabayar_id=$('#ubahCaraBayar_id').val();
        penjamin_id=$('#ubahPenjamin_id').val();
        pendaftaran_id=$('#ubahPendaftaranId').val();
        myAlert(pendaftaran_id);
        $.post("${url}/ajaxUpdateCaraBayarAntrian", { pendaftaran_id: pendaftaran_id, carabayar_id: carabayar_id, penjamin_id:penjamin_id  },
                function(data){
                     myAlert(data.message);
                     $('#carabayardialog').dialog('close');   
                     window.location.reload();
                },"json");
        
    } 
    
 function dynamicPenjamin(obj) 
    {
       $.post("${url}/ajaxGetPenjamin", {carabayar_id: obj.value},
                function(data){
                   $('#ubahPenjamin_id').html(data.penjamin);
                },"json");
        
  
   }
   
//=====================================Akhir Ubah Cara Bayar============================================================    

//=======================================Awal Print Lembar Poli==========================================================

function print(pendaftaran_id)
{
   window.open('${urlPrintLembarPoli}'+pendaftaran_id,'printwin','left=100,top=100,width=400,height=400');    
}
//========================================Akhir Print Lembar Poli========================================================

//========================================Awal Ganti Ruangan==================================================================

function gantiPoli(pendaftaran_id,ruangan_id,instalasi_id,pasien_id,namaPasien,jeniskasuspenyakit_id,pegawai_id,kelaspelayanan_id)
    {
        $('#titleNamaPasien').html(namaPasien);
           $.post("${urlGetRuangan}", { pendaftaran_id: pendaftaran_id, 
                ruangan_id: ruangan_id,instalasi_id:instalasi_id,jeniskasuspenyakit_id:jeniskasuspenyakit_id,pegawai_id:pegawai_id,kelaspelayanan_id:kelaspelayanan_id},
           function(data){
            $('#ganti_poli').dialog('open');
            $('#ganti_poli #ruangan_awal').val(ruangan_id);
            $('#ganti_poli #jeniskasuspenyakit_awal').val(jeniskasuspenyakit_id);
            $('#ganti_poli #pegawai_awal').val(pegawai_id);
            $('#ganti_poli #ruangan_sebelumnya').html(data.dropDown);
            $('#ganti_poli #ruangan_id_ganti').html(data.dropDown);
            $('#ganti_poli #jeniskasuspenyakit_sebelumnya').html(data.jenisKasusPenyakit);
            $('#ganti_poli #jeniskasuspenyakit_id_ganti').html(data.jenisKasusPenyakit);
            $('#ganti_poli #pegawai_sebelumnya').html(data.dokter);
            $('#ganti_poli #pegawai_id_ganti').html(data.dokter);
            $('#ganti_poli #pendaftaran_id').val(pendaftaran_id);
            $('#ganti_poli #pasien_id').val(pasien_id);
            $('#ganti_poli #instalasi_id').val(instalasi_id);
            $('#ganti_poli #kelaspelayanan_id').val(kelaspelayanan_id);
        }, "json");
    }
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

<script type="text/javascript">
// here is the magic
function disableLink()
{
    var status = null;
    $("#PPInfoKunjungan-v tbody").find('tr > td[class="gawat"]').each(
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


function ubahCaraBayar(namaPasien)
{   
    $('#titleNamaPasienCaraBayar').html(namaPasien);
    jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('pendaftaranPenjadwalan/infoKunjunganRJ/ubahCaraBayar')?>',
                 'data':$(this).serialize(),
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

function ubahKelompokPenyakit(pendaftaran_id)
{
    $('#temp_idPendaftaran').val(pendaftaran_id);
    jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('pendaftaranPenjadwalan/infoKunjunganRD/ubahKelompokPenyakit', array('menu'=>'RD'))?>',
        'data':$(this).serialize(),
        'type':'post',
        'dataType':'json',
        'success':function(data){
            if (data.status == 'create_form') {
                $('#editKelPenyakit div.divForFormEditKelPenyakit').html(data.div);
                $('#editKelPenyakit div.divForFormEditKelPenyakit form').submit(ubahKelompokPenyakit);
            }else{
                $('#editKelPenyakit div.divForFormEditKelPenyakit').html(data.div);
                $.fn.yiiGridView.update('PPInfoKunjungan-v', {
                        data: $(this).serialize()
                });
                setTimeout("$('#editKelPenyakit').dialog('close') ",500);
            }
        },
        'cache':false
    });
    return false; 
}

function ubahDokterPeriksa(pendaftaran_id)
{
    $('#temp_idPendaftaranDP').val(pendaftaran_id);
    jQuery.ajax({'url':'<?php echo $this->createUrl('ubahDokterPeriksa', array('menu'=>'RD'))?>',
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

function ubahKelasPelayanan(pendaftaran_id)
{
    $('#temp_idPendaftaranKP').val(pendaftaran_id);
    jQuery.ajax({'url':'<?php echo $this->createUrl('ubahKelasPelayanan', array('menu'=>'RD'))?>',
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
    //=============================== Ganti Data Jenis Kelamin Dialog =======================================
    $this->beginWidget('zii.widgets.jui.CJuiDialog',
        array(
            'id'=>'editKelPenyakit',
            'options'=>array(
                'title'=>'Ganti Data Kelompok Penyakit',
                'autoOpen'=>false,
                'zIndex'=>1002,
                'minWidth'=>600,
                'modal'=>true,
            ),
        )
    );
    echo CHtml::hiddenField('temp_idPendaftaran','',array('readonly'=>true));
    echo '<div class="divForFormEditKelPenyakit"></div>';
    $this->endWidget('zii.widgets.jui.CJuiDialog');
?>


<?php
    //=============================== Ganti Data Jenis Kelamin Dialog =======================================
    $this->beginWidget('zii.widgets.jui.CJuiDialog',
        array(
            'id'=>'editDokterPeriksa',
            'options'=>array(
                'title'=>'Ganti Dokter Periksa',
                'autoOpen'=>false,
                'zIndex'=>1002,
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
<!-- SESSION UBAH STATUS -->
<?php
$urlSessionUbahStatus = $this->createUrl('buatSessionUbahStatus');
$jscript = <<< JS
function buatSessionUbahStatus(pendaftaran_id)
{
//        myConfirm("Yakin Akan Merubah Status Periksa Pasien?","Perhatian!",function(r) {
        // if (r){
            $.post("${urlSessionUbahStatus}", {pendaftaran_id: pendaftaran_id },
                function(data){
                    'sukses';
            }, "json");
            ubahStatusPeriksa();
        // }
//    });
}
JS;
Yii::app()->clientScript->registerScript('jsPendaftaran',$jscript, CClientScript::POS_BEGIN);
?>

<script>
        function ubahStatusPeriksa()
{
    <?php 
            echo CHtml::ajax(array(
            'url'=>Yii::app()->createUrl('pendaftaranPenjadwalan/infoKunjunganRD/ubahStatusPeriksaRD'),
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
                    $.fn.yiiGridView.update('PPInfoKunjungan-v');
                    setTimeout(\"$('#dialogUbahStatus').dialog('close') \",1000);
                }
 
            } ",
    ))
?>;
    return false; 
}
    
</script>
<!-- SESSION UBAH STATUS --!>
<!-- UNTUK PERUBAHAN JENIS KASUS PENYAKIT DI UBAH POLI -->
<?php
$js = <<< JSCRIPT

function getKasusPenyakit(){
    ruangan_id = $('#ruangan_id_ganti').val();
    pendaftaran_id = $('#pendaftaran_id').val();
    pasien_id = $('#pasien_id').val();
    instalasi_id = $('#instalasi_id').val();
    pegawai_id = $('#pegawai_id').val();
    jeniskasuspenyakit_id = '';  
        
   $.post("${urlGetRuangan}", { pendaftaran_id: pendaftaran_id, ruangan_id: ruangan_id, instalasi_id:instalasi_id, pasien_id:pasien_id,
   jeniskasuspenyakit_id:jeniskasuspenyakit_id,pegawai_id:pegawai_id},
   function(data){
            $('#ganti_poli').dialog('open');            
            $('#ganti_poli #ruangan_id_ganti').html(data.dropDown);
            $('#ganti_poli #jeniskasuspenyakit_id_ganti').html(data.jenisKasusPenyakit);
            $('#ganti_poli #pegawai_id_ganti').html(data.dokter);
    }, "json");
    
}
   
function listKarcis(obj)
{
     kelasPelayanan=$('#ganti_poli #kelaspelayanan_id').val();
     ruangan=$('#ganti_poli #ruangan_id_ganti').val();
     pendaftaran_id=$('#ganti_poli #pendaftaran_id').val();
     if(kelasPelayanan!='' && ruangan!=''){
            $('#tblFormKarcis tbody').remove();
             $.post("${urlListKarcis}", { kelasPelayanan: kelasPelayanan, ruangan:ruangan, pendaftaran_id:pendaftaran_id},
                function(data){
                    $('#tblFormKarcis').append(data.form);
                    if (${karcis}){
                        if (jQuery.isNumeric(data.karcis.karcis_id)){
                            tdKarcis = $('#tblFormKarcis tbody tr').find("td a[data-karcis='"+data.karcis.karcis_id+"']");
                            changeBackground(tdKarcis, data.karcis.daftartindakan_id, data.karcis.harga_tariftindakan, data.karcis.karcis_id);
                        }else{
                            $('#TindakanpelayananT_idTindakan').val('');  
                            $('#TindakanpelayananT_tarifSatuan').val('');   
                            $('#TindakanpelayananT_idKarcis').val('');  
                        }
                    }
             }, "json");
     }      

}
function changeBackground(obj,idTindakan,tarifSatuan,idKarcis)
{
        banyakRow=$('#tblFormKarcis tr').length;
        for(i=1; i<=banyakRow; i++){
        $('#tblFormKarcis tr').css("background-color", "#FFFFFF");          
        } 
             
        $(obj).parent().parent().css("backgroundColor", "#00FF00");     
        $('#TindakanpelayananT_idTindakan').val(idTindakan);  
        $('#TindakanpelayananT_tarifSatuan').val(tarifSatuan);     
        $('#TindakanpelayananT_idKarcis').val(idKarcis);     
     
}   

function setValue(){
$('#karcisTindakan').change(function(){
    if ($(this).is(':checked')){
            $(this).val(1);
    }else{
            $(this).val(0);
    }
});
}
JSCRIPT;
Yii::app()->clientScript->registerScript('getKasusPenyakit',$js,CClientScript::POS_HEAD);
?>
<!-- UNTUK PERUBAHAN JENIS KASUS PENYAKIT DI UBAH POLI -->
<?php echo $this->renderPartial($this->path_view.'_jsFunctions', array()); ?>
</div>