<?php 
$table = 'ext.bootstrap.widgets.HeaderGroupGridViewNonRp';
$data = $model->searchTable();
$template = "{summary}\n{items}\n{pager}";
$sort = true;
if (isset($caraPrint)){
    $sort = false;
  $data = $model->searchPrint();  
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
                'header' => 'No.',
                'value' => '(($this->grid->dataProvider->pagination) ? $this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize : 0) + $row+1'
            ),
            'noreturresep',
            array(
                'name'=>'tglretur',
                'type'=>'raw',
                'value'=>'date("d/m/Y H:i:s",strtotime($data->tglretur))',
            ),
            array(
                'header'=>'Jenis Penjualan',
                'type'=>'raw',
                'value'=>'$data->jenispenjualan',
            ),
            'obatalkes_nama',
            array(
                'header'=>'Satuan Kecil',
                'type'=>'raw',
                'value'=>'$data->satuankecil_nama',
                'footerHtmlOptions'=>array('colspan'=>6,'style'=>'text-align:right;font-weight:bold;'),
                'footer'=>'Total',
            ),
            array(
                'header'=>'Jumlah',
                'type'=>'raw',
                'name'=>'qty_retur',
                'value'=>'number_format($data->qty_retur)',
                'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:right;'),
                'htmlOptions'=>array('style'=>'text-align:right;'),
                'footerHtmlOptions'=>array('style'=>'text-align:right;'),
                'footer'=>'sum(qty_retur)'
            ),
            array(
                'header'=>'Harga Satuan',
                'name'=>'hargasatuan',
                'value'=>'number_format($data->hargasatuan,0,",",".")',
                'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:right;'),
                'htmlOptions'=>array('style'=>'text-align:right;'),
                'footerHtmlOptions'=>array('style'=>'text-align:right;'),
                'footer'=>'sum(hargasatuan)'
            ),
            array(
                'header'=>'Total Retur',
                'name'=>'totalretur',
                'value'=>'number_format($data->totalretur,0,",",".")',
                'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:right;'),
                'htmlOptions'=>array('style'=>'text-align:right;'),
                'footerHtmlOptions'=>array('style'=>'text-align:right;'),
                'footer'=>'sum(totalretur)'
            ),
            
	),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
)); 
?>