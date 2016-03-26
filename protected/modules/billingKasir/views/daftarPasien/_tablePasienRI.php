<h6>Tabel Pasien <b>Rawat Inap</b></h6>
<?php
    $this->widget('ext.bootstrap.widgets.BootGridView', array(
	'id'=>'pencarianpasien-grid',
	'dataProvider'=>$modRI->searchRI(),
        'template'=>"{summary}\n{items}\n{pager}",
        'itemsCssClass'=>'table table-striped table-condensed',
	'columns'=>array(
                    array(
                        'header'=>'Tgl. Admisi/<br/>Tgl. Pulang Awal',
                        'name'=>'tgl_pulang',
                        'type'=>'raw',
                        'value'=>'$data->combineTglPendaftaran'
                    ),
                    array(
                        'header'=>'No. Pendaftaran/<br/>Tgl. Pendaftaran',
                        'name'=>'no_pendaftaran',
                        'type'=>'raw',
                        'value'=>'$data->no_pendaftaran."<br/>".MyFormatter::formatDateTimeForUser($data->tgl_pendaftaran)',
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
                        'header'=>'Jenis Kelamin/<br/>Umur',
                        'name'=>'umur',
                        'type'=>'raw',
                        'value'=>'$data->jeniskelamin."<br/>".$data->umur',
                    ),
                    array(
                        'name'=>'alamat_pasien',
                        'type'=>'raw',
                        'value'=>'$data->alamat_pasien',
                    ),
                    array(
                        'header'=>'Cara Bayar/<br/>Penjamin',
                        'name'=>'carabayar_nama',
                        'type'=>'raw',
                        'value'=>'$data->carabayar_nama."/<br/>".$data->penjamin_nama',
                    ),
                    array(
                        'header'=>'Ruangan<br/>Kelas Pelayanan',
                        'name'=>'ruangan_nama',
                        'type'=>'raw',
                        'value'=>'$data->ruangan_nama."<br/>".$data->kelaspelayanan_nama',
                    ),
                    /*
                    array(
                        'header'=>'Alias',
                        'name'=>'nama_bin',
                        'type'=>'raw',
                        'value'=>'$data->nama_bin',
                    ), */ /*
                    array(
                        'header'=>'Nama Penjamin',
                        'name'=>'penjamin_nama',
                        'type'=>'raw',
                        'value'=>'$data->penjamin_nama',
                    ), */
                    array(
                        'header'=>'Kamar<br/>No. Bed',
                        'type'=>'raw',
                        'value'=>function($data) {
                            $adm = PasienadmisiT::model()->findByPk($data->pasienadmisi_id);
                            $km = KamarruanganM::model()->findByPk($adm->kamarruangan_id);
                            if (empty($km)) return "-";
                            return $km->kamarruangan_nokamar."<br/>:".$km->kamarruangan_nobed;
                        },
                    ),
                    array(
                        'header'=>'Dokter PJP',
                        'type'=>'raw',
                        'value'=>'$data->gelardepan." ".$data->nama_pegawai.", ".$data->gelarbelakang_nama',
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
//                        'value'=>'CHtml::Link("<i class=\"icon-list-alt\"></i>",Yii::app()->controller->createUrl("RinciantagihanpasienV/rincianBelumBayarRI",array("id"=>$data->pendaftaran_id,"frame"=>true)),
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
                                                },//'(empty($data->pembayaranpelayanan_id) ? "Belum Lunas" : "Sudah Lunas")'
					),	
                                 * 
                                 */	
                    array(
                        'header'=>'Rincian Tagihan',
                        'type'=>'raw',
                        'value'=>'CHtml::Link("<i class=\"icon-form-detailtagihan\"></i>",Yii::app()->controller->createUrl("/billingKasir/pembayaranTagihanPasien/printRincianBelumBayar",array("instalasi_id"=>$data->instalasi_id,"pendaftaran_id"=>$data->pendaftaran_id,"pasienadmisi_id"=>$data->pasienadmisi_id,"frame"=>true)),
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
                        'value'=>'CHtml::Link("<i class=\"icon-form-rtfarmasi\"></i>",Yii::app()->controller->createUrl("RincianTagihanFarmasi/RincianBiayaFarmasiRI",array("id"=>$data->pendaftaran_id,"frame"=>true)),
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

                                    return $sb?CHtml::Link("<i class=\"icon-form-bayar\"></i>",Yii::app()->controller->createUrl("PembayaranTagihanPasien/index",array("instalasi_id"=>Params::INSTALASI_ID_RI,"pendaftaran_id"=>$data->pendaftaran_id,"pasienadmisi_id"=>$data->pasienadmisi_id,"frame"=>true)),
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