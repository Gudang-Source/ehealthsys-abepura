
<?php if (isset($caraPrint)){
   $data = $model->searchPrint();
//    $data = $model->search();
   $sort = false;
} else{
 $data = $model->searchTable();
//    $data = $model->search();
   $sort = true;
}
?>
<?php $this->widget('ext.bootstrap.widgets.BootGridView',array(
	'id'=>'tableLaporan',
	'dataProvider'=>$data,
        'enableSorting'=>$sort,
        'template'=>"{summary}\n{items}\n{pager}",
        'itemsCssClass'=>'table table-striped table-condensed',
	'columns'=>array(
            array(
                'header' => 'No.',
                'value' => '(($this->grid->dataProvider->pagination) ? $this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize : 0) + $row+1',
            ),

            'jenisobatalkes_nama',    
            'obatalkes_kategori',
            'obatalkes_golongan',
            'obatalkes_nama',
            'satuankecil_nama',
            'carabayar_nama',
	),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
)); ?>