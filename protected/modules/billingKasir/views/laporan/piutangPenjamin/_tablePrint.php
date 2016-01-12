<?php 
$table = 'ext.bootstrap.widgets.HeaderGroupGridView';
$data = $model->searchPiutangPenjamin();
$template = "{summary}\n{items}\n{pager}";
$sort = true;
if (isset($caraPrint)){
    $sort = false;
  $data = $model->searchPrintPenjamin();  
  $template = "{items}";
  if ($caraPrint == "EXCEL")
      $table = 'ext.bootstrap.widgets.BootExcelGridView';
}
?>
<?php if($_GET['filter_tab'] == 'penjamin'){ ?>
<div id="div_penjamin">
    <div>
        <?php if(!$caraPrint){ ?>
        <legend class="rim"> Tabel Rekap Piutang - P3 / Penjamin </legend>
        <?php } ?>
        <?php 
            $data = $model->searchPrintPenjamin();
            $this->widget($table,array(
                'id'=>'laporanrekapiutangpenjamin-grid',
                'dataProvider'=>$data,
                'enableSorting'=>$sort,
                'template'=>$template,
                'itemsCssClass'=>'table table-striped table-bordered table-condensed',
                    'columns'=>array(
                        array(
                            'header' => 'No',
                            'value' => '$row+1',
                            'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:center;'),
                            'htmlOptions'=>array('style'=>'text-align:center;'),
                        ),  
                        array(
                            'header'=>'Initial',
                            'type'=>'raw',
                            'value'=>'$data->penjamin_nama',
                            'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:center;'),
                        ),
                        array(
                            'header'=>'Tanggal Pembayaran',
                            'type'=>'raw',
                            'value'=>'date("d/m/Y H:i:s", strtotime($data->tglpembayaran))',
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
                           'header'=>'<center>Nama Pasien</center>',
                           'type'=>'raw',
                           'value'=>'$data->nama_pasien',
                           'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:center;'),
                       ),
                       array(
                           'header'=>'<center>Unit Pelayanan</center>',
                           'type'=>'raw',
                           'value'=>'$data->ruanganakhir_nama',
                           'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:center;'),
                       ),
                       array(
                           'header'=>'<center>Tanggal Masuk</center>',
                           'type'=>'raw',
                            'value'=>'date("d/m/Y H:i:s", strtotime($data->tgl_pendaftaran))',
                           'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:center;'),
                       ),
                       array(
                           'header'=>'<center>Tanggal Keluar</center>',
                           'type'=>'raw',
                            'value'=>'date("d/m/Y H:i:s", strtotime($data->tglpulang))',
                           'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:center;'),
                       ),
                        array(
                            'header'=>'<center>Total Tagihan</center>',
                            'type'=>'raw',
                            'value'=>'$data->totalbiayapelayanan',
                            'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:center;'),
                            'htmlOptions'=>array('style'=>'vertical-align:middle;text-align:right;'),
                        ),
                        array(
                            'header'=>'<center>Tanggungan <br/> P3</center>',
                            'type'=>'raw',
                            'value'=>'$data->totalsubsidiasuransi',
                            'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:center;'),
                            'htmlOptions'=>array('style'=>'vertical-align:middle;text-align:right;'),

                        ),
                        array(
                            'header'=>'<center>Tanggungan <br/> Pasien</center>',
                            'type'=>'raw',
                            'value'=>'$data->totaliurbiaya-$data->totalsubsidiasuransi',
                            'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:center;'),
                            'htmlOptions'=>array('style'=>'vertical-align:middle;text-align:right;'),
                        ),                       
                    ),
                    'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
            )); 
        ?>
    </div>
</div>
<?php }else if($_GET['filter_tab'] == 'umum'){ ?>
<div id="div_umum">
    <div style="max-width:1300px;overflow:auto;">
        <?php if(!$caraPrint){ ?>
        <legend class="rim">Tabel Rekap Piutang - Umum </legend>
        <?php } ?>
            <?php 
                $data = $model->searchPrintUmum();
                $this->widget($table,array(
                'id'=>'laporanrekapiutangumum-grid',
                'dataProvider'=>$data,
                'enableSorting'=>$sort,
                'template'=>$template,
                'itemsCssClass'=>'table table-striped table-bordered table-condensed',
                    'columns'=>array(
                        array(
                                'header' => 'No',
                                'value' => '$row+1',
                                'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:center;'),
                        ),  
                        array(
                            'header'=>'Tanggal Billing',
                            'type'=>'raw',
                            'value'=>'date("d/m/Y H:i:s", strtotime($data->tglpembayaran))',
                            'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:center;'),
                        ),
                        array(
                            'header'=>'No. RM',
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
                           'header'=>'Nama Pasien',
                           'type'=>'raw',
                           'value'=>'$data->nama_pasien',
                        ),
                        array(
                           'header'=>'Unit <br/> Pelayanan',
                           'type'=>'raw',
                           'value'=>'$data->ruanganakhir_nama',
                        ),
                        array(
                            'header'=>'Tanggal Masuk',
                            'type'=>'raw',
                            'value'=>'date("d/m/Y H:i:s", strtotime($data->tgl_pendaftaran))',
                            'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:center;'),
                        ),
                        array(
                           'header'=>'Tanggal Keluar',
                           'type'=>'raw',
                            'value'=>'date("d/m/Y H:i:s", strtotime($data->tglpulang))',
                        ),
                        array(
                            'header'=>'Total Tagihan',
                            'type'=>'raw',
                            'value'=>'$data->totalbiayapelayanan',
                            'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:right;'),
                            'htmlOptions'=>array('style'=>'text-align:right;'),
                        ),
                        array(
                            'header'=>'Tanggungan <br/> P3',
                            'type'=>'raw',
                            'value'=>'$data->totalsubsidiasuransi',
                            'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:center;'),
                            'htmlOptions'=>array('style'=>'text-align:right;'),

                        ),
                        array(
                            'header'=>'Tanggungan <br/> Pasien',
                            'type'=>'raw',
                            'value'=>'$data->totaliurbiaya-$data->totalsubsidiasuransi',
                            'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:center;'),
                            'htmlOptions'=>array('style'=>'text-align:right;'),
                        ),
                    ),
                    'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
            )); 
        ?>
    </div>
</div>
<?php } ?>
<br/>