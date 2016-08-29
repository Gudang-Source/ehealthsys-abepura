<?php 
$table = 'ext.bootstrap.widgets.HeaderGroupGridView';
$data = $model->searchTable();
$template = "{summary}\n{items}\n{pager}";
$sort = true;
if (isset($caraPrint)){
    $sort = false;
  $data = $model->searchPrint();  
  $template = "{items}";
  if ($caraPrint == "EXCEL"){
    $table = 'ext.bootstrap.widgets.BootExcelGridView';
  
  }
  
}
?>
<?php $this->widget($table,array(
    'id'=>'tableLaporan',
    'dataProvider'=>$data,
    'enableSorting'=>$sort,
    'template'=>$template,
        'itemsCssClass'=>'table table-striped table-condensed',
    'mergeHeaders'=>array(
            array(
                'name'=>'<center>Penerimaan</center>',
                'start'=>5, //indeks kolom 3
                'end'=>7, //indeks kolom 4
            ),
            array(
                'name'=>'<center>Piutang</center>',
                'start'=>8, //indeks kolom 3
                'end'=>10, //indeks kolom 4
            ),
        ),
	'columns'=>array(
            array(
                    'header' => 'No',
                    'value' => '$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1',
                    'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:center;'),
            ),  
            array(
                'header'=>'Tanggal Pelayanan',
                'type'=>'raw',
                'value'=>'MyFormatter::formatDateTimeForUser(date("d/m/Y", strtotime($data->tglpembayaran)))',
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
                'value'=>'number_format($data->totalbiayapelayanan,0,"",".")',
                'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:center;'),
                'htmlOptions'=>array('style'=>'text-align:right;'),
            ),
            array(
                'header'=>'<center>Bayar Tunai</center>',
                'type'=>'raw',
                'value'=>'$this->grid->owner->renderPartial("billingKasir.views.laporan/rekapPendapatan/_totalKas",array("pendaftaran_id"=>$data->pendaftaran_id,"tglpembayaran"=>$data->tglpembayaran),true)',
                'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:center;'),
                'htmlOptions'=>array('style'=>'text-align:right;'),
            ),
            array(
                'header'=>'<center>Bank</center>',
                'type'=>'raw',
                'value'=>'$this->grid->owner->renderPartial("billingKasir.views.laporan/rekapPendapatan/_totalBank",array("pendaftaran_id"=>$data->pendaftaran_id,"tglpembayaran"=>$data->tglpembayaran),true)',
                'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:center;'),
                'htmlOptions'=>array('style'=>'text-align:right;'),
               
            ),
            array(
                'header'=>'<center>Giro</center>',
                'type'=>'raw',
                'value'=>'$this->grid->owner->renderPartial("billingKasir.views.laporan/rekapPendapatan/_totalGiro",array("pendaftaran_id"=>$data->pendaftaran_id,"tglpembayaran"=>$data->tglpembayaran),true)',
                'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:center;'),
                'htmlOptions'=>array('style'=>'text-align:right;'),
            ),
            array(
                'header'=>'<center>Piutang P3</center>',
                'type'=>'raw',
                'value'=>'$this->grid->owner->renderPartial("billingKasir.views.laporan/rekapPendapatan/_totalP3",array("pendaftaran_id"=>$data->pendaftaran_id,"tglpembayaran"=>$data->tglpembayaran),true)',
                'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:center;'),
                'htmlOptions'=>array('style'=>'text-align:right;'),
            ),
            array(
                'header'=>'<center>Piutang Pasien</center>',
                'type'=>'raw',
                'value'=>'$this->grid->owner->renderPartial("billingKasir.views.laporan/rekapPendapatan/_totalPiutang",array("pendaftaran_id"=>$data->pendaftaran_id,"tglpembayaran"=>$data->tglpembayaran),true)',
                'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:center;'),
                'htmlOptions'=>array('style'=>'text-align:right;'),
            ),
            array(
                'header'=>'<center>Jumlah</center>',
                'type'=>'raw',
                'value'=>'$this->grid->owner->renderPartial("billingKasir.views.laporan/rekapPendapatan/_totalJumlah",array("pendaftaran_id"=>$data->pendaftaran_id,"tglpembayaran"=>$data->tglpembayaran),true)',
                'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:center;'),
                'htmlOptions'=>array('style'=>'text-align:right;'),
            ),
            array(
                'header'=>'<center>User <br/> Name</center>',
                'type'=>'raw',
                'value'=>'($data->nama_pemakai != null) ? "$data->nama_pemakai":"-"',
                'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:center;'),
                'htmlOptions'=>array('style'=>'text-align:center;'),
            ),
            array(
                'header'=>'<center>Nama <br/> Perusahaan <br/> P3 </center>',
                'type'=>'raw',
                'value'=>'($data->penjamin_nama == "Umum" ) ? "-":"$data->penjamin_nama" ',
                'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:center;'),
                'htmlOptions'=>array('style'=>'text-align:center;'),
            ),
	),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
)); ?>