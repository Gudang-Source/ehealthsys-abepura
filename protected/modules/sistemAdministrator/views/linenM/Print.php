
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
		////'linen_id',
		array(
			'header'=>'ID',
			'value'=>'$data->linen_id',
		),
		'jenislinen_id',
		'ruangan_id',
		'rakpenyimpanan_id',
		'bahanlinen_id',
		'barang_id',
            array(
                                    'header' => 'Status',
                                    'value' => '($data->linen_aktif)?"Aktif":"Tidak Aktif"',
                                ),
		/*
		'kodelinen',
		'tglregisterlinen',
		'noregisterlinen',
		'namalinen',
		'namalainnya',
		'merklinen',
		'beratlinen',
		'warna',
		'tahunbeli',
		'gambarlinen',
		'jmlcucilinen',
		'create_time',
		'update_time',
		'create_loginpemakai_id',
		'update_loginpemakai_id',
		'create_ruangan',
		'linen_aktif',
		*/
 
	),
)); 
?>