<?php
$table = 'ext.bootstrap.widgets.HeaderGroupGridView';
$template = "{summary}\n{items}\n{pager}";
$row = '$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1';
if (isset($caraPrint)){
  $row = '$row+1';
  $data = $model->searchRencanaKebutuhanPrint();
  $template = "{items}";
  if ($caraPrint=='EXCEL') {
      $table = 'ext.bootstrap.widgets.BootExcelGridView';
  }
} else{
  $data = $model->searchRencanaKebutuhan();
}
?>
<?php $this->widget($table, array(
	'id'=>'laporan-grid',
	'dataProvider'=>$data,
                'itemsCssClass'=>'table table-striped table-condensed',
                'template'=>$template,
//       'mergeHeaders'=>array(
//            array(
//                'name'=>'<center>Jumlah</center>',
//                'start'=>3, //indeks kolom 3
//                'end'=>5, //indeks kolom 4
//            ),
//        ),
	'columns'=>array(
                    array(
                        'header'=>'No.',
                        'value' => $row,
//                        'footer'=>'<b>Total:</b>',
//                        'footerHtmlOptions'=>array('colspan'=>3, 'style'=>'text-align:right;'),
//                        'type'=>'raw',
//                         'htmlOptions'=>array(
//                            'style'=>'text-align:right;padding-right:10%;'
//                        ),
                    ), 
                    
                    array(
                        'header'=>'Tanggal Perencanaan',
                        'value'=>'date("d/m/Y", strtotime($data->renkebbarang_tgl))',
                    ),
                    array(
                        'header'=>'No. Perencanaan',
                        'value'=>'$data->renkebbarang_no',
                    ), 
                    array(
                        'header'=>'Nama Barang',
                        'value'=>'$data->barang_nama',
                    ),
                    array(
                        'header'=>'Jumlah Permintaan',
                        'value'=>'$data->jmlpermintaanbarangdet',
                    ),
                    array(
                        'header'=>'Harga Total',
                        'value'=>'MyFormatter::formatNumberForPrint($data->harga_barangdet)',
                        'htmlOptions'=>array(
                            'style'=>'text-align: right',
                        )
                    ),
//                    array(
//                        'name'=>'qty_in',
//                        'type'=>'raw',
//                        'header'=>'<center>Jumlah In</center>',
//                        'value'=>'$data->qty_in',
//                        'htmlOptions'=>array('style'=>'text-align:center;'),
//                        'footerHtmlOptions'=>array('style'=>'text-align:center;'),
//                        'footer'=>'sum(qty_in)',
//                        
////                        'footer'=>number_format($model->totalqtystok_in),
//                    ),
//                    array(
//                        'name'=>'qty_out',
//                        'type'=>'raw',
//                        'header'=>'<center>Jumlah Out</center>',
//                        'value'=>'$data->qty_out',
//                        'htmlOptions'=>array('style'=>'text-align:center;'),
//                        'footerHtmlOptions'=>array('style'=>'text-align:center;'),
//                        'footer'=>'sum(qty_out)',
//                        
////                        'footer'=>number_format($model->totalqtystok_in),
//                    ),
//                    array(
//                        'name'=>'qty_current',
//                        'type'=>'raw',
//                        'header'=>'<center>Jumlah Current</center>',
//                        'value'=>'$data->qty_current',
//                        'htmlOptions'=>array('style'=>'text-align:center;'),
//                        'footerHtmlOptions'=>array('style'=>'text-align:center;width:100px;'),
//                        'footer'=>'sum(qty_current)',
//                        
////                        'footer'=>number_format($model->totalqtystok_in),
//                    ),
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