<?php
$table = 'ext.bootstrap.widgets.BootGridView';
$template = "{summary}\n{items}\n{pager}";
$row = '$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1';
if (isset($caraPrint)){
  $row = '$row+1';
  $data = $model->searchLaporanPrint();
  $template = "{items}";
  if ($caraPrint=='EXCEL') {
      $table = 'ext.bootstrap.widgets.BootExcelGridView';
  }
} else{
  $data = $model->searchLaporan();
}
?>
<?php $this->widget($table, array(
	'id'=>'laporan-grid',
	'dataProvider'=>$data,
	'itemsCssClass'=>'table table-striped table-condensed',
	'template'=>$template,
	'columns'=>array(
		array(
			'header'=>'No.',
			'value' =>$row,
		),
		array(
			'header'=>'No. Kode Barang',
			'value'=>'$data->barang_kode',
			'type'=>'raw',
		),
		array(
			'header'=>'Nama Barang',
			'value'=>'$data->barang_nama',
			'type'=>'raw',
		),
		array(
			'header'=>'Merk',
			'value'=>'$data->barang_merk',
			'type'=>'raw',
		),
		array(
			'header'=>'No. Seri',
			'value'=>'$data->barang_noseri',
			'type'=>'raw',
		),
		array(
			'header'=>'Satuan',
			'value'=>'$data->barang_satuan',
			'type'=>'raw',
		),
		array(
			'header'=>'Harga Netto',
			'value'=>'"Rp".number_format($data->harga_netto,0,"",".")',
			'type'=>'raw',
			'htmlOptions'=>array('style'=>'text-align:right;'),
		),
		array(
			'header'=>'Harga Jual',
			'value'=>'"Rp".number_format($data->harga_satuan,0,"",".")',
			'type'=>'raw',
			'htmlOptions'=>array('style'=>'text-align:right;'),
		),
		array(
			'header'=>'Kondisi',
			'value'=>'$data->kondisi_barang',
			'type'=>'raw',
		),
	),
)); ?>