<h6>Tabel Daftar <b>Pasien Poliklinik</b></h6>
<?php $this->widget('ext.bootstrap.widgets.BootGridView',array(
    'id'=>'daftarpasien-v-grid',
    'dataProvider'=>$model->searchDaftarPasienPoliklinik(),
	'template'=>"{summary}\n{items}\n{pager}",
	'itemsCssClass'=>'table table-striped table-condensed',
    'columns'=>array(   
		array(
			'name'=>'no_urutantri',
			'type'=>'raw',
			'header'=>'No. Antrian <br>/ Panggil Antrian',
			// 'value'=>'$data->ruangan_singkatan."-".$data->no_urutantri."<br>".(($data->panggilantrian == TRUE) ? "Sudah Dipanggil" : "-")'
			'value'=>'$data->ruangan_singkatan."-".$data->no_urutantri."<br>".(($data->panggilantrian == TRUE) ? "Sudah Dipanggil" : CHtml::htmlButton(Yii::t("mds","{icon}",array("{icon}"=>"<i class=\'icon-volume-up icon-white\'></i>")),array("class"=>"btn btn-primary","onclick"=>"panggilAntrian(\"$data->pendaftaran_id\"); setSuaraPanggilanSingle(\"$data->ruangan_singkatan\",\"$data->no_urutantri\",\"$data->ruangan_id\")","rel"=>"tooltip","title"=>"Klik untuk memanggil pasien ini")))'
		),
		array(
			'header'=>'Poliklinik',
			'type'=>'raw',
			'value'=>'$data->ruangan_nama',
		),
		array(
			'name'=>'tgl_pendaftaran',
			'type'=>'raw',
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
            'value'=>'"<div style=\'width:100px;\'>" . CHtml::link("<i class=icon-form-ubah></i>". $data->gelardepan." ".$data->nama_pegawai." ".$data->gelarbelakang_nama," ",array("onclick"=>"ubahDokterPeriksa(\'$data->pendaftaran_id\');$(\'#editDokterPeriksa\').dialog(\'open\');return false;", "rel"=>"tooltip","rel"=>"tooltip","title"=>"Klik Untuk Mengubah Data Dokter Periksa")) . "</div>"."/"."$data->kelaspelayanan_nama"',
            'htmlOptions'=>array(
               'style'=>'text-align:center;',
               'class'=>'rajal'
           )
        ),                
		array(
			'header'=>'Kasus Penyakit ',
			'type'=>'raw',
//			'value'=>'CHtml::hiddenField("RJInfokunjunganrV[$data->pendaftaran_id][pendaftaran_id]", $data->pendaftaran_id, array("id"=>"pendaftaran_id","onkeypress"=>"return $(this).focusNextInputField(event)","class"=>"span3"))."".$data->jeniskasuspenyakit_nama',
			'value'=>'CHtml::hiddenField("RJInfokunjunganrV[$data->pendaftaran_id][pendaftaran_id]", $data->pendaftaran_id, array("id"=>"pendaftaran_id","onkeypress"=>"return $(this).focusNextInputField(event)","class"=>"span3"))."".CHtml::link("<i class=icon-form-ubah></i> ".$data->jeniskasuspenyakit_nama,"javascript:void(0)",array("onclick"=>"ubahKasusPenyakit(this,$data->pendaftaran_id,$data->jeniskasuspenyakit_id);return false;","class"=>"kasus_penyakit","rel"=>"tooltip","rel"=>"tooltip","title"=>"Klik Untuk Mengubah Data Kasus Penyakit"))',
			'htmlOptions'=>array(
				'style'=>'text-align: center',
				'class'=>'list_kasus_penyakit'
			)
		),
		array(
			'header'=>'Status Periksa',
			'type'=>'raw',
			'value'=>'$data->getStatus($data->statusperiksa,$data->pendaftaran_id)',
		),
		array(
			'name'=>'Periksa Pasien',
			'type'=>'raw',
			'value'=>'CHtml::link("<i class=\'icon-form-periksa\'></i> ", Yii::app()->controller->createUrl("/rawatJalan/pemeriksaanPasien",array("pendaftaran_id"=>$data->pendaftaran_id,"ruangan_id"=>$data->ruangan_id)),array("id"=>"$data->no_pendaftaran","rel"=>"tooltip","title"=>"Klik untuk Pemeriksaan Pasien"))',
			'htmlOptions'=>array('style'=>'text-align:left;')
		),

		array(
			'name'=>'Tindak Lanjut<br/>ke Rawat Inap',
			'type'=>'raw',
			'value'=>'(!empty($data->pendaftaran->pasienpulang_id) ) ?  "Pasien di Rawat Inap".
				CHtml::link("<i class=\'icon-form-sampah\'></i>", Yii::app()->controller->createUrl("/rawatJalan/DaftarPasien/BatalRawatInap",array("pendaftaran_id"=>$data->pendaftaran_id,"ruangan_id"=>$data->ruangan_id)) , array("title"=>"Klik Untuk Batal Proses Tindak Lanjut Pasien","target"=>"iframeBatalRawatInap", "onclick"=>"$(\"#dialogBatalRawatInap\").dialog(\"open\");", "rel"=>"tooltip"))  :  
				(($data->statusperiksa==Params::STATUSPERIKSA_BATAL_PERIKSA) ? "" : CHtml::link("<i class=\'icon-form-ri\'></i>", Yii::app()->createUrl("/rawatJalan/DaftarPasien/tindakLanjutRI", array("instalasi_id"=>$data->instalasi_id,"pendaftaran_id"=>$data->pendaftaran_id,"ruangan_id"=>$data->ruangan_id)),
				array("class"=>"",
				"target"=>"frameTindakLanjut",
				"rel"=>"tooltip",
				"title"=>"Klik untuk Proses Tindak Lanjut Pasien",
				"onclick"=>"$(\'#dialogTindakLanjut\').dialog(\'open\');")))',
			'htmlOptions'=>array('style'=>'text-align:left; width:60px')
		),
		array(
			'header'=>'Rencana Kontrol',
			'type'=>'raw',
			'value'=>'((!empty($data->tglrenkontrol)) ? $data->tglrenkontrol.CHtml::link("<i class=\'icon-form-rkontrol\'></i> ",
					Yii::app()->controller->createUrl("daftarPasien/RencanaKontrolPasienRJ",array("pendaftaran_id"=>$data->pendaftaran_id,"ruangan_id"=>$data->ruangan_id)) ,
					array("title"=>"Klik Untuk Rencana Kontrol Pasien","target"=>"iframeRencanaKontrol", "onclick"=>"cekRenControl(event)", "rel"=>"tooltip")) : CHtml::link("<i class=\'icon-form-rkontrol\'></i> ",
					Yii::app()->controller->createUrl("daftarPasien/RencanaKontrolPasienRJ",array("pendaftaran_id"=>$data->pendaftaran_id,"ruangan_id"=>$data->ruangan_id)) ,
					array("title"=>"Klik Untuk Rencana Kontrol Pasien","target"=>"iframeRencanaKontrol", "onclick"=>"$(\"#dialogRencanaKontrol\").dialog(\"open\");", "rel"=>"tooltip")))',
			'htmlOptions'=>array('style'=>'text-align:left; width:40px'),
		),
		array(
                    'header'=>'Detail Rincian Tagihan',
                    'type'=>'raw',
                    'value'=>'CHtml::link("<icon class=\'icon-form-detailtagihan\' ></icon> ", Yii::app()->createUrl("/billingKasir/pembayaranTagihanPasien/printDetailRincianBelumBayar", array("instalasi_id"=>$data->instalasi_id,"pendaftaran_id"=>$data->pendaftaran_id,"frame"=>true)), array("target"=>"frameRincian","rel"=>"tooltip", "title"=>"lihat detail rincian tagihan pasien", "onclick"=>"$(\'#dialogRincian\').dialog(\'open\');"))','htmlOptions'=>array('style'=>'text-align:left; width:40px ')                  
                ),   
//		array(
//			'header'=>'Rincian Tagihan',
//			'type'=>'raw',
//			'value'=>'"-"',
//		),  
		array(
			'header'=>'Batal Periksa',
			'type'=>'raw',
			'value'=>'CHtml::link("<i class=\'icon-form-silang\'></i>", "javascript:batalperiksa($data->pendaftaran_id,$data->ruangan_id)",array("id"=>"$data->no_pendaftaran","rel"=>"tooltip","title"=>"Klik untuk membatalkan pemeriksaan"))',
			'htmlOptions'=>array('style'=>'text-align:left; width:40px'),
		),
    ),
		'afterAjaxUpdate'=>'function(id, data){
		jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
)); ?>
<script type="text/javascript">
{
   function batalperiksa(pendaftaran_id,ruangan_id)
   {
        myConfirm("Anda yakin akan membatalkan pemeriksaan rawat jalan pasien ini?","Perhatian!",function(r) {
            if(r){
				 $.ajax({
					type:'POST',
					url:'<?php echo Yii::app()->createUrl(Yii::app()->controller->module->id . '/DaftarPasien/batalPeriksa'); ?>',
					data: {pendaftaran_id : pendaftaran_id,ruangan_id:ruangan_id},//
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

}
</script>