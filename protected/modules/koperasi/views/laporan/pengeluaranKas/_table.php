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
                'header' => 'Tanggal Kas Keluar',
                'name'=>'tgl_bkk',
                'value'=>'MyFormatter::formatDateTimeForUser(date("d/m/Y",strtotime($data->tgl_bkk)))',
                ),
        array(
                'header' => 'No BKK',
                'name'=>'no_bkk',
                ),
        array(
                'header' => 'Jenis Transaksi',
                'name'=>'namatransaksi',
                ),
        array(
                'header' => 'Nama Penerima',
                'name'=>'namapenerima',
                ),
        array(
                'header' => 'Alamat Penerima',
                'name'=>'alamatpenerima',
                ),
        array(
                'header' => 'Untuk Pengeluaran',
                'name'=>'untuk_pengeluaran',
                'footer'=>'<b>GRAND TOTAL</b>',
                'footerHtmlOptions'=>array('style'=>'text-align:right;','colspan'=>'6'),
        ),
        array(
                'header' => 'Biaya Administrasi',
                'name'=>'biayaadministrasi',
                'value'=>'MyFormatter::formatNumberForPrint($data->biayaadministrasi)',
                'htmlOptions'=>array('style'=>'text-align:right'),
                'footer'=>MyFormatter::formatNumberForPrint($model->getTotBA($provider)),
                'footerHtmlOptions'=>array('style'=>'text-align:right;'),
                ),
        array(
                'header' => 'Biaya Materai',
                'name'=>'biayaamaterai',
                'value'=>'MyFormatter::formatNumberForPrint($data->biayaamaterai)',
                'htmlOptions'=>array('style'=>'text-align:right'),
                'footer'=>MyFormatter::formatNumberForPrint($model->getTotBM($provider)),
                'footerHtmlOptions'=>array('style'=>'text-align:right;'),
                ),
        array(
                'header' => 'Jumlah Kas Keluar',
                'name'=>'jmlkaskeluar',
                'value'=>'MyFormatter::formatNumberForPrint($data->jmlkaskeluar)',
                'htmlOptions'=>array('style'=>'text-align:right'),
                'footer'=>MyFormatter::formatNumberForPrint($model->getTotJKM($provider)),
                'footerHtmlOptions'=>array('style'=>'text-align:right;'),
                ),
        ),
)); ?> 

