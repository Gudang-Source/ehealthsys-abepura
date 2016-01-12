
<?php 
if($caraPrint=='EXCEL')
{
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="'.$judulLaporan.'-'.date("Y/m/d").'.xls"');
    header('Cache-Control: max-age=0');     
}
echo $this->renderPartial('application.views.headerReport.headerLaporan',array('judulLaporan'=>$judulLaporan, 'colspan'=>10));      

$table = 'ext.bootstrap.widgets.BootGroupGridView';
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
	'mergeColumns' => array('obatalkes.obatalkes_nama'),
	'columns'=>array(
				array(
                    'header'=>'No',
                    'value'=>'$row+1',
                ),
                array(
					'header'=>'Nama Obat',
					'name'=>'obatalkes.obatalkes_nama',
					'value'=>'$data->obatalkes->obatalkes_nama',
                ),
                array(
					'header'=>'Nama Kelas Terapi',
					'name'=>'therapiobat.therapiobat_nama',
					'value'=>'$data->therapiobat->therapiobat_nama',
                ),
        ),
    )); 
?>