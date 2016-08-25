<?php 
//    $table = 'ext.bootstrap.widgets.BootGroupGridView';
    $table = 'ext.bootstrap.widgets.BootGridView';
    $sort = true;
    if (isset($caraPrint)){
        $data = $model->searchLaporan();
        $template = "{items}";
        $sort = false;
        if ($caraPrint == "EXCEL"){
            $table = 'ext.bootstrap.widgets.BootExcelGridView';
        }
        echo "<style>
                .tableRincian thead, th{
                    border: 1px #000 solid;
                }
                .tableRincian{
                    width:100%;
                }
            </style>";
        $itemsCssClass = 'table table-striped table-condensed';
    } else{
        $data = $model->searchLaporan();
         $template = "{summary}\n{items}\n{pager}";
         $itemsCssClass = 'table table-striped table-condensed';
    }
    
    $this->widget($table,array( 
    'id'=>'laporan-grid',
    'dataProvider'=>$data, 
    'template'=>$template, 
    'itemsCssClass'=>$itemsCssClass,
    'columns'=>array( 
	    array(
		'header' => 'No.',
                'headerHtmlOptions'=>array('style'=>'text-align:left;'),
		'value' => '$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1'
	    ),
		array(
                    'header'=>'Tanggal Faktur',
                    'headerHtmlOptions'=>array('style'=>'text-align:left;'),
                    'value'=>'MyFormatter::formatDateTimeForUser($data->tglfaktur)',
                ),
                array(
                    'header' => 'No Faktur',
                    'value' => '$data->nofaktur'
                ),                
                array(
                    'header'=>'Nama Supplier',
                    'type'=>'raw',
                    'headerHtmlOptions'=>array('style'=>'text-align:left;'),
                    'value'=>'$data->supplier->supplier_nama',
                ),
                array(
                    'header'=>'Tanggal Jatuh Tempo',
                    'headerHtmlOptions'=>array('style'=>'text-align:left;'),
                    'value'=>'MyFormatter::formatDateTimeForUser($data->tgljatuhtempo)',
                ),
                array(
                    'header'=>'Keterangan Faktur',
                    'headerHtmlOptions'=>array('style'=>'text-align:left;'),
                    'value' => '$data->keteranganfaktur',
                ),
//                'totharganetto',
                array(
                    'header'=>'Total Harga Netto',
                    'type'=>'raw',
                    'headerHtmlOptions'=>array('style'=>'text-align:left;'),
                    'value'=>'number_format($data->totharganetto,0,"",".")',
                    'htmlOptions' => array('style'=>'text-align:right')
                ),
//                'jmldiscount',
                array(
                    'header'=>'Jumlah Diskon',
                    'type'=>'raw',
                    'headerHtmlOptions'=>array('style'=>'text-align:left;'),
                    'value'=>'number_format($data->jmldiscount,0,"",".")',
                    'htmlOptions' => array('style'=>'text-align:right')
                ),
//                'biayamaterai',
//                'totalpajakpph',
                array(
                    'header'=>'Total Pajak Pph',
                    'type'=>'raw',
                    'headerHtmlOptions'=>array('style'=>'text-align:left;'),
                    'value'=>'number_format($data->totalpajakpph,0,"",".")',
                    'htmlOptions' => array('style'=>'text-align:right')
                ),
//                'totalpajakppn',
                array(
                    'header'=>'Total Pajak Ppn',
                    'type'=>'raw',
                    'headerHtmlOptions'=>array('style'=>'text-align:left;'),
                    'value'=>'number_format($data->totalpajakppn,0,"",".")',
                    'htmlOptions' => array('style'=>'text-align:right')
                ),
//                'totalhargabruto', 
                array(
                    'header'=>'Total Harga Bruto',
                    'type'=>'raw',
                    'headerHtmlOptions'=>array('style'=>'text-align:left;'),
                    'value'=>'number_format($data->totalhargabruto,0,"",".")',
                    'htmlOptions' => array('style'=>'text-align:right')
                ),
    ), 
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}', 
)); ?> 
<script>
    $('.integer').each(function(){
       formatNumber(); 
    });
</script>