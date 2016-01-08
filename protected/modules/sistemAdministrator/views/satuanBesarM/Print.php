
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
            array(
            'name'=>'no',
            'value'=>'$row+1',
            'header'=>'No.',
//            'filter'=>false,
        ),
		array(
                        'header'=>'ID',
                        'value'=>'$data->satuanbesar_id',
                ),
		'satuanbesar_nama',
		'satuanbesar_namalain',
                  array
                (
                        'name'=>'satuanbesar_aktif',
                        'type'=>'raw',
                        'value'=>'($data->satuanbesar_aktif==1)? Yii::t("mds","Yes") : Yii::t("mds","No")',
                ),  
        ),
    )); 
?>