<?php 
    $table = 'ext.bootstrap.widgets.BootGridView';
    $sort = true;
    if (isset($caraPrint)){
        $data = $model->searchPrint();
        $template = "{items}";
        $sort = false;
        if ($caraPrint == "EXCEL")
            $table = 'ext.bootstrap.widgets.BootExcelGridView';
    } else{
        $data = $model->searchTableCaraMasuk();
         $template = "{summary}\n{items}\n{pager}";
    }
?>
<?php $this->widget($table,array(
	'id'=>'tableLaporan',
	'dataProvider'=>$data,
	'template'=>$template,
	'enableSorting'=>$sort,
	'itemsCssClass'=>'table table-striped table-condensed',
	'columns'=>array(
		'statusmasuk',
		'no_rekam_medik',
		'nama_pasien',
		'no_pendaftaran',
		'umur',
		'jeniskelamin',
		'alamat_pasien',
		array(
			'header'=>'Nama Kelas Pelayanan',
			'value'=>'$data->kelaspelayanan_nama',
		),
		array(
			'header'=>'Nama Asal Rujukan',
			'value'=>'$data->asalrujukan_nama',
		),
		array(
			'header'=>'Nama Jenis Kasus Penyakit',
			'value'=>'$data->jeniskasuspenyakit_nama',
		),
	),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
)); ?>