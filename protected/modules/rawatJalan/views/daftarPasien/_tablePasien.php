<h6>Tabel Pasien <b>Rawat Jalan </b><?php // echo CHtml::htmlButton(Yii::t('mds','{icon}',array('{icon}'=>'<i class="icon-volume-up icon-white"></i>')),array('title'=>'Klik untuk memanggil antrian terakhir','rel'=>'tooltip','class'=>'btn  btn-mini btn-primary', 'onclick'=>'ambilAntrianTerakhir();','style'=>'font-size:10px;')); ?></h6>
<?php $this->widget('ext.bootstrap.widgets.BootGridView',array(
    'id'=>'daftarpasien-v-grid',
    'dataProvider'=>$model->searchDaftarPasien(),
        'template'=>"{summary}\n{items}\n{pager}",
        'itemsCssClass'=>'table table-striped table-condensed',
    'columns'=>array(   
                array(
                    'name'=>'no_urutantri',
                    'type'=>'raw',
                    'header'=>'No. Antrian <br>/ Panggil Antrian',
                    'value'=>function($data) use (&$admisi) {
                        $admisi = PasienadmisiT::model()->findByAttributes(array('pendaftaran_id'=>$data->pendaftaran_id));
                        return $data->ruangan_singkatan."-".$data->no_urutantri."<br>".($data->statusperiksa != Params::STATUSPERIKSA_ANTRIAN?"":CHtml::htmlButton(Yii::t("mds","{icon}",array("{icon}"=>"<i class='icon-volume-up icon-white'></i>")),array("class"=>"btn btn-primary","onclick"=>"panggilAntrian('".$data->pendaftaran_id."'); setSuaraPanggilanSingle('".$data->ruangan_singkatan."','".$data->no_urutantri."','".$data->ruangan_id."')","rel"=>"tooltip","title"=>"Klik untuk memanggil pasien ini")));
                    },
                ),
				array(
                                        'header'=>'Tgl Pendaftaran/<br/>No Pendaftaran',
					'name'=>'tgl_pendaftaran',
					'type'=>'raw',
					'value'=>'MyFormatter::formatDateTimeForUser($data->tgl_pendaftaran)."<br/>".$data->no_pendaftaran',
				),
                array(
                    'name'=>'No_rekam_medik',
                    'type'=>'raw',
                    'value'=>'$data->no_rekam_medik',
                ),
                array(
                    'name'=>'nama_pasien',
                    'type'=>'raw',
                    'value'=>'$data->namadepan." ".$data->nama_pasien',
                ),
                array(
                    'name'=>'alamat_pasien',
                    'type'=>'raw',
                    'value'=>'$data->alamat_pasien',
                ),
                array(
                    'name'=>'Cara Bayar'.'/<br/>'.'Penjamin',
                    'type'=>'raw',
                    'value'=>'"$data->carabayar_nama"."<br/>"."$data->penjamin_nama"',
                ),
                array(
                    'header'=>'Dokter',
                    'type'=>'raw',
                    'value'=>function($data) use (&$admisi) {
                        if (!empty($admisi)) return $data->gelardepan." ".$data->nama_pegawai." ".$data->gelarbelakang_nama;
                        return CHtml::link("<i class=icon-pencil-brown></i> ". $data->gelardepan." ".$data->nama_pegawai." ".$data->gelarbelakang_nama," ",array("onclick"=>"ubahDokterPeriksa('$data->pendaftaran_id');$('#editDokterPeriksa').dialog('open');return false;", "rel"=>"tooltip","rel"=>"tooltip","title"=>"Klik Untuk Mengubah Data Dokter Periksa"));
                    },
                    'htmlOptions'=>array(
                       'style'=>'text-align:center;',
                       'class'=>'rajal'
                   )
                ),                
                array(
                    'header'=>'Kasus Penyakit ',
                    'type'=>'raw',
                    'value'=>'CHtml::hiddenField("RJInfokunjunganrV[$data->pendaftaran_id][pendaftaran_id]", $data->pendaftaran_id, array("id"=>"pendaftaran_id","onkeypress"=>"return $(this).focusNextInputField(event)","class"=>"span3"))."".$data->jeniskasuspenyakit_nama',
                ),
                array(
                    'header'=>'Status Periksa',
                    'type'=>'raw',
                    'value'=>'$data->getStatus($data->statusperiksa,$data->pendaftaran_id,$data)',
                ),
                array(
                    'name'=>'Periksa Pasien',
                    'type'=>'raw',
                    'value'=>'$data->linkPeriksaPasien',
                    //'value'=>'(($data->alihstatus==FALSE) ? CHtml::link("<i class=\'icon-form-periksa\'></i> ", Yii::app()->controller->createUrl("/rawatJalan/pemeriksaanPasien",array("pendaftaran_id"=>$data->pendaftaran_id)),array("id"=>"$data->no_pendaftaran","rel"=>"tooltip","title"=>"Klik untuk Pemeriksaan Pasien")): CHtml::link("<i class=\'icon-list-alt\'></i>", "javascript:cektindaklanjut()",array("rel"=>"tooltip","title"=>"Klik untuk Pemeriksaan Pasien")))',
                    'htmlOptions'=>array('style'=>'text-align: center; width:60px')
		),
                array(
                    'name'=>'Alergi Obat',
                    'type'=>'raw',
                    'value'=>'CHtml::link("<i class=\'icon-form-riwayatperiksa\'></i> ", Yii::app()->controller->createUrl("/rawatJalan/daftarPasien/alergiObat",array("pendaftaran_id"=>$data->pendaftaran_id)),
							array("id"=>"$data->no_pendaftaran",
								"rel"=>"tooltip",
								"title"=>"Klik untuk melihat riwayat alergi obat pasien",
								"target"=>"frameAlergiObat",
								"onclick"=>"$(\'#dialogAlergiObat\').dialog(\'open\');"
								))',
					'htmlOptions'=>array('style'=>'text-align: center; width:60px')
				),
                array(
                        'header'=>'Tindak Lanjut<br/>ke Rawat Inap',
                        'type'=>'raw',
                        'value'=>function($data) {
                            $admisi = PasienadmisiT::model()->findByAttributes(array('pendaftaran_id'=>$data->pendaftaran_id));
                            $ruangan = empty($admisi->ruangan_id)?"":$admisi->ruangan->ruangan_nama;
                            $kamar = empty($admisi->kamarruangan_id)?"":$admisi->kamarruangan->kamarruangan_nokamar.":".$admisi->kamarruangan->kamarruangan_nobed;
                            $pulang = PasienpulangT::model()->findByAttributes(array(
                                'pendaftaran_id'=>$data->pendaftaran_id,
                                'carakeluar_id'=>Params::CARAKELUAR_ID_RAWATINAP,
                            ), array(
                                'condition'=>'pasienbatalpulang_id is null'
                            ));
                            return (!empty($pulang) || !empty($admisi)) ? 
                                (
                                (!empty($admisi)?$ruangan."<br/>".$kamar:"DIRAWAT INAP".CHtml::link("<i class='icon-form-silang'></i>", Yii::app()->controller->createUrl("/".Yii::app()->controller->module->id."/".Yii::app()->controller->id."/BatalRawatInap",array("pendaftaran_id"=>$data->pendaftaran_id)) , array("title"=>"Klik Untuk Batal Proses Tindak Lanjut Pasien","target"=>"iframeBatalRawatInap", "onclick"=>"$('#dialogBatalRawatInap').dialog('open');", "rel"=>"tooltip"))))
                                :  
                                CHtml::link("<i class='icon-form-ri'></i>", "#",
                                        array("class"=>"",
                                        "target"=>"frameTindakLanjut",
                                        "rel"=>"tooltip",
                                        "title"=>"Klik untuk Proses Tindak Lanjut Pasien",
                                        "onclick"=>"tindaklanjutrawatjalan(".$data->pendaftaran_id.")"));
                        },
                        'htmlOptions'=>array('style'=>'text-align: center; width:60px')
                        ),
                array(
                    'header'=>'Rencana Kontrol',
                    'type'=>'raw',
                    'value'=>'((!empty($data->tglrenkontrol)) ? $data->tglrenkontrol.CHtml::link("<i class=\'icon-form-rkontrol\'></i> ",
                             Yii::app()->controller->createUrl("'.Yii::app()->controller->id.'/RencanaKontrolPasienRJ",array("pendaftaran_id"=>$data->pendaftaran_id)) ,
                             array("title"=>"Klik Untuk Rencana Kontrol Pasien","target"=>"iframeRencanaKontrol", "onclick"=>"cekRenControl(event)", "rel"=>"tooltip")) : CHtml::link("<i class=\'icon-form-rkontrol\'></i> ",
                             Yii::app()->controller->createUrl("'.Yii::app()->controller->id.'/RencanaKontrolPasienRJ",array("pendaftaran_id"=>$data->pendaftaran_id)) ,
                             array("title"=>"Klik Untuk Rencana Kontrol Pasien","target"=>"iframeRencanaKontrol", "onclick"=>"$(\"#dialogRencanaKontrol\").dialog(\"open\");", "rel"=>"tooltip")))',
                    'htmlOptions'=>array('style'=>'text-align: center; width:40px'),
                ),
