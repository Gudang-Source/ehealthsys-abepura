
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
		////'pemeriksaanlab_id',
		array(
			'header'=>'ID',
			'value'=>'$data->pemeriksaanlab_id',
		),
		array(
			'name'=>'jenispemeriksaanlab_id',
			'value'=>'$data->jenispemeriksaan->jenispemeriksaanlab_nama',
			'filter'=>CHtml::listData(JenispemeriksaanlabM::model()->findAll(array('order'=>'jenispemeriksaanlab_urutan'),'jenispemeriksaanlab_aktif = true'), 'jenispemeriksaanlab_id', 'jenispemeriksaanlab_nama'),
		),
		array(
			'name'=>'daftartindakan_id',
			'value'=>'$data->daftartindakan->daftartindakan_nama',
			'filter'=>CHtml::activeTextField($model,'daftartindakan_nama'),
		),
		//'jenispemeriksaanlab_id',
		//'daftartindakan_id',
		'pemeriksaanlab_kode',
		'pemeriksaanlab_urutan',
		'pemeriksaanlab_nama',
		/*
		'pemeriksaanlab_namalainnya',
		'pemeriksaanlab_aktif',
		*/
		'pemeriksaanlab_namalainnya',
		array(
                        'header'=>'<center>Status</center>',
                        'value'=>'($data->pemeriksaanlab_aktif == 1 ) ? "Aktif" : "Tidak Aktif"',
                        'htmlOptions'=>array('style'=>'text-align:center;'),
		),
 
	),
)); 
?>