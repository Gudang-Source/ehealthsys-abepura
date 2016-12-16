

	<div class="span12">
		<?php
			$this->widget('ext.bootstrap.widgets.BootGridView',array(
				'id'=>'peminjam-m-grid',
				'dataProvider'=>$pinjaman->searchPeminjamAsuransi(),
				'enableSorting'=>false,
				//'filter'=>$pegawai,
				'itemsCssClass' => 'table table-striped table-bordered table-condensed',
				'afterAjaxUpdate'=>'function(id, data) {hitungKasKeluar();}',
				'columns'=>array(
					array(
						'header'=> 'Pilih  '.CHtml::checkBox('check_all', false, array('onchange'=>'pilihSemua();')),
						'type'=>'raw',
						'value'=>function($data) {
							return CHtml::checkBox('asuransi['.$data->potonganasuransi_id.']', false, array('uncheckValue'=>null, 'class'=>'checker', 'onchange'=>'hitungKasKeluar();'));
						},
					),
					array(
						'header'=>'Tgl Pinjaman',
						'type'=>'raw',
						'value'=>'date("d/m/Y", strtotime($data->tglpinjaman))',
					),
					'no_pinjaman',
                                        array(
                                            'header' => 'No Keanggotaan',
                                            'name' => 'nokeanggotaan',
                                        ),
					
					'nama_pegawai',
					array(
						'header'=>'Umur',
						'type'=>'raw',
						'value'=>'$data->umuranggota_thn." Tahun"',
					),
					array(
						'header'=>'Lama Asuransi',
						'type'=>'raw',
						'value'=>'$data->lamaasuransi_thn." Tahun"',
					),
					array(
						'header'=>'Premi Asuransi',
						'type'=>'raw',
						'value'=>'number_format($data->premi_asuransi_persen, 2, ",", ".")',
						'htmlOptions'=>array('style'=>'text-align: right'),
					),
					array(
						'header'=>'Biaya Asuransi',
						'type'=>'raw',
						'value'=>function($data) {
							return MyFormatter::formatNumberForPrint($data->jml_biayaasuransi);
						},
						'htmlOptions'=>array('style'=>'text-align: right', 'class'=>'biaya'),
					),
				)
			));
		?>
	</div>

