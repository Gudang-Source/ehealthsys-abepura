
<?php
$table = 'ext.bootstrap.widgets.BootGridView';
if($caraPrint=='EXCEL')
{
    $table = 'ext.bootstrap.widgets.BootExcelGridView';
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="'.$judulLaporan.'-'.date("Y/m/d").'.xls"');
    header('Cache-Control: max-age=0');     
}
echo $this->renderPartial('application.views.headerReport.headerDefault',array('judulLaporan'=>$judulLaporan, 'colspan'=>4));      

$this->widget($table,array(
	'id'=>'sajenis-kelas-m-grid',
        'enableSorting'=>false,
	'dataProvider'=>$model->searchPrint(),
        'template'=>"{summary}\n{items}\n{pager}",
        'itemsCssClass'=>'table table-striped table-bordered table-condensed',
	'columns'=>array(
		////'jenisin_id',
		array(
                        'header'=>'ID',
                        'value'=>'$data->jenisin_id',
                ),
		'jenisin_nama',
		'jenisin_namalainnya',
		'jenisin_aktif',
                                array(
                                    'header'=>'Aktif',
                                    'value'=>'(($data->jenisin_aktif=1)? "Ya" : "Tidak")',
                                ),
 
        ),
    )); 
?>