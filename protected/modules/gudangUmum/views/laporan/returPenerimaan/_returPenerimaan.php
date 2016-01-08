<?php
$table = 'ext.bootstrap.widgets.BootGridView';
$template = "{summary}\n{items}\n{pager}";
$row = '$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1';
if (isset($caraPrint)){
  $row = '$row+1';
  $data = $model->searchReturPenerimaanPrint();
  $template = "{items}";
  if ($caraPrint=='EXCEL') {
      $table = 'ext.bootstrap.widgets.BootExcelGridView';
  }
} else{
  $data = $model->searchReturPenerimaan();
}
?>
<?php $this->widget($table, array(
	'id'=>'laporan-grid',
	'dataProvider'=>$data,
        'itemsCssClass'=>'table table-striped table-condensed',
        'template'=>$template,
	'columns'=>array(
            array(
                'header'=>'No.',
                'value' =>$row,
            ),
            array(
                'header'=>'No. Retur Penerimaan',
                'value'=>'$data->noreturterima',
                'type'=>'raw',
            ),
            array(
                'header'=>'Tanggal Retur',
                'value'=>'$data->tglreturterima',
                'type'=>'raw',
            ),
            array(
                'header'=>'Alasan Retur',
                'value'=>'date("d/m/Y H:i:s",strtotime($data->alasanreturterima))',
                'type'=>'raw',
            ),
            array(
                'header'=>'Keterangan Retur',
                'value'=>'$data->keterangan_retur',
                'type'=>'raw',
                'footer'=>'<b>Total:</b>',
                'footerHtmlOptions'=>array('style'=>'text-align:right;'),
                'htmlOptions'=>array(
                'style'=>'text-align:right;padding-right:10%;'
                ),
            ),
            array(
                'header'=>'Total Retur',
                'value'=>'$data->totalretur',
                'headerHtmlOptions'=>array('style'=>'text-align:right;'),
                'htmlOptions'=>array('style'=>'text-align:right;'),
                'footerHtmlOptions'=>array('style'=>'text-align:right;font-weight:bold;'),
                'type'=>'raw',
                'footer'=>number_format($model->getTotalRetur()),
            ),
            array(
                'header'=>'Pegawai Retur',
                'value'=>'(isset($data->pegawairetur->nama_pegawai) ? $data->pegawairetur->nama_pegawai : "")',
                'type'=>'raw',
            ),
            array(
                'header'=>'Pegawai Mengetahui',
                'value'=>'(isset($data->pegawaimengetahui->nama_pegawai) ? $data->pegawaimengetahui->nama_pegawai : "")',
                'type'=>'raw',
            ),
	),
)); ?>