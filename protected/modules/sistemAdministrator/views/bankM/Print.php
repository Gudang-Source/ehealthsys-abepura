
<?php 
$table = 'ext.bootstrap.widgets.BootGridView';
$template = "{summary}\n{items}\n{pager}";
$rows = '$this->grid->dataProvider->Pagination->CurrentPage*$this->grid->dataProvider->pagination->pageSize+$row+1';
if (isset($caraPrint)){
	$rows = '$row+1';
    $template = "{items}";
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
	'id'=>'sajenis-kelas-m-grid',
	'enableSorting'=>false,
	'dataProvider'=>$model->searchPrint(),
	'template'=>$template,
	'itemsCssClass'=>'table table-striped table-bordered table-condensed',
	'columns'=>array(
		array(
			'header'=>'No',
			'value'=>$rows,
		),
		array(
			'header'=>'Nama Bank',
			'name'=>'namabank',
			'value'=>'isset($data->bank->namabank) ? $data->bank->namabank : "-"',
		),
		array(
			'header'=>'No. Rekening',
			'name'=>'norekening',
			'value'=>'isset($data->bank->norekening) ? $data->bank->norekening : "-"',
		),
		array(
			'header'=>'Mata Uang',
			'name'=>'matauang_id',
			'value'=>'isset($data->bank->matauang->matauang) ? $data->bank->matauang->matauang : "-"',
		),
		array(
			'header'=>'Propinsi',
			'name'=>'propinsi_id',
			'value'=>'isset($data->bank->propinsi->propinsi_nama) ? $data->bank->propinsi->propinsi_nama : "-"',
		),
		array(
			'header'=>'Kabupaten',
			'name'=>'kabupaten_id',
			'value'=>'isset($data->bank->kabupaten->kabupaten_nama) ? $data->bank->kabupaten->kabupaten_nama : "-"',
		),
		array(
			'header'=>'Alamat Bank',
			'name'=>'alamatbank',
			'value'=>'isset($data->alamatbank) ? $data->alamatbank : "-"',
		),
		array(
			'header'=>'Telp Bank 1 / 2',
			'name'=>'telpbank1',
			'value'=>'isset($data->bank->telpbank1) ? $data->bank->telpbank1 : "-"." / ". isset($data->bank->telpbank2) ? $data->bank->telpbank2 : "-"',
		),
		array(
			'header'=>'Fax Bank / <br/> Kode Pos',
			'name'=>'faxbank',
			'value'=>'isset($data->bank->faxbank) ? $data->bank->faxbank : "-" ." / ". isset($data->bank->kodepos) ? $data->bank->kodepos : "-"',
		),
		array(
			'header'=>'Email / <br/> Website',
			'name'=>'emailbank',
			'value'=>'isset($data->bank->emailbank) ? $data->bank->emailbank : "-" ." / ". isset($data->bank->website) ? $data->bank->website : "-"',
		),
		array(
			'header'=>'Cabang dari / <br/> Negara',
			'name'=>'cabangdari',
				'value'=>'isset($data->bank->cabangdari) ? $data->bank->cabangdari : "-" ." / ".isset($data->bank->negara) ? $data->bank->negara : "-"',
		),
		array(
			'header'=>'Rekening Debit',
			'type'=>'raw',
			'value'=>'$this->grid->owner->renderPartial("sistemAdministrator.views.bankM/_rekBankD",array("saldonormal"=>"D","bank_id"=>$data->bank_id),true)',
		),
		array(
			'header'=>'Rekening Kredit',
			'type'=>'raw',
			'value'=>'$this->grid->owner->renderPartial("sistemAdministrator.views.bankM/_rekBankK",array("saldonormal"=>"K","bank_id"=>$data->bank_id),true)',
		),
		array(
			'header'=>'Aktif',
			'value'=>'($data->bank->bank_aktif == 1) ? "Aktif" : "Tidak Aktif" ',
		),
	),
    )); 
?>