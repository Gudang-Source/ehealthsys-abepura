
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
		////'alatmedis_id',
		array(
			'header'=>'ID',
			'value'=>'$data->alatmedis_id',
		),
		array(
			'name'=>'instalasi_id',
			'type'=>'raw',
			'value'=>'$data->instalasi->instalasi_nama',
			'filter'=> false,
		),
		array(
			'name'=>'jenisalatmedis_id',
			'type'=>'raw',
			'value'=>'$data->jenisalatmedis->jenisalatmedis_nama',
			'filter'=> false,
		),
		'alatmedis_noaset',
		'alatmedis_nama',
		'alatmedis_namalain',
		'alatmedis_kode',
		'alatmedis_format',
		/*
		'alatmedis_aktif',
		*/
		array(
				'header'=>'Status',
				'value' => '($data->alatmedis_aktif == true ? \'Aktif\': \'Tidak Aktif\')'
		), 
	),
)); 
?>