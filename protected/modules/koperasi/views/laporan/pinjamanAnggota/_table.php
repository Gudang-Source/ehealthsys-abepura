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
                'header'=>'No Anggota',
                'type'=>'raw',
                'value'=>'$data->nokeanggotaan',
           //     'headerHtmlOptions'=>array('style'=>'color:#373E4A'),
                'footer'=>'<b>GRAND TOTAL</b>',
                'footerHtmlOptions'=>array('style'=>'text-align:right;','colspan'=>'9'),
        ),
        array(
                'header'=>'Nama Anggota',
                'type'=>'raw',
                'value'=>'$data->nama_pegawai',
             //   'headerHtmlOptions'=>array('style'=>'color:#373E4A'),
        ),      
        array(
                'header'=>'Golongan',
                'type'=>'raw',
                'value'=>'$data->golonganpegawai_nama',
             //   'headerHtmlOptions'=>array('style'=>'color:#373E4A'),
        ),
        array(
                'header'=>'Tgl Pinjaman',
                'type'=>'raw',
                'value'=>'MyFormatter::formatDateTimeForUser(date("d/m/Y", strtotime($data->tglpinjaman)))',
              //  'headerHtmlOptions'=>array('style'=>'color:#373E4A'),
        ),
        array(
                'header'=>'No Pinjaman',
                'value'=>'$data->no_pinjaman',
              //  'headerHtmlOptions'=>array('style'=>'color:#373E4A'),
        ),
        array(
                'header'=>'Tgl Jatuh Tempo',
                'type'=>'raw',
                'value'=>'MyFormatter::formatDateTimeForUser(date("d/m/Y", strtotime($data->jatuh_tempo)))',
              //  'headerHtmlOptions'=>array('style'=>'color:#373E4A'),
        ),
        array(
                'header'=>'Jangka Waktu',
                'value'=>'$data->jangka_waktu_bln',
                'htmlOptions'=>array('style'=>'text-align:center'),
              //  'headerHtmlOptions'=>array('style'=>'color:#373E4A'),
        ),
        array(
                'header'=>'Jumlah Kali Angsuran',
                'value'=>'$data->jml_kali_angsur',
                'htmlOptions'=>array('style'=>'text-align:center'),
             //   'headerHtmlOptions'=>array('style'=>'color:#373E4A'),

        ),
        array(
                'header'=>'Jumlah Pinjaman',
                'value'=>'MyFormatter::formatNumberForPrint($data->jml_pinjaman)',
                'htmlOptions'=>array('style'=>'text-align:right'),
                'footer'=>MyFormatter::formatNumberForPrint($model->getTotalPinjaman($provider)),
                'footerHtmlOptions'=>array('style'=>'text-align:right;'),
             //   'headerHtmlOptions'=>array('style'=>'color:#373E4A'),
        ),
        array(
                'header'=>'Jasa Pinjaman',
                'value'=>'MyFormatter::formatNumberForPrint($data->jasapinjaman)',
                'htmlOptions'=>array('style'=>'text-align:right'),
                'footer'=>MyFormatter::formatNumberForPrint($model->getTotalJasa($provider)),
                'footerHtmlOptions'=>array('style'=>'text-align:right;'),
              //  'headerHtmlOptions'=>array('style'=>'color:#373E4A'),
        ),
        array(
                'header'=>'Total',
                'type'=>'raw',
                'value'=>'MyFormatter::formatNumberForPrint($data->jml_pinjaman + $data->jasapinjaman)',
                'htmlOptions'=>array('style'=>'text-align:right'),
                'footer'=>MyFormatter::formatNumberForPrint($model->getTotalpinjaman($provider) + $model->getTotalJasa($provider)), 
                'footerHtmlOptions'=>array('style'=>'text-align:right;'),
               // 'headerHtmlOptions'=>array('style'=>'color:#373E4A'),
        ),
        ),
//        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
)); ?> 

