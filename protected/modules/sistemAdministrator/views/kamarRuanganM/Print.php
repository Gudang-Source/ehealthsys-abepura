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
	'id'=>'sakamar-ruangan-m-grid',
        'enableSorting'=>$sort,
	'dataProvider'=>$data,
        'template'=>$template,
        'itemsCssClass'=>'table table-striped table-bordered table-condensed',
	'columns'=>array(
		array(
                        'name'=>'kamarruangan_id',
                        'value'=>'$data->kamarruangan_id',
                        'filter'=>false,
                ),
                'kelaspelayanan.kelaspelayanan_nama',
		'kamarruangan_nokamar',
		'kamarruangan_jmlbed',	
                'kamarruangan_nobed',
                 array
                (
                        'name'=>'kamarruangan_status',
                        'type'=>'raw',
                        'value'=>'($data->kamarruangan_status==1)? Yii::t("mds","Yes") : Yii::t("mds","No")',
                ),
             array
                (
                        'name'=>'kamarruangan_aktif',
                        'type'=>'raw',
                        'value'=>'($data->kamarruangan_aktif==1)? Yii::t("mds","Yes") : Yii::t("mds","No")',
                ),
		/*
		'kamarruangan_status',
		'kamarruangan_aktif',
		*/
 
        ),
    )); 
?>