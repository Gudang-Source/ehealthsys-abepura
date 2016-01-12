
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
			array(
				'header'=>'No.',
				'value' => '($this->grid->dataProvider->pagination) ? 
						($this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1)
						: ($row+1)',
				'type'=>'raw',
				'htmlOptions'=>array('style'=>'text-align:right;'),
			),
			array(
				'header'=>'Jabatan',
				'name'=>'jabatan_id',
				'value'=>'(isset($data->jabatan->jabatan_nama) ? $data->jabatan->jabatan_nama : "-")',
			),
			array(
				'header'=>'Jenis Penilaian',
				'name'=>'jenispenilaian_id',
				'value'=>'(isset($data->jenispenilaian->jenispenilaian_nama) ? $data->jenispenilaian->jenispenilaian_nama : "-")',
			),
			array(
				'header'=>'Kompetensi',
				'name'=>'kompetensi_id',
				'value'=>'(isset($data->kompetensi->kompetensi_nama) ? $data->kompetensi->kompetensi_nama : "-")',
			),
			'indikatorperilaku_nama',
			array(
				'name'=>'indikatorperilaku_aktif',
				'value'=>'($data->indikatorperilaku_aktif == 1) ? "Aktif" : "Tidak Aktif"',
				'filter'=>array(1=>'Aktif',0=>'Tidak Aktif'),
				'htmlOptions'=>array('style'=>'text-align:left;'),
			),
	),
)); 
?>