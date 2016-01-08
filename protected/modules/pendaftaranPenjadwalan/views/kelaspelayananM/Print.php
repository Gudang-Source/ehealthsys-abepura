
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
        'enableSorting'=>$sort,
	'dataProvider'=>$data,
        'template'=>$template,
        'itemsCssClass'=>'table table-striped table-bordered table-condensed',
	'columns'=>array(
			////'kelaspelayanan_id',
			array(
				'header'=>'ID',
				'value'=>'$data->kelaspelayanan_id',
			),
			'jeniskelas_id',
			'kelaspelayanan_nama',
			'kelaspelayanan_namalainnya',
			array(
				'header'=>'Ruangan ',
				'type'=>'raw',
				'value'=>'$this->grid->getOwner()->renderPartial(\'_ruangan\',array(\'kelaspelayanan_id\'=>$data->kelaspelayanan_id),true)',
			), 
			array(
				'header'=>'Aktif',
				'value'=>'($data->kelaspelayanan_aktif == 1) ? Yii::t("mds","Yes") : Yii::t("mds","No")',
			),
        ),
    )); 
?>