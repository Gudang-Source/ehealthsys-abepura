<?php 
$table = 'ext.bootstrap.widgets.BootGridView';
if($caraPrint=='EXCEL')
{
    $table = 'ext.bootstrap.widgets.BootExcelGridView';
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="'.$judulLaporan.'-'.date("Y/m/d").'.xls"');
    header('Cache-Control: max-age=0');     
}
echo $this->renderPartial('application.views.headerReport.headerDefault',array('judulLaporan'=>$judulLaporan, 'colspan'=>6));

$this->widget($table,array(
	'id'=>'sajenis-kelas-m-grid',
        'enableSorting'=>false,
	'dataProvider'=>$model->searchPrint(),
        'template'=>"{items}",
        'itemsCssClass'=>'table table-striped table-bordered table-condensed',
	'columns'=>array(
		////'triase_id',
		array(
                                    'header'=>'ID',
                                    'value'=>'$data->triase_id',
                                ),
		'triase_nama',
		'triase_namalainnya',
		'warna_triase',
		'kode_warnatriase',
		'keterangan_triase',
		/*
		'triase_aktif',
		*/
 
        ),
    )); 
?>