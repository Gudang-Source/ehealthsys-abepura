<div class="white-container">
    <legend class="rim2">Informasi Pasien <b>Rawat Darurat</b></legend>
    <?php
    $this->breadcrumbs=array(
            'Daftar Pasien'=>array('/billingKasir/daftarPasien'),
            'PasienRD',
    );?>
    <?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
            'id'=>'caripasien-form',
            'enableAjaxValidation'=>false,
                    'type'=>'horizontal',
                    'focus'=>'#',
                    'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event)'),
    ));

    Yii::app()->clientScript->registerScript('cariPasien', "
    $('#caripasien-form').submit(function(){
            $.fn.yiiGridView.update('pencarianpasien-grid', {
                    data: $(this).serialize()
            });
            return false;
    });
    ");
    ?>
    <div class="block-tabel">
        <h6>Tabel Pasien <b>Rawat Darurat</b></h6>
        <?php
            $this->widget('ext.bootstrap.widgets.BootGridView', array(
                'id'=>'pencarianpasien-grid',
                'dataProvider'=>$modRD->searchRD(),
                'template'=>"{summary}\n{items}\n{pager}",
                'itemsCssClass'=>'table table-striped table-condensed',
                'columns'=>array(
                            array(
                                'header'=>'Tgl. Pendaftaran/<br/>No. Pendaftaran',
                                'name'=>'tgl_pendaftaran',
                                'type'=>'raw',
                                'value'=>'MyFormatter::formatDateTimeForUser($data->tgl_pendaftaran)."<br/>".$data->no_pendaftaran',
                            ),
                            array(
                                'header'=>'Tgl. Pulang',
                                'type'=>'raw',
                                'name'=>'tglpasienpulang',
                                'value'=>'MyFormatter::formatDateTimeForUser($data->tglpasienpulang)'
                            ),
                            array(
                                'header'=>'Cara Pulang / <br/> Kondisi Pulang',
                                'name'=>'instalasi_nama',
                                'type'=>'raw',
                                'value'=>'$data->carakeluar." / <br/> ".$data->kondisipulang',
                            ),
                            array(
                                'name'=>'no_rekam_medik',
                                'type'=>'raw',
                                'value'=>'$data->no_rekam_medik',
                            ),
                            array(
                                'name'=>'nama_pasien',
                                'type'=>'raw',
                                'value'=>'$data->namadepan.$data->nama_pasien',
                            ),
                            array(
                                'name'=>'umur',
                                'type'=>'raw',
                                'value'=>'$data->umur',
                            ),
                            array(
                                'name'=>'alamat_pasien',
                                'type'=>'raw',
                                'value'=>'$data->alamat_pasien',
                            ),
                            array(
                                'header'=>'Nama Jenis Kasus Penyakit',
                                'name'=>'jeniskasuspenyakit_nama',
                                'type'=>'raw',
                                'value'=>'$data->jeniskasuspenyakit_nama',
                            ),
                            array(
                                'header'=>'Ruangan',
                                'name'=>'ruangan_nama',
                                'type'=>'raw',
                                'value'=>'$data->ruangan_nama',
                            ),
                            array(
                                'header'=>'Cara Bayar/<br/>Penjamin',
                                'name'=>'carabayar_nama',
                                'type'=>'raw',
                                'value'=>'$data->carabayar_nama."/<br/>".$data->penjamin_nama',
                            ),
                            array(
                                'header'=>'Dokter',
                                'type'=>'raw',
                                'value'=>'$data->gelardepan." ".$data->nama_pegawai.", ".$data->gelarbelakang_nama',
                            ),
                    /*
                            array(
                                'name'=>'nama_bin',
                                'type'=>'raw',
                                'value'=>'$data->nama_bin',
                            ),
                             * 
                             */  /*
                            array(
                                'header'=>'Nama Penjamin',
                                'name'=>'penjamin_nama',
                                'type'=>'raw',
                                'value'=>'$data->penjamin_nama',
                            ), */
                     array(
                          'header'=>'Status Periksa',
                          'name'=>'statusperiksa',
                          'type'=>'raw',
                          'value'=>'$data->statusperiksa',

                        ),
                        array(
                            'header'=>'Total Tagihan',
                            'type'=>'raw',
                            'value'=>function($data) {
                                $total = 0;
                                $tindakan = TindakanpelayananT::model()->findAllByAttributes(array(
                                        'pendaftaran_id'=>$data->pendaftaran_id,
                                ), array('condition'=>'tindakansudahbayar_id is null'));
                                $oa = ObatalkespasienT::model()->findAllByAttributes(array(
                                    'pendaftaran_id'=>$data->pendaftaran_id,
                                ), array('condition'=>'oasudahbayar_id is null'));
                                
                                foreach ($tindakan as $item) {
                                    $total += $item->tarif_satuan * $item->qty_tindakan;
                                }
                                foreach ($oa as $item) {
                                    $total += $item->qty_oa * $item->hargasatuan_oa;
                                }
                                return "Rp".MyFormatter::formatNumberForPrint($total);
                            },
                            'htmlOptions'=>array(
                                'style'=>'text-align: right',
                            )
                        ),
        //                    array(
        //                        'header'=>'Rincian Tagihan',
        //                        'type'=>'raw',
        //                        'value'=>'CHtml::Link("<i class=\"icon-list-alt\"></i>",Yii::app()->controller->createUrl("RinciantagihanpasienV/RincianBelumBayarRD",array("id"=>$data->pendaftaran_id,"frame"=>true)),
        //                                    array("class"=>"", 
        //                                          "target"=>"iframeRincianTagihan",
        //                                          "onclick"=>"$(\"#dialogRincianTagihan\").dialog(\"open\");",
        //                                          "rel"=>"tooltip",
        //                                          "title"=>"Klik untuk melihat Rincian Tagihan",
        //                                    ))',          'htmlOptions'=>array('style'=>'text-align: left; width:40px')
        //                    ),
                    /*
							array(
								'header'=>'Status Pembayaran',
								'type'=>'raw',
								'value'=>function($data) use (&$sb) {
                                                                    $tindakan = TindakanpelayananT::model()->findByAttributes(array(
                                                                        'pendaftaran_id'=>$data->pendaftaran_id,
                                                                    ), array('condition'=>'tindakansudahbayar_id is null'));
                                                                    $oa = ObatalkespasienT::model()->findByAttributes(array(
                                                                        'pendaftaran_id'=>$data->pendaftaran_id,
                                                                    ), array('condition'=>'oasudahbayar_id is null'));

                                                                    $sb = !empty($oa) || !empty($tindakan);

                                                                    return $sb?"Belum Lunas":"Sudah Lunas";
                                                                }, //'(empty($data->pembayaranpelayanan_id) ? "Belum Lunas" : "Sudah Lunas")'
	                        ),
                     * 
                     */					
                            array(
                                'header'=>'Rincian Tagihan',
                                'type'=>'raw',
                                'value'=>'CHtml::Link("<i class=\"icon-form-detailtagihan\"></i>",Yii::app()->controller->createUrl("/billingKasir/pembayaranTagihanPasien/printRincianBelumBayar",array("instalasi_id"=>$data->instalasi_id,"pendaftaran_id"=>$data->pendaftaran_id,"pasienadmisi_id"=>"","frame"=>true)),
                                            array("class"=>"", 
                                                  "target"=>"iframeRincianTagihan",
                                                  "onclick"=>"$(\"#dialogRincianTagihan\").dialog(\"open\");",
                                                  "rel"=>"tooltip",
                                                  "title"=>"Klik untuk melihat Rincian Tagihan",
                                            ))',          'htmlOptions'=>array('style'=>'text-align: left; width:40px')
                            ),
                            array(
                                'header'=>'Rincian Tagihan Farmasi',
                                'type'=>'raw',
                                'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:left;'),
                                'value'=>'CHtml::Link("<i class=\"icon-form-rtfarmasi\"></i>",Yii::app()->controller->createUrl("RincianTagihanFarmasi/RincianBiayaFarmasiRD",array("id"=>$data->pendaftaran_id,"frame"=>true)),
                                            array("class"=>"", 
                                                  "target"=>"iframeRincianTagihan",
                                                  "onclick"=>"$(\"#dialogRincianTagihan\").dialog(\"open\");",
                                                  "rel"=>"tooltip",
                                                  "title"=>"Klik untuk melihat Rincian Tagihan Farmasi",
                                            ))',          'htmlOptions'=>array('style'=>'text-align: left; width:40px')
                            ),
                            array(
                                'header'=>'Pembayaran Kasir',
                                'type'=>'raw',
                                'value'=>function($data) use (&$sb) {
                                    // return $data->total_belum." : ".$data->total_oa_belum;
                                    $td = TindakanpelayananT::model()->findByAttributes(array(
                                        'pendaftaran_id'=>$data->pendaftaran_id,
                                    ));
                                    $oa = ObatalkespasienT::model()->findByAttributes(array(
                                        'pendaftaran_id'=>$data->pendaftaran_id,
                                    ));
                                    if (empty($td) && empty($oa)) return "BELUM ADA TRANSAKSI";
                                    
                                    $tindakan = TindakanpelayananT::model()->findByAttributes(array(
                                        'pendaftaran_id'=>$data->pendaftaran_id,
                                    ), array('condition'=>'tindakansudahbayar_id is null'));
                                    $oa = ObatalkespasienT::model()->findByAttributes(array(
                                        'pendaftaran_id'=>$data->pendaftaran_id,
                                    ), array('condition'=>'oasudahbayar_id is null'));

                                    $sb = !empty($oa) || !empty($tindakan);

                                    return $sb?CHtml::Link("<i class=\"icon-form-bayar\"></i>",Yii::app()->controller->createUrl("PembayaranTagihanPasien/index",array("instalasi_id"=>Params::INSTALASI_ID_RD,"pendaftaran_id"=>$data->pendaftaran_id,"frame"=>true)),
                                            array("class"=>"", 
                                                  "target"=>"iframePembayaran",
                                                  "onclick"=>"$(\"#dialogPembayaranKasir\").dialog(\"open\");",
                                                  "rel"=>"tooltip",
                                                  "title"=>"Klik untuk membayar ke kasir",
                                            )):"SUDAH<br/>LUNAS";
                                },
                                'htmlOptions'=>array('style'=>'text-align: left; width:40px')
                            ),
                    ),
                'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
            ));
        ?>
    </div>
    <fieldset class="box">
        <?php echo $this->renderPartial('_formKriteriaPencarianRD', array('model'=>$modRD,'form'=>$form,'format'=>$format),true);  ?> 
        <div class="form-actions">
            <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="icon-search icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit')); ?>
            <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Reset',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')),array('class'=>'btn btn-danger', 'type'=>'reset')); ?>
            <?php  
            $content = $this->renderPartial('tips/informasi',array(),true);
            $this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); 
            ?>
        </div>
    </fieldset>
    <?php $this->endWidget(); ?>
    <?php 
    $this->beginWidget('zii.widgets.jui.CJuiDialog', array( 
        'id'=>'dialogPembayaranKasir',
        'options'=>array(
            'title'=>'Pembayaran Kasir',
            'autoOpen'=>false,
            'modal'=>true,
            'zIndex'=>1001,
            'minWidth'=>1124,
            'minHeight'=>510,
            'resizable'=>true,
            'close'=>"js:function(){ $.fn.yiiGridView.update('pencarianpasien-grid', {
                            data: $('#caripasien-form').serialize()
                        }); }",
        ),
    ));
    ?>
    <iframe src="" name="iframePembayaran" width="100%" height="550" >
    </iframe>
    <?php
    $this->endWidget();
    ?>
</div>

<?php 
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( 
    'id'=>'dialogRincianTagihan',
    'options'=>array(
        'title'=>'Rincian Tagihan',
        'autoOpen'=>false,
        'modal'=>true,
        'zIndex'=>1001,
        'minWidth'=>1024,
        'minHeight'=>510,
        'resizable'=>true,
    ),
));
?>
<iframe src="" name="iframeRincianTagihan" width="100%" height="500" >
</iframe>
<?php
$this->endWidget();
?>