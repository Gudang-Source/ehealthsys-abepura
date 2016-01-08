
<?php 
$table = 'ext.bootstrap.widgets.BootGridView';
$template = "{summary}\n{items}\n{pager}";
if (isset($caraPrint)){
    $template = "{items}";
}
if($caraPrint=='EXCEL')
{
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="'.$judulLaporan.'-'.date("Y/m/d").'.xls"');
    header('Cache-Control: max-age=0');   
    $table = 'ext.bootstrap.widgets.BootExcelGridView';
}
echo $this->renderPartial('application.views.headerReport.headerDefault',array('judulLaporan'=>$judulLaporan, 'colspan'=>''));      

$this->widget($table,array(
	'id'=>'saaksespengguna-k-grid',
	// 'mergeColumns'=>array('loginpemakai.nama_pemakai'),
        'enableSorting'=>false,
	'dataProvider'=>$model->searchPrint(),
        'template'=>$template,
        'itemsCssClass'=>'table table-striped table-bordered table-condensed',
	'columns'=>array(
		////'tugaspengguna_id',
		array(
                        'header'=>'No.',
                        'value' => '($row+1)',
                        'type'=>'raw',
                        'htmlOptions'=>array('style'=>'text-align:right;'),
                ),
        array(
                'name'=>'loginpemakai.nama_pemakai',
                'value'=>'$data->loginpemakai->nama_pemakai',
                'filter'=>false,
        ),
        array(
                'name'=>'peranpengguna.peranpenggunanama',
                'value'=>'$data->peranpengguna->peranpenggunanama',
                'filter'=>false,
        ),
        array(
                'name'=>'modul.modul_nama',
                'value'=>'$data->modul->modul_nama',
                'filter'=>false,
        ),
         
 
        ),
    )); 
?>

