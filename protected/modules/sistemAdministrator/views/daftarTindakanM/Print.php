
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
    
$this->widget($table,array(
	'id'=>'sajenis-kelas-m-grid',
        'enableSorting'=>$table,
	'dataProvider'=>$data,
        'template'=>$template,
        'itemsCssClass'=>'table table-striped table-bordered table-condensed',
	'columns'=>array(
		array(
                    'header'=>'ID',
                    'value'=>'$data->daftartindakan_id',
                ),
                array(
                    'name'=>'komponenunit_nama',
                    'value'=>'(isset($data->komponenunit->komponenunit_nama) ? $data->komponenunit->komponenunit_nama : "")',
                ),
                array(
                    'name'=>'kategoritindakan_nama',
                    'value'=>'(isset($data->kategoritindakan->kategoritindakan_nama) ? $data->kategoritindakan->kategoritindakan_nama : "")',
                ),
		array(
                    'name'=>'kelompoktindakan_nama',
                    'value'=>'(isset($data->kelompoktindakan->kelompoktindakan_nama) ? $data->kelompoktindakan->kelompoktindakan_nama : "")',
                ),
		'daftartindakan_kode',
		'daftartindakan_nama',
                 array
                (
                    'name'=>'daftartindakan_aktif',
                    'type'=>'raw',
                    'value'=>'($data->daftartindakan_aktif==1)? Yii::t("mds","Yes") : Yii::t("mds","No")',
                ),
        ),
    )); 
?>