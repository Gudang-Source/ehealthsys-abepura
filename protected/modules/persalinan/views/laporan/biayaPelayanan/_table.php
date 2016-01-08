<?php 
    $table = 'ext.bootstrap.widgets.HeaderGroupGridView';
    $sort = true;
    $row = '$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1';
    if (isset($caraPrint)){
        $row = '$row+1';
        $data = $model->searchPrint();
        $template = "{items}";
        $sort = false;
        if ($caraPrint == "EXCEL")
            $table = 'ext.bootstrap.widgets.BootExcelGridView';
    } else{
        $data = $model->searchTable();
         $template = "{summary}\n{items}\n{pager}";
    }
?>
<?php 
if(isset($caraPrint) && $caraPrint == "EXCEL"){
    $this->widget($table,array(
	'id'=>'tableLaporan',
	'dataProvider'=>$data,
        'template'=>$template,
        'enableSorting'=>$sort,
        'itemsCssClass'=>'table table-striped table-bordered table-condensed',
	'columns'=>array(
            array(
                'header' => 'No.',
                'value' => $row,
            ),
            'no_rekam_medik',
            array(
                'header'=>'Nama Pasien / Nama Panggilan',
                'value'=>'$data->NamaNamaBIN',
            ),
            'no_pendaftaran',
            'umur',
            'jeniskelamin',
            array(
                'header'=>'Jenis Kasus Penyakit',
                'type'=>'raw',
                'value'=>'$data->jeniskasuspenyakit_nama',
            ),
//            'jeniskasuspenyakit_nama',
            array(
              'header'=>'Kelas Pelayanan',
              'type'=>'raw',
              'value'=>'$data->kelaspelayanan_nama',
            ),
//            'kelaspelayanan_nama',
            'carabayarPenjamin',
            array(
                'header'=>'Iur Biaya',
                'type'=>'raw',
                'value'=>'$data->iurbiaya',
                'htmlOptions'=>array('style'=>'text-align:right;'),
            ),
//            'iurbiaya',
            array(
                'header'=>'Total Biaya Pelayanan',
                'type'=>'raw',
                'value'=>'$data->total',
                'htmlOptions'=>array('style'=>'text-align:right;'),
            ),
//            'total',
//            'alamat_pasien',   
	),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
));
}else{
$this->widget($table,array(
	'id'=>'tableLaporan',
	'dataProvider'=>$data,
        'template'=>$template,
        'enableSorting'=>$sort,
        'itemsCssClass'=>'table table-striped table-bordered table-condensed',
	'columns'=>array(
            array(
                'header' => 'No.',
                'value' => $row,
            ),
            'no_rekam_medik',
            array(
                'header'=>'Nama Pasien / Nama Panggilan',
                'value'=>'$data->NamaNamaBIN',
            ),
            'no_pendaftaran',
            'umur',
            'jeniskelamin',
            array(
                'header'=>'Jenis Kasus Penyakit',
                'type'=>'raw',
                'value'=>'$data->jeniskasuspenyakit_nama',
            ),
//            'jeniskasuspenyakit_nama',
            array(
              'header'=>'Kelas Pelayanan',
              'type'=>'raw',
              'value'=>'$data->kelaspelayanan_nama',
            ),
//            'kelaspelayanan_nama',
            'carabayarPenjamin',
            array(
                'header'=>'Iur Biaya',
                'type'=>'raw',
                'value'=>'MyFormatter::formatNumberForPrint($data->iurbiaya)',
                'htmlOptions'=>array('style'=>'text-align:right;'),
            ),
//            'iurbiaya',
            array(
                'header'=>'Total Biaya Pelayanan',
                'type'=>'raw',
                'value'=>'MyFormatter::formatNumberForPrint($data->total)',
                'htmlOptions'=>array('style'=>'text-align:right;'),
            ),
//            'total',
//            'alamat_pasien',   
	),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
)); 
}
?>