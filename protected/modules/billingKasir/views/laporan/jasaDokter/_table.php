<?php 
//    $table = 'ext.bootstrap.widgets.BootGroupGridView';
    $table = 'ext.bootstrap.widgets.BootExcelGridView';
    $sort = true;
    if (isset($caraPrint)){
        $data = $model->searchLaporan();
        $template = "{items}";
        $sort = false;
//        if ($caraPrint == "EXCEL")
            $table = 'ext.bootstrap.widgets.BootExcelGridView';
        echo "<style>
                .tableRincian thead, th{
                    border: 1px #000 solid;
                }
                .tableRincian{
                    width:100%;
                }
            </style>";
        $itemsCssClass = 'tableRincian';
    } else{
        $data = $model->searchLaporan();
         $template = "{summary}\n{items}\n{pager}";
         $itemsCssClass = 'table table-striped table-bordered table-condensed';
    }
    
    $this->widget($table,array( 
    'id'=>'laporan-grid',
    'dataProvider'=>$data, 
    'template'=>$template, 
    'itemsCssClass'=>$itemsCssClass,
    'mergeColumns'=>array('nama_pegawai'),
//    'extraRowColumns'=> array('nama_pegawai'),
    'columns'=>array( 
        array(
            'header' => 'No.',
            'value' => '$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1'
        ),
        array(
            'header'=>'<center>Nama Perujuk /Dokter</center>',
            'name'=>'nama_pegawai',
            'type'=>'raw',
            'htmlOptions'=>array('class'=>'ruangantujuan','style'=>'text-align:center;'),
            'value'=>'empty($data->nama_pegawai) ? $data->namaperujuk."<br> (Rujukan Luar)" : $data->gelardepan." ".$data->nama_pegawai." ".$data->gelarbelakang_nama."<br>"',
            'footerHtmlOptions'=>array('colspan'=>5,'style'=>'text-align:right;font-weight:bold;'),
            'footer'=>'Jumlah Total',
        ),
        array(
            'header'=>'<center>Tanggal Bayar Jasa</center>',
            'type'=>'raw',
            'htmlOptions'=>array('style'=>'text-align:center;'),
            'value'=>'date("d/m/Y",strtotime($data->tglbayarjasa))',
        ),
        array(
            'header'=>'<center>No. Bayar Jasa</center>',
            'type'=>'raw',
            'htmlOptions'=>array('style'=>'text-align:center;'),
            'value'=>'$data->nobayarjasa',
        ),
        array(
            'header'=>'<center>No. Kas Keluar</center>',
            'type'=>'raw',
            'htmlOptions'=>array('style'=>'text-align:center;'),
            'value'=>'$data->nokaskeluar',
        ),
        array(
            'name'=>'totaltarif',
            'header'=>'<center>Total Tarif</center>',
            'type'=>'raw',
            'value'=>'number_format($data->totaltarif,0,"",".")',
            'htmlOptions'=>array('style'=>'text-align:right;'),
            'footerHtmlOptions'=>array('style'=>'text-align:right;font-weight:bold;','class'=>'integer'),
            'footer'=>'sum(totaltarif)',
        ),
        array(
            'name'=>'totaljasa',
            'header'=>'<center>Total Jasa</center>',
            'value'=>'number_format($data->totaljasa,0,"",".")',
            'htmlOptions'=>array('style'=>'text-align:right;'),
            'footerHtmlOptions'=>array('style'=>'text-align:right;font-weight:bold;','class'=>'integer'),
            'footer'=>'sum(totaljasa)',
        ),
        array(
            'name'=>'totalbayarjasa',
            'header'=>'<center>Total Bayar Jasa</center>',
            'value'=>'number_format($data->totalbayarjasa,0,"",".")',
            'htmlOptions'=>array('style'=>'text-align:right;'),
            'footerHtmlOptions'=>array('style'=>'text-align:right;font-weight:bold;','class'=>'integer'),
            'footer'=>'sum(totalbayarjasa)',
        ),
        array(
            'name'=>'totalsisajasa',
            'header'=>'<center>Total Sisa Jasa</center>',
            'value'=>'number_format($data->totalsisajasa,0,"",".")',
            'htmlOptions'=>array('style'=>'text-align:right;'),
            'footerHtmlOptions'=>array('style'=>'text-align:right;font-weight:bold;','class'=>'integer'),
            'footer'=>'sum(totalsisajasa)',
        ),
    ), 
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}', 
)); ?> 
<script>
    $('.integer').each(function(){
       formatNumber(); 
    });
</script>