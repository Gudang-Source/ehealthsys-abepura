<?php 
    $table = 'ext.bootstrap.widgets.BootGroupGridView';
    $sort = true;
    if (isset($caraPrint)){
        $data = $model->searchLaporanMutasiIntern();
        $template = "{items}";
        $sort = false;
        if ($caraPrint == "EXCEL")
            $table = 'ext.bootstrap.widgets.BootExcelGridView';
        echo "<style>
                .tableRincian thead, th{
                    border: 1px #000 solid;
                }
            </style>";
        $itemsCssClass = 'table tableRincian';
    } else{
        $data = $model->searchLaporanMutasiIntern();
         $template = "{summary}\n{items}\n{pager}";
         $itemsCssClass = 'table table-striped table-bordered table-condensed';
    }
    
    $this->widget($table,array( 
    'id'=>'laporan-grid',
    'dataProvider'=>$data, 
    'template'=>$template, 
    'itemsCssClass'=>$itemsCssClass,
    'mergeColumns'=>array('ruangantujuan_nama','nomutasioa', 'tglmutasioa'),
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
            'htmlOptions'=>array('class'=>'ruangantujuan','style'=>'text-align:center;'),
            'value'=>'$data->ruangantujuan_nama',
        ),
         array(
            'header'=>'No. Mutasi',
            'name'=>'nomutasioa',
            'type'=>'raw',
            'value'=>'$data->nomutasioa',
        ),
         array(
            'header'=>'Tanggal Mutasi',
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
            'header'=>'Sumber Dana',
            'name'=>'sumberdana_nama',
            'type'=>'raw',
            'value'=>'$data->sumberdana_nama',
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
            'header'=>'Satuan',
            'type'=>'raw',
            'value'=>'$data->satuankecil_nama',
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
        
        array(
            'header' => 'Print',
            'type' => 'raw',
            'value'=>'CHtml::Link("<i class=\"icon-list-alt\"></i>","javascript:void(0)",
                            array("class"=>"", 
                                  "title"=>"Print Berdasarkan No. Mutasi",
                                  "onclick"=>"printDetail($data->mutasioaruangan_id, \'PRINT\');"
                            ))',
//            'cssClassExpression'=>'kolomPrint',
        ),
    ), 
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}', 
)); ?> 
<?php
$urlPrintDetail = $this->createUrl("laporan/LaporanMutasiInternDetail");
?>
<script>
    function printDetail(id,caraPrint){
        window.open("<?php echo $urlPrintDetail; ?>/"+$('#search-laporan').serialize()+"&id="+id+"&caraPrint="+caraPrint,"",'location=_new, width=980px, scrollbars=yes');
    }
</script>
<?php
//hapus kolom print saat tampilan print / frameDialog
if(isset($caraPrint)){
?>
<script>
    $('#laporan-grid tr').each(function(){
        $('#laporan-grid_c11').detach();
        $('.kolomPrint').detach();
        
    });
</script>
<?php }
?>