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
<?php 
 
$provider = $model->searchTable();
$this->widget($table,array(
    'id'=>'tableLaporan',
    'dataProvider'=>$data,
//    'filter'=>$model,
        'template'=>$template,
        'enableSorting'=>$sort,
        'itemsCssClass'=>'table table-striped table-bordered table-condensed',
//    'mergeColumns' => array('instalasi_nama'),
    'columns'=>array(
        array(
            'header' =>'No',
            'value' => '$row+1'
        ),
        array(
                'header' => 'Tanggal Kas Masuk',                
                'value'=>'MyFormatter::formatDateTimeForUser(date("d/m/Y",strtotime($data->tgl_kasmasuk)))',
                ),
        array(
                'header' => 'No BKM',
                'value'=>'$data->nobuktimasuk',
                ),
        array(
                'header' => 'Jenis Transaksi',
                'value'=>'$data->namatransaksi',
                ),
        array(
                'header' => 'Diterima Dari',
                'name'=>'darinama_bkm',
                ),
        array(
                'header' => 'Alamat BKM',
                'name'=>'alamat_bkm',
                ),
        array(
                'header' => 'Sebagai Pembayaran',
                'value'=>'$data->sebagaipembayaran_bkm',
                'footer'=>'<b>GRAND TOTAL</b>',
                'footerHtmlOptions'=>array('style'=>'text-align:right;color:#373E4A','colspan'=>'6'),
        ),
        array(
                'header' => 'Jumlah Pembayaran',
                'name'=>'jmlpembayaran',
                'value'=>'MyFormatter::formatNumberForPrint($data->jmlpembayaran)',
                'htmlOptions'=>array('style'=>'text-align:right'),
                'footer'=>MyFormatter::formatNumberForPrint($model->getTotJB($provider)),
                'footerHtmlOptions'=>array('style'=>'text-align:right;color:#373E4A'),
                ),
        array(
                'header' => 'Biaya Administrasi',
                'name'=>'biayaadministrasi',
                'value'=>'MyFormatter::formatNumberForPrint($data->biayaadministrasi)',
                'htmlOptions'=>array('style'=>'text-align:right'),
                'footer'=>MyFormatter::formatNumberForPrint($model->getTotBA($provider)),
                'footerHtmlOptions'=>array('style'=>'text-align:right;color:#373E4A'),
                ),
        array(
                'header' => 'Biaya Materai',
                'name'=>'biayamaterai',
                'value'=>'MyFormatter::formatNumberForPrint($data->biayamaterai)',
                'htmlOptions'=>array('style'=>'text-align:right'),
                'footer'=>MyFormatter::formatNumberForPrint($model->getTotBM($provider)),
                'footerHtmlOptions'=>array('style'=>'text-align:right;color:#373E4A'),
                ),
        array(
                'header' => 'Jumlah Kas Masuk',
                'name'=>'uangditerima',
                'value'=>'MyFormatter::formatNumberForPrint($data->uangditerima - $data->uangkembalian)',
                'htmlOptions'=>array('style'=>'text-align:right'),
                'footer'=>MyFormatter::formatNumberForPrint($model->getTotJKM($provider)),
                'footerHtmlOptions'=>array('style'=>'text-align:right;color:#373E4A'),
                ),
        ),
//        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
)); ?> 

