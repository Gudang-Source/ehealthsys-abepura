
<?php 
$table = 'ext.bootstrap.widgets.BootGridView';
$template = "{summary}\n{items}\n{pager}";
if (isset($caraPrint)){
	$rows = '$row+1';
    $template = "{items}";
}else{
	$rows = '$this->grid->dataProvider->Pagination->CurrentPage*$this->grid->dataProvider->pagination->pageSize+$row+1';
}

if($caraPrint=='EXCEL')
{
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="'.$judulLaporan.'-'.date("Y/m/d").'.xls"');
    header('Cache-Control: max-age=0');   
    $table = 'ext.bootstrap.widgets.BootExcelGridView';
}
echo $this->renderPartial('application.views.headerReport.headerDefault',array('judulLaporan'=>$judulLaporan, 'colspan'=>''));      

$this->widget($table,array(
	'id'=>'jenispenerimaan-m-grid',
	'enableSorting'=>false,
	'dataProvider'=>$model->searchJenisPenerimaanPrint(),
	'template'=>$template,
	'itemsCssClass'=>'table table-striped table-bordered table-condensed',
	'columns'=>array(
		array(
			'header'=>'No',
			'value'=>$rows,
		),
		array(
			'header'=>'Kode',
			'value'=>'$data->jenispenerimaan->jenispenerimaan_kode',
		),
		array(
			'header'=>'Jenis Penerimaan',
			'value'=>'$data->jenispenerimaan->jenispenerimaan_nama',
		),
		array(
			'header'=>'Nama Lain',
			'value'=>'$data->jenispenerimaan->jenispenerimaan_namalain',
		),
		array(
			'header'=>'Rekening Debit',
			'type'=>'raw',
			'value'=>'$this->grid->owner->renderPartial("_rekPenerimaanD",array("saldonormal"=>"D","jenispenerimaan_id"=>$data->jenispenerimaan_id),true)',
		),
		array(
			'header'=>'Rekening Kredit',
			'type'=>'raw',
			'value'=>'$this->grid->owner->renderPartial("_rekPenerimaanK",array("saldonormal"=>"K","jenispenerimaan_id"=>$data->jenispenerimaan_id),true)',
		),
		array(
			'header'=>'Status',
			'value'=>'($data->jenispenerimaan_aktif = 1 ) ? "Aktif" : "Tidak Aktif" ',
		),
        ),
    )); 
?>