<?php 
$table = 'ext.bootstrap.widgets.HeaderGroupGridView';
$data = $model->searchTable();
$sort = true;
$template = "{summary}\n{items}\n{pager}";
if (isset($caraPrint)){
  $sort = false;
  $data = $model->searchPrint();  
  $template = "{items}";
  if ($caraPrint == "EXCEL")
      $table = 'ext.bootstrap.widgets.BootExcelGridView';
}
?>

<?php $this->widget($table,array(
	'id'=>'tableLaporan',
        'enableSorting'=>$sort,
	'dataProvider'=>$data,
        'template'=>$template,
        'mergeHeaders'=>array(
//            array(
//                'name'=>'<center>Tindakan</center>',
//                'start'=>6, //indeks kolom 3
//                'end'=>11, //indeks kolom 4
//            ),
//            array(
//                'name'=>'<center>Karcis</center>',
//                'start'=>13, //indeks kolom 3
//                'end'=>16, //indeks kolom 4
//            ),
        ),
        'itemsCssClass'=>'table table-striped table-condensed',
	'columns'=>array(
                array(
                    'header' => 'No',
                    'headerHtmlOptions'=>array('style'=>'text-align: center;vertical-align:middle;'),
                    'value' => '$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1'
                ),
                        array(
                    'header'=>'No. Pendaftaran/<br/>No. Rekam Medis',
                    'type'=>'raw',
                    'value'=>'$data->RM',
                ),
                        array(
                    'header'=>'Nama Pasien /<br/>Bin/Binti ',
                    'type'=>'raw',
                    'value'=>'$data->Nama',
                ),
                        array( 
                    'header'=>'Alamat /<br/>RT/RW ',
                    'type'=>'raw',
                    'value'=>'$data->Alamat',
                ),
            array(
                    'header'=>'Jenis Kelamin /<br/>Umur ',
                    'type'=>'raw',
                    'value'=>'$data->Umur',
                ),
                        array(
                    'header'=>'Cara Bayar /<br/>Penjamin ',
                    'type'=>'raw',
                    'value'=>'$data->Carabayar',
                ),
                        array(
                    'header'=>'Golongan Darah /<br/>Status Masuk ',
                    'type'=>'raw',
                    'value'=>'$data->Status',
                ),
                        array(
                    'header'=>'Transportasi /<br/>Keadaan Masuk ',
                    'type'=>'raw',
                    'value'=>'$data->Transportasi',
                ),
//        'pasien_id',
//        'jenisidentitas',
//        'no_identitas_pasien',
//        'namadepan',
//        'nama_pasien',
//        'nama_bin',
            
        
//        'jeniskelamin',
//        'tempat_lahir',
//        'tanggal_lahir',
//        'alamat_pasien',
//        'rt',
//        'rw',
//        'agama',
//        'golongandarah',
//        'photopasien',
//        'alamatemail',
//        'statusrekammedis',
//        'statusperkawinan',
//        'no_rekam_medik',
//        'tgl_rekam_medik',
//        'propinsi_id',
//        'propinsi_nama',
//        'kabupaten_id',
//        'kabupaten_nama',
//        'kelurahan_id',
//        'kelurahan_nama',
//        'kecamatan_id',
//        'kecamatan_nama',
//        'pendaftaran_id',
//        'no_pendaftaran',
//        'tgl_pendaftaran',
//        'no_urutantri',
//        'transportasi',
//        'keadaanmasuk',
//        'statusperiksa',
//        'statuspasien',
//        'kunjungan',
//        'alihstatus',
//        'byphone',
//        'kunjunganrumah',
//        'statusmasuk',
//        'umur',
//        'no_asuransi',
//        'namapemilik_asuransi',
//        'nopokokperusahaan',
//        'create_time',
//        'create_loginpemakai_id',
//        'create_ruangan',
//        'carabayar_id',
//        'carabayar_nama',
//        'penjamin_id',
//        'penjamin_nama',
//        'shift_id',
//        ////'ruangan_id',
//        array(
//                        'name'=>'ruangan_id',
//                        'value'=>'$data->ruangan_id',
//                        'filter'=>false,
//                ),
//        'ruangan_nama',
//        'instalasi_id',
//        'instalasi_nama',
//        'jeniskasuspenyakit_id',
//        'jeniskasuspenyakit_nama',
//        'kelaspelayanan_id',
//        'kelaspelayanan_nama',
//        'pasienkecelakaan_id',
//        'jeniskecelakaan_id',
        'jeniskecelakaan_nama',
        'tglkecelakaan',
      'tempatkecelakaan',
//        'keterangankecelakaan',
                
	),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
)); ?>