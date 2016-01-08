
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
        $data = $model->searchMasterPP();
        $template = "{items}";
        $sort = false;
        if ($caraPrint == "EXCEL")
            $table = 'ext.bootstrap.widgets.BootExcelGridView';
    } else{
        $data = $model->searchMasterPP();
         $template = "{summary}\n{items}\n{pager}";
    }
    
    
$this->widget($table,array(
	'id'=>'sajenis-kelas-m-grid',
        'enableSorting'=>$sort,
	'dataProvider'=>$data,
        'template'=>$template,
        'itemsCssClass'=>'table table-striped table-bordered table-condensed',
	'columns'=>array(
		////'jadwalbukapoli_id',
		array(
                        'header'=>'ID',
                        'value'=>'$data->jadwalbukapoli_id',
                        'filter'=>false,
                ),
                array(
                        'name'=>'ruangan_id',
                        'value'=>'$data->ruangan->ruangan_nama',
                        'filter'=>false,
                ),
		'hari',
		'jmabuka',
		'jammulai',
		'jamtutup',
		/*
		'maxantiranpoli',
		'create_time',
		'update_time',
		'create_loginpemakai_id',
		'update_loginpemakai_id',
		'create_ruangan',
		*/
 
        ),
    )); 
?>