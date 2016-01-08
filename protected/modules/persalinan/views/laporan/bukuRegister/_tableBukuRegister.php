<?php 
$table = 'ext.bootstrap.widgets.BootGridView';
$data = $model->searchTable();
$sort=true;
$template = "{summary}\n{items}\n{pager}";
if (isset($caraPrint)){
  $data = $model->searchPrint();  
  $template = "{items}";
  if ($caraPrint=='EXCEL') {
      $table = 'ext.bootstrap.widgets.BootExcelGridView';
  }
}
?>

<?php $this->widget($table,array(
	'id'=>'tableLaporan',
        'enableSorting'=>$sort,
	'dataProvider'=>$data,
        'template'=>$template,
        'itemsCssClass'=>'table table-striped table-condensed',
	'columns'=>array(
            array(
                'header'=>'No. Rekam Medik',
                'type'=>'raw',
                'value'=>'$data->no_rekam_medik',
            ),  
            array(
                'header'=>'Nama Pasien / Nama Panggilan',
                'type'=>'raw',
                'value'=>'$data->NamaNamaBIN',
            ),  
            array(
                'header'=>'No. Pendaftaran',
                'type'=>'raw',
                'value'=>'$data->no_pendaftaran',
            ),  
            array(
                'header'=>'Umur',
                'type'=>'raw',
                'value'=>'$data->umur',
            ),  
            array(
                'header'=>'Jenis Kelamin',
                'type'=>'raw',
                'value'=>'$data->jeniskelamin',
            ),  
            array(
                'header'=>'Nama Perujuk',
                'type'=>'raw',
                'value'=>'$data->nama_perujuk',
            ),  
            array(
                   'header'=>'CaraBayar/Penjamin',
                   'type'=>'raw',
                   'value'=>'$data->CaraBayarPenjamin',
                   'htmlOptions'=>array('style'=>'text-align: left')
            ),  
            array(
                'header'=>'Alamat Pasien',
                'type'=>'raw',
                'value'=>'$data->alamat_pasien',
            ),  
	),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
)); ?>