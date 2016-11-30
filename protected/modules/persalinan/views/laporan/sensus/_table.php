
<?php 
$itemCssClass = 'table table-striped table-condensed';
$table = 'ext.bootstrap.widgets.BootGridView';
$data = $model->searchTable();
$template = "{summary}\n{items}\n{pager}";
$row = '$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1';
if (isset($caraPrint)){
  $row = '$row+1';
  $data = $model->searchPrint();  
  $template = "{items}";
  if ($caraPrint == "EXCEL"){
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
}
?>

<?php $this->widget($table,array(
	'id'=>'tableLaporan',
	'dataProvider'=>$data,
        'template'=>$template,
        'itemsCssClass'=>$itemCssClass,
	'columns'=>array(
            array(
                'header' => 'No.',
                'value' => $row,
            ),
            array(
                'header'=>'Nama Pasien / Nama Panggilan',
                'value'=>'$data->NamaNamaBIN',
            ),
            array(
                'header'=>'No. Rekam Medik',
                'value'=>'$data->no_rekam_medik',
            ),
            array(
                'header'=>'Umur',
                'value'=>'$data->umur',
            ),
            array(
                'header'=>'Jenis Kelamin',
                'value'=>'$data->jeniskelamin',
            ),
            array(
                'header'=>'Alamat Pasien',
                'value'=>'$data->alamat_pasien',
            ),
            array(
                'header'=>'Kunjungan',
                'value'=>'$data->kunjungan',
            ),
            array(
                'header'=>'Status Pasien',
                'value'=>'$data->statuspasien',
            ),
            array(
                'header'=>'Nama Diagnosa',
                'value'=>'$data->diagnosa_nama',
            ),
            array(
               'header'=>'Cara Bayar / Penjamin',
              // 'name'=>'CaraBayar/Penjamin',
               'type'=>'raw',
               'value'=>'$data->CaraBayarPenjamin',
               'htmlOptions'=>array('style'=>'text-align: center')
            ),  
            array(
                'header'=>'Nama Tindakan',
                'type'=>'raw',
                'value'=>'$this->grid->getOwner()->renderPartial(\'sensus/_tindakan\', array(\'id\'=>$data->pendaftaran_id))',
            ),
	),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
)); ?>