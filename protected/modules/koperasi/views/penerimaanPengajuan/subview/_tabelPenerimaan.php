
	<div class="span12">
			<?php
			$this->widget('ext.bootstrap.widgets.BootGridView',array(
				'id'=>'permintaan-m-grid',
				'dataProvider'=>$permintaanv->searchPengajuPotongan(),
				'filter'=>null,
				//'template' => "{items}",
				'itemsCssClass' => 'table table-striped table-bordered table-condensed',
				'columns'=>array(
					array(
						'header'=>'Pilih '.CHtml::checkbox('cekSemua', false),
						'type'=>'raw',
						'value'=>function($data) use ($angsuran, $form) {
							$angsuran = PembayaranangsuranT::model()->findByAttributes(array('pengajuanpembayaran_id'=>$data->pengajuanpembayaran_id));
							$bayar = PengajuanpembayaranT::model()->findByPk($data->pengajuanpembayaran_id);
							$angsuran2 = JmlangsuranT::model()->findByPk($bayar->jmlangsuran_id);

							$str = '';

							if (!empty($angsuran)) $data->simpananwajib = $data->simpanansukarela = 0;

							// SimpananT[<jenissimpanan_id>][<keanggotaan_id>]
							$str .= CHtml::hiddenField('SimpananT[2]['.$data->keanggotaan_id.']['.$angsuran2->jmlangsuran_id.']', $data->simpananwajib, array('class'=>'wajib'));
							$str .= CHtml::hiddenField('SimpananT[3]['.$data->keanggotaan_id.']['.$angsuran2->jmlangsuran_id.']', $data->simpanansukarela, array('class'=>'sukarela'));

							//PembayaranangsuranT[<jmlangsuran_id>][...]
							$str .= CHtml::hiddenField('PembayaranangsuranT['.$angsuran2->jmlangsuran_id.'][jmlpokok_byangsuran]', $data->jmlpokok_angsuran, array('class'=>'jmlpokok'));
							$str .= CHtml::hiddenField('PembayaranangsuranT['.$angsuran2->jmlangsuran_id.'][jmljasa_byangsuran]', $data->jmljasa_angsuran, array('class'=>'jmljasa'));
							$str .= CHtml::hiddenField('PembayaranangsuranT['.$angsuran2->jmlangsuran_id.'][jmlpengajuan]', ($data->sisa), array('class'=>'jmlpengajuan'));
							$str .= CHtml::hiddenField('PembayaranangsuranT['.$angsuran2->jmlangsuran_id.'][jml_bayar]', ($data->jmlpotongan_sumber - ($data->simpananwajib + $data->simpanansukarela)), array('class'=>'jmlpengajuan'));
							$str .= CHtml::hiddenField('PembayaranangsuranT['.$angsuran2->jmlangsuran_id.'][keanggotaan_id]', $data->keanggotaan_id);
							$str .= CHtml::hiddenField('PembayaranangsuranT['.$angsuran2->jmlangsuran_id.'][pengajuanpembayaran_id]', $data->pengajuanpembayaran_id);
							$str .= CHtml::hiddenField('PembayaranangsuranT['.$angsuran2->jmlangsuran_id.'][potongansumber_id]', $data->potongansumber_id);
							$str .= CHtml::hiddenField('PembayaranangsuranT['.$angsuran2->jmlangsuran_id.'][jmlangsuran_id]', $angsuran2->jmlangsuran_id);
							$str .= CHtml::hiddenField('PembayaranangsuranT['.$angsuran2->jmlangsuran_id.'][byangsuranke]', $angsuran2->angsuran_ke);
							$str .= CHtml::hiddenField('PembayaranangsuranT['.$angsuran2->jmlangsuran_id.'][sisa]', $angsuran2->sisa);


							return $str.CHtml::checkBox('PembayaranangsuranT['.$angsuran2->jmlangsuran_id.'][check]', false, array('defaultValue'=>0, 'class'=>'check'));
						},
						//'headerHtmlOptions'=>array('style'=>'color:#373e4a;'),
					),
					array(
						'header'=>'Tgl Jatuh Tempo',
						'type'=>'raw',
						'value'=>'$data->tgljatuhtempoangs',
						//'headerHtmlOptions'=>array('style'=>'color:#373e4a;'),
					),
					array(
						'header'=>'No Anggota',
						'type'=>'raw',
						'value'=>'$data->nokeanggotaan',
						//'headerHtmlOptions'=>array('style'=>'color:#373e4a;'),
					),
					array(
						'header'=>'Nama Anggota',
						'type'=>'raw',
						'value'=>'$data->nama_pegawai',
						//'headerHtmlOptions'=>array('style'=>'color:#373e4a;'),
					),
					array(
						'header'=>'Unit',
						'type'=>'raw',
						'value'=>'$data->namaunit',
						//'headerHtmlOptions'=>array('style'=>'color:#373e4a;'),
					),
					array(
						'header'=>'Simpanan Wajib',
						'type'=>'raw',
						'value'=>'MyFormatter::formatNumberForPrint($data->simpananwajib)',
						'htmlOptions'=>array('style'=>'text-align: right'),
						//'headerHtmlOptions'=>array('style'=>'color:#373e4a;'),
					),
					array(
						'header'=>'Simpanan Sukarela',
						'type'=>'raw',
						'value'=>function($data) {
								return MyFormatter::formatNumberForPrint($data->simpanansukarela);
							},//'MyFormatter::formatNumberForPrint($data->simpanansukarela)',
						'htmlOptions'=>array('style'=>'text-align: right'),
						//'headerHtmlOptions'=>array('style'=>'color:#373e4a;'),
					),
					array(
						'header'=>'Jumlah Angsuran',
						'type'=>'raw',
						'value'=>'MyFormatter::formatNumberForPrint($data->jmlpokok_angsuran + $data->jmljasa_angsuran)',
						'htmlOptions'=>array('style'=>'text-align: right'),
						//'headerHtmlOptions'=>array('style'=>'color:#373e4a;'),
					),
					array(
						'header'=>'Jumlah Denda',
						'type'=>'raw',
						'value'=>function($data) use ($angsuran, $form) {
							$bayar = PengajuanpembayaranT::model()->findByPk($data->pengajuanpembayaran_id);
							$angsuran2 = JmlangsuranT::model()->findByPk($bayar->jmlangsuran_id);
							return CHtml::textField('PembayaranangsuranT['.$angsuran2->jmlangsuran_id.'][jmldenda_byrangsuran]', 0, array('class'=>'form-control num denda'));
						},
						//'headerHtmlOptions'=>array('style'=>'color:#373e4a;'),
					),
					array(
						'header'=>'Jumlah Bayar',
						'type'=>'raw',
						'value'=>function($data) use ($angsuran, $form) {
							$bayar = PengajuanpembayaranT::model()->findByPk($data->pengajuanpembayaran_id);
							$angsuran2 = JmlangsuranT::model()->findByPk($bayar->jmlangsuran_id);

							return CHtml::textField('PembayaranangsuranT['.$angsuran2->jmlangsuran_id.'][sub_total]', $data->simpananwajib + $data->simpanansukarela + $data->jmlpokok_angsuran + $data->jmljasa_angsuran, array('class'=>'form-control subtotal num', 'onblur'=>'hitungBKM()', 'readonly'=>false));
						},
						//'headerHtmlOptions'=>array('style'=>'color:#373e4a;'),
					),
				),
				'afterAjaxUpdate'=>'function(id, data) {registerNum(); cekSemua(); hitungAngsuran();}',
			));
		?>
	</div>

