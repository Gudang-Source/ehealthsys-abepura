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
		////'jamkerja_id',
		array(
			'header'=>'ID',
			'value'=>'$data->jamkerja_id',
		),
		//'shift_id',
		'shift.shift_nama',
		'jamkerja_nama',
		'jammasuk',
		'jampulang',
		'jamisitrahat',
		array(
				'header'=>'<center>Status</center>',
				'value'=>'($data->jamkerja_aktif == 1 ) ? "Aktif" : "Tidak Aktif"',
				'htmlOptions'=>array('style'=>'text-align:center;'),
		),
		/*
		'jammasukistirahat',
		'jammulaiscanmasuk',
		'jamakhirscanmasuk',
		'jammulaiscanplng',
		'jamakhirscanplng',
		'toleransiterlambat',
		'toleransiplgcpt',
		'jamkerja_aktif',
		*/
 
	),
)); 
?>