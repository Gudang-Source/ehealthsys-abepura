
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
		//'ruangan_id',
		array(
			'header'=>'Instalasi',
			'value'=>'$data->ruangan->instalasi->instalasi_nama',
			'filter'=>(Yii::app()->session['modul_id'] == Params::MODUL_ID_SISADMIN) ? CHtml::activeTextField($model, 'instalasi_nama') : false,
		),
		array(
			'name'=>'ruangan_id',
			'value'=>'$data->ruangan->ruangan_nama',
			'filter'=>(Yii::app()->session['modul_id'] == Params::MODUL_ID_SISADMIN) ? CHtml::activeTextField($model, 'ruangan_nama') : false,
		),
		array(
			'header'=>'Kelas Pelayanan ',
			'type'=>'raw',
			'value'=>'$data->kelaspelayanan->kelaspelayanan_nama',
			'filter'=> CHtml::activeDropDownList($model, 'kelaspelayanan_id', CHtml::listData(SAKelasPelayananM::model()->getItems(),'kelaspelayanan_id','kelaspelayanan_nama'),array('empty'=>''))
		), 
//                array(
//                  'header'=>'Aktif',
//                  'value'=>'($data->ruangan_aktif == 1) ? Yii::t("mds","Yes") : Yii::t("mds","No")',
//                ),
 
        ),
    )); 
?>