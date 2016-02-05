<div style="overflow-x: scroll;">
<?php 
    $this->widget('ext.bootstrap.widgets.BootGridView', array(
	'id'=>'daftarPasien-grid',
	'dataProvider'=>$model->searchRD(),
//                'filter'=>$model,
                'template'=>"{summary}\n{items}\n{pager}",

                'itemsCssClass'=>'table table-striped table-condensed',
	'columns'=>array(
                    array(
                        'header'=>'Tgl. Pendaftaran/<br/>No. Pendaftaran',
                       'name'=>'tgl_pendaftaran',
                        'type'=>'raw',
                        'value'=>'$data->tgl_pendaftaran."/<br/>".$data->no_pendaftaran'
                    ),
//                    array(
//                        'header'=>'Instalasi / Poliklinik',
//                        'value'=>'$data->insatalasiRuangan'
//                    ),
                    array(
                       'name'=>'no_rekam_medik',
                        'type'=>'raw',
                        'value'=>'$data->no_rekam_medik',
                    ),
                    array(
                        'header'=>'Nama Pasien',
                        'value'=>'$data->namadepan.$data->nama_pasien'
                    ),
                    array(
                        'header'=>'Jenis Kelamin/<br/>Umur',
                        'type'=>'raw',
                        'value'=>'$data->jeniskelamin."/<br/>".$data->umur',
                    ),
                    array(
                       'name'=>'alamat_pasien',
                        'type'=>'raw',
                        'value'=>'$data->alamat_pasien',
                    ),
                    array(
                        'header'=>'Kasus Penyakit',
                        'type'=>'raw',
//                        'value'=>'"$data->jeniskasuspenyakit_nama"."<br/>"."$data->kelaspelayanan_nama"',
						'value'=>'CHtml::hiddenField("RDInfoKunjunganRDV[$data->pendaftaran_id][pendaftaran_id]", $data->pendaftaran_id, array("id"=>"pendaftaran_id","onkeypress"=>"return $(this).focusNextInputField(event)","class"=>"span3"))."".CHtml::link("<i class=icon-form-ubah></i> ".$data->jeniskasuspenyakit_nama,"javascript:void(0)",array("onclick"=>"ubahKasusPenyakit(this,$data->pendaftaran_id,$data->jeniskasuspenyakit_id);return false;","class"=>"kasus_penyakit","rel"=>"tooltip","rel"=>"tooltip","title"=>"Klik Untuk Mengubah Data Kasus Penyakit"))',
						'htmlOptions'=>array(
							'style'=>'text-align: center',
							'class'=>'list_kasus_penyakit'
						)
                    ),
                    array(
                       'name'=>'Rujukan',
                        'type'=>'raw',
                        'value'=>'(!empty($data->asalrujukan_nama))? $data->asalrujukan_nama : "-"',
                    ),
                    array(
                        'header'=>'Cara Bayar / Penjamin',
                        'value'=>'$data->caraBayarPenjamin',
                    ),
                    array(
                        'header'=>'Status Periksa',
                        'type'=>'raw',
//                        'value'=>'$data->statusperiksa.CHtml::link("<i class=icon-pencil></i>","",array("href"=>"","rel"=>"tooltip","title"=>"Klik Untuk Mengubah Status Periksa","onclick"=>"{buatSessionUbahStatus($data->pendaftaran_id); ubahStatusPeriksa(); $(\'#dialogUbahStatus\').dialog(\'open\');}return false;"))',
                        'value'=>'$data->getStatus($data->statusperiksa,$data->pendaftaran_id)',
                    ),
                    // array(
                    //    'name'=>'Dokter',
                    //     'type'=>'raw',
                    //     'value'=>'$data->nama_pegawai',
                    // ),
                    array(
                        'name'=>'Dokter',
                        'type'=>'raw',
                        'value'=>'"<div style=\'width:100px;\'>" . CHtml::link("<i class=icon-pencil-brown></i> ". $data->gelardepan." ".$data->nama_pegawai." ".$data->gelarbelakang_nama," ",array("onclick"=>"ubahDokterPeriksa(\'$data->pendaftaran_id\');$(\'#editDokterPeriksa\').dialog(\'open\');return false;", "rel"=>"tooltip","rel"=>"tooltip","title"=>"Klik Untuk Mengubah Data Dokter Periksa")) . "</div>"',
                    ), /*
                    array(
                       'name'=>'Transportasi',
                        'type'=>'raw',
                        'value'=>'(!empty($data->transportasi))? $data->transportasi : "-"',
                    ),
                    array(
                       'name'=>'Cara Masuk',
                        'type'=>'raw',
                        'value'=>'(!empty($data->caramasuk_nama))? $data->caramasuk_nama : "-"',
                    ),
                     * 
                     */
//                    array(
//                       'name'=>'kelaspelayanan_nama',
//                        'type'=>'raw',
//                        'value'=>'$data->kelaspelayanan_nama',
//                    ),
                   // array(
                   //    'name'=>'pembayaranpelayanan_id',
                   //     'type'=>'raw',
                   //     'value'=>'$data->pembayaranpelayanan_id',
                   // ),
                    array(
                        'name'=>'Pemeriksaan Pasien',
                        'type'=>'raw',
//                        'value'=>'(!empty($data->pasienpulang_id))? "-" : CHtml::link("<i class=\'icon-list-alt\'></i> ", Yii::app()->controller->createUrl("/rawatDarurat/anamnesaTRD",array("pendaftaran_id"=>$data->pendaftaran_id)),array("id"=>"$data->no_pendaftaran","rel"=>"tooltip","title"=>"Klik untuk Pemeriksaan Pasien"))','htmlOptions'=>array('style'=>'text-align: center; width:40px')
                          // 'value'=>'RDInfoKunjunganRDV::getPeriksaPasien($data->statusperiksa,$data->pendaftaran_id,$data->pendaftaran->pembayaranpelayanan_id,$data->no_pendaftaran,$data->alihstatus)',
                        'value'=>'(($data->alihstatus==FALSE) ? CHtml::link("<i class=\'icon-form-periksa\'></i> ", Yii::app()->controller->createUrl("/rawatDarurat/pemeriksaanPasienTRD",array("pendaftaran_id"=>$data->pendaftaran_id)),array("id"=>"$data->no_pendaftaran","rel"=>"tooltip","title"=>"Klik untuk Pemeriksaan Pasien")): CHtml::link("<i class=\'icon-form-periksa\'></i>", "javascript:cektindaklanjut()",array("rel"=>"tooltip","title"=>"Klik untuk Pemeriksaan Pasien")))',
			'htmlOptions'=>array('style'=>'text-align: center; width:40px')
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
                       'header'=>'Tindak Lanjut',
                       'type'=>'raw',
						'value'=>'(($data->pasienpulang_id != 0) OR ($data->carakeluar != "")) ? $data->carakeluar : CHtml::link("<icon class=\'icon-form-ubah\'></icon>", Yii::app()->createUrl("/rawatDarurat/daftarPasien/PasienPulang", array("pendaftaran_id"=>$data->pendaftaran_id,"dialog"=>true)), array("target"=>"iframePasienPulang", "onclick"=>"$(\'#dialogPasienPulang\').dialog(\'open\');","rel"=>"tooltip", "title"=>"Klik untuk menambahkan tindak lanjut"))','htmlOptions'=>array('style'=>'text-align: center; width:40px')
                    ), /*
					array(
						'header'=>'Tindak Lanjut<br/>ke Rawat Inap',
						'type'=>'raw',
						'value'=>'($data->statusperiksa == "'.Params::STATUSPERIKSA_SEDANG_DIRAWATINAP.'") ? 
							("Pasien di Rawat Inap<br>".$data->getNamaKamar()."<br>".$data->getNoBed().
							CHtml::link("<i class=\'icon-form-sampah\'></i>", Yii::app()->controller->createUrl("/'.Yii::app()->controller->module->id.'/'.Yii::app()->controller->id.'/BatalRawatInap",array("pendaftaran_id"=>$data->pendaftaran_id)) , array("title"=>"Klik Untuk Batal Proses Tindak Lanjut Pasien","target"=>"iframeBatalRawatInap", "onclick"=>"$(\"#dialogBatalRawatInap\").dialog(\"open\");", "rel"=>"tooltip")))
							:  
							CHtml::link("<i class=\'icon-form-ri\'></i>", Yii::app()->createUrl("/'.Yii::app()->controller->module->id.'/TindakLanjutDariRD/tindakLanjutRI", array("instalasi_id"=>$data->instalasi_id,"pendaftaran_id"=>$data->pendaftaran_id)),
								array("class"=>"",
								"target"=>"frameTindakLanjut",
								"rel"=>"tooltip",
								"title"=>"Klik untuk Proses Tindak Lanjut Pasien",
								"onclick"=>"$(\'#dialogTindakLanjut\').dialog(\'open\');"))',
						'htmlOptions'=>array('style'=>'text-align: center; width:60px')
					),
                     * 
                     */
                    array(
                        'header'=>'Rincian Detail Tagihan',
                        'type'=>'raw',
//                        'value'=>'CHtml::link("<icon class=\'icon-list-brown\'></icon>", Yii::app()->createUrl("'.Yii::app()->controller->module->id.'/RinciantagihanpasienExtendsV/rincianBelumBayarRD", array("id"=>$data->pendaftaran_id)), array("target"=>"frameRincian", "onclick"=>"$(\'#dialogRincian\').dialog(\'open\');","rel"=>"tooltip", "title"=>"Klik untuk melihat rincian tagihan"))','htmlOptions'=>array('style'=>'text-align: center; width:40px')
                        'value'=>'CHtml::link("<icon class=\'icon-form-detailtagihan\'></icon>", Yii::app()->createUrl("/billingKasir/pembayaranTagihanPasien/printDetailRincianBelumBayar", array("instalasi_id"=>$data->instalasi_id,"pendaftaran_id"=>$data->pendaftaran_id,"frame"=>true)), array("target"=>"frameRincian", "onclick"=>"$(\'#dialogRincian\').dialog(\'open\');","rel"=>"tooltip", "title"=>"Klik untuk melihat detail rincian tagihan"))','htmlOptions'=>array('style'=>'text-align: center; width:40px')
                    ),  
                    array(
                        'header'=>'Rincian Tagihan',
                        'type'=>'raw',
//                        'value'=>'CHtml::link("<icon class=\'icon-list-brown\'></icon>", Yii::app()->createUrl("'.Yii::app()->controller->module->id.'/RinciantagihanpasienExtendsV/rincianBelumBayarRD", array("id"=>$data->pendaftaran_id)), array("target"=>"frameRincian", "onclick"=>"$(\'#dialogRincian\').dialog(\'open\');","rel"=>"tooltip", "title"=>"Klik untuk melihat rincian tagihan"))','htmlOptions'=>array('style'=>'text-align: center; width:40px')
                        'value'=>'CHtml::link("<icon class=\'icon-form-detail\'></icon>", Yii::app()->createUrl("/billingKasir/pembayaranTagihanPasien/printRincianBelumBayar", array("instalasi_id"=>$data->instalasi_id,"pendaftaran_id"=>$data->pendaftaran_id,"frame"=>true)), array("target"=>"frameRincian", "onclick"=>"$(\'#dialogRincian\').dialog(\'open\');","rel"=>"tooltip", "title"=>"Klik untuk melihat rincian tagihan"))','htmlOptions'=>array('style'=>'text-align: center; width:40px')
                    ),  
					array(
						'header'=>'Batal Periksa',
						'type'=>'raw',
						'value'=>'CHtml::link("<i class=\'icon-form-silang\'></i>", "javascript:batalperiksa($data->pendaftaran_id)",array("id"=>"$data->no_pendaftaran","rel"=>"tooltip","title"=>"Klik untuk membatalkan pemeriksaan"))',
						'htmlOptions'=>array('style'=>'text-align: center; width:40px'),
					),
            ),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
    ));
