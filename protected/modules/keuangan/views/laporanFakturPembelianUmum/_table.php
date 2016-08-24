<?php
//    $table = 'ext.bootstrap.widgets.BootGroupGridView';
$table = 'ext.bootstrap.widgets.BootGridView';
$sort = true;
if (isset($caraPrint)) {
	$data = $model->searchLaporan();
	$template = "{items}";
	$sort = false;
        if ($caraPrint == "EXCEL")
        {
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
} else {
	$data = $model->searchLaporan();
	$template = "{summary}\n{items}\n{pager}";
	$itemsCssClass = 'table table-striped table-bordered table-condensed';
}

$this->widget($table, array(
	'id' => 'laporan-grid',
	'dataProvider' => $data,
	'template' => $template,
	'itemsCssClass' => $itemsCssClass,
	'columns' => array(
		array(
			'header' => 'No.',
			'headerHtmlOptions' => array('style' => 'text-align:left;'),
			'value' => '$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1'
		),
		array(
			'name' => 'tglterima',
			'headerHtmlOptions' => array('style' => 'text-align:left;'),
			'value' => 'date("d/m/Y H:i:s",strtotime($data->tglterima))',
		),
		array(
			'header' => 'Tanggal Terima',
			'type' => 'raw',
			'value' => 'MyFormatter::formatDateTimeForUser($data->tglterima)',
		),
		'nopenerimaan',
		'supplier_nama',
		'nofaktur',
		'tgljatuhtempo',
		array(
			'header' => 'Keterangan Persediaan',
			'type' => 'raw',
			'value' => '$data->keterangan_persediaan',
		),
		array(
			'header' => 'Umur Hutang',
			'type' => 'raw',
			'value' => '$data->umurHutang',
			'footer' => 'Total Hutang :',
			'footerHtmlOptions' => array('colspan' => 7, 'style' => 'text-align:right;'),
		),
		array(
			'header' => 'Total Harga',
			'name' => 'totalharga',
			'type' => 'raw',
			'value' => '"Rp. ".number_format($data->totalharga)',
			'footer' => 'sum(totalharga)',
			'footerHtmlOptions' => array('style' => 'text-align:left;'),
		),
		array(
			'header' => 'Discount',
			'name' => 'discount',
			'type' => 'raw',
			'value' => '"Rp. ".number_format($data->discount)',
			'footer' => '-',
			'footerHtmlOptions' => array('style' => 'text-align:left;color:white;'),
		),
		array(
			'header' => 'Pajak PPH',
			'name' => 'pajakpph',
			'type' => 'raw',
			'value' => '"Rp. ".number_format($data->pajakpph)',
			'footer' => '-',
			'footerHtmlOptions' => array('style' => 'text-align:left;color:white;'),
		),
		array(
			'header' => 'Pajak PPN',
			'name' => 'pajakppn',
			'type' => 'raw',
			'value' => '"Rp. ".number_format($data->pajakppn)',
			'footer' => '-',
			'footerHtmlOptions' => array('style' => 'text-align:left;color:white;'),
		),
	),
	'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));
?> 
<script>
	$('.integer').each(function () {
		formatNumber();
	});
</script>