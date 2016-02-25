<h6>Tabel Monitoring <b>Rawat Darurat</b></h6>
<?php $this->widget('ext.bootstrap.widgets.BootGridView', array(
	'id'=>'monitoring-v-grid',
	'dataProvider'=>$model->searchTable(),
                'itemsCssClass'=>'table table-striped table-condensed',
	'columns'=>array(
                        array(
                            'header'=>'No.',
                            'value'=>'$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1',
                        ),  
                        array(
                            'header'=>'Tanggal Pendaftaran',
                            'value'=>'$data->tgl_pendaftaran',
                        ),
                        array(
                            'header'=>'No. Pendaftaran',
                            'value'=>'$data->no_pendaftaran',
                        ),
                        array(
                            'header'=>'No. Rekam Medik',
                            'value'=>'$data->no_rekam_medik',
                        ),
                        array(
                            'header'=>'Nama Pasien',
                            'value'=>'$data->nama_pasien',
                        ),
                        array(
                            'header'=>'Jenis Kelamin',
                            'value'=>'$data->jeniskelamin',
                        ),
                        array(
                            'header'=>'Jenis Kasus Penyakit',
                            'value'=>'$data->jeniskasuspenyakit_nama',
                        ),
                        array(
                            'header'=>'Dokter',
                            'value'=>function($data){
                                $p = PendaftaranT::model()->findByPk($data->pendaftaran_id);
                                return $p->pegawai->namaLengkap;
                            },
                        ),
                        array(
                            'header'=>'Cara Bayar / Penjamin',
                            'value'=>'$data->carabayar_nama." / ".$data->penjamin_nama',
                        ),
                         array(
                            'header'=>'Status Periksa',
                            'value'=>'$data->statusperiksa',
                        ),
                      /*  array(
                            'header'=>'Poliklinik',
                            'value'=>'$data->ruangan_nama',
                        ),                                               */
                       
                        array(
                            'header'=>'Cara Keluar',
                            'value'=>'$data->carakeluar',
                        ),
                        array(
                            'header'=>'Status Bayar',
                            'value'=>'$data->carabayar_nama',
                        ),
                        array(
                            'header'=>'Alih Status',
                            'value'=>'$data->alihstatus',
                        ),
//		'pasien_id',
//		'namadepan',
//		'nama_pasien',
//		'nama_bin',
//		'jeniskelamin',
//		'no_rekam_medik',
		/*
		'pendaftaran_id',
		'no_pendaftaran',
		'tgl_pendaftaran',
		'no_urutantri',
		'statusperiksa',
		'statuspasien',
		'kunjungan',
		'umur',
		'carabayar_id',
		'carabayar_nama',
		'penjamin_id',
		'penjamin_nama',
		'ruangan_id',
		'ruangan_nama',
		'instalasi_id',
		'instalasi_nama',
		'jeniskasuspenyakit_id',
		'jeniskasuspenyakit_nama',
		'kelaspelayanan_id',
		'kelaspelayanan_nama',
		'pembayaranpelayanan_id',
		'alihstatus',
		'pasienbatalperiksa_id',
		*/
//		array(
//			'class'=>'CButtonColumn',
//		),
	),
)); ?>