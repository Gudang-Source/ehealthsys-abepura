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
            'header'=>'Nomor Anggota',
            'type'=>'raw',
            'value'=>'$data->nokeanggotaan',
            //'headerHtmlOptions'=>array('style'=>'color:#373E4A'),
            'footer'=>'<b>GRAND TOTAL</b>',
            'footerHtmlOptions'=>array('style'=>'text-align:right;','colspan'=>'6'),
        ),
        array(
                'header'=>'Nama Anggota',
                'type'=>'raw',
                'value'=>'$data->namaLengkap',
              //  'headerHtmlOptions'=>array('style'=>'color:#373E4A'),
        ),       
        array(
                'header'=>'Tgl Pinjaman/ <br/> No Pinjaman',
                'type'=>'raw',
                'value'=>'MyFormatter::formatDateTimeForUser(date("d/m/Y", strtotime($data->tglpinjaman)))." /<br/>".
                                         $data->no_pinjaman',
                'htmlOptions'=>array('nowrap'=>true),
            //    'headerHtmlOptions'=>array('style'=>'color:#373E4A;width:120px;'),					
        ),
        array(
                'header'=>'Tgl Angsuran',
                'type'=>'raw',
                'value'=>'MyFormatter::formatDateTimeForUser(date("d/m/Y", strtotime($data->tglangsuran)))',
                'htmlOptions'=>array('nowrap'=>true),
             //   'headerHtmlOptions'=>array('style'=>'color:#373E4A'),	
        ),
        array(
                'header'=>'Angsuran Ke',
                'value'=>'$data->angsuran_ke',
                'htmlOptions'=>array('style'=>'text-align:center'),
            //    'headerHtmlOptions'=>array('style'=>'color:#373E4A'),	
                ),
        array(
                'header'=>'Pokok Angsuran',
                'value'=>'MyFormatter::formatNumberForPrint($data->jmlpokok_angsuran)',
                'htmlOptions'=>array('style'=>'text-align:right'),
              //  'headerHtmlOptions'=>array('style'=>'color:#373E4A'),
                'footer'=>MyFormatter::formatNumberForPrint($model->getTotPA($provider)),
                                'footerHtmlOptions'=>array('style'=>'text-align:right;'),	
                ),
        array(
                'header'=>'Jasa Angsuran',
                'value'=>'MyFormatter::formatNumberForPrint(empty($data->jmljasa_angsuran)?0:$data->jmljasa_angsuran)',
                'htmlOptions'=>array('style'=>'text-align:right'),
               // 'headerHtmlOptions'=>array('style'=>'color:#373E4A'),	
                'footer'=>MyFormatter::formatNumberForPrint($model->getTotJA($provider)),
                                'footerHtmlOptions'=>array('style'=>'text-align:right;'),	
                ),
        array(
                'header'=>'Denda Angsuran',
                'value'=>'MyFormatter::formatNumberForPrint(empty($data->jmldenda_angsuran)?0:$data->jmldenda_angsuran)',
                'htmlOptions'=>array('style'=>'text-align:right'),
               // 'headerHtmlOptions'=>array('style'=>'color:#373E4A'),	
                'footer'=>MyFormatter::formatNumberForPrint($model->getTotDA($provider)),
                                'footerHtmlOptions'=>array('style'=>'text-align:right;'),	
                ),
        array(
                'header'=>'Total Bayar',
                'value'=>'MyFormatter::formatNumberForPrint(empty($data->bayar_angsuran)?0:$data->bayar_angsuran)',
                                'htmlOptions'=>array('style'=>'text-align:right'),
            //                    'headerHtmlOptions'=>array('style'=>'color:#373E4A'),	
                'footer'=>MyFormatter::formatNumberForPrint($model->getTotBayar($provider)),
                                'footerHtmlOptions'=>array('style'=>'text-align:right;'),	
                ),
        array(
                'header'=>'Sisa',
                'value'=>'MyFormatter::formatNumberForPrint(empty($data->sisa_angsuran)?0:$data->sisa_angsuran)',
                'htmlOptions'=>array('style'=>'text-align:right'),
             //   'headerHtmlOptions'=>array('style'=>'vertical-align:top;color:#373E4A'),	
                'footer'=>MyFormatter::formatNumberForPrint($model->getTotSisa($provider)),
                                'footerHtmlOptions'=>array('style'=>'text-align:right;'),	
                ),
      array(
                'header'=>'Status',
                'value'=>'($data->isudahbayar)? "LUNAS":"BELUM LUNAS"',
              //  'headerHtmlOptions'=>array('style'=>'vertical-align:top;color:#373E4A'),	
                ),
            ),
//        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
)); ?> 

