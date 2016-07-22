<?php 
    $table = 'ext.bootstrap.widgets.MergeHeaderGroupGridView';
    $sort = true;
    $row = '$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1';
    if (isset($caraPrint)){
        $row = '$row+1';
        $data = $model->searchPrint();
        $template = "{items}";
        $sort = false;
        if ($caraPrint == "EXCEL")
            $table = 'ext.bootstrap.widgets.BootExcelGridView';
    } else{
        $data = $model->searchTable();
         $template = "{summary}\n{items}\n{pager}";
    }
?>
<?php 
        $kelas = KelaspelayananM::model()->findAll('kelaspelayanan_aktif = TRUE ORDER BY kelaspelayanan_nama');
                
        $columns =array();
        $columns = array(
                array(
                    'header'=>'No.',
                    'value' => $row,
                    'headerHtmlOptions'=>array('style'=>'text-align: center;vertical-align:middle;'),
                    'htmlOptions'=>array('style'=>'text-align: center;vertical-align:middle;'),                    
                ),
                 array(
                        'header' => 'Jenis Diet',
                        'value' => '$data->jenisdiet_nama',
                        'headerHtmlOptions'=>array('style'=>'text-align: left;vertical-align:middle;'),                    
                        'footerHtmlOptions'=>array('colspan'=>2,'style'=>'text-align:right;color:black;font-weight:bold'),
                        'footer'=>'JUMLAH',                        
                    ),
            );
        
        foreach($kelas as $kelas):
            
            $columns[] = array(
                'header'=>$kelas->kelaspelayanan_nama,
                'value'=>'number_format($data->getSumJmlPorsi(array("jenisdiet"),'.$kelas->kelaspelayanan_id.'),0,"",".")',
                'htmlOptions'=>array('style'=>'text-align: right;vertical-align:middle;'),
                'headerHtmlOptions'=>array('style'=>'text-align: right;vertical-align:middle;'),
                'footerHtmlOptions'=>array('style'=>'text-align:right;color:black;font-weight:bold'),
                'footer'=>number_format($model->getSumTotalPorsi(array("jenisdiet"),$kelas->kelaspelayanan_id),0,"","."),
            );
        endforeach;
        $columns[] =  array(
                        'header' => 'Jumlah',
                        'value'=>'number_format($data->getSumJmlPorsi(array("jenisdiet"),"JML"))',
                        'headerHtmlOptions'=>array('style'=>'text-align: right;vertical-align:middle;'),
                        'htmlOptions'=>array('style'=>'text-align: right;vertical-align:middle;'),                    
                        'footerHtmlOptions'=>array('style'=>'text-align:right;color:black;font-weight:bold'),
                        'footer'=>number_format($model->getSumTotalPorsi(array("kelas"),"TOTAL")),
                    );
        $columns[] = array(
                        'header' => '%',
                        'value' => '"-"',
                        'headerHtmlOptions'=>array('style'=>'text-align: right;vertical-align:middle;'),
                        'htmlOptions'=>array('style'=>'text-align: right;vertical-align:middle;'),                    
                        'footerHtmlOptions'=>array('style'=>'text-align:right;color:black;font-weight:bold'),
                        'footer'=>'-',
                    );
       
        $this->widget($table,array(
            'id'=>'tableLaporan',
            'dataProvider'=>$data,
            'template'=>$template,
            'enableSorting'=>$sort,
            'itemsCssClass'=>'table table-striped table-condensed',
            'columns'=> $columns,
         
            'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
    )); 
?>