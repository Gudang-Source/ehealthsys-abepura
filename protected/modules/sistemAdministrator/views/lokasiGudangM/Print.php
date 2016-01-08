
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
		////'lokasigudang_id',
		array(
                        'header'=>'ID',
                        'value'=>'$data->lokasigudang_id',
                ),
		'lokasigudang_nama',
		'lokasigudang_namalain',
                array(
                    'header'=>'Lokasi Gudang',
                    'name'=>'lokasigudang_farmasi',
                    'value'=>'($data->lokasigudang_farmasi == 1 ) ? "Ya" : "Tidak"',
                    'htmlOptions'=>array('style'=>'text-align:center;'),
//                    'class'=>'CCheckBoxColumn',     
//                    'selectableRows'=>0,
//                    'id'=>'rows',
//                    'checked'=>'$data->lokasigudang_farmasi',
                ), 
                 array
                (
                        'header'=>'Status',
                        'name'=>'lokasigudang_aktif',
                        'type'=>'raw',
                        'value'=>'($data->lokasigudang_aktif==1)? Yii::t("mds","Aktif") : Yii::t("mds","Tidak Aktif")',
                ),   
        ),
    )); 
?>