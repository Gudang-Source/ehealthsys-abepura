<h6>Tabel Pasien <b>Rawat Inap</b></h6>
<?php
    $this->widget('ext.bootstrap.widgets.BootGridView', array(
	'id'=>'pencarianpasien-grid',
	'dataProvider'=>$modRI->searchRI(),
        'template'=>"{summary}\n{items}\n{pager}",
        'itemsCssClass'=>'table table-striped table-condensed',
	'columns'=>array(
                    array(
                        'header'=>'Tanggal Admisi/ Tanggal Pulang Awal',
                        'name'=>'tgl_pulang',
                        'type'=>'raw',
                        'value'=>'$data->combineTglPendaftaran'
                    ),
                    array(
                        'header'=>'Nama Instalasi<br/> /<br/> Ruangan',
                        'name'=>'instalasi_nama',
                        'type'=>'raw',
                        'value'=>'$data->instalasi_nama." / <br/> ".$data->ruangan_nama',
                    ),
                    array(
                        'header'=>'No. Pendaftaran',
                        'name'=>'no_pendaftaran',
                        'type'=>'raw',
                        'value'=>'$data->no_pendaftaran',
                    ),
                    array(
                        'name'=>'no_rekam_medik',
                        'type'=>'raw',
                        'value'=>'$data->no_rekam_medik',
                    ),
                    array(
                        'name'=>'nama_pasien',
                        'type'=>'raw',
                        'value'=>'$data->nama_pasien',
                    ),
                    array(
                        'header'=>'Alias',
                        'name'=>'nama_bin',
                        'type'=>'raw',
                        'value'=>'$data->nama_bin',
                    ),
                    array(
                        'header'=>'Cara Bayar',
                        'name'=>'carabayar_nama',
                        'type'=>'raw',
                        'value'=>'$data->carabayar_nama',
                    ),
                    array(
                        'header'=>'Nama Penjamin',
                        'name'=>'penjamin_nama',
                        'type'=>'raw',
                        'value'=>'$data->penjamin_nama',
                    ),
                    array(
                        'header'=>'Nama Jenis Kasus Penyakit',
                        'name'=>'jeniskasuspenyakit_nama',
                        'type'=>'raw',
                        'value'=>'$data->jeniskasuspenyakit_nama',
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
					array(
						'header'=>'Status Pembayaran',
						'type'=>'raw',
						'value'=>'(empty($data->pembayaranpelayanan_id) ? "Belum Lunas" : "Sudah Lunas")'
					),		
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
                        'value'=>'CHtml::Link("<i class=\"icon-form-bayar\"></i>",Yii::app()->controller->createUrl("PembayaranTagihanPasien/index",array("instalasi_id"=>Params::INSTALASI_ID_RI,"pendaftaran_id"=>$data->pendaftaran_id,"pasienadmisi_id"=>$data->pasienadmisi_id,"frame"=>true)),
                                    array("class"=>"", 
                                          "target"=>"iframePembayaran",
                                          "onclick"=>"$(\"#dialogPembayaranKasir\").dialog(\"open\");",
                                          "rel"=>"tooltip",
                                          "title"=>"Klik untuk membayar ke kasir",
                                    ))',          'htmlOptions'=>array('style'=>'text-align: left; width:40px')
                    ),
            ),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
    ));
?>