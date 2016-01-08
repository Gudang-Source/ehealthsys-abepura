
<?php 
if($caraPrint=='EXCEL')
{
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="'.$judulLaporan.'-'.date("Y/m/d").'.xls"');
    header('Cache-Control: max-age=0');     
}
echo $this->renderPartial('application.views.headerReport.headerDefault',array('judulLaporan'=>$judulLaporan, 'colspan'=>10));      

 $table = 'ext.bootstrap.widgets.BootGroupGridView';
    $sort = true;
    if (isset($caraPrint)){
        $data = $model->searchTabelPrint();
        $template = "{items}";
        $sort = false;
        if ($caraPrint == "EXCEL")
            $table = 'ext.bootstrap.widgets.BootExcelGridView';
    } else{
        $data = $model->searchTabel();
         $template = "{summary}\n{items}\n{pager}";
    }
    
$this->widget($table,array(
	'id'=>'rjkasuspenyakitruangan-m-grid',
	'dataProvider'=>$data,
	'template'=>$template,
	'mergeColumns'=>'ruangan.ruangan_nama',
	'itemsCssClass'=>'table table-striped table-bordered table-condensed',
	'columns'=>array(
			array(
				'name'=>'ruangan.ruangan_nama',
				'header'=>'Nama Ruangan',
				'value'=>'$data->ruangan->ruangan_nama',
			),
			array(
				'header'=>'Jenis Kasus Penyakit',
				'value'=>'$data->jeniskasuspenyakit->jeniskasuspenyakit_nama',
				'htmlOptions'=>array(
					'style'=>'border-left:solid 1px #DDDDDD',
				),
			),
			array(
				'header'=>'Nama Lain Kasus',
				'value'=>'$data->jeniskasuspenyakit->jeniskasuspenyakit_namalainnya',
			),
        ),
    )); 
?>