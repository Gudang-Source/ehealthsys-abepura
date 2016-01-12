<div class="block-tabel">
    <h6>Tabel <b>Pasien MCU</b></h6>
    <?php $this->widget('ext.bootstrap.widgets.BootGridView',array(
    'id'=>'daftarpasien-v-grid',
    'dataProvider'=>$model->searchDaftarPasienMcu(),
	'template'=>"{summary}\n{items}\n{pager}",
	'itemsCssClass'=>'table table-striped table-condensed',
    'columns'=>array(   
                array(
                    'name'=>'no_urutantri',
                    'type'=>'raw',
                    'header'=>'No. Antrian <br>/ Panggil Antrian',
                    'value'=>'$data->ruangan_singkatan."-".$data->no_urutantri."<br>".(($data->panggilantrian == TRUE) ? "Sudah Dipanggil" : CHtml::htmlButton(Yii::t("mds","{icon}",array("{icon}"=>"<i class=\'icon-volume-up icon-white\'></i>")),array("class"=>"btn btn-primary","onclick"=>"panggilAntrian(\"$data->pendaftaran_id\"); setSuaraPanggilanSingle(\"$data->ruangan_singkatan\",\"$data->no_urutantri\",\"$data->ruangan_id\")","rel"=>"tooltip","title"=>"Klik untuk memanggil pasien ini")))'
                ),
                array(
                    'name'=>'tgl_pendaftaran',
                    'value'=>'MyFormatter::formatDateTimeForUser($data->tgl_pendaftaran)',
                ),
                array(
                    'name'=>'No_pendaftaran'.'/<br/>'.'No_rekam_medik',
                    'type'=>'raw',
                    'value'=>'"$data->no_pendaftaran"."<br/>"."$data->no_rekam_medik"',
                ),
                array(
                    'name'=>'nama_pasien'.'/<br/>'.'Alias',
                    'type'=>'raw',
                    'value'=>'"$data->nama_pasien"."<br/>"."$data->nama_bin"',
                ),
                array(
                    'name'=>'alamat_pasien'.'/<br/>'.'RT RW',
                    'type'=>'raw',
                    'value'=>'"$data->alamat_pasien"."<br/>"."$data->RTRW"',
                ),
                array(
                    'name'=>'Penjamin'.'/<br/>'.'Cara Bayar',
                    'type'=>'raw',
                    'value'=>'"$data->penjamin_nama"."<br/>"."$data->carabayar_nama"',
                ),
                array(
                    'header'=>'Dokter / <br> Kelas Pelayanan',
                    'type'=>'raw',
                    'value'=>'"<div style=\'width:120px;\'>" . CHtml::link("<i class=icon-form-ubah></i> ". $data->gelardepan." ".$data->nama_pegawai." ".$data->gelarbelakang_nama," ",array("onclick"=>"ubahDokterPeriksa(\'$data->pendaftaran_id\');$(\'#editDokterPeriksa\').dialog(\'open\');return false;", "rel"=>"tooltip","rel"=>"tooltip","title"=>"Klik Untuk Mengubah Data Dokter Periksa")) . "</div>"."<br/>"."$data->kelaspelayanan_nama"',
                    'htmlOptions'=>array(
                       'style'=>'text-align:left;'
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
                    'value'=>'$data->getStatus($data->statusperiksa,$data->pendaftaran_id)',
                    'htmlOptions'=>array('style'=>'text-align:left;')
                ),
                array(
                    'name'=>'Periksa Pasien',
                    'type'=>'raw',
                    'value'=>'(($data->alihstatus==FALSE) ? CHtml::link("<i class=\'icon-form-periksa\'></i> ", Yii::app()->controller->createUrl("/mcu/pemeriksaanPasienMC",array("pendaftaran_id"=>$data->pendaftaran_id)),array("id"=>"$data->no_pendaftaran","rel"=>"tooltip","title"=>"Klik untuk Pemeriksaan Pasien MCU")): CHtml::link("<i class=\'icon-list-alt\'></i>", "javascript:cektindaklanjut()",array("rel"=>"tooltip","title"=>"Klik untuk Pemeriksaan Pasien MCU")))',
					'htmlOptions'=>array('style'=>'text-align: left; width:60px')
		),
        
//LNG-552
//                array(
//                    'name'=>'Tindak Lanjut<br/>ke Rawat Inap',
//                    'type'=>'raw',
//                    'value'=>'(!empty($data->pendaftaran->pasienpulang_id) ) ?  "Pasien di Rawat Inap".
//                       CHtml::link("<i class=\'icon-form-silang\'></i>", Yii::app()->controller->createUrl("'.Yii::app()->controller->id.'/BatalRawatInap",array("pendaftaran_id"=>$data->pendaftaran_id)) , array("title"=>"Klik Untuk Batal Proses Tindak Lanjut Pasien","target"=>"iframeBatalRawatInap", "onclick"=>"$(\"#dialogBatalRawatInap\").dialog(\"open\");", "rel"=>"tooltip"))  :  
//                       (($data->statusperiksa==Params::STATUSPERIKSA_BATAL_PERIKSA) ? "" : CHtml::link("<i class=\'icon-form-ri\'></i>", Yii::app()->createUrl("/rawatJalan/DaftarPasien/tindakLanjutRI", array("instalasi_id"=>$data->instalasi_id,"pendaftaran_id"=>$data->pendaftaran_id)),
//                       array("class"=>"",
//                       "target"=>"frameTindakLanjut",
//                       "rel"=>"tooltip",
//                       "title"=>"Klik untuk Proses Tindak Lanjut Pasien",
//                       "onclick"=>"$(\'#dialogTindakLanjut\').dialog(\'open\');")))',
//                    'htmlOptions'=>array('style'=>'text-align: left; width:60px')
//                ),
                array(
                    'header'=>'Rencana Kontrol',
                    'type'=>'raw',
                    'value'=>'((!empty($data->tglrenkontrol)) ? $data->tglrenkontrol.CHtml::link("<i class=\'icon-form-rkontrol\'></i> ",
                             Yii::app()->controller->createUrl("'.Yii::app()->controller->id.'/RencanaKontrolPasienRJ",array("pendaftaran_id"=>$data->pendaftaran_id)) ,
                             array("title"=>"Klik Untuk Rencana Kontrol Pasien","target"=>"iframeRencanaKontrol", "onclick"=>"cekRenControl(event)", "rel"=>"tooltip")) : CHtml::link("<i class=\'icon-form-rkontrol\'></i> ",
                             Yii::app()->controller->createUrl("'.Yii::app()->controller->id.'/RencanaKontrolPasienRJ",array("pendaftaran_id"=>$data->pendaftaran_id)) ,
                             array("title"=>"Klik Untuk Rencana Kontrol Pasien","target"=>"iframeRencanaKontrol", "onclick"=>"$(\"#dialogRencanaKontrol\").dialog(\"open\");", "rel"=>"tooltip")))',
                    'htmlOptions'=>array('style'=>'text-align: left; width:40px'),
                ),
                array(
                    'header'=>'Detail Rincian Tagihan',
                    'type'=>'raw',
                    'value'=>'CHtml::link("<icon class=\'icon-form-detailtagihan\' ></icon> ", Yii::app()->createUrl("/billingKasir/pembayaranTagihanPasien/printDetailRincianBelumBayar", array("instalasi_id"=>$data->instalasi_id,"pendaftaran_id"=>$data->pendaftaran_id,"frame"=>true)), array("target"=>"frameRincian","rel"=>"tooltip", "title"=>"lihat detail rincian tagihan pasien", "onclick"=>"$(\'#dialogRincian\').dialog(\'open\');"))','htmlOptions'=>array('style'=>'text-align: left; width:40px ')                  
                ),  
                array(
                    'header'=>'Rincian Tagihan',
                    'type'=>'raw',
                    'value'=>'CHtml::link("<icon class=\'icon-form-detail\' ></icon> ", Yii::app()->createUrl("/billingKasir/pembayaranTagihanPasien/printRincianBelumBayar", array("instalasi_id"=>$data->instalasi_id,"pendaftaran_id"=>$data->pendaftaran_id,"frame"=>true)), array("target"=>"frameRincian","rel"=>"tooltip", "title"=>"lihat rincian tagihan pasien", "onclick"=>"$(\'#dialogRincian\').dialog(\'open\');"))','htmlOptions'=>array('style'=>'text-align: left; width:40px ')                  
                ),  
		array(
		    'header'=>'Batal Periksa',
		    'type'=>'raw',
		    'value'=>'CHtml::link("<i class=\'icon-form-silang\'></i>", "javascript:batalperiksa($data->pendaftaran_id)",array("id"=>"$data->no_pendaftaran","rel"=>"tooltip","title"=>"Klik untuk membatalkan pemeriksaan"))',
		    'htmlOptions'=>array('style'=>'text-align: left; width:40px'),
		),
    ),
                'afterAjaxUpdate'=>'function(id, data){
                jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});
                }',
    )); ?>
</div>

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
   
	function ubahDokterPeriksa(pendaftaran_id)
	{
		$('#temp_idPendaftaranDP').val(pendaftaran_id);
		jQuery.ajax({'url':'<?php echo $this->createUrl('ubahDokterPeriksa', array('menu'=>'MCU'))?>',
			'data':$(this).serialize(),
			'type':'post',
			'dataType':'json',
			'success':function(data){
				if (data.status == 'create_form') {
					$('#editDokterPeriksa div.divForFormEditDokterPeriksa').html(data.div);
					$('#editDokterPeriksa div.divForFormEditDokterPeriksa form').submit(ubahDokterPeriksa);
				}else{
					$('#editDokterPeriksa div.divForFormEditDokterPeriksa').html(data.div);
					$.fn.yiiGridView.update('daftarpasien-v-grid', {
							data: $(this).serialize()
					});
					setTimeout("$('#editDokterPeriksa').dialog('close') ",500);
				}
			},
			'cache':false
		});
		return false; 
	}
}
</script>