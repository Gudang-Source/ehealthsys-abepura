
<?php 
$table = 'ext.bootstrap.widgets.BootGridView';
$template = "{pager}{summary}\n{items}";
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
	'id'=>'sajenis-kelas-m-grid',
        'enableSorting'=>false,
	'dataProvider'=>$model->searchPrint(),
        'template'=>$template,
        'itemsCssClass'=>'table table-striped table-bordered table-condensed',
	'columns'=>array(
		////'mutasioaruangan_id',
		array(
                        'header'=>'ID',
                        'value'=>'$data->mutasioaruangan_id',
                ),
		'pesanobatalkes_id',
		'terimamutasi_id',
		'tglmutasioa',
		'nomutasioa',
		'ruanganasal_id',
		/*
		'ruangantujuan_id',
		'keteranganmutasi',
		'totalharganettomutasi',
		'totalhargajual',
		'create_time',
		'update_time',
		'create_loginpemakai_id',
		'update_loginpemakai_id',
		'create_ruangan',
		'pegawaimutasi_id',
		'pegawaimengetahui_id',
		*/
 
        ),
    )); 
?>