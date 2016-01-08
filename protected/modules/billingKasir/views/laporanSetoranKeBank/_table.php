<h6>Tabel <b>Setoran ke Bank</b></h6>
<?php 
    $kolom = array(
                    array(
                        'header' => 'No.',
                        'value' => '(($this->grid->dataProvider->pagination) ? $this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize : 0) + $row+1',
                        'htmlOptions'=>array('style'=>'text-align:right;'),
                        'footerHtmlOptions'=>array('colspan'=>2,'style'=>'text-align:right;font-style:italic;'),
                        'footer'=>'JUMLAH',
                    ),
                    array(
                      'header'=>'<center>Jenis Tarif</center>',
                      'type'=>'raw',
                      'value'=>'$data->komponentarif_nama',
                    ),
                    array(
                      'header'=>'Rawat Jalan',
                      'name'=>'totalpenerimaan',
                      'type'=>'raw',
                      'footerHtmlOptions'=>array('style'=>'text-align:right;'),
                      'footer'=>number_format($model->getTotalRJ(),0,"","."),
                      'value'=>'number_format($data->getRawatJalan($data->komponentarif_id),0,"",".");',
                      'htmlOptions'=>array(
                          'style'=>'text-align:right',
                          'class'=>'integer',
                      ),
                    ),
                );
    $header = array();
    $beda_kelas = $model->totalBedaKelas();
    $jmlkelas = 0;
    foreach ($beda_kelas as $i=>$kelas){
            if ($kelas->kelaspelayanan_nama != "ALL"){
                $kolom[] = array(
                      'header'=>'<center>'.$kelas->kelaspelayanan_nama.'</center>',
                      'value'=>'number_format($data->getRawatInap($data->komponentarif_id, '.$kelas->kelaspelayanan_id.'),0,"",".");',
                      'footerHtmlOptions'=>array('style'=>'text-align:right;'),
                      'footer'=>number_format($model->getTotalRI($kelas->kelaspelayanan_id),0,"","."),
                      'htmlOptions'=>array(
                          'style'=>'text-align:right',
                          'class'=>'integer',
                      ),
                    );
            $jmlkelas++;
            }
    }
    if ($jmlkelas > 0){
        $header[] = array(
                        'name'=>'<center>Rawat Inap</center>',
                        'headerHtmlOptions'=>array('style'=>'background-color:#4bb1cf;'),
                        'start'=>3, 
                        'end'=>2+$jmlkelas, 
                    );
    }
    $kolom[] = array(
                      'header'=>'Jumlah',
                      'type'=>'raw',
                      'value'=>'number_format($data->getTotalKomponen($data->komponentarif_id),0,"",".");',
                      'footerHtmlOptions'=>array('style'=>'text-align:right;'),
                      'footer'=>number_format($model->getTotal(),0,"","."),
                      'htmlOptions'=>array(
                          'style'=>'text-align:right',
                          'class'=>'integer',
                      ),
                    );
    
    $rim = '';
    $table = 'ext.bootstrap.widgets.HeaderGroupGridView';
    $data = $model->searchSetoranKeBank();
    $template = "{summary}\n{items}\n{pager}";
    $sort = true;
    if (isset($caraPrint)){
      $sort = false;
      $data = $model->searchPrintSetoranKeBank(); 
      $rim = '';
      $template = "{items}";
      if ($caraPrint == "EXCEL")
          $table = 'ext.bootstrap.widgets.BootExcelGridView';
    }
?>
    <div style="<?php echo $rim; ?>">
       <?php
        if(isset($caraPrint)){
       
        }else{
       ?>
       <?php } ?>
    <?php 
        $this->widget($table,array(
            'id'=>'laporansetorankebank-grid',
            'dataProvider'=>$data,
            'enableSorting'=>$sort,
            'template'=>$template,
            'itemsCssClass'=>'table table-striped table-condensed',
            'mergeHeaders'=>$header,
            'columns'=>$kolom,
            'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
        )); 
        ?>
    </div>
    

<br/>