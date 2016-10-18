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
			'value' => '$data->indikatorimplkepdet_id',
		),
                array(
                        'header' => 'Diagnosa Keperawatan',
                       // 'name' => 'diagnosakep_id',
                        'value' => 'isset($data->implementasikep->diagnosakep->diagnosakep_nama) ? $data->implementasikep->diagnosakep->diagnosakep_nama : " - "',
                       // 'filter' => Chtml::activeDropDownList($model, 'diagnosakep_id', Chtml::listData(DiagnosakepM::model()->findAll("diagnosakep_aktif = TRUE ORDER BY diagnosakep_nama ASC"), 'diagnosakep_id', 'diagnosakep_nama'), array('empty'=>'-- Pilih --'))
                ),				
                array(
                        'header' => 'Indikator',
                      //  'name' => 'indikatorimplkepdet_indikator',
                        'value' => 'isset($data->indikatorimplkepdet_indikator) ? $data->indikatorimplkepdet_indikator : " - "',
                ),
                array(
                        'header' => 'Status',
                        'value' => '($data->indikatorimplkepdet_aktif == true ? \'Aktif\': \'Tidak Aktif\')',

                ),
	),
));
?>