<?php 
$table = 'ext.bootstrap.widgets.HeaderGroupGridView';
$data = $model->searchTable();
$template = "{summary}\n{items}\n{pager}";
$sort = true;
if (isset($caraPrint)){
    $sort = false;
  $data = $model->searchPrint();  
  $template = "{items}";
  if ($caraPrint == "EXCEL")
      $table = 'ext.bootstrap.widgets.BootExcelGridView';
}
?>
<?php $this->widget($table,array(
    'id'=>'tableLaporan',
    'dataProvider'=>$data,
    'enableSorting'=>$sort,
    'template'=>$template,
        'itemsCssClass'=>'table table-striped table-bordered table-condensed',
    'mergeHeaders'=>array(
            array(
                'name'=>'<center>Penerimaan</center>',
                'start'=>5, //indeks kolom 3
                'end'=>7, //indeks kolom 4
            ),
            array(
                'name'=>'<center>Piutang</center>',
                'start'=>8, //indeks kolom 3
                'end'=>11, //indeks kolom 4
            ),
        ),
	'columns'=>array(
            array(
                    'header' => 'No',
                    'value' => '$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1',
                    'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:center;'),
            ),  
            array(
                'header'=>'Tgl. Transaksi',
                'type'=>'raw',
                'value'=>'$data->tglpembayaran',
                'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:center;'),
            ),
            array(
                'header'=>'No. RM',
                'type'=>'raw',
                'value'=>'$data->no_rekam_medik',
                'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:center;'),
            ),
            array(
                'header'=>'Nama Pasien',
                'type'=>'raw',
                'value'=>'$data->nama_pasien',
                'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:center;'),
            ),
            array(
                'header'=>'Total Tagihan',
                'type'=>'raw',
                'value'=>'number_format($data->totalbiayapelayanan)',
                'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:center;'),
            ),
            array(
                'header'=>'<center>KAS</center>',
                'type'=>'raw',
                'value'=>'"-"',
                'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:center;'),
            ),
            array(
                'header'=>'<center>Bank</center>',
                'type'=>'raw',
                'value'=>'"-"',
                'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:center;'),
               
            ),
            array(
                'header'=>'<center>Giro</center>',
                'type'=>'raw',
                'value'=>'"-"',
                'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:center;'),
            ),
            array(
                'header'=>'<center>Piutang P3</center>',
                'type'=>'raw',
                'value'=>'"-"',
                'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:center;'),
            ),
            array(
                'header'=>'<center>Piutang Pasien</center>',
                'type'=>'raw',
                'value'=>'"-"',
                'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:center;'),
            ),
            array(
                'header'=>'<center>Jumlah</center>',
                'type'=>'raw',
                'value'=>'"-"',
                'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:center;'),
            ),
            array(
                'header'=>'<center>User Name</center>',
                'type'=>'raw',
                'value'=>'"-"',
                'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:center;'),
            ),
            array(
                'header'=>'<center>Nama Perusahaan P3 </center>',
                'type'=>'raw',
                'value'=>'"-"',
                'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:center;'),
            ),
	),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
)); ?>