<?php
$itemCssClass = 'table table-striped table-condensed';
$table = 'ext.bootstrap.widgets.BootGridView';
$template = "{summary}\n{items}\n{pager}";
$row = '$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1';
if (isset($caraPrint)){
  $row = '$row+1';
  $data = $model->searchPrint();
  $template = "{items}";
  if ($caraPrint=='EXCEL') {
      $table = 'ext.bootstrap.widgets.BootExcelGridView';
  }
  echo "<style>
     .border th, .border td{
        border:1px solid #000;
    }
    .border{
        box-shadow:none;
    }
    
    .table thead:first-child{
        border-top:1px solid #000;        
    }
    
    thead th{
        background:none;
        color:#333;
    }
    
    .table tbody tr:hover td, .table tbody tr:hover th {
        background-color: none;
    }
</style>";
  if ($caraPrint == "PRINT"){
      
  $itemCssClass = 'table border';
  }
} else{
  $data = $model->searchTable();
}
?>
<?php $this->widget($table,array(
	'id'=>'tableLaporan',
	'dataProvider'=>$data,
        'template'=>$template,
        'itemsCssClass'=>$itemCssClass,
	'columns'=>array(
            array(
                'header' => 'No',
                'value' => $row,
            ),
            array(
              'header'=>'No. Rekam Medik',
              'value'=>'$data->no_rekam_medik',
            ),
            array(
              'header'=>'Nama Pasien Bin',
              'value'=>'$data->NamaNamaBIN',
            ),
            array(
                'header'=>'Umur',
                'value'=>'$data->umur',
            ),
            array(
                'header'=>'Alamat Pasien',
                'value'=>'$data->alamat_pasien',
            ),
            array(
                'header'=>'Status Pasien',
                'value'=>'$data->statuspasien',
            ),
            array(
                'header'=>'Status Masuk',
                'value'=>'$data->statusmasuk',
            ),
            array(
                'header'=>'Kunjungan',
                'value'=>'$data->kunjungan',
            ),
            array(
                'header'=>'Jenis Kelamin',
                'value'=>'$data->jeniskelamin',
            ),
            array(
               'name'=>'CaraBayar/Penjamin',
               'type'=>'raw',
               'value'=>'$data->CaraBayarPenjamin',
               'htmlOptions'=>array('style'=>'text-align: center')
            ), 
            array(
                'name'=>'Cara Masuk / Transportasi',
                'type'=>'raw',
                'value'=>'$data->caraMasukTransportasi',
            ),
	),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
)); ?>