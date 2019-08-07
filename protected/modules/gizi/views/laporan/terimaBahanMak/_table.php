<?php 
    $table = 'ext.bootstrap.widgets.HeaderGroupGridView';
    $sort = true;
    $row = '$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1';
    if (isset($caraPrint)){
        $row = '$row+1';
        $data = $model->searchPrint();
        $template = "{items}";
        $sort = false;
        if ($caraPrint == "EXCEL")
            $table = 'ext.bootstrap.widgets.BootExcelGridView';
    } else{
        $data = $model->searchTable();
         $template = "{summary}\n{items}\n{pager}";
    }
?>
<?php $this->widget($table,array(
	'id'=>'tableLaporan',
	'dataProvider'=>$data,
        'template'=>$template,
        'enableSorting'=>$sort,
        'itemsCssClass'=>'table table-striped table-condensed',
	'columns'=>array(
                /*array(
                    'header'=>'No.',
                    'value' => $row,
                    'headerHtmlOptions'=>array('style'=>'text-align: left;vertical-align:middle;'),
                ),*/
                array(
                    'header' => 'Tanggal Penerimaan',
                    'headerHtmlOptions'=>array('style'=>'text-align: center;vertical-align:middle;'),
                    'value' => 'MyFormatter::formatDateTimeForUser(date("Y-m-d", strtotime($data->tglterimabahan)))',
                ),
                array(
                    'header' => 'No Penerimaan',
                    'headerHtmlOptions'=>array('style'=>'text-align: center;vertical-align:middle;'),
                    'value' => '$data->nopenerimaanbahan',
                ),
                array(
                    'header' => 'Tanggal Faktur',
                    'headerHtmlOptions'=>array('style'=>'text-align: center;vertical-align:middle;'),
                    'value' => 'isset($data->tglfaktur)?MyFormatter::formatDateTimeForUser(date("Y-m-d", strtotime($data->tglfaktur))):""',
                ),
                array(
                    'header' => 'No Faktur',
                    'headerHtmlOptions'=>array('style'=>'text-align: center;vertical-align:middle;'),
                    'value' => '$data->nofaktur'
                ),
                array(
                    'header' => 'Supplier',
                    'headerHtmlOptions'=>array('style'=>'text-align: center;vertical-align:middle;'),
                    'value' => '$data->supplier_nama'
                ),
                array(
                    'header' => 'Pegawai Penerima',
                    'headerHtmlOptions'=>array('style'=>'text-align: center;vertical-align:middle;'),                    
                    'value' => '$data->namaLengkap',                    
                ),
                array(
                    'header' => 'Bahan Makanan',                    
                    'headerHtmlOptions'=>array('style'=>'text-align: center;vertical-align:middle;'),
                    'value' => '$data->namabahanmakanan',
                    //'footerHtmlOptions'=>array('style'=>'text-align:right;font-weight:bold'),
                    //'htmlOptions'=>array('style'=>'text-align:right;'),
                    //'footer'=>'sum(hargasatuan)',
                ),
                array(
                    'header' => 'Jml Terima',
                    'headerHtmlOptions'=>array('style'=>'text-align: center;vertical-align:middle;'),
                    'value' => 'number_format($data->qty_terima,0,"",".")',
                    'htmlOptions'=>array('style'=>'text-align:right;')
                ),
                array(
                    'header' => 'Harga Netto',
                    'headerHtmlOptions'=>array('style'=>'text-align: center;vertical-align:middle;'),
                    'value' => 'number_format($data->harganettobhn,0,"",".")',
                    'htmlOptions' => array('style'=>'text-align:right'),
                    //'footerHtmlOptions'=>array('style'=>'text-align:right;color:white'),
                    //'footer'=>'-',
                ),
                array(
                    'header' => 'Subtotal',
                    'headerHtmlOptions'=>array('style'=>'text-align: center;vertical-align:middle;'),
                    'value' => 'number_format($data->totalharganetto,0,"",".")',
                    'htmlOptions'=>array('style'=>'text-align:right;')
                    //'footerHtmlOptions'=>array('style'=>'text-align:right;color:white'),
                    //'footer'=>'-',
                ),                
	),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
)); ?>