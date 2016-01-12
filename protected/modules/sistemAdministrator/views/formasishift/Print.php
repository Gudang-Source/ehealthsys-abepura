
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
	'dataProvider'=>$model->searchPrint2(),
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
			'header'=>'Ruangan',
			'name'=>'ruangan_id',
			'value'=>'$data->ruangan->ruangan_nama',
			'type'=>'raw',
			'filter'=>CHtml::activeTextField($model,'ruangan_nama'),
		),
		array(
			'header'=>'Shiift',
			'name'=>'shift_id',
			'value'=>'$data->shift->shift_nama',
			'type'=>'raw',
			'filter'=>CHtml::activeTextField($model,'shift_nama'),
		),
		array(
			'header'=>'Jumlah Formasi (Orang)',
			'name'=>'jmlformasi',
			'value'=>'$data->jmlformasi',
			'type'=>'raw',
		),
		/*
		'create_loginpemakai_id',
		'update_loginpemakai_id',
		'create_ruangan',
		'formasishift_aktif',
		*/

	),
)); 
?>