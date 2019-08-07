
	
	<div class="span12">
		<?php
			if (!isset($_GET['PengajuanpembangsuranV'])) {
				$permintaanv->tglAwal = MyFormatter::formatDateTimeForDb($permintaanv->tglAwal);
				$permintaanv->tglAkhir = MyFormatter::formatDateTimeForDb($permintaanv->tglAkhir);
			}

			$this->widget('ext.bootstrap.widgets.BootGridView',array(
				'id'=>'permintaan-m-grid',
				'dataProvider'=>$permintaanv->searchPeminjamAngsuran(),
				'filter'=>null,
				'itemsCssClass' => 'table table-striped table-bordered table-condensed',
				'columns'=>array(
					array(
						'header'=>'Pilih'.CHtml::checkbox('pilih_semua', false, array('onchange'=>'pilihSemua()')),
						'type'=>'raw',
						'value'=>function($data) use ($permintaan, $form) {
							return CHtml::checkBox('PengajuanpembayaranT[angsuran]['.$data->jmlangsuran_id.'][check]', false, array('defaultValue'=>0, 'class'=>'ceklis'));
						},
					),
					array(
						'header'=>'Tgl Angsuran <br/>/ Tgl Jatuh Tempo',
						'type'=>'raw',
						'value'=>function($data) use ($permintaan, $form) {
							$angsuran = JmlangsuranT::model()->findByPk($data->jmlangsuran_id);
							$input = "";
							$input .= $form->hiddenField($permintaan, '[angsuran]['.$data->jmlangsuran_id.']potongansumber_id', array('value'=>$data->potongansumber_id));
							$input .= $form->hiddenField($permintaan, '[angsuran]['.$data->jmlangsuran_id.']keanggotaan_id', array('value'=>$data->keanggotaan_id));
							$input .= $form->hiddenField($permintaan, '[angsuran]['.$data->jmlangsuran_id.']jmlangsuran_id', array('value'=>$data->jmlangsuran_id));
							$input .= Chtml::hiddenField('mull[angsuran]['.$data->jmlangsuran_id.'][jmlpokok_angsuran]', $data->jmlpokok_angsuran, array('class'=>'jmlpokok_angsuran'));
							$input .= Chtml::hiddenField('mull[angsuran]['.$data->jmlangsuran_id.'][jmljasa_angsuran]', $data->jmljasa_angsuran, array('class'=>'jmljasa_angsuran'));
							$input .= Chtml::hiddenField('mull[angsuran]['.$data->jmlangsuran_id.'][jmlsisa_angsuran]', $angsuran->sisaPengajuan, array('class'=>'jmlsisa_angsuran'));
							$input .= Chtml::hiddenField('mull[angsuran]['.$data->jmlangsuran_id.'][bayar]', $angsuran->bayarBelum, array('class'=>'bayar'));
							return date("d/m/Y",strtotime($data->tglangsuran))." ".$input.date('d/m/Y', strtotime($data->tgljatuhtempoangs));
						},
						'headerHtmlOptions'=>array('style'=>'width:100px'),
						),
					/*array(
						'header'=>'Tgl Jatuh Tempo',
						'type'=>'raw',
						'value'=>function($data) use ($permintaan, $form) {
							$angsuran = JmlangsuranT::model()->findByPk($data->jmlangsuran_id);
							$input = "";
							$input .= $form->hiddenField($permintaan, '[angsuran]['.$data->jmlangsuran_id.']potongansumber_id', array('value'=>$data->potongansumber_id));
							$input .= $form->hiddenField($permintaan, '[angsuran]['.$data->jmlangsuran_id.']keanggotaan_id', array('value'=>$data->keanggotaan_id));
							$input .= $form->hiddenField($permintaan, '[angsuran]['.$data->jmlangsuran_id.']jmlangsuran_id', array('value'=>$data->jmlangsuran_id));
							$input .= Chtml::hiddenField('mull[angsuran]['.$data->jmlangsuran_id.'][jmlpokok_angsuran]', $data->jmlpokok_angsuran, array('class'=>'jmlpokok_angsuran'));
							$input .= Chtml::hiddenField('mull[angsuran]['.$data->jmlangsuran_id.'][jmljasa_angsuran]', $data->jmljasa_angsuran, array('class'=>'jmljasa_angsuran'));
							$input .= Chtml::hiddenField('mull[angsuran]['.$data->jmlangsuran_id.'][jmlsisa_angsuran]', $angsuran->sisaPengajuan, array('class'=>'jmlsisa_angsuran'));
							$input .= Chtml::hiddenField('mull[angsuran]['.$data->jmlangsuran_id.'][bayar]', $angsuran->bayarBelum, array('class'=>'bayar'));
							return date("d/m/Y",strtotime($data->tglangsuran))." ".$input.date('d/m/Y', strtotime($data->tgljatuhtempoangs));
						},//'$data->tgljatuhtempoangs',
					),*/
					array(
						'header'=>'Tgl Pinjaman<br/>/ No Pinjaman',
						'type'=>'raw',
						'value'=>'date("d/m/Y", strtotime($data->tglpinjaman))."<br/>".CHtml::link("<i class=\'entypo-doc-text\'>$data->no_pinjaman</i>","#",
								 array("onclick"=>"dialogInformasi(\'".$data->no_pinjaman."\'); return false;","rel"=>"tooltip","title"=>"Klik Untuk Melihat Detail Angsuran"))',
						'headerHtmlOptions'=>array('style'=>'width:110px'),
					),
					array(
						'header'=>'Sumber Potongan',
						'value'=>'$data->namapotongan',
					),
					array(
						'header'=>'No Anggota /<br>Nama Anggota',
						'type'=>'raw',
						'value'=>'$data->nokeanggotaan." /<br>".$data->nama_pegawai',
					),
					array(
						'header'=>'Unit',
						'type'=>'raw',
						'value'=>'$data->namaunit',
					), /*
					array(
						'header'=>'Golongan',
						'type'=>'raw',
						'value'=>'$data->golonganpegawai_nama',
					), */
					array(
						'header'=>'Angsuran Ke',
						'type'=>'raw',
						'value'=>'$data->angsuran_ke',
						'htmlOptions'=>array('style'=>'text-align:center'),
					),
					array (
						'header'=>'Simpanan Wajib',
						'type'=>'raw',
						'value'=>function($data) use ($form, $permintaan) {
							$golongan = GolonganpegawaiM::model()->findByPk($data->golonganpegawai_id);
							$simpanan = SimpananT::model()->findByAttributes(
								array('keanggotaan_id'=>$data->keanggotaan_id, 'jenissimpanan_id'=>2),
								array('order'=>'tglsimpanan desc')
							);
							$val = 0; $dis = false;
							$tgls = date('m', strtotime($simpanan->tglsimpanan)); // bulan simpanan terakhir
							$tgln = date('m'); // bulan sekarang

							if ($tgln > $tgls) $val = $golongan->simpananwajib;
							else $dis = true;
							//if (!empty($golongan) && !$data->pernahAjukan) $val = $golongan->simpananwajib;

							return  $form->textField($permintaan, '[angsuran]['.$data->jmlangsuran_id.']simpananwajib', array('value'=>MyFormatter::formatNumberForPrint($val), 'readonly'=>$dis, 'class'=>'form-control num', 'onblur'=>'hitungTotalAngsuran()'));
						},
					),
					array (
						'header'=>'Simpanan Sukarela',
						'type'=>'raw',
						'value'=>function($data) use ($form, $permintaan) {
							return  $form->textField($permintaan, '[angsuran]['.$data->jmlangsuran_id.']simpanansukarela', array('value'=>0, 'class'=>'form-control num', 'onblur'=>'hitungTotalAngsuran()'));
						},
					),
					array(
						'header'=>'Pokok Angsuran',
						'type'=>'raw',
						'value'=>'MyFormatter::formatNumberForPrint($data->jmlpokok_angsuran)',
						'htmlOptions'=>array('style'=>'text-align:right'),
					),
					array(
						'header'=>'Jasa Angsuran',
						'type'=>'raw',
						'value'=>'MyFormatter::formatNumberForPrint($data->jmljasa_angsuran)',
						'htmlOptions'=>array('style'=>'text-align:right'),
					),
					array(
						'header'=>'Sisa Angsuran',
						'type'=>'raw',
						'value'=>function($data) {
							$angsuran = JmlangsuranT::model()->findByPk($data->jmlangsuran_id);
							$str = CHtml::textField('jml_angsuran', 0, array('readonly'=>true, 'class'=>'jumlah_angsuran form-control num'));
							//$str .= CHtml::textField('sisa_pinjaman', 0, array('readonly'=>true, 'class'=>'jumlah_angsuran form-control num'));
							return $str;
						},
						'htmlOptions'=>array('style'=>'text-align:right'),
					), /*
					array(
						'header'=>'Sumber Potongan',
						'type'=>'raw',
						'value'=>'$data->namapotongan',
					), */
					array(
						'header'=>'Jumlah Potongan',
						'type'=>'raw',
						'value'=>function($data) use ($form, $permintaan) {
							return
							$form->textField($permintaan, '[angsuran]['.$data->jmlangsuran_id.']jmlpengajuan_pengangsuran', array('value'=>MyFormatter::formatNumberForPrint($data->jumlahpotongan), 'class'=>'form-control num')).
							$form->hiddenField($permintaan, '[angsuran]['.$data->jmlangsuran_id.']jmlpotongan_sumber', array('value'=>MyFormatter::formatNumberForPrint($data->jumlahpotongan), 'class'=>'form-control'));
						},
					),
				),
				'afterAjaxUpdate'=>'function(id, data) {registerNum(); hitungTotalAngsuran(); }',
			));
		?>
	</div>



<script type="text/javascript">
//color font and hover header column
//$('#permintaan-m-grid').find("table >thead >tr >th").css({ 'color': '#373E4A'});
//	$('#permintaan-m-grid').find("table >thead >tr >th").hover(function() {
//	  $(this).css("color","#818DA2");
  //   },function(){
//		  $(this).css("color","#373E4A");
//	  });

//$(document).ajaxSuccess(function() {
	//alert("An individual AJAX call has completed successfully");
	//$( "#pegawai-m-grid" ).find("table >thead").replaceWith(header);

  // $('#permintaan-m-grid').find("table >thead >tr >th").css({ 'color': '#373E4A'});
//	$('#permintaan-m-grid').find("table >thead >tr >th").hover(function() {
//	  $(this).css("color","#818DA2");
  //   },function(){
//		  $(this).css("color","#373E4A");
//	  });
//});
</script>
