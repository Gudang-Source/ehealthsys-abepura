<?php 
    $table = 'ext.bootstrap.widgets.HeaderGroupGridViewNonRp';
    $sort = true;
    if (isset($caraPrint)){
        $data = $model->searchPrintLaporan();
        $template = "{items}";
        $sort = false;
        if ($caraPrint == "EXCEL")
            $table = 'ext.bootstrap.widgets.BootExcelGridView';
    } else{
        $data = $model->searchTableLaporan();
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
            'header' => '<center>No.</center>',
            'type'=>'raw',
            'value' => '$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1',
            'htmlOptions'=>array('style'=>'text-align:center'),
        ),
        array(
            'header' => '<center>Kode</center>',
            'type'=>'raw',
            'value' => '$data->daftartindakan_kode',
        ),
        array(
            'header'=>'<center>Nama Jenis Periksa</center>',
            'type'=>'raw',
            'value'=>'$data->daftartindakan_nama',
            'footerHtmlOptions'=>array('colspan'=>3,'style'=>'text-align:right;font-style:italic;'),
            'footer'=>'Total',
        ),
        array(
            'header'=>'<center>Tarif</center>',
            'name'=>'tarif_satuan',
            'type'=>'raw',
            'value'=>'number_format($data->tarif_satuan,0,"",".")',
            'htmlOptions'=>array('style'=>'text-align:right'),
            'footerHtmlOptions'=>array('style'=>'text-align:right;'),
            'footer'=>'sum(tarif_satuan)',
        ),
        array(
            'header'=>'<center>Jumlah</center>',
            'name'=>'qty_tindakan',
            'type'=>'raw',
            'value'=>'number_format($data->qty_tindakan,0,"",".")',
            'htmlOptions'=>array('style'=>'text-align:center'),
            'footerHtmlOptions'=>array('style'=>'text-align:center;'),
            'footer'=>'sum(qty_tindakan)',
        ),
        array(
            'header'=>'<center>Total</center>',
            'name'=>'Total',
            'type'=>'raw',
            'value'=>'number_format($data->Total,0,"",".")',
            'htmlOptions'=>array('style'=>'text-align:right'),
            'footerHtmlOptions'=>array('style'=>'text-align:right;'),
            'footer'=>'sum(Total)',
        ),
        
    ),
)); ?> 