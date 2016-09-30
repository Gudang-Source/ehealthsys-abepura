<?php
$itemCssClass = 'table table-striped table-condensed';
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
	if ($caraPrint == "EXCEL"){
		$table = 'ext.bootstrap.widgets.BootExcelGridView';
        }
        echo "
            <style>
                .border th, .border td{
                    border:1px solid #000;
                }
                .table thead:first-child{
                    border-top:1px solid #000;        
                }

                thead th{
                    background:none;
                    color:#333;
                }

                .border {
                    box-shadow:none;
                }

                .table tbody tr:hover td, .table tbody tr:hover th {
                    background-color: none;
                }
            </style>";
        $itemCssClass = 'table border';
} else {
	$data = $model->searchPrint();
	$template = "{summary}\n{items}\n{pager}";
}

$this->widget($table, array(
	'id' => 'sajenis-kelas-m-grid',
	'enableSorting' => $sort,
	'dataProvider' => $data,
	'template' => $template,
	'itemsCssClass' => $itemCssClass,
	'columns' => array(
		array(
			'header' => 'ID',
			'value' => '$data->intervensidet_id',
		),
		array(
			'header' => 'Diagnosa Keperawatan',
			'value' => 'isset($data->diagnosakep_nama) ? $data->diagnosakep_nama : " - "',
		),
		array(
			'header' => 'Nama Intervensi',
			'value' => 'isset($data->intervensi->intervensi_nama) ? $data->intervensi->intervensi_nama : " - "',
		),
		array(
			'header' => 'Indikator',
			'value' => 'isset($data->intervensidet_indikator) ? $data->intervensidet_indikator : " - "',
		),
		array(
			'header' => 'Status',
			'value' => '($data->intervensidet_aktif == true ? \'Aktif\': \'Tidak Aktif\')'
		),
	),
));
?>