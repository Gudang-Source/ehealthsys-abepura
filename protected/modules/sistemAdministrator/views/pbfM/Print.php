
<?php 
if($caraPrint=='EXCEL')
{
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="'.$judulLaporan.'-'.date("Y/m/d").'.xls"');
    header('Cache-Control: max-age=0');     
}
echo $this->renderPartial('application.views.headerReport.headerLaporan',array('judulLaporan'=>$judulLaporan, 'colspan'=>10));      

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
    
$this->widget($table,array(
	'id'=>'sajenis-kelas-m-grid',
        'enableSorting'=>$sort,
	'dataProvider'=>$data,
        'template'=>$template,
        'itemsCssClass'=>'table table-striped table-bordered table-condensed',
	'columns'=>array(
		////'pbf_id',
		array(
                        'header'=>'No.',
                        'value'=>'$row+1',
                ),
		'pbf_kode',
		'pbf_nama',
		'pbf_singkatan',
		'pbf_alamat',
		'pbf_propinsi',
		'pbf_kabupaten',
                 array
                (
                        'name'=>'pbf_aktif',
                        'type'=>'raw',
                        'value'=>'($data->pbf_aktif==1)? Yii::t("mds","Yes") : Yii::t("mds","No")',
                ),  
        ),
    )); 
?>