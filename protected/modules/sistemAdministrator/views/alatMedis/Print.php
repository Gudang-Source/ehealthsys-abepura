
<?php 
$itemCssClass = 'table table-striped table-condensed';
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
        
        if ($caraPrint=='PDF') {
            $table = 'ext.bootstrap.widgets.BootGridViewPDF';
        }
  
        echo "
        <style>
            .border th, .border td{
                border:1px solid #000;
            }
            .table thead:first-child{
                border-top:1px solid #000;        
            }

            thead th{
                background:none;
                color:#333;
            }

            .border {
                box-shadow:none;
                border-spacing:0px;
                padding:0px;
            }

            .table tbody tr:hover td, .table tbody tr:hover th {
                background-color: none;
            }
        </style>";
        $itemCssClass = 'table border';
}

echo $this->renderPartial('application.views.headerReport.headerDefault',array('judulLaporan'=>$judulLaporan, 'colspan'=>''));  

$this->widget($table,array(
	'id'=>'sajenis-kelas-m-grid',
	'enableSorting'=>false,
	'dataProvider'=>$model->searchPrint(),
	'template'=>$template,
	'itemsCssClass'=>$itemCssClass,
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