//                array(
//                    'header'=>'Rincian Tagihan',
//                    'type'=>'raw',
//                     'value'=>'CHtml::link("<icon class=\'icon-list-brown\' ></icon> ", Yii::app()->createUrl("'.Yii::app()->controller->module->id.'/RinciantagihanpasienExtendsV/rincianBelumBayar", array("id"=>$data->pendaftaran_id)), array("target"=>"frameRincian","rel"=>"tooltip", "title"=>"lihat rincian tagihan pasien", "onclick"=>"$(\'#dialogRincian\').dialog(\'open\');"))','htmlOptions'=>array('style'=>'text-align: center; width:40px ')                  
//                ),
		array(
			'header'=>'Detail Rincian Tagihan',
			'type'=>'raw',
			'value'=>'CHtml::link("<icon class=\'icon-form-detailtagihan\' ></icon> ", Yii::app()->createUrl("/billingKasir/pembayaranTagihanPasien/printDetailRincianBelumBayar", array("instalasi_id"=>$data->instalasi_id,"pendaftaran_id"=>$data->pendaftaran_id,"frame"=>true)), array("target"=>"frameRincian","rel"=>"tooltip", "title"=>"lihat detail rincian tagihan pasien", "onclick"=>"$(\'#dialogRincian\').dialog(\'open\');"))','htmlOptions'=>array('style'=>'text-align: center; width:40px ')                  
		),  
		array(
			'header'=>'Rincian Tagihan',
			'type'=>'raw',
			'value'=>'CHtml::link("<icon class=\'icon-form-detail\' ></icon> ", Yii::app()->createUrl("/billingKasir/pembayaranTagihanPasien/printRincianBelumBayar", array("instalasi_id"=>$data->instalasi_id,"pendaftaran_id"=>$data->pendaftaran_id,"frame"=>true)), array("target"=>"frameRincian","rel"=>"tooltip", "title"=>"lihat rincian tagihan pasien", "onclick"=>"$(\'#dialogRincian\').dialog(\'open\');"))','htmlOptions'=>array('style'=>'text-align: center; width:40px ')                  
		),  
		array(
			'header'=>'Status Dokumen',
			'type'=>'raw',
			'value'=>'($data->statusdokrm == "SUDAH DITERIMA") ? CHtml::link("<i></i> $data->statusdokrm", Yii::app()->createUrl("/'.Yii::app()->controller->module->id.'/'.Yii::app()->controller->id.'/statusDokumenKirim", array("pengirimanrm_id"=>$data->pengirimanrm_id,"pendaftaran_id"=>$data->pendaftaran_id)),
							array("class"=>"btn btn-primary",
							"target"=>"frameStatusDokumen",
							"rel"=>"tooltip",
							"title"=>"Klik untuk mengirim dokumen ke ruangan lain",
							"onclick"=>"$(\'#dialogStatusDokumen\').dialog(\'open\');"))
				: $data->getStatusDokumen($data->pengirimanrm_id,$data->statusdokrm,$data->pendaftaran_id)',
			'htmlOptions'=>array('style'=>'text-align: center; width:40px'),
		),
		array(
			'header'=>'Batal Periksa',
			'type'=>'raw',
			'value'=>function($data) {
                            $pendaftaran = PendaftaranT::model()->findByPk($data->pendaftaran_id);
                            $admisi = PasienadmisiT::model()->findByAttributes(array('pendaftaran_id'=>$data->pendaftaran_id));
                            if (empty($admisi) && empty($pendaftaran->pasienpulang_id)) return CHtml::link("<i class='icon-form-silang'></i>", "javascript:batalperiksa($data->pendaftaran_id)",array("id"=>"$data->no_pendaftaran","rel"=>"tooltip","title"=>"Klik untuk membatalkan pemeriksaan"));
                            return "-";
                        },
			'htmlOptions'=>array('style'=>'text-align: center; width:40px'),
		),
    ),
			'afterAjaxUpdate'=>'function(id, data){
			jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});
			disableLink();}',
)); ?>
<script type="text/javascript">
{
   function batalperiksa(pendaftaran_id)
   {
        myConfirm("Anda yakin akan membatalkan pemeriksaan rawat jalan pasien ini?","Perhatian!",function(r) {
            if(r){
				 $.ajax({
					type:'POST',
					url:'<?php echo Yii::app()->createUrl(Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/' . 'batalPeriksa'); ?>',
					data: {pendaftaran_id : pendaftaran_id},//
					dataType: "json",
					success:function(data){
						if(data.status == true){
							myAlert(data.pesan);
							$.fn.yiiGridView.update('daftarpasien-v-grid', {
								data: $(this).serialize() });

                            // Notifikasi Pasien
                            if(data.smspasien==0){
                                var params = [];
                                params = {instalasi_id:<?php echo Yii::app()->user->getState("instalasi_id"); ?>, modul_id:<?php echo Yii::app()->session['modul_id']; ?>, judulnotifikasi:'GAGAL KIRIM SMS PASIEN', isinotifikasi:'Pasien '+data.nama_pasien+' tidak memiliki nomor mobile'}; // 16 
                                insert_notifikasi(params);
                            } 
                            // Notifikasi Dokter
                            if(data.smsdokter==0){
                                var params = [];
                                params = {instalasi_id:<?php echo Yii::app()->user->getState("instalasi_id"); ?>, modul_id:<?php echo Yii::app()->session['modul_id']; ?>, judulnotifikasi:'GAGAL KIRIM SMS DOKTER', isinotifikasi:'dr. '+data.nama_pegawai+' tidak memiliki nomor mobile'}; // 16 
                                insert_notifikasi(params);
                            }
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
   //validasi pemeriksaan
   function cektindaklanjut()
   {
      myAlert("Pasien sudah ditindak lanjut ke Rawat Inap !");
   }
   
	function setSedangPeriksa(pendaftaran_id,nama_pasien){
		myConfirm(' Apakah pasien atas nama '+nama_pasien+' sudah selesai periksa? ', 'Perhatian!', function(r){
            if(r){
				$.ajax({
					type:'POST',
					url:'<?php echo Yii::app()->createUrl(Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/' . 'SetSedangPeriksa'); ?>',
					data: {pendaftaran_id : pendaftaran_id},//
					dataType: "json",
					success:function(data){
						if(data){
							$.fn.yiiGridView.update('daftarpasien-v-grid');
						}
					},
					error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
				});
            }
        });
	}

}
</script>