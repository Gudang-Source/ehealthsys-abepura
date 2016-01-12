<?php 
    $rim = '';
    $table = 'ext.bootstrap.widgets.HeaderGroupGridView';
    $data = $model->searchKasHarian();
    $template = "{summary}\n{items}\n{pager}";
    $sort = true;
    if (isset($caraPrint)){
      $sort = false;
      $data = $model->searchPrintKasHarian(); 
      $rim = '';
      $template = "{items}";
      if ($caraPrint == "EXCEL")
          $table = 'ext.bootstrap.widgets.BootExcelGridView';
    }
?>
<?php if($_REQUEST['filter_tab'] == 'rekap')
                {

?>
<div id="rekapKas">
    <div style="<?php echo $rim; ?>">
       <?php
        if(isset($caraPrint)){
       
        }else{
       ?>
        <legend class="rim"> Table Rekap Kas Harian </legend>
       <?php } ?>
    <?php 
        $this->widget($table,array(
            'id'=>'laporankasharianlab-grid',
            'dataProvider'=>$data,
            'enableSorting'=>$sort,
            'template'=>$template,
                'itemsCssClass'=>'table table-striped table-bordered table-condensed',
             'mergeHeaders'=>array(
                    array(
                        'name'=>'<center>PENERIMAAN KAS</center>',
                        'headerHtmlOptions'=>array('style'=>'background-color:#4bb1cf;'),
                        'start'=>2, //indeks kolom 3
                        'end'=>4, //indeks kolom 4
                    ),
                ),
                'columns'=>array(
                         array(
                        'header' => 'No.',
                        'value' => '$row+1',
                        'footerHtmlOptions'=>array('colspan'=>2,'style'=>'text-align:right;font-style:italic;'),
                        'footer'=>'JUMLAH',
                    ),
                    array(
                      'header'=>'<center>URAIAN</center>',
                      'type'=>'raw',
                      'value'=>'(empty($data->keterangan_closing) ? "-" : "$data->keterangan_closing" )',
                    ),
                    array(
                      'header'=>'<center>TUNAI (Rp.)</center>',
                      'name'=>'jumlahuang',
                      'type'=>'raw',
//                      'htmlOptions'=>array('style'=>'text-align:right;'),
                      'footerHtmlOptions'=>array('style'=>'text-align:right;'),
                      'footer'=>number_format($model->getTotal('jumlahuang'),0,"",".") ,
                      'value'=>'(empty($data->jumlahuang) ? "0" : number_format($data->jumlahuang,0,"","."))',
                      'htmlOptions'=>array(
                          'style'=>'text-align:right',
                          'class'=>'integer',
                      ),
                    ),
                    array(
                      'header'=>'<center>PIUTANG (Rp.)</center>',
                      'name'=>'piutang',
                      'type'=>'raw',
                      'value'=>'(empty($data->piutang) ? "0" : number_format($data->piutang,0,"","."))',
                      'footerHtmlOptions'=>array('style'=>'text-align:right;'),
                      'footer'=>number_format($model->getTotal('piutang'),0,"","."),
//                      'value'=>'(empty($data->terimauangmuka) ? "0" : number_format($data->terimauangmuka))',
                      'htmlOptions'=>array(
                          'style'=>'text-align:right',
                          'class'=>'integer',
                      ),
                    ),
                    array(
                      'header'=>'<center>TOTAL (Rp.)</center>',
                      'name'=>'total',
                      'type'=>'raw',
                      'value'=>'(empty($data->total) ? "0" : number_format($data->total,0,"",".") )',
                      'footerHtmlOptions'=>array('style'=>'text-align:right;'),
                      'footer'=>number_format($model->getTotal('total'),0,"","."),
                      'htmlOptions'=>array(
                          'style'=>'text-align:right',
                          'class'=>'integer',
                      ),
                    ),
                    array(
                      'header'=>'<center>BERSYARAT <br/> PIUTANG BARU (Rp.)</center>',
                      'name'=>'totalpengeluaran',
                      'type'=>'raw',
                      'value'=>'(empty($data->totalpengeluaran) ? "0" : number_format($data->totalpengeluaran))',
                      'footerHtmlOptions'=>array('style'=>'text-align:right;'),
                      'footer'=>number_format($model->getTotal('totalpengeluaran'),0,"","."),
                      'htmlOptions'=>array(
                          'style'=>'text-align:right',
                          'class'=>'integer',
                      ),
                    ),
                ),
                'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
        )); 
        ?>
    </div>
    
</div>

<?php } else { ?>
<div id="detailKas">
    <div style="<?php echo $rim; ?>">
        <?php
            if(isset($caraPrint)){
                $dataDetail = $model->searchPrintDetailKas();
            }else{
                $dataDetail = $model->searchDetailKas();
        ?>
        <legend class="rim"> Table Detail Kas Harian</legend>
        <?php } ?>
    <?php 
        $this->widget($table,array(
            'id'=>'detaillaporankasharianlab-grid',
            'dataProvider'=>$dataDetail,
            'enableSorting'=>$sort,
            'template'=>$template,
            'itemsCssClass'=>'table table-striped table-bordered table-condensed',
                'columns'=>array(
                    array(
                        'header' => 'No.',
                        'value' => '$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1',
                        'footerHtmlOptions'=>array('colspan'=>'4','style'=>'text-align:right;font-style:italic;'),
                        'footer'=>'Total:',
                    ),
                    array(
                      'header'=>'No. Reg Lab ',
                      'type'=>'raw',
                      'value'=>'$data->no_pendaftaran',
                    ),
                    array(
                      'header'=>'Nama',
                      'type'=>'raw',
                      'value'=>'$data->nama_pasien',
                    ),
                    array(
                      'header'=>'Kedatangan',
                      'type'=>'raw',
                      'value'=>'(empty($data->keterangan_closing) ? "-" : $data->keterangan_closing)',
                    ),
                   array(
                      'header'=>'<center>Piutang (Rp.)</center>',
                      'name'=>'piutang',
                      'type'=>'raw',
                      'value'=>'(empty($data->piutang) ? "0" : number_format($data->piutang,0,"","."))',
                      'footerHtmlOptions'=>array('style'=>'text-align:right;'),
                      'footer'=>number_format($model->getTotal('piutang'),0,"","."),
//                      'value'=>'(empty($data->terimauangmuka) ? "0" : number_format($data->terimauangmuka))',
                      'htmlOptions'=>array(
                          'style'=>'text-align:right',
                      ),
                    ),
                    array(
                      'header'=>'<center>Deposit (Rp.)</center>',
                      'name'=>'piutang',
                      'type'=>'raw',
                      'value'=>'(empty($data->piutang) ? "0" : number_format($data->piutang,0,"","."))',
                      'footerHtmlOptions'=>array('style'=>'text-align:right;'),
                      'footer'=>number_format($model->getTotal('piutang'),0,"","."),
//                      'value'=>'(empty($data->terimauangmuka) ? "0" : number_format($data->terimauangmuka))',
                      'htmlOptions'=>array(
                          'style'=>'text-align:right',
                      ),
                    ),
                    array(
                      'header'=>'<center>Pembayaran (Rp.)</center>',
                      'name'=>'jumlahuang',
                      'type'=>'raw',
                      'value'=>'(empty($data->jumlahuang) ? "0" : number_format($data->jumlahuang,0,"","."))',
                      'footerHtmlOptions'=>array('style'=>'text-align:right;'),
                      'footer'=>number_format($model->getTotal('jumlahuang'),0,"","."),
//                      'value'=>'(empty($data->terimauangmuka) ? "0" : number_format($data->terimauangmuka))',
                      'htmlOptions'=>array(
                          'style'=>'text-align:right',
                      ),
                    ),
                   
                ),
                'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
            )); 
        ?>
    </div>
    
</div>
<?php } ?>
<br/>