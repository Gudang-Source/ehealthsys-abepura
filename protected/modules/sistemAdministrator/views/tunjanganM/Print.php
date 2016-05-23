
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
			'htmlOptions'=>array('style'=>'text-align:center; width:10px;'),
		),
		array(
			'name'=>'pangkat_id',
			'type'=>'raw',
			'value'=>'isset($data->pangkat_id)?$data->pangkat->pangkat_nama:"-"',
		),
		array(
			'name'=>'jabatan_id',
			'type'=>'raw',
			'value'=>'isset($data->jabatan_id)?$data->jabatan->jabatan_nama:"-"',
		),
		array(
			'name'=>'komponengaji_id',
			'type'=>'raw',
			'value'=>'isset($data->komponengaji_id)?$data->komponengaji->komponengaji_nama:"-"',
		),
		array(
			'name'=>'nominaltunjangan',
			'type'=>'raw',
			'value'=>'"Rp".number_format($data->nominaltunjangan,0,"",".")',
                        'htmlOptions' => array('style' => 'text-align:right')
		),
		array(
			'header'=>'Status',
			'type'=>'raw',
			'value'=>'(($data->tunjangan_aktif) ? "Aktif" : "Tidak Aktif")',
		),
 
	),
)); 
?>