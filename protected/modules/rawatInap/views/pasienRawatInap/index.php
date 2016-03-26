<div class="white-container">
    <legend class="rim2">Informasi Pasien <b>Rawat Inap</b></legend>
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
        <h6>Tabel Pasien <b>Rawat Inap</b></h6>
        <div class="table-responsive">
            <?php
                $this->widget('ext.bootstrap.widgets.BootGridView', array(
                    'id'=>'daftarPasien-grid',
                    'dataProvider'=>$model->searchRI(),
                    'template'=>"{summary}\n{items}\n{pager}",
                    'itemsCssClass'=>'table table-striped table-condensed',
                    'columns'=>array(
                            array(
                               'header'=>'Tanggal Admisi / Masuk Kamar',
                                'type'=>'raw',
                                'value'=>'MyFormatter::formatDateTimeForUser($data->tglAdmisiMasukKamar)'
                            ),
                    //                    'ruangan_nama',
                            array(
                               'name'=>'caramasuk_nama',
                                'type'=>'raw',
                                'value'=>'$data->caramasuk_nama',
                            ),
                            array(
                                'header'=>'Tgl. Pendaftaran/<br/>No. Pendaftaran',
                                'type'=>'raw',
                                'value'=>'MyFormatter::formatDateTimeForUser($data->tgl_pendaftaran)."/<br/>".$data->no_pendaftaran'
                            ),
                            array(
                               'header'=>'No. Rekam Medik',
                                'type'=>'raw',
                                'value'=>'$data->no_rekam_medik',
                            ),
                            array(
                                'header'=>'Nama Pasien',
                                'value'=>'$data->namadepan.$data->nama_pasien'
                            ), 
                            array(
                                'header'=>'Cara Bayar / Penjamin',
                                'value'=>'$data->caraBayarPenjamin',
                            ),
                            /*
                            array(
                                'name'=>'jeniskelamin',
                                'value'=>'$data->jeniskelamin',
                            ), 
                            array(
                                'name'=>'umur',
                                'type'=>'raw',
                                'value'=>'CHtml::hiddenField("RIInfokunjunganriV[$data->pendaftaran_id][pendaftaran_id]", $data->pendaftaran_id, array("id"=>"pendaftaran_id","onkeypress"=>"return $(this).focusNextInputField(event)","class"=>"span3"))."".$data->umur',
                            ), */
                            array(
                               'name'=>'Dokter',
                                'type'=>'raw',
                                'value'=>'"<div style=\'width:100px;\'>" . CHtml::link("<i class=icon-pencil-brown></i> ". $data->gelardepan." ".$data->nama_pegawai." ".$data->gelarbelakang_nama," ",array("onclick"=>"ubahDokterPeriksa(\'$data->pendaftaran_id\',\'$data->pasienadmisi_id\');$(\'#editDokterPeriksa\').dialog(\'open\');return false;", "rel"=>"tooltip","rel"=>"tooltip","title"=>"Klik Untuk Mengubah Data Dokter Periksa")) . "</div>"',
                            ),
                            array(
                               'name'=>'kelaspelayanan_nama',
                                'type'=>'raw',
                                'value'=>'$data->kelaspelayanan_nama',
                            ),
                            array(
                                                    'name'=>'jeniskasuspenyakit_nama',
                                'type'=>'raw',
                                'value'=>'CHtml::hiddenField("RIInfopasienmasukkamarV[$data->pendaftaran_id][pendaftaran_id]", $data->pendaftaran_id, array("id"=>"pendaftaran_id","onkeypress"=>"return $(this).focusNextInputField(event)","class"=>"span3"))."".CHtml::link("<i class=icon-form-ubah></i> ".$data->jeniskasuspenyakit_nama,"javascript:void(0)",array("onclick"=>"ubahKasusPenyakit(this,$data->pendaftaran_id,$data->pasienadmisi_id,$data->jeniskasuspenyakit_id);return false;","class"=>"kasus_penyakit","rel"=>"tooltip","rel"=>"tooltip","title"=>"Klik Untuk Mengubah Data Kasus Penyakit"))',
                                                    'htmlOptions'=>array(
                                                            'style'=>'text-align: center',
                                                            'class'=>'list_kasus_penyakit'
                                                    )
                            ),
                            array(
                                'header'=>'No.Kamar <br> No.Bed',
                               'name'=>'kamarruangan_nokamar',
                                'type'=>'raw',
                                'value'=>'(!empty($data->kamarruangan_nokamar))? "Kmr : ".$data->kamarruangan_nokamar."<br>"."Bed : ".$data->kamarruangan_nobed.CHtml::link("<i class=icon-form-ubah></i>","",array("href"=>"","rel"=>"tooltip","title"=>"Klik Untuk Memasukan Pasien Ke kamar","onclick"=>"{buatSessionMasukKamar($data->masukkamar_id,$data->kelaspelayanan_id,$data->pendaftaran_id); addMasukKamar(); $(\'#dialogMasukKamar\').dialog(\'open\');}return false;")) : "<span class=\"no_kamar\">".CHtml::link("<i class=icon-form-kamar></i>","",array("href"=>"","rel"=>"tooltip","title"=>"Klik Untuk Memasukan Pasien Ke kamar","onclick"=>"{buatSessionMasukKamar($data->masukkamar_id,$data->kelaspelayanan_id,$data->pendaftaran_id); addMasukKamar(); $(\'#dialogMasukKamar\').dialog(\'open\');}return false;"))',    
                                'htmlOptions'=>array('style'=>'text-align:center;'),
                            ),
                            array(
                               'header'=>'Pindah Kamar',
                               'type'=>'raw',
                               'value'=>function($data) {
                                    if (!empty($data->pasienpulang_id)) {
                                        return $data->carakeluar;
                                    } else if (!empty($data->kamarruangan_nokamar)) {
                                        return CHtml::link("<i class='icon-form-pindahkamar'></i> ",Yii::app()->controller->createUrl(Yii::app()->controller->id.'/PindahKamarPasienRI',array("pendaftaran_id"=>$data->pendaftaran_id)) ,array("title"=>"Klik Untuk Pindah Kamar","target"=>"iframePindahKamar", "onclick"=>"$('#dialogPindahKamar').dialog('open');", "rel"=>"tooltip"));
                                    } else {
                                        return CHtml::link("<i class='icon-form-pindahkamar'></i> ","#",array("title"=>"Klik Untuk Pindah Kamar","target"=>"iframePindahKamar", "onclick"=>"myAlert('Pasien belum masuk kamar.'); return false;", "rel"=>"tooltip"));
                                    }
                               },
                               'htmlOptions'=>array('style'=>'text-align: center; width:40px'),
                            ),
                            array(
                                'name'=>'Periksa Pasien',
                                'type'=>'raw',
                //                        'value'=>'((!empty($data->pasienpulang_id)) ? "-" : CHtml::link("<i class=\'icon-list-alt\'></i> ", Yii::app()->controller->createUrl("/rawatInap/pemeriksaanPasien",array("pendaftaran_id"=>$data->pendaftaran_id,"pasienadmisi_id"=>$data->pasienadmisi_id)),array("id"=>"$data->no_pendaftaran","rel"=>"tooltip","title"=>"Klik untuk Pemeriksaan Pasien")))',
                                'value'=>function($data) {
                                    if (!empty($data->kamarruangan_nokamar)) 
                                    return CHtml::link("<i class='icon-form-periksa'></i> ", Yii::app()->controller->createUrl("/rawatInap/pemeriksaanPasien",array("pendaftaran_id"=>$data->pendaftaran_id,"pasienadmisi_id"=>$data->pasienadmisi_id)),array("id"=>$data->no_pendaftaran,"rel"=>"tooltip","title"=>"Klik untuk Pemeriksaan Pasien"));
                                    else return (CHtml::link("<i class='icon-form-periksa'></i> ", "#",array("id"=>"$data->no_pendaftaran","rel"=>"tooltip","title"=>"Klik untuk Pemeriksaan Pasien", "onclick"=>"myAlert('Pasien belum masuk kamar.'); return false;")));
                                },
                                'htmlOptions'=>array('style'=>'text-align: center; width:40px'),
                            ),
                                            array(
                                                    'name'=>'Alergi Obat',
                                                    'type'=>'raw',
                                                    'value'=>function($data) {
                                                        $url = !empty($data->kamarruangan_nokamar) ? Yii::app()->controller->createUrl("/rawatJalan/daftarPasien/alergiObat",array("pendaftaran_id"=>$data->pendaftaran_id)) : "#";
                                                        $click = !empty($data->kamarruangan_nokamar) ? "$('#dialogAlergiObat').dialog('open');" : "myAlert('Pasien belum masuk kamar.'); return false;";
                                                        return  CHtml::link("<i class='icon-form-riwayatperiksa'></i> ", $url,
                                                                array("id"=>"$data->no_pendaftaran",
                                                                    "rel"=>"tooltip",
                                                                    "title"=>"Klik untuk melihat riwayat alergi obat pasien",
                                                                    "target"=>"frameAlergiObat",
                                                                    "onclick"=>$click,
                                                                ));
                                            },
                                                    'htmlOptions'=>array('style'=>'text-align: center; width:60px')
                                            ), /*
                                            array(
                                                    'name'=>'Label Gelang',
                                                    'type'=>'raw',
                                                    'value'=>'CHtml::link("<i class=\'icon-form-kamar\'></i> ", Yii::app()->controller->createUrl("/rawatInap/pasienRawatInap/labelGelang",array("pendaftaran_id"=>$data->pendaftaran_id)),
                                                                    array("id"=>"$data->no_pendaftaran",
                                                                            "rel"=>"tooltip",
                                                                            "title"=>"Klik untuk melihat label gelang pasien",
                                                                            "target"=>"frameLabelGelang",
                                                                            "onclick"=>"$(\'#dialogLabelGelang\').dialog(\'open\');"
                                                                            ))',
                                                    'htmlOptions'=>array('style'=>'text-align: center; width:60px')
                                            ), */

            //                    array(
            //                       'header'=>'Tindak Lanjut',
            //                       'type'=>'raw',
            //                       'value'=>'((!empty($data->pasienpulang_id)) ? $data->carakeluar : CHtml::link("<i class=\'icon-share\'></i> ",Yii::app()->controller->createUrl("'.Yii::app()->controller->id.'/TindakLanjutDariPasienRI",array("pendaftaran_id"=>$data->pendaftaran_id)) ,array("title"=>"Klik Untuk Tindak lanjut Pasien","target"=>"iframeTindakLanjut", "onclick"=>"$(\"#dialogTindakLanjut\").dialog(\"open\");", "rel"=>"tooltip"))."<br>".CHtml::link("<i class=\'icon-remove\'></i>", "javascript:cekHakAkses($data->pendaftaran_id)",array("id"=>"$data->no_pendaftaran","rel"=>"tooltip","title"=>"Klik untuk Batal Rawat Inap")))',
            //                       'htmlOptions'=>array('style'=>'text-align: center; width:40px'),
            //                    ),
                            array(
                               'header'=>'Pindahan Dari',
                               'type'=>'raw',
                               'value'=>'($data->PindahanDari->pindahkamar_id == "") ?  "Bukan Pindahan" : 
                                        "Rg:".$data->PindahanDari->ruangan->ruangan_nama." Kmr:".$data->PindahanDari->kamarruangan->kamarruangan_nokamar." Bed:".$data->PindahanDari->kamarruangan->kamarruangan_nobed."<br>".
                                        ($data->TindakanDanObat["ada"] ? CHtml::link("Sedang Diperiksa", "#",array("title"=>"Silahkan batalkan dulu ".$data->TindakanDanObat["msg"]."!")) : CHtml::link("<i class=icon-remove-sign></i>","#",array("rel"=>"tooltip","title"=>"Klik Untuk Batal Pindah Kamar","onclick"=>"batalPindahKamar(".$data->PindahanDari->pindahkamar_id.",".$data->PindahanDari->masukkamar_id.");")))
                                    ',
                            ),
                                                    array(
                                'name'=>'Verifikasi Tindakan Pasien',
                                'type'=>'raw',
                                'value'=>function($data) {
                                        $url = !empty($data->kamarruangan_nokamar) ? Yii::app()->controller->createUrl("/rawatInap/verifikasiTindakan",array("pendaftaran_id"=>$data->pendaftaran_id,"pasienadmisi_id"=>$data->pasienadmisi_id)) : "#";
                                        $click = !empty($data->kamarruangan_nokamar) ? "return true" : "myAlert('Pasien belum masuk kamar.'); return false;";
                                        return (CHtml::link("<i class='icon-form-detailtagihan'></i> ", $url, array("id"=>"$data->no_pendaftaran","rel"=>"tooltip","title"=>"Klik untuk Verifikasi Tindakan Pasien", "onclick"=>$click)));
                                },
                                'htmlOptions'=>array('style'=>'text-align: center; width:40px'),
                            ),
                            array(
                               'header'=>'Pulangkan Pasien <br/> Rencana Pulang',
                               'type'=>'raw',
                               'value'=>
                                '(empty($data->kamarruangan_nokamar))?"Belum Masuk Kamar":((!empty($data->pasienpulang_id)) ? $data->carakeluar : CHtml::link("<i class=\'icon-form-pulang\'></i> ",
                                         Yii::app()->controller->createUrl("'.Yii::app()->controller->id.'/TindakLanjutDariPasienRI",
                                         array("pendaftaran_id"=>$data->pendaftaran_id)) ,
                                         array("title"=>"Klik Untuk Pemulangan Pasien","target"=>"iframeTindakLanjut", 
                                         "onclick"=>"verifikasiPulangPasien(\"$data->pendaftaran_id\")", "rel"=>"tooltip")))." /".
                                         ((!empty($data->rencanapulang)) ? $data->rencanapulang.CHtml::link("<i class=\'icon-form-rencanapulang\'></i> ",
                                         Yii::app()->controller->createUrl("'.Yii::app()->controller->id.'/RencanaPulangPasienRI",
                                         array("idPasienadmisi"=>$data->pasienadmisi_id)) ,
                                         array("title"=>"Klik Untuk Rencana Pulang Pasien","target"=>"iframeRencanaPulang", 
                                        "onclick"=>"verifikasiRencanaPulang(\"$data->pendaftaran_id\")", "rel"=>"tooltip")) : CHtml::link("<i class=\'icon-form-rencanapulang\'></i> ",
                                         Yii::app()->controller->createUrl("'.Yii::app()->controller->id.'/RencanaPulangPasienRI",
                                         array("idPasienadmisi"=>$data->pasienadmisi_id)) ,
                                         array("title"=>"Klik Untuk Rencana Pulang Pasien","target"=>"iframeRencanaPulang", 
                                        "onclick"=>"verifikasiRencanaPulang(\"$data->pendaftaran_id\")", "rel"=>"tooltip")))',
                               'htmlOptions'=>array('style'=>'text-align: center; width:80px'),
                            ),
                            array(
                               'header'=>'Batal Rawat',
                               'type'=>'raw',
                               'value'=>'CHtml::link("<i class=\'icon-form-silang\'></i>", 
                                         Yii::app()->controller->createUrl("'.Yii::app()->controller->id.'/batalRawatInap",
                                         array("pendaftaran_id"=>$data->pendaftaran_id)),
                                         array("title"=>"Klik untuk Batal Rawat Inap", "target"=>"iframeBatalRawatInap",
                                         "onclick"=>"$(\"#dialogBatalRawatInap\").dialog(\"open\");", "rel"=>"tooltip"))',
                               'htmlOptions'=>array('style'=>'text-align: center; width:40px'),
                            ),
            //                    array(
            //                    'header'=>'Rincian Tagihan',
            //                    'type'=>'raw',
            //                    'value'=>'CHtml::link("<icon class=\'icon-list\'></idcon>", Yii::app()->createUrl("'.$module.'/'.$controller.'/rincian", array("id"=>$data->pendaftaran_id)), array("target"=>"frameRincian", "onclick"=>"$(\'#dialogRincian\').dialog(\'open\');"))',
            //                ), 
            //                link rincian sblmnya: '.$module.'/'.$controller.'/rincian
                            array(
                                      'header'=>'Detail Rincian Tagihan',
                                      'type'=>'raw',
            //                          'value'=>'CHtml::link("<icon class=\'icon-list-brown\'></idcon>", Yii::app()->createUrl("billingKasir/RinciantagihanpasienV/rincianBelumBayarRI", array("id"=>$data->pendaftaran_id)), array("target"=>"frameRincian", "onclick"=>"$(\'#dialogRincian\').dialog(\'open\');"))','htmlOptions'=>array('style'=>'text-align: center; width:40px')
                                      'value'=>'CHtml::link("<icon class=\'icon-form-detailtagihan\'></idcon>", Yii::app()->createUrl("/billingKasir/pembayaranTagihanPasien/printDetailRincianBelumBayar", array("instalasi_id"=>$data->instalasi_id,"pendaftaran_id"=>$data->pendaftaran_id,"pasienadmisi_id"=>$data->pasienadmisi_id,"frame"=>true)), array("target"=>"frameRincian", "onclick"=>"$(\'#dialogRincian\').dialog(\'open\');"))','htmlOptions'=>array('style'=>'text-align: center; width:40px')
                            ),  
                            array(
                                      'header'=>'Rincian Tagihan',
                                      'type'=>'raw',
            //                          'value'=>'CHtml::link("<icon class=\'icon-list-brown\'></idcon>", Yii::app()->createUrl("billingKasir/RinciantagihanpasienV/rincianBelumBayarRI", array("id"=>$data->pendaftaran_id)), array("target"=>"frameRincian", "onclick"=>"$(\'#dialogRincian\').dialog(\'open\');"))','htmlOptions'=>array('style'=>'text-align: center; width:40px')
                                      'value'=>'CHtml::link("<icon class=\'icon-form-detail\'></idcon>", Yii::app()->createUrl("/billingKasir/pembayaranTagihanPasien/printRincianBelumBayar", array("instalasi_id"=>$data->instalasi_id,"pendaftaran_id"=>$data->pendaftaran_id,"pasienadmisi_id"=>$data->pasienadmisi_id,"frame"=>true)), array("target"=>"frameRincian", "onclick"=>"$(\'#dialogRincian\').dialog(\'open\');"))','htmlOptions'=>array('style'=>'text-align: center; width:40px')
                            ),  
                            array(
                                    'header'=>'Status Dokumen',
                                    'type'=>'raw',
                                    'value'=>function($data) {
                                        $kirimrm = PengirimanrmT::model()->findByAttributes(array(
                                            'pendaftaran_id'=>$data->pendaftaran_id,
                                            'ruangan_id'=>Yii::app()->user->getstate('ruangan_id'),
                                        ));
                                        
                                        if (empty($kirimrm)) return '<button id="red" class="btn btn-primary" name="yt1">BELUM DI TERIMA</button>';
                                        else if (empty($kirimrm->tglterimadokrm)) return '<button id="red" class="btn btn-primary" name="yt1" onclick="verifikasiKirimanRM('.$data->pendaftaran_id.','.$kirimrm->pengirimanrm_id.')">BELUM DI VERIFIKASI</button>';
                                        return '<button id="red" class="btn btn-primary" name="yt1" onclick="verifikasiKirimanRM('.$data->pendaftaran_id.', '.$kirimrm->pengirimanrm_id.')">SUDAH DI VERIFIKASI</button>';
                                    }, 
                                            /*'($data->statusdokrm == "SUDAH DITERIMA") ? CHtml::link("<i></i> $data->statusdokrm", Yii::app()->createUrl("/'.Yii::app()->controller->module->id.'/'.Yii::app()->controller->id.'/statusDokumenKirim", array("pengirimanrm_id"=>$data->pengirimanrm_id,"pendaftaran_id"=>$data->pendaftaran_id)),
                                                                    array("class"=>"btn btn-primary",
                                                                    "target"=>"frameStatusDokumen",
                                                                    "rel"=>"tooltip",
                                                                    "title"=>"Klik untuk mengirim dokumen ke ruangan lain",
                                                                    "onclick"=>"$(\'#dialogStatusDokumen\').dialog(\'open\');"))
                                            : $data->getStatusDokumen($data->pengirimanrm_id,$data->statusdokrm,$data->pendaftaran_id)',
                                             * 
                                             */
                                    'htmlOptions'=>array('style'=>'text-align: center; width:40px'),
                            ),
                    //                   
            //                    array(
            //                       'header'=>'Rencana Pulang',
            //                       'type'=>'raw',
            //                       'value'=>'((!empty($data->rencanapulang)) ? $data->rencanapulang : CHtml::link("<i class=\'icon-time\'></i> ",
            //                           Yii::app()->controller->createUrl("'.Yii::app()->controller->id.'/RencanaPulangPasienRI",array("idPasienadmisi"=>$data->pasienadmisi_id)) ,
            //                               array("title"=>"Klik Untuk Rencana Pulang Pasien","target"=>"iframeRencanaPulang", "onclick"=>"$(\"#dialogRencanaPulang\").dialog(\"open\");", "rel"=>"tooltip")))',
            //                       'htmlOptions'=>array('style'=>'text-align: center; width:40px'),
            //                    ),

                        ),
                    'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
                ));


            ?>
        </div>
    </div>
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
    <div style='display:none'>
    <?php $this->widget('MyDateTimePicker',array(
//      'model'=>$modMasukKamar,
        'name'=>'jammasukkamar',
        'mode'=>'time',
        'options'=> array(
             'dateFormat'=>Params::TIME_FORMAT,
        ),
        'htmlOptions'=>array('readonly'=>true,
        'class'=>'dtPicker3',
        'onkeypress'=>"return $(this).focusNextInputField(event);",
        ),
    )); ?>
    </div>
    <?php echo $this->renderPartial('_formPencarian', array('model'=>$model,'format'=>$format)); ?>


    <?php 
    // Dialog untuk pasienpulang_t =========================
    $this->beginWidget('zii.widgets.jui.CJuiDialog', array( 
        'id'=>'dialogPasienPulang',
        'options'=>array(
            'title'=>'Pasien Pulang',
            'autoOpen'=>false,
            'modal'=>true,
            'minWidth'=>800,
            'minHeight'=>600,
            'resizable'=>false,
        ),
    ));

    echo '<div class="divForForm"></div>';


    $this->endWidget();
    //========= end pasienpulang_t dialog =============================
    ?>

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

    <?php 
    // Dialog untuk pindahkamar_t =========================
    $this->beginWidget('zii.widgets.jui.CJuiDialog', array( 
        'id'=>'dialogPindahKamar',
        'options'=>array(
            'title'=>'Pindah Kamar Pasien',
            'autoOpen'=>false,
            'modal'=>true,
            'minWidth'=>1100,
            'minHeight'=>700,
            'height'=>530,
            'resizable'=>true,
        ),
    ));
    ?>
    <iframe src="" name="iframePindahKamar" width="100%" height="480">
    </iframe>
    <?php $this->endWidget(); ?>

    <?php 
    // Dialog untuk batal Rawat Inap =========================
    $this->beginWidget('zii.widgets.jui.CJuiDialog', array( 
        'id'=>'dialogBatalRawatInap',
        'options'=>array(
            'title'=>'Pembatalan Pasien Rawat Inap',
            'autoOpen'=>false,
            'modal'=>true,
            'minWidth'=>800,
            'minHeight'=>500,
            'resizable'=>true,
        ),
    ));
    ?>
    <iframe src="" name="iframeBatalRawatInap" width="100%" height="550">
    </iframe>
    <?php $this->endWidget(); ?>

    <?php 
    // Dialog untuk pindahkamar_t =========================
    $this->beginWidget('zii.widgets.jui.CJuiDialog', array( 
        'id'=>'dialogTindakLanjut',
        'options'=>array(
            'title'=>'Transaksi Pasien Pulang',
            'autoOpen'=>false,
            'modal'=>true,
            'minWidth'=>1100,
            'minHeight'=>700,
            'resizable'=>true,
        ),
    ));
    ?>

    <iframe src="" name="iframeTindakLanjut" width="100%" height="900">
    </iframe>

    <?php
    $this->endWidget();
    //========= end pasienpulang_t dialog =============================
    ?>


    <?php 
    // Dialog untuk rencana pulang =========================
    $this->beginWidget('zii.widgets.jui.CJuiDialog', array( 
        'id'=>'dialogRencanaPulang',
        'options'=>array(
            'title'=>'Rencana Pulang',
            'autoOpen'=>false,
            'modal'=>true,
            'minWidth'=>600,
            'minHeight'=>300,
            'resizable'=>true,
        ),
    ));
    ?>

    <iframe src="" name="iframeRencanaPulang" width="100%" height="300px;">
    </iframe>

    <?php
    $this->endWidget();
    //========= end rencanapulang dialog =============================
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
             <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Cancel',array('{icon}'=>'<i class="icon-ban-circle icon-white"></i>')),
                                array('class'=>'btn btn-danger', 'type'=>'button', 'onclick'=>'batal();return false;')); ?>
        </div> 
    <?php echo CHtml::endForm(); ?>
    <?php $this->endWidget();?>
