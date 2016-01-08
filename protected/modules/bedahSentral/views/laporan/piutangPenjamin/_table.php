<?php 
$table = 'ext.bootstrap.widgets.HeaderGroupGridView';
$data = $model->searchPiutang();
$template = "{summary}\n{items}\n{pager}";
$sort = true;
if (isset($caraPrint)){
    $sort = false;
  $data = $model->searchPrintPiutang();  
  $template = "{items}";
  if ($caraPrint == "EXCEL")
      $table = 'ext.bootstrap.widgets.BootExcelGridView';
}
?>

<div id="div_penjamin">
    <div>
        <legend class="rim"> Tabel Rekap Piutang - P3 / Penjamin </legend>
        <?php 
            if(isset($_GET['filter_tab']) == "penjamin"){
                $data = $model->searchPiutangPenjamin;
            }
            $this->widget($table,array(
                'id'=>'laporanrekapiutangpenjamin-grid',
                'dataProvider'=>$data,
                'enableSorting'=>$sort,
                'template'=>$template,
                'itemsCssClass'=>'table table-striped table-bordered table-condensed',
                    'columns'=>array(
                        array(
                                'header' => 'No',
                                'value' => '$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1',
                                'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:center;'),
                        ),  
                        array(
                            'header'=>'Initial',
                            'type'=>'raw',
                            'value'=>'$data->penjamin_nama',
                            'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:center;'),
                        ),
                        array(
                            'header'=>'Tgl. Billing',
                            'type'=>'raw',
                            'value'=>'$data->tglpembayaran',
                            'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:center;'),
                        ),
                        array(
                            'header'=>'No. Rekam Medik',
                            'type'=>'raw',
                            'value'=>'$data->no_rekam_medik',
                            'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:center;'),
                        ),
                        array(
                            'header'=>'No. Pendaftaran',
                            'type'=>'raw',
                            'value'=>'$data->no_pendaftaran',
                            'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:center;'),
                        ),
                        array(
                            'header'=>'<center>Total Tagihan</center>',
                            'type'=>'raw',
                            'value'=>'number_format($data->totalbayartindakan)',
                            'htmlOptions'=>array('style'=>'vertical-align:middle;text-align:right;'),
                        ),
                        array(
                            'header'=>'<center>Tanggungan <br/> P3</center>',
                            'type'=>'raw',
                            'value'=>'"-"',
                            'htmlOptions'=>array('style'=>'vertical-align:middle;text-align:right;'),

                        ),
                        array(
                            'header'=>'<center>Tanggungan <br/> Pasien</center>',
                            'type'=>'raw',
                            'value'=>'"-"',
                            'htmlOptions'=>array('style'=>'vertical-align:middle;text-align:right;'),
                        ),
                       array(
                           'header'=>'<center>Nama Pasien</center>',
                           'type'=>'raw',
                           'value'=>'$data->nama_pasien',
                       ),
                       array(
                           'header'=>'<center>Unit Pelayanan</center>',
                           'type'=>'raw',
                           'value'=>'$data->ruangan_nama',
                       ),
                       array(
                           'header'=>'<center>Tgl. Masuk</center>',
                           'type'=>'raw',
                           'value'=>'$data->tgl_pendaftaran',
                       ),
                       array(
                           'header'=>'<center>Tgl. Keluar</center>',
                           'type'=>'raw',
                           'value'=>'"-"',
                       ),
                    ),
                    'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
            )); 
        ?>
    </div>
</div>

<div id="div_umum">
    <div style="width:1480px;overflow:auto;">
        <legend class="rim">Tabel Rekap Piutang - Umum </legend>
            <?php 
                if(isset($_GET['filter_tab']) == "penjamin"){
                    $data = $model->searchPiutangUmum;
                }
                $this->widget($table,array(
                'id'=>'laporanrekapiutangumum-grid',
                'dataProvider'=>$data,
                'enableSorting'=>$sort,
                'template'=>$template,
                'itemsCssClass'=>'table table-striped table-bordered table-condensed',
                    'columns'=>array(
                        array(
                                'header' => 'No',
                                'value' => '$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1',
                                'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:center;'),
                        ),  
//                        array(
//                            'header'=>'Initial',
//                            'type'=>'raw',
//                            'value'=>'$data->tglpembayaran',
//                            'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:center;'),
//                        ),
                        array(
                            'header'=>'Tgl. Billing',
                            'type'=>'raw',
                            'value'=>'$data->tglpembayaran',
                            'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:center;'),
                        ),
                        array(
                            'header'=>'No. Rekam Medik',
                            'type'=>'raw',
                            'value'=>'$data->nama_pasien',
                            'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:center;'),
                        ),
                        array(
                            'header'=>'No. Pendaftaran',
                            'type'=>'raw',
                            'value'=>'$data->nama_pasien',
                            'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:center;'),
                        ),
                        array(
                            'header'=>'Total Tagihan',
                            'type'=>'raw',
                            'value'=>'"-"',
                            'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:center;'),
                        ),
                        array(
                            'header'=>'Tanggungan <br/> P3',
                            'type'=>'raw',
                            'value'=>'"-"',
                            'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:center;'),

                        ),
                        array(
                            'header'=>'Tanggungan <br/> Pasien',
                            'type'=>'raw',
                            'value'=>'"-"',
                            'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:center;'),
                        ),
                        array(
                           'header'=>'Nama Pasien',
                           'type'=>'raw',
                           'value'=>'$data->nama_pasien',
                        ),
                        array(
                           'header'=>'Unit Pelayanan',
                           'type'=>'raw',
                           'value'=>'$data->ruangan_nama',
                        ),
                        array(
                           'header'=>'Tgl. Masuk',
                           'type'=>'raw',
                           'value'=>'$data->tgl_pendaftaran',
                        ),
                        array(
                           'header'=>'Tgl. Keluar',
                           'type'=>'raw',
                           'value'=>'"-"',
                        ),
                    ),
                    'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
            )); 
        ?>
    </div>
</div>
<br/>