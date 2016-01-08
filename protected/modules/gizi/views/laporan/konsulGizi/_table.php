<?php 
    $table = 'ext.bootstrap.widgets.MergeHeaderGroupGridView';
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
                    'htmlOptions'=>array('style'=>'text-align:center;'),
                    'value' => '$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1'
                ),
                array(
                    'header'=>'No. Rekam Medik',
                    'value'=> '$data->no_rekam_medik',
                    'headerHtmlOptions'=>array('style'=>'vertical-align:middle;'),
                ),
                array(
                    'header'=>'Nama Pasien',
                    'value'=> '$data->nama_pasien',
                    'headerHtmlOptions'=>array('style'=>'vertical-align:middle;'),
                ),
                array(
                    'header'=>'No. Pendaftaran',
                    'value'=> '$data->no_pendaftaran',
                    'headerHtmlOptions'=>array('style'=>'vertical-align:middle;'),
                ),
                array(
                    'header'=>'No. Gizi',
                    'value'=> '$data->no_masukpenunjang',
                    'headerHtmlOptions'=>array('style'=>'vertical-align:middle;'),
                ),
                array(
                    'header'=>'Jenis Diet',
                    'value'=> '$data->jenisdiet_nama',
                    'headerHtmlOptions'=>array('style'=>'vertical-align:middle;'),
                ),
                array(
                    'header'=>'Jumlah',
                    'value'=> '$data->qty_tindakan',
                    'headerHtmlOptions'=>array('style'=>'vertical-align:middle;'),
                ),
                array(
                    'header'=>'Harga',
                    'value'=> '$data->tarif_tindakan',
                    'headerHtmlOptions'=>array('style'=>'vertical-align:middle;'),
                ),
                array(
                    'header'=>'Ruangan',
                    'value'=> '$data->ruanganasal_nama',
                    'headerHtmlOptions'=>array('style'=>'vertical-align:middle;'),
                ),
                array(
                    'header'=>'Kelas Pelayanan',
                    'value'=> '$data->kelaspelayanan_nama',
                    'headerHtmlOptions'=>array('style'=>'vertical-align:middle;'),
                ),
                array(
                    'header'=>'Tanggal Transaksi',
                    'type'=>'raw',
//                    'value'=> '$data->tglmasukpenunjang',
                    'value'=> 'date("d M Y", strtotime($data->tglmasukpenunjang))',
                    'headerHtmlOptions'=>array('style'=>'vertical-align:middle;'),
                ),
	),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
)); ?>