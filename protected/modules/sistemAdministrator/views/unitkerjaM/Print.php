
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
		////'unitkerja_id',
//		array(
//			'header'=>'ID',
//			'value'=>'$data->unitkerja_id',
//		),
		 array(
                            'header'=>'No.',
                            'value' => '($this->grid->dataProvider->pagination) ? 
                                            ($this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1)
                                            : ($row+1)',
                            'type'=>'raw',
                            'htmlOptions'=>array('style'=>'text-align:center; width:10px;'),
                    ),
                    'kodeunitkerja',
                    'namaunitkerja',
                    'namalain',
    //		array(
    //			'header'=>'Ruangan Unit',
    //			'name'=>'ruangan_nama',
    //			'type'=>'raw',
    //			'value'=>'$data->ruanganMs->ruangan_nama'
    //		),

                    array(
                             'header'=>'Ruangan Unit',
                             'type'=>'raw',
                             'value'=>'$this->grid->getOwner()->renderPartial(\''.$this->path_view.'_ruanganUnit\',array(\'unitkerja_id\'=>$data->unitkerja_id),true)',
                    ), 
                    array(
                             'header'=>'Status',
                             'type'=>'raw',
                             'value'=>'(($data->unitkerja_aktif) ? "Aktif" : "Tidak Aktif")',
                             'htmlOptions'=>array('style'=>'width:10px; text-align:center;'),
                    ), 
 
	),
)); 
?>