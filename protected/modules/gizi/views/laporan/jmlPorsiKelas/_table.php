<?php 
    $table = 'ext.bootstrap.widgets.MergeHeaderGroupGridView';
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
<?php 
        $this->widget($table,array(
            'id'=>'tableLaporan',
            'dataProvider'=>$data,
            'template'=>$template,
            'enableSorting'=>$sort,
            'itemsCssClass'=>'table table-striped table-condensed',
            'columns'=>array(
                    array(
                        'header'=>'No.',
                        'value' => $row,
                        'headerHtmlOptions'=>array('style'=>'text-align: center;vertical-align:middle;'),
                        'htmlOptions'=>array('style'=>'text-align: center;vertical-align:middle;'),
                    ),
                    array(
                        'header' => 'Jenis Diet',
                        'value' => '$data->jenisdiet_nama',
                        'headerHtmlOptions'=>array('style'=>'text-align: left;vertical-align:middle;'),                    
                        'footerHtmlOptions'=>array('colspan'=>2,'style'=>'text-align:right;color:black;font-weight:bold'),
                        'footer'=>'JUMLAH',
                    ),
                    array(
                        'header' => 'Bangsal',
                        'value'=>'number_format($data->getSumJmlPorsi(array("jenisdiet"),"BANGSAL"))',
                        'htmlOptions'=>array('style'=>'text-align: right;vertical-align:middle;'),
                        'headerHtmlOptions'=>array('style'=>'text-align: right;vertical-align:middle;'),
                        'footerHtmlOptions'=>array('style'=>'text-align:right;color:black;font-weight:bold'),
                        'footer'=>number_format($model->getSumTotalPorsi(array("jenisdiet"),"BANGSAL")),
                    ),
                    array(
                        'header' => 'OBS',
                        'value'=>'number_format($data->getSumJmlPorsi(array("jenisdiet"),"OBS"))',
                        'htmlOptions'=>array('style'=>'text-align: right;vertical-align:middle;'),
                        'headerHtmlOptions'=>array('style'=>'text-align: right;vertical-align:middle;'),                    
                        'footerHtmlOptions'=>array('style'=>'text-align:right;color:black;font-weight:bold'),
                        'footer'=>number_format($model->getSumTotalPorsi(array("jenisdiet"),"OBS")),
                    ),
                    array(
                        'header' => 'ICU',
                        'value'=>'number_format($data->getSumJmlPorsi(array("jenisdiet"),"ICU"))',
                        'htmlOptions'=>array('style'=>'text-align: right;vertical-align:middle;'),
                        'headerHtmlOptions'=>array('style'=>'text-align: right;vertical-align:middle;'),                    
                        'footerHtmlOptions'=>array('style'=>'text-align:right;color:black;font-weight:bold'),
                        'footer'=>number_format($model->getSumTotalPorsi(array("jenisdiet"),"ICU")),
                    ),
                    array(
                        'header' => 'VVIP',
                        'value'=>'number_format($data->getSumJmlPorsi(array("jenisdiet"),"VVIP"))',
                        'htmlOptions'=>array('style'=>'text-align: right;vertical-align:middle;'),
                        'headerHtmlOptions'=>array('style'=>'text-align: right;vertical-align:middle;'),                    
                        'footerHtmlOptions'=>array('style'=>'text-align:right;color:black;font-weight:bold'),
                        'footer'=>number_format($model->getSumTotalPorsi(array("jenisdiet"),"VVIP")),
                    ),
                    array(
                        'header' => 'VIP A',
                        'value'=>'number_format($data->getSumJmlPorsi(array("jenisdiet"),"VIPA"))',
                        'htmlOptions'=>array('style'=>'text-align: right;vertical-align:middle;'),
                        'headerHtmlOptions'=>array('style'=>'text-align: right;vertical-align:middle;'),                    
                        'footerHtmlOptions'=>array('style'=>'text-align:right;color:black;font-weight:bold'),
                        'footer'=>number_format($model->getSumTotalPorsi(array("jenisdiet"),"VIPA")),
                    ),
                    array(
                        'header' => 'VIP B',
                        'name'=>'hargasatuan',
                        'value'=>'number_format($data->getSumJmlPorsi(array("jenisdiet"),"VIPB"))',
                        'headerHtmlOptions'=>array('style'=>'text-align: right;vertical-align:middle;'),                    
                        'htmlOptions'=>array('style'=>'text-align: right;vertical-align:middle;'),
                        'footerHtmlOptions'=>array('style'=>'text-align:right;color:black;font-weight:bold'),
                        'footer'=>number_format($model->getSumTotalPorsi(array("jenisdiet"),"VIPB")),
                    ),
                    array(
                        'header' => 'UTAMA',
                        'value'=>'number_format($data->getSumJmlPorsi(array("jenisdiet"),"UTAMA"))',
                        'htmlOptions'=>array('style'=>'text-align: right;vertical-align:middle;'),
                        'headerHtmlOptions'=>array('style'=>'text-align: right;vertical-align:middle;'),                    
                        'footerHtmlOptions'=>array('style'=>'text-align:right;color:black;font-weight:bold'),
                        'footer'=>number_format($model->getSumTotalPorsi(array("jenisdiet"),"UTAMA")),
                    ),
                    array(
                        'header' => 'MADYA',
                        'value'=>'number_format($data->getSumJmlPorsi(array("jenisdiet"),"MADYA"))',
                        'htmlOptions'=>array('style'=>'text-align: right;vertical-align:middle;'),
                        'headerHtmlOptions'=>array('style'=>'text-align: right;vertical-align:middle;'),                    
                        'footerHtmlOptions'=>array('style'=>'text-align:right;color:black;font-weight:bold'),
                        'footer'=>number_format($model->getSumTotalPorsi(array("jenisdiet"),"MADYA")),
                    ),
                    array(
                        'header' => 'I',
                        'value'=>'number_format($data->getSumJmlPorsi(array("jenisdiet"),"I"))',
                        'htmlOptions'=>array('style'=>'text-align: right;vertical-align:middle;'),
                        'headerHtmlOptions'=>array('style'=>'text-align: right;vertical-align:middle;'),                    
                        'footerHtmlOptions'=>array('style'=>'text-align:right;color:black;font-weight:bold'),
                        'footer'=>number_format($model->getSumTotalPorsi(array("jenisdiet"),"I")),
                    ),
                    array(
                        'header' => 'II',
                        'value'=>'number_format($data->getSumJmlPorsi(array("jenisdiet"),"II"))',
                        'htmlOptions'=>array('style'=>'text-align: right;vertical-align:middle;'),
                        'headerHtmlOptions'=>array('style'=>'text-align: right;vertical-align:middle;'),                    
                        'footerHtmlOptions'=>array('style'=>'text-align:right;color:black;font-weight:bold'),
                        'footer'=>number_format($model->getSumTotalPorsi(array("jenisdiet"),"II")),
                    ),
                    array(
                        'header' => 'III',
                        'value'=>'number_format($data->getSumJmlPorsi(array("jenisdiet"),"III"))',
                        'headerHtmlOptions'=>array('style'=>'text-align: right;vertical-align:middle;'),
                        'htmlOptions'=>array('style'=>'text-align: right;vertical-align:middle;'),                    
                        'footerHtmlOptions'=>array('style'=>'text-align:right;color:black;font-weight:bold'),
                        'footer'=>number_format($model->getSumTotalPorsi(array("jenisdiet"),"III")),
                    ),
                    array(
                        'header' => 'Jumlah',
                        'value'=>'number_format($data->getSumJmlPorsi(array("jenisdiet"),"JML"))',
                        'headerHtmlOptions'=>array('style'=>'text-align: right;vertical-align:middle;'),
                        'htmlOptions'=>array('style'=>'text-align: right;vertical-align:middle;'),                    
                        'footerHtmlOptions'=>array('style'=>'text-align:right;color:black;font-weight:bold'),
                        'footer'=>number_format($model->getSumTotalPorsi(array("kelas"),"TOTAL")),
                    ),
                    array(
                        'header' => '%',
                        'value' => '"-"',
                        'headerHtmlOptions'=>array('style'=>'text-align: right;vertical-align:middle;'),
                        'htmlOptions'=>array('style'=>'text-align: right;vertical-align:middle;'),                    
                        'footerHtmlOptions'=>array('style'=>'text-align:right;color:black;font-weight:bold'),
                        'footer'=>'-',
                    ),
            ),
            'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
    )); 
?>