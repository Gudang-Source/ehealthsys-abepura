
<?php 
if($caraPrint=='EXCEL')
{
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="'.$judulLaporan.'-'.date("Y/m/d").'.xls"');
    header('Cache-Control: max-age=0');     
}
echo $this->renderPartial('application.views.headerReport.headerDefault',array('judulLaporan'=>$judulLaporan, 'colspan'=>10));      

$table = 'ext.bootstrap.widgets.BootGridView';
    $sort = true;
    if (isset($caraPrint)){
        $data = $model->searchPrint();
        $template = "{items}";
        $sort = false;
        if ($caraPrint == "EXCEL")
            $table = 'ext.bootstrap.widgets.BootExcelGridView';
    } else{
        $data = $model->searchPrint();
         $template = "{summary}\n{items}\n{pager}";
    }
    
$this->widget($table, array(
	'id'=>'kelrem-m-grid',
	'dataProvider'=>$data,
        'enableSorting'=>$sort,
        'template'=>$template,
        'itemsCssClass'=>'table table-bordered table-striped table-condensed',
	'columns'=>array(
		array(
                    'header' => 'ID',
                    'value' => '$data->kelrem_id'
                ),
		//'kelrem_urutan',
		'kelrem_kode',
		'kelrem_nama',
                'kelrem_singkatan',
		'kelrem_desc',
		
		/*
		'kelrem_rate',
		'kelrem_aktif',
		*/
                                array(
                                        'header'=>'Aktif',
                                        'value'=>'(($data->kelrem_aktif==TRUE) ? "Ya" : "Tidak")',
                                ),
	),
)); ?>