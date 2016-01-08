<h6>Tabel Lembar <b>Resep Luar</b></h6>
<?php 
$table = 'ext.bootstrap.widgets.BootGroupGridView';
$data = $model->searchLaporan();
$template = "{summary}\n{items}\n{pager}";
$sort = false;
if (isset($caraPrint)){
    $sort = false;
  $data = $model->searchLaporanPrint();  
  $template = "{items}";
  if ($caraPrint == "EXCEL") {
      $table = 'ext.bootstrap.widgets.BootExcelGridView';
  }
}
?>
<?php 
$this->widget($table,array(
    'id'=>'laporan-grid',
    'dataProvider'=>$data,
    'enableSorting'=>$sort,
    'template'=>$template,
        'itemsCssClass'=>'table table-striped table-condensed',
//                'mergeColumns'=>array('noresep','tglresep','totalhargajual','jumalhresep'),
	'columns'=>array(
                    array(
                        'header'=>'No.',
                        'value' => '(($this->grid->dataProvider->pagination) ? $this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize : 0) + $row+1',
                    ),
                    array(
                        'header'=>'No. Resep',
                        'name'=>'noresep',
                        'value'=>'$data->noresep',
                    ),
                    array(
                        'header'=>'Tanggal Resep',
                        'name'=>'tglresep',
                        'value'=>'date("d/m/Y H:i:s",strtotime($data->tglresep))',
                        'footerHtmlOptions'=>array('style'=>'text-align:right;'),
                        'footer'=>'<b>Total</b>',
                    ),
                    array(
                        'header'=>'Total Harga',
                        'name'=>'totalhargajual',
                        'headerHtmlOptions'=>array('style'=>'text-align:right;'),
                        'footerHtmlOptions'=>array('style'=>'text-align:right;'),
                        'htmlOptions'=>array('style'=>'text-align:right;'),
                        'value'=>'"Rp. ".number_format($data->totalhargajual,0,"",".")',
                        'footer'=>"Rp. ".''.number_format($model->getTotalhargajual(),0,"",".").'',
                    ),
                    array(
                        'header'=>'Total Item (R)',
                        'value'=>'FALaporanLembarresepLuarV::getItemR($data->noresep)',
                        'headerHtmlOptions'=>array('style'=>'text-align:right;'),
                        'footerHtmlOptions'=>array('style'=>'text-align:right;'),
                        'htmlOptions'=>array('style'=>'text-align:right;'),
                        'footer'=>number_format($model->getTotalR(),0,"","."),
                    ),
                    array(
                        'header'=>'Jumlah Item',
                        'value'=>'FALaporanLembarresepLuarV::getQty($data->noresep)',
                        'headerHtmlOptions'=>array('style'=>'text-align:right;'),
                        'footerHtmlOptions'=>array('style'=>'text-align:right;'),
                        'htmlOptions'=>array('style'=>'text-align:right;'),
                        'footer'=>$model->getTotalQty(),
                    ),
                    array(
                        'header'=>'Jumlah Resep',
                        'name'=>'jumalhresep',
                        'type'=>'raw',
                        'value'=>'1',
                        'headerHtmlOptions'=>array('style'=>'text-align:right;'),
                        'footerHtmlOptions'=>array('style'=>'text-align:right;'),
                        'htmlOptions'=>array('style'=>'text-align:right;'),
                        'footer'=>$model->getTotalJumlahresep(),
                    )
	),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
)); 
?>