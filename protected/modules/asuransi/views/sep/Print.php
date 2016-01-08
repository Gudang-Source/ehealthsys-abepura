
<?php 
$table = 'ext.bootstrap.widgets.BootGridView';
$template = "{summary}\n{items}\n{pager}";
if (isset($caraPrint)){
	$template = "{items}";
	if($caraPrint=='EXCEL'){
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="'.$judulLaporan.'-'.date("Y/m/d").'.xls"');
		header('Cache-Control: max-age=0');   
		$table = 'ext.bootstrap.widgets.BootExcelGridView';
	}
}

echo $this->renderPartial('application.views.headerReport.headerDefault',array('judulLaporan'=>$judulLaporan, 'colspan'=>''));  

$this->widget($table,array(
	'id'=>'sajenis-kelas-m-grid',
	'enableSorting'=>false,
	'dataProvider'=>$model->searchPrint(),
	'template'=>$template,
	'itemsCssClass'=>'table table-striped table-bordered table-condensed',
	'columns'=>array(
		////'sep_id',
		array(
			'header'=>'ID',
			'value'=>'$data->sep_id',
		),
		array(
				'header'=>'Tanggal SEP',
				'type'=>'raw',
				'value'=>'isset($data->tglsep) ? MyFormatter::formatDateTimeForUser($data->tglsep) : ""',
			),
			'nosep',
			'nokartuasuransi',
			array(
				'header'=>'Tanggal Rujukan',
				'type'=>'raw',
				'value'=>'isset($data->tglrujukan) ? MyFormatter::formatDateTimeForUser($data->tglrujukan) : ""',
			),
			'norujukan',
			'diagnosaawal',
			'ruangan.ruangan_nama',
			'kelasrawat.kelaspelayanan_nama',
			array(
				'header'=>'Tanggal Pulang',
				'type'=>'raw',
				'value'=>'MyFormatter::formatDateTimeForUser($data->tglpulang)',
			),
 
	),
)); 
?>