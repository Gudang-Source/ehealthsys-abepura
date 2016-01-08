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
        'mergeHeaders'=>array(
            array(
                'name'=>'<center>Tarif</center>',
                'start'=>7, //indeks kolom 3
                'end'=>12, //indeks kolom 4
            ),
        ),
        'itemsCssClass'=>'table table-striped table-condensed',
        'columns'=>array(
                array(
                    'header' => 'No.',
                    'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:center;'),
                    'value' => $row,
                ),
                array(
                    'header'=>'No. Rekam Medik',
                    'name'=>'no_rekam_medik',
                    'headerHtmlOptions'=>array('style'=>'vertical-align:middle;'),
                ),
                array(
                    'header'=>'Nama Pasien / Alias',
                    'value'=>'$data->NamaNamaBIN',
                    'headerHtmlOptions'=>array('style'=>'vertical-align:middle;'),
                ),
                array(
                    'header'=>'No. Pendaftaran',
                    'name'=>'no_pendaftaran',
                    'headerHtmlOptions'=>array('style'=>'vertical-align:middle;'),
                ),
                array(
                    'header'=>'Nama Pegawai',
                    'name'=>'nama_pegawai',
                    'headerHtmlOptions'=>array('style'=>'vertical-align:middle;'),
                ),
                array(
                    'header'=>'Cara Bayar / Penjamin',
                    'name'=>'carabayarPenjamin',
                    'headerHtmlOptions'=>array('style'=>'vertical-align:middle;'),
                ),
                array(
                    'header'=>'Kelas Pelayanan',
                    'name'=>'kelaspelayanan_nama',
                    'headerHtmlOptions'=>array('style'=>'vertical-align:middle;'),
                ),
                array(
                    'header'=>'Satuan',
                    'name'=>'tarif_satuan',
                    'value'=>'$data->tarif_satuan',
                    'htmlOptions'=>array('style'=>'text-align:right;'),
                    'headerHtmlOptions'=>array('style'=>'vertical-align:middle;'),
                ),
                array(
                    'header'=>'Cyto Tindakan',
                    'name'=>'tarifcyto_tindakan',
                    'value'=>'$data->tarifcyto_tindakan',
                    'htmlOptions'=>array('style'=>'text-align:right;'),
                    'headerHtmlOptions'=>array('style'=>'vertical-align:middle;'),
                ),
                array(
                    'header'=>'RS. Akomodasi',
                    'name'=>'tarif_rsakomodasi',
                    'value'=>'$data->tarif_rsakomodasi',
                    'htmlOptions'=>array('style'=>'text-align:right;'),
                    'headerHtmlOptions'=>array('style'=>'vertical-align:middle;'),
                ),
                array(
                    'header'=>'Medis',
                    'name'=>'tarif_medis',
                    'value'=>'$data->tarif_medis',
                    'htmlOptions'=>array('style'=>'text-align:right;'),
                    'headerHtmlOptions'=>array('style'=>'vertical-align:middle;'),
                ),
                array(
                    'header'=>'Paramedis',
                    'name'=>'tarif_paramedis',
                    'value'=>'$data->tarif_paramedis',
                    'htmlOptions'=>array('style'=>'text-align:right;'),
                    'headerHtmlOptions'=>array('style'=>'vertical-align:middle;'),
                ),
                array(
                    'header'=>'BHP',
                    'name'=>'tarif_bhp',
                    'value'=>'$data->tarif_bhp',
                    'htmlOptions'=>array('style'=>'text-align:right;'),
                    'headerHtmlOptions'=>array('style'=>'vertical-align:middle;'),
                ),
                array(
                    'header'=>'Total',
                    'value'=>'$data->totalTarif',
                    'htmlOptions'=>array('style'=>'text-align:right;'),
                    'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:center;'),
                ),
        ),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
    ));
}else{
    $this->widget($table,array(
        'id'=>'tableLaporan',
        'dataProvider'=>$data,
        'template'=>$template,
        'enableSorting'=>$sort,
        'mergeHeaders'=>array(
            array(
                'name'=>'<center>Tarif</center>',
                'start'=>7, //indeks kolom 3
                'end'=>12, //indeks kolom 4
            ),
        ),
        'itemsCssClass'=>'table table-striped table-condensed',
        'columns'=>array(
                array(
                    'header' => 'No.',
                    'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:center;'),
                    'value' => $row,
                ),
                array(
                    'header'=>'No. Rekam Medik',
                    'name'=>'no_rekam_medik',
                    'headerHtmlOptions'=>array('style'=>'vertical-align:middle;'),
                ),
                array(
                    'header'=>'Nama Pasien / Alias',
                    'value'=>'$data->NamaNamaBIN',
                    'headerHtmlOptions'=>array('style'=>'vertical-align:middle;'),
                ),
                array(
                    'header'=>'No. Pendaftaran',
                    'name'=>'no_pendaftaran',
                    'headerHtmlOptions'=>array('style'=>'vertical-align:middle;'),
                ),
                array(
                    'header'=>'Nama Pegawai',
                    'name'=>'nama_pegawai',
                    'headerHtmlOptions'=>array('style'=>'vertical-align:middle;'),
                ),
                array(
                    'header'=>'Cara Bayar / Penjamin',
                    'name'=>'carabayarPenjamin',
                    'headerHtmlOptions'=>array('style'=>'vertical-align:middle;'),
                ),
                array(
                    'header'=>'Kelas Pelayanan',
                    'name'=>'kelaspelayanan_nama',
                    'headerHtmlOptions'=>array('style'=>'vertical-align:middle;'),
                ),
                array(
                    'header'=>'Satuan',
                    'name'=>'tarif_satuan',
                    'value'=>'number_format($data->tarif_satuan,0,",",".")',
                    'htmlOptions'=>array('style'=>'text-align:right;'),
                    'headerHtmlOptions'=>array('style'=>'vertical-align:middle;'),
                ),
                array(
                    'header'=>'Cyto Tindakan',
                    'name'=>'tarifcyto_tindakan',
                    'value'=>'number_format($data->tarifcyto_tindakan,0,",",".")',
                    'htmlOptions'=>array('style'=>'text-align:right;'),
                    'headerHtmlOptions'=>array('style'=>'vertical-align:middle;'),
                ),
                array(
                    'header'=>'RS. Akomodasi',
                    'name'=>'tarif_rsakomodasi',
                    'value'=>'number_format($data->tarif_rsakomodasi,0,",",".")',
                    'htmlOptions'=>array('style'=>'text-align:right;'),
                    'headerHtmlOptions'=>array('style'=>'vertical-align:middle;'),
                ),
                array(
                    'header'=>'Medis',
                    'name'=>'tarif_medis',
                    'value'=>'number_format($data->tarif_medis,0,",",".")',
                    'htmlOptions'=>array('style'=>'text-align:right;'),
                    'headerHtmlOptions'=>array('style'=>'vertical-align:middle;'),
                ),
                array(
                    'header'=>'Paramedis',
                    'name'=>'tarif_paramedis',
                    'value'=>'number_format($data->tarif_paramedis,0,",",".")',
                    'htmlOptions'=>array('style'=>'text-align:right;'),
                    'headerHtmlOptions'=>array('style'=>'vertical-align:middle;'),
                ),
                array(
                    'header'=>'BHP',
                    'name'=>'tarif_bhp',
                    'value'=>'number_format($data->tarif_bhp,0,",",".")',
                    'htmlOptions'=>array('style'=>'text-align:right;'),
                    'headerHtmlOptions'=>array('style'=>'vertical-align:middle;'),
                ),
                array(
                    'header'=>'Total',
                    'value'=>'number_format($data->totalTarif,0,",",".")',
                    'htmlOptions'=>array('style'=>'text-align:right;'),
                    'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:center;'),
                ),
        ),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
    )); 
}
?>