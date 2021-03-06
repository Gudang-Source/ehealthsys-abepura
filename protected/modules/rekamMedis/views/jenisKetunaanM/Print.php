
<?php 
$table = 'ext.bootstrap.widgets.BootGridView';
if($caraPrint=='EXCEL')
{
    $table = 'ext.bootstrap.widgets.BootExcelGridView';
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="'.$judulLaporan.'-'.date("Y/m/d").'.xls"');
    header('Cache-Control: max-age=0');     
}
echo $this->renderPartial('application.views.headerReport.headerLaporan',array('judulLaporan'=>$judulLaporan, 'colspan'=>5));      

$this->widget($table,array(
	'id'=>'sajenis-kelas-m-grid',
        'enableSorting'=>false,
	'dataProvider'=>$model->searchPrint(),
        'template'=>"{summary}\n{items}\n{pager}",
        'itemsCssClass'=>'table table-striped table-bordered table-condensed',
	'columns'=>array(
		////'jenisketunaan_id',
		array(
                        'header'=>'ID',
                        'value'=>'$data->jenisketunaan_id',
                ),
		'jenisketunaan_kode',
		'jenisketunaan_nama',
		'jenisketunaan_namalainnya',
                                array(
                                    'header'=>'<center>Status</center>',
                                    'value'=>'($data->jenisketunaan_aktif == 1 ) ? "Aktif" : "Tidak Aktif"',
                                    'htmlOptions'=>array('style'=>'text-align:center;'),
                                ),
 
        ),
    )); 
?>