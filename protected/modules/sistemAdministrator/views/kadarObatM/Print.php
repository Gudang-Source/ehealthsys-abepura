<?php 
if($caraPrint=='EXCEL')
{
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="'.$judulLaporan.'-'.date("Y/m/d").'.xls"');
    header('Cache-Control: max-age=0');     
}
echo $this->renderPartial('application.views.headerReport.headerLaporan',array('judulLaporan'=>$judulLaporan, 'colspan'=>10));      

  $table = 'ext.bootstrap.widgets.BootGridView';
    $sort = true;
    if (isset($caraPrint)){
        $data = $model->searchPrint();
        $template = "{items}";
        $sort = false;
        if ($caraPrint == "EXCEL")
            $table = 'ext.bootstrap.widgets.BootExcelGridView';
    } else{
        $data = $model->search();
         $template = "{summary}\n{items}\n{pager}";
    }
    
$this->widget($table,array(
    'id'=>'sajenis-kelas-m-grid',
    'enableSorting'=>$sort,
    'dataProvider'=>$data,
    'template'=>$template,
    'itemsCssClass'=>'table table-striped table-bordered table-condensed',
    'columns'=>array(
        ////'lookup_id',
        array(
                        'header'=>'ID',
                        'value'=>'$data->lookup_id',
                ),
        'lookup_name',
       // 'lookup_value',
        //'lookup_urutan',
        //'lookup_kode',
         array(
                        'header'=>'Nama Lain',
                        'value'=>'$data->lookup_value',
                ),
         array(
                        'header'=>'Dosis',
                        'value'=>'$data->lookup_kode',
                ),
         array(
                        'header'=>'Kode',
                        'value'=>'$data->lookup_urutan',
                ),
//        'lookup_aktif',
         array(
                        'header'=>'Status',
                        'value'=>'($data->lookup_aktif==1)? Yii::t("mds","Aktif") : Yii::t("mds","Tidak Aktif")'
                ),
 
        ),
    )); 
?>