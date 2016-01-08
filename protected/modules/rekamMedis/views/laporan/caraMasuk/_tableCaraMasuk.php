
<?php
$table = 'ext.bootstrap.widgets.BootGridView';
$template = "{summary}\n{items}\n{pager}";
if (isset($caraPrint)){
  $data = $model->searchPrint();
  $template = "{items}";
  if ($caraPrint=='EXCEL') {
      $table = 'ext.bootstrap.widgets.BootExcelGridView';
  }
} else{
  $data = $model->searchTable();
}
?>

<?php $this->widget($table,array(
	'id'=>'tableLaporan',
	'dataProvider'=>$data,
        'template'=>$template,
        'itemsCssClass'=>'table table-striped table-condensed',
	'columns'=>array(
//            'instalasi_nama',
            array(
                'header'=>'Status Masuk',
                'type'=>'raw',
                'value'=>'$data->statusmasuk',
            ),
            array(
                'header'=>'No. Rekam Medik',
                'type'=>'raw',
                'value'=>'$data->no_rekam_medik',
            ),
            array(
                'header'=>'Nama Pasien',
                'type'=>'raw',
                'value'=>'$data->nama_pasien',
            ),
//            'nama_pasien',
            array(
                'header'=>'No. Pendaftaran',
                'type'=>'raw',
                'value'=>'$data->no_pendaftaran',
            ),
//            'no_pendaftaran',
            array(
                'header'=>'Umur',
                'type'=>'raw',
                'value'=>'$data->umur',
            ),
//            'umur',
            array(
                'header'=>'Jenis Kelamin',
                'type'=>'raw',
                'value'=>'$data->jeniskelamin',
            ),
//            'jeniskelamin',
            array(
                'header'=>'Alamat Pasien',
                'type'=>'raw',
                'value'=>'$data->alamat_pasien',
            ),
//            'alamat_pasien',
            array(
                'header'=>'Nama Kelas Pelayanan',
                'type'=>'raw',
                'value'=>'$data->kelaspelayanan_nama',
            ),
//            'kelaspelayanan_nama',
            array(
                'header'=>'Nama Asal Rujukan',
                'type'=>'raw',
                'value'=>'$data->asalrujukan_nama',
            ),
//            'asalrujukan_nama',
            array(
                'header'=>'Nama Jenis Kasus Penyakit',
                'type'=>'raw',
                'value'=>'$data->jeniskasuspenyakit_nama',
            ),
//            'jeniskasuspenyakit_nama',
//            'catatan_dokter_konsul',
//            'statusperiksa',
//            array(
//                   'header'=>'CaraBayar/Penjamin',
//                   'type'=>'raw',
//                   'value'=>'$data->CaraBayarPenjamin',
//                   'htmlOptions'=>array('style'=>'text-align: center')
//            ),  
//            'alamat_pasien',   
	),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
)); ?>