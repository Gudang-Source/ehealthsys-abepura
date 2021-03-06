
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
        'enableSorting'=>false,
	'dataProvider'=>$data,
        'template'=>$template,
        'enableSorting'=>$sort,
        'itemsCssClass'=>'table table-striped table-bordered table-condensed',
	'columns'=>array(
		////'tabularlist_id',
		array(
                        'header'=>'ID',
                        'value'=>'$data->tabularlist_id',
                ),
		'tabularlist_chapter',
		'tabularlist_block',
		'tabularlist_title',
		'tabularlist_revisi',
		'tabularlist_versi',
                array(
                    'header'=>'Status',
                    'value'=>'($data->tabularlist_aktif == TRUE)?"Aktif":"Tidak Aktif"'
                ),
		/*
		'tabularlist_aktif',
		*/
 
        ),
    )); 
?>