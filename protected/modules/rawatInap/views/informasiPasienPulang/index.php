<div class="white-container">
    <legend class="rim2">Informasi <b>Pasien Pulang</b></legend>
    <?php
     $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
     $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai

    Yii::app()->clientScript->registerScript('cari wew', "
    $('#daftarPasienPulang-form').submit(function(){
            $('#daftarPasienPulang-grid').addClass('animation-loading');
            $.fn.yiiGridView.update('daftarPasienPulang-grid', {
                    data: $(this).serialize()
            });
            return false;
    });
    ");
    ?>
    <div class="block-tabel">
        <h6>Tabel <b>Pasien Pulang</b></h6>
        <?php $this->widget('ext.bootstrap.widgets.BootGridView',array(
                'id'=>'daftarPasienPulang-grid',
                'dataProvider'=>$modPasienYangPulang->searchRI(),
                'template'=>"{summary}\n{items}\n{pager}",
                'itemsCssClass'=>'table table-striped table-condensed',
                'columns'=>array(
        //                'tglpasienpulang',
                        array(
                            'header'=>'Tanggal Pulang',
                            'value'=>'$data->tglpasienpulang',
                        ),
                        array(
                            'header'=>'Tanggal Masuk/ <br/>No Masuk',
                            'type' => 'raw',
                            'value'=>'$data->tglmasukkamar."/ <br/>".$data->nomasukkamar',
                        ),                                               
        //                'lamadirawat_kamar',
                        
        //                'tgladmisi',
                        array(
                            'header'=>'Tanggal Pendaftaran/ <br/> No. Pendaftaran',
                            'type'=>'raw',
                            'value'=>'$data->tgl_pendaftaran."/ <br/>".$data->no_pendaftaran'
                        ),
                        array(
                            'header'=>'No Rekam Medik',
                            'type'=>'raw',
                            'value'=>'$data->no_rekam_medik'
                        ), 
                        array(
                            'header'=>'Nama Pasien',
                            'type'=>'raw',
                            'value'=>'$data->namadepan." ".$data->nama_pasien'
                        ),    
                        array(
                            'header' => 'Kamar/ <br/> No Bed',
                            'type'=>'raw',
                            'value'=>'$data->kamarruangan_nokamar."/ <br/>".$data->kamarruangan_nobed'
                        ),
        //                'umur',
        //                 array(
        //                       'header'=>'Cara Bayar/ Penjamin',
        //                        'type'=>'raw',
        //                        'value'=>'$data->CaraBayardanPenjamin'
        //                    ),
                        array(
                            'header'=>'Kelas Pelayanan',
                            'type'=>'raw',
                            'value'=>'$data->kelaspelayanan_nama'
                        ),   
                        array(
                            'header'=>'Kasus Penyakit',
                            'value'=>'$data->jeniskasuspenyakit_nama',
                        ),
                        array(
                            'header'=>'Dokter PJP',
                            'value'=>'$data->gelardepan." ".$data->nama_pegawai." ".$data->gelarbelakang_nama' ,
                        ),
                        array(
                            'header'=>'Lama Dirawat',
                            'type' => 'raw',
                            'value'=>'$data->lamadirawat_kamar',
                        ),
                        
                        
                        array(
                            'header'=>'Cara/ Kondisi Pulang',
                            'type'=>'raw',
                            'value'=>'$data->CaradanKondisiPulang'
                        ), 
        //                'jeniskasuspenyakit_nama',

        //                array(
        //                       'header'=>'Batal Pulang',
        //                       'type'=>'raw',
        //                       'value'=>'CHtml::link("<i class=\'icon-list-alt\'></i> ","javascript:cekHakAkses($data->pasienpulang_id,$data->pasienadmisi_id,$data->pasien_id,$data->pendaftaran_id)" ,array("title"=>"Klik Untuk Membatalkan Kepulangan"))',
        //                    ),
                        array(
                            'header'=>'Rincian',
                            'type'=>'raw',
                            'value'=>'CHtml::link("<icon class=\'icon-form-detail\'></idcon>", Yii::app()->createUrl("billingKasir/RinciantagihanpasienV/rincianBelumBayarRI", array("id"=>$data->pendaftaran_id)), array("rel"=>"tooltip","title"=>"Lihat Rincian Pasien Pulang","target"=>"frameRincian", "onclick"=>"$(\'#dialogRincian\').dialog(\'open\');"))',
                            'htmlOptions'=>array('style'=>'text-align:left;'),
                        ),  
                        array(
                               'header'=>'Batal Pulang',
                               'type'=>'raw',
                               'value'=>'CHtml::link("<i class=\'icon-form-silang\'></i>", 
                                   Yii::app()->controller->createUrl("'.Yii::app()->controller->id.'/batalPulang",array("pendaftaran_id"=>$data->pendaftaran_id)),
                                       array("title"=>"Klik untuk Batal Pulang", "target"=>"iframeBatalPulang", "onclick"=>"$(\"#dialogBatalPulang\").dialog(\"open\");", "rel"=>"tooltip"))',
                               'htmlOptions'=>array('style'=>'text-align:left; width:40px'),
                            ),
                        

                ),
                'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
        ));
        echo CHtml::hiddenField('pasien_id','',array('readonly'=>TRUE));
        echo CHtml::hiddenField('pendaftaran_id','',array('readonly'=>TRUE));
        ?>
    </div>
    <?php echo $this->renderPartial('_formPencarian', array('modPasienYangPulang'=>$modPasienYangPulang)); ?>
    <?php 
    // Dialog untuk batal Rawat Inap =========================
    $this->beginWidget('zii.widgets.jui.CJuiDialog', array( 
        'id'=>'dialogBatalPulang',
        'options'=>array(
            'title'=>'Pembatalan Pulang Pasien',
            'autoOpen'=>false,
            'modal'=>true,
            'minWidth'=>800,
            'minHeight'=>500,
            'resizable'=>true,
        ),
    ));
    ?>
    <iframe src="" name="iframeBatalPulang" width="100%" height="550">
    </iframe>
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
</div>