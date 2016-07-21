<?php 
    $table = 'ext.bootstrap.widgets.BootGroupGridView';
    //$table = 'ext.bootstrap.widgets.BootExcelGridView';
    $sort = true;
    if (isset($caraPrint)){
        $data = $model->searchInformasi();
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
        $itemsCssClass = 'tableRincian';
    } else{
        $data = $model->searchInformasi();
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
                'name'=>'tglpenerimaan',
                'headerHtmlOptions'=>array('style'=>'text-align:left;'),
                'value'=>'date("d/m/Y H:i:s",strtotime($data->tglpenerimaan))',
            ),
            'nopenerimaan',
            array(
                'header'=>'Nama Penerimaan',
                'headerHtmlOptions'=>array('style'=>'text-align:left;'),
                'value'=>'$data->jenispenerimaan->jenispenerimaan_nama',
            ),
            array(
                'name'=>'namapenandatangan',
                'headerHtmlOptions'=>array('style'=>'text-align:left;'),
            ),
            array(
                'name'=>'kelompoktransaksi',
                'headerHtmlOptions'=>array('style'=>'text-align:left;'),
            ),
            array(
                'name'=>'volume',
                'headerHtmlOptions'=>array('style'=>'text-align:left;'),
            ),
            array(
                'name'=>'satuanvol',
                'headerHtmlOptions'=>array('style'=>'text-align:left;'),
            ),
            array('name'=>'hargasatuan',
                'headerHtmlOptions'=>array('style'=>'text-align:left;'),
                'value'=>'MyFormatter::formatUang($data->hargasatuan)'
            ),
            array('name'=>'totalharga',
                'headerHtmlOptions'=>array('style'=>'text-align:left;'),
                'value'=>'MyFormatter::formatUang($data->totalharga)'
            ),
    ), 
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}', 
)); ?> 
<script>
    $('.integer').each(function(){
       formatNumber(); 
    });
</script>