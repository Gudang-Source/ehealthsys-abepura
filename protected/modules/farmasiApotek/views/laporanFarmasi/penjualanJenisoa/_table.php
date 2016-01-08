<?php 
/**
 * css untuk membuat text head berada d tengah
 */
echo CHtml::css('.table thead tr th{
    vertical-align:middle;
}'); ?>
<?php 
$table = 'ext.bootstrap.widgets.HeaderGroupGridViewNonRp';
$mergeColumns = array('obatalkes_nama');
$data = $model->searchTable();
$template = "{summary}\n{items}\n{pager}";
$sort = false;
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
//    'mergeColumns'=>$mergeColumns,
    'dataProvider'=>$data,
    'enableSorting'=>$sort,
    'template'=>$template,
        'itemsCssClass'=>'table table-striped table-condensed',
	'columns'=>array(
            
            array(
                    'header' => 'No',
                    'value' => '(($this->grid->dataProvider->pagination) ? $this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize : 0) + $row+1',
                    'footer'=>'Jumlah',
                    'footerHtmlOptions'=>array('colspan'=>6, 'style'=>'text-align:right;'),
            ),
            array(
                'name'=>'jenisobatalkes_nama',
                'type'=>'raw',
                'value'=>'$data->jenisobatalkes_nama',
            ),
            'obatalkes_golongan',
            'obatalkes_kategori',
            'obatalkes_kode',
            'obatalkes_nama',
            array(
                'name'=>'r',
                'type'=>'raw',
                'header'=>'R',
                'htmlOptions'=>array('style'=>'text-align:right;'),
                'headerHtmlOptions'=>array('style'=>'text-align:right;'),
                'footerHtmlOptions'=>array('style'=>'text-align:right;'),
                'footer'=>'sum(r)',
                'value'=>'$data->r'
            ),
            array(
                'name'=>'qty_oa',
                'type'=>'raw',
                'header'=>'Jumlah',
                'value'=>'number_format($data->qty_oa)',
                'headerHtmlOptions'=>array('style'=>'text-align:right;'),
                'htmlOptions'=>array('style'=>'text-align:right;'),
                'footerHtmlOptions'=>array('style'=>'text-align:right;'),
                'footer'=>'sum(qty_oa)',
            ),
            
	),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
)); ?>