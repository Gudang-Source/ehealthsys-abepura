
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
			'header'=>'Nama Pemeriksaan',
			'type'=>'raw',
			'value'=>'$data->pemeriksaanlab->pemeriksaanlab_nama',
			'filter'=>  CHtml::activeTextField($model,'pemeriksaanlab_nama'),
		),
		array(
			'header'=>'Kelompok Detail',
			'type'=>'raw',
			'value'=>'$data->getNamaPemeriksaanDet($data->pemeriksaanlabdet_id)',
			'filter'=>  CHtml::activeTextField($model,'kelompokdet'),
		),
		array(
			'header'=>'Nama Pemeriksaan Detail',
			'type'=>'raw',
			'value'=>'$data->getKelompokDet($data->pemeriksaanlabdet_id)',
			'filter'=>  CHtml::activeTextField($model,'namapemeriksaandet'),
		),	
		array(
			'name'=>'nilairujukan.nilairujukan_jeniskelamin',
			'type'=>'raw',
			'filter'=>  CHtml::activeTextField($model,'nilairujukan_jeniskelamin'),
		),
		array(
			'name'=>'nilairujukan.nilairujukan_nama',
			'type'=>'raw',
			'value'=>'$data->NilaiRujukan',
			'filter'=>  CHtml::activeTextField($model,'nilairujukan_nama'),
		),
		array(
			'name'=>'nilairujukan.nilairujukan_min',
			'type'=>'raw',
			'filter'=>  CHtml::activeTextField($model,'nilairujukan_min',array('class'=>'numbers-only')),
		),
		array(
			'name'=>'nilairujukan.nilairujukan_max',
			'type'=>'raw',
			'filter'=>  CHtml::activeTextField($model,'nilairujukan_max',array('class'=>'numbers-only')),
		),
		array(
			'name'=>'nilairujukan.nilairujukan_satuan',
			'type'=>'raw',
			'filter'=>  CHtml::activeTextField($model,'nilairujukan_satuan',array('class'=>'numbers-only')),
		),
		'pemeriksaanlabdet_nourut',
	),
)); 
?>