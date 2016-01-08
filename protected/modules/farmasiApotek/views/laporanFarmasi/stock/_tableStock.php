<?php
$table = 'ext.bootstrap.widgets.HeaderGroupGridView';
$template = "{summary}\n{items}\n{pager}";
if (isset($caraPrint)){
  $data = $model->searchPrint();
  $template = "{items}";
  if ($caraPrint=='EXCEL') {
      $table = 'ext.bootstrap.widgets.BootExcelGridView';
  }
} else{
  $data = $model->search();
}
?>
<?php $this->widget($table, array(
	'id'=>'laporan-grid',
	'dataProvider'=>$data,
                'itemsCssClass'=>'table table-striped table-condensed',
                'template'=>$template,
       'mergeHeaders'=>array(
            array(
                'name'=>'<center>Jumlah</center>',
                'start'=>3, //indeks kolom 3
                'end'=>5, //indeks kolom 4
            ),
        ),
	'columns'=>array(
                    array(
                        'header'=>'No.',
                        'value' => '$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1',
//                        'footer'=>'<b>Total:</b>',
                        'footerHtmlOptions'=>array('colspan'=>3, 'style'=>'text-align:right;'),
                        'type'=>'raw',
                         'htmlOptions'=>array(
                            'style'=>'text-align:right;padding-right:10%;'
                        ),
                    ),
                    array(
                        'header'=>'Kode Obat Alkes',
                        'value'=>'$data->obatalkes_kode',
                    ),
                    array(
                        'header'=>'Nama Obat Alkes',
                        'value'=>'$data->obatalkes_nama',
                    ),
                    array(
                        'name'=>'qty_in',
                        'type'=>'raw',
                        'header'=>'Jumlah Masuk',
                        'value'=>'number_format($data->qty_in,0,",",".")',
                        'htmlOptions'=>array('style'=>'text-align:left;'),
                        'footerHtmlOptions'=>array('style'=>'text-align:left;'),
//                        'footer'=>'sum(qty_in)',
                        
//                        'footer'=>number_format($model->totalqtystok_in),
                    ),
                    array(
                        'name'=>'qty_out',
                        'type'=>'raw',
                        'header'=>'Jumlah Keluar',
                        'value'=>'number_format($data->qty_out,0,",",".")',
                        'htmlOptions'=>array('style'=>'text-align:left;'),
                        'footerHtmlOptions'=>array('style'=>'text-align:left;'),
//                        'footer'=>'sum(qty_out)',
                        
//                        'footer'=>number_format($model->totalqtystok_in),
                    ),
                    array(
                        'name'=>'qty_current',
                        'type'=>'raw',
                        'header'=>'Jumlah Sekarang',
                        'value'=>'number_format($data->qty_current,0,",",".")',
                        'htmlOptions'=>array('style'=>'text-align:left;'),
                        'footerHtmlOptions'=>array('style'=>'text-align:left;width:100px;'),
//                        'footer'=>'sum(qty_current)',
                        
//                        'footer'=>number_format($model->totalqtystok_in),
                    ),
//                    array(
//                        'header'=>'Harga Jual',
//                        'value'=>'number_format($data->hargajual_oa)',
//                        'footer'=>number_format($model->totalhargajual),
//                    ),
//                    array(
////                        'header'=>'Total Harga',
////                        'value'=>'number_format($data->hargajual_oa * $data->qty)',
////                        'footer'=>number_format($model->totalharga),
//                        'name'=>'totalharga',
//                        'type'=>'raw',
//                        'header'=>'Total Harga',
//                        'value'=>'number_format($data->hargajual_oa * $data->qty)',
//                        'htmlOptions'=>array('style'=>'text-align:right;'),
//                        'footerHtmlOptions'=>array('style'=>'text-align:right;'),
//                        'footer'=>'sum(totalharga)',
//                    ),
	),
)); ?>
<?php
    if(isset($caraPrint) && $caraPrint == 'EXCEL'){
        $this->widget($table, array(
            'id'=>'laporan-grid',
            'dataProvider'=>$data,
            'itemsCssClass'=>'table table-bordered table-striped table-condensed',
            'template'=>$template,
           'mergeHeaders'=>array(
                array(
                    'name'=>'<center>Jumlah</center>',
                    'start'=>3, //indeks kolom 3
                    'end'=>5, //indeks kolom 4
                ),
            ),
            'columns'=>array(
            array(
                'header'=>'No.',
                'value' => '$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1',
    //                        'footer'=>'<b>Total:</b>',
                'footerHtmlOptions'=>array('colspan'=>3, 'style'=>'text-align:right;'),
                'type'=>'raw',
                 'htmlOptions'=>array(
                    'style'=>'text-align:right;padding-right:10%;'
                ),
            ),
            array(
                'header'=>'Kode Obat Alkes',
                'value'=>'$data->obatalkes_kode',
            ),
            array(
                'header'=>'Nama Obat Alkes',
                'value'=>'$data->obatalkes_nama',
            ),
            array(
                'name'=>'qty_in',
                'type'=>'raw',
                'header'=>'<center>Jumlah Masuk</center>',
                'value'=>'$data->qty_in',
                'htmlOptions'=>array('style'=>'text-align:center;'),
                'footerHtmlOptions'=>array('style'=>'text-align:center;'),
            ),
            array(
                'name'=>'qty_out',
                'type'=>'raw',
                'header'=>'<center>Jumlah Keluar</center>',
                'value'=>'$data->qty_out',
                'htmlOptions'=>array('style'=>'text-align:center;'),
                'footerHtmlOptions'=>array('style'=>'text-align:center;'),
            ),
            array(
                'name'=>'qty_current',
                'type'=>'raw',
                'header'=>'<center>Jumlah Sekarang</center>',
                'value'=>'$data->qty_current',
                'htmlOptions'=>array('style'=>'text-align:center;'),
                'footerHtmlOptions'=>array('style'=>'text-align:center;width:100px;'),
            ),
        ),
    )); 
    }
    ?>