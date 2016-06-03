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
	'id' => 'sajenis-kelas-m-grid',
	'enableSorting' => $sort,
	'dataProvider' => $data,
	'template' => $template,
	'itemsCssClass' => 'table table-striped table-bordered table-condensed',
	'columns' => array(
		array(
			'header' => 'ID',
			'value' => '$data->bataskarakteristikdet_id',
		),
		array(
			'header' => 'Diagnosa Keperawatan',
			'value' => 'isset($data->diagnosakep_nama) ? $data->diagnosakep_nama : " - "',
		),
		array(
			'header' => 'Nama Batasan Karakteristik',
			'value' => 'isset($data->bataskarakteristik->bataskarakteristik_nama) ? $data->bataskarakteristik->bataskarakteristik_nama : " - "',
		),
		array(
			'header' => 'Indikator',
			'value' => 'isset($data->bataskarakteristikdet_indikator) ? $data->bataskarakteristikdet_indikator : " - "',
		),
		array(
			'header' => 'Status',
			'value' => '($data->bataskarakteristikdet_aktif == true ? \'Aktif\': \'Tidak Aktif\')'
		),
	),
));
?>