<?php $this->widget('ext.bootstrap.widgets.BootGridView',array(
	'id'=>'rjrinciantagihanpasien-v-grid',
	'dataProvider'=>$model->searchDaftarPasienRincian(),
//	'filter'=>$model,
        'template'=>"{summary}\n{items}\n{pager}",
        'itemsCssClass'=>'table table-striped table-condensed',
	'columns'=>array(
				array(
                                    'name'=>'Tgl. Pendaftaran<br/>No. Pendaftaran',
					'name'=>'tgl_pendaftaran',
					'type'=>'raw',
					'value'=>'MyFormatter::formatDateTimeForUser($data->tgl_pendaftaran)."<br/>".$data->no_pendaftaran',
				),
                array(
                    'header'=>'No. Rekam Medik',
                    'type'=>'raw',
                    'value'=>'$data->no_rekam_medik',
                ),
                array(
                    'header'=>'Nama Pasien',
                    'type'=>'raw',
                    'value'=>'$data->namadepan.$data->nama_pasien',
                ),
//                'nama_pegawai',
                array(
                    'header'=>'Dokter',
                    'type'=>'raw',
                    'value'=>'$data->gelardepan.$data->nama_pegawai.",".$data->gelarbelakang_nama',
                ),
                'jeniskasuspenyakit_nama',
                array(
                    'name'=>'statusperiksa',
                ),
                array(
                    'header'=>'Cara Bayar<br/>Penjamin',
                    'type'=>'raw',
                    'value'=>'$data->CaraBayarPenjamin',
                ),
                array(
                    'header'=>'Total Tagihan',
                    'type'=>'raw',
                    'value'=>'number_format($data->Totaltagihan,0,\',\',\'.\')',  
                    'htmlOptions'=>array('style'=>'text-align:right;'),
                ),
                array(
                    'header'=>'Status Bayar',
                    'type'=>'raw',
                    'value'=>'(empty($data->pembayaranpelayanan_id)) ? "Belum Lunas" : "Lunas"' ,
                ),
//                'totaltagihan',
                array(
                    'header'=>'Rincian',
                    'type'=>'raw',
                    'value'=>'CHtml::link("<icon class=\'icon-form-detail\'></idcon>", Yii::app()->createUrl("billingKasir/PembayaranTagihanPasien/PrintRincianBelumBayar", array("instalasi_id"=>Yii::app()->user->getState(\'instalasi_id\'), "pendaftaran_id"=>$data->pendaftaran_id, "frame"=>1)), array("target"=>"frameRincian", "rel"=>"tooltip", "title"=>"lihat rincian tagihan pasien", "onclick"=>"$(\'#dialogRincian\').dialog(\'open\');"))','htmlOptions'=>array('style'=>'text-align:left; width:40px')
                ),		
	),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',

)); ?>