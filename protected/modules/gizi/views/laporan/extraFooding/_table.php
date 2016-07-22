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
        'itemsCssClass'=>'table table-striped table-condensed',
	'columns'=>array(
                array(
                    'header' => 'No.',
                    'headerHtmlOptions'=>array('style'=>'text-align: center;vertical-align:middle;'),
                    'value' => '$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1'
                ),
                array(
                    'header' => 'No. RM',
                    'headerHtmlOptions'=>array('style'=>'text-align: center;vertical-align:middle;'),
                    'value' => '$data->no_rekam_medik',
                ),
                array(
                    'header' => 'Nama Lengkap',
                    'headerHtmlOptions'=>array('style'=>'text-align: center;vertical-align:middle;'),
                    'value' => '$data->nama_pasien',
                ),
                array(
                    'header' => 'No. Pendaftaran',
                    'headerHtmlOptions'=>array('style'=>'text-align: center;vertical-align:middle;'),
                    'value' => '$data->no_pendaftaran',
                ),
                array(
                    'header' => 'Jenis',
                    'headerHtmlOptions'=>array('style'=>'text-align: center;vertical-align:middle;'),
                    'value' => '$data->jenisdiet_nama'
                ),
                array(
                    'header' => 'Jenis Diet',
                    'headerHtmlOptions'=>array('style'=>'text-align: center;vertical-align:middle;'),
                    'value' => '$data->menudiet_nama'
                ),
//                array(
//                    'header' => 'No. Gizi',
//                    'headerHtmlOptions'=>array('style'=>'text-align: center;vertical-align:middle;'),
//                    'value' => '$data->no_masukpenunjang',
//                ),
                array(
                    'header' => 'Jumlah',
                    'headerHtmlOptions'=>array('style'=>'text-align: right;vertical-align:middle;'),
                    'htmlOptions'=>array('style'=>'text-align:right'),
                    'value' => 'number_format($data->jml_kirim,0,"",".")',
                    'footerHtmlOptions'=>array('colspan'=>7,'style'=>'text-align:right;font-weight:bold'),
                    'footer'=>'Total',
                ),
                array(
                    'header' => 'Harga',
                    'name'=>'hargasatuan',
                    'headerHtmlOptions'=>array('style'=>'text-align: right;vertical-align:middle;'),
                    'value' => '"Rp".number_format($data->hargasatuan,0,"",".")',
                    'footerHtmlOptions'=>array('style'=>'text-align:right;font-weight:bold'),
                    'htmlOptions'=>array('style'=>'text-align:right;'),
                    'footer'=>'sum(hargasatuan)',
                ),
                array(
                    'header' => 'Ruangan',
                    'headerHtmlOptions'=>array('style'=>'text-align: left;vertical-align:middle;'),
                    'value' => '$data->ruangan_nama',
                    'footerHtmlOptions'=>array('style'=>'text-align:right;color:white'),
                    'footer'=>'-',
                ),
                array(
                    'header' => 'Kelas',
                    'headerHtmlOptions'=>array('style'=>'text-align: left;vertical-align:middle;'),
                    'value' => '$data->kelaspelayanan_nama',
                    'footerHtmlOptions'=>array('style'=>'text-align:right;color:white'),
                    'footer'=>'-',
                ),
                array(
                    'header' => 'Tanggal Transaksi',
                    'headerHtmlOptions'=>array('style'=>'text-align: left;vertical-align:middle;'),
                    'value' => 'date("d/m/Y H:i:s",strtotime($data->tglkirimmenu))',
                    'footerHtmlOptions'=>array('style'=>'text-align:right;color:white'),
                    'footer'=>'-',
                ),
                array(
                    'header' => 'Tanggal Pemberian',
                    'headerHtmlOptions'=>array('style'=>'text-align: left;vertical-align:middle;'),
                    'value' => 'date("d/m/Y H:i:s",strtotime($data->tglkirimmenu))',
                    'footerHtmlOptions'=>array('style'=>'text-align:right;color:white'),
                    'footer'=>'-',
                ),
                array(
                    'header' => 'Jam Pemberian',
                    'headerHtmlOptions'=>array('style'=>'text-align: left;vertical-align:middle;'),
                    'htmlOptions'=>array('style'=>'text-align:left;'),
                    'value' => '$data->jeniswaktu_jam',
                    'footerHtmlOptions'=>array('style'=>'text-align:right;color:white'),
                    'footer'=>'-',
                ),
//                array(
//                    'header' => 'Hari',
//                    'headerHtmlOptions'=>array('style'=>'text-align: center;vertical-align:middle;'),
//                    'value' => 'date("l,strtotime($data->tglkirimmenu")',
//                ),
                array(
                    'header' => 'Waktu',
                    'headerHtmlOptions'=>array('style'=>'text-align: left;vertical-align:middle;'),
                    'htmlOptions'=>array('style'=>'text-align:left;'),
                    'value' => '$data->jeniswaktu_nama',
                    'footerHtmlOptions'=>array('style'=>'text-align:right;color:white'),
                    'footer'=>'-',
                ),
	),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
)); ?>