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
$sort=true;
?>

<?php $this->widget($table,array(
	'id'=>'tableLaporan',
	'dataProvider'=>$data,
        'template'=>$template,
        'enableSorting'=>$sort,
        'itemsCssClass'=>'table table-striped table-condensed',
	'columns'=>array(
            array(
                    'header' => 'No',
                    'value' => '$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1'
            ),
            'no_rekam_medik',
            array(
                'header'=>'Nama Pasien / Bin',
                'value'=>'$data->NamaNamaBIN',
            ),
//            'NamaNamaBIN',
            'no_pendaftaran',
            'umur',
            'jeniskelamin',
            array(
                'header'=>'Jenis Kasus Penyakit',
                'value'=>'$data->jeniskasuspenyakit_nama',
            ),
//            'jeniskasuspenyakit_nama',
            array(
                'header'=>'Kelas Pelayanan',
                'value'=>'$data->kelaspelayanan_nama',
            ),
//            'kelaspelayanan_nama',
            array(
                'header'=>'Cara Bayar / Penjamin',
                'value'=>'$data->carabayarPenjamin',
            ),
            array(
                'header'=>'Biaya Pelayanan',
                'value'=>'"Rp".number_format($data->tarif_tindakan,0,"",".")',
                'htmlOptions'=>array('style'=>'text-align:right;'),
            ),
              
	),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
)); ?>