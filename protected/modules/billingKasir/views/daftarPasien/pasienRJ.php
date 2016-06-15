<div class="white-container">
    <legend class="rim2">Informasi Pasien <b>Rawat Jalan</b></legend>
    <?php
    $this->breadcrumbs=array(
            'Daftar Pasien'=>array('/billingKasir/daftarPasien'),
            'PasienRJ',
    );?>
    <?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
            'id'=>'caripasien-form',
            'enableAjaxValidation'=>false,
                    'type'=>'horizontal',
                    'focus'=>'#',
                    'method'=>'GET',
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
        <h6>Tabel Pasien <b>Rawat Jalan</b></h6>
        <?php
            $this->widget('ext.bootstrap.widgets.HeaderGroupGridView', array(
                'id'=>'pencarianpasien-grid',
                'dataProvider'=>$modRJ->searchRJ(),
                'template'=>"{summary}\n{items}\n{pager}",
                'itemsCssClass'=>'table table-striped table-condensed',
                /*
                'mergeHeaders'=>array(
                    array(
                        'name'=>'<center>Penjamin</center>',
                        'start'=>5,
                        'end'=>6,
                    ),
                ),
                 * 
                 */
                'columns'=>array(
                            array(
                                'header'=>'Tgl. Pendaftaran/<br/>No. Pendaftaran',
                                'name'=>'tgl_pendaftaran',
                                'type'=>'raw',
                                'value'=>'$data->Tanggal."/<br/>".$data->no_pendaftaran',
                                'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:left;'),
                            ),
                            /*
                            array(
                                'header'=>'Nama Instalasi',
                                'name'=>'instalasi_nama',
                                'type'=>'raw',
                                'value'=>'$data->instalasi_nama',
                                'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:left;'),
                            ),
                             * 
                             *//*
                            array(
                                'name'=>'no_pendaftaran',
                                'type'=>'raw',
                                'value'=>'$data->no_pendaftaran',
                                'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:left;'),
                            ), */
                            array(
                                'name'=>'no_rekam_medik',
                                'type'=>'raw',
                                'value'=>'$data->no_rekam_medik',
                                'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:left;'),
                            ),
                            array(
                                'header'=>'Nama',
                                'name'=>'nama_pasien',
                                'type'=>'raw',
                                'value'=>'$data->namadepan.$data->nama_pasien',
                                'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:left;'),
                            ),
                            array(
                                'name'=>'umur',
                                'type'=>'raw',
                                'value'=>'$data->umur',
                                'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:left;'),
                            ),
                            array(
                                'header'=>'Jenis Kasus Penyakit',
                                'name'=>'jeniskasuspenyakit_nama',
                                'type'=>'raw',
                                'value'=>'$data->jeniskasuspenyakit_nama',
                                'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:left;'),
                            ),
                            array(
                                'header'=>'Alamat',
                                'name'=>'alamat_pasien',
                                'type'=>'raw',
                                'value'=>'$data->alamat_pasien',
                                'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:left;'),
                            ), 
                            array(
                                'header'=>'Poliklinik/<br/>Dokter',
                                'name'=>'ruangan_nama',
                                'type'=>'raw',
                                'value'=>'$data->ruangan_nama."/<br/>".$data->gelardepan.$data->nama_pegawai.", ".$data->gelarbelakang_nama',
                            ),
                            /*
                            array(
                                'header'=>'Nama Panggilan',
                                'name'=>'nama_bin',
                                'type'=>'raw',
                                'value'=>'$data->nama_bin',
                                'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:left;')
                            ), */
                            array(
                                'header'=>'Cara Bayar/<br/>Penjamin',
                                'name'=>'carabayar_nama',
                                'type'=>'raw',
                                'value'=>'$data->carabayar_nama."/<br/>".$data->penjamin_nama',
                                'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:left;')
                            ), /*
                            array(
                                'header'=>'Penjamin',
                                'name'=>'penjamin_nama',
                                'type'=>'raw',
                                'value'=>'$data->penjamin_nama',
                                'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:left;')
                            ), */
                            array(
                                'header'=>'Penanggung',
                                'name'=>'nama_pj',
                                'type'=>'raw',
                                'value'=>'isset($data->nama_pj) ? CHtml::Link($data->nama_pj,Yii::app()->controller->createUrl("DaftarPasien/informasiPenanggung",array("id"=>$data->no_pendaftaran,"frame"=>true)),array("class"=>"", "target"=>"iframeInformasiPenanggung", "onclick"=>"$(\"#dialogInformasiPenanggung\").dialog(\"open\");","rel"=>"tooltip", "title"=>"Klik untuk melihat Informasi Penanggung Jawab",)) : "-"',
                                'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:left;'),
                            ),/*
                            array(
                                'header'=>'Nama Instalasi<br/> /<br/> Ruangan',
                                'name'=>'instalasi_nama',
                                'type'=>'raw',
                                'value'=>'$data->instalasi_nama." / <br/> ".$data->ruangan_nama',
                            ), */
                      array(
                          'header'=>'Status Periksa',
                            'type'=>'raw',
                          'value'=>'$data->statusperiksa',
                          'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:left;'),
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
                                    if (!empty($item->penjualanresep_id) && $item->penjamin_id == Params::PENJAMIN_ID_UMUM)
                                        continue;
                                    
                                    $total += $item->qty_oa * $item->hargasatuan_oa;
                                }
                                return "Rp".MyFormatter::formatNumberForPrint($total);
                            },
                            'htmlOptions'=>array(
                                'style'=>'text-align: right',
                            )
                        ),
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
                            }//'(empty($data->pembayaranpelayanan_id) ? "Belum Lunas" : "Sudah Lunas")'
                        ),
                     * 
                     */
        //                    array(
        //                        'header'=>'Rincian Tagihan',
        //                        'type'=>'raw',
        //                        'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:left;'),
        //                        'value'=>'CHtml::Link("<i class=\"icon-list-alt\"></i>",Yii::app()->controller->createUrl("RinciantagihanpasienV/rincianBelumBayar",array("id"=>$data->pendaftaran_id,"frame"=>true)),
        //                                    array("class"=>"", 
        //                                          "target"=>"iframeRincianTagihan",
        //                                          "onclick"=>"$(\"#dialogRincianTagihan\").dialog(\"open\");",
        //                                          "rel"=>"tooltip",
        //                                          "title"=>"Klik untuk melihat Rincian Tagihan",
        //                                    ))',          'htmlOptions'=>array('style'=>'text-align: left; width:40px')
        //                    ),
                            array(
                                'header'=>'Rincian Tagihan',
                                'type'=>'raw',
                                'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:left;'),
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
                                'htmlOptions'=>array(
                                    'style'=>'text-align: rcenter',
                                ),
                                'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:left;'),
                                'value'=>'($data->penjamin_id == 1)?"-":'.
                                    'CHtml::Link("<i class=\"icon-form-rtfarmasi\"></i>",Yii::app()->controller->createUrl("RincianTagihanFarmasi/RincianBiayaFarmasi",array("id"=>$data->pendaftaran_id,"frame"=>true)),
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
                                'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:left;'),
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
                                    $oa = ObatalkespasienT::model()->findAllByAttributes(array(
                                        'pendaftaran_id'=>$data->pendaftaran_id,
                                    ), array('condition'=>'oasudahbayar_id is null '));
                                    
                                    $of = ObatalkespasienT::model()->findAllByAttributes(array(
                                        'pendaftaran_id'=>$data->pendaftaran_id,
                                    ), array('condition'=>'penjualanresep_id is not null and penjamin_id = '.Params::PENJAMIN_ID_UMUM));
 
                                    foreach ($oa as $idx=>$val) {
                                        if (in_array($val, $of)) {
                                            unset($oa[$idx]);
                                        }
                                    }
                                    
                                    $sb = count($oa) > 0 || !empty($tindakan);

                                    return $sb?CHtml::Link("<i class=\"icon-form-bayar\"></i>",Yii::app()->controller->createUrl("PembayaranTagihanPasien/index",array("instalasi_id"=>Params::INSTALASI_ID_RJ,"pendaftaran_id"=>$data->pendaftaran_id,"frame"=>true)),
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
        <?php echo $this->renderPartial('_formKriteriaPencarian', array('model'=>$modRJ,'form'=>$form,'format'=>$format),true);  ?> 
        <div class="form-actions">
            <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="icon-search icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit')); ?>
            <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Reset',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')),array('class'=>'btn btn-danger', 'type'=>'reset')); ?>
            <?php  
                $content = $this->renderPartial('tips/informasi',array(),true);
                $this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); 
            ?>
        </div>

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
<iframe src="" name="iframePembayaran" width="100%" height="550">
</iframe>
<?php
$this->endWidget();
?>

<?php 
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( 
    'id'=>'dialogRincianTagihan',
    'options'=>array(
        'title'=>'Rincian Tagihan',
        'autoOpen'=>false,
        'modal'=>true,
        'zIndex'=>1001,
        'minWidth'=>1024,
        'minHeight'=>400,
        'resizable'=>true,
    ),
));
?>
<iframe src="" name="iframeRincianTagihan" width="100%" height="550" >
</iframe>
<?php
$this->endWidget();
?>

<?php 
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( 
    'id'=>'dialogInformasiPenanggung',
    'options'=>array(
        'title'=>'Informasi Penanggung',
        'autoOpen'=>false,
        'modal'=>true,
        'minWidth'=>350,
        'zIndex'=>1001,
        'minHeight'=>200,
        'resizable'=>true,
    ),
));
?>
<iframe src="" name="iframeInformasiPenanggung" width="100%" height="200" ></iframe>
<?php
$this->endWidget();
?>