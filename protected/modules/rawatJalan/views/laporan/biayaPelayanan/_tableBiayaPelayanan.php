<?php 
    $table = 'ext.bootstrap.widgets.BootGridView';
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
<?php $this->widget($table,array(
	'id'=>'tableLaporan',
	'dataProvider'=>$data,
        'template'=>$template,
        'enableSorting'=>$sort,
        'itemsCssClass'=>'table table-striped table-condensed',
	'columns'=>array(
            array(
                    'header'=>'No.',
                    'value' => $row,
            ),
            'no_rekam_medik',
            array(
                'header'=>'Nama Pasien Bin',
                'value'=>'$data->NamaNamaBIN',
            ),
//            'NamaNamaBIN',
            'no_pendaftaran',
            'umur',
            'jeniskelamin',
            array(
                'header'=>'Nama Jenis Kasus Penyakit',
                'value'=>'$data->jeniskasuspenyakit_nama',
            ),
//            'jeniskasuspenyakit_nama',
            array(
                'header'=>'Nama Kelas Pelayanan',
                'value'=>'$data->kelaspelayanan_nama',
            ),
//            'kelaspelayanan_nama',
            array(
                'header'=>'Cara Bayar /<br> Penjamin',
                'type'=>'raw',
                'value'=>'$data->carabayarPenjamin',
            ),
//            'carabayarPenjamin',
            array(
                'header'=>'Iur Biaya',
                'value'=>'"Rp".number_format($data->iurbiaya,0,"",".")',
                'htmlOptions'=>array('style'=>'text-align:right;')
            ),
//            'iurbiaya',
            array(
                'header'=>'Total Biaya Pelayanan',
                'value'=>'"Rp".number_format($data->total,0,"",".")',
                'htmlOptions'=>array('style'=>'text-align:right;')
            ),
//            'total',
//            'alamat_pasien',   
	),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
)); ?>