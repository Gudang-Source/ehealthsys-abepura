
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
            array(
                'header' => 'Tanggal Pemakaian',
                'value' => 'MyFormatter::formatDateTimeForUser($data->tglpemakaianobat)'
            ),
             array(
                'header' => 'No Pemakaian',
                'value' => '$data->nopemakaian_obat'
            ),
            array(
                'header' => 'Jenis',
                'value' => '$data->jenisobatalkes_nama'
            ),
            array(
                'header' => 'Kategori',
                'value' => '$data->obatalkes_kategori'
            ),
            array(
                'header' => 'Golongan',
                'value' => '$data->obatalkes_golongan'
            ),            
            array(
                'header' => 'Nama Obat Alkes',
                'value' => '$data->obatalkes_nama'
            ), 
            array(
                'header' => 'Jumlah Pemakaian',
                'value' => '$data->qty_satuanpakai." ".$data->satuankecil_nama',               
            ), 
            array(
                'header' => 'Harga Satuan',
                'value' => '"Rp".number_format($data->harga_satuanpakai,0,"",".")',                                                
                'htmlOptions' => array('style'=>'text-align:right;')
            ), 
            array(
                'header' => 'Sub Total harga',
                'value' => '"Rp".number_format(($data->harga_satuanpakai * $data->qty_satuanpakai),0,"",".")',                
                'htmlOptions' => array('style'=>'text-align:right;')
            ), 
	),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
)); ?>