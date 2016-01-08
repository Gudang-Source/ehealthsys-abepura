
<?php 
if($caraPrint=='EXCEL')
{
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="'.$judulLaporan.'-'.date("Y/m/d").'.xls"');
    header('Cache-Control: max-age=0');     
}
echo $this->renderPartial('application.views.headerReport.headerDefault',array('judulLaporan'=>$judulLaporan, 'colspan'=>10));      

    $table = 'ext.bootstrap.widgets.BootGridView';
    $sort = false;
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
	'id'=>'saasal-rujukan-m-grid',
	'dataProvider'=>$model->searchPrint(),
        'template'=>$template,
        'itemsCssClass'=>'table table-striped table-bordered table-condensed',
	'columns'=>array(
		////'asalrujukan_id',
                array(
                        'name'=>'asalrujukan_id',
                        'value'=>'$data->asalrujukan_id',
                        'filter'=>false,
                ),		
                'asalrujukan_nama',
		'asalrujukan_institusi',
		'asalrujukan_namalainnya',
		//'asalrujukan_aktif',
                array(
                        'header'=>'Aktif',
                        'type'=>'raw',
                        'value'=>'(($data->asalrujukan_aktif)? "Ya" : "Tidak")',
                ),
                ),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
)); ?>