<?php 
    $table = 'ext.bootstrap.widgets.MergeHeaderGroupGridView';
    $sort = true;
    if (isset($caraPrint)){
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
            array(
                'header' => 'No.',
                'headerHtmlOptions'=>array('style'=>'text-align: center;vertical-align:middle;'),
                'htmlOptions'=>array('style'=>'text-align:center'),
                'value' => '$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1'
            ),
            array(
                'header' => 'Nama',
                'headerHtmlOptions'=>array('style'=>'text-align: center;vertical-align:middle;'),
                'value' => '$data->nama_pasien',
            ),
            array(
                'header' => 'Kelas',
                'headerHtmlOptions'=>array('style'=>'text-align: center;vertical-align:middle;'),
                'htmlOptions'=>array('style'=>'text-align:center'),
                'value' => '$data->kelaspelayanan_nama',
                'footerHtmlOptions'=>array('colspan'=>4,'style'=>'text-align:right;font-style:italic;'),
                'footer'=>'Total',
            ),
            array(
                'header' => 'Tarif',
                'headerHtmlOptions'=>array('style'=>'text-align: center;vertical-align:middle;'),
                'htmlOptions'=>array('style'=>'text-align:right'),
                'value'=>'"Rp".number_format($data->getSumTotal(array("pasien","kelaspelayanan"),"total"),0,"",".")',
                'htmlOptions' => array('style'=>'text-align:right')
            ),
            array(
                'header' => 'Jasa Ahli Gizi',
                'name'=>'tarif_tindakankomp',
                'headerHtmlOptions'=>array('style'=>'text-align: center;vertical-align:middle;'),
                'htmlOptions'=>array('style'=>'text-align:right'),
                'value'=>'"Rp".number_format($data->getSumKomponen(array("pasien","kelaspelayanan"),"ag"),0,"",".")',
                'htmlOptions' => array('style'=>'text-align:right'),
                'footerHtmlOptions'=>array('style'=>'text-align:right;'),
                'footer'=>"Rp".number_format($model->getSumTotalKomponen(array("pasien","kelaspelayanan"),"ag"),0,"","."),
            ),
            array(
                'header' => 'Insentif',
                'name'=>'tarif_tindakankomp',
                'headerHtmlOptions'=>array('style'=>'text-align: center;vertical-align:middle;'),
                'htmlOptions'=>array('style'=>'text-align:right'),
                'value'=>'"Rp".number_format($data->getSumKomponen(array("pendaftaran","kelaspelayanan"),"insentif"),0,"",".")',
                'footerHtmlOptions'=>array('style'=>'text-align:right;'),
                'footer'=>"Rp".number_format($model->getSumTotalKomponen(array("pasien","kelaspelayanan"),"insentif"),0,"","."),
            ),
	),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
)); ?>