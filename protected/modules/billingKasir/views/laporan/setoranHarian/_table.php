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
<div class="block-tabel">
    <h6>Tabel <b>Setoran Harian</b></h6>
    <?php $this->widget($table,array(
        'id'=>'tableLaporan',
        'dataProvider'=>$data,
        'enableSorting'=>$sort,
        'template'=>$template,
            'htmlOptions'=>array(
                'style'=>'font-size',

            ),
            'itemsCssClass'=>'table table-striped table-condensed',
        'columns'=>array(
                   array(
                        'header' => 'No.',
                        'value' => '(($this->grid->dataProvider->pagination) ? $this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize : 0) + $row+1',
                        'htmlOptions'=>array('style'=>'font-size:10px;'),
                        'footerHtmlOptions'=>array('colspan'=>6,'style'=>'text-align:right;font-style:italic;'),
                        'footer'=>'JUMLAH',
                    ),
                   array(
                        'header' => 'No. Registrasi',
                        'name' => 'no_rekam_medik',
                        'htmlOptions'=>array('style'=>'font-size:10px;'),
                    ),
                   array(
                        'header' => 'No. Kwitansi',
                        'name' => 'nobuktibayar',
                        'htmlOptions'=>array('style'=>'font-size:10px;'),
                    ),
                   array(
                        'header' => 'Uraian',
                        'name' => 'nama_pasien',
                        'htmlOptions'=>array('style'=>'font-size:10px;'),
                    ),
                   array(
                        'header' => 'Ruangan',
                        'name' => 'ruangan_nama',
                        'htmlOptions'=>array('style'=>'font-size:10px;'),
                    ),
                   array( 
                        'header' => 'Kelas Pelayanan',
                        'name' => 'kelaspelayanan_nama',
                        'htmlOptions' => array('style'=>'font-size:10px;'), 
                    ),
                   array( 
                        'header' => 'Jumlah',
                        'name' => 'totalbayartindakan',
                        'value' => 'number_format($data->totalbayartindakan,0,"",".")',
                        'htmlOptions' => array('style'=>'font-size:10px;'), 
                        'footer'=>number_format($model->getTotalSetoran(),0,",",".")
                    ),
                   array( 
                        'header' => 'Keterangan',
                        'name' => 'keterangan_closing',
                        'value'=> '$data->keterangan_closing',
                        'htmlOptions' => array('style'=>'font-size:10px;'),
                        'footer'=>'&nbsp;',
                    ),
    //               array(
    //                    'header' => 'Bahan Alat',
    //                    'type' => 'raw',
    //                    'htmlOptions'=>array('style'=>'text-align:right;'),
    //                    'value'=>'number_format($data->tarif_bhp,0,"",".")',
    //                    'htmlOptions'=>array('style'=>'font-size:10px;'),
    //                ),
    //               array(
    //                    'header' => 'Jasa Rumah Sakit',
    //                    'type' => 'raw',
    //                    'htmlOptions'=>array('style'=>'text-align:right;'),
    //                    'value'=>'number_format($data->tarif_rsakomodasi,0,"",".")',
    //                    'htmlOptions'=>array('style'=>'font-size:10px;'),
    //                ),
    //               array(
    //                    'header' => 'Jasa Medis',
    //                    'type' => 'raw',
    //                    'htmlOptions'=>array('style'=>'text-align:right;'),
    //                    'value'=>'number_format($data->tarif_medis,0,"",".")',
    //                    'htmlOptions'=>array('style'=>'font-size:10px;'),
    //                ),
    //               array(
    //                    'header' => 'Total',
    //                    'type' => 'raw',
    //                    'htmlOptions'=>array('style'=>'text-align:right;'),
    //                    'value' => 'number_format($data->tarif_satuan,0,"",".")',
    //                    'htmlOptions'=>array('style'=>'font-size:10px;'),
    //                ),

        ),
            'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
    )); ?>
</div>
<div class="block-tabel">
    <h6>Tabel <b>DP Keluar</b></h6>
    <?php 
    $tableDP = 'ext.bootstrap.widgets.HeaderGroupGridView';
    $dataDP = $model->searchTableDP();
    $templateDP = "{summary}\n{items}\n{pager}";
    $sortDP = true;
    if (isset($caraPrint)){
      $sortDP = false;
      $dataDP = $model->searchPrintDP();  
      $templateDP = "{items}";
      if ($caraPrint == "EXCEL")
          $tableDP = 'ext.bootstrap.widgets.BootExcelGridView';
    }
    ?>
    <?php $this->widget($tableDP,array(
        'id'=>'tableLaporanDP',
        'dataProvider'=>$dataDP,
        'enableSorting'=>$sortDP,
        'template'=>$templateDP,
            'htmlOptions'=>array(
                'style'=>'font-size',

            ),
            'itemsCssClass'=>'table table-striped table-condensed',
            'columns'=>array(
                   array(
                        'header' => 'No.',
                        'value' => '(($this->grid->dataProvider->pagination) ? $this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize : 0) + $row+1',
                        'htmlOptions'=>array('style'=>'font-size:10px;'),
                        'footerHtmlOptions'=>array('colspan'=>6,'style'=>'text-align:right;font-style:italic;'),
                        'footer'=>'JUMLAH',
                    ),
                   array(
                        'header' => 'No. Registrasi',
                        'name' => 'no_rekam_medik',
                        'htmlOptions'=>array('style'=>'font-size:10px;'),
                    ),
                   array(
                        'header' => 'No. Kwitansi',
                        'name' => 'nobuktibayar',
                        'htmlOptions'=>array('style'=>'font-size:10px;'),
                    ),
                   array(
                        'header' => 'Uraian',
                        'name' => 'nama_pasien',
                        'htmlOptions'=>array('style'=>'font-size:10px;'),
                    ),
                   array(
                        'header' => 'Ruangan',
                        'name' => 'ruangan_nama',
                        'htmlOptions'=>array('style'=>'font-size:10px;'),
                    ),
                   array( 
                        'header' => 'Kelas Pelayanan',
                        'name' => 'kelaspelayanan_nama',
                        'htmlOptions' => array('style'=>'font-size:10px;'), 
                    ),
                   array( 
                        'header' => 'Jumlah',
                        'name' => 'pemakaianuangmuka',
                        'value' => 'number_format($data->pemakaianuangmuka,0,"",".")',
                        'htmlOptions' => array('style'=>'font-size:10px;'), 
                        'footer'=>  number_format($model->getTotalDP(),0,",",".")
                    ),
                   array( 
                        'header' => 'Keterangan',
                        'name' => 'keterangan_closing',
                        'value'=> '$data->keterangan_closing',
                        'htmlOptions' => array('style'=>'font-size:10px;'),
                        'footer'=>'&nbsp;',
                    ),

        ),
            'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
    )); ?>
</div>
<div id="tableLaporanJumlah" class="grid-view" style="font-size">
<table class="table table-bordered table-striped table-condensed">
    <thead>
        <tr>
            <th style="text-align:center;font-style:italic; width:80.4%">JUMLAH</th>
            <th style="text-align:left;"><?php echo number_format(($model->getTotalSetoran()-$model->getTotalDP()),0,",","."); ?></th>
        </tr>
    </thead>
</table>
</div>


