<?php 
    $table = 'ext.bootstrap.widgets.HeaderGroupGridView';
    $sort = true;
    if (isset($caraPrint)){
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
        'mergeHeaders'=>array(
            array(
                'name'=>'<center>Tarif</center>',
                'start'=>7, //indeks kolom 3
                'end'=>8, //indeks kolom 4
            ),
        ),
        'itemsCssClass'=>'table table-striped table-condensed',
    'columns'=>array(
                array(
                    'header' => 'No.',
                    'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:center;'),
                    'value' => '$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1'
                ),
                array(
                    'header'=>'No. Rekam Medik / <br> Nama Pasien',
                    'type'=>'raw',
                    'value'=>'"$data->no_rekam_medik"."<br/>"."$data->nama_pasien"',
                    'headerHtmlOptions'=>array('colspan'=>1,'style'=>'vertical-align:middle;'),
                ),
//                array(
//                    'name'=>'nama_pasien',
//                    'headerHtmlOptions'=>array('style'=>'vertical-align:middle;'),
//                ),
                array(
                    'name'=>'no_pendaftaran',
                    'headerHtmlOptions'=>array('style'=>'vertical-align:middle;'),
                ),
                array(
                    'name'=>'nama_pegawai',
                    'headerHtmlOptions'=>array('style'=>'vertical-align:middle;'),
                ),
                array(
                    'header'=>'Cara Bayar /<br/> Penjamin',
                    'type'=>'raw',
                    'name'=>'carabayarPenjamin',
                    'headerHtmlOptions'=>array('style'=>'vertical-align:middle;'),
                ),
                array(
                    'header'=>'Kelas Pelayanan',
                    'type'=>'raw',
                    'value'=>'$data->kelaspelayanan_nama',
//                    'name'=>'kelaspelayanan_nama',
                    'headerHtmlOptions'=>array('style'=>'vertical-align:middle;'),
                    'footerHtmlOptions'=>array('colspan'=>6,'style'=>'text-align:right;font-style:italic;'),
                    'footer'=>'Jumlah Total',
                ),
                array(
                    'header'=>'Satuan',
                    'name'=>'tarif_satuan',
                    'value'=>'"Rp. ".number_format($data->tarif_satuan)',
                    'headerHtmlOptions'=>array('style'=>'vertical-align:middle;'),
                    'htmlOptions'=>array('style'=>'text-align:right;'),
                    'footerHtmlOptions'=>array('style'=>'text-align:right;'),
                    'footer'=>'sum(tarif_satuan)',
                ),
                array(
                    'header'=>'CytoTindakan',
                    'name'=>'tarifcyto_tindakan',
                    'value'=>'"Rp. ".number_format($data->tarifcyto_tindakan)',
                    'headerHtmlOptions'=>array('style'=>'vertical-align:middle;'),
                    'htmlOptions'=>array('style'=>'text-align:right;'),
                    'footerHtmlOptions'=>array('style'=>'text-align:right;'),
                    'footer'=>'sum(tarifcyto_tindakan)',
                ),
                array(
                      'header'=>'Biaya Operasional',
                    'name'=>'tarif_rsakomodasi',
                    'value'=>'"Rp. ".number_format($data->tarif_rsakomodasi)',
                    'headerHtmlOptions'=>array('style'=>'vertical-align:middle;'),
                    'htmlOptions'=>array('style'=>'text-align:right;'),
                    'footerHtmlOptions'=>array('style'=>'text-align:right;'),
                    'footer'=>'sum(tarif_rsakomodasi)',
                ),
                array(
                      'header'=>'Jasa Pelayanan',
                    'name'=>'tarif_medis',
                    'value'=>'"Rp. ".number_format($data->tarif_medis)',
                    'headerHtmlOptions'=>array('style'=>'vertical-align:middle;'),
                    'htmlOptions'=>array('style'=>'text-align:right;'),
                    'footerHtmlOptions'=>array('style'=>'text-align:right;'),
                    'footer'=>'sum(tarif_medis)',
                ),
//                array(
//                    'name'=>'tarif_paramedis',
//                    'value'=>'"Rp. ".number_format($data->tarif_paramedis)',
//                    'headerHtmlOptions'=>array('style'=>'vertical-align:middle;'),
//                    'htmlOptions'=>array('style'=>'text-align:right;'),
//                    'footerHtmlOptions'=>array('style'=>'text-align:right;'),
//                    'footer'=>'sum(tarif_paramedis)',
//                ),
                array(
                    'name'=>'tarif_bhp',
                    'value'=>'"Rp. ".number_format($data->tarif_bhp)',
                    'headerHtmlOptions'=>array('style'=>'vertical-align:middle;'),
                    'htmlOptions'=>array('style'=>'text-align:right;'),
                    'footerHtmlOptions'=>array('style'=>'text-align:right;'),
                    'footer'=>'sum(tarif_bhp)',
                ),
                array(
                    'header'=>'Total',
                    'name'=>'totalTarif',
                    'value'=>'"Rp. ".number_format($data->totalTarif)',
                    'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:center;'),
                    'htmlOptions'=>array('style'=>'text-align:right;'),
                    'footerHtmlOptions'=>array('style'=>'text-align:right;'),
                    'footer'=>'sum(totalTarif)',
                ),
    ),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
)); ?>