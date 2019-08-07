<?php 
    $table = 'ext.bootstrap.widgets.BootGroupGridView';
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
    $provider2 = clone $provider;
    $provider2->pagination = false;
    $pdata = $provider2->data;

    $pokok = $model->getTotal($pdata, 'total_simpananpokok');
    $wajib = $model->getTotal($pdata, 'total_simpananwajib');
    $sukarela = $model->getTotal($pdata, 'total_simpanansukarela');
    $deposito = $model->getTotal($pdata, 'total_simpanandeposito');

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
            'header'=>'No Anggota',
            'type'=>'raw',
            'value'=>'$data->nokeanggotaan',
          //  'headerHtmlOptions'=>array('style'=>'color:#373E4A'),
            'footer'=>'<b>GRAND TOTAL</b>',
           // 'footerHtmlOptions'=>array('style'=>'text-align:right;color:#373E4A','colspan'=>'4'),
        ),
            array(
                    'header'=>'Nama Anggota',
                    'type'=>'raw',
                    'value'=>'$data->namaLengkap',
                //    'headerHtmlOptions'=>array('style'=>'color:#373E4A'),
            ),
          //  array(
             //       'header'=>'Unit',
              //      'type'=>'raw',
              //      'value'=>'$data->namaunit',
              //      'headerHtmlOptions'=>array('style'=>'color:#373E4A'),
           // ),
            array(
                    'header'=>'Golongan',
                    'type'=>'raw',
                    'value'=>'$data->golonganpegawai_nama',
               //     'headerHtmlOptions'=>array('style'=>'color:#373E4A'),
            ),
            array(
                    'header'=>'Simpanan Pokok',
                    'value'=>'MyFormatter::formatNumberForPrint($data->total_simpananpokok)',
                    'htmlOptions'=>array('style'=>'text-align:right'),
            //        'headerHtmlOptions'=>array('style'=>'color:#373E4A'),
                    'footer'=>MyFormatter::formatNumberForPrint($pokok),
                    'footerHtmlOptions'=>array('style'=>'text-align:right;'),

            ),
            array(
                    'header'=>'Simpanan Wajib',
                    'value'=>'(!empty($data->total_simpananwajib)) ? MyFormatter::formatNumberForPrint($data->total_simpananwajib):"0"',
                    'htmlOptions'=>array('style'=>'text-align:right'),
             //       'headerHtmlOptions'=>array('style'=>'color:#373E4A'),
                    'footer'=>MyFormatter::formatNumberForPrint($wajib),
                    'footerHtmlOptions'=>array('style'=>'text-align:right;'),

            ),
            array(
                    'header'=>'Simpanan Sukarela',
                    'value'=>'(!empty($data->total_simpanansukarela)) ? MyFormatter::formatNumberForPrint($data->total_simpanansukarela):"0"',
                    'htmlOptions'=>array('style'=>'text-align:right'),
            //        'headerHtmlOptions'=>array('style'=>'color:#373E4A'),
                    'footer'=>MyFormatter::formatNumberForPrint($sukarela),
                    'footerHtmlOptions'=>array('style'=>'text-align:right;'),

            ), /*
            array(
                    'header'=>'Jasa Simpanan Sukarela',
                    'type'=>'raw',
                    'value'=>'($data->PersenJasaSR !="-") ? $data->PersenJasaSR:"0"',
                    'htmlOptions'=>array('style'=>'text-align:right'),
                    'headerHtmlOptions'=>array('style'=>'color:#373E4A'),
                    'footer'=>MyFormatter::formatNumberForPrint($simpanan->getTotal($pdata, 'total_simpananpokok')),
        'footerHtmlOptions'=>array('style'=>'text-align:right;color:#373E4A'),
            ), */
            array(
                    'header'=>'Simpanan Deposito',
                    'value'=>'(!empty($data->total_simpanandeposito)) ? MyFormatter::formatNumberForPrint($data->total_simpanandeposito):"0"',
                    'htmlOptions'=>array('style'=>'text-align:right'),
                  //  'headerHtmlOptions'=>array('style'=>'color:#373E4A'),
                    'footer'=>MyFormatter::formatNumberForPrint($deposito),
                    'footerHtmlOptions'=>array('style'=>'text-align:right;'),
      

            ), /*
            array(
                    'header'=>'Jasa Simpanan Deposito',
                    'type'=>'raw',
                    'value'=>'($data->PersenJasaDP !="-") ? $data->PersenJasaDP:"0"',
                    'headerHtmlOptions'=>array('style'=>'color:#373E4A'),
                    'htmlOptions'=>array('style'=>'text-align:right'),
                    //'footer'=>MyFormatter::formatNumberForPrint($simpanan->getTotJasaDP($provider)),
        'footerHtmlOptions'=>array('style'=>'text-align:right;color:#373E4A'),
            ), */
            array(
                    'header'=>'Total',
                    'type'=>'raw',
                    'value'=>'MyFormatter::formatNumberForPrint($data->total_simpananpokok + $data->total_simpananwajib + $data->total_simpanansukarela + $data->total_simpanandeposito)',
                    'htmlOptions'=>array('style'=>'text-align:right'),
                 //   'headerHtmlOptions'=>array('style'=>'color:#373E4A'),

                    'footer'=>MyFormatter::formatNumberForPrint($pokok + $wajib + $sukarela + $deposito), 
                    'footerHtmlOptions'=>array('style'=>'text-align:right;'),
            ),
        ),
//        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
)); ?> 

