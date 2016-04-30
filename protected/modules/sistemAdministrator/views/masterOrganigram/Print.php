
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
		'organigram_kode',
		array(
			'name'=>'organigramasal_id',
			'value'=>'isset($data->organigramasal->pegawai->nama_pegawai) ? $data->organigramasal->pegawai->nama_pegawai : (isset($data->organigramasal->organigram_unitkerja) ? $data->organigramasal->organigram_unitkerja : "-")',
		),
		'organigram_unitkerja',
		'organigram_formasi',
		array(
			'name'=>'pegawai.nama_pegawai',
		),
		array(
			'name'=>'pegawai.jabatan.jabatan_nama',
		),
		'organigram_pelaksanakerja',
		//'organigram_periode',
                array(
                    'header' => 'Periode',
                    'value' => 'MyFormatter::formatDateTimeForUser($data->organigram_periode)'
                ),
		//'organigram_sampaidengan',
                array(
                    'header' => 'Sampai Dengan',
                    'value' => 'MyFormatter::formatDateTimeForUser($data->organigram_sampaidengan)'
                ),
		array(
			'name'=>'organigram_urutan',
			'filter'=>false,
		),
                array(
			'header'=>'Status',
			'value'=>'($data->organigram_aktif)?"Aktif":"Tidak Aktif"',
		),
	),
)); 
?>