<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( 
    'id'=>'dialogAlasan',
    'options'=>array(
        'title'=>'Data Pasien',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>1000,
        'height'=>250,
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
            <?php echo CHtml::hiddenField('pasienadmisi_id', '', array('readonly'=>TRUE)); ?>
            
        </td>
    </tr>
</table>    
    <div class="form-actions">
        <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-lock icon-white"></i>')),
                            array('class'=>'btn btn-primary', 'type'=>'submit', 'onclick'=>'simpanAlasan();return false;')); ?>
        <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Cancel',array('{icon}'=>'<i class="icon-ban-circle icon-white"></i>')),
                            array('class'=>'btn btn-danger', 'type'=>'button', 'onclick'=>'batal();return false;')); ?>    </div> 
<?php echo CHtml::endForm(); ?>
<?php $this->endWidget();?>
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
    $('#dialogAlasan #pasienadmisi_id').val('');
    
    $.fn.yiiGridView.update('daftarpasien-v-grid', {
        data: $('#daftarPasienPulang-form').serialize()
    });
}    
function cekHakAkses(pendaftaran_id)
{
//       $('#dialogAlasan #idPasienPulang').val(idPasienPulang);
//       $('#dialogAlasan #pendaftaran_id').val(pendaftaran_id);
//       $('#pasien_id').val(pasien_id);
//       $('#pendaftaran_id').val(pendaftaran_id);
       
       $('#konfirmasiDialog').dialog('open');

    $.post('<?php echo Yii::app()->createUrl('rawatJalan/ActionAjax/CekHakAkses');?>', {pendaftaran_id:pendaftaran_id, idUser:'<?php echo Yii::app()->user->id; ?>',useName:'<?php echo Yii::app()->user->name; ?>'}, function(data){
        
        if(data.cekAkses==true){
            $('#dialogAlasan').dialog('open');
            $('#dialogAlasan #idOtoritas').val(data.userid);
            $('#dialogAlasan #namaOtoritas').val(data.username);
        } else {
            $('#konfirmasiDialog').dialog('open');
        }
        $('#dialogAlasan #idPasienPulang').val(data.pendaftaran.pasienpulang_id);
       $('#dialogAlasan #pendaftaran_id').val(data.pendaftaran.pendaftaran_id);
       $('#pasien_id').val(data.pendaftaran.pasien_id);
       $('#pendaftaran_id').val(data.pendaftaran.pendaftaran_id);
       $('#dialogAlasan #pasienadmisi_id').val(data.pendaftaran.pasienadmisi_id);
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
              $.post('<?php echo Yii::app()->createUrl('rawatJalan/ActionAjax/dataPasien');?>', {pasien_id:pasien_id ,pendaftaran_id:pendaftaran_id}, function(dataPasien){
                  
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
        $.post('<?php echo Yii::app()->createUrl('rawatInap/pasienRawatInap/BatalRawatInap');?>', $('#formAlasan').serialize(), function(data){
//            if(data.error != '')
//                myAlert(data.error);
//            $('#'+data.cssError).addClass('error');
            if(data.status=='success'){
                batal();
                myAlert('Data Berhasil Disimpan');
                location.reload();
            }else{
                myAlert(data.status);
            }
        }, 'json');
   }     
}




</script>
<script>
        function addMasukKamar()
{
    
    <?php 
            echo CHtml::ajax(array(
            'url'=>Yii::app()->createUrl('rawatInap/pasienRawatInap/addMasukKamarRI'),
            'data'=> "js:$(this).serialize()",
            'type'=>'post',
            'dataType'=>'json',
            'success'=>"function(data)
            {
                if (data.status == 'create_form')
                {
                    $('#dialogMasukKamar div.divForForm').html(data.div);
                    $('#dialogMasukKamar div.divForForm form').submit(addMasukKamar);
                    
//                    jQuery('.dtPicker3').datetimepicker(jQuery.extend({showMonthAfterYear:false}, 
//                    jQuery.datepicker.regional['id'], {'dateFormat':'dd M yy hh:mm:ss','maxDate'  : 'd','timeText':'Waktu','hourText':'Jam',
//                         'minuteText':'Menit','secondText':'Detik','showSecond':true,'timeOnlyTitle':'Pilih   Waktu','timeFormat':'hh:mm:ss','changeYear':true,'changeMonth':true,'showAnim':'fold'}));
//                    
                    jQuery('#MasukkamarT_jammasukkamar').timepicker(jQuery.extend({showMonthAfterYear:false}, 
                    jQuery.datepicker.regional['id'], {
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

function ubahKasusPenyakit(obj,pendaftaran_id, pasienadmisi_id, jeniskasuspenyakit_id){
	var pendaftaran_id = pendaftaran_id;
	var pasienadmisi_id = pasienadmisi_id;
	var jeniskasuspenyakit_id = jeniskasuspenyakit_id;
	$.ajax({
	   type:'POST',
	   url:'<?php echo $this->createUrl('SetDropdownKasusPenyakit'); ?>',
	   data: {pendaftaran_id:pendaftaran_id,pasienadmisi_id:pasienadmisi_id,jeniskasuspenyakit_id:jeniskasuspenyakit_id},
	   dataType: "json",
	   success:function(data){
			$(obj).parents('tr').find('.list_kasus_penyakit').append(data.kasusPenyakit);
			$(obj).parents('td').find('.kasus_penyakit').hide();			
	   },
	   error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
   });	
   return false;
}

function saveKasusPenyakit(obj,pendaftaran_id,pasienadmisi_id){
	var jeniskasuspenyakit_id = $(obj).val();
	var pendaftaran_id = pendaftaran_id;
	var pasienadmisi_id = pasienadmisi_id;
	$.ajax({
	   type:'POST',
	   url:'<?php echo $this->createUrl('saveKasusPenyakit'); ?>',
	   data: {pendaftaran_id:pendaftaran_id,pasienadmisi_id:pasienadmisi_id,jeniskasuspenyakit_id:jeniskasuspenyakit_id},
	   dataType: "json",
	   success:function(data){
		   if(data.pesan == 'berhasil'){
				myAlert('Data Kasus Penyakit berhasil di ubah');
				$.fn.yiiGridView.update('daftarPasien-grid', {
					data: $(this).serialize()
				});
		   }else{
			   myAlert('Data Kasus Penyakit gagal di ubah');
		   }	
	   },
	   error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
   });	
   return false;
}

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

function verifikasiTagihanPasien(pendaftaran_id,pasienadmisi_id){
	alert(pendaftaran_id+'-'+pasienadmisi_id);
}

function verifikasiRencanaPulang(pendaftaran_id){
	$.ajax({
	   type:'POST',
	   url:'<?php echo $this->createUrl('VerifikasiRencanaPulang'); ?>',
	   data: {pendaftaran_id:pendaftaran_id},
	   dataType: "json",
	   success:function(data){
		   if(data.status == true){
				if(data.verifikasinull != ''){
					myAlert(data.pesan);
				}else{
					$("#dialogRencanaPulang").dialog("open");
				}
		   }else{
				myConfirm(data.pesan,"Perhatian!",function(r) {
					if(r){
						$("#dialogRencanaPulang").dialog("open");
					}
				});
		   }	
	   },
	   error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
	});	
	
}

function verifikasiPulangPasien(pendaftaran_id){
	$.ajax({
	   type:'POST',
	   url:'<?php echo $this->createUrl('VerifikasiRencanaPulang'); ?>',
	   data: {pendaftaran_id:pendaftaran_id},
	   dataType: "json",
	   success:function(data){
		   if(data.status == true){
				if(data.verifikasinull != ''){
					myAlert(data.pesan);
				}else{
					$("#dialogTindakLanjut").dialog("open");
				}
		   }else{
				myConfirm(data.pesan,"Perhatian!",function(r) {
					if(r){
						$("#dialogTindakLanjut").dialog("open");
					}
				});
		   }	
	   },
	   error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
	});	
	
}


function verifikasiKirimanRM(id, kirimrm) {
    myConfirm('Yakin Anda Menerima Dokumen Pasien? ', 'Perhatian!', function(r){
        if(r){
            $.post('<?php echo $this->createUrl('terimaDokumen');?>', {
                pendaftaran_id:id, pengirimanrm_id:kirimrm
            }, function(data){
                if(data.status == 'proses_form'){
						//$('#dialogStatusDokumen div.divForForm').html(data.div);
						$.fn.yiiGridView.update('daftarPasien-grid');
						//setTimeout("$('#dialogStatusDokumen').dialog('close')",1000);
					}
            }, 'json');
        }else{
             preventDefault();
        }
    });
}
</script>
<?php
$urlSessionMasukKamar = Yii::app()->createUrl('rawatInap/pasienRawatInap/buatSessionMasukKamar ');
$jscript = <<< JS
function buatSessionMasukKamar(masukkamar_id,kelaspelayanan_id, pendaftaran_id)
{
    $.post("${urlSessionMasukKamar}", { masukkamar_id: masukkamar_id,kelaspelayanan_id: kelaspelayanan_id,pendaftaran_id: pendaftaran_id },
        function(data){
            'sukses';
    }, "json");
}
JS;
Yii::app()->clientScript->registerScript('jsPendaftaran',$jscript, CClientScript::POS_BEGIN);
?>
<?php
$url = Yii::app()->createUrl('ActionAjaxRIRD/batalPindahKamar');
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
<?php 
// Dialog untuk Melihat riwayat alergi obat pasien =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogLabelGelang',
    'options' => array(
        'title' => 'Label Gelang Pasien',
        'autoOpen' => false,
        'modal' => true,
        'width' => 640,
        'height' => 280,
        'resizable' => true,
		'close'=>"js:function(){ $.fn.yiiGridView.update('daftarPasien-grid', {
                        data: $('#daftarPasien-form').serialize()
                    }); }",
    ),
));
?>
<iframe name='frameLabelGelang' width="100%" height="100%"></iframe>
<?php $this->endWidget(); ?>