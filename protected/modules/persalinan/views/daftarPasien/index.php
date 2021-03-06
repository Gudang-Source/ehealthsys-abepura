<div class='white-container'>
    <legend class="rim2">Informasi <b>Daftar Pasien</b></legend>                         
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

    <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
    <div class='block-tabel'>
        <h6>Tabel <b>Daftar Pasien</b></h6>
        <?php
            if(Yii::app()->user->getState('instalasi_id')==Params::INSTALASI_ID_RJ){//Jika Bukan Rawat Jalan

                    $this->widget('ext.bootstrap.widgets.BootGridView', array(
            'id'=>'daftarPasien-grid',
            'dataProvider'=>$model->searchPasien(),
                    'template'=>"{summary}\n{items}\n{pager}",
                    'itemsCssClass'=>'table table-striped table-condensed',
            'columns'=>array(
                                    array(
                                            'header'=>'Tgl. Pendaftaran/<br/>No. Pendaftaran',
                                            'name'=>'tgl_pendaftaran',
                                            'type'=>'raw',
                                            'value'=>'MyFormatter::formatDateTimeForUser($data->tgl_pendaftaran)."/<br/>".$data->no_pendaftaran',
                                    ),
                                    array(
                                            'header'=>'No.Rekam Medik',
                                            'type'=>'raw',
                                            'value'=>'$data->no_rekam_medik ',
                                    ),
                                    array(
                                            'header'=>'Nama Pasien / Alias',
                                            'value'=>'$data->namadepan.$data->nama_pasien'
                                    ),
                                    array(
                                            'header'=>'Cara Bayar / Penjamin',
                                            'type'=>'raw',
                                            //'value'=>'$data->caraBayarPenjamin2',
                                            'value'=>function($data) {
                                        return $data->carabayar_nama."/<br/>".$data->penjamin_nama;
                                    },
                                    ),
                                    array(
                                            'header'=>'Ruangan',
                                            'type'=>'raw',
                                            'value'=>'$data->ruangan_nama',
                                    ),
                                    array(
                                       'name'=>'Cara Masuk / Transportasi',
                                            'type'=>'raw',
                                            'value'=>'$data->caraMasukTransportasi',
                                    ),

                                    array(
                                       'name'=>'Dokter',
                                            'type'=>'raw',
                                            'value'=>'$data->nama_pegawai',
                                    ),
                                    array(
                                       'name'=>'Rujukan',
                                            'type'=>'raw',
                                            'value'=>'(!empty($data->asalrujukan_nama))? $data->asalrujukan_nama : "-"',
                                    ),
                                    array(
                                       'header'=>'Kasus Penyakit / <br/> Kelas Pelayanan',
                                            'type'=>'raw',
                                            'value'=>'"$data->jeniskasuspenyakit_nama"."<br/>"."$data->kelaspelayanan_nama"',
                                    ),
                                    array(
                                       'name'=>'alamat_pasien',
                                            'type'=>'raw',
                                            'value'=>'$data->alamat_pasien',
                                    ),
                                    array(
                                       'name'=>'statusperiksa',
                                            'type'=>'raw',
                                            'value'=>'$data->statusperiksa',
                                    ),
                                    array(
                                            'header'=>'Periksa Kehamilan',
                                            'class'=>'bootstrap.widgets.BootButtonColumn',
                                            'template'=>'{lihat}',
                                            'buttons'=>array(
                                                                            'lihat' => array (
                                                                                            'label'=>"<i class='icon-form-ubah'></i>",
                                                                                            'options'=>array('title'=>'Persalinan'),
                                                                                            'url'=>'Yii::app()->createUrl("persalinan/periksaKehamilan/index",array("pendaftaran_id"=>"$data->pendaftaran_id"))',                            
                                                                                    ),
                                                    ),  'htmlOptions'=>array('style'=>'text-align: center; width:40px'),
                                    ),
                                    array(
                                            'header'=>'Imunisasi',
                                            'class'=>'bootstrap.widgets.BootButtonColumn',
                                            'template'=>'{lihat}',
                                            'buttons'=>array(
                                                                            'lihat' => array (
                                                                                            'label'=>"<i class='icon-pencil-yellow'></i>",
                                                                                            'options'=>array('title'=>'Kelahiran', 'class'=>'kelahiran'),
                                                                                            'url'=>'Yii::app()->createUrl("persalinan/Imunisasi/index",array("pendaftaran_id"=>"$data->pendaftaran_id"))',                            
                                                                                    ),
                                                    ),  'htmlOptions'=>array('style'=>'text-align: center; width:40px'),
                                    ),
                                    array(
                                            'header'=>'Keluarga Berencana',
                                            'class'=>'bootstrap.widgets.BootButtonColumn',
                                            'template'=>'{lihat}',
                                            'buttons'=>array(
                                                                            'lihat' => array (
                                                                                            'label'=>"<i class='icon-pencil'></i>",
                                                                                            'options'=>array('title'=>'Kelahiran', 'class'=>'kelahiran'),
                                                                                            'url'=>'Yii::app()->createUrl("persalinan/KeluargaBerencana/index",array("pendaftaran_id"=>"$data->pendaftaran_id"))',                            
                                                                                    ),
                                                    ),  'htmlOptions'=>array('style'=>'text-align: center; width:40px'),
                                    ),
                                    array(
                                            'header'=>'Kegiatan Bayi Tabung',
                                            'class'=>'bootstrap.widgets.BootButtonColumn',
                                            'template'=>'{lihat}',
                                            'buttons'=>array(
                                                                            'lihat' => array (
                                                                                            'label'=>"<i class='icon-pencil'></i>",
                                                                                            'options'=>array('title'=>'Kelahiran', 'class'=>'kelahiran'),
                                                                                            'url'=>'Yii::app()->createUrl("persalinan/kegiatanBayiTabung/index",array("pendaftaran_id"=>"$data->pendaftaran_id"))',                            
                                                                                    ),
                                                    ),
                                              'htmlOptions'=>array('style'=>'text-align: center; width:40px'),
                                    ),
                                    array(
                                            'name'=>'Pemeriksaan Pasien',
                                            'type'=>'raw',
                                            'value'=>'CHtml::link("<i class=\'icon-list-alt\'></i> ", Yii::app()->controller->createUrl("/persalinan/anamnesa",array("pendaftaran_id"=>$data->pendaftaran_id)),array("id"=>"$data->no_pendaftaran","rel"=>"tooltip","title"=>"Klik untuk Pemeriksaan Pasien"))',
                                            'htmlOptions'=>array('style'=>'text-align: center; width:40px'),
                                    ),
                                    array(
                                            'header'=>'Tindak Lanjut RI',
                                                                     'type'=>'raw',
                                            'value'=>'(!empty($data->pasienpulang_id) ? "Pasien Rawat Inap" : CHtml::link("<i class=\'icon-user\'></i> ".$data->pasienpulang_id, "javascript:tindakLanjutRI(\'$data->pendaftaran_id\');",array("title"=>"Klik Untuk Mendaftarkan ke Rawat Inap"))) ',
                                             'htmlOptions'=>array('style'=>'text-align: center; width:40px'),
                                    ),
                                    array(
                                            'header'=>'Rincian Tagihan',
                                            'type'=>'raw',
                                            'value'=>'CHtml::link("<icon class=\'icon-list-brown\'></idcon>", Yii::app()->createUrl("'.$modul.'/'.$controller.'/rincian", array("id"=>$data->pendaftaran_id)), array("target"=>"frameRincian", "onclick"=>"$(\'#dialogRincian\').dialog(\'open\');"))','htmlOptions'=>array('style'=>'text-align: center; width:40px')
									),
									array(
											'header'=>'Batal Periksa',
											'type'=>'raw',
											'value'=>function($data) {
												$rd = InfokunjunganrdV::model()->findByAttributes(array(
													'pendaftaran_id'=>$data->pendaftaran_id
												));

												if (($rd->pasienpulang_id != 0) || ($rd->carakeluar != "")) 
													return "-";
												
												$admisi = PasienadmisiT::model()->findByAttributes(array('pendaftaran_id'=>$data->pendaftaran_id));
												if (empty($admisi)) return CHtml::link('<i class="icon-form-silang"></i>', "javascript:batalperiksa($data->pendaftaran_id)",array("id"=>"$data->no_pendaftaran","rel"=>"tooltip","title"=>"Klik untuk membatalkan pemeriksaan"));
												else return "-";
											},
											'htmlOptions'=>array('style'=>'text-align: center; width:40px'),
									),

                    ),
                    'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
            ));     
            }
            else if (Yii::app()->user->getState('instalasi_id')==Params::INSTALASI_ID_RI) {
                $this->widget('ext.bootstrap.widgets.BootGridView', array(
                    'id'=>'daftarPasien-grid',
                    'dataProvider'=>$model->searchPasien(),
                    'template'=>"{summary}\n{items}\n{pager}",
                    'itemsCssClass'=>'table table-striped table-condensed',
                    'columns'=>array(
                            array(
                                    'header'=>'Tgl. Pendaftaran/<br/>No. Pendaftaran',
                                    'name'=>'tgl_pendaftaran',
                                    'type'=>'raw',
                                    'value'=>'MyFormatter::formatDateTimeForUser($data->tgl_pendaftaran)."/<br/>".$data->no_pendaftaran',
                            ),
                            array(
                                    'header'=>'No.Rekam Medik',
                                    'type'=>'raw',
                                    'value'=>'$data->no_rekam_medik ',
                            ),
                            array(
                                    'header'=>'Nama Pasien',
                                    'value'=>'$data->namadepan.$data->nama_pasien'
                            ),
                            'umur',
                            array(
                                    'header'=>'Alamat Pasien',
                                    'type'=>'raw',
                                    'value'=>'$data->alamat_pasien',
                            ),
                            array(
                                    'header'=>'Jenis Kasus Penyakit',
                                    'type'=>'raw',
                                    'value'=>'$data->jeniskasuspenyakit_nama',
                            ),
                            array(
                                    'header'=>'Rujukan',
                                    'type'=>'raw',
                                    'value'=>'(!empty($data->asalrujukan_nama))? $data->asalrujukan_nama : "-"',
                            ),
                            array(
                                    'header'=>'Cara Bayar / Penjamin',
                                    'type'=>'raw',
                                    'value'=>function($data) {
                                        return $data->carabayar_nama."/<br/>".$data->penjamin_nama;
                                    }, //'$data->caraBayarPenjamin2',
                            ), 
                             array(
                                            'header'=>'Ruangan',
                                            'type'=>'raw',
                                            'value'=>'$data->ruangan_nama',
                                    ),
                            array(
                                    'header'=>'Kelas Pelayanan',
                                    'name'=>'kelaspelayanan_nama',
                            ),
                            array(
                                    'header'=>'Kamar Ruangan/<br/>No. Bed',
                                    'type'=>'raw',
                                    'value'=>function($data) {
                                        $ad = PasienadmisiT::model()->findByAttributes(array(
                                            'pendaftaran_id'=>$data->pendaftaran_id,
                                        ));
                                        if (!empty($ad)) {
                                            $kamar = KamarruanganM::model()->findByPk($ad->kamarruangan_id);
                                            if (!empty($kamar)) {
                                                return $kamar->kamarruangan_nokamar."/<br/>Bed ".$kamar->kamarruangan_nobed;
                                            } return "-";
                                        } return "-";
                                    }
                            ),
                                            /*
                            array(
                                    'header'=>'Cara Masuk / Transportasi',
                                    'type'=>'raw',
                                    'value'=>'$data->caraMasukTransportasi',
                            ), */

                            array(
                                    'header'=>'Dokter',
                                    'type'=>'raw',
                                    'value'=>'$data->gelardepan." ".$data->nama_pegawai.", ".$data->gelarbelakang_nama',
                                   // 'value'=>'"<div style=\'width:100px;\'>" . CHtml::link("<i class=icon-pencil-brown></i> ". $data->gelardepan." ".$data->nama_pegawai." ".$data->gelarbelakang_nama," ",array("onclick"=>"ubahDokterPeriksa(\'$data->pendaftaran_id\',\'$data->pasienadmisi_id\');$(\'#editDokterPeriksa\').dialog(\'open\');return false;", "rel"=>"tooltip","rel"=>"tooltip","title"=>"Klik Untuk Mengubah Data Dokter Periksa")) . "</div>"',
                            ),
                            array(
                                    'header'=>'Status Periksa',
                                    'type'=>'raw',
                                    'value'=>'$data->statusperiksa',
                            ),
                            array(
                                    'header'=>'Persalinan',
                                    'class'=>'bootstrap.widgets.BootButtonColumn',
                                    'template'=>'{lihat}',
                                    'buttons'=>array(
                                            'lihat' => array (
                                                            'label'=>"<i class='icon-form-persalinan'></i>",
                                                            'options'=>array('title'=>'Persalinan'),
                                                            'url'=>'Yii::app()->createUrl("persalinan/persalinanT/index",array("id"=>"$data->pendaftaran_id"))',                            
                                                    ),
                                            ),
                            ),
                            array(
                                    'header'=>'Kelahiran',
                                    'class'=>'bootstrap.widgets.BootButtonColumn',
                                    'template'=>'{lihat}',
                                    'buttons'=>array(
                                                                    'lihat' => array (
                                                                                    'label'=>"<i class='icon-form-kelahiran'></i>",
                                                                                    'options'=>array('title'=>'Kelahiran', 'class'=>'kelahiran'),
                                                                                    'url'=>'Yii::app()->createUrl("persalinan/kelahiranbayiT/index",array("id"=>"$data->pendaftaran_id"))',                            
                                                                            ),
                                            ),
                            ),
                            array(
                                    'name'=>'Pemeriksaan Pasien',
                                    'type'=>'raw',
                                    'value'=>'CHtml::link("<i class=\'icon-form-periksa\'></i> ", Yii::app()->controller->createUrl("/persalinan/pemeriksaanPasienPersalinan",array("pendaftaran_id"=>$data->pendaftaran_id)),array("id"=>"$data->no_pendaftaran","rel"=>"tooltip","title"=>"Klik untuk Pemeriksaan Pasien"))',
                                    'htmlOptions'=>array('style'=>'text-align: center; width:40px'),
                            ), /*
                            array(
                                    'header'=>'Pasien Pulang',
                                    'type'=>'raw',
                                     'value'=>'(($data->pasienpulang_id != 0) OR ($data->carakeluar_nama != "")) ? $data->carakeluar_nama : 
                                                             $data->getTindakLanjut($data->statusperiksa,$data->pendaftaran_id,$data->no_pendaftaran,$data->pasienpulang_id,$data->carakeluar_id,$data->alihstatus)',
                                    'htmlOptions'=>array('style'=>'text-align: center; width:40px'),
                            ), /*
                            array(
                                    'name'=>'Tindak Lanjut<br/>ke Rawat Inap',
                                    'type'=>'raw',
                                    'value'=>'(!empty($data->pasienpulang_id)) ?  "Pasien di Rawat Inap".
                                       CHtml::link("<i class=\'icon-form-silang\'></i>", Yii::app()->createUrl("/rawatDarurat/DaftarPasien/BatalRawatInap",array("pendaftaran_id"=>$data->pendaftaran_id)) , array("title"=>"Klik Untuk Batal Proses Tindak Lanjut Pasien","target"=>"iframeBatalRawatInap", "onclick"=>"$(\"#dialogBatalRawatInap\").dialog(\"open\");", "rel"=>"tooltip"))  :  
                                       (($data->statusperiksa==Params::STATUSPERIKSA_BATAL_PERIKSA) ? "" : CHtml::link("<i class=\'icon-user\'></i>", Yii::app()->createUrl("/rawatJalan/DaftarPasien/tindakLanjutRI", array("instalasi_id"=>$data->instalasi_id,"pendaftaran_id"=>$data->pendaftaran_id)),
                                       array("class"=>"",
                                       "target"=>"frameTindakLanjut",
                                       "rel"=>"tooltip",
                                       "title"=>"Klik untuk Proses Tindak Lanjut Pasien",
                                       "onclick"=>"$(\'#dialogTindakLanjut\').dialog(\'open\');")))',
                                    'htmlOptions'=>array('style'=>'text-align: center; width:60px')
                            ), */
							array(
									'header'=>'Batal Periksa',
									'type'=>'raw',
									'value'=>function($data) {
										$rd = InfokunjunganrdV::model()->findByAttributes(array(
											'pendaftaran_id'=>$data->pendaftaran_id
										));

										if (($rd->pasienpulang_id != 0) || ($rd->carakeluar != "")) 
											return "-";

										$admisi = PasienadmisiT::model()->findByAttributes(array('pendaftaran_id'=>$data->pendaftaran_id));
										if (empty($admisi)) return CHtml::link('<i class="icon-form-silang"></i>', "javascript:batalperiksa($data->pendaftaran_id)",array("id"=>"$data->no_pendaftaran","rel"=>"tooltip","title"=>"Klik untuk membatalkan pemeriksaan"));
										else return "-";
									},
									'htmlOptions'=>array('style'=>'text-align: center; width:40px'),
							),

                    ),
                    'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
                ));
            } else{        
                    $this->widget('ext.bootstrap.widgets.BootGridView', array(
            'id'=>'daftarPasien-grid',
            'dataProvider'=>$model->searchPasien(),
                    'template'=>"{summary}\n{items}\n{pager}",
                    'itemsCssClass'=>'table table-striped table-condensed',
            'columns'=>array(
                            array(
                                    'header'=>'Tanggal Pendaftaran',
                                    'name'=>'tgl_pendaftaran',
                                    'type'=>'raw',
                                    'value'=>'MyFormatter::formatDateTimeForUser($data->tgl_pendaftaran)'
                            ),
                            array(
                                    'header'=>'No. Pendaftaran / No. Rekam Medik',
                                    'type'=>'raw',
                                    'value'=>'$data->noPendaftaranRekammedik',
                            ),
                            array(
                                    'header'=>'Nama Pasien / Panggilan',
                                    'value'=>'$data->namaNamaBin'
                            ),
                            array(
                                            'header'=>'Cara Bayar / Penjamin',
                                            'type'=>'raw',
                                            //'value'=>'$data->caraBayarPenjamin2',
                                            'value'=>function($data) {
                                        return $data->carabayar_nama."/<br/>".$data->penjamin_nama;
                                    },
                                    ),
                                    array(
                                            'header'=>'Ruangan',
                                            'type'=>'raw',
                                            'value'=>'$data->ruangan_nama',
                                    ),
                            array(
                                    'header'=>'Cara Masuk / Transportasi',
                                    'type'=>'raw',
                                    'value'=>'$data->caraMasukTransportasi',
                            ),

                            array(
                                    'header'=>'Dokter',
                                    'type'=>'raw',
                                    'value'=>'$data->gelardepan." ".$data->nama_pegawai." ".$data->gelarbelakang_nama',
                                  // 'value'=>'"<div style=\'width:100px;\'>" . CHtml::link("<i class=icon-pencil-brown></i> ". $data->gelardepan." ".$data->nama_pegawai." ".$data->gelarbelakang_nama," ",array("onclick"=>"ubahDokterPeriksa(\'$data->pendaftaran_id\',\'$data->pasienadmisi_id\');$(\'#editDokterPeriksa\').dialog(\'open\');return false;", "rel"=>"tooltip","rel"=>"tooltip","title"=>"Klik Untuk Mengubah Data Dokter Periksa")) . "</div>"',
                            ),
                            array(
                                    'header'=>'Rujukan',
                                    'type'=>'raw',
                                    'value'=>'(!empty($data->asalrujukan_nama))? $data->asalrujukan_nama : "-"',
                            ),
                            array(
                                    'header'=>'Nama Jenis Kasus Penyakit',
                                    'type'=>'raw',
                                    'value'=>'$data->jeniskasuspenyakit_nama',
                            ),
                            array(
                                    'header'=>'Alamat Pasien',
                                    'type'=>'raw',
                                    'value'=>'$data->alamat_pasien',
                            ),
                            array(
                                    'header'=>'Status Periksa',
                                    'type'=>'raw',
                                    'value'=>'$data->statusperiksa',
                            ),
                            array(
                                    'header'=>'Persalinan',
                                    /*'class'=>'bootstrap.widgets.BootButtonColumn',
                                    'template'=>'{lihat}',
                                    'buttons'=>array(
                                        'lihat' => array (
                                                        'label'=>"<i class='icon-form-persalinan'></i>",
                                                        'options'=>array('title'=>'Persalinan'),
                                                        'url'=>'Yii::app()->createUrl("persalinan/persalinanT/index",array("id"=>"$data->pendaftaran_id"))',                            
                                                ),
                                    ),*/
                                    'type' => 'raw',
                                    'value' => function($data){
                                        return CHtml::link("<i class = 'icon-form-persalinan'></i>",Yii::app()->createUrl("persalinan/persalinanT/index",array("id"=>"$data->pendaftaran_id")),array('onclick'=>'return cekPegawai(); return false;'));
                                    }
                            ),
                            array(
                                    'header'=>'Kelahiran',
                                    'class'=>'bootstrap.widgets.BootButtonColumn',
                                    'template'=>'{lihat}',
                                    'buttons'=>array(
                                                                    'lihat' => array (
                                                                                    'label'=>"<i class='icon-form-kelahiran'></i>",
                                                                                    'options'=>array('title'=>'Kelahiran', 'class'=>'kelahiran'),
                                                                                    'url'=>'Yii::app()->createUrl("persalinan/kelahiranbayiT/index",array("id"=>"$data->pendaftaran_id"))',                            
                                                                            ),
                                            ),
                            ),
                            array(
                                    'name'=>'Pemeriksaan Pasien',
                                    'type'=>'raw',
                                    'value'=>'CHtml::link("<i class=\'icon-form-periksa\'></i> ", Yii::app()->controller->createUrl("/persalinan/pemeriksaanPasienPersalinan",array("pendaftaran_id"=>$data->pendaftaran_id)),array("id"=>"$data->no_pendaftaran","rel"=>"tooltip","title"=>"Klik untuk Pemeriksaan Pasien"))',
                                    'htmlOptions'=>array('style'=>'text-align: center; width:40px'),
                            ),
                    array(
                                    'header'=>'Pasien Pulang',
                                    'type'=>'raw',
                                     'value'=>'(($data->pasienpulang_id != 0) OR ($data->carakeluar_nama != "")) ? $data->carakeluar_nama : 
                                                             $data->getTindakLanjut($data->statusperiksa,$data->pendaftaran_id,$data->no_pendaftaran,$data->pasienpulang_id,$data->carakeluar_id,$data->alihstatus)',
                                    'htmlOptions'=>array('style'=>'text-align: center; width:40px'),
                            ),
                    array(
                                    'name'=>'Tindak Lanjut<br/>ke Rawat Inap',
                                    'type'=>'raw',
                                    'value'=>'(!empty($data->pasienpulang_id)) ?  "Pasien di Rawat Inap".
                                       CHtml::link("<i class=\'icon-form-silang\'></i>", Yii::app()->createUrl("/rawatDarurat/DaftarPasien/BatalRawatInap",array("pendaftaran_id"=>$data->pendaftaran_id)) , array("title"=>"Klik Untuk Batal Proses Tindak Lanjut Pasien","target"=>"iframeBatalRawatInap", "onclick"=>"$(\"#dialogBatalRawatInap\").dialog(\"open\");", "rel"=>"tooltip"))  :  
                                       (($data->statusperiksa==Params::STATUSPERIKSA_BATAL_PERIKSA) ? "" : CHtml::link("<i class=\'icon-user\'></i>", Yii::app()->createUrl("/rawatJalan/DaftarPasien/tindakLanjutRI", array("instalasi_id"=>$data->instalasi_id,"pendaftaran_id"=>$data->pendaftaran_id)),
                                       array("class"=>"",
                                       "target"=>"frameTindakLanjut",
                                       "rel"=>"tooltip",
                                       "title"=>"Klik untuk Proses Tindak Lanjut Pasien",
                                       "onclick"=>"$(\'#dialogTindakLanjut\').dialog(\'open\');")))',
                                    'htmlOptions'=>array('style'=>'text-align: center; width:60px')
                            ),
					array(
							'header'=>'Batal Periksa',
							'type'=>'raw',
							'value'=>function($data) {
								$rd = InfokunjunganrdV::model()->findByAttributes(array(
									'pendaftaran_id'=>$data->pendaftaran_id
								));
								
								if (($rd->pasienpulang_id != 0) || ($rd->carakeluar != "")) 
									return "-";
								
								$admisi = PasienadmisiT::model()->findByAttributes(array('pendaftaran_id'=>$data->pendaftaran_id));
								if (empty($admisi)) return CHtml::link('<i class="icon-form-silang"></i>', "javascript:batalperiksa($data->pendaftaran_id)",array("id"=>"$data->no_pendaftaran","rel"=>"tooltip","title"=>"Klik untuk membatalkan pemeriksaan"));
								else return "-";
							},
							'htmlOptions'=>array('style'=>'text-align: center; width:40px'),
					),

                            ),
                    'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
            ));

            }
        ?>
    </div>
    <?php $this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
            'id' => 'dialogRincian',
            'options' => array(
                    'title' => 'Rincian Tagihan Pasien',
                    'autoOpen' => false,
                    'modal' => true,
                    'width' => 900,
                    'resizable' => false,
            ),
    ));
    ?>
    <iframe name='frameRincian' width="100%" height="100%"></iframe>
    <?php $this->endWidget(); ?>
    <?php
    $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
            'action'=>Yii::app()->createUrl($this->route),
            'method'=>'get',
                    'id'=>'daftarPasien-form',
                    'type'=>'horizontal',
                    'htmlOptions'=>array('enctype'=>'multipart/form-data'),
                    'focus'=>'#'.CHtml::activeId($model,'no_rekam_medik'),

    )); ?>
    <fieldset class='box'>
        <legend class="rim"><i class='icon-white icon-search'></i> Pencarian</legend>
	<table width='100%' class="table-condensed">
            <tr>
                <td>
                    <div class="control-group ">
                        <label for="namaPasien" class="control-label">
                                <?php // echo CHtml::activecheckBox($model, 'ceklis', array('uncheckValue'=>0,'onClick'=>'cekTanggal()','rel'=>'tooltip' ,'data-original-title'=>'Cek untuk pencarian berdasarkan tanggal')); ?>
                                Tanggal Masuk 
                        </label>
                        <div class="controls">
                            <?php   
                                    $model->tgl_awal = $format->formatDateTimeForUser($model->tgl_awal);
                                    $this->widget('MyDateTimePicker',array(
                                                                    'model'=>$model,
                                                                    'attribute'=>'tgl_awal',
                                                                    'mode'=>'date',
                                                                    'options'=> array(
                                                                            'dateFormat'=>Params::DATE_FORMAT,
                                                                            'maxDate' => 'd',
                                                                    ),
                                                                    'htmlOptions'=>array('readonly'=>true,'class'=>'dtPicker3'),
                                    ));
                                    $model->tgl_awal = $format->formatDateTimeForDb($model->tgl_awal);
                            ?>
                        </div> 
                        <?php echo CHtml::label(' Sampai Dengan',' s/d', array('class'=>'control-label')) ?>
                        <div class="controls"> 
                            <?php    
                                    $model->tgl_akhir = $format->formatDateTimeForUser($model->tgl_akhir);
                                    $this->widget('MyDateTimePicker',array(
                                                                    'model'=>$model,
                                                                    'attribute'=>'tgl_akhir',
                                                                        'mode'=>'date',
                                                                        'options'=> array(
                                                                                'dateFormat'=>Params::DATE_FORMAT,
                                                                                'maxDate' => 'd',
                                                                        ),
                                                                        'htmlOptions'=>array('readonly'=>true,'class'=>'dtPicker3'),
                                        )); 
                                        $model->tgl_akhir = $format->formatDateTimeForDb($model->tgl_akhir);
                                ?>
                            </div>
                        </div> 
                </td>
                <td width='35%'>                    
                    <?php echo $form->textFieldRow($model,'no_pendaftaran',array('placeholder'=>'Ketik No. Pendaftaran','class'=>'span3 angkahuruf-only','onkeypress'=>"return $(this).focusNextInputField(event)", 'maxlength'=>12)); ?>
                    <?php echo $form->textFieldRow($model,'no_rekam_medik',array('placeholder'=>'Ketik No. Rekam Medik','class'=>'span3 numbers-only','onkeypress'=>"return $(this).focusNextInputField(event)", 'maxlength'=>6)); ?>
                    <?php echo $form->textFieldRow($model,'nama_pasien',array('placeholder'=>'Ketik Nama Pasien','class'=>'span3 hurufs-only','onkeypress'=>"return $(this).focusNextInputField(event)", 'maxlength'=>50)); ?>
                </td>
                <td width='35%'>
                    <?php 
                    $carabayar = CarabayarM::model()->findAll(array(
                        'condition'=>'carabayar_aktif = true',
                        'order'=>'carabayar_nama ASC',
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
                    <?php 
                    $dok = CHtml::listData(DokterV::model()->findAllByAttributes(array(
                        'pegawai_aktif'=>true,
                        'ruangan_id'=>Yii::app()->user->getState('ruangan_id'),
                    ), array(
                        'order'=>'nama_pegawai'
                    )), 'pegawai_id', 'namaLengkap');
                    
                    $kel = CHtml::listData(KelaspelayananM::model()->findAllByAttributes(array(
                        'kelaspelayanan_aktif'=>true,
                    ), array(
                        'order'=>'kelaspelayanan_nama'
                    )), 'kelaspelayanan_id', 'kelaspelayanan_nama');
                    
                    
                    
                    $kamar = CHtml::listData(KamarruanganM::model()->findAllByAttributes(array(
                        'ruangan_id'=>Yii::app()->user->getState('ruangan_id')
                    )), 'kamarruangan_id', 'kamarDanTempatTidurPolos');                    
                    echo $form->dropDownListRow($model, 'pegawai_id', $dok, array('empty'=>'-- Pilih --', 'class'=>'span3')); 
                    echo $form->dropDownListRow($model, 'kelaspelayanan_id', $kel, array(
                        'empty'=>'-- Pilih --', 
                        'class'=>'span3',
                    ));
                    echo $form->dropDownListRow($model, 'kamarruangan_id', $kamar, array('empty'=>'-- Pilih --', 'class'=>'span3'));
                    ?>
                </td>
            </tr>
	</table>
	<?php 
		echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="icon-search icon-white"></i>')),
					array('class'=>'btn btn-primary', 'type'=>'submit','id'=>'btn_simpan'));
				echo CHtml::hiddenField('pendaftaran_id');
			if(isset($_GET['data']))
			{
				echo CHtml::hiddenField('jumlahPersalinan', $_GET['data']); 
			}
		echo CHtml::hiddenField('pasien_id');
	?>
	<?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
							Yii::app()->createUrl($this->module->id.'/'.Yii::app()->controller->id.'/'.Yii::app()->controller->action->id.''), 
							array('class'=>'btn btn-danger',
								  'onclick'=>'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href ;}); return false;'));  ?>
	<?php
		$content = $this->renderPartial('../daftarPasien/tips/informasi',array(),true);
		$this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); 
	?>
    <?php $this->endWidget();?>
    </fieldset>  
