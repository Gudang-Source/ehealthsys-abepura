
<?php 
$table = 'ext.bootstrap.widgets.BootGridView';
if($caraPrint=='EXCEL')
{
    $table = 'ext.bootstrap.widgets.BootExcelGridView';
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="'.$judulLaporan.'-'.date("Y/m/d").'.xls"');
    header('Cache-Control: max-age=0');     
}
echo $this->renderPartial('application.views.headerReport.headerDefault',array('judulLaporan'=>$judulLaporan, 'colspan'=>5));      

$this->widget($table,array(
	'id'=>'sajenis-kelas-m-grid',
        'enableSorting'=>false,
	'dataProvider'=>$model->searchPrint(),
        'template'=>"{items}",
        'itemsCssClass'=>'table table-striped table-bordered table-condensed',
	'columns'=>array(
		////'lookup_id',
		array(
                        'header'=>'ID',
                        'value'=>'$data->lookup_id',
                ),
		'lookup_type',
		'lookup_name',
		array(
                        'header'=>'Nama Lain',
                        'value'=>'$data->lookup_value',
                ),
		'lookup_kode',
		/*
		'lookup_aktif',
		*/
 
        ),
    )); 
?>