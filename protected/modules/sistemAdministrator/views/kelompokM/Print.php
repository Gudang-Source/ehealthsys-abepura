
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
        'enableSorting'=>$sort,
	'dataProvider'=>$data,
        'template'=>$template,
        'itemsCssClass'=>'table table-striped table-bordered table-condensed',
	'columns'=>array(
		////'kelompok_id',
		array(
                        'header'=>'ID',
                        'value'=>'$data->kelompok_id',
                ),
		array(
                        'name'=>'golongan_id',
                        'filter'=>  CHtml::listData($model->GolonganItems, 'golongan_id', 'golongan_nama'),
                        'value'=>'$data->golongan->golongan_nama',
                ),
		'kelompok_kode',
		'kelompok_nama',
		'kelompok_namalainnya',
		array(
                        'header'=>'Aktif',
                        'class'=>'CCheckBoxColumn',     
                        'selectableRows'=>0,
                        'id'=>'rows',
                        'checked'=>'$data->kelompok_aktif',
                ),
 
        ),
    )); 
?>