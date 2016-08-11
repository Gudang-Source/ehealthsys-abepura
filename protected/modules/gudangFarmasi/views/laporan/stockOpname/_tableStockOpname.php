<?php 
$table = 'ext.bootstrap.widgets.HeaderGroupGridView';
$data = $model->searchTableGF();
$template = "{summary}\n{items}\n{pager}";
$sort = true;
$row = '$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1';
if (isset($caraPrint)){
    $row = '$row+1';
    $sort = false;
  $data = $model->searchPrintGF();  
  $template = "{items}";
  if ($caraPrint == "EXCEL") {
      echo $caraPrint;
      $table = 'ext.bootstrap.widgets.BootExcelGridView';
  }
}
?>
<?php 
$this->widget($table,array(
    'id'=>'tableLaporan',
    'dataProvider'=>$data,
    'enableSorting'=>$sort,
    'template'=>$template,
        'itemsCssClass'=>'table table-striped table-condensed',
	'columns'=>array(
            array(
                'header' => 'No',
                'value' => $row,
            ),
            array(
                'header'=>'Jenis <br/> Obat Alkes',
                'type'=>'raw',
                'value'=>'$data->jenisobatalkes_nama',
            ),
            array(
                'header'=>'Kode <br/> Obat Alkes',
                'type'=>'raw',
                'value'=>'$data->obatalkes_kode',
            ),
            array(
                'header'=>'Golongan <br/> Kategori',
                'type'=>'raw',
                'value'=>'$data->obatalkes_golongan."<br/>".$data->obatalkes_kategori',
            ),
            array(
                'header'=>'Nama <br/> Obat Alkes',
                'type'=>'raw',
                'value'=>'$data->obatalkes_nama',
            ),
            array(
                'header'=>'Sumber <br/> Dana',
                'type'=>'raw',
                'value'=>'$data->sumberdana_nama',
            ),
            array(
                'header'=>'Harga <br/> Netto',
                'type'=>'raw',
                'value'=>'number_format($data->harganetto,0,"",".")',
                'htmlOptions'=>array('style'=>'text-align:right'),
            ),
            array(
                'header'=>'Stock <br/> Minimal',
                'type'=>'raw',
                'value'=>'number_format($data->kemasanbesar,0,"",".")',
                'htmlOptions'=>array('style'=>'text-align:right'),
            ),
            array(
                'header'=>'Stock <br/> Opname',
                'type'=>'raw',
                'value'=>'number_format($data->volume_fisik,0,"",".")',
                'htmlOptions'=>array('style'=>'text-align:right'),
            ),
            array(
                'header'=>'Tanggal Kadaluarsa',
                'type'=>'raw',
                'value'=>'MyFormatter::formatDateTimeForUser(date("d/m/Y", strtotime($data->tglkadaluarsa)))',
            ),
            array(
                'header'=>'Kondisi <br/> Barang',
                'type'=>'raw',
                'value'=>'$data->kondisibarang',
            ),
	),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
)); 
?>