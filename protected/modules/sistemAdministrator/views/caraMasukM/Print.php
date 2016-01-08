
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
	'id'=>'sacara-masuk-m-grid',
	'dataProvider'=>$model->search(),
        'template'=>$template,
        'itemsCssClass'=>'table table-striped table-bordered table-condensed',
	'columns'=>array(
		////'caramasuk_id',
array(
                        'header'=>'ID',
                        'value'=>'$data->caramasuk_id',
                ),		
                'caramasuk_nama',
		'caramasuk_namalainnya',
		//'caramasuk_aktif',
                 array
                (
                        'header'=>'Aktif',
                        'name'=>'daftartindakan_aktif',
                        'type'=>'raw',
                        'value'=>'($data->caramasuk_aktif==1)? Yii::t("mds","Yes") : Yii::t("mds","No")',
                ),
            
	),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
)); ?>