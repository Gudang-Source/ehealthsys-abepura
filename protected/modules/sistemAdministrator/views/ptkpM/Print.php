
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
	'id'=>'ptkp-kelas-m-grid',
    'enableSorting'=>$sort,
	'dataProvider'=>$data,
    'template'=>$template,
    'itemsCssClass'=>'table table-striped table-bordered table-condensed',
	'columns'=>array(
		array(
            'header'=>'ID',
            'value'=>'$data->ptkp_id',
        ),
		array(
                        'header' => 'Tanggal Berlaku',
                        'value' => 'MyFormatter::formatDateTimeForUser($data->tglberlaku)'
                    ),
		'jmltanggunan',
		array(
                        'header' => 'Tahun Wajib Pajak',
                        'name' => 'wajibpajak_thn',
                        'value' => '"Rp".number_format($data->wajibpajak_thn,0,"",".")',                       
                        'htmlOptions' => array('style'=>'text-align:right;')
                    ),    
                    array(
                        'header' => 'Tahun Wajib Pajak',
                        'name' => 'wajibpajak_bln',
                        'value' => '"Rp".number_format($data->wajibpajak_bln,0,"",".")',                       
                        'htmlOptions' => array('style'=>'text-align:right;')
                    ), 
        'statusperkawinan',
        array(
            'header'=>'berlaku',
            'value'=>'(($data->berlaku==1)? "Ya" : "Tidak")',
        ),
    ),
)); 
?>