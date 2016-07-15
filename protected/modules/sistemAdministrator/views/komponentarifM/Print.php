
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
		////'komponentarif_id',
		array(
                        'header'=>'ID',
                        'value'=>'$data->komponentarif_id',
                ),
		'komponentarif_nama',
		'komponentarif_namalainnya',
		'komponentarif_urutan',
                array(
                     'header'=>'Instalasi',
                     'type'=>'raw',
                     'value'=>'$this->grid->getOwner()->renderPartial(\'_komponenTarifInstalasi\',array(\'komponentarif_id\'=>$data->komponentarif_id),true)',
                 ), 
                array(
                    'header'=>'Persentase',
                    'type'=>'raw',
                    'value'=>function($data) {
                        $kel = PersenkelkomponentarifM::model()->findAllByAttributes(array(
                            'komponentarif_id'=>$data->komponentarif_id,
                        ));
                        if (count($kel) == 0) return "-";
                        
                        $st = "<ul>";
                        foreach ($kel as $item) {
                            $st .= "<li>".$item->kelompokkomponentarif->kelompokkomponentarif_nama
                                    ." (".$item->persentase."%)</li>";
                        }
                        $st .= "</ul>";
                        
                        return $st;
                    }
                ),
		array
                (
                        'name'=>'komponentarif_aktif',
                        'type'=>'raw',
                        'value'=>'($data->komponentarif_aktif==1)? Yii::t("mds","Yes") : Yii::t("mds","No")',
                ),
 
        ),
    )); 
?>