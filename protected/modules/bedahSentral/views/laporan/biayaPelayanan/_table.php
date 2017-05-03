<?php 
$table = 'ext.bootstrap.widgets.HeaderGroupGridView';
$data = $model->searchTable();
$template = "{summary}\n{items}\n{pager}";
$sort = true;
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
    'dataProvider'=>$data,
    'enableSorting'=>$sort,
    'template'=>$template,
        'itemsCssClass'=>'table table-striped table-condensed',
	'columns'=>array(
            array(
                    'header' => 'No.',
                    'value' => '(($this->grid->dataProvider->pagination) ? $this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize : 0) + $row+1'
            ),
            'no_rekam_medik',
//            'NamaNamaBIN',
            array (
                'header' => 'Nama / Nama Bin',
                'value' => '$data->NamaNamaBin',
            ),
            'no_pendaftaran',
            'umur',
            'jeniskelamin',
            array(
              'header'=>'Jenis Kasus Penyakit',
              'type'=>'raw',
              'value'=>'$data->jeniskasuspenyakit_nama',
            ),
//            'jeniskasuspenyakit_nama',
            array(
              'header'=>'Kelas Pelayanan',
              'type'=>'raw',
              'value'=>'$data->kelaspelayanan_nama',
            ),
//            'kelaspelayanan_nama',
//            'carabayarPenjamin',
            array(
                'header'=>'Cara Bayar Penjamin',
				 'type'=>'raw',
                'value'=>'$data->carabayarPenjamin',
            ),
            array(
                'header'=>'Iur Biaya',
                'type'=>'raw',
                'value'=>'"Rp".number_format($data->iurbiaya,0,"",".")',
                'htmlOptions' => array('style'=>'text-align:right;')
            ),
            array(
                'header'=>'Total Biaya Pelayanan',
                'type'=>'raw',
                'value'=>'"Rp".number_format($data->total,0,"",".")',
                'htmlOptions' => array('style'=>'text-align:right;')
            ),
//            'iurbiaya',
//            'total',
//            'alamat_pasien',   
	),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
)); ?>