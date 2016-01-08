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
        ////'modul_id',
        array(
            'header'=>'No',
            'value' => '(($this->grid->dataProvider->pagination) ? $this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize : 0) + $row+1',
            ),
        'kelompokmodul.kelompokmodul_nama',
        'modul_nama',
        'modul_namalainnya',
        'modul_fungsi',
        'tglrevisimodul',
        /*
        'tglupdatemodul',
        'url_modul',
        'icon_modul',
        'modul_key',
        'modul_urutan',
        'modul_kategori',
        'modul_aktif',
        */
 
        ),
    )); 
?>