
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
	//'enableSorting'=>false,
	'dataProvider'=>$model->search(),
	'template'=>$template,
	'itemsCssClass'=>'table table-striped table-bordered table-condensed',
	'columns'=>array(
		////'jenispemeriksaanlab_id',
		array(
			'header'=>'ID',
			'value'=>'$data->jenispemeriksaanlab_id',
		),
                array(
                    'header' => 'Kode',
                    'value' => '$data->jenispemeriksaanlab_kode'
                ),
		array(
                    'header' => 'Urutan',
                    'value' => '$data->jenispemeriksaanlab_urutan'
                ),
                array(
                        'header' => 'Nama',
                        'value' => '$data->jenispemeriksaanlab_nama'
                    ),
                array(
                        'header' => 'Nama Lain',
                        'value' => '$data->jenispemeriksaanlab_namalainnya'
                    ),
                array(
                        'header' => 'kelompok',
                        'value' => '$data->jenispemeriksaanlab_kelompok'
                    ),		
                array(
                    'header' => 'Status',
                    'value' => '($data->jenispemeriksaanlab_aktif==1)?"Aktif":"Tidak Aktif"'
                ),
		/*
		'jenispemeriksaanlab_aktif',
		*/
 
	),
)); 
?>