</div>
<?php 
// Dialog untuk pasienpulang_t =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( 
	'id'=>'dialogPasienPulang',
	'options'=>array(
		'title'=>'Tindak Lanjut Pasien Persalinan',
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

$this->endWidget();
//========= end ubah status periksa dialog =============================
?>
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

<script>
	
	
function batalperiksa(pendaftaran_id)
{
	myConfirm("Anda yakin akan membatalkan pemeriksaan/persalinan pasien ini?","Perhatian!",function(r) {
		if(r){
			 $.ajax({
				type:'POST',
				url:'<?php echo Yii::app()->createUrl(Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/' . 'batalPeriksa'); ?>',
				data: {pendaftaran_id : pendaftaran_id},//
				dataType: "json",
				success:function(data){
					if(data.status == true){
						myAlert(data.pesan);
						$.fn.yiiGridView.update('daftarPasien-grid', {
							data: $(this).serialize() });
					}else if(data.pesan == 'exist'){
						myAlert('Pasien telah melakukan pemeriksaan');
					}else{
						myAlert(data.pesan);
					}
				},
				error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
			});
		}
	});
}
// document.getElementById('PSInfokunjunganpersalinanV_tgl_awal_date').setAttribute("style","display:none;");
// document.getElementById('PSInfokunjunganpersalinanV_tgl_akhir_date').setAttribute("style","display:none;");
function cekTanggal(){

	var checklist = $('#PSInfokunjunganpersalinanV_ceklis');
	var pilih = checklist.attr('checked');
	if(pilih){
		document.getElementById('PSInfokunjunganpersalinanV_tgl_awal_date').setAttribute("style","display:block;");
		document.getElementById('PSInfokunjunganpersalinanV_tgl_akhir_date').setAttribute("style","display:block;");
	}else{
		document.getElementById('PSInfokunjunganpersalinanV_tgl_awal_date').setAttribute("style","display:none;");
		document.getElementById('PSInfokunjunganpersalinanV_tgl_akhir_date').setAttribute("style","display:none;");
	}
}

