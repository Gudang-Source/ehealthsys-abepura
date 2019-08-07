
		<?php
				 $this->widget('ext.bootstrap.widgets.BootGridView',array(
				'id'=>'kartuangsuran-m-grid',
				'dataProvider'=>$angsuran->searchInformasi(),
				//'filter'=>$angsuran,
				'itemsCssClass' => 'table table-striped table-condensed',
				'columns'=>array(
					/*array(
                'header' => 'No',
                'value' => '$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1'
            	),*/
            	array(
						'header'=>'Tgl Pinjaman/ <br/>No Pinjaman',
						'type'=>'raw',
						'value'=>'MyFormatter::formatDateTimeForUser(date("d/m/Y", strtotime($data->tglpinjaman)))."/ <br/>".
						CHtml::link("<i class=\"entypo-doc-text\"></i>".$data->no_pinjaman, "#", array("onclick"=>"lihatDetail(".$data->pinjaman_id."); return false;","rel"=>"tooltip","title"=>"Klik Untuk Melihat Informasi Pinjaman"))',
						'htmlOptions'=>array('nowrap'=>true),
					//	'headerHtmlOptions'=>array('style'=>'color:#373E4A'),
					),
					/*array(
						'header'=>'Unit Kerja',
						'type'=>'raw',
						'value'=>'$data->namaunit',
						'headerHtmlOptions'=>array('style'=>'color:#373E4A'),
						'filter'=>CHtml::activeDropDownList($angsuran, 'namaunit', CHtml::listData(UnitM::model()->findAll(),'namaunit','namaunit'), array('empty'=>'-- Pilih --')),
					),*/
					array(
						'header'=>'Golongan',
						'type'=>'raw',
						'value'=>'$data->golonganpegawai_nama',
						//'headerHtmlOptions'=>array('style'=>'color:#373E4A'),
					//	'filter'=>CHtml::activeDropDownList($angsuran, 'golonganpegawai_id', CHtml::listData(GolonganpegawaiM::model()->findAll(array('order'=>'golonganpegawai_nama')),'golonganpegawai_id','golonganpegawai_nama'), array('empty'=>'-- Pilih --')),
					),
					array(
						'header'=>'Nomor Anggota',
						'type'=>'raw',
						'value'=>'$data->nokeanggotaan',
						//'headerHtmlOptions'=>array('style'=>'color:#373E4A'),
					),
					array(
						'header'=>'Nama Anggota',
						'type'=>'raw',
						'value'=>'$data->nama_pegawai',
					//	'headerHtmlOptions'=>array('style'=>'color:#373E4A'),
					),
					array(
						'header'=>'Tgl Angsuran',
						'type'=>'raw',
						'value'=>'empty($data->tglangsuran)?"-":MyFormatter::formatDateTimeForUser(date("d/m/Y", strtotime($data->tglangsuran)))',
						'htmlOptions'=>array('style'=>'text-align:right'),
						//'headerHtmlOptions'=>array('style'=>'color:#373E4A'),
					),
					array(
						'header'=>'Tgl Jatuh Tempo',
						'type'=>'raw',
						'value'=>'MyFormatter::formatDateTimeForUser(date("d/m/Y", strtotime($data->tgljatuhtempoangs)))',
					//	'headerHtmlOptions'=>array('style'=>'color:#373E4A'),
					),
					array(
						'header'=>'Angsuran Ke',
						'type'=>'raw',
						'value'=>'$data->angsuran_ke',
						'htmlOptions'=>array('style'=>'text-align:center'),
						//'headerHtmlOptions'=>array('style'=>'color:#373E4A'),
					),
					array(
						'header'=>'Angsuran Pokok',
						'type'=>'raw',
						'value'=>'empty($data->jmlpokok_angsuran)?"-":MyFormatter::formatNumberForPrint($data->jmlpokok_angsuran)',
						'htmlOptions'=>array('style'=>'text-align:right'),
					//	'headerHtmlOptions'=>array('style'=>'color:#373E4A'),
					),
					array(
						'header'=>'Jasa Angsuran',
						'type'=>'raw',
						'value'=>'empty($data->jmljasa_angsuran)?"-":MyFormatter::formatNumberForPrint($data->jmljasa_angsuran)',
						'htmlOptions'=>array('style'=>'text-align:right'),
					//	'headerHtmlOptions'=>array('style'=>'color:#373E4A'),
					),
					array(
						'header'=>'Total Angsuran',
						'type'=>'raw',
						'value'=>'MyFormatter::formatNumberForPrint(
							(empty($data->jmlpokok_angsuran)?0:$data->jmlpokok_angsuran) +
							(empty($data->jmljasa_angsuran)?0:$data->jmljasa_angsuran))',
						'htmlOptions'=>array('style'=>'text-align:right'),
						//'headerHtmlOptions'=>array('style'=>'color:#373E4A'),
					),
					array(
						'header'=>'Jml Pembayaran',
						'type'=>'raw',
						'value'=>'(!empty($data->jmlpembayaran)) ? MyFormatter::formatNumberForPrint($data->jmlpembayaran) : "0"',
						'htmlOptions'=>array('style'=>'text-align:right'),
						//'headerHtmlOptions'=>array('style'=>'color:#373E4A'),
					),
					array(
						'header'=>'Status Angsuran',
						'type'=>'raw',
						//'value'=>'($data->isudahbayar)? "LUNAS":"BELUM LUNAS"',
                                                'value' => '$data->statuspinjaman'
					//	'headerHtmlOptions'=>array('style'=>'color:#373E4A'),
					//	'filter'=>CHtml::activeDropDownList($angsuran, 'statuspinjaman', array('LUNAS'=>'LUNAS','BELUM LUNAS'=>'BELUM LUNAS'), array('empty'=>'-- Pilih --')),
					),
					array(
						'header'=>'Bayar',
						'type'=>'raw',
						'value'=>function($data) {
							if ($data->isudahbayar == false)
							return CHtml::link('<i class="entypo-window"></i>', Yii::app()->controller->createUrl('pembayaranAngsuran/index', array('no'=>$data->no_pinjaman, 'idAngsuran'=>$data->jmlangsuran_id,'ke'=>$data->angsuran_ke)), array('data-toggle'=>'tooltip', 'title'=>'Klik untuk membayar angsuran pinjaman.'));
							else {
								return "-";
							}
						},
					//	'headerHtmlOptions'=>array('style'=>'color:#373E4A'),
					),
					array(
						'header'=>'Penangguhan',
						'type'=>'raw',
						'value'=>function($data) {

							$bayar = PembayaranangsuranT::model()->findAllByAttributes(array('jmlangsuran_id'=>$data->jmlangsuran_id), array('condition'=>'pengajuanpembayaran_id is not null'));
							$str = '';

							if (count($bayar) == 0) return '-';

							foreach ($bayar as $item) {
								$pengajuan = PengajuanpembayaranT::model()->findByPk($item->pengajuanpembayaran_id);
								$penangguhan = PermohonanpenangguhanT::model()->findByAttributes(array('pengajuanpembayaran_id'=>$pengajuan->pengajuanpembayaran_id));
								if (!empty($penangguhan)) {
									$str = "Sudah diajukan";
									break;
								}
								$str .= $pengajuan->nopengajuan.CHtml::link('<i class="entypo-cancel-circled"></i>', Yii::app()->controller->createUrl('/pinjaman/PenangguhanAngsuran/index', array('id'=>$item->pengajuanpembayaran_id)), array('target'=>'_blank','data-toggle'=>'tooltip', 'title'=>'Klik untuk koreksi angsuran.'))."<br/>";
							}
							$str = $str == ''?"-":$str;
							return $str;
						},
						'htmlOptions'=>array('style'=>'text-align: center;'),
						//'headerHtmlOptions'=>array('style'=>'color:#373E4A'),
					),
				),
			));
		?>
	