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
                'header'=>'Tgl Pengajuan/ <br/> No Pengajuan',
                'type'=>'raw',
                'value'=>'MyFormatter::formatDateTimeForUser(date("d/m/Y", strtotime($data->tglpengajuanpemb)))."/ <br/>".$data->nopengajuan',
                'htmlOptions'=>array('nowrap'=>true),
                //'headerHtmlOptions'=>array('style'=>'color:#373E4A;width:120px;'),					
                'footer'=>'<b>GRAND TOTAL</b>',
                'footerHtmlOptions'=>array('style'=>'text-align:right;','colspan'=>'2'),
        ),
        array(
                'header'=>'Tgl Bukti Bayar / <br/> No BKM',
                'type'=>'raw',
                'value'=>'MyFormatter::formatDateTimeForUser(date("d/m/Y", strtotime($data->tglbuktibayar)))." /<br/>".$data->nobuktimasuk',
                'htmlOptions'=>array('nowrap'=>true),
                //'headerHtmlOptions'=>array('style'=>'color:#373E4A'),
        ),
        array(
                'header'=>'Simpanan Wajib',
                'value'=>'MyFormatter::formatNumberForPrint($data->potongan_simpananwajib)',
                'htmlOptions'=>array('style'=>'text-align:right;'),
               // 'headerHtmlOptions'=>array('style'=>'color:#373E4A'),	
                'footer'=>MyFormatter::formatNumberForPrint($model->getTotSW($provider)),
                'footerHtmlOptions'=>array('style'=>'text-align:right;'),
        ),
        array(
                'header'=>'Simpanan Sukarela',
                'value'=>'MyFormatter::formatNumberForPrint($data->potongan_simpanansukarela)',
                'htmlOptions'=>array('style'=>'text-align:right;'),
             //   'headerHtmlOptions'=>array('style'=>'color:#373E4A'),
                'footer'=>MyFormatter::formatNumberForPrint($model->getTotSS($provider)),
                'footerHtmlOptions'=>array('style'=>'text-align:right;'),	
        ),
        array(
                'header'=>'Pokok Angsuran',
                'value'=>'MyFormatter::formatNumberForPrint($data->potongan_pokokangsuran)',
                'htmlOptions'=>array('style'=>'text-align:right;'),
              //  'headerHtmlOptions'=>array('style'=>'color:#373E4A'),	
                'footer'=>MyFormatter::formatNumberForPrint($model->getTotPK($provider)),
                'footerHtmlOptions'=>array('style'=>'text-align:right;'),
        ),
        array(
                'header'=>'Jasa Angsuran',
                'value'=>'MyFormatter::formatNumberForPrint($data->potongan_jasaangsuran)',
                'htmlOptions'=>array('style'=>'text-align:right;'),
               // 'headerHtmlOptions'=>array('style'=>'color:#373E4A'),	
                'footer'=>MyFormatter::formatNumberForPrint($model->getTotJA($provider)),
                'footerHtmlOptions'=>array('style'=>'text-align:right;'),
        ),
        array(
                'header'=>'Denda Angsuran',
                'value'=>'MyFormatter::formatNumberForPrint($data->potongan_dendaangsuran)',
                'htmlOptions'=>array('style'=>'text-align:right;'),
              //  'headerHtmlOptions'=>array('style'=>'color:#373E4A'),
                'footer'=>MyFormatter::formatNumberForPrint($model->getTotDA($provider)),
                'footerHtmlOptions'=>array('style'=>'text-align:right;'),	
        ),
        array(
                'header'=>'Total Pengajuan',
                'value'=>'MyFormatter::formatNumberForPrint($data->potongan_totalpengajuan)',
                'htmlOptions'=>array('style'=>'text-align:right;'),
               // 'headerHtmlOptions'=>array('style'=>'color:#373E4A'),
                'footer'=>MyFormatter::formatNumberForPrint($model->getTotPengajuan($provider)),
                'footerHtmlOptions'=>array('style'=>'text-align:right;'),	
        ),
        array(
                'header'=>'Total Penerimaan',
                'value'=>'MyFormatter::formatNumberForPrint($data->jmlpembayaran)',
                'htmlOptions'=>array('style'=>'text-align:right;'),
                //'headerHtmlOptions'=>array('style'=>'color:#373E4A'),
                'footer'=>MyFormatter::formatNumberForPrint($model->getTotPenerimaan($provider)),
                'footerHtmlOptions'=>array('style'=>'text-align:right;'),	
        ),
        array(
                'header'=>'Sisa',
                'value'=>'MyFormatter::formatNumberForPrint($data->potongan_sisaangsuran)',
                'htmlOptions'=>array('style'=>'text-align:right;'),
               // 'headerHtmlOptions'=>array('style'=>'color:#373E4A;vertical-align:top'),
                'footer'=>MyFormatter::formatNumberForPrint($model->getTotSisa($provider)),
                'footerHtmlOptions'=>array('style'=>'text-align:right;'),	
        ),
),
)); ?> 

