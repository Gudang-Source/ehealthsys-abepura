<?php
$table = 'ext.bootstrap.widgets.BootGridView';
$template = "{summary}\n{items}\n{pager}";
if (isset($caraPrint)){
  $data = $model->searchPrint();
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
//    'filter'=>$model,
        'template'=>$template,
        'itemsCssClass'=>'table table-striped table-condensed',
    'columns'=>array(
        array(
            'header' => 'No',
            'value' => '$row+1'
        ),
        'tgldirujuk',
         array(
            'header' => 'No.Pendaftaran/ No.Rekam Medik',
            'value' => '$data->NoPenNoRM',
            ),
        'NamaBin',
        array(
            'header' => 'Alamat RT/RW',
            'value' => '$data->alamatRtRw',
            ),
        array(
            'header' => 'Jenis kelamin / Umur',
            'value' => '$data->jenisKelaminUmur',
            ),
        array(
            'header' => 'Cara bayar/ Penjamin',
            'value' => '$data->caraBayarPenjamin',
            ),
        'rumahsakitrujukan',
        array(
            'header' => 'Nama Dokter',
            'value' => '$data->kepadayth',
            ),
        'dirujukkebagian',
        'alasandirujuk',
      
    ),

)); ?> 

