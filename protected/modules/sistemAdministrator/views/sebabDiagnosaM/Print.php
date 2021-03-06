
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
        'template'=>"{summary}\n{items}\n{pager}",
        'itemsCssClass'=>'table table-striped table-bordered table-condensed',
	'columns'=>array(
		////'sebabdiagnosa_id',
		array(
                        'header'=>'ID',
                        'value'=>'$data->sebabdiagnosa_id',
                ),
		'jenissebab.jenissebab_nama',
		'sebabdiagnosa_nama',
		'sebabdiagnosa_namalainnya',
                                array(
                                    'header'=>'Aktif',
                                    'type'=>'raw',
                                    'value'=>'(($data->sebabdiagnosa_aktif=="1")? "Ya" : "Tidak")',
                                ),
 
        ),
    )); 
?>