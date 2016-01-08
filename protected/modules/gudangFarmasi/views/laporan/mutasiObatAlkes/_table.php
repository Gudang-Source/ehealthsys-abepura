<?php 
    $table = 'ext.bootstrap.widgets.BootGroupGridView';
    $sort = true;
    if (isset($caraPrint)){
        $data = $model->searchLaporanPrint();
        $template = "{items}";
        $sort = false;
        if ($caraPrint == "EXCEL")
            $table = 'ext.bootstrap.widgets.BootExcelGridView';
    } else{
        $data = $model->searchLaporan();
         $template = "{summary}\n{items}\n{pager}";
    }
    
    $this->widget($table,array( 
    'id'=>'laporan-grid',
    'dataProvider'=>$data, 
    'template'=>$template, 
    'itemsCssClass'=>'table table-striped table-condensed',
    'mergeColumns'=>array('ruangantujuan_nama','nomutasioa'),
    'extraRowColumns'=> array('ruangantujuan_nama'),
    'columns'=>array( 
        ////'mutasioaruangan_id',
//        array(
//            'name'=>'no',
//            'value'=>'$this->grid->dataProvider->pagination->currentPage * $this->grid->dataProvider->pagination->pageSize + ($row+1)',
//            'header'=>'No.',
//            'filter'=>false,
//        ),
        //'pesanobatalkes.nopemesanan',
        array(
            'header'=>'<center>Ruangan Tujuan</center>',
            'name'=>'ruangantujuan_nama',
            'type'=>'raw',
            'htmlOptions'=>array('style'=>'text-align:left;'),
            'value'=>'$data->ruangantujuan_nama',
        ),
        'nomutasioa',
        array(
            'name'=>'tglmutasioa',
            'type'=>'raw',
            'value'=>'date("d/m/Y H:i:s", strtotime($data->tglmutasioa))',
        ),
        array(
            'header'=>'<center>Obat Alkes</center>',
            'name'=>'obatalkes',
            'type'=>'raw',
            'value'=>'$data->obatalkes_nama',
        ),
        array(
            'header'=>'HPP/ Satuan',
            'type'=>'raw',
            'value'=>'"Rp. ".number_format($data->harganettosatuan,0,",",".")',
        ),
        array(
            'header'=>'Harga Jual/ Satuan',
            'type'=>'raw',
            'value'=>'"Rp. ".number_format($data->hargajualsatuan,0,",",".")',
        ),
        array(
            'header'=>'Jumlah',
            'type'=>'raw',
            'value'=>'$data->jummutasi',
        ),
        array(
            'header'=>'Total',
            'type'=>'raw',
            'value'=>'"Rp. ".number_format($data->totalharga,0,",",".")',
        ),
//        array(
//            'header'=>'Total HPP',
//            'type'=>'raw',
//            'value'=>'"Rp. ".number_format($data->totalharganettomutasi)',
//        ),
//         array(
//          'header'=>'Total Harga Jual',
//          'type'=>'raw',
//          'value'=>'"Rp. ".number_format($data->totalhargajual)', 
//        ),
//        'totalhargajual',
        //'nomutasioa',
        /*
        'ruangantujuan_id',
        'keteranganmutasi',
        'totalharganettomutasi',
        'totalhargajual',
        'create_time',
        'update_time',
        'create_loginpemakai_id',
        'update_loginpemakai_id',
        'create_ruangan',
        */
        array(
            'header' => 'Status Terima',
            'type' => 'raw',
            'value'=>'(empty($data->terimamutasi_id))? "Belum Diterima" : "Telah Diterima"',
        ),
    ), 
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}', 
)); ?> 