?>
</div>

<script type="text/javascript">
{
   function batalperiksa(pendaftaran_id)
   {
        myConfirm("Anda yakin akan membatalkan pemeriksaan rawat darurat pasien ini?","Perhatian!",function(r) {
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
   //validasi pemeriksaan
   function cektindaklanjut()
   {
      myAlert("Pasien sudah ditindak lanjut ke Rawat Inap !");
   }

}
/**
* untuk ubah kasus penyakit
* @param {type} obj
* @param {type} pendaftaran_id
* @param {type} jeniskasuspenyakit_id
* @returns {Boolean} */
 
function ubahKasusPenyakit(obj,pendaftaran_id, jeniskasuspenyakit_id){
	var pendaftaran_id = pendaftaran_id;
	var jeniskasuspenyakit_id = jeniskasuspenyakit_id;
	$.ajax({
	   type:'POST',
	   url:'<?php echo $this->createUrl('SetDropdownKasusPenyakit'); ?>',
	   data: {pendaftaran_id:pendaftaran_id,jeniskasuspenyakit_id:jeniskasuspenyakit_id},
	   dataType: "json",
	   success:function(data){
			$(obj).parents('tr').find('.list_kasus_penyakit').append(data.kasusPenyakit);
			$(obj).parents('td').find('.kasus_penyakit').hide();			
	   },
	   error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
   });	
   return false;
}

function saveKasusPenyakit(obj,pendaftaran_id){
	var jeniskasuspenyakit_id = $(obj).val();
	var pendaftaran_id = pendaftaran_id;
	$.ajax({
	   type:'POST',
	   url:'<?php echo $this->createUrl('saveKasusPenyakit'); ?>',
	   data: {pendaftaran_id:pendaftaran_id,jeniskasuspenyakit_id:jeniskasuspenyakit_id},
	   dataType: "json",
	   success:function(data){
		   if(data.pesan == 'berhasil'){
				myAlert('Data Kasus Penyakit berhasil di ubah');
				$.fn.yiiGridView.update('daftarPasien-grid', {
								data: $(this).serialize() });
		   }else{
			   myAlert('Data Kasus Penyakit gagal di ubah');
		   }	
	   },
	   error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
   });	
}
</script>