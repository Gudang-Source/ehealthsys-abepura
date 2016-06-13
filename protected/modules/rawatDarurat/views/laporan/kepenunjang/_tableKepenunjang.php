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
$sort=true;
?>

<?php $this->widget($table,array(
	'id'=>'tableLaporan',
        'enableSorting'=>$sort,
	'dataProvider'=>$data,
        'template'=>$template,
        'itemsCssClass'=>'table table-striped table-condensed',
	'columns'=>array(
//            'instalasi_nama',
            array(
                'header'=> 'Tgl Masuk Penunjang',
                'value' => '$data->tglmasukpenunjang'
            ),            
            array(
                'header'=> 'No Rekam Medik',
                'value' => '$data->no_rekam_medik'
            ),
              array(
                'header'=> 'Nama Pasien',
                'value' => '$data->namadepan." ".$data->nama_pasien'
            ),
             array(
                'header'=> 'No Pendaftaran',
                'value' => '$data->no_pendaftaran'
            ),
           array(
                'header'=> 'Umur',
                'value' => '$data->umur'
            ),
            array(
                'header'=> 'Jenis Kelamin',
                'value' => '$data->jeniskelamin'
            ),           
          array(
              'header'=>'Ruangan Penunjang',
              'value'=>'$data->ruanganpenunj_nama',
          ),
//            'ruanganpenunj_nama',
//            'catatan_dokter_konsul',
             array(
              'header'=>'Status Periksa',
              'value'=>'$data->statusperiksa',
          ),
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