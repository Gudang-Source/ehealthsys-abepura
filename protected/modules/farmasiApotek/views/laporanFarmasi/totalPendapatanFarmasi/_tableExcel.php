<?php 
$table = 'ext.bootstrap.widgets.HeaderGroupGridViewNonRp';
$data = $model->searchTableTotalPendapatanFarmasi();
$template = "{summary}\n{items}\n{pager}";
$sort = true;
if (isset($caraPrint)){
    $sort = false;
    $data = $model->searchTableTotalPendapatanFarmasi(false);  
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
    'itemsCssClass'=>'table table-striped table-bordered table-condensed',
    'mergeHeaders'=>array(
        array(
            'name'=>'<center>Penjualan</center>',
            'start'=>2,
            'end'=>5,
        ),
        array(
            'name'=>'<center>Retur Penjualan</center>',
            'start'=>6,
            'end'=>9,
        ),
        array(
            'name'=>'<center>Jumlah</center>',
            'start'=>10,
            'end'=>14,
        ),                  
    ),
	'columns'=>array(
            array(
                'header' => 'No.',
                'value' => '$row+1',
                'footerHtmlOptions'=>array('colspan'=>2,'style'=>'text-align:right;font-weight:bold;'),
                'footer'=>' Grand Total (Rp.)',
            ),
           // array(
           //     'header'=>'jenisobatalkes_id',
           //     'type'=>'raw',
           //     'value'=>'$data->jenisobatalkes_id',
           // ),
            array(
                'header'=>'Kelompok',
                'type'=>'raw',
                'value'=>'$data->jenisobatalkes_nama',
            ),
            // //Penjualan
            array(
                'header'=>'Bruto',
                // 'name'=>'hargajual_oa',
                'value'=>'number_format($data->hargajual_oa)',
                'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:center;'),
                'htmlOptions'=>array('style'=>'text-align:right;'),
                'footerHtmlOptions'=>array('style'=>'text-align:right;'),
                'footer'=>  number_format($model->getTpJual('hargajual_oa',true))
            ),
            array(
                'header'=>'Discount',
                // 'name'=>'discount',
                'value'=>'number_format($data->discount)',
                'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:center;'),
                'htmlOptions'=>array('style'=>'text-align:right;'),
                'footerHtmlOptions'=>array('style'=>'text-align:right;'),
                'footer'=>  number_format($model->getTpJual('discount',true))
            ),
            array(
                'header'=>'PPn (%)',
                'value'=>'number_format($data->ppn_persen)',
                'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:center;'),
                'htmlOptions'=>array('style'=>'text-align:right;'),
                'footerHtmlOptions'=>array('style'=>'text-align:right;'),
                'footer'=>'-'
            ),
            array(
                'header'=>'Netto',
                // 'name'=>'harganetto_oa',
                'value'=>'number_format($data->harganetto_oa)',
                'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:center;'),
                'htmlOptions'=>array('style'=>'text-align:right;'),
                'footerHtmlOptions'=>array('style'=>'text-align:right;'),
                'footer'=>  number_format($model->getTpJual('harganetto_oa',true))
            ),
            //Retur
            array(
                'header'=>'Bruto',
                'value'=>'number_format($data->getTpRetur("hargajual_oa"))',
                'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:center;'),
                'htmlOptions'=>array('style'=>'text-align:right;'),
                'footerHtmlOptions'=>array('style'=>'text-align:right;'),
                'footer'=>  number_format($model->getTpRetur('hargajual_oa',true))
            ),
            array(
                'header'=>'Discount',
                'value'=>'number_format($data->getTpRetur("discount"))',
                'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:center;'),
                'htmlOptions'=>array('style'=>'text-align:right;'),
                'footerHtmlOptions'=>array('style'=>'text-align:right;'),
                'footer'=>  number_format($model->getTpRetur('discount',true))
            ),
            array(
                'header'=>'PPn (%)',
                'value'=>'number_format($data->getTpRetur("ppn_persen"))',
                'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:center;'),
                'htmlOptions'=>array('style'=>'text-align:right;'),
                'footerHtmlOptions'=>array('style'=>'text-align:right;'),
                'footer'=>'-'
            ),
            array(
                'header'=>'Netto',
                'value'=>'number_format($data->getTpRetur("harganetto_oa"))',
                'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:center;'),
                'htmlOptions'=>array('style'=>'text-align:right;'),
                'footerHtmlOptions'=>array('style'=>'text-align:right;'),
                'footer'=>  number_format($model->getTpRetur('harganetto_oa',true))
            ),
            // //Total
            array(
                'header'=>'Bruto',
                'value'=>'number_format($data->getTpTotal("hargajual_oa"))',
                'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:center;'),
                'htmlOptions'=>array('style'=>'text-align:right;'),
                'footerHtmlOptions'=>array('style'=>'text-align:right;'),
                'footer'=>  number_format($model->getTpTotal('hargajual_oa',true))
            ),
            array(
                'header'=>'Discount',
                'value'=>'number_format($data->getTpTotal("discount"))',
                'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:center;'),
                'htmlOptions'=>array('style'=>'text-align:right;'),
                'footerHtmlOptions'=>array('style'=>'text-align:right;'),
                'footer'=>  number_format($model->getTpTotal('discount',true))
            ),
            array(
                'header'=>'PPn (%)',
                'value'=>'number_format($data->getTpTotal("ppn_persen"))',
                'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:center;'),
                'htmlOptions'=>array('style'=>'text-align:right;'),
                'footerHtmlOptions'=>array('style'=>'text-align:right;'),
                'footer'=>'-'
            ),
            array(
                'header'=>'Netto',
                'value'=>'number_format($data->getTpTotal("harganetto_oa"))',
                // 'value'=>'$data->getTpTotal("harganetto_oa")',
                'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:center;'),
                'htmlOptions'=>array('style'=>'text-align:right;'),
                'footerHtmlOptions'=>array('style'=>'text-align:right;'),
                'footer'=>  number_format($model->getTpTotal('harganetto_oa',true))
            ),
            array(
                'header'=>'HPP',
                'value'=>'number_format($data->hpp)',
                'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:center;'),
                'htmlOptions'=>array('style'=>'text-align:right;'),
                'footerHtmlOptions'=>array('style'=>'text-align:right;'),
                'footer'=>  number_format($model->getTpJual('hpp',true))
            ),
	),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
)); 
?>