function addPasienPulang(pendaftaran_id,pasien_id)
{
	$('#pendaftaran_id').val(pendaftaran_id);
	$('#pasien_id').val(pasien_id);

	<?php 
			echo CHtml::ajax(array(
			'url'=>$this->createUrl('addPasienPulang'),
			'data'=> "js:$(this).serialize()",
			'type'=>'post',
			'dataType'=>'json',
			'success'=>"function(data)
			{
				if (data.status == 'create_form')
				{
					$('#dialogPasienPulang div.divForForm').html(data.div);
					$('#dialogPasienPulang div.divForForm form').submit(addPasienPulang);

					jQuery('.dtPicker3').datetimepicker(jQuery.extend({showMonthAfterYear:false}, 
					jQuery.datepicker.regional['id'], {'dateFormat':'dd M yy','minDate'  : 'd','timeText':'Waktu','hourText':'Jam',
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

function cekStatus(status){
    var status = status;
    myAlert("Pasien "+status+" Tidak bisa melanjutkan pemeriksaan atau tindak lanjut");
}
</script>

<?php
$urlSession = $this->createUrl('buatSessionPendaftaranPasien');
$urlPasienRujukRI = Yii::app()->createUrl('daftarPasien/PasienRujukRI');

$jscript = <<< JS
function buatSession(pendaftaran_id,pasien_id)
{
	$.post("${urlSession}", { pendaftaran_id: pendaftaran_id,pasien_id: pasien_id },
		function(data){
			'sukses';
	}, "json");
}


JS;
Yii::app()->clientScript->registerScript('jsPendaftaran',$jscript, CClientScript::POS_BEGIN);
?>

<?php
$jscript = <<< JS
function tindakLanjutRI(pendaftaran_id)
{
	$('#dialogRujukanRI').dialog('open');
	$('#pendaftaran_id').val(pendaftaran_id);
}

function simpanPasienPulang()
{
	pendaftaran_id=$('#pendaftaran_id').val();
	myAlert(pendaftaran_id);
	$.post("${urlPasienRujukRI}", { pendaftaran_id: pendaftaran_id},
		function(data){
		myAlert(data.pesan);
		$('#dialogRujukanRI').dialog('close')
	}, "json");
}

JS;
Yii::app()->clientScript->registerScript('rujukKerawatInap',$jscript, CClientScript::POS_HEAD);


// ===========================Dialog Rujukan ke RI=========================================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
					'id'=>'dialogRujukanRI',
						// additional javascript options for the dialog plugin
						'options'=>array(
						'title'=>'Konfirmasi',
						'autoOpen'=>false,
						'width'=>500,
						'resizable'=>false,
//                        'hide'=>explode,    
						 ),
					));
?>
<div align="center">Anda Yakin Akan Melakukan Tindak Lanjut Ke Rawat Inap ?
	<br/>
		<?php echo CHtml::hiddenField('pendaftaran_id'); ?>
		<?php echo CHtml::htmlButton(Yii::t('mds','{icon} Ya',array('{icon}'=>'<i class="icon-ok icon-white"></i>')), array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'simpanPasienPulang()')); ?>
		<?php echo CHtml::htmlButton(Yii::t('mds','{icon} Tidak',array('{icon}'=>'<i class="icon-ok icon-white"></i>')), array('class'=>'btn btn-danger', 'type'=>'button','onclick'=>'$(\'#dialogRujukanRI\').dialog(\'close\')')); ?>


</div>
<?php
$this->endWidget('zii.widgets.jui.CJuiDialog');
//===============================Akhir Dialog Rujukan ke RI================================

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
    echo CHtml::hiddenField('temp_idPasienadmisiDP','',array('readonly'=>true));
    echo '<div class="divForFormEditDokterPeriksa"></div>';
    $this->endWidget('zii.widgets.jui.CJuiDialog');
?>

<script>
function ubahDokterPeriksa(pendaftaran_id,pasienadmisi_id)
{
    $('#temp_idPendaftaranDP').val(pendaftaran_id);
    $('#temp_idPasienadmisiDP').val(pasienadmisi_id);
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


function cekPegawai(){
    var pegawai_id = "<?php echo Yii::app()->user->getState('pegawai_id');  ?>";
    
    if (pegawai_id != ''){
        return true
    }else{
        myAlert("Maaf, <b>Nama Pemakai (user login)</b> Anda tidak bisa untuk melakukan transaksi ini. <br> <b>'Mohon untuk menghubungi Sistem Administrator'</b>");
        return false;
    }
}
</script>
