
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
$row = '$this->grid->dataProvider->Pagination->CurrentPage*$this->grid->dataProvider->pagination->pageSize+$row+1';
    if (isset($caraPrint)){
        $row = '$row+1';
        $data = $model->searchPrintSuplier();
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
		////'supplier_id',
                array(
                    'header'=>'No',
                    'value'=>$row,
                ),
		'supplier_kode',
		'supplier_nama',
		'supplier_alamat',
     		'supplier_cp',
                array(
                    'header'=>'<center>Status</center>',
                    'value'=>'($data->supplier_aktif == 1 ) ? "Aktif" : "Tidak Aktif"',
                    'htmlOptions'=>array('style'=>'text-align:center;'),
                ),
//                 array(
//                     'name'=>'obatalkes_nama',
//                     'type'=>'raw',
//                     'value'=>'$this->grid->getOwner()->renderPartial(\''.$this->path_view.'_obatSupplier\',array(\'supplier_id\'=>$data->supplier_id),true)',
//                ),
		/*
                'supplier_namalain',
		'supplier_kabupaten',
		'supplier_fax',
		'supplier_kodepos',
		'supplier_npwp',
                'supplier_website',
		'supplier_email',
		
		*/
 
        ),
    )); 
?>