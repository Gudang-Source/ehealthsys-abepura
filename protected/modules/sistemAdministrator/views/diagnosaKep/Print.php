<?php

if ($caraPrint == 'EXCEL') {
	header('Content-Type: application/vnd.ms-excel');
	header('Content-Disposition: attachment;filename="' . $judulLaporan . '-' . date("Y/m/d") . '.xls"');
	header('Cache-Control: max-age=0');
}
echo $this->renderPartial('application.views.headerReport.headerDefault', array('judulLaporan' => $judulLaporan, 'colspan' => 10));

$table = 'ext.bootstrap.widgets.BootGridView';
$sort = true;
if (isset($caraPrint)) {
	$data = $model->searchPrint();
	$template = "{items}";
	$sort = false;
	if ($caraPrint == "EXCEL")
		$table = 'ext.bootstrap.widgets.BootExcelGridView';
} else {
	$data = $model->searchPrint();
	$template = "{summary}\n{items}\n{pager}";
}

$this->widget($table, array(
	'id' => 'sadiagnosakep-m-grid',
	'enableSorting' => false,
	'dataProvider' => $data,
	'template' => $template,
	'enableSorting' => $sort,
	'itemsCssClass' => 'table table-striped table-bordered table-condensed',
	'columns' => array(
		array(
			'header' => 'ID',
			'value' => '$data->diagnosakep_id',
		),
		array(
			'header' => 'Kode Diagnosa',
			'value' => '$data->diagnosakep_kode',
		),
		array(
			'header' => 'Diagnosa Keperawatan',
			'value' => '$data->diagnosakep_nama',
		),
		array(
			'header' => 'Deskripsi',
			'value' => '$data->diagnosakep_deskripsi',
		),
		array(
			'header' => 'Aktif',
			'value' => '($data->diagnosakep_aktif == true ? \'Aktif\': \'Tidak Aktif\')'
		),
	),
));
?>