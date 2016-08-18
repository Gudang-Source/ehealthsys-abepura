
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
         $template = "{pager}{summary}\n{items}";
    }
    
$this->widget($table,array(
	'id'=>'sajenis-kelas-m-grid',
        'enableSorting'=>$sort,
	'dataProvider'=>$data,
        'template'=>$template,
        'itemsCssClass'=>'table table-striped table-bordered table-condensed',
	'columns'=>array(
		array(
            'header'=>'ID',
            'value'=>'$data->harikerjagol_id',
        ),
        'kelompokpegawai.kelompokpegawai_nama',            
         array(
            'header' => 'Periode Hari Kerja Awal',
            'value' => 'MyFormatter::formatDateTimeForUser($data->periodeharikerjaawl)'
        ),
         array(
            'header' => 'Periode Hari Akhir',
            'value' => 'MyFormatter::formatDateTimeForUser($data->periodehariakhir)'
        ),
         array(
            'header' => 'Periode Hari Kerja Akhir',
            'value' => 'MyFormatter::formatDateTimeForUser($data->periodeharikerjaakhir)'
        ),           
        'jmlharibln',
        array(
            'header'=>'Aktif',
            'type'=>'raw',
            'value'=>'(($data->harikerjagol_aktif==1)? "Ya" : "Tidak")',
        ),
 
    ),
)); 
?>