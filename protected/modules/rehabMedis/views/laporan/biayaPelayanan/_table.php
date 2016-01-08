<?php
$table = 'ext.bootstrap.widgets.HeaderGroupGridView';
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
        'itemsCssClass'=>'table table-striped table-bordered table-condensed',
	'columns'=>array(
            array(
                    'header' => 'No',
                    'value' => '$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1'
            ),
            'no_rekam_medik',
            // 'NamaNamaBIN',
            'no_pendaftaran',
            'umur',
            'jeniskelamin',
            array(
                'header'=>'Jenis Kasus Penyakit',
                'type'=>'raw',
                'value'=>'$data->jeniskasuspenyakit_nama',
            ),
//            'jeniskasuspenyakit_nama',
            'kelaspelayanan_nama',
            'carabayarPenjamin',
            'iurbiaya',
            'total',
//            'alamat_pasien',   
	),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
)); ?>