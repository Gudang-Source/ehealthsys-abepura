<?php 
$table = 'ext.bootstrap.widgets.HeaderGroupGridView';
$data = $model->searchPenjualanObat();
$template = "{summary}\n{items}\n{pager}";
$sort = false;
if (isset($caraPrint)){
    $sort = false;
  $data = $model->searchPrintPenjualanObat();  
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
                'value' => '(($this->grid->dataProvider->pagination) ? $this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize : 0) + $row+1'
            ),
            'noresep',
            array(
                'name'=>'tglpenjualan',
                'type'=>'raw',
                'value'=>'date("d/m/Y H:i:s",strtotime($data->tglpenjualan))',
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
            ),
            array(
                'header'=>'Jumlah',
                'type'=>'raw',
                'value'=>'$data->qty_oa',
                'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:right;'),
                'htmlOptions'=>array('style'=>'vertical-align:middle;text-align:right;'),
            ),
            array(
                'header'=>'Harga Satuan',
                'name'=>'hargasatuan_oa',
                'value'=>'"Rp. ".number_format($data->hargasatuan_oa,0,",",".")',
                'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:right;'),
                'htmlOptions'=>array('style'=>'vertical-align:middle;text-align:right;'),
                'footerHtmlOptions'=>array('colspan'=>8,'style'=>'text-align:right;font-weight:bold;'),
                'footer'=>'Total',
            ),
            array(
                'header'=>'Total',
                'name'=>'hargajual_oa',
                'value'=>'"Rp. ".number_format($data->hargajual_oa,0,",",".")',
                'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:right;'),
                'htmlOptions'=>array('style'=>'text-align:right;'),
                'footerHtmlOptions'=>array('style'=>'text-align:right;'),
                'footer'=>'sum(hargajual_oa)'
            ),
            array(
                'header'=>'Status Bayar',
                'name'=>'status_bayar',
                'value'=>'(empty($data->oasudahbayar_id)) ? "Belum" : "Sudah"',
                'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:right;'),
                'footerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:right;'),
                'htmlOptions'=>array('style'=>'vertical-align:middle;text-align:right;'),
                'footer'=>'-'
            ),
            
	),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
)); 
?>