<?php if (isset($caraPrint)){
  $data = $model->searchPrint();  
  $template = "{items}";
  $sort = false;
} else{
  $data = $model->searchTable();
  $template = "{summary}\n{items}\n{pager}";
  $sort = true;
}
?>

<?php $this->widget('ext.bootstrap.widgets.HeaderGroupGridView',array(
	'id'=>'tableLaporan',
	'dataProvider'=>$data,
        'enableSorting'=>$sort,
        'template'=>$template,
        'mergeHeaders'=>array(
            array(
                'name'=>'<center>Tarif</center>',
                'start'=>7, //indeks kolom 3
                'end'=>8, //indeks kolom 4
            ),
        ),
        'itemsCssClass'=>'table table-striped table-condensed',
	'columns'=>array(
                array(
                    'header' => 'No.',
                    'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:center;'),
                    'value' => '(($this->grid->dataProvider->pagination) ? $this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize : 0) + $row+1'
                ),
                array(
                    'name'=>'no_rekam_medik',
                    'headerHtmlOptions'=>array('style'=>'vertical-align:middle;'),
                ),
                array(
                    'name'=>'nama_pasien',
                    'headerHtmlOptions'=>array('style'=>'vertical-align:middle;'),
                ),
                array(
                    'name'=>'no_pendaftaran',
                    'headerHtmlOptions'=>array('style'=>'vertical-align:middle;'),
                ),
                array(
                    'name'=>'nama_pegawai',
                    'headerHtmlOptions'=>array('style'=>'vertical-align:middle;'),
                ),
                array(
                    'header'=>'Cara Bayar Penjamin',
                    'name'=>'carabayarPenjamin',
                    'headerHtmlOptions'=>array('style'=>'vertical-align:middle;'),
                ),
                array(
                    'header'=>'Kelas Pelayanan',
                    'value'=>'$data->kelaspelayanan_nama',
//                    'name'=>'kelaspelayanan_nama',
                    'headerHtmlOptions'=>array('style'=>'vertical-align:middle;'),
                ),
                array(
                    'header'=>'Tarif Satuan',
                    'type'=>'raw',
                    'value'=>'"Rp. ".number_format($data->tarif_satuan)',
//                    'name'=>'tarif_satuan',
                    'headerHtmlOptions'=>array('style'=>'vertical-align:middle;'),
                ),
                array(
                    'header'=>'Tarif Cyto Tindakan',
                    'type'=>'raw',
                    'value'=>'"Rp. ".number_format($data->tarifcyto_tindakan)',
//                    'name'=>'tarifcyto_tindakan',
                    'headerHtmlOptions'=>array('style'=>'vertical-align:middle;'),
                ),
                array(
                    'header'=>'Tarif RS Akomodasi',
                    'type'=>'raw',
                    'value'=>'"Rp. ".number_format($data->tarif_rsakomodasi)',
//                    'name'=>'tarif_rsakomodasi',
                    'headerHtmlOptions'=>array('style'=>'vertical-align:middle;'),
                ),
                array(
                    'header'=>'Tarif Medis',
                    'type'=>'raw',
                    'value'=>'"Rp. ".number_format($data->tarif_medis)',
//                    'name'=>'tarif_medis',
                    'headerHtmlOptions'=>array('style'=>'vertical-align:middle;'),
                ),
                array(
                    'header'=>'Tarif Paramedis',
                    'type'=>'raw',
                    'value'=>'"Rp. ".number_format($data->tarif_paramedis)',
//                    'name'=>'tarif_paramedis',
                    'headerHtmlOptions'=>array('style'=>'vertical-align:middle;'),
                ),
                array(
                    'header'=>'Tarif Bhp',
                    'type'=>'raw',
                    'value'=>'"Rp. ".number_format($data->tarif_bhp)',
//                    'name'=>'tarif_bhp',
                    'headerHtmlOptions'=>array('style'=>'vertical-align:middle;'),
                ),
                array(
                    'header'=>'Total',
                    'type'=>'raw',
                    'value'=>'"Rp. ".number_format($data->totalTarif)',
                    'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:center;'),
                ),
            
//                'profilrs_id',
//                'pasien_id',
//                'no_rekam_medik',
//                'tgl_rekam_medik',
//                'jenisidentitas',
//                'no_identitas_pasien',
                /*
                'namadepan',
                'nama_pasien',
                'nama_bin',
                'jeniskelamin',
                'tempat_lahir',
                'tanggal_lahir',
                'alamat_pasien',
                'rt',
                'rw',
                'statusperkawinan',
                'agama',
                'golongandarah',
                'rhesus',
                'anakke',
                'jumlah_bersaudara',
                'no_telepon_pasien',
                'no_mobile_pasien',
                'warga_negara',
                'photopasien',
                'alamatemail',
                ////'pendaftaran_id',
                array(
                                'name'=>'pendaftaran_id',
                                'value'=>'$data->pendaftaran_id',
                                'filter'=>false,
                        ),
                'no_pendaftaran',
                'tgl_pendaftaran',
                'umur',
                'no_asuransi',
                'namapemilik_asuransi',
                'nopokokperusahaan',
                'namaperusahaan',
                'tglselesaiperiksa',
                'tindakanpelayanan_id',
                'penjamin_id',
                'penjamin_nama',
                'carabayar_id',
                'carabayar_nama',
                'kelaspelayanan_id',
                'kelaspelayanan_nama',
                'instalasi_id',
                'instalasi_nama',
                'ruangan_id',
                'ruangan_nama',
                'tgl_tindakan',
                'daftartindakan_id',
                'daftartindakan_kode',
                'daftartindakan_nama',
                'tipepaket_id',
                'tipepaket_nama',
                'daftartindakan_karcis',
                'daftartindakan_visite',
                'daftartindakan_konsul',
                'tarif_rsakomodasi',
                'tarif_medis',
                'tarif_paramedis',
                'tarif_bhp',
                
                'tarif_tindakan',
                'satuantindakan',
                'qty_tindakan',
                'cyto_tindakan',
                'tarifcyto_tindakan',
                'discount_tindakan',
                'pembebasan_tindakan',
                'subsidiasuransi_tindakan',
                'subsidipemerintah_tindakan',
                'subsisidirumahsakit_tindakan',
                'iurbiaya_tindakan',
                'create_time',
                'update_time',
                'create_loginpemakai_id',
                'update_loginpemakai_id',
                'create_ruangan',
                'tindakansudahbayar_id',
                'shift_id',
                'shift_nama',
                */
	),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
)); ?>