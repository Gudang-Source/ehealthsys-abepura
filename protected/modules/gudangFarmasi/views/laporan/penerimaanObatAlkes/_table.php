<?php 
    $table = 'ext.bootstrap.widgets.BootGroupGridView';
    $data = $model->searchLaporanPenerimaanObatAlkes();
    $sort = true;
    $header_noterima = '<div style="cursor:pointer;" onclick="printByPenerimaan(\'PRINT\')" title="Print Group Berdasarkan Penerimaan"> No. Penerimaan <icon class="icon-print"></icon></div>';
    $header_obatalkes = '<div style="cursor:pointer;" onclick="printByObat(\'PRINT\')" title="Print Group Berdasarkan Obat"> Obat Alkes <icon class="icon-print"></icon></div>';
    if (isset($caraPrint)){
        $header_noterima = "No. Penerimaan";
        $header_obatalkes = "Obat Alkes";
        $template = "{items}";
        $sort = false;
        if ($caraPrint == "EXCEL")
            $table = 'ext.bootstrap.widgets.BootExcelGridView';
    } else{
         $template = "{summary}\n{items}\n{pager}";
    }
?>
<?php $this->widget($table,array(
	'id'=>'laporan-grid',
        'dataProvider'=>$data,
        'template'=>$template,
        'itemsCssClass'=>'table table-striped table-bordered table-condensed',
        'mergeColumns'=>array('supplier_id', 'noterima'),
        'extraRowColumns'=> array('supplier_id'),
	'columns'=>array(
//                array(
//                    'value'=>'$data->no',
//                    'header'=>'No.',
//                    'filter'=>false,
//                ),	                            
                array(
                    'header'=>'Nama Supplier',
                    'name'=>'supplier_id',
                    'type'=>'raw',
                    'value'=>'$data->supplier_nama',
                ),
                array(
                    'header'=>$header_noterima,
                    'name'=>'noterima',
                    'type'=>'raw',
                    'value'=>'$data->noterima',
                ),
                array(
                    'header'=>'Tanggal Penerimaan',
                    'name'=>'tglterima',
                    'type'=>'raw',
                    'value'=>'date("d/m/Y H:i:s", strtotime($data->tglterima))'
                ),
                array(
                    'header'=>'No. Faktur',
                    'name'=>'nofaktur',
                    'type'=>'raw',
                    'value'=>'empty($data->nofaktur) ? "-" : $data->nofaktur'
                ),
                array(
                    'header'=>'Tanggal Faktur',
                    'name'=>'tglfaktur',
                    'type'=>'raw',
                    'value'=>'empty($data->tglfaktur) ? "-" : date("d/m/Y H:i:s", strtotime($data->tglfaktur))'
                ),
                array(
                    'header'=>'Kode',
                    'type'=>'raw',
                    'value'=>'$data->obatalkes_kode',
                ),
                array(
                    'header'=>$header_obatalkes,
                    'type'=>'raw',
                    'value'=>'$data->nama_obat',
                ),
                array(
                    'header'=>'Harga Satuan(Rp)',
                    'type'=>'raw',
                    'value'=>'number_format($data->harganettoper)',                    
                    'htmlOptions'=>array('style'=>'text-align:right'),
                ),
                array(
                    'header'=>'Jumlah',
                    'name'=>'jumlahterima',
                    'type'=>'raw',
                    'value'=>'$data->jumlahterima',                    
                    'htmlOptions'=>array('style'=>'text-align:right'),
                ),
                array(
                    'header'=>'Satuan Besar',
                    'name'=>'satuanbesar_nama',
                    'type'=>'raw',
                    'value'=>'$data->satuanbesar_nama'
                ),
                array(
                    'header'=>'Bruto(Rp)',
                    'type'=>'raw',
                    'value'=>'number_format($data->harganettoper*$data->jumlahterima)',                    
                    'htmlOptions'=>array('style'=>'text-align:right'),
                ),  
                array(
                    'header'=>'Diskon(Rp)',
                    'type'=>'raw',
                    'value'=>'number_format($data->hargadiskon)',                    
                    'htmlOptions'=>array('style'=>'text-align:right'),
                ),  
                array(
                    'header'=>'Ppn(Rp)',
                    'type'=>'raw',
                    'value'=>'number_format($data->hargappn)',
                    'htmlOptions'=>array('style'=>'text-align:right'),
                ),  
                array(
                    'header'=>'Total(Rp)',
                    'type'=>'raw',
                    'name'=>'total',
                    'value'=>'number_format(($data->harganettoper*$data->jumlahterima)-$data->hargadiskon-$data->hargappn)',
                    'htmlOptions'=>array('style'=>'text-align:right'),
                ),  
            
	),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
)); ?>
<?php 
$urlPrintDetail = $this->createUrl('laporan/PrintLaporanPenerimaanObatAlkesDetail');
$urlPrintByObat = $this->createUrl('laporan/PrintLaporanPenerimaanObatAlkesByObat');
$urlPrintByPenerimaan = $this->createUrl('laporan/PrintLaporanPenerimaanObatAlkesByPenerimaan');
?>
<script>
    function printDetail(caraPrint){
        window.open("<?php echo $urlPrintDetail; ?>/"+$('#search-laporan').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=1024px, scrollbars=yes');
    }
    function printByObat(caraPrint){
        window.open("<?php echo $urlPrintByObat; ?>/"+$('#search-laporan').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=1024px, scrollbars=yes');
    }
    function printByPenerimaan(caraPrint){
        window.open("<?php echo $urlPrintByPenerimaan; ?>/"+$('#search-laporan').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=1024px, scrollbars=yes');
    }
</script>